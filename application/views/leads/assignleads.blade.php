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
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Adjustable Responsive Table</h3>
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
					<div class="table-responsive" data-pattern="priority-columns" data-focus-btn-icon="fa-asterisk" data-sticky-table-header="true" data-add-display-all-btn="true" data-add-focus-btn="true">
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
<script src="{{URL::to('assets')}}/js/rwd-table/js/rwd-table.min.js"></script>