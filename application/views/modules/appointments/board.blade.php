<?php $appointments = Appointment::take(20)->get();?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Appointments for (date goes here)</h3>
				<div class="panel-options">
					<a href="#">
						<i class="linecons-cog"></i>
					</a>
					<a href="#" data-toggle="panel">
						<span class="collapse-icon">&ndash;</span>
						<span class="expand-icon">+</span>
					</a>
					<a href="#" data-toggle="reload">
						<i class="fa-rotate-right"></i>
					</a>
					<a href="#" data-toggle="remove">
						&times;
					</a>
				</div>
			</div>
			<div class="panel-body">
				<div class="table-responsive" data-pattern="priority-columns" data-focus-btn-icon="fa-asterisk" data-sticky-table-header="true" data-add-displayall-b="true" data-add-focus-btn="true">
				
					<table cellspacing="0" class="table table-small-font table-bordered table-striped">
						<thead>
							<tr>
								<th>Customer</th>
								<th data-priority="1">Address</th>
								<th data-priority="3">City</th>
								<th data-priority="1">Booked By</th>
								<th data-priority="3">Status</th>
								<th data-priority="3">Dispatched</th>
								<th data-priority="6">Options</th>
							</tr>
						</thead>
						<tbody>
							@foreach($appointments as $app)
							<tr>
								<th><span class="co-name" style='color:#000;'>{{strtoupper($app->lead->cust_name)}}</span> 
									<br/>{{$app->lead->address}}
								</th>
								<td></td>
								<td>{{$app->lead->city}}</td>
								<td>{{$app->booked_by}}</td>
								<td>{{$app->status}}</td>
								<td>
								</td>
								<td>
									<button class='btn btn-primary'>Test Bustton</button>
								</td>
							</tr>		
							@endforeach
						</tbody>
					</table>
				</div>
				
				<script type="text/javascript">
				// This JavaScript Will Replace Checkboxes in dropdown toggles
				jQuery(document).ready(function($)
				{
					setTimeout(function()
					{
						$(".checkbox-row input").addClass('cbr');
						cbr_replace();
					}, 0);
				});
				</script>
			</div>
		</div>
	</div>
</div>