<style>
.showsale {
	background:#0066FF;
}

.Cancelled {
	background:#FF9999!important;
}

.nohighlight {
	background:white;
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
	
	<?php
	if($i->checked_by==""){$i->checked_by = 0;};		
	if($i->status=="Sold"){$stock="sold";$itemtitle="This item is sold on Sale #".$i->sale_id;} else if($i->status=="Cancelled"){
		$stock="cancelled";$itemtitle="This item is waiting to be picked up ";
	} else  {
		$pickup[] = $i;$itemtitle="Cancelled Item, waiting to be picked up";};
	if($i->returned>0){$itemtitle.=" <br/><br/>This item has been demoed ".$i->returned." times";}
	?>
	@if($i->location!=$loc)
	<?php $loc = $i->location;?>
	<tr class=" instock-li {{stringFilter($loc)}} row-{{$type}}" style="background:black;color:white;"><td colspan=6><b>{{strtoupper($loc)}}</b>
		
	</td></tr>
	@endif
	<?php if($i->date_received<=date('Y-m-d',strtotime('-10 days'))){$time="danger-item";$itemtitle.=" | This item is older than 10 days";} else {$time="";};?>
	<tr class="saleRow locationFilter soldRow-{{$i->sale_id}} invitem-{{$i->id}} {{$i->status}} {{$stock}}-li animated fadeInUp prod-{{$type}} locationFilter {{stringFilter($i->location)}} tooltwo" title="{{$itemtitle}}" data-sale='{{$i->sale_id}}' data-repid="{{$i->user_id}}" data-repname="" data-id="{{$i->id}}" data-machinetype="{{$i->item_name}}" data-sku="{{$i->sku}}" data-sale="{{$i->sale_id}}" data-type="{{ucfirst($i->item_name)}}" >
		<td><span style='font-size:17px;font-weight:bolder'><i class='cus-eye sku_info' data-sku='{{$i->sku}}'></i>&nbsp;{{$i->sku}}</span></td>
		<td ><center><a href='{{URL::to("reports/sales")}}?startdate={{$i->date_sold}}&amp;enddate={{$i->date_sold}}' target=_blank><button class='btn btn-small'> # {{$i->sale_id}}</button></a></center></td>
		<td><center>{{date('M-d',strtotime($i->date_sold))}}</center></td>
		<td>
			<?php $sale = Sale::find($i->sale_id);?>
			@if($sale)
			<?php
			if($sale->status=="PAID" || $sale->status=="COMPLETE"){$paid="";} else {$paid="viewSale";};
			if(empty($sale->payment)){$paypic = "payment-none.png";} else {$paypic="payment-".strtolower($sale->payment).".png";};
			?>
			
				<!--
				<img src='{{URL::to("images/pureop-")}}{{$sale->typeofsale}}.png' style='width:40px;' >
				-->
				{{strtoupper($sale->typeofsale)}}
			@endif
		</td>
		<td>{{$i->sold_by}}</td>
		<td>
			@if($sale)
				<!--
				<img style='float:right;width:80px;margin-right:10px;' src='{{URL::to_asset("images/")}}{{$paypic}}'>-->
				{{$sale->payment}}
			@endif
		</td>
	</tr>

	@endif
	@endforeach
	<?php
}
;?>

<div class="row-fluid" style="margin-top:20px;">

<h2>SOLD INVENTORY <button class='btn pull-right btn-large btn-default pickUpItems'>SHOW ITEMS WAITING TO BE PICKED UP</button></h2>
<br/>
</div>
<div class="row-fluid">
<div class="span4">
	<h3><span id="sold-defender"></span> SOLD Defenders</h3>
	<table class="apptable table table-condensed">
		<thead>
		<th style="width:21%">SKU</th>
		<th style="widht:15%;">SALE</th>
		<th>DATE</th>
		<th style='width:18%;'>TYPE</th>
		<th>SOLD BY</th>
		<th>STATUS</th>
		</thead>
		<tbody id="defender-table">
			{{inventoryTable($inventory, "defender")}}
		</tbody>
	</table>
</div>
<div class="span4">
	<h3><span id="sold-majestic"></span> SOLD Majestics</h3>
	<table class="apptable table table-condensed">
		<thead>
		<th style="width:21%">SKU</th>
		<th style="widht:15%;">SALE</th>
		<th>DATE</th>
		<th style='width:18%;'>TYPE</th>
		<th>SOLD BY</th>
		<th>STATUS</th>
		</thead>
		<tbody id="defender-table">
			{{inventoryTable($inventory, "majestic")}}
		</tbody>
	</table>
</div>
<div class="span4">
	<h3><span id="sold-attachment"></span> SOLD Attachments</h3>
	<table class="apptable table table-condensed">
		<thead>
		<th style="width:21%">SKU</th>
		<th style="widht:15%;">SALE</th>
		<th>DATE</th>
		<th style='width:18%;'>TYPE</th>
		<th>SOLD BY</th>
		<th>STATUS</th>
		</thead>
		<tbody id="defender-table">
			{{inventoryTable($inventory, "attachment")}}
		</tbody>
	</table>
</div>
</div>
<script>
$(document).ready(function(){

	$('.saleRow').hover(function(){
		id = $(this).data('sale');
		$('.soldRow-'+id).removeClass('nohighlight').addClass('showsale');
	}, function(){

		$('.soldRow-'+id).removeClass('showsale').addClass('nohighlight');
	});

    var tog = 0;
	$('.pickUpItems').click(function(){
		if(tog==0){
			tog=1;
			$(this).html("SHOW ALL SALES");
		} else {
			tog=0;
			$(this).html("SHOW ITEMS WAITING TO BE PICKED UP")
		}
		$('.saleRow').toggle();
		$('.Cancelled').show();
	});

	countSold();
	function countSold(){
		
		var defsold=0;var attsold=0; var majsold=0;
		$('.saleRow').each(function(i,val){
			var count='';
			var type = $(this).data('machinetype');
			if($(this).hasClass('sold-li')){
				var count = 'sold';
			} else if($(this).hasClass('cancelled-li'))  {
				var count = 'cancelled';
			};
		
			if(type=='defender'){
				defsold++;
			} else if(type=='majestic'){
				majsold++;
			} else if(type=='attachment'){
				attsold++;
			}

			$('#sold-defender').html(defsold);
			$('#sold-majestic').html(majsold);
			$('#sold-attachment').html(attsold);
		});
	}

});
</script>