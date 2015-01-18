@layout('layouts/main')
@section('content')
<style>
.instock-li {
background:#fff;
color:black;
}

.number-block {
	width:20%!important;
	margin-left:10px;
	padding-right:30px!important;
}

.btn-pur {
	background:#660033;
	text-shadow:none!important;
	color:white;
}

.btn-yel {
	background:#FF9933;
	color:black;
	
}


.checkoutBlock {
	background:#99FFCC!important;
}


.checkout-li {
background:#99FFCC;
}
.intransit-li {
background:#FFCCCC;
}
</style>
<?php
function stringFilter($string){
	$string= stripslashes($string);
	$string = str_replace(array(' ','.','/','-','.','  ') ,'-',$string); 
	return  strtolower($string);
}


function inventoryTable($inventory, $type){
	$loc="";?>
	@foreach($inventory as $i)
	@if($i->item_name==$type)
	@if(($i->status=="In Stock")|| ($i->status=="Checked Out") || ($i->status=="In Transit"))
	<?php
	if($i->checked_by==""){$i->checked_by = 0;};		
	if($i->status=="In Stock"){$stock="instock";$itemtitle="This item is in stock, available to assign";} else if($i->status=="Checked Out"){
		$stock="checkout";$itemtitle="This item is assigned to ".$i->checked_by;
	} else if($i->status=="In Transit"){
		$stock="intransit";$itemtitle="This item is in transit";
	} else  {
		$pickup[] = $i;$itemtitle="Cancelled Item, waiting to be picked up";};
	if($i->returned>0){$itemtitle.=" <br/><br/>This item has been demoed ".$i->returned." times";}
	?>
	@if($i->location!=$loc)
	<?php $loc = $i->location;?>
	<tr class=" instock-li {{stringFilter($loc)}} row-{{$type}}" style="background:black;color:white;"><td colspan=6><b>{{strtoupper($loc)}}</b>
		<button class='btn pull-right btn-mini addItemToCity' data-type='{{$type}}' data-city='{{$loc}}'><i class='cus-add'></i>&nbsp;ADD ITEMS TO CITY</button>
		<button class='btn pull-right btn-mini moveToStock' style='margin-right:10px;' data-type='{{$type}}' data-city='{{$loc}}'><i class='cus-add'></i>&nbsp;MOVE TRANSIT to STOCK</button>
		<button class='btn pull-right btn-mini moveToCity' style='margin-right:10px;' data-type='{{$type}}' data-city='{{$loc}}'><i class='cus-add'></i>&nbsp;MOVE CITY</button>
	</td></tr>
	@endif
	<?php if($i->date_received<=date('Y-m-d',strtotime('-10 days'))){$time="danger-item";$itemtitle.=" | This item is older than 10 days";} else {$time="";};?>
	<tr class="locationFilter invitem-{{$i->id}} {{$stock}}-li animated fadeInUp prod-{{$type}} rowtype-{{$stock}} {{stringFilter($i->location)}} tooltwo" title="{{$itemtitle}}" data-machinetype="{{$i->item_name}}" data-repid="{{$i->user_id}}" data-repname="" data-id="{{$i->id}}" data-sku="{{$i->sku}}" data-sale="{{$i->sale_id}}" data-type="{{ucfirst($i->item_name)}}" >
		<td><span style='font-size:17px;font-weight:bolder'><i class='cus-eye sku_info' data-sku='{{$i->sku}}'></i>&nbsp;{{$i->sku}}</span> </td>
		<td><input type="checkbox" class="confirmDate" data-id="{{$i->id}}" @if($i->date_confirmed==date('Y-m-d')) checked='checked' @endif > 
		    @if($i->date_confirmed!='0000-00-00')
		    @if($i->date_confirmed!=date('Y-m-d'))
		    <span class="label label-important" id="confirm-{{$i->id}}" >  {{date('D d M',strtotime($i->date_confirmed))}} </span>
		    @else
		    <span class="label label-success" id="confirm-{{$i->id}}" >  {{date('D d M',strtotime($i->date_confirmed))}} </span>
		    @endif
		    @else 
		    <span class="label label-important" id="confirm-{{$i->id}}" > Unconfirmed </span>
		    @endif </td>
		<td class="itemstatus-{{$i->id}}">{{$i->status}}</td>
		<td>{{date('M-d',strtotime($i->created_at))}}</td>
		<td>{{strtoupper(substr($i->location,0,13))}}</td>
		<td>
			@if($i->status=="Checked Out")
			<button class='edit_dropdown btn btn-mini btn-pur' data-id="{{$i->id}}"  id="user_id|{{$i->id}}">{{$i->checked_by}}</button>
			@elseif($i->status=="In Transit")

			@else
			<button class='edit_dropdown btn btn-mini btn-yel' data-id="{{$i->id}}"  id="user_id|{{$i->id}}">ASSIGN REP</button>
			@endif

			<button class='btn btn-danger pull-right btn-mini deleteInventory' data-user='{{$i->checked_by}}' data-id='{{$i->id}}'>X</button>
		</td>
	</tr>
	@endif
	@endif
	@endforeach
	<?php
}
;?>


@include('inventory.modals')

<div id="main"  class="container-fluid" style="background:white;padding:45px;padding-top:30px;padding-bottom:800px;">

	<!-- FILTER SECTION-->
	<div class="topBar subtle-shadow hide-these-when-searching" style="margin-left:-55px;">
	<div class="row-fluid" >

		<div class="span3" style="margin-top:15px;margin-left:10px;">
			<button class="btn btn-default btn-small filterStock" data-type="instock">IN STOCK </button>
			<button class="btn btn-default btn-small filterStock" data-type="checkout">CHECKED OUT </button>
			<button class="btn btn-default btn-small filterStock" data-type="intransit">IN TRANSIT </button>
			
		</div>

		<!-- SKU SEARCH -->
		<div class="span2" >
        	<label>Search Filter :</label>
        	<input type="text"  name="inventory_search" id="inventory_search" value="" placeholder="Search by SKU#"/>
        </div>

		<!-- CITY FILTER -->
		<div class="span1">
        	<label> Filter By City : </label>
        	<select name="app_city" id="app_city" style="width:80%;">
        		<option value="all cities">All</option>
        		@if(!empty($cities))
        			@foreach($cities as $val)
        			<option value="{{stringFilter($val->cityname)}}"  
        				@if((isset($_GET['app_city']))&&($_GET['app_city']==$val->cityname)) 
        				selected = 'selected' 
        				@endif >{{$val->cityname}}</option>
        			@endforeach
        		@endif
        	</select>
		</div>

		<!-- REP FILTER -->
		<div class="span1">
        	<label> Filter By Rep : </label>
        	<select name="rep_filter" id="rep_filter" style="width:80%;">
        		<option value="all reps">All</option>
        		@if(!empty($reps))
        			@foreach($reps as $r)
        			<option value="{{$r->id}}">
        				{{$r->fullName()}}
        			</option>
        			@endforeach
        		@endif
        	</select>
		</div>

		<div class="span4" style="margin-top:10px;">
			<a href='{{URL::to("inventory?oldstyle=yes")}}'>
            	<div class='btn btn-default tooltwo' title="Click here to View Inventory Table List" >
            	    		<i class='cus-grid'></i>
            	</div>
            </a>
            <div class='btn btn-default addInventory tooltwo' title="Click here to easily add machines to Inventory" >
                <i class='cus-add'></i>&nbsp;&nbsp;ADD INVENTORY
            </div>
            
			<button class="btn btn-default moveDealer" ><i class='cus-user'></i>&nbsp;&nbsp;DEALER TRANSFER</button>
			<button class="btn btn-default loadSold" ><i class='cus-eye'></i>&nbsp;&nbsp;VIEW SOLD</button>
		</div>

	</div>
	</div>

	<!-- SIDE PANEL -->
	<div class="subtle-shadow animated slideInRight hide-these-when-searching" id="addInventoryPanel" style="margin-top:-50px;" >
		<div class="row-fluid">
            <article class="span8" id="addnewinventory" style="margin-top:100px;" >
                <h3><span class='uploadHeading'></span></h3>
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
                            <div class='cityDetails'>
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
	<!-- END SIDE PANEL -->


	

	<div class="row-fluid" id="soldInventory" style="margin-top:5px;display:none;">
			<center>
				<img src='{{URL::to("img/loaders/misc/300.gif")}}'>
			</center>
	</div>

	<div class="row-fluid" style="margin-top:70px;">

		<!--ACTUAL INVENTORY TABLE SECTION-->
		<div class="span4">
			<h3>Defenders</h3>

			<div class="row-fluid" style="margin-bottom:20px;">
			<div class="number-block border-right" >
                <center><span class="dailystats2 PUTON total-defender" style="Padding-left:10px;padding-right:10px;">0</span></center><br/>
                <h5>TOTAL</h5>
            </div>

            <div class="number-block border-right" >
                <center><span class="dailystats2  instock-defender" style="Padding-left:10px;padding-right:10px;">0</span></center><br/>
                <h5>STOCK</h5>
            </div>

            <div class="number-block" >
                <center><span class="dailystats2 checkoutBlock checkout-defender" style="Padding-left:10px;padding-right:10px;">0</span></center><br/>
                <h5>CHECKOUT</h5>
            </div>
            </div>

			<table class="apptable table table-condensed">
				<thead>
				<th>SKU #</th>
				<th>Daily Confirm</th>
				<th>Status</th>
				<th>Date Rcd</th>
				<th>Location</th>
				<th>Action</th>
				</thead>
				<tbody id="defender-table">
					{{inventoryTable($inventory, "defender")}}
				</tbody>
			</table>
		</div>

		<div class="span4">
			<h3>Majestics</h3>
			<div class="row-fluid" style="margin-bottom:20px;">
			<div class="number-block border-right" >
                <center><span class="dailystats2 PUTON total-majestic"  style="Padding-left:10px;padding-right:10px;">0</span></center><br/>
                <h5>TOTAL</h5>
            </div>

            <div class="number-block border-right" >
                <center><span class="dailystats2  instock-majestic"  style="Padding-left:10px;padding-right:10px;">0</span></center><br/>
                <h5>STOCK</h5>
            </div>

            <div class="number-block " >
                <center><span class="dailystats2 checkoutBlock checkout-majestic" style="Padding-left:10px;padding-right:10px;">0</span></center><br/>
                <h5>CHECKOUT</h5>
            </div>
            </div>
			<table class="apptable table table-condensed">
				<thead>
				<th>SKU #</th>
				<th>Daily Confirm</th>
				<th>Status</th>
				<th>Date Rcd</th>
				<th>Location</th>
				<th>Action</th>
				</thead>
				<tbody  id="majestic-table">
					{{inventoryTable($inventory, "majestic")}}
				</tbody>
			</table>
		</div>

		<div class="span4">
			<h3>Attachments</h3>

			<div class="row-fluid" style="margin-bottom:20px;">
        	<div class="number-block  border-right" >
                <center><span class="dailystats2 PUTON total-attachment" style="Padding-left:10px;padding-right:10px;">0</span></center><br/>
                <h5>TOTAL</h5>
            </div>

            <div class="number-block  border-right" >
                <center><span class="dailystats2  instock-attachment" style="Padding-left:10px;padding-right:10px;">0</span></center><br/>
                <h5>STOCK</h5>
            </div>

            <div class="number-block " >
                <center><span class="dailystats2 checkoutBlock checkout-attachment" style="Padding-left:10px;padding-right:10px;">0</span></center><br/>
                <h5>CHECKOUT</h5>
            </div>
        	</div>

			<table class="apptable table table-condensed">
				<thead>
				<th>SKU #</th>
				<th>Daily Confirm</th>
				<th>Status</th>
				<th>Date Rcd</th>
				<th>Location</th>
				<th>Action</th>
				</thead>
				<tbody  id="attachment-table">
					{{inventoryTable($inventory, "attachment")}}
				</tbody>
			</table>
		</div>

	</div>

</div>

<div class="push"></div>
<?php $reps_string = User::activeUsers('salesrep','json_id');
?>
<script src="{{URL::to_asset('js/editable.js')}}"></script>
<script>
$(document).ready(function(){

	//COUNTING SYSTEMS
	getCount();
	function getCount(){

		var def=0;var att=0; var maj=0;var attstock=0; var defstock=0;var majstock=0;
		var defcheck=0;var attcheck=0; var majcheck=0;

		$('.locationFilter').each(function(i,val){
			var count='';
			var type = $(this).data('machinetype');
			if($(this).hasClass('instock-li')){
				var count = 'instock';
			} else if($(this).hasClass('checkout-li'))  {
				var count = 'checkout';
			};
		
			if(type=='defender'){
				def++;
				if(count=="checkout"){defcheck++;} else {
					defstock++;
				}
			} else if(type=='majestic'){
				maj++;
				if(count=="checkout"){majcheck++;} else {
					majstock++;
				}
			} else if(type=='attachment'){
				att++;
				if(count=="checkout"){attcheck++;} else {
					attstock++;
				}
			}

			$('.instock-defender').html(defstock);
			$('.instock-majestic').html(majstock);
			$('.instock-attachment').html(attstock);
			$('.checkout-defender').html(defcheck);
			$('.checkout-majestic').html(majcheck);
			$('.checkout-attachment').html(attcheck);
			
		});
	}
	//END COUNTING SYSTEM
	// SHOW SOLD INVENTORY
	$('.loadSold').click(function(){
		var img = "{{URL::to('img/loaders/misc/300.gif')}}";
		$('#soldInventory').html("<center><img src='"+img+"'></center>");
		$('#soldInventory').toggle();
		$('#soldInventory').load("{{URL::to('inventory/solditems')}}");
		
	});

	// ADD INVENTORY SECTION
		$('.addInventory').click(function(){
			$('.uploadHeading').html("Add Inventory");
			$('.cityDetails').show();
			$('#addInventoryPanel').show();	
		});


		$('.closePanel').click(function(e){
			e.preventDefault();
			$('#addInventoryPanel').hide(200);	
		});

		$(document).on('click','.addItemToCity',function(){
			var city = $(this).data('city');
			var type = $(this).data('type');
			$('.uploadHeading').html("Add <span style='color:black;'>"+type.toUpperCase()+"'s</span> to <span style='color:black;'>"+city.toUpperCase()+"</span>");
			$('#addInventoryPanel').show();	
			$('#cityname2').val(city);
			$('#unittype').val(type);
			$('.cityDetails').hide();
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
						applyDropdown();
						if(cnt!=0){
							toastr.success(cnt+" "+type+"'s have been added to Inventory","Added "+cnt+" Items");
							$('#addInventoryPanel').hide(200);	
						}
						if(data.bad.length>0){
							toastr.warning(data.bad.length+" Items already exist", "Already exist in inventory!!  "+data.bad.length+" items");
						}
						$('#skus').importTags('');
						getCount();
					}
				});
			}
		});
		//Remove Item
		$(document).on('click','.deleteInventory',function(){
			var user = parseInt($(this).data('user'));
			if(user!=0){
				alert('You cannot delete an item, that is checked out! Please return it to stock!');
				return false;
			} else {
				var id = $(this).data('id');
				var t = confirm("Are you sure you want to delete this item??");
				if(t){
				    $.get('inventory/deleteitem/'+id, function(data){
				        if(data=="failed"){
				        	toastr.error("This item is attached to a sale, you cannot delete it!");
				        } else {
				        	$('.invitem-'+id).remove();
				        	toastr.success("Item succesfully removed!");
				        	//setTimeout(updateCount,300);
				        	getCount();
				        }
				    });
				}
			}
		});
		// Confirm item
		$(document).on('click','.confirmDate',function(){
			var id = $(this).data('id');
			if($(this).is(':checked')){
				var theval = 1;
			} else {
				var theval = 0;
			}
			$.getJSON("{{URL::to('inventory/confirmdate')}}",{theid:id,thevalue:theval},function(data){
				if(theval==1){
					$('#confirm-'+id).removeClass('label-important').addClass('label-success').html(data);
					toastr.success('Item last confirmed on '+data,'SUCCESS - '+data );
				} else {
					$('#confirm-'+id).removeClass('label-success').addClass('label-important').html(data);
					toastr.success('Item marked as unconfirmed ','UNCONFIRMED');	
				}
			});
		});

		//Move to Stock
		$(document).on('click','.moveToStock',function(){
				var type = $(this).data('type');
				var city = $(this).data('city');
				var t = confirm('Are you sure you want to move this cities items into stock?');
				if(t){
					$.getJSON("{{URL::to('inventory/movetostocknew')}}",{city:city, type:type},function(data){
						if(data=="noitems"){
							toastr.error('No Items to Move to Stock under '+city,'No IN TRANSIT Items!');
						} else if(data=="failed"){
							toastr.error('FAILED! Contact the webmaster', 'FAILED');
						} else {
							toastr.success(data + ' Items Moved succesully to Stock in '+city+ ', WAIT FOR RELOAD!','SUCCESS!');
							location.reload();
						}
					});
				}
		});
		// Move to City
		$(document).on('click','.moveToCity',function(e){
			var type = $(this).data('type');
			var city = $(this).data('city');
			$('#fromCity').val(city);
			$('#machineType-city').val(type);
			e.preventDefault();
			$('.infoHover').hide();
			$('.modal').hide();
			$('#moveCity').modal({backdrop:'static'});	
		});

		// Move to City
		$(document).on('click','.moveDealer',function(e){
			var type = $(this).data('type');
			var city = $(this).data('city');
			e.preventDefault();
			$('.infoHover').hide();
			$('.modal').hide();
			$('#moveDealer').modal({backdrop:"static"})
		});


		function applyDropdown(){

			$('.newlyadded_dropdown').editable('{{URL::to("inventory/edit")}}',{
				data : '{{$reps_string}}',
				type:'select',
				submit:'OK',
	   			indicator : 'Saving...',
	   			cssclass: 'checkbookSelect select',
	   			callback : function(value, settings) {
	   				var item_id = $(this).data('id');
		
	   				if(value=="ASSIGN REP"){
	   					$(this).removeClass('btn-pur').addClass('btn-yel');
	   					$('.invitem-'+item_id).removeClass('checkout-li').addClass('instock-li');
	   					
	   					$('.itemstatus-'+item_id).html("In Stock");
	   					toastr.success("Moved to stock succesfully", "ITEM BACK IN STOCK");
	   					getCount();
	   				} else {
	   					$(this).removeClass('btn-yel').addClass('btn-pur');
	   					$('.itemstatus-'+item_id).html("Checked Out");
	   					$('.invitem-'+item_id).removeClass('instock-li').addClass('checkout-li');
	   					
	   					toastr.success("Assigned Inventory to Rep", "Inventory Assigned Succesfully");
	   					getCount();
	   				}
	   				
     		}});


		}

		function insertProduct(product){
			var type = product.item_name;
			var location = stringFilter(product.location);

	    	if(product.status=="In-Transit"){var stock = "intransit";} 
	    	else if(product.status=="In-Stock") {var stock="instock";} 
	    	else if(product.status=="Checked-Out"){var stock="checkout";}
	    	else {var stock="";};

			var html = '<tr class="invitem-'+product.id+' '+stock+'-li animated fadeInUp prod-'+type+' locationFilter '+location+' tooltwo" data-repid="" data-repname="" data-id="'+product.id+'" data-sku="'+product.sku+'" >';
			html+="<td><span style='font-size:17px;font-weight:bolder'><i class='cus-eye sku_info' data-sku='"+product.sku+"'></i>&nbsp; ";
			html+=product.sku+"</span></td>";
	
			html+="<td><input type='checkbox' class='confirmDate' data-id='"+product.id+"'> <span class='label label-important'>Unconfirmed</span> </td>";
			html+="<td class='itemstatus-"+product.id+"'>"+product.status+"</td>";
			html+="<td></td>";
			html+="<td>"+location.toUpperCase()+"</td>";
			if(product.status=="In-Stock"){
				html+="<td><button class='newlyadded_dropdown btn btn-mini btn-yells' data-id='"+product.id+"'  id='user_id|"+product.id+"'>ASSIGN REP</button>";

			} else {
				html+="<td>";
			}
			html+="<button class='btn btn-danger pull-right btn-mini deleteInventory' data-user='0' data-id='"+product.id+"'>X</button></td>";
			html += "</tr>";
			if($('.row-'+type+'.'+location).length){
				$('.row-'+type+'.'+location).after(html);
			} else {
				var cityrow ='<tr class=" instock-li '+location+' row-'+type+' " style="background:black;color:white;">';
				cityrow+="<td colspan=5><b>"+product.location.toUpperCase()+"</b>";
				cityrow+="<button class='btn pull-right btn-mini addItemToCity' data-type='"+type+"' data-city='"+location+"'><i class='cus-add'></i>&nbsp;ADD ITEMS TO CITY</button>";
				cityrow+="<button class='btn pull-right btn-mini moveToStock' style='margin-right:10px;' data-type='"+type+"' data-city='"+location+"'><i class='cus-add'></i>&nbsp;MOVE IN-TRANSIT to STOCK</button>";
				cityrow+="</td></tr>";
				$('#'+type+'-table').append(cityrow+html);
			}
			
		}
	//END ADD INVENTORY

	$(document).on('click','.sku_info',function(){
		var id=$(this).attr('data-sku');
		var url = '{{URL::to("inventory/history")}}/'+id;
		var type='inventory';
		$('.'+type+'InfoHover').addClass('animated fadeInUp').load(url).show();
	});

	function filterInventory(){
		var type = "";
		$('.locationFilter').hide();
		var c = $('#app_city').val();
		var r = $('#rep_filter').val();
		$('.filterStock').each(function(i,val){
			if($(this).hasClass('btn-inverse')){
				type+= "."+$(this).data('type')+"-li,";
			}
		});
		type = type.slice(0,-1);
		$(type).show();
		if(c!="all cities"){
			$('.locationFilter').not('.'+c).hide();
		} 
		if(type===""){
			if(c=="all cities"){
			$('.locationFilter').show();
			} else {
				$('.locationFilter.'+c).show();
			}
		}
	}

	$('.filterStock').click(function(){
		
		if($(this).hasClass('btn-inverse')){
			$(this).removeClass('btn-inverse');
		} else {
			$(this).addClass('btn-inverse');
		}
		
		filterInventory();
	});



	$('#app_city').change(function(){
		var c = $(this).val();
		filterInventory();
		//updateCount();
	});

	$('#rep_filter').change(function(){
		var c = $(this).val();
		$('.locationFilter').show();
		if(c!="all reps"){
			$('.locationFilter').not( "[data-repid='"+c+"']" ).hide();
		} 
		//updateCount();
	});

	$('#inventory_search').keyup(function(){
		var value = $(this).val();
		if(value!=''){
			$('.instock-li').hide();
			$('.intransit-li').hide();
			$('.sold-li').hide();
			$('.cancelled-li').hide();
			$('.dealerRow').hide();
			$( ".instock-li[data-sku*='"+value+"']" ).show();
			$( ".intransit-li[data-sku*='"+value+"']" ).show();
			$( ".dealerRow[data-sku*='"+value+"']" ).show();
			$(".sold-li[data-sku*='"+value+"']" ).show();
			$(".cancelled-li[data-sku*='"+value+"']" ).show();
		} else {
			$('.instock-li').show();
			$('.dealerRow').show();
			$('.intransit-li').show();
			$('.sold-li').show();
			$('.cancelled-li').show();
		}
	});

	//Dropdown edit to assign to a rep
	$('.edit_dropdown').editable('{{URL::to("inventory/edit")}}',{
		data : '{{$reps_string}}',
		type:'select',
		submit:'OK',
	   	indicator : 'Saving...',
	   	cssclass: 'checkbookSelect select',
	   	callback : function(value, settings) {
	   		var item_id = $(this).data('id');

	   		if(value=="ASSIGN REP"){
	   			$(this).removeClass('btn-pur').addClass('btn-yel');
	   			$('.invitem-'+item_id).removeClass('checkout-li').addClass('instock-li');
	   			$('.itemstatus-'+item_id).html("In Stock");
	   			toastr.success("Moved to stock succesfully", "ITEM BACK IN STOCK");
	   			getCount();
	   		} else {
	   			$(this).removeClass('btn-yel').addClass('btn-pur');
	   			$('.itemstatus-'+item_id).html("Checked Out");
	   			$('.invitem-'+item_id).removeClass('instock-li').addClass('checkout-li');
	   			toastr.success("Assigned Inventory to Rep", "Inventory Assigned Succesfully");
	   			getCount();
	   		}
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
		return str.toLowerCase();
	}



});
</script>

@endsection