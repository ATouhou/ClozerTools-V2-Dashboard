<style>
.error {background:#FF9999!important;}
</style>

<dic class="row-fluid">
	<div class="span3">
		<h4>Add an Event / Homeshow</h4>
		<form id="newEvent" action="">
		<label>City</label>
		<select name="city_id" id="eventcity_id" >
			@foreach($cities as $val)
			<option value="{{$val->id}}">{{$val->cityname}}</option>
			@endforeach
		</select><br/>

		<label>Event Name</label>
		<input type="text" name="event_name" id="event_name" />

		<label>Cost Of Entry</label>
		<input type="text" name="entry_fee" id="entry_fee" />

		<label>Travel Expenses</label>
		<input type="text" name="travel_costs" id="travel_costs" />

		<label>Other Costs</label>
		<input type="text" name="other_costs" id="other_costs" />

		<label>Gift Costs</label>
		<input type="text" name="gift_costs" id="gift_costs" />

		<label>Start of Event</label>
		<input class="datepicker-input" size="16" id="event_start" name="event_start" type="text" value="{{date('Y-m-d')}}" placeholder="Select a date" />
		<br/>
		<label>End of Event</label>
		<input class="datepicker-input" size="16" id="event_end" name="event_end" type="text" value="{{date('Y-m-d',strtotime('+5 days'))}}" placeholder="Select a date" />
		<br/><br/>
		</form>
		<button class='btn btn-default addEvent'>CREATE EVENT</button>
	</div>

	<div style="float:left;width:78%;margin-left:-20px;">
		<div id="attach_leads" style="width:100%;float:left;display:none;" class="well">


		</div>
		<table class='table leadtable table-bordered table-condensed eventTable'>
			<tr>
				<th style="width:20%"> Name</th>
				<th style="width:12%;"> Dates</th>
				<th> Entry  </th>
				<th> Travel  </th>
				<th> Gifts  </th>
				<th> Other  </th>
				<th> Total Leads</th>
				<th> Total Booked</th>
				<th> Not Interested </th>
				<th> Not Qualified </th>
				<th> Book Ratio</th>
				<th> Conversion Ratio</th>
				<th> Cost Per Sale</th>
				<th> Delete</th>
			</tr>
			<?php $booked=0;$total=0;$entry=0;$other=0;$travel=0;$gift=0;$ni=0;$nq=0;$sold=0;?>
			@foreach($events as $val)
			<?php $stats = $val->stats();
			$booked+=$stats->booked;$total+=$stats->cnt;$entry+=floatval($val->entry_fee);$other+=floatval($val->other_costs);
			$travel+=floatval($val->travel_costs);$gift+=floatval($val->gift_costs);$ni+=$stats->ni;$nq+=$stats->nq;$sold+=$stats->sold;
			?>

			<tr class='event-{{$val->id}}'>
				<td><span class='blackText'><b>{{$val->event_name}}</b></span>
				<br><span class='smallText' >City : {{$val->city->cityname}}</span>
				</td>
				<td>
				 <span class='smallText'>Start : {{date('M-d',strtotime($val->event_start))}}<br/> End :  {{date('M-d',strtotime($val->event_end))}}</span>
				</td>
				<td>
					@if(!empty($val->entry_fee))
					${{$val->entry_fee}}<br/>
					@endif
				</td>
				<td>
					@if(!empty($val->travel_costs))
					${{$val->travel_costs}}<br/>
					@endif
				</td>
				
				<td>
					@if(!empty($val->gift_costs))
					${{$val->gift_costs}}<br/>
					@endif
				</td>
				
				<td>
					@if(!empty($val->other_costs))
					${{$val->other_costs}}<br/>
					@endif
				</td>
				
				
				<td>
					<center><span class='label label-inverse'>{{$stats->cnt}}</span></center>
				</td>
				<td>
					<center>
						<span class='label label-info special'>{{$stats->booked}}</span>
					</center>
				</td>
				<td>
					<center>
						<span class='label label-important special'>{{$stats->ni}}</span>
					</center>
				</td>
				<td>
					<center>
						<span class='label label-important special'>{{$stats->nq}}</span>
					</center>
				</td>
				<td>
					@if(!empty($stats->booked) && $stats->booked!=0)
						<center><span class='label label-success special blackText'>{{number_format(($stats->booked/$stats->cnt)*100,0,'.','')}}%</span></center>
					@endif
				</td>
				<td>
					@if(!empty($stats->sold) && $stats->sold!=0)
						<center><span class='label label-success special blackText'>{{number_format(($stats->sold/$stats->booked)*100,0,'.','')}}%</span></center>
					@endif
				</td>
				
				<td>
				<center>
				@if(!empty($stats->sold) && $stats->sold!=0)
					<span class='label label-warning special blackText'>
						<?php $cost = (floatval($val->entry_fee)+floatval($val->other_costs)+floatval($val->gift_costs)+floatval($val->travel_costs));
						$cost_per_sale = floatval($cost)/intval($stats->sold);?>
						${{$cost_per_sale}}

					</span>
				@endif
				</center>
				</td>
				<td>
				
				<button class='btn btn-primary btn-mini attachLeadsToEvent' data-id='{{$val->id}}'>ATTACH LEADS</button>
				<button class='btn btn-danger btn-mini deleteEvent' data-id='{{$val->id}}' style='margin-top:3px;'>DELETE EVENT</button>
			</td>
			</tr>
			@endforeach
			<tr style='height:30px;background:#ddd;'></tr>
			<tr>
				
			<td><span class='blackText'><b>TOTALS</b></span></td>
				<td>
				 
				</td>
				<td>
					${{$entry}}
				</td>
				<td>
					${{$travel}}
				</td>
				
				<td>
					${{$gift}}
				</td>
				
				<td>
					${{$other}}
				</td>
				
				
				<td>
					<center><span class='label label-inverse'>{{$total}}</span></center>
				</td>
				<td>
					<center>
						<span class='label label-info special'>{{$booked}}</span>
					</center>
				</td>
				<td>
					<center>
						<span class='label label-important special'>{{$ni}}</span>
					</center>
				</td>
				<td>
					<center>
						<span class='label label-important special'>{{$nq}}</span>
					</center>
				</td>
				<td>
					@if(!empty($booked) && $booked!=0)
						<center><span class='label label-success special blackText'>{{number_format(($booked/$total)*100,0,'.','')}}%</span></center>
					@endif
				</td>
				<td>
					@if(!empty($sold) && $sold!=0)
						<center><span class='label label-success special blackText'>{{number_format(($sold/$booked)*100,0,'.','')}}%</span></center>
					@endif
				</td>
				
				<td>
				<center>
				@if(!empty($sold) && $sold!=0)
					<span class='label label-warning special blackText'>
						<?php $cost = (floatval($entry)+floatval($other)+floatval($gift)+floatval($travel));
						$totcost_per_sale = floatval($cost)/intval($sold);?>
						${{$totcost_per_sale}}

					</span>
				@endif
				</center>
				</td>
				<td>
				</td>
			</tr>
		</table>
	</div>
</div>

<script>
$(document).ready(function(){

	$('.attachLeadsToEvent').click(function(){
		var img = "{{URL::to('img/loaders/misc/66.gif')}}";
		var id = $(this).data('id');
		$('#attach_leads').html("<center>Loading... <br/><br/><br/><img src='"+img+"'></center>");
		$('#attach_leads').load("{{URL::to('lead/attacheventleads/')}}"+id);
		$('#attach_leads').show();
	});

	$('.viewEventStats').click(function(){
		var id = $(this).attr('data-id');
		var name = $(this).attr('data-name');

		$('#scratchStatsInfo').show();
		$('#scratchLoader').show();
		$('#scratchStatTable').html("");

		$.getJSON("{{URL::to('lead/eventstats')}}",{event_id:id},function(data){
			var html="";
			var d = data.stats;
			if(d.app!=0 && d.cnt!=0){
				bookRatio = (((parseInt(d.booked)/parseInt(d.cnt))*100).toFixed(2))+"%";
			} else {
				bookRatio = "N/A";
			}
			if(d.sold!=0 && d.cnt!=0){
				saleRatio = (((parseInt(d.sold)/parseInt(d.cnt))*100).toFixed(2))+"%";
			} else {
				saleRatio = "";
			}
			if(d.sold!=0){
				costPerSale = "$"+0;
			} else {
				costPerSale = "";
			}
			html+="<tr><td>"+name+"</td><td><center><span class='label totalStat label-inverse'>"+d.cnt+"</span></center></td>";
			html+="<td><center><span class='label totalStat label-success'>"+d.booked+"</span></center></td>";
			html+="<td><center><span class='label totalStat label-important  '>"+d.ni+"</span></center></td>";
			html+="<td><center><span class='label totalStat label-success special blackText'>"+d.sold+"</span></center></td>";
			html+="<td><center><span class='label totalStat label-important special blackText'>"+d.dns+"</span></center></td>";
			html+="<td><center><span class='label label-important totalStat '>"+costPerSale+"</span></center></td>";
			html+="<td><center><span class='label label-inverse special totalStat '>"+bookRatio+"</span></center></td>";
			html+="<td><center><span class='label label-inverse special totalStat '>"+saleRatio+"</span></center></td></tr>";
			$('.eventName').html(name);
			$('#scratchStatTable').html(html);
			$('#scratchStatsInfo').hide().removeClass('fadeInUp');
			$('#scratchStatsInfo').addClass('fadeInUp').show();
			$('#scratchLoader').hide();
		});
	});

	$('.deleteEvent').click(function(){
		var id = $(this).data('id');
		var t = confirm("If you delete this Event, any leads entered under it will be dissasociated.  You can attach them to another event later, if you choose");
		if(t){
			$.get('lead/delevent/'+id, function(data){
				$('tr.event-'+id).hide(300);
				console.log(data);
				toastr.success('Successfully Deleted Event','Deleted');
			});
		}
	});

	$('.addEvent').click(function(){
		$('#appdate').datepicker( );
		var form = $('#newEvent').serialize();
		var name = $('#event_name').val();
		var city = $('#eventcity_id').find(":selected").val();
		var cost = $('#entry_fee').val();
		if(cost==0 || cost==""){
			$('#entry_fee').removeClass().addClass('error animated shake');
			toastr.error('Cannot enter new Event without a cost','ERROR');
			return false;
		}
		if(cost.search(/^([0-9\.]+)$/)==-1){
			$('#entry_fee').removeClass().addClass('error animated shake');
			toastr.error('Not a Valild Number','ERROR');
			return false;
		}
		if(city==0 || city=="" || city==undefined){
			toastr.error('Must select a city','ERROR');
			$('#eventcity_id').removeClass().addClass('error animated shake');
			return false;
		}
		if(name==0 || name=="" || name==undefined){
			toastr.error('Must enter a name for this event','ERROR');
			$('#event_name').removeClass().addClass('error animated shake');
			return false;
		}
		//$('#event_name').removeClass('error animated shake').val('');
		$.getJSON('{{URL::to("lead/addevent")}}',form,function(data){
			if(data=="alreadyexists"){
				toastr.error('An Event with this Name exists, Try Again','EVENT EXISTS');
			} else {
				toastr.success('Added Event to System','SUCCESS');
				$('.eventManager').trigger('click');
				
			}
			
		});
	});

});
</script>