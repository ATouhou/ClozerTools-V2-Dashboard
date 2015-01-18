@if(!empty($leads) && !empty($event))
<h4>Homeshow Leads in {{strtoupper($event->city->cityname)}} without an Event ID</h4>
	<form id="attachLeads">
		<input type="hidden" name="event_id" value="{{$event->id}}">
	<div class="span12" style="margin-left:0px;">
		<input type='checkbox' class="checkAllLeads" />&nbsp; Check All Leads
	</div>
	<fieldset>
	@foreach($leads as $l)
		<div class='span2'>
			<input type='checkbox' class='eventLeads' name="leads[]" value="{{$l->id}}" >&nbsp;{{$l->cust_num}} <br/>{{strtoupper($l->cust_name)}}
		</div>
	@endforeach
	</fieldset>
	<br/><br/>
	<button class='btn btn-default attachChosenLeads' >ATTACH LEADS TO THIS EVENT ({{$event->event_name}})</button>

@else
<h4>No Homeshow Leads In System</h4>

@endif
<script>
$(document).ready(function(){
	$('.checkAllLeads').click(function(){
		var t = "";
		if($(this).is(':checked')){
			t = true;
		} else {
			t = false;
		}
		$('.eventLeads').each(function(i,val){
			$(this).prop('checked',t);
		});
	});

	$('.attachChosenLeads').click(function(e){
		e.preventDefault();
		var form = $('#attachLeads').serialize();
		$.post("{{URL::to('lead/attachleads')}}",form,function(data){
			if(data.cnt>0){
				toastr.success(data.cnt+ " leads were attached to this Event","SUCCESS");
				$('.eventManager').trigger('click');
			} else {
				toastr.error(data.cnt+ " leads were attached","FAILED");
				$('.eventManager').trigger('click');
			}
		});
	});


});
</script>