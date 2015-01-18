@layout('layouts/main')
@section('content')
<style>
table.apptable {border:1px solid #1f1f1f;padding-bottom:50px;font-size:15px;color:#000;}
table.apptable th {border:1px solid #5e5e5e;background:#3e3e3e;color:#fff;}
table.apptable td {border:1px solid #5e5e5e;font-size:14px;font-weight:normal;}
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
</style>
<?php $settings = Setting::find(1);?>
  <div id="leadview" style="width:100%;display:none;padding-top:20px;margin-top:-90px;position:absolute;z-index:20000;padding:10px;" >
                       
                       
                       <div style="position:fixed;margin-left:-10px;width:43%;top:-100px;border:1px solid #1f1f1f;">
                        		<button class="btn btn-danger animated fadeInUp backtoreports" style="position:fixed;margin-top:200px;z-index:250000;padding:12px;margin-left:160px;font-size:25px;"><i class="cus-cancel"></i>&nbsp;&nbsp;BACK TO REPORTS</button>
                        		<button class="btn btn-danger animated fadeInUp backtoreports" style="position:fixed;right:10px;margin-top:110px;z-index:250000;padding:8px;font-size:15px;"><i class="cus-cancel"></i>&nbsp;&nbsp;BACK TO REPORTS</button>
                                <div id="map" style="height:1200px;width:100%;"></div>

                            </div>
                                <div style="width:55%;float:right;padding-top:30px;">
                               <h4>Leads Entered By <span class="rname"></span> Period : <span class="label label-info special">{{date('D M-d',strtotime($startdate))}} - {{date('D M-d',strtotime($enddate))}}</span></h4>
                                <table class="apptable" style="font-size:10px;margin-right:22px;">
                                    <thead>
                                        <th style="width:3%;"><center>#</center></th>
                                        <th>CALLED</th>
                                        <th style="width:14%;"><center>Number</center></th>
                                        <th style="width:10%;">Survey Date</th>
                                        <th>Name</th>
                                        <th>Notes</th>
                                        
                                        <th>Status</th>
                                    </thead>
                                    <tbody id="leadtable">
                                    </tbody>
                                </table>
                            </div>
                  
                    </div>


<div id="main"  class="container-fluid lightPaperBack" style="min-height:1000px;padding:45px;padding-top:30px;padding-bottom:800px;">
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

            	<div class='span4' style="margin-top:5px;" id="leadtype">
            		Choose Leadtype to Filter&nbsp;&nbsp;
                	<select name='leadtype_get' id='leadtype_get'>
                		<option value='all'>All</option>
                    @if($settings->lead_paper==1)
                    <option value='paper' @if($type=="paper") selected='selected' @endif>Manilla</option>
                    @endif
                    @if($settings->lead_secondtier==1)
                    <option value='secondtier' @if($type=="secondtier") selected='selected' @endif>Second Tier</option>
                    @endif
                    @if($settings->lead_door==1)
                     <option value='door' @if($type=="door") selected='selected' @endif>Door</option>
                    @endif
                    @if($settings->lead_scratch==1)
                    <option value='other' @if($type=="other") selected='selected' @endif>Scratch Cards</option>
                    @endif
                    @if($settings->lead_homeshow==1)
                    <option value='homeshow' @if($type=="homeshow") selected='selected' @endif>Homeshow</option>
                    @endif
                    @if($settings->lead_ballot==1)
                    <option value='ballot' @if($type=="ballot") selected='selected' @endif>Ballot Box</option>
                    @endif
                    @if($settings->lead_referral==1)
                    <option value='referral' @if($type=="referral") selected='selected' @endif>Referral</option>
                    @endif
                    @if($settings->lead_personal==1)
                    <option value='personal' @if($type=="personal") selected='selected' @endif>Personal</option>
                    @endif
                    @if($settings->lead_coldcall==1)
                    <option value='coldcall' @if($type=="coldcall") selected='selected' @endif>Cold Call</option>
                    @endif
                		@if($settings->lead_doorknock==1)
	                	<option value='doorknock' @if($type=="doorknock") selected='selected' @endif>Door Knock</option>
                    @endif
                        
               		</select>
            	</div>
            	
            	<button class="btn btn-default generateReport" style="margin-left:20px;margin-top:-6px;">
            		<i class="cus-application-view-tile"></i>&nbsp;GENERATE REPORT
            	</button>
            	
        	
            	</form>
                    </div>

                    	<div class="row-fluid">
                            
           					<div class="span6">
                                <table class="table apptable table-condensed">
                                <thead>
                                    <tr style="background:#1f1f1f;color:#fff;font-size:12px;">
                                        <th>ENTERED BY</th>
                                        <th>Total</th>
                                        <th>Valid</th>
                                        <th>Wrong #</th>
                                        <th>Renters</th>
                                        <th>Booked</th>
                                        <th>Put On</th>
                                        <th>SOLD</th>
                                        <th>DNS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                 <?php $total=0;$totputon=0;$totsold=0;$totvalid=0;$totwrong=0;$totrenters=0;
                                 $tottotal=0;$totavail=0;$totunreleased=0;$totdnc=0;$totni=0;$totbooked=0;$totdns=0;
                                 $totgross=0;$totwrong=0;$totowed=0;?>
                                @foreach($doorreports as $val)
                                @if(!empty($val->researcher_name))
                                <?php $u = User::find($val->researcher_id);?>
                                 <?php $tottotal=$tottotal+$val->total; 
                                 $totputon=$totputon+$val->puton;$totsold=$totsold+$val->sold;$totdns=$totdns+$val->dns;
                                  $totni=$totni+$val->ni;$totdnc=$totdnc+$val->dnc;
                                 $totavail=$totavail+$val->avail;$totunreleased=$totunreleased+$val->unreleased;$totbooked=$totbooked+$val->booked;
                                 $totvalid=$totvalid+$val->valid;$totwrong=$totwrong+$val->wrong;$totrenters=$totrenters+$val->renters;
                                $reggiers['names'][] = $val->researcher_name;
                                $reggiers['sold'][] = intval($val->sold);
                                $reggiers['puton'][]=intval($val->puton);
                                $reggiers['booked'][] = intval($val->booked);
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
                                    <td><center>@if($val->total!=0) {{$val->total}} @endif</center></td>
                                    <td><center>@if($val->valid!=0) <span class="label bigtext label-success special">{{$val->valid}} </span>@endif</center></td>
                                    <td><center>@if($val->wrong!=0) <span class="label bigtext label-important">{{$val->wrong}} </span> @endif</center></td>
                                    <td><center>@if($val->renters!=0) <span class="label bigtext label-important special">{{$val->renters}}</span> @endif</center></td>
                                    <td><center>@if($val->booked!=0) <span class="label bigtext label-warning special blackText">{{$val->booked}}</span> @endif</center></td>
                                     <td><center>@if($val->puton!=0) <span class="label bigtext label-info special">{{$val->puton}} </span> @endif</center></td>
                                    <td><center>@if($val->sold!=0) <span class="label bigtext label-success blackText special">{{$val->sold}}</span> @endif</center></td>
                                    <td><center>@if($val->dns!=0) <span class="label bigtext label-important special">{{$val->dns}}</span> @endif</center></td>
                              
                                </tr>
                                @endif
                                @endforeach
                                <tr style="height:30px;">
                                	<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                                </tr>
                                <tr style="background:#ccc;">
                                	  <td>TOTALS</td>
                                    <td><center>@if($tottotal!=0) <span class="label label-success bigtext">{{$tottotal}} </span>@endif</center></td>
                                    <td><center>@if($totvalid!=0)  <span class="label label-success bigtext">{{$totvalid}} </span>@endif</center></td>
                                    <td><center>@if($totwrong!=0)  <span class="label label-important bigtext">{{$totwrong}} </span> @endif</center></td>
                                    <td><center>@if($totrenters!=0) <span class="label label-important special bigtext">{{$totrenters}}</span> @endif</center></td>
                                    <td><center>@if($totbooked!=0) <span class="label label-warning blackText special bigtext">{{$totbooked}} </span> @endif</center></td>
                                    <td><center>@if($totputon!=0) <span class="label label-info special bigtext">{{$totputon}} </span> @endif</center></td>
                                    <td><center>@if($totsold!=0) <span class="label label-success blackText special bigtext">{{$totsold}}</span> @endif</center></td>
                                    <td><center>@if($totdns!=0) <span class="label label-important special bigtext">{{$totdns}}</span> @endif</center></td>

                                </tr>
                                </tbody>
                            </table>
                            <br/>
                             <div class="row-fluid" style="margin-top:10px;border-bottom:1px solid #ddd;padding-bottom:20px;">
                             	<div style="float:left;">
                          	BOOK PERCENT %<br/><span class="dailystats2 PUTON" style="border:1px solid #1f1f1f;border-radius:4px;padding:8px;font-size:16px;color:#000;width:60%;">

                            	@if(($tottotal!=0)&&($totbooked!=0)) {{number_format($totbooked/$tottotal*100,2,'.','')}} @else 0 @endif%</span>
                            	</div>
                            	<div style="float:left;margin-left:30px;">
                            	HOLD PERCENT %<br/><span class="dailystats2 PUTON" style="border:1px solid #1f1f1f;border-radius:4px;padding:8px;font-size:16px;color:#000;width:60%;">
                            	@if(($totputon!=0)&&($totbooked!=0)) {{number_format($totputon/$totbooked*100,2,'.','')}} @else 0 @endif%</span>
                            </div>
                            <div style="float:left;margin-left:30px;">
                            	   CLEAR PERCENT %<br/><span class="dailystats2 PUTON" style="border:1px solid #1f1f1f;border-radius:4px;padding:8px;font-size:16px;color:#000;width:60%;">
                            	@if(($totputon!=0)&&($totsold!=0)) {{number_format($totsold/$totputon*100,2,'.','')}} @else 0 @endif%</span>
                          	</div>
                      </div>
                              <div class="row-fluid">
                            	<div id="cont" class="smallShadow" style="margin-top:10px;float:left;width:50%;height:400px;"></div>
                            	<div id="pie" class="smallShadow" style="margin-top:10px;float:left;width:45%;margin-left:30px;height:400px;"></div>
                            </div>
                        </div>
                           <div class="span6 well  " >
                           	   	<button class='btn btn-success filter' data-status="SOLD">SHOW SOLD</button>
                           	<button class='btn btn-danger  filter' data-status="DNS">SHOW DNS</button>
                           	<button class='btn btn-primary filter' data-status="APP">SHOW APPOINTMENTS</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                           	<button class='btn btn-warning btn-small blackText filter' data-status="NEW">AVAILABLE</button>
                           	<button class='btn btn-inverse btn-small redText filter' data-status="INACTIVE">UNRELEASED</button>
                           	<button class='btn btn-success blackText btn-small filter' data-status="ASSIGNED">ASSIGNED</button><br/><br/>
	                            	<div  id="maptwo" style="height:510px;width:100%;border:1px solid #1f1f1f;border-radius:20px;"></div>
                        </div>
                    </div>
                     
                    


</div>
<div class="push"></div>
<script src="{{URL::to_asset('js/include/gmap3.min.js')}}"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&amp;language=en"></script>
<script src="{{URL::to_asset('js/highcharts.js')}}"></script>
<script>
$(document).ready(function(){

    $('#leadtype_get').change(function(){
        var val = $(this).val();
        var to = $('#enddate').val();
        var from = $('#startdate').val();
       window.location.search = "?leadtype_get=" + encodeURIComponent(val)+"&startdate="+from+"&enddate="+to;
    });
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
                name: 'Put On',
                data: {{json_encode($reggiers['puton'])}}
    
            }

            ]
        });
    @endif
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
                ['Available / Rebook',     {{$totavail}}]
               
            ]
        }]

    });
var url = '../reports/other/map';
var type = '{{$type}}';
var to="{{$startdate}}"; var from="{{$enddate}}";
var lat = "{{Setting::find(1)->lat}}"; var lng = "{{Setting::find(1)->lng}}";

$.getJSON(url,{to:to,from:from,leadtype_get:type},function(data){
	console.log(data);
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
var url = '../reports/other/map';
$.getJSON(url,{id:id,to:to,from:from},function(data){

$("#map").gmap3({
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