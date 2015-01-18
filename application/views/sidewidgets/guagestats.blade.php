<?php 

$stats = Auth::user()->getstats();
if(Auth::user()->user_type=="agent"){
$type="CALLS";$type2="DEMOS";
} elseif(Auth::user()->user_type=="salesrep") {
$type="DEMOS";$type2="SALES";
} elseif(Auth::user()->user_type=="manager"){
$type="DEMOS";$type2="SALES";
}

;?>
 
<article class="span4" id="salesrepstats">
    <!-- new widget -->
    <div class="jarviswidget black"  data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false" >
        <header>
            <h4 id="yourstats" style="margin-top:8px;">YOUR STATS THIS MONTH</h4>                           
        </header>
        <div>
            <div class="inner-spacer" style="padding:20px;">
                <div id="guage">
                <center>
                <h4>YOUR CLOSE PERCENT</h4>
                    <canvas id="teamsales" data-value="{{$stats['MRatio']}}" ></canvas> <br><span class="shadow" style="font-size:30px;">{{$stats['MRatio']}}%</span>
                <br><br>
                <hr>
                </div>
                    <span class="label label-info boxshadow"> {{$stats['MTotal']}} {{$type}}</span>
                    <span class="label label-inverse boxshadow"> INCOMPLETE</span>
                    <span class="label label-success boxshadow">{{$stats['MClosed']}} {{$type2}}</span>
                <hr>
                @if(Auth::user()->user_type=="salesrep")
                <?php $earnings = Auth::user()->repmonthearn();?>
                <h3>Your Earnings this Week</h3>
                    <div class="bignum shadow" >${{$earnings['weekly']}}.00</div>
                <h3>Your Earnings this Month</h3>
                    <div class="bignum shadow" style="margin-bottom:40px;">${{$earnings['monthly']}}.00</div>
                @endif
                </center>
            </div>
        </div>
    </div>
    <!-- end widget -->
</article>

<script src="{{URL::to_asset('js/include/guage.min.js')}}"></script>
<script>
function getguage(gval){
    var opts = {
        lines: 12, // The number of lines to draw
        angle: 0, // The length of each line
        lineWidth: 0.29, // The line thickness
        pointer: {
          length: 1, // The radius of the inner circle
          strokeWidth: 0.073, // The rotation offset
          color: '#1f1f1f' // Fill color
        },
        colorStart: '#00CF15',   
        colorStop: '#DA9900',    
        strokeColor: '#5e5e5e',   
        generateGradient: true
    };
    
    var target = document.getElementById('teamsales'); 
    var gauge = new Gauge(target).setOptions(opts); 
    gauge.maxValue = 100; 
    gauge.animationSpeed = 18; 
    gauge.set(gval); 
}
</script>

