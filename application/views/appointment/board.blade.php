<div class="page-title">
	<div class="title-env">
		<h1 class="title">Responsive Table</h1>
		<p class="description">An example of responsive table with fixed header</p>
	</div>
	<div class="breadcrumb-env">
		<ol class="breadcrumb bc-1" >
		<li>
			<a href="dashboard-1.html"><i class="fa-home"></i>Home</a>
		</li>
		<li>
			<a href="tables-basic.html">Tables</a>
		</li>
		<li class="active">
			<strong>Responsive Table</strong>
		</li>
		</ol>
	</div>
</div>
<!-- Responsive Table -->
<div class="row">

					<div class="table-responsive" data-pattern="priority-columns" data-focus-btn-icon="fa-asterisk" data-sticky-table-header="true" data-add-display-all-btn="true" data-add-focus-btn="true">
					<table cellspacing="0" class="apptable table table-small-font table-bordered table-striped">
						<thead>
							<tr>  <th data-priority="1">Time</th>
								<th>Customer</th>
								<th>Number</th>
								<th >Address</th>
								<th >City</th>
								<th>Leadtype</th>
								<th>Booker</th>
								<th>Gift</th>
								<th>In</th>
								<th>Out</th>
								<th>Sales Rep</th>
								<th>Status</th>
								<th>Actions</th>
						
							</tr>
						</thead>
						<tbody>
							@foreach($appts as $app)
							<tr>  <td><center>
								{{$app->lead->displayAppTime($app->app_time,"ampm",false)}}
								{{$app->lead->displayAppTime($app->app_time,"ampm",true)}}
								</center>
								</td>
								<td>
									<span class="co-name">
									{{$app->lead->displayCustName(true, true)}} 
									</span>
								</td>
								<td>{{$app->lead->displayNum()}}</td>
								<td><button>{{$app->lead->displayAddress()}}</button></td>
								<td>{{$app->lead->city}}</td>
								<td><center>{{$app->lead->leadTypeIcon()}}</center></td>
								<?php $b = $app->booker;?>
								<td><span class='label label-black'>{{$b->fullName()}} </span><br/>
								<span style='font-size:10px;'>Hold : {{$b->stat("hold")}}</span>
								</td>
								<td>{{$app->lead->gift}}</td>
								<td>{{$app->in}}</td>
								<td>{{$app->out}}</td>
								<td>@if($app->salesrep) {{$app->salesrep->fullName()}} @endif</td>
								<td>{{$app->status}}</td>
								<td>{{$app->lead->gift}}</td>
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

						reapplyPopover();
					});
					</script>
				
</div>
<script src="{{URL::to('assets')}}/js/rwd-table/js/rwd-table.min.js"></script>