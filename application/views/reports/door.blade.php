@layout('layouts/main')
@section('content')
<style>

.processapp{width:90%!important;}
.bignum3{font-size:12px;padding:5px;}
.thedate{padding:2px;padding-left:10px;padding-right:10px;background: #4c4c4c; /* Old browsers */
background: -moz-linear-gradient(top,  #4c4c4c 0%, #595959 12%, #666666 25%, #474747 39%, #2c2c2c 50%, #000000 51%, #111111 60%, #2b2b2b 76%, #1c1c1c 91%, #131313 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#4c4c4c), color-stop(12%,#595959), color-stop(25%,#666666), color-stop(39%,#474747), color-stop(50%,#2c2c2c), color-stop(51%,#000000), color-stop(60%,#111111), color-stop(76%,#2b2b2b), color-stop(91%,#1c1c1c), color-stop(100%,#131313)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #4c4c4c 0%,#595959 12%,#666666 25%,#474747 39%,#2c2c2c 50%,#000000 51%,#111111 60%,#2b2b2b 76%,#1c1c1c 91%,#131313 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #4c4c4c 0%,#595959 12%,#666666 25%,#474747 39%,#2c2c2c 50%,#000000 51%,#111111 60%,#2b2b2b 76%,#1c1c1c 91%,#131313 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #4c4c4c 0%,#595959 12%,#666666 25%,#474747 39%,#2c2c2c 50%,#000000 51%,#111111 60%,#2b2b2b 76%,#1c1c1c 91%,#131313 100%); /* IE10+ */
background: linear-gradient(to bottom,  #4c4c4c 0%,#595959 12%,#666666 25%,#474747 39%,#2c2c2c 50%,#000000 51%,#111111 60%,#2b2b2b 76%,#1c1c1c 91%,#131313 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#4c4c4c', endColorstr='#131313',GradientType=0 ); /* IE6-9 */
color:#fff;border-radius:4px;}
.result {color:#000;margin-left:10px;padding:3px;font-weight:bold;border-radius:3px;}
.NI{background: #FF5050;!importantcolor:#000;}
.CXL {background:#FF5050;!important}
.NH{background:#0099FF;!important}
.NQ{background:#FFCCCC;!important}
.Recall{background: #FFA347;!important}
.CONF{background:#99FF99;!important}
.DNC{background: #CC8080;!important}
.INC {background:#FFCC99;!important}
.DNS{background:#1f1f1f;color:red;!important}
.NA{background:#aaa;!important}
.SOLD{background:green;!important}
.APP{background:#fff;}
.BUMP {background:#CCCCFF;!important}
.ASSIGNED{background:#0099FF;!important}
.DISP{background:#66CCFF;!important}
.NEW{background:#D6D6C2;!important}
.RB-TF{background:#FF99CC;!important}
.RB-OF{background:#FF99CC;!important}
div.jGrowl.myposition {
 position: absolute;
 font-size:200%;
 margin-left:150px;
 top: 20%;
}
.rightbutton{float:right;margin-top:10px;margin-right:10px;}
#bigmapview {
	background:white;
	width:100%;height:1000px;
	margin-top:-20px;
	display:none;position:absolute;z-index:25000;
	margin-left:-50px;

}
.cityList {
	background:#eee;
	border-right:1px solid;
	width:100%;
	z-index:50000;
	width:200px;
	height:10000px;
	position:absolute;
	padding:10px;
	padding-bottom:20px;
	overflow:scroll;

}
#BIGMAP {
	width:100%;
	height:1000px;
}
#bigmaploader {
	padding-left:500px;
	padding-top:100px;
	display:none;
}



</style>

<?php $setting = Setting::find(1);
$dollar_amount = $setting->reggie_rate;
;?>
<div id="main"  class="container-fluid lightPaperBack" style="min-height:1000px;padding:45px;padding-top:30px;padding-bottom:800px;">
	<div id="bigmapview" >
		<div class='cityList subtle-shadow' >
			<h4 >Choose a City</h4>
			<?php $cities = City::where('status','!=','leadtype')->order_by('cityname')->get();?>
			@foreach($cities as $c)
			<button class='btn btn-default btn-small loadCity' data-cityname='{{$c->cityname}}' data-id='{{$c->id}}' style='margin-top:5px; padding:2px;'>{{$c->cityname}}</button>
			@endforeach
			
			<br/><br/><br/><hr/>
			<h5>Legend</h5>
			<img src='{{URL::to_asset("img/door-regy2.png")}}'> &nbsp;&nbsp; - Available / New<br/>
			<img src='{{URL::to_asset("img/door-regy1.png")}}'> &nbsp;&nbsp; - Appointment<br/>
			<img src='{{URL::to_asset("img/door-regy5.png")}}'> &nbsp;&nbsp; - SOLD <br/>
			<img src='{{URL::to_asset("img/door-regy4.png")}}'> &nbsp;&nbsp; - NI / NQ / DNS<br/>
		
		</div>
	<div class="backtodash" >
  		<button class="btn btn-danger btn-large animated fadeInUp " style="border:1px solid #1f1f1f; padding:20px;margin-top:-200px;" onclick="$('.demoTable').hide(200);$('#bigmapview').hide();$('.infoHover').hide();" >
  			<i class="cus-cancel"></i>&nbsp;&nbsp;BACK TO REPORTS
	  	</button>
  	</div>

    	<div class="largeMap">
    		<div id="bigmaploader">
    			<img src='{{URL::to_asset("img/loaders/misc/500.gif")}}'>
    		</div>
    		<div id="BIGMAP" >
    			<div class='please_load' style='margin-left:400px;margin-top:200px;'><h1><img class='animated fadeInUp' src='{{URL::to_asset("img/arrow.png")}}'> &nbsp;&nbsp; PLEASE CLICK A CITY TO VIEW</div>
    		</div>
    	</div>
	</div>
				<h3>{{$title}}
				@include('plugins.reportmenu')
				</h3>
      				<div class="well row-fluid">
                        <form method="get" action="" id="dates" name="dates"/>
            	FROM : 
            	<div class="input-append date" style="margin-top:5px;" id="datepicker-js" data-date="{{$startdate}}" data-date-format="yyyy-mm-dd">
                		<input class="datepicker-input" size="16" id="startdate" name="startdate" type="text" value="{{$startdate}}" placeholder="Select a date" />
                		<span class="add-on"><i class="cus-calendar-2"></i></span>
            	</div>
            	&nbsp;&nbsp;TO : 
            	<div class="input-append date" style="margin-top:5px;" id="datepicker-js" data-date="{{$enddate}}" data-date-format="yyyy-mm-dd">
                		<input class="datepicker-input" size="16" id="enddate" name="enddate" type="text" value="{{$enddate}}" placeholder="Select a date" />
                		<span class="add-on"><i class="cus-calendar-2"></i></span>
            	</div>
            	
            	<button class="btn btn-default generateReport" style="margin-left:20px;margin-top:-6px;">
            		<i class="cus-application-view-tile"></i>&nbsp;GENERATE REPORT
            	</button>

            	
            	
        	
            	</form>
            	<button class="btn btn-primary pull-right viewReggieHistory" style="margin-right:16px;margin-top:-38px;">
            		<i class="cus-application-view-tile"></i>&nbsp;VIEW REGGIE HISTORY BY CITY
            	</button>
                    </div>

                    	<div class="row-fluid">
                            
           					<div class="span6">
                    <br/>

                                <table class="table apptable table-condensed" >
                                <thead>
                                    <tr style="background:#1f1f1f;color:#fff;">
                                        <th>DOOR REGGIER</th>

                                        <th>Complete</th>
                                        <th>Valid</th>
                                        <th>Wrong</th>
                                        <th>Renters</th>
                                        <th>Booked</th>
                                        <th>Put On</th>
                                        <th>SOLD</th>
                                        <th>DNS</th>
                                        <th>Gross</th>
                                        <th>Wrong # / Renters</th>
                                        <th>OWED</th>
                                    </tr>
                                </thead>
                                <tbody>
                                 <?php $total=0;$totputon=0;$totsold=0;$totvalid=0;$totwrong=0;$totrenters=0;
                                 $tottotal=0;$totavail=0;$totunreleased=0;$totdnc=0;$totni=0;$totbooked=0;$totdns=0;
                                 $reggiers=array();$gross=0;$rent=0;$wrong=0;$totalwrong=0;
                                 $totgross=0;$totwrong=0;$totowed=0;?>
                                @foreach($doorreports as $val)
                                <?php $u = User::find($val->researcher_id);?>
                                @if($u)
                                 
                                   <?php $tottotal=$tottotal+$val->total; 
                                 $totputon=$totputon+$val->puton;$totsold=$totsold+$val->sold;$totdns=$totdns+$val->dns;
                                  $totni=$totni+$val->ni;$totdnc=$totdnc+$val->dnc;
                                 $totavail=$totavail+$val->avail;$totunreleased=$totunreleased+$val->unreleased;$totbooked=$totbooked+$val->booked;
                                 $totvalid=$totvalid+$val->valid;$totwrong=$totwrong+$val->wrong;$totrenters=$totrenters+$val->renters;?>
                                 <?php $gross=number_format($val->total*$dollar_amount,2,'.','');$wrong=number_format($val->wrong*-$dollar_amount,2,'.','');
                                $rent=number_format($val->renters*-$dollar_amount,2,'.','');
                                $totgross=$totgross+$gross;
                                $totalwrong = $totalwrong+$wrong+$rent;
                                $totowed=$totowed+($gross+$wrong+$rent);
                                $reggiers['names'][] = $val->researcher_name;
                                $reggiers['sold'][] = intval($val->sold);
                                $reggiers['booked'][] = intval($val->booked);
                                $reggiers['puton'][]=intval($val->puton);
                                $reggiers['wrong'][]=intval($val->wrong);
                                $reggiers['total'][]=intval($val->total);
                                $reggiers['renters'][]=intval($val->renters);
                                if($u->user_type=="doorrep"){$usertype="Reggier";} 
                                else if($u->user_type=="manager"){$usertype="Manager";}
                                else if($u->user_type=="salesrep"){$usertype="Dealer";}
                                else if($u->user_type=="agent"){$usertype="Marketer";}
                                else {$usertype=="Other";};

                                ?>

                                <tr class="{{$usertype}}">
                                    <td>
                                    	&nbsp;&nbsp;<b>{{$val->researcher_name}}</b>
                                      <br/>
                                      &nbsp;&nbsp;<span style='font-size:12px;'>{{$usertype}}</span>
                                    </td>
                                    <td><center>{{$val->total}}</center></td>
                                    <td><center>@if($val->valid!=0) <span class="label bigtext label-success">{{$val->valid}} </span>@endif</center></td>
                                    <td><center>@if($val->wrong!=0)<span class="label bigtext label-important">{{$val->wrong}} </span> @endif</center></td>
                                    <td><center>@if($val->renters!=0)<span class="label bigtext label-important special">{{$val->renters}}</span> @endif</center></td>
                                     <td><center>@if($val->booked!=0)<span class="label bigtext label-warning special blackText">{{$val->booked}}</span> @endif</center></td>
                                    <td><center>@if($val->puton!=0)<span class="label bigtext label-info special">{{$val->puton}}</span> @endif</center></td>
                                    <td><center>@if($val->sold!=0)<span class="label bigtext label-success blackText special">{{$val->sold}}</span> @endif</center></td>
                                    <td><center>@if($val->dns!=0)<span class="label bigtext label-important special">{{$val->dns}}</span> @endif</center></td>
                                    <td><center>$<span class="payrate">{{$gross}}</span></center></td>
                                    <td><center>$<span class="payrate">{{number_format($wrong+$rent,2,'.','')}}</span></center></td>
                                    <td><center>$<span class="owed"><strong>{{number_format(($gross+$wrong+$rent),2,'.','')}}</strong></span></center></td>
                                </tr>
                                @endif
                                @endforeach

                                 <tr style="height:30px;">
                                	<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                                </tr>
                                <tr style="background:#ccc;">
                                	  <td>TOTALS</td>
                                    <td><center>{{$tottotal}}</center></td>
                                    <td><center>@if($totvalid!=0) <span class="label bigtext label-success">{{$totvalid}} </span>@endif</center></td>
                                    <td><center>@if($totwrong!=0)<span class="label bigtext label-important">{{$totwrong}} </span> @endif</center></td>
                                    <td><center>@if($totrenters!=0)<span class="label bigtext label-important special">{{$totrenters}}</span> @endif</center></td>
                                    <td><center>@if($totbooked!=0)<span class="label bigtext label-warning blackText special">{{$totbooked}} </span> @endif</center></td>
                                    <td><center>@if($totputon!=0)<span class="label bigtext label-info special">{{$totputon}} </span> @endif</center></td>
                                    <td><center>@if($totsold!=0)<span class="label bigtext label-success blackText special">{{$totsold}}</span> @endif</center></td>
                                    <td><center>@if($totdns!=0)<span class="label bigtext label-important special">{{$totdns}}</span> @endif</center></td>
                                    <td><center>@if($totgross!=0)${{number_format($totgross,2,'.','')}}@endif</center></td>
                                    <td><center>@if($totwrong!=0)${{number_format($totalwrong,2,'.','')}}@endif</center></td>
                                    <td><center>@if($totowed!=0)${{number_format($totowed,2,'.','')}} @endif</center></td>

                                </tr>
                                </tbody>
                            </table>
                            <br/>
                            <div class="row-fluid" style="margin-top:10px;border-bottom:1px solid #ddd;padding-bottom:20px;">
                          	<div style="float:left;width:20%;margin-left:20px;">
                                 BOOK PERCENT %<br/>
                                 <span class="dailystats2 PUTON" style="border:1px solid #1f1f1f;border-radius:4px;padding:8px;font-size:16px;color:#000;">
                                 @if(($tottotal!=0)&&($totbooked!=0)) {{number_format($totbooked/$tottotal*100,2,'.','')}} @else 0 @endif %
                                 </span>
                            </div>
                            <div style="float:left;width:20%;margin-left:20px;">
                                  HOLD PERCENT %<br/>
                                   <span class="dailystats2 PUTON" style="border:1px solid #1f1f1f;border-radius:4px;padding:8px;font-size:16px;color:#000;">
                                @if(($totputon!=0)&&($totbooked!=0)) {{number_format($totputon/$totbooked*100,2,'.','')}} @else 0 @endif %
                                </span>
                            </div>
                            <div style="float:left;width:20%;margin-left:20px;">
                                 CLEAR PERCENT % <br/>
                                 <span class="dailystats2 PUTON" style="border:1px solid #1f1f1f;border-radius:4px;padding:8px;font-size:16px;color:#000;">
                                @if(($totputon!=0)&&($totsold!=0)) {{number_format($totsold/$totputon*100,2,'.','')}} @else 0 @endif %
                                </span>
                            </div>
                      </div>
                      <br/>
                            <div class="row-fluid">
                            	<div id="cont" style="float:left;width:50%;height:400px;"></div>
                            	<div id="pie" style="float:left;width:45%;margin-left:30px;height:400px;"></div>
                            </div>

                        </div>
                           <div class="span6 well" >
                            <button class='btn btn-success filter' data-status="SOLD">SHOW SOLD</button>
                           	<button class='btn btn-danger  filter' data-status="DNS">SHOW DNS</button>
                           	<button class='btn btn-primary filter' data-status="APP">SHOW APPOINTMENTS</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                           	<button class='btn btn-warning btn-small blackText filter' data-status="NEW">AVAILABLE</button>
                           	<button class='btn btn-inverse btn-small redText filter' data-status="INACTIVE">UNRELEASED</button>
                           	<button class='btn btn-success blackText btn-small filter' data-status="ASSIGNED">ASSIGNED</button><br/><br/>
	                            	<div  id="maptwo" style="height:510px;width:100%;border:1px solid #1f1f1f;border-radius:20px;"></div>
                        </div>
                    </div>
                   @if($setting->numerology==1)
                    <div class="row-fluid" >
                    	<div class="span6">

                    	<div id="close_numerology" style="float:left;width:100%;margin-left:30px;height:400px;"></div><br/>
                    	</div>
                    	<div class="span6">
                    	<div id="add_numerology" style="float:left;width:100%;margin-left:30px;height:400px;"></div><br/>
                    	</div>
                    	
                    	
                    </div>
                    @endif
                    
                     
                    


</div>
<div class="push"></div>

<?php $addtotal=0;
if(!empty($numero)){
	foreach($numero['address'] as $k=>$n){
	if($k!=0){
		$addtotal=intval($addtotal)+intval($n->booked);
		$add_num['numbers'][] = intval($n->add_numerology);
		$add_num['sold'][]=intval($n->sold);
		$add_num['avgsold'][]=intval($n->avgsold);
		if($n->sold!=0){
			$add_num['close'][]=(intval($n->sold)/intval($n->dns)*100);
		}
		$add_num['dns'][]=intval($n->dns);
		$add_num['book'][]=intval($n->booked);
		$add_num['ni'][]=intval($n->ni);

	}
	
	};

	echo $addtotal."<br>";
	$numtotal=0;
	foreach($numero['number'] as $k=>$n){
	if($k!=0){
		$numtotal=$numtotal+intval($n->booked);
		$num['numbers'][] = intval($n->num_numerology);
		$num['sold'][]=intval($n->sold);
		$num['avgsold'][]=intval($n->avgsold);
		$num['dns'][]=intval($n->dns);
		$num['book'][]=intval($n->booked);
		if($n->sold!=0){
			$num['close'][]=(intval($n->sold)/intval($n->dns)*100);
		}
		
		
		
		$num['ni'][]=intval($n->ni);
	}
	};
}


?>


<script src="{{URL::to_asset('js/highcharts.js')}}"></script>
<script src="{{URL::to_asset('js/include/gmap3.min.js')}}"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&amp;language=en"></script>

<script>
$(document).ready(function(){
@if($setting->numerology==1)
	       
     	          $('#add_numerology').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Address DNS vs SOLD Numerology Breakdown'
            },
            
            xAxis: {
                categories: {{json_encode($add_num['numbers'])}}
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Leads'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Sold',
                data: {{json_encode($add_num['sold'])}}
    
            }, {
                name: 'DNS',
                data: {{json_encode($add_num['dns'])}}
            }
            ]
        });

	     	          $('#close_numerology').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Address Close % Numerology Breakdown'
            },
            
            xAxis: {
                categories: {{json_encode($add_num['numbers'])}}
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Leads'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [ {
                name: 'Close',
                data: {{json_encode($add_num['close'])}}
    
            }



            ]
        });
@endif
@if(!empty($reggiers))
          $('#cont').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Breakdown by Reggier'
            },
            
            xAxis: {
                categories: {{json_encode($reggiers['names'])}}
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Leads'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Renters',
                data: {{json_encode($reggiers['renters'])}}
    
            },{
                name: 'Wrong',
                data: {{json_encode($reggiers['wrong'])}}
    
            },{
                name: 'Sold',
                data: {{json_encode($reggiers['sold'])}}
    
            },{
                name: 'Booked',
                data: {{json_encode($reggiers['booked'])}}
    
            },{
                name: 'Put On',
                data: {{json_encode($reggiers['puton'])}}
    
            }

            ]
        });

    $('#pie').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },exporting: {
         enabled: false
		},
        title: {
            text: 'Hold %'
        },
       
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    color: '#000000',
                    connectorColor: '#000000',
                  
                }
            }
        },
        series: [{
            type: 'pie',
           
            data: [
                ['Wrong',   {{$totwrong}}],
                ['Renters',       {{$totrenters}}],
                ['Sold',    {{$totsold}}],
                ['Put On',     {{$totputon}}],
                ['Unreleased',     {{$totunreleased}}],
                ['Not Interested',     {{$totni}}],
                ['DNC',     {{$totdnc}}],
                ['Booked',{{$totbooked-$totputon-$totsold}}],
                ['Available / Rebook',     {{$totavail}}]
               
            ]
        }]

    });

@endif



$('.viewReggieHistory').click(function(){
	$('#bigmapview').show();
});

$('.loadCity').click(function(){
	var name = $(this).data('cityname');
	$('#BIGMAP').hide();
	$('#bigmaploader').show();
	var historyUrl = '../reports/door/map';
var url = '../reports/door/map';
var to="{{$startdate}}"; var from="{{$enddate}}";
var lat = "{{$setting->lat}}"; var lng = "{{$setting->lng}}";
$.getJSON(url,{cityname:name,plainicons:true},function(data){
	$('#bigmaploader').hide();
	$('#BIGMAP').show();
	if(data.empty==true){
		alert('There is no data for the chosen city!');
		$('#bigmaploader').hide();
		$('#BIGMAP').hide();
	} else {
	

$("#BIGMAP").gmap3({
  marker:{
    values: data.map,
    options:{
     draggable:false,
    },
    events:{
      mouseover: function(marker, event, context){
        var map = $(this).gmap3("get"),
          infowindow = $(this).gmap3({get:{name:"infowindow"}});
        if (infowindow){
          infowindow.open(map, marker);
          infowindow.setContent(context.data);
        } else {
          $(this).gmap3({
            infowindow:{
              anchor:marker, 
              options:{content: context.data}
            }
          });
        }
      },
      mouseout: function(){
        var infowindow = $(this).gmap3({get:{name:"infowindow"}});
        if (infowindow){
          infowindow.close();
        }
      },
    }
  },
  map:{
    options:{
      zoom: 13,
        center: new google.maps.LatLng(data.latlng[0],data.latlng[1]),
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        mapTypeControl: true,
        mapTypeControlOptions: {
         mapTypeIds: [google.maps.MapTypeId.ROADMAP, google.maps.MapTypeId.HYBRID],
          style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
        },
        navigationControl: true,
        scrollwheel: true,
        streetViewControl: true
     }
  }
});
}

});


});

$('.cityList ').hover(function() {
    $("body").css("overflow","hidden");
}, function() {
     $("body").css("overflow","auto");
});

$('#bigmapview').hover(function() {
    $("body").css("overflow","hidden");
}, function() {
     $("body").css("overflow","auto");
});

var url = '../reports/door/map';
var to="{{$startdate}}"; var from="{{$enddate}}";
var lat = "{{$setting->lat}}"; var lng = "{{$setting->lng}}";

$.getJSON(url,{to:to,from:from},function(data){
$("#maptwo").gmap3({
  marker:{
    values: data.map,
    options:{
     draggable:false,
    },
    events:{
      mouseover: function(marker, event, context){
        var map = $(this).gmap3("get"),
          infowindow = $(this).gmap3({get:{name:"infowindow"}});
        if (infowindow){
          infowindow.open(map, marker);
          infowindow.setContent(context.data);
        } else {
          $(this).gmap3({
            infowindow:{
              anchor:marker, 
              options:{content: context.data}
            }
          });
        }
      },
      mouseout: function(){
        var infowindow = $(this).gmap3({get:{name:"infowindow"}});
        if (infowindow){
          infowindow.close();
        }
      },
    }
  },
  map:{
    options:{
      zoom: 8,
        center: new google.maps.LatLng(lat,lng),
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        mapTypeControl: true,
        mapTypeControlOptions: {
         mapTypeIds: [google.maps.MapTypeId.ROADMAP, google.maps.MapTypeId.HYBRID],
          style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
        },
        navigationControl: true,
        scrollwheel: true,
        streetViewControl: true
     }
  }
});
});


$('.getmap').click(function(){
var id = $(this).data('id');
var to=$(this).data('to');var from=$(this).data('from');
var lat=$(this).data('lat');var lng=$(this).data('lng');
var name = $(this).data('rname');
$('.rname').html(name);
$('.to').html(to);
$('.from').html(from);
$('#leadview').show();
var url = '../reports/door/map';
$.getJSON(url,{id:id,to:to,from:from},function(data){

$("#BIGMAP").gmap3({
  marker:{
    values: data.map,
    options:{
     draggable:false,
    },
    events:{
      mouseover: function(marker, event, context){
        var map = $(this).gmap3("get"),
          infowindow = $(this).gmap3({get:{name:"infowindow"}});
        if (infowindow){
          infowindow.open(map, marker);
          infowindow.setContent(context.data);
        } else {
          $(this).gmap3({
            infowindow:{
              anchor:marker, 
              options:{content: context.data}
            }
          });
        }
      },
      mouseout: function(){
        var infowindow = $(this).gmap3({get:{name:"infowindow"}});
        if (infowindow){
          infowindow.close();
        }
      },
    }
  },
  map:{
    options:{
      zoom: 13,
        center: new google.maps.LatLng(lat,lng),
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        mapTypeControl: true,
        mapTypeControlOptions: {
         mapTypeIds: [google.maps.MapTypeId.ROADMAP, google.maps.MapTypeId.HYBRID],
          style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
        },
        navigationControl: true,
        scrollwheel: true,
        streetViewControl: true
     }
  }
});

html="";count=0;
$.each(data.leads, function(i,val){
    count++;

if(val.status=="SOLD"){thelabel="success special";} else if(val.status=="CXL"){thelabel="important";}
else if((val.status=="DNC")||(val.status=="NQ")){thelabel="important special";}
else if(val.status=="NI"){thelabel="important";} else if((val.status=="RB-TF")||(val.status=="RB-OF")){thelabel="info special";}
else if(val.status=="NH"){thelabel="info";} else if(val.status=="NEW") {thelabel="inverse";} else if(val.status=="ASSIGNED"){thelabel="warning"} else if(val.status=="WrongNumber") {thelabel="warning special";} else {thelabel="success special";}
if(val.status=="APP"){theresult = "<span class='result "+val.result+" '>"+val.result+"</span>";} else {theresult="";}


html+="<tr><td><center>"+count+"</center></td><td><center><span class='label label-important round special'>"+val.assign_count+"</span></center></td><td><center><a href='{{URL::to('lead/newlead/')}}"+val.cust_num+"'>"+val.cust_num+"</a></center></td><td>"+val.entry_date+"</td><td>"+val.cust_name+"</td><td>"+val.notes+"</td><td><span class='label label-"+thelabel+"'>"+val.status+"</span>"+theresult+"</td></tr>";

});
$('#leadtable').html(html);

});

});



$('.filter').click(function(){
var filter = $(this).data('status');
hide(filter);
});

function hide(category) {
    var objs = $("#maptwo").gmap3({
        get: {
            name:"marker",
            all: true
        }
    });    
    $.each(objs, function(i, obj){
        obj.setVisible(false);
    });

    var objs = $("#maptwo").gmap3({
        get: {
            name:"marker",
            tag: category,
            all: true
        }
    });    
    $.each(objs, function(i, obj){
        obj.setVisible(true);
    });
}

$('.backtoreports').click(function(){
	window.scrollTo(0, 0);
$('#leadview').hide();
});




});
</script>
@endsection