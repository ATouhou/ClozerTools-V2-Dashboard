@layout('layouts/main')
@section('content')
<?php $chart = $user->barchart();
$stats = $user->totalstats();
$calls = $user->todayscalls();
$leads = $user->agentleads();
?>
<style>
.uploadAvatar {cursor:pointer;}
.uploadAvatar:hover {background:#ddd}
</style>
<div id="main" role="main" class="container-fluid">
    <div class="contained">
        <aside> 
            @render('layouts.managernav')
        </aside>
        <div id="page-content">
            <div class="row-fluid">
                <div class="span5">
                <h1 id="page-header">{{$user->firstname}} {{$user->lastname}}</h1>   
                    @if(count($leads)>0)
                    <button class="btn btn-primary showleads" onclick="$('#bookerleads').toggle(50);" style="float:right;margin-top:-72px;" >
                        <div id="countercalls2" ><h5 style="margin-bottom:-20px;"><i class="cus-telephone"></i>&nbsp;&nbsp;LEADS ASSIGNED </h5>
                            <input type="hidden" name="assigned" id="assigned" value="{{count($leads)}}" /><Br/>
                        </div>
                        Calling :&nbsp; <span class='label label-success'>{{$leads[0]->city}}</span><br/>
                        <div style="margin-top:6px;font-size:12px;">
                            Todays Stats : <br/>
                            App: <span class='label label-success special'>{{$calls[0]->app}}</span> 
                            NH : <span class='label label-info special '>{{$calls[0]->nh}}</span>
                            NI : <span class='label label-danger special'>{{$calls[0]->ni}}</span>
                        </div>
                    </button>
                    @endif
                    <div id="countercalls" class="counter3">
                        <h5>TOTAL CALLS MADE </h5>
                        <input type="hidden" name="totalcalls" id="totalcalls" value="{{$stats['ALLCALLS'][0]->total}}" />
                    </div>
                </div>
                <div class="span7 well" style="padding-bottom:36px;">
                    <h4 style="margin-top:-3px;margin-left:5px;">Shifts This Week</h4>
                    @foreach($user->shifts("breakdown") as $val)
                    <div style="float:left;width:13%;margin-right:8px;margin-top:5px;border-right:1px solid #ddd;padding-right:5px;padding-left:5px;">
                        <span class='label label-inverse'>{{date('D M-d',strtotime($val->date))}}</span><br/>
                        <span class='label label-info'>{{date('h:i a',strtotime($val->checkin))}}</span><br/>
                        <span class='label label-info'>{{date('h:i a',strtotime($val->checkout))}}</span><br/><br/>

                    </div>
                    @endforeach
                </div>
            </div>
            
                <div class="fluid-container">
                    @if(!empty($leads))
                    <div class="row-fluid well" id="bookerleads" style="display:none;">
                        <table class="table table-bordered responsive" >
                            <thead>
                                <tr align="center">
                                    <th>Date</th>                                                   
                                    <th class="span2">Customer<br />Phone Number</th>
                                    <th>Customer<br />Name</th>
                                    <th>City</th>
                                    <th>CALLED</th>
                                    <th>Last Contact</th>
                                    <th>Status</th>  
                                </tr>
                            </thead>
                            <tbody id="bookerleaddata">
                                @foreach($leads as $val2)
                                <?php if($val2->status=="APP"){$shadow="shadowtable";$color="#000";} else {$shadow="";$color="black";}
                                    if($val2->status=="APP"){$label="success";$msg = "DEMO BOOKED!";}
                                    elseif($val2->status=="SOLD"){$label="success";$msg = " $$ SOLD $$";}
                                    elseif($val2->status=="ASSIGNED"){$label="info";$msg = "ASSIGNED TO CALL";} 
                                    elseif($val2->status=="NH") {$label="inverse";$msg = "NOT HOME";} 
                                    elseif($val2->status=="DNC") {$label="important";$msg = "DO NOT CALL!";}
                                    elseif($val2->status=="NI") {$label="important";$msg = "NOT INTERESTED";}
                                    elseif($val2->status=="NID") {$label="important special blackText";$msg = "NOT INTERESTED IN DRAW";}
                                    elseif($val2->status=="Recall") {$label="warning";$msg = "RECALL";} 
                                    elseif($val2->status=="NQ") {$label="important";$msg = "NOT QUALIFIED";} 
                                    elseif($val2->status=="WrongNumber"){$label="warning";$msg="Wrong Number";} 
                                    else{$label="";$msg="";} ?>
                                <tr id='{{$val2->cust_num}}' class="{{$shadow}} {{$val2->status}} leadrow" style='color:{{$color}}'>
                                    <td>{{date('M-d', strtotime($val2->assign_date))}}</td>
                                    <td class="span2">{{$val2->cust_num}}</td>
                                    <td>{{$val2->cust_name}}</td>
                                    <td>{{$val2->city}}</td>
                                    <?php $callcount = Lead::find($val2->id)->calls()->count();?>
                                    @if($callcount>0)
                                        <?php $last = Lead::find($val2->id)->calls()->order_by('created_at','DESC')->first();?>
                                    <td>
                                        <center>
                                            <span class='label label-success boxshadow'>CALLED {{$callcount}} TIMES</span>
                                        </center>
                                    </td>
                                    <td>Called on <b>{{date('M-d h:i a', strtotime($last->created_at))}}</b> by <b>{{$last->caller_name}}</b> &nbsp;<sclass="label label-inverse">Result :  {{$last->result}}</span>
                                    </td>
                                    @else
                                    <td>
                                        <center>
                                            <span class='label label-inverse'>Not Called</span>
                                        </center>
                                    </td>
                                    <td>Have not contacted this lead yet</b></td>
                                    @endif
                                    <td>
                                        <center>
                                            <span class='label label-{{$label}} special boxshadow'>{{$msg}}</span>
                                        </center>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif


                    
                    <div class="row-fluid">
                        <div class="span5 well" style="margin-top:40px;">
                            <img class="tooltwo uploadAvatar animated rollIn" src="{{$user->avatar_link()}}" width=100px height=120px title='Click to Upload New Avatar' data-id='{{$user->id}}' style="float:left;padding-right:20px;border:1px solid #ddd;border-radius:8px;">
                            <div class="span6" style="margin-left:20px;">
                                <span class='label label-info'>Start Date:</span> <span class='label label-inverse'>
                                    @if($user->startdate!="0000-00-00") {{date('M d Y',strtotime($user->startdate))}}
                                    @else N/A @endif</span> <br/>
                                <span class='label label-info'>End Date:</span> <span class='label label-inverse'>
                                    @if($user->enddate!="0000-00-00") {{date('M d Y',strtotime($user->enddate))}}
                                    @else N/A @endif</span> <br/><br/>
                                Name : {{$user->firstname}} {{$user->lastname}}<br/>
                                Phone no : <b>{{$user->cell_no}}</b><br/>

                            </div>
                            <div class="span12" style="margin-top:10px;border-top:1px solid #ddd;padding-top:10px;">
                                <H4>Shifts This Week : <span style="color:#000;font-size:20px;">{{$user->shifts()}} Shifts</span>&nbsp;&nbsp;
                                    <a href="{{URL::to('agent/schedule')}}">
                                        <button class="btn btn-default btn-mini">VIEW SCHEDULE</button>
                                    </a>
                                </h4>
                                <h5>
                                     Total Calls Made : <span style="color:#000;font-size:16px;">{{$stats['ALLCALLS'][0]->total}}</span>
                                </h5>
                                <h5>
                                     Total Contacts : <span style="color:#000;font-size:15px;">{{$stats['ALLCALLS'][0]->ni+$stats['ALLCALLS'][0]->app+$stats['ALLCALLS'][0]->nq+$stats['ALLCALLS'][0]->dnc}}</span>
                                </h5>
                                <h5>
                                     Total Manilla Bookings : <span style="color:#000;font-size:15px;">{{$stats['ALLCALLS'][0]->manilla}}</span>
                                </h5>
                                <h5>
                                     Total Door Reggie Booked : <span style="color:#000;font-size:15px;">{{$stats['ALLCALLS'][0]->door}}</span>
                                </h5>
                                <h5>
                                     Total Scratch Bookings : <span style="color:#000;font-size:15px;">{{$stats['ALLCALLS'][0]->scratch}}</span>
                                </h5>
                               	<br/><br/>
                            </div>
                        </div>
                        <div class="span7">
                        	<h4>Lifetime Stats for {{$user->firstname}}</h4>
                        </div>
                        <div class="span7 well" >

                            <div class="span6" style="border-right:1px solid #ddd;">
                                <h4 style="margin-left:20px;">HOLD PERCENT : &nbsp;&nbsp; <span class="bignum2 BOOK"><span id="hold-percent"></span> %</span></h4>
                                    <canvas id="holdpercent" style="margin-top:18px;" data-value="{{($stats['PUTON'][0]->puton/($stats['ALLCALLS'][0]->app+$stats['PUTON'][0]->puton)*100)}}" style="width:88%;"></canvas><br/>
                            </div>
                            <div class="span6" >
                                <h4 style="margin-left:20px;">BOOK PERCENT : &nbsp;&nbsp; <span class="bignum2 BOOK"><span id="book-percent"></span> %</span></h4>
                                    <canvas id="bookpercent" style="margin-top:18px;" data-value="{{$stats['ALLCALLS'][0]->book}}" style="width:88%;"></canvas><br/>
                            </div>
                            <div class="span12" style="width:95%;margin-top:30px;padding-top:15px;border-top:1px solid #ddd;border-bottom:1px solid #ddd">
                                @if(!empty($stats['PUTON']))
                                <div class="largestats end ">
                                    <span class="bignum2 BOOK">{{$stats['ALLCALLS'][0]->app}}</span><br/>
                                    <h5>Booked</h5>
                                </div>
                                <div class="largestats end ">
                                    <span class="bignum2 DNS2">{{$stats['ALLCALLS'][0]->ni}}</span><br/>
                                    <h5>Not Interested</h5>
                                </div>
                                <div class="largestats end ">
                                    <span class="bignum2 PUTON">{{$stats['PUTON'][0]->puton}}</span><br/>
                                    <h5>Puton</h5>
                                </div>
                                <div class="largestats end ">
                                    <span class="bignum2 SOLD">{{$stats['PUTON'][0]->sales}}</span><br/>
                                    <h5>Sales</h5>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row-fluid employeeNotes" style="padding:10px;width:98%;margin-top:10px;border-top:1px solid #ccc;border-bottom:1px solid #ccc;margin-bottom:30px;" >
        <div class="span12" style='padding:30px;'>
            <button class='btn btn-default addUserNote' data-userid="{{$user->id}}"><i class='cus-note'></i>&nbsp;&nbsp;ADD A NEW NOTE / COMMENT</button><br/><br/>
            

            <table class='table table-condensed table-bordered'>
                <tr>
                    <th>Entered By</th>
                    <th style="width:60%;">Comment / Note</th>
                    <th>Date Entered</th>
                    <th>Delete</th>
                </tr>
                <tbody class='user-note-table'>
                	<?php $k = $user->notes();?>
                	@if(!empty($k))
                @foreach($k as $n)
                <tr id='userNoteRow-{{$n->id}}'>
                    <td>{{User::find($n->sender_id)->firstname}} {{User::find($n->sender_id)->lastname}}</td>
                    <td>{{$n->body}}</td>
                    <td>{{date('Y-m-d',strtotime($n->created_at))}}</td>
                    <td><button class='btn btn-mini btn-danger deleteUserNote' data-id='{{$n->id}}'>X</button></td>
                </tr>
                @endforeach
                @endif
                </tbody>
            </table>
            <br/><br/>

           
        </div>
    </div>

                    <div class="row-fluid">
                        <div class="span5 well">
                            <div id="container" style="width:95%; height: 400px; margin: -10 auto"></div>
                        </div>
                         <div class="span7 well">
                            <div id="container2" style="width:95%; height: 400px; margin: -10 auto"></div>
                             <div class="span12">
                                <button class="btn btn-primary btn-small retrieveChart" data-id="{{$user->id}}-HOUR">HOURLY</button>
                                <button class="btn btn-primary btn-small retrieveChart" data-id="{{$user->id}}-DATE">DAILY</button>
                                <button class="btn btn-primary btn-small retrieveChart" data-id="{{$user->id}}-WEEK">WEEKLY</button>
                                <button class="btn btn-primary btn-small retrieveChart" data-id="{{$user->id}}-MONTH">MONTHLY</button>
                            </div>
                        </div>
                    </div>

                    <div class="row-fluid well">
                        <div class="span12">
                            <div id="container3" style="width:95%; height: 900px; margin: -10 auto"></div>
                            <div class="span12">
                                <button class="btn btn-primary btn-small retrieveBarChart" data-id="DATE">DAILY</button>
                                <button class="btn btn-primary btn-small retrieveBarChart" data-id="WEEK">WEEKLY</button>
                                <button class="btn btn-primary btn-small retrieveBarChart" data-id="MONTH">MONTHLY</button>
                            </div>
                        </div>
                    </div>
                </div>
        </div>    
        <aside class="right">
 
        </aside>
    </div>
</div>

<div class="push"></div>
<script src="{{URL::to_asset('js/highcharts.js')}}"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
<script src="{{URL::to_asset('js/include/gmap3.min.js')}}"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&amp;language=en"></script>
<script src="{{URL::to_asset('js/include/guage.min.js')}}"></script>
<script src="{{URL::to_asset('js/flip2.js')}}"></script>
<script>
function getguageslim(gval, element, max, textfield){
var opts = {
  lines: 12, 
  angle: 0,
  lineWidth: 0.27, 
  pointer: {
    length: 1, 
    strokeWidth: 0.064, 
    color: '#000000'
  },
  limitMax: 'true',   
  colorStart: '#002906',  
  colorStop: '#00DA41',    
  strokeColor: '#E0E0E0',  
  generateGradient: true
};
var target = document.getElementById(element); 
var gauge = new Gauge(target).setOptions(opts); 
gauge.maxValue = max; 
gauge.animationSpeed = 32; 
gauge.set(gval); 
gauge.setTextField(document.getElementById(textfield));
}
</script>
<script>
$(function () {
        $('#container').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'BOOKERS TOTAL STATS'
            },
            
            xAxis: {
                categories: [
                ]
            },
            yAxis: {
                min: 0,
                title: {
                    text: ''
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.05,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'BOOKED',
                data: [{{$chart["app"]}}],
                 color:'#33CC33'
    
            }, 
            {
                name: 'NOT INTERESTED',
                data: [{{$chart["ni"]}}],
                 color:'#990000'
    
            },
            {
                name: 'DNC',
                data: [{{$chart["dnc"]}}],
                 color:'#FF3300'
    
            },
            {
                name: 'RECALL',
                data: [{{$chart["recall"]}}],
                 color:'#FF9900'
    
            },
            {
                name: 'WRONG',
                data: [{{$chart["wrong"]}}],
                 color:'#CCCC00'
    
            }]
        });
    });
    

</script>
<script>
$(document).ready(function(){



function getChart(lengthID){
    $.get('../profilesplinechart/'+lengthID, function(data){
        console.log(data);
        var data = JSON.parse(data);
        console.log(data);
    $(function () {
        $('#container2').highcharts({
            chart: {
                type: 'areaspline'
            },
            title: {
                text: 'BOOKING STATS FOR TIME PERIOD'
            },
            legend: {
                layout: 'vertical',
                align: 'left',
                verticalAlign: 'top',
                x: 65,
                y: 32,
                floating: true,
                borderWidth: 1,
                backgroundColor: '#FFFFFF'
            },
          
            tooltip: {
                shared: true,
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                areaspline: {
                    fillOpacity: 0.1
                }
            },
            series: [{
                name: 'APP',
                data: data.app,
                color: '#33CC33'
            },
            {
                name: 'DNC',
                data: data.dnc,
                color: '#FF3300'
            }, {
                name: 'NI',
                data: data.ni,
                color: '#990000'
            },
            {
                name: 'wrong',
                data: data.wrong,
                color: '#CCCC00'
            }]
        });
    });

    });
}

getChart("60-date");
$('.retrieveChart').click(function(){
    var type = $(this).data('id');
    getChart(type);
});

function getBarChart(time){
    $.get('../profilebarchart/'+time, function(data){
        var data = JSON.parse(data);
        $(function () {
            $('#container3').highcharts({
                chart: {
                    type: 'bar'
                },
                title: {
                    text: data.title,
                    style: {
                            font: 'normal 26px Verdana, sans-serif',
                            color : 'black'
                        }
                },
                xAxis: {
                    categories: data.names,
                    title: {
                        text: null
                    },
                    labels: {
                        style: {
                            font: 'normal 17px Verdana, sans-serif',
                            color : 'black'
                        }
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'The booking averages for each marketer, Time period default is DAI',
                        align: 'high',
                        
                    },
                    labels: {
                        overflow: 'justify',
                        
                    }
                },
               
                plotOptions: {
                    bar: {
                        dataLabels: {
                            enabled: true
                        }
                    }
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'top',
                    x: -40,
                    y: 100,
                    floating: true,
                    borderWidth: 1,
                    backgroundColor: '#FFFFFF',
                    shadow: true
                },
                credits: {
                    enabled: false
                },
                series: data.values
            });
        });
    });
}
getBarChart("DATE");
$('.retrieveBarChart').click(function(){
    var type = $(this).data('id');
    getBarChart(type);
});
});
</script>
<script>
$(document).ready(function() {
$("#countercalls").flipCounter(
        "startAnimation", 
        {
        numIntegralDigits:3,
        duration:1000,
        number:0,
        end_number: $('#totalcalls').val()}
);


$("#countercalls2").flipCounter(
        "startAnimation", 
        {
        numIntegralDigits:2,
        duration:1000,
        number:0,
        end_number: $('#assigned').val()}
);

var holdper = $('#holdpercent').data('value');
getguageslim(holdper, 'holdpercent', 100,'hold-percent');
var bookper = $('#bookpercent').data('value');
getguageslim(bookper, 'bookpercent', 100,'book-percent');

});
</script>

@endsection