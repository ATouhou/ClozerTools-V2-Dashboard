<?php $settings = Setting::find(Auth::user()->tenant_id);?>
@if($settings->goals==0)
<div class="col-lg-12 col-sm-12 subtle-shadow whiteback" style="width:100.5%;">
  <h4><b>{{strtoupper($m->custom_name)}}</b></h4>
  
  <div class="row" style="margin-top:-26px;padding:17px;">
   
  @if($m->custom_chart=="guage")
  <?php if($m->custom_lg<=3){
    $height="120px;";$width=7;$guageSize="126%;margin-left:-10px;";
} else {$height="130px";$width=12;$guageSize="100%";};?>
  <div class="row" style="margin-bottom:2px;">
    <div class="col-lg-4 col-sm-4">
      <center>
      <div class="chart-right-legend">
        <div id="gauge{{$m->id}}-1" class="guageChart widgetDataPoint" data-width="{{$width}}" data-statobject="{{$m->stat_object}}" data-key="totals.appointment.TOTALS" style="width: {{$guageSize}}; height: {{$height}}"></div>
      </div>
      <div style="margin-top:-16px;"><b>DEMOS</b></div>
      </center>
    </div>

    <div class="col-lg-4 col-sm-4">
      <center>
      <div class="chart-right-legend">
        <div id="gauge{{$m->id}}-2" class="guageChart widgetDataPoint" data-width="{{$width}}"  data-statobject="{{$m->stat_object}}" data-key="totals.appointment.TOTALS" style="width: {{$guageSize}}; height: {{$height}}"></div>
      </div>
      <div style="margin-top:-16px;"><b>SALES</b></div>
      </center>
    </div>

    <div class="col-lg-4 col-sm-4">
      <center>
      <div class="chart-right-legend">
        <div id="gauge{{$m->id}}-3" class="guageChart widgetDataPoint" data-width="{{$width}}"  data-statobject="{{$m->stat_object}}" data-key="totals.appointment.TOTALS" style="width: {{$guageSize}}; height: {{$height}}"></div>
      </div>
      <div style="margin-top:-16px;"><b>UNITS SOLD</b></div>
      </center>
    </div>
  </div>
  
  @else
			<style>
				.bar2 {
				  width: 0%;
  				  height: 100%;
  				  color: #ffffff;
  				  float: left;
  				  font-size: 12px;
  				  
				}
				.onpaceArrow {
					float:right;
					color:#000;
					height:100%;
				}
				.littleArrow {
					position:relative;
					margin-top:-26px;
					margin-left:200px;
					z-index:50000;
				}
			</style>
			<br/>

  <b>DEMOS :</b> 
  <div class="progress"  data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Put On Demos" data-original-title="Goal Guage Description">
        <div class="progress-bar progress-bar-success widgetDataPoint" data-statobject="{{$m->stat_object}}" data-key="totals.appointment.TOTALS" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width:20%;padding-top:30px;">
            
        </div>
        <div class="bar2" data-percentage="" style="width:50%">
          <div class="onpaceArrow tooltwo" title="On Pace for Demos This Week">
            <img src="{{URL::to('images/little-arrow.png')}}" style="margin-top:-40px;">
          </div>
        </div>
  </div>
  <b>SOLD DEMOS :</b> 
  <div class="progress"  data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Put On Demos" data-original-title="Goal Guage Description">
        <div class="progress-bar progress-bar-success widgetDataPoint" data-statobject="{{$m->stat_object}}" data-key="totals.grosssales" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%;padding-top:30px;">
            
        </div>
        <div class="bar2" data-percentage="" style="width:50%">
          <div class="onpaceArrow tooltwo" title="On Pace for Demos This Week">
            <img src="{{URL::to('images/little-arrow.png')}}" style="margin-top:-40px;">
          </div>
        </div>
  </div>
  <b>UNITS SOLD :</b> 
  <div class="progress" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Put On Demos" data-original-title="Goal Guage Description">
        <div class="progress-bar progress-bar-success widgetDataPoint" data-statobject="{{$m->stat_object}}" data-key="totals.totgrossunits" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%;padding-top:30px;">
            
        </div>
        <div class="bar2" data-percentage="" style="width:50%">
          <div class="onpaceArrow tooltwo" title="On Pace for Demos This Week">
            <img src="{{URL::to('images/little-arrow.png')}}" style="margin-top:-40px;">
          </div>
        </div>
  </div>
 
      
@endif
</div>
</div>
@if($m->custom_chart=="guage")
<script>
$(document).ready(function(){

  $('.guageChart').each(function(){
    var id = $(this).attr('id');
    var width = $(this).data('width');
    initGuage('#'+id,width,16);
  });

  function initGuage(elem, width, value){
    $(elem).dxCircularGauge({
      scale: {
        startValue: 0,
        endValue: 100,
        majorTick: {
          tickInterval: 25
        }
      },
      //TODO GET RID OF TICK MARKS
      rangeContainer: {
        width:width,
        ranges: [
          { startValue: 0, endValue: 25, color: "#CC0000" },
          { startValue: 25, endValue: 50, color: "#FF6666" },
          { startValue: 50, endValue: 75, color: "#CCFF66" },
          { startValue: 75, endValue: 100, color: "#66FF66" },
        ],
      },
      value: value,
      valueIndicator: {
        offset: 1,
        color: '#000',
        type: 'triangleNeedle',
        spindleSize: 10
      }
    });
  }

  function networkRealtimeGaugeTick()
        {
          if(jQuery('#network-realtime-gauge').length == 0)
            return;
            
          var nr_gauge = jQuery('#network-realtime-gauge').dxCircularGauge('instance');
          
          nr_gauge.value( between(50,200) );
        }
});
</script>
@endif
@endif
            
            