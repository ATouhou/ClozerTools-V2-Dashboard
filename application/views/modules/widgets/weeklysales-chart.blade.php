<?php $sales = DB::connection("clozertools-tenant-data")->query("SELECT COUNT(id) as total, app_date FROM ".Auth::user()->tenantTable()."_appointments WHERE app_date=WEEK(NOW()) AND status='SOLD' GROUP BY app_date LIMIT 60");
	$sold = Appointment::where('status','=','SOLD')->where('app_date','=','WEEK(NOW())')->count();
?>
<div class="chart-item-bg">
	<div class="chart-label chart-label-small">
		<div class="h4 text-green text-bold"  data-count="this" data-from="0" data-to="{{$sold}}" data-suffix="" data-duration="1.5">{{$sold}}</div>
		<span class="text-small text-upper text-muted">Total Sales This Week</span>
	</div>
	<div id="weeksales-chart" style="height: 134px;"></div>
</div>

<script>
$(document).ready(function(){
	var data = {{json_encode($sales)}};
	var i =0;
	$("#weeksales-chart").dxChart({
		dataSource: data,
		series: {
			argumentField: "app_date",
			valueField: "total",
			name: "Sales",
			type: "bar",
			color: 'green'
		},
		commonAxisSettings: {
			label: {
				visible: false
			},
			grid: {
				visible: false
			}
		},
		legend: {
			visible: false
		},
		argumentAxis: {
	        valueMarginsEnabled: true
	    },
		valueAxis: {
			max: 12
		},
		equalBarWidth: {
			width: 11
		}
	});

	$(window).on('xenon.resize', function()
	{
		$("#server-uptime-chart").data("dxChart").render();
	});
});
</script>	