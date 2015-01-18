<?php 
$stats = Auth::user()->getstats();
$wgoalpercent = $stats['WClosed']/Auth::user()->weeklygoal()*100;
$mgoalpercent = $stats['MClosed']/Auth::user()->monthlygoal()*100;
?>

@if(Auth::user()->user_type!="manager")
<input type="hidden" name="count" id="count" value="0"/>
<button class="btn btn-mini btn-primary newWeek" data-dir="prev" data-week="">PREV WEEK</button>&nbsp;&nbsp;&nbsp;<button class="btn btn-mini btn-primary newWeek" data-dir="next" data-week="" style="float:right;">NEXT WEEK</button><br><br>
<ul class="indented aside-progress-stats">
    <li>
        <!-- easy pie chart -->
        <div class="easypie">
            <h2>Goal Completion</h2>
            <div id="gague-chart" >
                <div id="g1" style="width:100%;height:120px;"></div>
                <div id="g2" style="width:100%;height:120px;"></div>
            </div>
        </div>
        <!-- end easy pie chart -->
    </li>
</ul>
<div class="divider"></div>
<!-- aside item: Tiny Stats -->
<div class="number-stats">
    <ul>
        <li><span>WEEK</span><p id="weeknum">{{$stats['WTotal']}}</p><span>{{$stats['type2']}}</span></li>
        <li><span>MONTH</span><p id="monthnum">{{$stats['MTotal']}}</p><span>{{$stats['type2']}}</span></li>
        <li><span>GOAL</span><p>{{Auth::user()->monthlygoal()}}</p><span>{{$stats['type2']}}</span></li>
    </ul>
</div>
<div class="divider"></div>
<!-- end aside item: Tiny Stats -->

<script>
$(document).ready(function(){

    var g1, g2;
    window.onload = function() {
    var g1 = new JustGage({
        id : "g1",
        value : {{$stats['WTotal']}},
        startAnimationType: "bounce",
        refreshAnimationType: "bounce",
        refreshAnimationTime:900,
        shadowOpacity: 1.98,
        shadowSize:2,
        levelColors : ["#FF0000", "#00FF00"],
        min : 0,
        max : {{$stats['weeklygoal']}},
        title : "Weekly Goal  | {{$stats['weeklygoal']}} {{$stats['type2']}}",
        label : "",
        //valueFontColor : "#FFFF66",
        gaugeWidthScale : 1
    });
    var g2 = new JustGage({
        id : "g2",
        value : {{$stats['MTotal']}},
        startAnimationType: "bounce",
        refreshAnimationType: "bounce",
        refreshAnimationTime:900,
        shadowOpacity: 1.98,
        shadowSize:2,
        levelColors : ["#FF0000", "#00FF00"],
        min : 0,
        max : {{$stats['monthlygoal']}},
        title : "Monthly Goal | {{$stats['monthlygoal']}} {{$stats['type2']}}",
        label : "",
        //valueFontColor : "#FFFF66",
        gaugeWidthScale : 1
    });
    
$('.newWeek').click(function(){
    var count = $('input#count').val();
    var direction = $(this).data('dir');
    if(direction=="next"){count--;} else {count++;}
    $('input#count').val(count);
    $.getJSON('../dashboard/getajaxstats/'+count, function(data){
       
        $('p#weeknum').html(data.WTotal);
        $('p#monthnum').html(data.MTotal);
        g1.refresh(data.WTotal);
        g2.refresh(data.MTotal);
    });
    @if(Auth::user()->user_type=="doorrep")
        var html = "";
        $.getJSON('../dashboard/ajaxtable/'+count, function(data){
            $('.leadcount').html(data.length);
            $('.dollarearned').html("$"+data.length*3+".00");
            $('.datereplace').html("");
                $.each(data, function(i, value){
                var msecPerDay = 24 * 60 * 60 * 1000;
                var date = (new Date(value.entry_date ))
                var d = (new Date(date.getTime() + msecPerDay)+'').split(' ');
                html += "<tr><td >"+d[0]+"-"+d[2]+"</td><td class='edit'>"+value.cust_num+"</td><td class='edit'>"+value.cust_name+"</td><td class='edit'>"+value.address+"</td><td>"+value.city+"</td></tr>";
            });

            if(html.length>0){
                $('.leads').show();
                $('.nodata').hide();
                $('tbody#leadtable').html(html);
                $('#viewleadlist').trigger('click');
            } else {
                $('.leads').hide();
                $('.nodata').show();
                $('#viewleadlist').trigger('click');
            }      
        });
    @endif
});

    
        } // end if



});
</script>
@endif