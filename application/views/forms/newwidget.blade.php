<?php
$statuses = StatusPipeline::getPipeline();
$leadtypes = array();

;?>
<style>
.formH4{
	margin-top:40px;
}
.widgetForm {float:left;
width:100%;}
.widgetForm .form-group {float:left;}

</style>
<div class="row" style="padding:15px;">
	<div class="form-group">
		<label class="col-sm-12 control-label">Select Widget</label>
		<div class="col-sm-12">
			<select class="addWidgetDropdown form-control">
				<option placeholder="Select a Widget" disabled selected>Select a Widget</option>
				<?php $type = "";?>
				<option disabled> ------- STATISTICS / COUNTS / GUAGES ------ </option>
				@foreach($widgets as $w)
				@if($w->widget_type=="Stats")
				<option value="{{$w->id}}" class="btn btn-xs" data-formid='{{$w->form_id}}' id="widget-id-{{$w->id}}" data-widgetid="{{$w->id}}" data-lgsize="{{$w->lg_size}}" data-smsize="{{$w->sm_size}}" data-medsize="{{$w->med_size}}" data-xssize="{{$w->xs_size}}">
		      		{{$w->widget_name}}
				</option>
				@endif
				@endforeach
				<option disabled> ------ LEADS ------ </option>
				@foreach($widgets as $w)
				@if($w->widget_type=="Leads")
				<option value="{{$w->id}}" class="btn btn-xs" data-formid='{{$w->form_id}}' id="widget-id-{{$w->id}}" data-widgetid="{{$w->id}}" data-lgsize="{{$w->lg_size}}" data-smsize="{{$w->sm_size}}" data-medsize="{{$w->med_size}}" data-xssize="{{$w->xs_size}}">
		      		{{$w->widget_name}}
				</option>
				@endif
				@endforeach
				<option disabled> ------ MARKETING ------ </option>
				@foreach($widgets as $w)
				@if($w->widget_type=="Marketing")
				<option value="{{$w->id}}" class="btn btn-xs" data-formid='{{$w->form_id}}' id="widget-id-{{$w->id}}" data-widgetid="{{$w->id}}" data-lgsize="{{$w->lg_size}}" data-smsize="{{$w->sm_size}}" data-medsize="{{$w->med_size}}" data-xssize="{{$w->xs_size}}">
		      		{{$w->widget_name}}
				</option>
				@endif
				@endforeach

				<option disabled> ------ SALES ------ </option>
				@foreach($widgets as $w)
				@if($w->widget_type=="Sales")
				<option value="{{$w->id}}" class="btn btn-xs" data-formid='{{$w->form_id}}' id="widget-id-{{$w->id}}" data-widgetid="{{$w->id}}" data-lgsize="{{$w->lg_size}}" data-smsize="{{$w->sm_size}}" data-medsize="{{$w->med_size}}" data-xssize="{{$w->xs_size}}">
		      		{{$w->widget_name}}
				</option>
				@endif
				@endforeach


			</select>
		</div>
	</div>
	
	<div class="col-sm-12 col-lg-12">
		<form role="form" class="animated fadeInUp widgetForm" style="display:none;" id="formid-1" >
			<h4 class="formH4">Options for <span class='widgetName'>Widget</span></h4>
			<div class="form-group">
				<label class="col-sm-12 control-label">Timeframe For Calculation</label>
				<div class="col-sm-12">
					<select class="form-control">
						<option value="DAY">DAY</option>
						<option value="MONTH">MONTH</option>
						<option value="WEEK">WEEK</option>
						<option value="ALLTIME">ALL TIME</option>
					</select>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-12 control-label">Metric To Calculate</label>
				<div class="col-sm-12">
					<select class="form-control">
						<option value="MONTH">Sales</option>
						<option value="MONTH">Units Sold</option>
						<option value="MONTH">Did Not Sell</option>
						<option value="ALLTIME">Sales Close %</option>
						<option value="WEEK">Visited Leads / Put On Demonstrations</option>
						<option value="ALLTIME">Booked Appointments</option>
						<option value="ALLTIME">Appointment Hold %</option>
						<option value="ALLTIME">Called Leads</option>
						<option value="MONTH">Contacted Leads</option>
						<option value="ALLTIME">Avg Time per Call</option>
						<option value="ALLTIME">Avg Time per Appointment</option>
					</select>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-12 control-label">Timeframe For Calculation</label>
				<div class="col-sm-12">
					<select class="form-control">
						<option value="MONTH">MONTH</option>
						<option value="WEEK">WEEK</option>
						<option value="ALLTIME">ALL TIME</option>
					</select>
				</div>
			</div>
			
		</form>
		
	</div>
</div>

<script type="text/javascript">
$(document).ready(function($)
{	
	
	
	$('.addWidgetDropdown').change(function(event){
		var id = $(this).find(':selected').attr('id');
		var form = $(this).find(':selected').data('formid');
		
		$('.widgetForm').hide();
		$('#formid-'+form).show();
		$('.modalButtonHTML').show();
		
		var lg = $(this).data('lgsize');var sm = $(this).data('smsize');var med = $(this).data('medsize');
		var xs = $(this).data('xssize'); var id = $(this).data('widgetid');

		/*$.get('{{URL::to("widget/create")}}',{theid:id,custom_name:"Test"},function(data){
			var elem = "<div class='item col-sm-"+sm+" col-lg-"+lg+" col-med-"+med+" col-xs-"+xs+"' data-widgetid='"+id+"'>"+data+"</div>";
			var $items = $(elem);
    			$container.append( $items );
    			$container.packery( 'destroy' );
    			initGrid();
		});*/
	});
	
});
</script> 
