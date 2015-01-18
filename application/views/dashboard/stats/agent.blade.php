@layout('layouts/main')
@section('content')

<style>
.num {text-align:center;}
td.border {border-left:1px solid #1f1f1f;!important}
.closepercent{
    font-size:130%;
}
.closepercent2{
    font-size:130%;
}
#element {position:absolute;margin-top:-40px;margin-left:580px;width:35%;}
.stattable {margin-top:20px;color:#000;font-weight:bold;font-size:100%;background:url('../images/cardboard_flat.png');}
</style>

<div id="main" role="main" class="container-fluid">
    <div class="contained">
        <!-- LEFT SIDE WIDGETS & MENU -->
        <aside> 
            @render('layouts.managernav')
           
       </aside>
        <!-- END WIDGETS -->
                
        <!-- MAIN CONTENT -->
        <div id="page-content" >
            <h1 id="page-header">Marketer Weekly Goals</h1>   
            <div id="element"></div>
            <div class="charts row-fluid shadowBOX " style="width:94%;display:none;margin-bottom:20px;padding:20px;border:1px solid #1f1f1f;">
                 
                <div class="span4" style="margin-left:20px;padding-right:20px;">

                     <div> <center>
                            @if(!empty($stats))
                                                <h4>BOOKER AVERAGE CLOSE PERCENTAGE</h4>
                                             <canvas id="teamsales" data-value="{{number_format(($stats[0]->app/($stats[0]->app+$stats[0]->ni)*100),2,'.','')}}"></canvas> <br><span class="shadow" style="font-size:30px;">{{number_format(($stats[0]->app/($stats[0]->app+$stats[0]->ni)*100),2,'.','')}}%</span><br><br><hr>
                                             <h4>We made 
                                                <span style="padding-left:6px;padding:5px;background:#1f1f1f;color:#fff;border-radius:4px;">{{$stats[0]->total}} </span> &nbsp;calls for this time period</h4>
                                                <hr>
                                                @endif
                                            </center>
                                                

                                            </div>
                </div>
                <div class="span5" style="border-left:1px solid #ddd;padding-left:50px;">
                  <div id="container" style="min-width: 380px; height: 380px; margin-top-200px;"></div>
                </div>
               
            </div>
             
            <div class="fluid-container">
                

            
                
                <div class="row-fluid" style="margin-bottom:20px;">
                    @if(!empty($stats))
                <h5 style="color:#000;">Total Calls Made : <span class="label label-info totalcalls">{{$stats[0]->total}}</span>&nbsp;&nbsp;APP :  <span class="label label-success special appcalls">{{$stats[0]->app}}</span>&nbsp;&nbsp; NI :  <span class="label label-important nicalls">{{$stats[0]->ni}}</span>&nbsp;&nbsp;&nbsp;  DNC :  <span class="label label-info dnccalls">{{$stats[0]->dnc}}</span>&nbsp;&nbsp;  NQ :  <span class="label label-info nqcalls">{{$stats[0]->nq}}</span>&nbsp;&nbsp;  </h5><br/>
                 <button class='btn btn-default filter btn-inverse active' data-id='door'><i class='cus-door'></i>&nbsp;DOOR SURVEY</button>&nbsp;&nbsp;<button class='btn btn-default filter' data-id='paper'><i class='cus-blog'></i>&nbsp;PAPER SURVEY</button>&nbsp;&nbsp;<button class='btn btn-default filter' data-id='other'><i class='cus-color-swatch-2'></i>&nbsp;SCRATCH / BALLOT</button> <button class="btn btn-primary" onclick="$('.charts').show(200);" style="float:right;"><i class="cus-chart-line"></i>&nbsp;SHOW CHARTS</button>  
                 @endif
             </div>
                <!-- widget grid -->
                <section id="widget-grid" class="">
                    
                     <div class="row-fluid" id="availableLeads">
                           
                            <article class="span12">
                                    <!-- new widget -->
                                    <div class="jarviswidget black" data-widget-editbutton="false" data-widget-deletebutton="false"
                                    data-widget-fullscreenbutton="false" >
                                        <header>
                                            @if(!empty($stats))
                                            <h2>TOTAL CALLS MADE |  <span class='totalcalls'>{{$stats[0]->total}}</span>  &nbsp;&nbsp;&nbsp;&nbsp;TOTAL CLOSE % |  <span class='closepercent closepercent2 totalclose'>{{number_format(($stats[0]->app/($stats[0]->app+$stats[0]->ni)*100),2,'.','')}}</span></h2>  
                                                    @endif  
                                        </header>
                                        <!-- wrap div -->
                                        <div>
                                        <div class="inner-spacer" style="padding:20px;"> 
                                              
                                        
                                        <table class="table table-bordered table-condensed door stattable animated fadeInUp" style='border:1px solid #1f1f1f; ' >
                                        <thead style="color:#000!important">
                                            <th>Booker</th>
                                            <th>Book %</th>
                                            <th>APP</th>
                                            <th>NI</th>
                                            <th>NH</th>
                                            <th>NQ</th>
                                            <th>DNC</th>
                                            <th>Wrong</th>
                                            <th>Recalls</th>
                                            <th>TOTAL</th>
                        
                                        </thead>
                                        <tbody class='stats doortable'>
                                            @if(!empty($totalstats))
                                           @foreach($totalstats as $val)
                                            <?php $u = User::find($val->caller_id);?>
                                            @if($u->user_type=="agent")
                                            <tr><td>{{strtoupper($u->firstname)}} {{strtoupper($u->lastname)}}</td>
                                            <td><center><span class='closepercent doorclose'>@if($val->app!=0){{number_format(($val->app/($val->app+$val->ni)*100),2,'.','')}}@endif</span></center></td>
                                            <td><center><span class="label label-success white appdoor">{{$val->app}}</span></center></td>
                                            <td><center><span class="label label-important white nidoor">{{$val->ni}}</span></center></td>
                                            <td><center>{{$val->nh}}</center></td>
                                            <td><center>{{$val->nq}}</center></td>
                                            <td><center>{{$val->dnc}}</center></td>
                                            <td><center>{{$val->wrong}}</center></td>
                                            <td><center>{{$val->recall}}</center></td>
                                            <td><center>{{$val->tot}}</center></td>
                                            @endif
                                            </tr>
                                            @endforeach
                                            @endif
                                            </tbody>
                                        </table>

                                      
                                        
                                        </div>
                                            <!-- end content-->
                                        </div>
                                        <!-- end wrap div -->
                                    </div>
                                    <!-- end widget -->
                                </article>
                        </div>



                    <div class="row-fluid" id="availableLeads">
                           
                            <article class="span12">
                                    <!-- new widget -->
                                    <div class="jarviswidget black" data-widget-editbutton="false" data-widget-deletebutton="false"
                                    data-widget-fullscreenbutton="false" >
                                        <header>

                                            <h2>TOTAL CALLS MADE - </h2>  
                                                            
                                        </header>
                                        <!-- wrap div -->
                                        <div>
                                            <div class="inner-spacer"> 
                                          
                                                <table class="table table-striped table-bordered responsive"  >
                                                    <thead>
                                                        <tr align="center">
                                                            <th>BOOKER</th>
                                                            <th colspan="3">
                                                                <span class='label label-inverse'>9-10 AM</span><br>Call vs Book
                                                            </th>
                                                             <th colspan="3">
                                                                <span class='label label-inverse'>10-11 AM</span><br>Call vs Book
                                                            </th>
                                                             <th colspan="3">
                                                                <span class='label label-inverse'>11-12 PM</span><br>Call vs Book
                                                            </th>
                                                            <th colspan="3">
                                                                <span class='label label-inverse'>1-2 PM</span><br>Call vs Book
                                                            </th>
                                                            <th colspan="3">
                                                                <span class='label label-inverse'>2-3 PM</span><br>Call vs Book
                                                            </th>
                                                            <th colspan="3">
                                                                <span class='label label-inverse'>3-4 PM</span><br>Call vs Book
                                                            </th>
                                                            <th colspan="3">
                                                                <span class='label label-inverse'>4-5 PM</span><br>Call vs Book
                                                            </th>
                                                            <th colspan="3">
                                                                <span class='label label-inverse'>5-6 PM</span><br>Call vs Book
                                                            </th>
                                                            <th colspan="3">
                                                                <span class='label label-inverse'>6-7 PM</span><br>Call vs Book
                                                            </th>
                                                            <th colspan="3">
                                                                <span class='label label-inverse'>8-9 PM</span><br>Call vs Book
                                                            </th>
                                                            <th colspan="3">
                                                                <span class='label label-inverse'>9-10 PM</span><br>Call vs Book
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if(!empty($callstats))
                                                    @foreach($callstats as $val)
                                                    <?php $u = User::find($val->caller_id);?>
                                                    @if($u->user_type=="agent")
                                                    <tr>
                                                        <td >{{$u->firstname}} {{$u->lastname}}</td>
                                                        <td style="border-left:1px solid #1f1f1f;">
                                                            <span class='num'>{{$val->nine}}</span>
                                                        </td>
                                                        <td><span class='num'>{{$val->ninec}}</span></td>
                                                        <td><span class='num'>{{$val->nineapp}}</span></td>
                                                        <td style="border-left:1px solid #1f1f1f;">
                                                            <span class='num'>{{$val->ten}}</span>
                                                        </td>
                                                        <td><span class='num'>{{$val->tenc}}</span></td>
                                                        <td><span class='num'>{{$val->tenapp}}</span></td>
                                                        <td style="border-left:1px solid #1f1f1f;">
                                                            <span class='num'>{{$val->eleven}}</span>
                                                        </td>
                                                        <td><span class='num'>{{$val->elevenc}}</span></td>
                                                        <td><span class='num'>{{$val->elevenapp}}</span></td>
                                                        <td style="border-left:1px solid #1f1f1f;">
                                                            <span class='num'>{{$val->twelve}}</span>
                                                        </td>
                                                        <td><span class='num'>{{$val->twelvec}}</span></td>
                                                        <td><span class='num'>{{$val->twelveapp}}</span></td>
                                                        <td style="border-left:1px solid #1f1f1f;">
                                                            <span class='num'>{{$val->thirteen}}</span>
                                                        </td>
                                                        <td><span class='num'>{{$val->thirteenc}}</span></td>
                                                        <td><span class='num'>{{$val->thirteenapp}}</span></td>
                                                        <td style="border-left:1px solid #1f1f1f;">
                                                            <span class='num'>{{$val->fourteen}}</span>
                                                        </td>
                                                        <td><span class='num'>{{$val->fourteenc}}</span></td>
                                                        <td><span class='num'>{{$val->fourteenapp}}</span></td>
                                                        <td style="border-left:1px solid #1f1f1f;">
                                                            <span class='num'>{{$val->fifteen}}</span>
                                                        </td>
                                                        <td><span class='num'>{{$val->fifteenc}}</span></td>
                                                        <td><span class='num'>{{$val->fifteenapp}}</span></td>
                                                        <td style="border-left:1px solid #1f1f1f;">
                                                            <span class='num'>{{$val->sixteen}}</span>
                                                        </td>
                                                        <td><span class='num'>{{$val->sixteenc}}</span></td>
                                                        <td><span class='num'>{{$val->sixteenapp}}</span></td>
                                                        <td style="border-left:1px solid #1f1f1f;">
                                                            <span class='num'>{{$val->seventeen}}</span>
                                                        </td>
                                                        <td><span class='num'>{{$val->seventeenc}}</span></td>
                                                        <td><span class='num'>{{$val->seventeenapp}}</span></td>
                                                        <td style="border-left:1px solid #1f1f1f;">
                                                            <span class='num'>{{$val->eighteen}}</span>
                                                        </td>
                                                        <td><span class='num'>{{$val->eighteenc}}</span></td>
                                                        <td><span class='num'>{{$val->eighteenapp}}</span></td>
                                                        <td style="border-left:1px solid #1f1f1f;">
                                                            <span class='num'>{{$val->nineteen}}</span>
                                                        </td>
                                                        <td><span class='num'>{{$val->nineteenc}}</span></td>
                                                        <td><span class='num'>{{$val->nineteenapp}}</span></td>
                                                        <td style="border-left:1px solid #1f1f1f;">
                                                            <span class='num'>{{$val->twenty}}</span>
                                                        </td>
                                                        <td><span class='num'>{{$val->twentyc}}</span></td>
                                                        <td><span class='num'>{{$val->twentyapp}}</span></td>
                                                           <td style="border-left:1px solid #1f1f1f;">
                                                            <span class='num'>{{$val->twentyone}}</span>
                                                        </td>
                                                        <td><span class='num'>{{$val->twentyonec}}</span></td>
                                                        <td><span class='num'>{{$val->twentyoneapp}}</span></td>
                                                    </tr>
                                                    @endif
                                                    @endforeach
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- end content-->
                                        </div>
                                        <!-- end wrap div -->
                                    </div>
                                    <!-- end widget -->
                                </article>
                        </div>





                </section>
                <!-- end widget grid -->
            
            </div>    
            
            <!--RIGHT SIDE WIDGETS-->
        <aside class="right">
          
              
        </aside>
        <!--END RIGHT SIDE WIDGETS-->

        </div>
        <!-- end main content -->
    </div>
</div><!--end fluid-container-->
<div class="push"></div>
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>



<script src="{{URL::to_asset('js/include/guage.min.js')}}"></script>
<script src="{{URL::to_asset('js/libs/jQRangeSlider-5.4.0/jQDateRangeSlider-withRuler-min.js')}}"></script>

<script>
@if(!empty($stats))
$(function () {
    $('#container').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: true,
            margin: [0, 0, 0, 0],
        spacingTop: 0,
        spacingBottom: 0,
        spacingLeft: 0,
        spacingRight: 0
        },
        title: {
            text: ''
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                size:'54%',
                dataLabels: {
                    enabled: true,
                    color: '#000000',
                    connectorColor: '#ddd',
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Call Result',
            data: [
                ['DNC',   {{$stats[0]->dnc}}],
                 ['NI',    {{$stats[0]->ni}}],
                {
                    name: 'DEMOS',
                    y: {{$stats[0]->app}},
                    sliced: true,
                    selected: true
                },
                ['NQ',    {{$stats[0]->nq}}],
                ['Recall',   {{$stats[0]->dnc}}]
            ]
        }]
    });
});
@endif



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
  colorStart: '#00CF15',   // Colors
  colorStop: '#DA9900',    // just experiment with them
  strokeColor: '#5e5e5e',   // to see which ones work best for you
  generateGradient: true
};
var target = document.getElementById('teamsales'); // your canvas element
var gauge = new Gauge(target).setOptions(opts); // create sexy gauge!
gauge.maxValue = 100; // set max gauge value
gauge.animationSpeed = 18; // set animation speed (32 is default value)
gauge.set(gval); // set actual value
}

$(document).ready(function(){
var gval = $('#teamsales').data('value');
getguage(gval);

var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec"];
  $("#element").dateRangeSlider({
    bounds: {min: new Date(2012, 11, 1), max: new Date(2013, 11, 31, 12, 59, 59)},
    defaultValues: {min: new Date(2013, 8, 1), max: new Date(2013, 10, 1)},
    scales: [{
      first: function(value){ return value; },
      end: function(value) {return value; },
      next: function(value){
        var next = new Date(value);
        return new Date(next.setMonth(value.getMonth() + 1));
      },
      label: function(value){
        return months[value.getMonth()];
      },
      format: function(tickContainer, tickStart, tickEnd){
        tickContainer.addClass("myCustomClass");
      }
    }]
  });

$("#element").on("valuesChanged", function(e, data){
    var url = "../stats/booker";

    $.getJSON(url,{datemin:data.values.min, datemax:data.values.max},function(data){
        console.log(data);
        var html="";
        $('.doortable').html("");
        $('.papertable').html("");
        $('.othertable').html("");
        $('.closepercent').html("");
        $.each(data[0], function(i,val){
            var percent = (parseInt(val.rangeapp)/((parseInt(val.rangeapp) + parseInt(val.rangeni)))*100).toFixed(2);
            if(isNaN(percent)){
                percent=0;
            }
         
                html = "<tr><td>"+val.caller_id.toUpperCase()+"</td><td><center><span class='closepercent2 doorclose'>"+percent+"</span></center></td>";
                html+="<td><center><span class='label label-success white'>"+val.rangeapp+"</span></center></td>";
                html+="<td><center><span class='label label-important white'>"+val.rangeni+"</span></center></td>";
                html+="<td><center>"+val.rangenh+"</center></td><td><center>"+val.rangenq+"</center></td><td><center>"+val.rangednc+"</center></td><td><center>"+val.rangewrong+"</center></td><td><center>"+val.rangerecall+"</center></td><td><center>"+val.rangetot+"</center></td></tr>";
         if(val.leadtype=="door"){
                $('.doortable').append(html);
         } else if(val.leadtype=="paper"){$('.papertable').append(html);} else if(val.leadtype=="other"){$('.othertable').append(html);};

        });

        $.each(data[1], function(i,val){
              var percent = (parseInt(val.app)/((parseInt(val.app) + parseInt(val.ni)))*100).toFixed(2);
            if(isNaN(percent)){
                percent=0;
            }
            $('.totalcalls').html(val.tot);
            $('.appcalls').html(val.app);
            $('.nicalls').html(val.ni);
            $('.dnccalls').html(val.dnc);
            $('.nqcalls').html(val.nq);
            $('.totalclose').html(percent);
        });

        $('.closepercent2').each(function(){
        var t =$(this).html();
        if(t==0){
            $(this).html("");
        } else if(t<20) {$(this).addClass('label label-error');} else if((t>20)&&(t<45)){$(this).addClass('label label-warning');}
        else if((t>45)&&(t<65)){$(this).addClass('label label-success');} else if(t>65){$(this).addClass('label label-success special black');}
        $(this).html(t+"%");
        });
    });
});

$('.stats').each(function(){
var t =$(this).html();
if(t==0){
    $(this).html("");
} else {$(this).html("<center>"+t+"</center>");}
});

$('.filter').click(function(){
var name = $(this).data('id');
$('.filter').removeClass('btn-inverse active');
$(this).addClass('btn-inverse active');
$('.stattable').hide();
$('.'+name).addClass('animated fadeInUp').show();
});



$('.closepercent').each(function(){
var t =$(this).html();
if(t==0){
    $(this).html("");
} else if(t<20) {$(this).addClass('label label-error');} else if((t>20)&&(t<45)){$(this).addClass('label label-warning');}
else if((t>45)&&(t<65)){$(this).addClass('label label-success');} else if(t>65){$(this).addClass('label label-success special black');}
$(this).html(t+"%");


});




});
</script>

@endsection