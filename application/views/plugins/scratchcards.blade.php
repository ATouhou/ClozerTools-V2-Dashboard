<style>
.error {background:#FF9999!important;}
</style>

<dic class="row-fluid">
	<div class="span3">
		<h4>Add a Mailout</h4>
		<form id="newScratch" action="">
		<label>Quantity of Scratch Cards Mailed</label>
		<input type="text" name="scratch_qty" id="scratch_qty" />

		<label>City</label>
		<select name="scratch_city" id="scratch_city" >
			@foreach($cities as $val)
			<option value="{{$val->cityname}}">{{$val->cityname}}</option>
			@endforeach
		</select><br/>

		<label>Date Sent Out</label>
		<input class="datepicker-input" size="16" id="scratch_date" name="scratch_date" type="text" value="{{date('Y-m-d')}}" placeholder="Select a date" />
		<br/><br/>
		</form>
		<button class='btn btn-default addMailOut'>ADD MAILOUT</button>
	</div>

	<div class="span9">

		<div id="scratchStatsInfo" class="animated fadeInUp" style="display:none;">
		<h5>Scratch Card Statistics for <span class='scratchStatCity'></span></h5>
		<table class='table leadtable table-bordered table-condensed scratchTable'>
			<tr>
				<th>City </th>
				<th>Total Called In</th>
				<th>Total Booked</th>
				<th>Not Interested</th>
				<th>SOLD</th>
				<th>DNS</th>
				<th>COST PER SALE</th>
				<th>Book Ratio %</th>
				<th>Sale Ratio %</th>
				
			</tr>
			<tbody id="scratchStatTable">



			</tbody>
		</table>
		<div style="width:100%;padding:40px;" id="scratchLoader">
			<center><img src="{{URL::to_asset('img/loaders/misc/66.gif')}}"> &nbsp;&nbsp; <h2>LOADING ... </h2></center>
		</div>
		<br/><br/>
		</div>


		<table class='table leadtable table-bordered table-condensed scratchTable'>
			<tr>
				<th> Date Sent</th>
				<th> City </th>
				<th> Quantity Mailed</th>
				<th> One Week Response</th>
				<th> Total Response</th>
				<th> Conversion Ratio</th>
				<th> Est. Cost</th>
				<th> Delete</th>
			</tr>
			@foreach($scratch as $val)
			<tr class='batch-{{$val->id}}'>
				<td>{{$val->date_sent}}</td>
				<td>{{$val->city}}</td>
				<td><center><span class='label label-inverse'>{{$val->qty}}</span></center></td>
				<td>	<center>
					@if($val->oneweek_qty!=0)
				
						<span class='label label-info special'>{{$val->oneweek_qty}}</span>
						
					@endif
					</center>

				</td>
				<td>
					<center>@if($val->qty_calledin>0)<span class='label label-success special blackText'>{{$val->qty_calledin}}</span>@endif</center>
				</td>

				<td>	
					<center>
					@if($val->qty_calledin!=0)
					<?php $conversion = number_format(($val->qty_calledin/$val->qty)*100,2,'.','');?>
						@if($conversion<2.5)
						<span class='label label-warning special blackText'>{{$conversion}}%</span>
						@elseif(($conversion>2.5)&&($conversion<4.5))
						<span class='label label-info special'>{{$conversion}}%</span>
						@elseif($conversion>4.5)
						<span class='label label-success special blackText'>{{$conversion}}%</span>
						@endif
					@endif
					</center>
				</td>

				<td><center>${{$val->qty*0.21}}</center></td>
				<td><button class='btn btn-primary btn-mini viewScratchStats' data-cost='{{number_format($val->qty*0.21,0,"","")}}' data-city='{{$val->city}}' data-id='{{$val->id}}' >LOAD STATS </button>&nbsp;&nbsp;
				<button class='btn btn-danger btn-mini deleteBatch' data-id='{{$val->id}}'>DELETE</button></td>
			</tr>
			@endforeach
		</table>
		

	</div>
</div>

<script>
$(document).ready(function(){

	$('.viewScratchStats').click(function(){
		var id = $(this).attr('data-id');
		var city = $(this).attr('data-city');
		var cost = $(this).attr('data-cost');
		$('#scratchStatsInfo').show();
		$('#scratchLoader').show();
		$('#scratchStatTable').html("");

		$.getJSON("{{URL::to('lead/scratchstats')}}",{scratch_id:id},function(data){
			var html="";
			var d = data.stats;
			if(d.app!=0 && d.cnt!=0){
				bookRatio = (((parseInt(d.app)/parseInt(d.cnt))*100).toFixed(2))+"%";
			} else {
				bookRatio = "N/A";
			}
			if(d.sold!=0 && d.cnt!=0){
				saleRatio = (((parseInt(d.sold)/parseInt(d.cnt))*100).toFixed(2))+"%";
			} else {
				saleRatio = "";
			}
			if(d.sold!=0){
				costPerSale = "$"+(parseInt(cost)/parseInt(d.sold)).toFixed(2);
			} else {
				costPerSale = "";
			}
			html+="<tr><td>"+city+"</td><td><center><span class='label totalStat label-inverse'>"+d.cnt+"</span></center></td>";
			html+="<td><center><span class='label totalStat label-success'>"+d.app+"</span></center></td>";
			html+="<td><center><span class='label totalStat label-important  '>"+d.ni+"</span></center></td>";
			html+="<td><center><span class='label totalStat label-success special blackText'>"+d.sold+"</span></center></td>";
			html+="<td><center><span class='label totalStat label-important special blackText'>"+d.dns+"</span></center></td>";
			html+="<td><center><span class='label label-important totalStat '>"+costPerSale+"</span></center></td>";
			html+="<td><center><span class='label label-inverse special totalStat '>"+bookRatio+"</span></center></td>";
			html+="<td><center><span class='label label-inverse special totalStat '>"+saleRatio+"</span></center></td></tr>";
			$('.scratchStatCity').html(city);
			$('#scratchStatTable').html(html);
			$('#scratchStatsInfo').hide().removeClass('fadeInUp');
			$('#scratchStatsInfo').addClass('fadeInUp').show();
			$('#scratchLoader').hide();
		});
		
	});

	$('.deleteBatch').click(function(){
		var id = $(this).data('id');
		$.get('lead/delscratchbatch/'+id, function(data){
			$('tr.batch-'+id).hide(300);
			toastr.success('Successfully Deleted Scratch Card Mailout','Deleted');
		});
	});

	$('.addMailOut').click(function(){

		$('#appdate').datepicker( );
		var form = $('#newScratch').serialize();
		qty = $('#scratch_qty').val();

		if(qty==0){
			$('#scratch_qty').removeClass().addClass('error animated shake');
		} else {
			$('#scratch_qty').removeClass('error animated shake').val('');
			$.getJSON('lead/addscratchbatch',form,function(data){
				toastr.success('Added ScratchCard Mailout to System','Successfully Logged a Mailout');
				$('.scratchTable').append('<tr class="batch-'+data.id+'"><td>'+data.date_sent+'</td><td>'+data.city+'</td><td><center><span class="label label-inverse">'+data.qty+'</span></center></td><td></td><td></td><td></td><td><center><span class="small">$'+data.cost+'</span></center></td><td><button class="deleteBatch btn btn-danger btn-mini" data-id="'+data.id+'">DELETE</button></td></tr>');
			});
		
		}
	});

});
</script>