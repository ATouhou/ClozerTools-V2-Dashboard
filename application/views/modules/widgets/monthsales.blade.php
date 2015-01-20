<?php $count = Appointment::where('status','=','SOLD')->count();
	$dns = Appointment::where('status','=','DNS')->count();
?>

<!-- SALES WIDGETS -->
<div class="row ">
	<div class="col-sm-12">
		<div class="xe-widget xe-counter xe-counter-info" data-count=".num" data-from="0" data-to="{{$dns}}" data-suffix="" data-duration="1">
			<div class="xe-icon">
				<i class="fa-calendar"></i>
			</div>
			<div class="xe-label">
				<strong class="num"></strong>
				<span>DEMONSTRATIONS THIS MONTH</span>
			</div>
		</div>
		<div class="xe-widget xe-counter" data-count=".num" data-from="0" data-to="{{$count}}" data-suffix="" data-duration="1">
			<div class="xe-icon">
				<i class="linecons-tag"></i>
			</div>
			<div class="xe-label">
				<strong class="num"></strong>
				<span>SOLD THIS MONTH</span>
			</div>
		</div>
		<div class="xe-widget xe-counter xe-counter-red" data-count=".num" data-from="0" data-to="{{$dns}}" data-suffix="" data-duration="1">
			<div class="xe-icon">
				<i class="fa-close"></i>
			</div>
			<div class="xe-label">
				<strong class="num"></strong>
				<span>DID NOT SELL</span>
			</div>
		</div>
	</div>
	
</div>


