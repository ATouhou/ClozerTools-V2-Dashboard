@layout('layouts/main')
@section('content')

<style>
#saleview {display:none;}
#submitpayform {display:none;}
#stats {display:none;}
</style>
      
<div id="main" role="main" class="container-fluid">
    <div class="contained">
        <!-- aside -->  
        <aside> 
            <!-- aside item: Mini profile -->
            @render('layouts.managernav')
            <!-- aside item: Menu -->
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
            <div class="divider"></div>
         
        </aside>
        <!-- aside end -->
                
                <!-- main content -->
                <div id="page-content">
            
                
                    <!-- page header -->
                    <h1>Sales Statistics for {{date('M-d', strtotime($date))}}</h1>   

                
                    
                    <div class="fluid-container">
                        
                   

                        
                        <!-- widget grid -->
                        <section id="widget-grid" class="">

                            
                            <div class="row-fluid" id="saleview">
                            <article class="span12">
                                    <!-- new widget -->
                                    <div class="jarviswidget black" data-widget-editbutton="false" data-widget-deletebutton="false" >
                                        <header>
                                            <h2>Viewing Sale # <span id="saleno"></span></h2>

                                        </header>
                                        <!-- wrap div -->
                                        <div>
                                        
                                          
            
                                            <div class="inner-spacer" style="padding:40px;"> 
                                                <h4>Sale # : <Span id="saleid"></span> </h4>
                                                <p>Sold by: <b><span id="rep">Fill here</span></b></p>
                                                <p>Date Sold: <b><span id="date">Fill here</span></b></p>
                                                <p>System Type: <b><span id="system">Super System</span></b></p>
                                                <hr>
                                                <table class="table table-bordered"
                                                >
                                                    <thead>
                                                        <tr><th>ITEM SKU#</th>
                                                            <th>Date Sold</th>
                                                            
                                                           
                                                            <th>PRICE</th>
                                                                                                                    
                                                       
                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody id="saledata">
                                                    
                                                    </tbody>
                                                </table>
                                            </div>
                                </div>
                            </article>
                            </div>

                       
                        
                            
                            
                            
                            
                            <div class="row-fluid" id="teamstats">

                                

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
                                            <h4 style="margin-top:8px;">DEMOS / SALES</h4>                       
                                        </header>
                                        <div>
                                        
                                            <div class="jarviswidget-editbox">
                                                <div>
                                                    <label>Title:</label>
                                                    <input type="text" />
                                                </div>
                                                <div>
                                                    <label>Styles:</label>
                                                    <span data-widget-setstyle="purple" class="purple-btn"></span>
                                                    <span data-widget-setstyle="navyblue" class="navyblue-btn"></span>
                                                    <span data-widget-setstyle="green" class="green-btn"></span>
                                                    <span data-widget-setstyle="yellow" class="yellow-btn"></span>
                                                    <span data-widget-setstyle="orange" class="orange-btn"></span>
                                                    <span data-widget-setstyle="pink" class="pink-btn"></span>
                                                    <span data-widget-setstyle="red" class="red-btn"></span>
                                                    <span data-widget-setstyle="darkgrey" class="darkgrey-btn"></span>
                                                    <span data-widget-setstyle="black" class="black-btn"></span>
                                                </div>
                                            </div>
            
                                            <div class="inner-spacer"> 
                                            <!-- content goes here -->

                                                <!-- sin chart -->
                                                
                                                <div id="barchart" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
                                                
                                            </div>
                                            
                                        </div>
                                    </div>


                                    <!-- new widget -->
                                    <div class="jarviswidget black"  data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
                                        <header>
                                            <h4 style="margin-top:8px;">MARKETING / BOOKINGS</h4>                       
                                        </header>
                                        <div>
                                        
                                            <div class="jarviswidget-editbox">
                                                <div>
                                                    <label>Title:</label>
                                                    <input type="text" />
                                                </div>
                                                <div>
                                                    <label>Styles:</label>
                                                    <span data-widget-setstyle="purple" class="purple-btn"></span>
                                                    <span data-widget-setstyle="navyblue" class="navyblue-btn"></span>
                                                    <span data-widget-setstyle="green" class="green-btn"></span>
                                                    <span data-widget-setstyle="yellow" class="yellow-btn"></span>
                                                    <span data-widget-setstyle="orange" class="orange-btn"></span>
                                                    <span data-widget-setstyle="pink" class="pink-btn"></span>
                                                    <span data-widget-setstyle="red" class="red-btn"></span>
                                                    <span data-widget-setstyle="darkgrey" class="darkgrey-btn"></span>
                                                    <span data-widget-setstyle="black" class="black-btn"></span>
                                                </div>
                                            </div>
            
                                            <div class="inner-spacer"> 
                                            <!-- content goes here -->

                                                <!-- sin chart -->
                                                
                                                
                                                <div id="marketingchart" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <!-- end widget -->
                                    
                                    <!-- new widget -->
                                   

                                </article>
                            </div>

                            <div class="row-fluid">

                            <article class="span12">
                                    <!-- new widget -->
                                    <div class="jarviswidget" data-widget-editbutton="false" data-widget-deletebutton="false" >
                                        <header>
                                            <h2>This Months Sales</h2>                           
                                        </header>
                                        <!-- wrap div -->
                                        <div>
                                        
                                          
            
                                            <div class="inner-spacer"> 
                                          
                                                <table class="table table-striped table-bordered responsive" id="dtable">
                                                    <thead>
                                                        <tr>
                                                             <th>Date</th>
                                                            <th>Customer Name</th>
                                                            <th>Payment Type</th>
                                                            <th>System</th>
                                                                                                                    
                                                            <th>Price</th>
                                                            <th>Sales Rep</th>
                                                            <th>Actions</th>
                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                     <!--@foreach($monthsales as $val)
                                                     <tr id="salerow-{{$val->id}}">
                                                         <td>{{$val->date}}</td>
                                                        <td>{{$val->cust_name}}</td>
                                                        <td>{{ucfirst($val->payment)}}</td>
                                                        <td>{{ucfirst($val->typeofsale)}}</td>
                                                        <td>${{$val->price}}</td>
                                                        <td>{{$val->sold_by}}</td>
                                                        <td><center><button class="btn btn-primary btn-mini "><i class="icon-pencil"></i></button>
                                                       <button class="btn btn-success btn-mini viewsale" data-id="{{$val->id}}"><i class="icon-eye-open"></i></button>
                                                  
                                                       <button class="btn btn-danger btn-mini deletesale" data-id="{{$val->id}}"><i class="icon-trash"></i></button></center></td>
                                                        
                                                     </tr>

                                                     @endforeach-->
                                                    </tbody>
                                                </table>
                                                    
                                            </div>
                                            <!-- end content-->
                                        </div>
                                        <!-- end wrap div -->
                                    </div>
                                    <!-- end widget -->
                                </article>
                      
















                                <article class="span6">
                                    
                                    <!-- new widget -->
                                    <div class="jarviswidget black"  data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
                                        <header>
                                            <h4 style="margin-top:8px;">TOP SALESPERSON THIS MONTH</h4>                           
                                        </header>
                                        <div>
                                        
                                          
            
                                            <div class="inner-spacer"> 
                                            <!-- content goes here -->
                                            <div id="gague-chart" class="indented">
                        <div id="g1"></div>
                        <div id="g2"></div>
                        <div id="g3"></div>
                        <div id="g4"></div>
                        <div id="g5" class="last"></div>
                        <div id="g6" class="last"></div>
                    </div>
                                                <div class="span12">
                                                
                                                        <h4></h4>
                                                        <div class="well">
                                                            
                                                            
                                                            <div class="progress progress-warning">
                                                                <div class="bar filled-text" data-percentage="75">
                                                                    75%
                                                                </div>
                                                            </div>
                                                            <div class="progress progress-danger">
                                                                <div class="bar filled-text" data-percentage="100">
                                                                    100%
                                                                </div>
                                                            </div>
                                                        </div>
                    
                                                    </div>
                                                    <!-- end span6 -->
                                            <!-- end content -->
                                            </div>
                                            
                                            
                                        </div>
                                    </div>
                                    <!-- end widget -->
                                </article>
                            </div>
                            
                            
                            
                            <!-- row-fluid -->
                            <div class="row-fluid" id="stats">
                            <article class="span6">
                                    <div class="jarviswidget black"  data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false">
                                        <header>
                                            <h4 style="margin-top:8px;">YOUR SALES THIS MONTH</h4>                           
                                        </header>
                                        <div>
                                        
                                           
            
                                            <div class="inner-spacer"> 
                                            <!-- content goes here -->

                                                <!-- chart -->
                                                <div id="bar-graph"></div>

                                            </div>
                                            
                                        </div>
                                    </div>
                                </article>

                                <article class="span6">
                                    <div class="jarviswidget black"  data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false" >
                                        <header>
                                            <h4 style="margin-top:8px;">YOUR SALES BY SYSTEM</h4>                           
                                        </header>
                                        <div>
                                        
                                            
            
                                            <div class="inner-spacer"> 
                                            <!-- content goes here -->

                                                <!-- chart -->
                                                <div id="donut-graph"></div>

                                            </div>
                                            
                                        </div>
                                    </div>
                                </article>
                            
                            
                            <div class="row-fluid">
                                <article class="span12">
                                    <div class="jarviswidget black" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false" >
                                        <header>
                                             <h4 style="margin-top:8px;">Your Monthly Sales by System</h4>                           
                                        </header>
                                        <div>
                                        <div class="inner-spacer"> 
                                            <div id="sales-graph"></div>
                                        </div>
                                        </div>
                                    </div>
                                </article>
                            </div>
                            
                            
                            
                            
                            </div>
                            
                             <div class="row-fluid" id="salestable">
                            <article class="span12">
                                    <!-- new widget -->
                                    <div class="jarviswidget" data-widget-editbutton="false" data-widget-deletebutton="false" >
                                        <header>
                                            <h2>This Months Sales</h2>                           
                                        </header>
                                        <!-- wrap div -->
                                        <div>
                                        
                                          
            
                                            <div class="inner-spacer"> 
                                          
                                                <table class="table table-striped table-bordered responsive" id="dtable">
                                                    <thead>
                                                        <tr>
                                                                <th>Date</th>
                                                            <th>Customer Name</th>
                                                            <th>Payment Type</th>
                                                            <th>System</th>
                                                                                                                    
                                                            <th>Price</th>
                                                            <th>Sales Rep</th>
                                                            <th>Actions</th>
                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                     @foreach($monthsales as $val)
                                                     <tr id="salerow-{{$val->id}}">
                                                         <td>{{$val->date}}</td>
                                                        <td>{{$val->cust_name}}</td>
                                                        <td>{{ucfirst($val->payment)}}</td>
                                                        <td>{{ucfirst($val->typeofsale)}}</td>
                                                        <td>${{$val->price}}</td>
                                                        <td>{{$val->sold_by}}</td>
                                                        <td><center><button class="btn btn-primary btn-mini "><i class="icon-pencil"></i></button>
                                                       <button class="btn btn-success btn-mini viewsale" data-id="{{$val->id}}"><i class="icon-eye-open"></i></button>
                                                  
                                                       <button class="btn btn-danger btn-mini deletesale" data-id="{{$val->id}}"><i class="icon-trash"></i></button></center></td>
                                                        
                                                     </tr>

                                                     @endforeach
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
                </div>
                <!-- end main content -->
            
                <!-- aside right on high res -->
                <aside class="right">
                    
                    <!-- sparkline stats -->
                    <ul class="mystats indented">
                        <li class="first">
                            <h1><span>THIS WEEK:</span>$</h1>
                            <div class="mychart" id="balance" style="width:35px"></div>
                        </li>
                         <li>
                            <h1><span>UNITS:</span></h1>
                            <div class="mychart" id="subscribe" style="width:35px"></div>
                        </li>
                        <li >
                            <h1><span>THIS MONTH:</span>$ </h1>
                            <div class="mychart" id="clicks" style="width:35px"></div>
                        </li>
                        <li class="last">
                            <h1><span>UNITS:</span></h1>
                            <div class="mychart" id="subscribe" style="width:35px"></div>
                        </li>
                       
                        
                    </ul>
                    <div class="divider"></div>
                    <h2 class="shadow">Pick a Date to Analyze</h2>
            <div id="datefilter" class="shadow" style="background:#1f1f1f;border-radius:12px"></div>

                
                    <!-- end date picker -->
                        <div class="divider"></div>
                    @render('layouts.chat')
                    
                </aside>
                
                <!-- end aside right -->
            </div>
            
        </div><!--end fluid-container-->
        <div class="push"></div>
    </div>
    <!-- end .height wrapper -->
    


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