@if(!empty($reps))

			<div class="span3" style="width:20%;float:left; border-right:1px solid #ccc">
			<fieldset>
			<h4>Working Today</h4>
			<?php $days_since=array();?>
			@foreach($reps as $v)
			
			<?php $dealer = User::find($v->id);
			 $ind="";$outd="";$dis="";
			if($dealer){
				$days_since[$dealer->id]=$dealer->demosSince();
			}
			?>
			<div style='padding:5px;border-bottom:1px solid #ccc;'>
			<input class='repstatus-dealers' id='working|{{$v->id}}' type='checkbox' @if($v->working==1) checked='checked' @endif value='{{$v->id}}'> {{$v->firstname}} {{$v->lastname}}  
			
			</div>
			@endforeach
			</fieldset>
			</div>
			<div class='span1' style='margin-left:25px;padding-right:45px;border-right:1px solid #ccc;min-height:400px;'>
			<h4>Available</h4>
			@foreach($out as $k=>$v)
			<?php 
			$title = ucfirst($v)." is available for dispatch";
			$color = "warning";
			$outd.="<span class='tooltwo label label-".$color." special blackText' title='".$title."'>".ucfirst($v)."&nbsp";
			if(!empty($days_since)){
				if($days_since[$k]['count']>3){
					$label = "important animated shake";
				} else {
					$label="inverse";
				}
					
				/*$outd.="<span class='smallbadge badge badge-".$label." special tooltwo' title=''>".$days_since['dems']."</span>&nbsp;";*/
				$outd.="&nbsp;&nbsp;<span class='smallbadge badge badge-".$label." special tooltwo' title='Demos Since Last Sale'>".$days_since[$k]['count']."</span>&nbsp;";
			}
			$outd.= "</span>&nbsp;";

			?>
			<div style='padding:5px;border-bottom:1px solid #ccc;'>
			<span class='label label-warning special blackText'>{{$v}}</span><br/>
			
			</div>
			@endforeach

			</div>

			<div class='span2' style="margin-left:40px;border-right:1px solid #ccc;min-height:400px;">
			<h4>Dispatched</h4>
			@foreach($disp as $k=>$v)
			<?php 

			$title = ucfirst($v["name"])." is on their way to a Demo";
			$color = "info";
			$dis.="<span class='tooltwo label label-".$color." special ' title='".$title."'>".ucfirst($v["name"])."&nbsp";
			if(!empty($days_since)){
				if($days_since[$k]['count']>3){
					$label = "important animated shake";
				} else {
					$label="inverse";
				}
				$dis.="&nbsp;&nbsp;<span class='smallbadge badge badge-".$label." special tooltwo'  title='Demos Since Last Sale'>".$days_since[$k]['count']."</span>&nbsp;";
			}

			if($v['type']=="ridealong"){
				$other = User::find($v["with"]);
				if($other){
					$dis.="&nbsp;&nbsp<img class='tooltwo' title='".$v["name"]." is a ridealong with ".$other->firstname."' src='".URL::to('img/ride-along.png')."' width=32px height=27px>";
				}
			}
			$dis.= "</span>&nbsp;";

			?>
				<?php $app = Appointment::find($v["appid"]);?>
				<span class='label label-info special'>{{$v["name"]}}</span>
				@if(!empty($other))
				<img class='tooltwo' title='{{$v['name']}} is a ridealong with {{$other->firstname}}' src='{{URL::to('img/ride-along.png')}}' width=32px height=27px>
				@endif
				<br/>
					@if($app)
					<a href='{{URL::to("appointment/")}}?appid={{$app->id}}'>
						<span class='small'>{{$app->lead->cust_name}} @if(!empty($app->lead->spouse_name)) & {{$app->lead->spouse_name}}  @endif | {{$app->lead->address}}</span>
					</a>
					<br/>
					@endif
			@endforeach
			</div>

			<div class='span2' style="min-height:400px;">
			<h4>In A Demo</h4>
			@foreach($indemo as $k=>$v)
			<?php 
			if($days_since[$k]['timeIn']>'01:30:00'){
				$title = ucfirst($v["name"])." has been in demo longer than an hour and a half!";
				$color = "important";
			} else {
				$title = ucfirst($v["name"])." has been in demo for less than an hour";
				$color = "success";
			}
			$ind.="<span class='tooltwo label label-".$color." special blackText ' title='".$title."'>".ucfirst($v['name'])."&nbsp";
			/*if(!empty($days_since)){
				$ind.="&nbsp;<span class='clock smallbadge badge badge-info special' data-date='".date('Y-m-d H:i:s',strtotime($v['in']))."' style='color:white;'>".$days_since[$k]['timeIn']."</span>";
			}*/
			if(!empty($days_since)){
				if($days_since[$k]['count']>3){
					$label = "important animated shake";
				} else {
					$label="inverse";
				}
			
				$ind.="&nbsp;&nbsp;<span class='smallbadge badge badge-".$label." special tooltwo'  title='Demos Since Last Sale'>".$days_since[$k]['count']."</span>&nbsp;";
			}
			
			if($v['type']=="ridealong"){
				$other = User::find($v["with"]);
				if($other){
					$ind.="&nbsp;&nbsp<img class='tooltwo' title='".$v["name"]." is a ridealong with ".$other->firstname."' src='".URL::to('img/ride-along.png')."' width=32px height=27px>";
				}
			}
			
			$ind.= "</span>&nbsp;";
			?>
				<?php $app = Appointment::find($v["appid"]);?>
				<span class='label label-success special'>{{$v["name"]}}</span>
				@if(!empty($other))
				<img class='tooltwo' title='{{$v['name']}} is a ridealong with {{$other->firstname}}' src='{{URL::to('img/ride-along.png')}}' width=32px height=27px>
				@endif
				<br/>
					@if($app)
					<a href='{{URL::to("appointment/")}}?appid={{$app->id}}'>
						<span class='small'>{{$app->lead->cust_name}} @if(!empty($app->lead->spouse_name)) & {{$app->lead->spouse_name}}  @endif | {{$app->lead->address}}</span>
					</a>
					<br/>
					@endif
			@endforeach
			</div>
			@endif


<?php
$str = "";
if(!empty($outd)){
	$str.= "<div style='float:left;margin-top:3px;'><strong>Available :</strong> ".$outd."&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp;</div>";
}
if(!empty($ind)){
	$str.= "<div style='float:left;margin-top:4px;'><strong>In Demo :</strong> ".$ind."&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp;</div>";
}
if(!empty($dis)){
	$str.= "<div style='float:left;margin-top:4px;'><strong>Disp :</strong>  ".$dis."&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp;</div>";
}

;?>

<script>
$(document).ready(function(){
	$('.dealer-StatusBar').html("{{$str}}");
	$('.tooltwo').tooltipster();


	/*$('.clock').each(function(){
		var t = $(this);
		var date = $(this).data('date');
		var start = new Date(date);
		setInterval(function(){
			var total_seconds = (new Date-start) / 1000;
			var hours = Math.floor(total_seconds / 3600);
  			total_seconds = total_seconds % 3600;
  			var minutes = Math.floor(total_seconds / 60);
  			total_seconds = total_seconds % 60;
  			var seconds = Math.floor(total_seconds);
  			hours = pretty_time_string(hours);
  			minutes = pretty_time_string(minutes);
  			seconds = pretty_time_string(seconds);
  			var timeString = hours + ":" + minutes + ":" + seconds;
			t.html(timeString); 
		},1000);
	});

	function pretty_time_string(num) {
    		return ( num < 10 ? "0" : "" ) + num;
  	}*/

    
});
</script>
