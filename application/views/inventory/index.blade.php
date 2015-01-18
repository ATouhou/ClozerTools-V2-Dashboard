@layout('layouts/main')
@section('content')
<style>
.bignum2{
	font-size:17px!important;
	padding:10px!important;
	padding-top:3px!important;
	padding-bottom:3px!important;
	font-weight:bold;
}
.cancel-li {
background: #b5bdc8; /* Old browsers */
background: -moz-linear-gradient(top,  #b5bdc8 0%, #828c95 36%, #28343b 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#b5bdc8), color-stop(36%,#828c95), color-stop(100%,#28343b)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #b5bdc8 0%,#828c95 36%,#28343b 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #b5bdc8 0%,#828c95 36%,#28343b 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #b5bdc8 0%,#828c95 36%,#28343b 100%); /* IE10+ */
background: linear-gradient(to bottom,  #b5bdc8 0%,#828c95 36%,#28343b 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#b5bdc8', endColorstr='#28343b',GradientType=0 ); /* IE6-9 */
color:#fff!important;
}
</style>
<?php
function stringFilter($string){
	$string= stripslashes($string);
	$string = str_replace(' ' ,'-',$string); 
	$string =str_replace('/','',$string);
	$string = str_replace('.','',$string);
	return  $string;
}
;?>

<div class="modal hide fade" id="upload_xlsinventory">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h3>Upload XLS Inventory File</h3>
	</div>
	<div class="modal-body">
		<form method="POST" action="{{ URL::to('inventory/uploadbatch') }}" id="upload_inventory" enctype="multipart/form-data">
		
		<select name="upload_city" id="upload_city">
			@foreach($cities as $val)
			<option value='{{$val->cityname}}'>{{$val->cityname}}</option>
			@endforeach
		</select>

		<label for="photo">XLS File</label>
		<input type="file" placeholder="Choose a XLS File to upload" name="xls_upload_file" id="xls_upload_file" /><br>
			
	    </form>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal">Cancel</a>
    	<button type="button" onclick="$('#upload_inventory').submit();" class="btn btn-primary uploadFileButton">Upload File</a>
	</div>
</div>


<div class="modal hide fade" id="moveCity">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h3>Move Batch of Inventory to New City</h3>
	</div>
	<div class="modal-body">
		<form method="POST" action="{{URL::to('inventory/changeCity')}}" id="changeCity" enctype="multipart/form-data">
			
			<label>Type</label>
			<select name="machineType">
				<option value="all">All Machines</option>
				<option value="majestic">Majestic</option>
				<option value="defender">Defenders</option>
				<option value="attachment">Attachments</option>
			</select><br/>
			<label><strong>FROM :</strong> </label>
			<select name="fromcity" >
				@foreach($cities as $val)
					<option value="{{$val->cityname}}">{{$val->cityname}}</option>
				@endforeach
			</select><br/>

			<label><strong>TO :</strong> </label>
			<select name="tocity">
				@foreach($cities as $val)
					<option value="{{$val->cityname}}">{{$val->cityname}}</option>
				@endforeach
			</select><br/>
	    </form>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal">Cancel</a>
    	<button type="button" onclick="$('#changeCity').submit();" class="btn btn-primary executeMove">MOVE INVENTORY</a>
	</div>
</div>

<div class="modal hide fade" id="moveDealer">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h3>Move Batch of Inventory from One Dealer to Another</h3>
	</div>
	<div class="modal-body">
		<form method="POST" action="{{URL::to('inventory/movedealer')}}" id="moveFromDealer" enctype="multipart/form-data">

			<label><strong>FROM :</strong> </label>
			<select name="fromRep" id="fromRep">
				@foreach($reps as $val)
				<option value="{{$val->id}}">{{$val->fullName()}}</option>
				@endforeach
			</select><br/>

			<label><strong>TO : </strong> </label>
			<select name="toRep">
				@foreach($reps as $val)
				<option value="{{$val->id}}">{{$val->fullName()}}</option>
				@endforeach
			</select><br/>
			<h4>Machines to Move</h4>

			@foreach($reps as $r)
				@foreach($r->machines() as $m)
					@if($m->status=="Checked Out")
					<div class="repMachineBox repMachine-{{$r->id}}">
					<label>{{$m->sku}} | {{strtoupper($m->item_name)}}
						<input type="checkbox" class="repMachineCheckbox" value="{{$m->id}}" name="repMachines[]"   />
					</label>
					</div>
					@endif
				@endforeach
			@endforeach
	    </form>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal">Cancel</a>
    	<button type="button" onclick="$('#moveFromDealer').submit();" class="btn btn-primary">MOVE INVENTORY</a>
	</div>
</div>



<div id="main"  class="container-fluid" style="background:#fff;padding:45px;padding-top:30px;padding-bottom:500px;">
	<div class="topBar subtle-shadow hide-these-when-searching" style="margin-left:-55px;">
		<div class='row-fluid' id="pageheader" data-date="{{date('Y-m-d')}}" >
        	
        		<div class="span3" >
        			<form id="filterApps" method="get" action="">
        			<label> Choose City: : </label>
        			<select name="app_city" id="app_city" style="width:50%;">
        				<option value="all cities">All</option>
        			@if(!empty($cities))
        			@foreach($cities as $val)
        			<option value="{{$val->cityname}}" 
        				@if((isset($_GET['app_city']))&&($_GET['app_city']==$val->cityname)) 
        				selected = 'selected' 
        				@endif>{{$val->cityname}}</option>
        			@endforeach
        			@endif
        			</select>
        			<input type="hidden" name="type" id="type" value="{{$type}}"/>
        			<input type="hidden" name="table" id="tableyes" value="{{$table}}"/>        			
        			</form>

         		</div>
         		<div class="span2 animated fadeInUp " style='margin-top:24px;'>
         			<span class="cityName huge shadow "></span>
         		</div>
         		<div class="span5" style="padding-top:22px;margin-left:-62px;">
         		ALL MAJ : <span class="bignum BOOK counts totalMajestics" ></span>&nbsp;&nbsp;
         		ALL DEF : <span class="bignum BOOK counts totalDefenders" ></span>&nbsp;&nbsp;
         			IN STOCK : <span class="bignum SOLD counts instockCount" ></span>&nbsp;&nbsp;
                    IN TRANSIT : <span class="bignum PUTON counts transitCount" ></span>&nbsp;&nbsp;
                    CHECK OUT : <span class="bignum BOOK counts checkOutCount" ></span>
         		</div>
         
            	<div style="margin-top:10px;float:right;margin-right:30px;">
            		<a href='{{URL::to("inventory?oldstyle=yes")}}'>
            			<div class='btn btn-default btn-large tooltwo' title="Click here to View Inventory Table List" >
            			    		<i class='cus-grid'></i>
            			</div>
            		</a>
            		<div class='btn btn-default btn-large addInventory tooltwo' title="Click here to easily add machines to Inventory" >
            		    	<i class='cus-add'></i>&nbsp;&nbsp;ADD INVENTORY
            		</div>
           		</div>
        	</div>

        	<div class='topDateBar subtle-shadow hide-these-when-searching' style="height:30px;!important" >
        		<div class="span4" style="margin-top:8px;">
        			<b>Maj :</b>  <span class="bignum2 BOOK maj-count"></span>  
        			&nbsp;&nbsp;<b>Def :</b>  <span class="bignum2 BOOK  def-count"></span>
        			&nbsp;&nbsp;<b>Att :</b>  <span class="bignum2 BOOK att-count"></span>
        		</div>
        		<div class="span4" >
        			Search Filter :
        			<input type="text"  name="inventory_search" id="inventory_search" value="" placeholder="Search by SKU#"/>
        		</div>
        		
        			@if(Session::has('upload_msg'))
        				{{Session::get('upload_msg')}}
        			@endif
        	
         		<div class='span5 pull-right' style="margin-right:25px;">
         			
         			<button class="btn btn-default togglePickup ">
						<i class="cus-eye"></i>&nbsp;&nbsp;View Machines to Be Picked Up
				</button>&nbsp;&nbsp;
				<button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
					<i class="cus-cog"></i>&nbsp;&nbsp;Actions <span class="caret"></span>
				</button>
					<ul class="dropdown-menu">
						
						<li>
							<a href="{{URL::to('inventory/movetostock')}}" class="movetoStock filterInventory tooltwo" title="Receive all IN TRANSIT to STOCK" data-slot="all" data-start="all" data-end="all"><i class="cus-arrow-right"></i>&nbsp;Move ALL to Stock</a>
						</li>	
						<li>
							<a href="" class="movetoCity tooltwo" title="Move all inventory from one city to another" data-slot="all" data-start="all" data-end="all"><i class="cus-delivery"></i>&nbsp;Move to City</a>
						</li>	
						<li>
							<a href="" class="moveFromDealer tooltwo" title="Move Stock from One Dealer to Another"><i class="cus-arrow-right"></i>&nbsp;Move From One Dealer to Another</a>
						</li>
						
					</ul>
         		</div>
            </div>
 	</div>


<div class="subtle-shadow animated slideInRight hide-these-when-searching" id="addInventoryPanel" >
<div class="row-fluid">
                            <article class="span8" id="addnewinventory" style="margin-top:-20px;" >
                                <h3>Add Inventory <button class='btn btn-default uploadBatch'>BATCH UPLOAD XLS</button></h3>
                                    <form class="form-horizontal " id="inventoryadd" method="post" action="{{URL::to('inventory/add')}}">
                                        <fieldset>
                                             <h4>BATCH INFORMATION</h4>
                                            <div class="control-group subtle-shadow" style="margin-bottom:10px;">
                                                
                                            <label class="control-label" style="margin-top:10px;">STATUS</label>
                                            <div class="controls" style="margin-top:20px;">
                                                <select id="inv-status" name="inv-status" class="span11">
                                                     <option value='In Transit'>In Transit</option>
                                                     <option value='In Stock'>In Stock</option>
                                                </select>
                                            </div>
                                            <label class="control-label" style="margin-top:10px;">TYPE OF PRODUCT</label>
                                            <div class="controls" style="margin-top:20px;">
                                                <select id="unittype" name="unittype" class="span11">
                                                     <option value='majestic'>Majestic</option>
                                                     <option value='defender'>Defender</option>
                                                     <option value='attachment'>Attachment</option>
                                                </select>
                                            </div>
                                            <label class="control-label"  style="margin-top:10px;">ASSIGN A CITY</label>
                                            <div class="controls" style="margin-top:20px;">
                                                <select id="cityname2" name="cityname" class="span11">
                                                    @foreach($cities as $val)
                                                    	<option value="{{$val->cityname}}">
                                                    		{{$val->cityname}}
                                                    	</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            </div>
                                        </fieldset>
                                             
                                        <fieldset>
                                        <h4 >SKU #'s</h4>
                                        <span class='small'>TAB, Enter, or Comma, will seperate the entries.</span>
                                            <div class="control-group subtle-shadow">
                                                <input id="skus" value="" name="tags" />
                                           </div>
                                        </fieldset>  
                                        </form>
                                        <div style="margin-top:20px;float:left;">
                                    <button title="" class="btn btn-primary addNewInventory " >ADD NEW INVENTORY</button> <button class="btn btn-danger closePanel">CLOSE</button></siv>
                            </article>
      </div>
</div>

<div id="SIGNOUT" class="data-content hide-these-when-searching" >
	<div class="cart" >
		<h3>Checked Out Machines</h3>
		<button class="btn btn-default btn-small moveFromDealer" style="margin-bottom:10px;"><i class="cus-arrow-right"></i>&nbsp;&nbsp;Move Machines From One Dealer to Another</button>
		@foreach($reps as $r)
		
		<div class="dealerBox subtle-shadow animated fadeInUp ">
		<h5 style="margin-top:-4px;color:#000" class="repnameHeading"><img src='{{URL::to_asset("images/")}}level{{$r->level}}.png' class='rep-level-image'>&nbsp;{{$r->firstname}} {{$r->lastname}} 
			<button class='btn btn-primary btn-mini right-button addMachine' data-id='{{$r->id}}' data-repname='{{$r->firstname}}' title='Click to pick machines to add' style='color:yellow;margin-top:2px;margin-right:1px;'>ADD MACHINE</button></h5>
		<table class="table table-condensed">
			<thead style="font-size:10px;">
				<tr>	<th style="width:4%;"></th>
					<th style="width:9%;">Type</th>
					<th style="width:12%;">Location</th>
					<th style="width:10%;">SKU</th>
					<th style="width:14%;" >CheckOut</th>
				</tr>
			</thead>
			<tbody id="rep-table-{{$r->id}}" class="smallTable">
				@foreach($r->machines() as $mac)
					 <?php if($mac->status=="Cancelled"){$color = "cancel-li cancel-image";$title="This item is Cancelled from SALE #".$mac->sale_id. " | Still to be Picked Up";} else {$color="";$title="";};?>
					<tr class="tooltwo dealer-{{$mac->item_name}} {{stringFilter($mac->status)}}  {{$color}} dealerRow" data-sale="{{$mac->sale_id}}" data-sku="{{$mac->sku}}" title="{{$title}}">
						<td>
						@if($mac->status=="Checked Out")
						<button class='btn btn-mini btn-danger returnMachine' data-id='{{$mac->id}}'>RETURN</button>
						@else
						<img src="{{URL::to_asset('images/')}}cancel-pickup.png"  >
						@endif
						</td>
						<td>
						 &nbsp;<span class='small'>{{ucfirst($mac->item_name)}}</span> </td>
						<td><span class='small'>{{$mac->location}}</span></td>
						<td>{{$mac->sku}} </td>
						<td>{{$mac->date_received}}</td>
					</tr>
					
				@endforeach

			</tbody>
		</table>
		</div>
		@endforeach
		<div style='height:2200px;'></div>
	</div>


<div class="instockProducts hide-these-when-searching ">
	<div class="row-fluid instock-list" style="margin-top:4px;">
		<div class="invHeading">
			<div class="span2">
				<span class='header'>IN STOCK</span>
			</div>
			<div style="margin-left:12px;float:left;width:20%;">
				MAJESTIC : <span class="bignum SOLD smallcounts majestic-instockCount" ></span>
			</div>
			<div style="margin-left:40px;float:left;width:20%;">
				DEFENDER : <span class="bignum SOLD smallcounts defender-instockCount" ></span>
			</div>
			<div style="margin-left:40px;float:left;width:20%;">
				ATTACHMENTS : <span class="bignum SOLD smallcounts attachment-instockCount" ></span>
			</div>
        </div>
        <div class="clearfix"></div>

		<div class="productBOX">
			<h5 class='machineHead' >Majestic</h5>
			<ul class="products productbox-majestic In-Stock">
			@foreach($maj as $m)
			@if(($m->status=="In Stock")||($m->status=="Cancelled"))
			<?php			
			if($m->status=="In Stock"){$stock="instock";$im = "pureop-small-majestic.png";$itemtitle="Click to check this item out to a rep";} else  {
				$pickup[] = $m;$itemtitle="Cancelled Item, waiting to be picked up";};
			if($m->returned>0){$itemtitle.=" <br/><br/>This item has been demoed ".$m->returned." times";}
			?>
			@if($m->status=="In Stock")
			<?php if($m->date_received<=date('Y-m-d',strtotime('-10 days'))){$time="danger-item";$itemtitle.=" | This item is older than 10 days";} else {$time="";};?>
			<li class="animated fadeInUp {{$stock}}-li prod-majestic locationFilter {{stringFilter($m->location)}} tooltwo" title="{{$itemtitle}}" data-repid="" data-repname="" data-id="{{$m->id}}" data-sku="{{$m->sku}}" data-sale="{{$m->sale_id}}" data-type="{{ucfirst($m->item_name)}}" >
				<div class='skuBOX subtle-shadow {{$time}}'  >
					<div class="{{$stock}}-image" data-sale="{{$m->sale_id}}">
						<span class='theSKU {{$stock}}'>{{$m->sku}}</span><br/>
						<span class='small'>Rcd : </span><span class='dateText'>{{date('M-d',strtotime($m->created_at))}}</span><br/>
						<span class='small'>{{substr($m->location,0,13)}}.</span>
					</div>
					<img class="product-image smallProductImage" data-sku="{{$m->sku}}" src="{{URL::to_asset('images/')}}{{$im}}" >
					<button class="btn pull-right btn-danger btn-mini removeInventoryItem tooltwo skuDelButton" title='Click to delete item' data-id='{{$m->id}}' >X</button>
				</div>
			</li>
			@endif
			@endif
			@endforeach
			</ul>
		</div>

		<div class="productBOX pull">
			<h5 class='machineHead' >Defenders</h5>
			<ul class="products productbox-defender In-Stock">
			@foreach($def as $d)
			@if(($d->status=="In Stock")||($d->status=="Cancelled"))
			<?php 
			if($d->status=="In Stock"){$stock="instock";$im = "pureop-small-defender.png";$itemtitle="Click to check this item out to a rep";} else  {
				$pickup[] = $d;$itemtitle="Cancelled Item, waiting to be picked up";
			};
			if($d->returned>0){$itemtitle.=" <br/><br/>This item has been demoed ".$m->returned." times";}

			?>
			@if($d->status=="In Stock")
			<?php if($d->date_received<=date('Y-m-d',strtotime('-10 days'))){$time="danger-item";$itemtitle.=" | This item is older than 10 days";} else {$time="";};?>
			<li class="animated fadeInUp {{$stock}}-li prod-defender locationFilter {{stringFilter($d->location)}} tooltwo" title="{{$itemtitle}}" data-repid="" data-repname="" data-id="{{$d->id}}" data-sku="{{$d->sku}}" data-sale="{{$d->sale_id}}" data-type="{{$d->item_name}}"  >
				<div class='skuBOX subtle-shadow {{$time}}' >
					<div class=" {{$stock}}-image " data-sale="{{$d->sale_id}}">
						<span class='theSKU'>{{$d->sku}}</span><br/>
						<span class='small'>Rcd : </span><span class='dateText'>{{date('M-d',strtotime($d->created_at))}}</span><br/>
						<span class='small'>{{substr($d->location,0,13)}}.</span><br/>
					</div>
					<img class="product-image smallProductImage"  data-sku="{{$d->sku}}" src="{{URL::to_asset('images/')}}{{$im}}" >
					<button class="btn pull-right btn-danger btn-mini removeInventoryItem tooltwo skuDelButton" title='Click to delete item' data-id='{{$d->id}}'>X</button>
				</div>
			</li>
			@endif
			@endif
			@endforeach
			</ul>
		</div>

		<div class="productBOX pull">
			<h5 class='machineHead' >Attachments</h5>
			<ul class="products productbox-attachment In-Stock">
			@foreach($att as $a)
			@if(($a->status=="In Stock")||($a->status=="Cancelled"))
			<?php 
			if($a->status=="In Stock"){$stock="instock";$im = "pureop-att.png";$itemtitle="Click to check this item out to a rep";} else  {
				$pickup[] = $a;$itemtitle="Cancelled Item, waiting to be picked up";}
			if($a->returned>0){$itemtitle.=" <br/><br/>This item has been demoed ".$m->returned." times";}
			?>
			@if($a->status=="In Stock")
			<?php if($a->date_received<=date('Y-m-d',strtotime('-10 days'))){$time="danger-item";$itemtitle.=" | This item is older than 10 days";} else {$time="";};?>
			<li class="animated fadeInUp {{$stock}}-li prod-attachment locationFilter {{stringFilter($a->location)}} tooltwo" title="{{$itemtitle}}" data-repid="" data-repname=""  data-id="{{$a->id}}" data-sku="{{$a->sku}}" data-sale="{{$a->sale_id}}" data-type="{{$a->item_name}}">
				<div class='skuBOX subtle-shadow {{$time}}'  >
					<div class="{{$stock}}-image" data-sale="{{$a->sale_id}}" >
						<span class='theSKU'>{{$a->sku}}</span><br/>
						<span class='small'>Rcd : </span><span class='dateText'>{{date('M-d',strtotime($a->created_at))}}</span><br/>
						<span class='small'>{{substr($a->location,0,13)}}.</span>
					</div>
					<img class="product-image smallProductImage"  data-sku="{{$a->sku}}" src="{{URL::to_asset('images/')}}{{$im}}" >
					<button class="btn pull-right btn-danger btn-mini removeInventoryItem tooltwo skuDelButton" title='Click to delete item' data-id='{{$a->id}}'>X</button>
				</div>
			</li>
			@endif
			@endif
			@endforeach
		</ul>
		</div>
		
	</div>

	<div class="row-fluid pickup-list" style="display:none">
		<div class="invHeading">
			<div class="span2">
				<span class='header'>TO BE PICKED UP</span>
			</div>
			
            </div>
            <div class="clearfix"></div>

		<div class="productBOX">
			<h5 class='machineHead' >Majestic</h5>
			<ul class="products productbox-majestic For-Pickup">
			@if(!empty($pickup))
			@foreach($pickup as $p)
			@if($p->item_name=="majestic")
			<?php $stock="cancel";
			$im="cancel-pickup.png";$warningcolor="";$itemtitle="This ".ucfirst($p->item_name)." is cancelled from SALE # ".$p->sale_id. " | Still to be Picked Up";
			if($p->returned>0){$itemtitle.=" <br/><br/>This item has been demoed ".$p->returned." times";};?>
			<li class="animated fadeInUp {{$stock}}-li locationFilter {{stringFilter($p->location)}} tooltwo" title="{{$itemtitle}}" data-repid="" data-repname="" data-id="{{$p->id}}" data-sku="{{$p->sku}}" data-sale="{{$p->sale_id}}" data-type="{{ucfirst($p->item_name)}}" >
				<div class='skuBOX subtle-shadow' >
					<div class="{{$stock}}-image" data-sale="{{$p->sale_id}}">
						<span class='theSKU {{$stock}}'>{{$p->sku}}</span><br/>
						<span class='dateText' style='color:white;'>{{date('M-d',strtotime($p->created_at))}}</span><br/>
						<span class='small'>{{substr($p->location,0,7)}} | <span style='color:yellow;'>Sale # {{$p->sale_id}}</span></span><br/>
					</div>
					<img class="product-image smallProductImage" src="{{URL::to_asset('images/')}}{{$im}}" ><br/>
				</div>
			</li>
			@endif
			@endforeach
			@endif
			</ul>
		</div>

		<div class="productBOX pull">
			<h5 class='machineHead' >Defenders</h5>
			<ul class="products productbox-defender For-Pickup">
			@if(!empty($pickup))
			@foreach($pickup as $p)
			@if($p->item_name=="defender")
			<?php $stock="cancel";
			$im="cancel-pickup.png";$warningcolor="";$itemtitle="This ".ucfirst($p->item_name)." is cancelled from SALE # ".$p->sale_id. " | Still to be Picked Up";
			if($p->returned>0){$itemtitle.=" <br/><br/>This item has been demoed ".$p->returned." times";};?>
			<li class="animated fadeInUp {{$stock}}-li locationFilter {{stringFilter($p->location)}} tooltwo" title="{{$itemtitle}}" data-repid="" data-repname="" data-id="{{$p->id}}" data-sku="{{$p->sku}}" data-sale="{{$p->sale_id}}" data-type="{{ucfirst($p->item_name)}}" >
				<div class='skuBOX subtle-shadow' >
					<div class="{{$stock}}-image" data-sale="{{$p->sale_id}}">
						<span class='theSKU {{$stock}}'>{{$p->sku}}</span><br/>
						<span class='dateText' style='color:white;'>{{date('M-d',strtotime($p->created_at))}}</span><br/>
						<span class='small'>{{substr($p->location,0,7)}} | <span style='color:yellow;'>Sale # {{$p->sale_id}}</span></span><br/>
					</div>
					<img class="product-image smallProductImage" src="{{URL::to_asset('images/')}}{{$im}}" ><br/>
				</div>
			</li>
			@endif
			@endforeach
			@endif
			</ul>
		</div>

		<div class="productBOX pull">
			<h5 class='machineHead' >Attachments</h5>
			<ul class="products productbox-attachment For-Pickup">
			@if(!empty($pickup))
			@foreach($pickup as $p)
			@if($p->item_name=="attachment")
			<?php $stock="cancel";
			$im="cancel-pickup.png";$warningcolor="";$itemtitle="This ".ucfirst($p->item_name)." is cancelled from SALE # ".$p->sale_id. " | Still to be Picked Up";
			if($p->returned>0){$itemtitle.=" <br/><br/>This item has been demoed ".$p->returned." times";};?>
			<li class="animated fadeInUp {{$stock}}-li locationFilter {{stringFilter($p->location)}} tooltwo" title="{{$itemtitle}}" data-repid="" data-repname="" data-id="{{$p->id}}" data-sku="{{$p->sku}}" data-sale="{{$p->sale_id}}" data-type="{{ucfirst($p->item_name)}}" >
				<div class='skuBOX subtle-shadow' >
					<div class="{{$stock}}-image" data-sale="{{$p->sale_id}}">
						<span class='theSKU {{$stock}}'>{{$p->sku}}</span><br/>
						<span class='dateText' style='color:white;'>{{date('M-d',strtotime($p->created_at))}}</span><br/>
						<span class='small'>{{substr($p->location,0,7)}} | <span style='color:yellow;'>Sale # {{$p->sale_id}}</span></span><br/>
					</div>
					<img class="product-image smallProductImage" src="{{URL::to_asset('images/')}}{{$im}}" ><br/>
				</div>
			</li>
			@endif
			@endforeach
			@endif
			</ul>
		</div>

		
	</div>


	<div class="row-fluid intransit-list" >
		<div class="invHeading">
			<div class="span2">
				<span class='header'>IN TRANSIT</span>
			</div>
			<div style="margin-left:12px;float:left;width:20%;">
				MAJESTIC : <span class="bignum PUTON smallcounts majestic-intransitCount" ></span>
			</div>
			<div style="margin-left:40px;float:left;width:20%;">
				DEFENDER : <span class="bignum PUTON smallcounts defender-intransitCount" ></span>
			</div>
			<div style="margin-left:40px;float:left;width:20%;">
				ATTACHMENTS : <span class="bignum PUTON smallcounts attachment-intransitCount" ></span>
			</div>
            </div>
		<div class="productBOX">
			<ul class="products productbox-majestic In-Transit">
			@foreach($maj as $m)
			@if($m->status=="In Transit")
			<li class="animated fadeInUp intransit-li prod-majestic locationFilter {{stringFilter($m->location)}} tooltwo" title="Click on this item to Receive Machine into stock" data-repid="" data-repname="" data-id="{{$m->id}}" data-sku="{{$m->sku}}" data-type="{{ucfirst($m->item_name)}}" >
				<div class='skuBOX subtle-shadow' >
					<div class="intransit-image">
						<span class='theSKU'>{{$m->sku}}</span><br/>
						<span class='small'>Rcd : </span><span class='dateText'>{{date('M-d',strtotime($m->created_at))}}</span><br/>
						<span class='small'>{{substr($m->location,0,7)}}.</span><br/>
					</div>
					<img class="product-image smallProductImage" src="{{URL::to_asset('images/pureop-small-majestic.png')}}" ><br/>
					<button class="btn pull-right btn-danger btn-mini removeInventoryItem tooltwo skuDelButton" title='Click to delete item' data-id='{{$m->id}}'>X</button>
				</div>
			</li>
			@endif
			@endforeach
			</ul>
		</div>

		<div class="productBOX pull">
			<ul class="products productbox-defender In-Transit">
			@foreach($def as $d)
			@if($d->status=="In Transit")
			<li class="animated fadeInUp intransit-li prod-defender locationFilter {{stringFilter($d->location)}} tooltwo" title="Click this icon to Receive Machine into Stock" data-repid="" data-repname="" data-id="{{$d->id}}" data-sku="{{$d->sku}}" data-type="{{$d->item_name}}" >
				<div class='skuBOX subtle-shadow' >
					<div class="intransit-image">
						<span class='theSKU'>{{$d->sku}}</span><br/>
						<span class='small'>Rcd : </span><span class='dateText'>{{date('M-d',strtotime($d->created_at))}}</span><br/>
						<span class='small'>{{substr($d->location,0,7)}}.</span><br/>
					</div>
					<img class="product-image smallProductImage" src="{{URL::to_asset('images/pureop-small-defender.png')}}" ><br/>
					<button class="btn pull-right btn-danger btn-mini removeInventoryItem tooltwo skuDelButton" title='Click to delete item' data-id='{{$d->id}}'>X</button>
				</div>
			</li>
			@endif
			@endforeach
			</ul>
		</div>

		<div class="productBOX pull">
			<ul class="products productbox-attachment In-Transit">
			@foreach($att as $a)
			@if($a->status=="In Transit")
			<li class="animated fadeInUp intransit-li prod-attachment  locationFilter {{stringFilter($a->location)}} tooltwo" title="Click here to receive machine into stock" data-repid="" data-repname=""  data-id="{{$a->id}}" data-sku="{{$a->sku}}" data-type="{{$a->item_name}}">
				<div class='skuBOX subtle-shadow' >
					<div class="intransit-image">
						<span class='theSKU'>{{$a->sku}}</span><br/>
						<span class='small'>Rcd : </span><span class='dateText'>{{date('M-d',strtotime($a->created_at))}}</span><br/>
						<span class='small'>{{substr($a->location,0,7)}}.</span><br/>
					</div>
					<img class="product-image smallProductImage" src="{{URL::to_asset('images/pureop-att.png')}}" ><br/>
					<button class="btn pull-right btn-danger btn-mini removeInventoryItem tooltwo skuDelButton" title='Click to delete item' data-id='{{$a->id}}'>X</button>
				</div>
			</li>
			@endif
			@endforeach
		</ul>
		</div>
	</div>
</div>

</div>
</div>

<script src="{{URL::to('js/tagit.js')}}"></script>
<script>
$(document).ready(function(){
	//INITIATE PAGE
	$('body').css('background','white');
	updateCount();
	//END INIT

	$('.uploadBatch').click(function(){
		$('.infoHover').hide();
		$('.modal').hide();
		$('#addInventoryPanel').hide(200);	
		$('#upload_xlsinventory').modal({backdrop:'static'});	
	});

	$('.togglePickup').click(function(){
		if($(this).hasClass('btn-default')){
			$(this).removeClass('btn-default').addClass('btn-inverse');
			$('.instock-list').hide();
			$('.pickup-list').show();
		} else {
			$(this).removeClass('btn-inverse').addClass('btn-default');
			$('.instock-list').show();
			$('.pickup-list').hide();
		}
	});

	

	$('#skus').tagsInput({
   		'height':'200px',
   		'width':'100%',
   		'maxChars' : 10,
   		'defaultText':'Enter SKU#s',
   		onAddTag:function(tag){
    			if(tag.length!=8){
        			return false;
    			} else {
        		$.get('../inventory/checksku',{sku: tag },function(data){
            		if(data){
                			toastr.warning('The SKU# you are trying to enter, already exists!  You can enter this number, but make sure the Item Type is different than the number already in system','SKU ALREADY IN SYSTEM!');
            		} else {
                			//toastr.success('The SKU# you entered is new, and is valid!','SKU VALID');
            		}
        		});
   			}
   		}
	});

	//ADD REMOVE INVENTORY SECTION

		//ADD NEW INVENTORY PANEL
		$('.addInventory').click(function(){
			$('#addInventoryPanel').show();	
		});
	
		$('.closePanel').click(function(e){
			e.preventDefault();
			$('#addInventoryPanel').hide(200);	
		});

		//Move to city 
	$('.movetoCity').click(function(e){
		e.preventDefault();
		$('.infoHover').hide();
		$('.modal').hide();
		$('#moveCity').modal({backdrop:'static'});	
	});
		//END ADD INVENTORY

	//Remove Item
	$(document).on('click','.removeInventoryItem',function(){
		var g = $(this);
		var id = $(this).data('id');
		clearAddMachine();
		var t = confirm("Are you sure you want to delete this item??");
		if(t){
		    $.get('inventory/deleteitem/'+id, function(data){
		        if(data=="failed"){
		        	toastr.error("This item is attached to a sale, you cannot delete it!");
		        } else {
		        	g.parent().parent().hide(200);
				g.parent().parent().remove();
		        	toastr.success("Item succesfully removed!");
		        	setTimeout(updateCount,300);
		        	
		        }
		    });
		}
	});

	$('.movetoStock').click(function(e){
	e.preventDefault();
	var link = $(this).attr('href');
	var t = confirm("Are you sure you want to move all to stock??");
	if(t){
		window.location = link;
	}
	});

	//Add Item
	$('.addNewInventory').click(function(e){
		e.preventDefault();
		var form = $('#inventoryadd').serialize();
		var t = $('#skus').val();
		if(t.length==0){
			toastr.error("You havent entered any numbers!");
		} else {
			$.getJSON("{{URL::to('inventory/add')}}",form,function(data){
				if(data){
					var cnt=0;type="";
					$.each(data.good,function(i,val){
						cnt++;type=val.item_name;
						insertProduct(val);
					});
					if(cnt!=0){
					toastr.success(cnt+" "+type+"'s have been added to Inventory","Added "+cnt+" Items");}
					if(data.bad.length>0){
						toastr.warning(data.bad.length+" Items already exist", "Already exist in inventory!!  "+data.bad.length+" items");
					}
					$('#skus').importTags('');
				}
			});
		}
	});
	//END ADD REMOVE

	//MOVE FROM ONE DEALER TO ANOTHER
	$('.moveFromDealer').click(function(e){
		e.preventDefault();
		var val = $('#fromRep').val();

		$('.repMachineCheckbox').removeAttr('checked');
		$('.repMachineBox').hide();
		$('.repMachine-'+val).show();
		$('.infoHover').hide();
		$('.modal').hide();
		$('#moveDealer').modal({backdrop:'static'});	
	});

	$('#fromRep').change(function(){
		$('.repMachineCheckbox').removeAttr('checked');
		var val = $(this).val();
		$('.repMachineBox').hide();
		$('.repMachine-'+val).show();
	});

	//ASSIGN MACHINE TO DEALER
	//Initiate the dealer to send to
	$('.addMachine').click(function(){
		var c = $('#app_city').val();
		var city=stringFilter(c);
		var id = $(this).data('id');
		var repname = $(this).data('repname');
		$('.dealerBox').removeClass('highlightTable').css('border','0px');
		$(this).parent().parent().addClass('highlightTable').css('border','1px solid #3e3e3e');
		$('.instock-li').data('repid',id).data('repname',repname).removeClass('pulse').removeClass('fadeInUp').hide();
		$('.instock-li').addClass('pulse machineHighlight');
		if(c=="all cities"){
			$('.instock-li').show();
		} else {
			$('.instock-li.'+city).show();
		}
	});

	//When a machine is clicked, send it to dealer
	$(document).on('click','.instock-image',function(){
		t = $(this);
		par = t.parent().parent();
		var id= par.data('id');
		var repid = par.data('repid');
		var repname = par.data('repname');

		if(par.hasClass('machineHighlight')){
			$.getJSON("{{URL::to('inventory/dispatch')}}",{id:id,rep:repid},function(data){
				if(data){
					var d = data.attributes;
					toastr.success('Item checked out by '+repname,' Success!');
					par.hide(200);
					setTimeout(function(){par.remove()},100);
					var status = '' ; var location = '';
					status = d.status.replace(/\s+/g, '-'); location = d.location.replace(/\s+/g, '-');
					html = "<td><button class='btn btn-mini btn-danger returnMachine' data-id='"+d.id+"'>RETURN</button><td>&nbsp;<span class='small'>"+d.item_name.charAt(0).toUpperCase() + d.item_name.slice(1)+"</span></td><td><span class='small'>"+d.location+"</span></td><td>"+d.sku+"</td><td>"+d.date_received+"</td>";
					var row = $("<tr class='dealer-"+d.item_name+" "+status+" "+location+" dealerRow'></tr>").hide().append(html).show();
					$('#rep-table-'+repid).prepend(row);
					setTimeout(updateCount,800);
				} else {
					toastr.error('FAILED! Contact the webmaster', 'FAILED');
				}
		});
		} else {
			toastr.error("To assign a machine to a rep, first activate them, by clicking ADD MACHINE in their table on the left");
			
		}
	});

	$(document).on('click','.cancel-image',function(){
			
			var sale= $(this).data('sale');
			toastr.error(" It can be marked as returned from the sales report, which will put it back into available inventory."," This is a Cancelled Sale Item | SALE #: "+sale);
	});

	$(document).on('click','.smallProductImage',function(){
		var id=$(this).attr('data-sku');
		var url = '{{URL::to("inventory/history")}}/'+id;
		var type='inventory';
		$('.'+type+'InfoHover').addClass('animated fadeInUp').load(url).show();

	});
	
	//RETURN MACHINE FROM DEALER
	$(document).on('click','.returnMachine', function(){
		var id =$(this).data('id');
		clearAddMachine();
		t = $(this);
		$.getJSON("{{URL::to('inventory/return/')}}"+id,function(data){
			if(data=="failed"){
				toastr.failed("FAILED, please Contact the webmaster","FAILED");
			} else {

				var d = data.attributes;
				t.parent().parent().hide();
				t.parent().parent().remove();
				insertProduct(d);
				toastr.success("Item succesfully returned to Stock","Returned to Stock");
			}
		});
	});
	//END ASSIGN MACHINE TO DEALER


	//ADD MACHINE TO STOCK
	// Singular add to stock function
	$(document).on('click','.intransit-image',function(){
		par = $(this).parent().parent();
		var id = par.data('id');
		$.getJSON("{{URL::to('inventory/movetostock/')}}"+id,function(data){
				if(data){
					var d = data.attributes;
					toastr.success('Item received, and moved to stock','MOVED TO STOCK');
					par.hide(100);
					setTimeout(function(){par.remove()},100);
					insertProduct(d);
					setTimeout(updateCount,300);
				} else {
					toastr.error('FAILED! Contact the webmaster', 'FAILED');
				}
		});
	})
	//END ADD TO STOCK

//FILTERS FOR PAGE
//Filter with City drodown
$('#app_city').change(function(){
	var c = $(this).val();
	city = stringFilter(c);

	$('.locationFilter').removeClass('fadeInUp').hide().addClass('fadeInUp');
	if(c=="all cities"){
		$('.locationFilter').show();
	} else {
		$('.locationFilter.'+city).show();
	}
	updateCount();
	clearAddMachine();
});

$('#inventory_search').keyup(function(){
	var value = $(this).val();
	if(value!=''){
		$('.instock-li').hide();
		$('.intransit-li').hide();
		$('.dealerRow').hide();
		$( ".instock-li[data-sku*='"+value+"']" ).show();
		$( ".intransit-li[data-sku*='"+value+"']" ).show();
		$( ".dealerRow[data-sku*='"+value+"']" ).show();
	} else {
		$('.instock-li').show();
		$('.dealerRow').show();
		$('.intransit-li').show();
	}
});

//GENERIC FUNCTIONS--------------
function stringFilter(str){
	//replace spaces with dashes
	str = str.replace(/\s+/g, '-');
	//replace slashes with spaces
	str = str.replace(/\//g, '');	
	//replace periods with spaces
	str = str.replace(/\./g,'');
	return str;
}
//----------------------------


//COUNT/UPDATE FUNCTIONS----------------

//Clear machine and ids for assigning, reset CSS as well
function clearAddMachine(){
	$('.dealerBox').removeClass('highlightTable').css('border','0px');
	$('.instock-li').data('repid','').data('repname','').removeClass('pulse machineHighlight');
	
}
//

//Count visible elements to get Count
function updateCount(){
	var c = $('#app_city').val();
	$('#cityname').val(c);
	$('.cityName').html(c.toUpperCase());
	theCity = stringFilter(c);
	
	$('.cityName').html(c.toUpperCase());
	if(c=="all cities"){
		var stock = $('.instock-li').length;
		var transit = $('.intransit-li').length;
		var maj = $('tr.dealer-majestic').length;
		var def = $('tr.dealer-defender').length;
		var att =$('tr.dealer-attachment').length;
		var stockmaj = $('.instock-li.prod-majestic').length;
		var stockdef = $('.instock-li.prod-defender').length;
		var stockatt = $('.instock-li.prod-attachment').length;
		var transitmaj = $('.intransit-li.prod-majestic').length;
		var transitdef = $('.intransit-li.prod-defender').length;
		var transitatt = $('.intransit-li.prod-attachment').length;
		
	} else {
		var stock = $('.instock-li.'+theCity).length;
		var transit = $('.intransit-li.'+theCity).length;
		var maj = $('tr.dealer-majestic.'+theCity).length;
		var def = $('tr.dealer-defender.'+theCity).length;
		var att =$('tr.dealer-attachment.'+theCity).length;
		var stockmaj = $('.instock-li.prod-majestic.'+theCity).length;
		var stockdef = $('.instock-li.prod-defender.'+theCity).length;
		var stockatt = $('.instock-li.prod-attachment.'+theCity).length;
		var transitmaj = $('.intransit-li.prod-majestic.'+theCity).length;
		var transitdef = $('.intransit-li.prod-defender.'+theCity).length;
		var transitatt = $('.intransit-li.prod-attachment.'+theCity).length;

	}
	$('.maj-count').html(maj);$('.def-count').html(def);$('.att-count').html(att);
	$('.majestic-instockCount').html(stockmaj);
	$('.defender-instockCount').html(stockdef);
	$('.attachment-instockCount').html(stockatt);
	$('.majestic-intransitCount').html(transitmaj);
	$('.defender-intransitCount').html(transitdef);
	$('.attachment-intransitCount').html(transitatt);
	var totalMaj = parseInt(maj)+parseInt(stockmaj)+parseInt(transitmaj);
	var totalDef = parseInt(def)+parseInt(stockdef)+parseInt(transitdef);
	$('.totalMajestics').html(totalMaj);
	$('.totalDefenders').html(totalDef);
	$('.checkOutCount').html($('.dealerRow:visible').length);
	$('.transitCount').html(transit);
	$('.instockCount').html(stock);
	setTimeout(function(){
		$('.instock-li').removeClass('rollIn');
	},600);
}
//

//INSERT PRODUCTS
function insertProduct(d){
	if(d.item_name=="attachment"){
		var imagetype = "att";
	} else {
		var imagetype = d.item_name;
	}
	var html="";
	var date = new Date(d.created_at);
      var month = date.toDateString().substring(4, 7);
      var day = date.getDay();
      date = month+"-"+day;
	if(d.location==''){
		d.location = 'No City';
	}
	var img="";var list="";
	if((d.status=="In Stock")||(d.status=="In-Stock")){img="instock-image";list="instock-li"; }
	else if(d.status=="Cancelled"){img="cancel-image";list="cancel-li"; }
	else {img="intransit-image";list="intransit-li";};
	d.status= stringFilter(d.status);
	var locationFilt = stringFilter(d.location);

	html+="<li class='animated rollIn  locationFilter "+locationFilt+" "+list+" prod-"+d.item_name+"' data-repid='' data-repname=''  data-id='"+d.id+"' data-sku='"+d.sku+"' data-type='"+d.item_name+"' data-sale='"+d.sales_id+"'>";
	html+="<div class='skuBOX subtle-shadow'><div class='"+img+"'><span class='theSKU'>"+d.sku+"</span><br/><span class='small'>Rcd : </span><span class='dateText'>"+date+"</span><br/><span class='small'>"+d.location.substring(0,13)+"</span></div>";
	html+="<img class='product-image smallProductImage' data-sku='"+d.sku+"' src='{{URL::to_asset('images/pureop-small-"+imagetype+".png')}}'><button class='btn pull-right btn-danger btn-mini removeInventoryItem skuDelButton' data-id='"+d.id+"'>x</button></div></li>";

	$('.productbox-'+d.item_name+'.'+d.status).prepend(html);
	setTimeout(updateCount,400);
}


});
</script>
@endsection


