@layout('layouts/main')
@section('content')
      
<div id="main" role="main" class="container-fluid">
    <div class="contained">
        <!-- LEFT SIDE WIDGETS & MENU -->
        <aside> 
            @render('layouts.managernav')


       </aside>
        <!-- END WIDGETS -->
                
        <!-- MAIN CONTENT -->
        <div id="page-content" >
            <h1 id="page-header">Sales History</h1>
            <a href=""><button class="btn btn-mini">{{date('M Y',strtotime('-12 Month'))}}</button></a>
            <a href=""><button class="btn btn-mini">{{date('M Y',strtotime('-11 Month'))}}</button></a>
            <a href=""><button class="btn btn-mini">{{date('M Y',strtotime('-10 Month'))}}</button></a>
            <a href=""><button class="btn btn-mini">{{date('M Y',strtotime('-9 Month'))}}</button></a>
            <a href=""><button class="btn btn-mini">{{date('M Y',strtotime('-8 Month'))}}</button></a>
            <a href=""><button class="btn btn-mini">{{date('M Y',strtotime('-7 Month'))}}</button></a>
            <a href=""><button class="btn btn-mini">{{date('M Y',strtotime('-6 Month'))}}</button></a>
            <a href=""><button class="btn btn-mini">{{date('M Y',strtotime('-5 Month'))}}</button></a>
            <a href=""><button class="btn btn-mini">{{date('M Y',strtotime('-4 Month'))}}</button></a>
            <a href=""><button class="btn btn-mini">{{date('M Y',strtotime('-3 Month'))}}</button></a>
            <a href=""><button class="btn btn-mini">{{date('M Y',strtotime('-2 Month'))}}</button></a>
            <a href=""><button class="btn btn-mini">{{date('M Y',strtotime('-1 Month'))}}</button></a>
            <a href=""><button class="btn btn-mini">{{date('M Y')}}</button></a>
            <div class="fluid-container">
            
                <!-- widget grid -->
                <section id="widget-grid" class="" style="margin-top:40px;">

                    <div class="jarviswidget black" data-widget-editbutton="false" data-widget-deletebutton="false"
                                    data-widget-fullscreenbutton="false" data-widget-togglebutton="false" >
                                        <header>
                                            <h2>INVENTORY</h2>                           
                                        </header>
                                        <!-- wrap div -->
                                        <div>
                                            <div class="inner-spacer"> 
                                                <table class="table table-bordered responsive" id="dtable3" >
                                                     <thead>
                                                        <tr>
                                                            <th>SUBMITTED ON</th>
                                                            <th>TYPE OF SALE</th>
                                                            <th style="width:8%;">SKU #'s</th>
                                                            <th>DEFERRAL</th>
                                                            <th>PAYMENT</th>
                                                            <th style="width:10%;">PRICE</th>
                                                            <th style="width:10%;">Payout</th>
                                                            <th style="width:20%;">STATUS</th>
                                                            <th style="width:10%;">ACTIONS</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(!empty($allsales))
                                                    @foreach($allsales as $val)

                                                 
                                                    <tr id="salerow-{{$val->id}}">
                                                        <td>{{date("M-d", strtotime($val->submission_date))}} by<br/><span class="label label-info">{{$val->sold_by}}</span></td>
                                                        <td>{{strtoupper($val->typeofsale)}}</td>
                                                        <td>{{$val->skus}}
                                                         <td>
                                                            {{$val->deferal}}
                                                        </td>
                                                        <td>
                                                           {{$val->payment}}
                                                        </td>
                                                        <td><span>$</span><span class="edit" id="price|{{$val->id}}">{{$val->price}}</span></td>
                                                        <td><span>$</span><span class="edit" id="payout|{{$val->id}}">{{$val->payout}}</span></td>
                                                       <td>{{$val->status}}</td>
                                                        <td><center>
                                                       <a href="{{URL::to('sales/view/')}}{{$val->id}}" <button class="btn btn-default btn-small approve"><i class="cus-accept"></i>&nbsp;&nbsp;VIEW SALE</button></a>
                                                      </center></td>
                                                       
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



                    <div class="row-fluid" id="teamstats" style="margin-top:50px;">

                                

                            <article class="span4">
                                
                                    <!-- new widget -->
                                    <div class="jarviswidget black"  data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false" >
                                        <header>
                                            <h4 style="margin-top:8px;">TEAMS STATS FOR THE MONTH</h4>                           
                                        </header>
                                        <div>
                                            <div class="inner-spacer" style="padding:20px;">
                                                <center>
                                                <h4>SALES TEAM CLOSE PERCENT</h4>
                                             <canvas id="teamsales" data-value="{{$monthstats['closeratio']}}"></canvas> <br><span class="shadow" style="font-size:30px;">{{$monthstats['closeratio']}}%</span><br><br><hr>
                                             <h4>We made 
                                                <span style="padding-left:6px;padding:5px;background:#1f1f1f;color:#fff;border-radius:4px;">{{$monthstats['monthsales']}} </span> &nbsp;sales this month</h4>
                                                <hr></center>
                                                

                                            </div>
                                        </div>
                                    </div>
                                    <!-- end widget -->
                                    <div class="jarviswidget black"  data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false" >
                                        <header>
                                            <h4 style="margin-top:8px;">SALES REP OVERVIEW STATS</h4>                           
                                        </header>
                                        <div>
                                            <div class="inner-spacer" style="padding:20px;">
                                              
                                                                                               
                                                @foreach($monthstats['repnumbers'] as $val)
                                                <div class="topsalesbox">

                                                            <h4 class="shadow">{{$val['repname']}}</h4>
                                                            <span class="label label-info">{{$val['demos']}} Demos</span>
                                                            <span class="label label-success">{{$val['sales']}} Sales</span>
                                                            @if($val['inc']!=0)
                                                            <span class="label label-danger">{{$val['inc']}} Incomplete</span>
                                                            @endif
                                                            <h5>Close Percentage</h5>
                                                            <div class="progress progress-success" style="margin-top:10px;">
                                                                <div class="bar filled-text" data-percentage="{{$val['closepercent']}}">
                                                                    {{$val['closepercent']}}%
                                                                </div>
                                                            </div>

                                                            </div>
                                                            @endforeach


                                            </div>
                                        </div>
                                    </div>
                                    <!-- end widget -->
                                </article>


                                <article class="span8">

                                  
                                    
                                    <!-- new widget -->
                                    <div class="jarviswidget black"  data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
                                        <header>
                                            <h4 style="margin-top:8px;">DEMOS PUT ON vs SALES</h4>                       
                                        </header>
                                        <div>
                                        
                                           
            
                                            <div class="inner-spacer"> 
                                            <!-- content goes here -->

                                                <!-- sin chart -->
                                                
                                                <div id="barchart" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
                                                
                                            </div>
                                            
                                        </div>
                                    </div>


                                  
                                    
                                    <!-- new widget -->
                                   

                                </article>
                            </div>
                </section>
                <!-- end widget grid -->
            
            </div>    
            
            <!--RIGHT SIDE WIDGETS-->
        <aside class="right">
            <ul class="indented aside-progress-stats">
                    <h4>Sales Rep Close %</h4>
                    @foreach($monthstats['repnumbers'] as $val)
                        <?php if($val['closepercent']>30){$progress="progress-success";}
                        elseif(($val['closepercent']<30)&&($val['closepercent']>10)){$progress="progress-info";} elseif($val['closepercent']<10){$progress="progress-success";};?>
                        
                        @if($val['closepercent']!=0)
                        <li>
                            <strong>{{$val['repname']}}</strong><strong class="pull-right">{{$val['closepercent']}}%</strong>
                            <div class="progress {{$progress}} slim"><div class="bar" data-percentage="{{$val['closepercent']}}"></div></div>
                        </li>
                        @endif
                        @endforeach
                </ul>
                 <div class="number-stats">
                <ul>
                    <li><span>{{str_replace("-","", strtoupper(date('M-d', strtotime($date))))}}</span>{{$monthstats['todayssales']}} <span>sales</span></li>
                    <li><span>MONTH</span>{{$monthstats['monthsales']}}<span>sales</span></li>
                    <li><span>GOAL</span>25<span>sales</span></li>
                </ul>
            </div>

            <div class="divider"></div>
                 
            <ul class="indented aside-progress-stats">       
                <li>
                    <div class="easypie">
                        <div class="percentage" data-percent="{{$monthstats['closeratio']}}">
                            <span>{{$monthstats['closeratio']}}</span>%
                        </div>
                        <div class="easypie-text">
                            CURRENT MONTHLY GOAL
                        </div>
                    </div>
                </li>
            </ul>

            <div class="divider"></div> 
        </aside>
        <!--END RIGHT SIDE WIDGETS-->

        </div>
        <!-- end main content -->
    </div>
</div><!--end fluid-container-->
<div class="push"></div>
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

$('#salesmenu').addClass('expanded');
var gval = $('#teamsales').data('value');
getguage(gval);

$('.deletesale').click(function(){
   var id=$(this).data('id');
   if(confirm("Are you sure you want to delete this sale?")){
   var url = "sales/deletesale/"+id;
   $.getJSON(url, function(data) {
     $('#salerow-'+id).hide();
    });
    }
});

$('.viewsale').click(function(){
var id= $(this).data('id');
var url = "sales/viewsale/"+id;
   $.getJSON(url, function(data) {
    var data = data.attributes;
    $('span#saleid').html(data.id);
    $('span#price').html(data.price);
    $('span#date').html(data.date);
    $('span#rep').html(data.sold_by);
    var sale = data.typeofsale.charAt(0).toUpperCase() + data.typeofsale.slice(1)
    $('span#system').html(sale);

    var html = "<tr><td>"+data.sku+"</td><td>"+data.date+"</td><td>"+data.price+"</td></tr>";
    $('#saledata').html(html);
    $('#saleview').hide();
    $('#saleview').fadeIn(300);
  });           
});
});
</script>   
<script type="text/javascript">
$(function () {
    var chart;

$(document).ready(function() {

var url = "{{URL::to('stats/demovssales')}}";
$.ajax({
  dataType: "html",
  url: url,
  success: function(data){
   var dat = JSON.parse(data);
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'barchart',
                type: 'column'
            },
            title: {
                text: 'DEMOS vs SALES'
            },
            xAxis: {
                categories: []
            },
            yAxis: {
                min: 0,
                title: {
                    text: ''
                },
                stackLabels: {
                    enabled: true,
                    
                    style: {
                        fontWeight: 'bold',
                        color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'
                    },
                    
                }
            },
            legend: {
                align: 'right',
                x: -50,
                verticalAlign: 'top',
                y: 40,
                floating: true,
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColorSolid) || 'white',
                borderColor: '#ddd',
                borderWidth: 1,
                shadow: true
            },
            tooltip: {
                formatter: function() {
                    return '<b>'+ this.x +'</b><br/>'+
                        this.series.name +': '+ this.y +'<br/>'+
                        'Total: '+ this.point.stackTotal;
                }
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true,
                        color: 'black',
                        fontWeight: 'bold',

                    }
                }
            },
            series: [{
                name: 'DEMOS',
                data: dat.demos,
                color: '#006699'
            }, {
                name: 'SALES',
                data: dat.sales,
                color: '#00FF00'
            }]
        });
  }
});

  });
    
});
</script>
<script type="text/javascript">
$(function () {
    var chart;

$(document).ready(function() {
var url = "{{URL::to('stats/callsvsbooks')}}";
$.ajax({
  dataType: "html",
  url: url,
  success: function(data){

   var dat = JSON.parse(data);
   console.log(dat);
   var appointmentsbooked = [2,3,2,1,4,2,3,2,5,6];
   var callsmade = [22,33,23,34,23,12,24,33,55,66];
      chart = new Highcharts.Chart({
            chart: {
                renderTo: 'marketingchart',
                type: 'line',
                marginRight: 130,
                marginBottom: 25
            },
            title: {
                text: 'Marketing Efforts',
                x: -20 //center
            },
            subtitle: {
                text: '',
                x: -20
            },
            xAxis: {
                categories: []
            },
            yAxis: {
                title: {
                    text: 'Leads'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                formatter: function() {
                        return '<b>'+ this.series.name +'</b><br/>'+
                        this.x +': '+ this.y +'°C';
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -10,
                y: 100,
                borderWidth: 0
            },
            series: [{
                name: 'Leads Called',
                data: dat.called
            }, {
                name: 'Appointments Booked',
                data: dat.booked
            }]
        });
      }
});
});
});
</script>
<script type="text/javascript">
$(function () {
    var chart;
    $(document).ready(function() {
    });
});
</script>
@endsection