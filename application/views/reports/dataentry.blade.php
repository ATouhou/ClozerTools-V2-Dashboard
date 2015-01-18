@layout('layouts/main')
@section('content')
<style>

.processapp{width:90%!important;}
.bignum3{font-size:12px;padding:5px;}
.sendleads {cursor:pointer;}
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
                        <!--<div class='span4' style="margin-top:5px;" id="cityname">
            		Choose City&nbsp;&nbsp;
                		<select name='cityname' id='cityname'>
                			<option value='all'>All</option>
                			@if(!empty($cities))
                			@foreach($cities as $val)
                			<option value='{{$val->cityname}}' @if($city==$val->cityname) selected='selected' @endif>{{$val->cityname}}</option>
                			@endforeach
                			@endif
                		</select>
            	</div>-->
                        <button class="btn btn-default" style="margin-left:20px;margin-top:-6px;"><i class="cus-application-view-tile"></i>&nbsp;GENERATE REPORT</button>
                        
                      
                        </form>

                    <div class="row-fluid" style="padding-top:20px;">
                        @if(Setting::find(1)->quick_pick_buttons==1)
                        <?php
                        $num_weeks = 8;
                        
                        $dates = Array();
                        $dates[] = strtotime('Monday');
                        
                        for ($i = 0; $i < $num_weeks-1; $i++)
                            $dates[] = strtotime('-1 week', $dates[$i]);
                        
                        foreach ($dates as $date)
                            $date2[] = strftime('%c', $date);
                        
                        $date2 = array_reverse($date2);
                        $count = count($date2);
                        ?>
                            @foreach($date2 as $k=>$d)
                        
                            @if($k==$count-1)
                        
                            @else
                            <?php
                            $date = strtotime($d);
                            $date = strtotime("+6 day", $date);?>
                                    <a href='{{URL::to("reports/dataentry")}}?startdate={{date("Y-m-d",strtotime($d))}}&enddate={{date("Y-m-d",$date)}}'>
                                        <button class='btn btn-default'>
                                            <b>{{date('Md',strtotime($d))}} </b>- <b>{{date('Md',$date)}}</b>
                                        </button>
                                    </a>
                            @endif
                            @endforeach
                        &nbsp;&nbsp;
                        @endif

                        @if(!empty($wrong))
                        <a href='{{URL::to("reports/generateExcelManilla")}}?startdate={{$startdate}}&enddate={{$enddate}}'>
                            <button class="btn btn-default pull-right" style="margin-left:20px;margin-top:-6px;">
                            <i class="cus-doc-excel-table"></i>&nbsp;DOWNLOAD INVALID NUMBERS EXCEL REPORT FOR {{date('M-d',strtotime($startdate))}} - {{date('M-d',strtotime($enddate))}}</button>
                        </a>
                        @endif
                    </div>

                    <div class='row-fluid wrongNumReport animated fadeInUp ' style="float:left;margin-top:20px;">
                    	
                    	<div class="span12">
                    		<h4>INVALID vs VALID Number Report for {{date('M-d',strtotime($startdate))}} - {{date('M-d',strtotime($enddate))}}</h5>
                    	 <table class="table apptable">
                                <thead>
                                    <tr style="background:#1f1f1f;color:#fff;">
                                        <th style="width:18%;">UPLOAD DATE</th>
                                        <th>Total Uploaded</th>
                                        
                                        <th><center>Valid Leads</center></th>
                                        <th><center>Duplicates</center></th>
                                        <th><center>Renters / Invalids</center></th>
                                        <th><center>Wrong / Mistyped Number</center></th>
                                        <th><center>< 12 Digits</center></th>
                                        <th><center>Estimated Invoice Amount</center></th>
                                        <th><center>Valid Payable Numbers</center></th>
                                    </tr>
                                </thead>
                                <tbody><?php $row=0;$totrent=0;$totwrong=0;$totless=0;$totvalid=0;$totdup=0;$totall=0;?>
                                	<tr class='wrongNumRow' style='display:none;'>
                               	<td><button class='btn btn-mini btn-primary' onclick="$('.wrongNumRow').toggle(400);">HIDE DETAILS</button></td>
                               	<td></td><td></td><td></td><td></td><td></td>
                               	</tr>
                               @if(!empty($wrong))
                    			@foreach($wrong as $w)
                    			<?php $less= intval($w->short_num1)+intval($w->short_num2)+intval($w->short_num3);
                    			$totdup+=$w->duplicates;
                                $totall+=$w->tot+$w->duplicates;
                    			$totrent+=$w->renters;
                                $totvalid+=$w->valid;$totwrong+=intval($w->wrong);$totless+=$less;?>
                               	
                                <tr class='wrongNumRow' style='display:none;'>
                                    <td>{{date('M-d-Y',strtotime($w->entry_date))}}</td>
                                    <td><center>@if(!empty($w->tot))<span class="label totalStat label-inverse ">{{$w->tot + $w->duplicates}}</span> @endif </center></td>
                                    <td><center>@if(!empty($w->valid))<span class="label totalStat label-success blackText special">{{$w->valid}}</span >@endif </center></td>
                                    <td><center>@if(!empty($w->duplicates))<span class="label totalStat label-important special">{{$w->duplicates}}</span> @endif </center></td>
                                    <td><center>@if(!empty($w->renters))<span class="label totalStat label-important blackText special">{{$w->renters}}</span> @endif </center></td>
                                    <td><center>@if(!empty($w->wrong))<span class="label totalStat label-warning blackText special">{{$w->wrong}}</span> @endif </center></td>
                                    <td><center>@if(!empty($less))<span class="label totalStat label-important special">{{$less}}</span> @endif </center></td>
                                    <td>
                                        @if($w->tot!=0)
                                        <center><span class="totalStat label label-warning blackText special">${{number_format(($w->tot+$w->duplicates)/7,2,'.','')}}</span></center>
                                        @endif
                                    </td>
                                    <td>   
                                        @if($w->valid!=0)
                                        <center><span class="totalStat label label-success special">${{number_format($w->valid/7,2,'.','')}}</span></center>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td><span class='label label-inverse'>TOTAL FOR</span> <br/>
                                    	{{date('M-d',strtotime($startdate))}} - {{date('M-d',strtotime($enddate))}}
                                    	<br/>
                                    	<button class='btn btn-mini btn-primary' onclick="$('.wrongNumRow').toggle(400);">VIEW DETAILS</button>
                                    </td>
                                    <td><center><span class="totalStat label label-inverse special">{{$totall}}</span></center></td>

                                     <td><center><span class="totalStat label label-success blackText special">{{$totvalid}}</span></center></td>
                                     <td><center><span class="totalStat label label-important special">{{$totdup}}</span></center></td>
                                    <td><center><span class="totalStat label label-important blackText special">{{$totrent}}</span></center></td>
                                    <td><center><span class="totalStat label label-warning blackText special">{{$totwrong}}</span></center></td>
                                    <td><center><span class="totalStat label label-important special">{{$totless}}</span></center></td>
                                    <td>
                                        @if($totall!=0)
                                        <center><span class="totalStat label label-warning blackText special">${{number_format($totall/7,2,'.','')}}</span></center>
                                        @endif
                                    </td>
                                    <td>   
                                        @if($totvalid!=0)
                                        <center><span class="totalStat label label-success special">${{number_format($totvalid/7,2,'.','')}}</span></center>
                                        @endif
                                    </td>
                                </tr>
                    	@else
                    	<tr>
                    		<td>NO INVALID NUMBERS FOR REPORTING PERIOD</td>
                    	</tr>
                    	@endif
                                </tbody>
                            </table>
                            <br/><br/>
                            <div class='span2' style='border-right:1px solid #ccc;padding-right:10px;'>
                            <h3>TOTAL INVALID </h3>
                            <h2 style='color:red;'>{{$totrent+$totwrong+$totless+$totdup}}</h2><br/><br/>
                      		</div>
                      		<div class='span2' style='padding-left:40px;border-right:1px solid #ccc;padding-right:10px;'>
                            <h4>TOTAL INVALID % </h4>
                            @if((($totrent+$totwrong+$totless+$totdup)!=0)&&($totvalid!=0))
                            <h2 style='color:red;'>
                            	{{number_format(($totrent+$totwrong+$totless+$totdup)/(($totrent+$totwrong+$totless+$totdup)+$totvalid)*100,2,'.','')}}%
                            </h2>
                            @endif
                      </div>
                       <div class='span2' style='padding-left:40px;border-right:1px solid #ccc;padding-right:10px;'>
                            <h4>RENTING % </h4>
                            @if((($totrent+$totwrong+$totless+$totdup)!=0)&&($totvalid!=0))
                            <h2 style='color:orange;'>{{number_format(($totrent)/(($totrent+$totwrong+$totless+$totdup)+$totvalid)*100,2,'.','')}}%</h2>
                            @endif
                      </div>
                      <div class='span2' style='padding-left:40px;border-right:1px solid #ccc;padding-right:10px;'>
                            <h4>WRONG % </h4>
                            @if((($totrent+$totwrong+$totless+$totdup)!=0)&&($totvalid!=0))
                            <h2 style='color:orange;'>{{number_format(($totwrong)/(($totrent+$totwrong+$totless+$totdup)+$totvalid)*100,2,'.','')}}%</h2>
                            @endif
                      </div>
                       <div class='span2' style='padding-left:40px;border-right:1px solid #ccc;padding-right:10px;'>
                            <h4>< 12 DIGITS % </h4>
                            @if((($totrent+$totwrong+$totless+$totdup)!=0)&&($totvalid!=0))
                            <h2 style='color:orange;'>{{number_format(($totless)/(($totrent+$totwrong+$totless+$totdup)+$totvalid)*100,2,'.','')}}%</h2>
                            @endif
                      </div>
                      
                      </div>
                  
                    </div>

                    </div>

                    	<div class="row-fluid">
                            
           					<div class="span12 ">
                                <table class="table apptable">
                                <thead>
                                    <tr style="background:#1f1f1f;color:#fff;">
                                        <th>UPLOAD DATE</th>
                                        <th>CITY </th>
                                        <th>Valid</th>
                                        <th>Invalid Numbers</th>
                                        <th>Released</th>
                                        <th>Un-Released</th>
                                        <th><center>ASSIGNED</center></th>
                                        <th><center>AVAILABLE TO ASSIGN</center></th>
                                        <th>STATS</th>
                                        <th>Close %</th>
                                        
                                   
                                    </tr>
                                </thead>
                                <tbody><?php $row=0;?>
                                @foreach($dataentry as $val)
                                <?php $row = $row+1;
                                $close = 0;
                                if(($val->app>0)&&($val->called>0)){
                                	$close = intval($val->app/($val->sold+$val->app+$val->wrong+$val->ni+$val->nq+$val->dnc)*100);                                }
                                ?>
                                <tr id="{{$row}}"><?php $gross=number_format($val->total*3.00,2,'.','');$wrong=number_format($val->wrong*-3.00,2,'.','');?>
                                    <td>&nbsp;&nbsp;{{date('M-d-Y',strtotime($val->entry_date))}}&nbsp;&nbsp;
                                    	<!--<button class='btn btn-mini btn-primary getLeads' data-entrydate="{{$val->entry_date}}">VIEW LEADS</button>-->
                                    </td>
                                    <td>{{$val->city}}</td>
                                    <td><center><span class='label label-success special' style='color:#000'>{{$val->valid}}</span></center></td>
                                    <td>Renters : <span class="label label-important special">{{$val->renters}}</span>&nbsp;&nbsp;Wrong # : <span class="label label-important special">{{$val->wrong}}</span>&nbsp;&nbsp;Duplicates : <span class="label label-important special">{{$val->duplicates}}</span>
                                    </td>
                                    <td><span id="row-{{$row}}" class="label label-info special">{{$val->released}}</span></td>
                                    <td id="relrow-{{$row}}">
                                    	@if($val->unreleased>0)
                                    	<span class="label label-inverse special">{{$val->unreleased}}</span>&nbsp;&nbsp;
                                    	<button class='tooltwo btn btn-mini btn-primary releaseLeads' data-city='{{$val->city}}' title='Click here to release only the leads uploaded on this day' data-row='{{$row}}' data-date='{{$val->entry_date}}'>Release Leads</button>
                                    	@endif
                                    </td>
                                    <td><center><div id='assign-{{$row}}'>@if($val->assigned>0)
                                    	<span class='badge badge-success special' style='font-size:16px;color:#000;padding:7px'>{{$val->assigned}}</span>
                                    	@endif</div></center></td>
                                    <td><?php $none = "<span class='label'>0</span>";?>
                                    	<center>
                                    	 @if($val->new!=0)

                                    	<span class="label label-warning special sendleads tooltwo" title='Click here to assign 30 of these leads to a Booker' id="{{$val->entry_date}}|{{$val->city}}" style='color:#000;font-size:18px;padding:5px;' >{{$val->new}}</span>
                                    	@else
                                    	{{$none}}
                                    	@endif   </center> </td>
                                    <td>
                                    	Called : @if($val->called!=0)
                                    	<span class="label label-info special">{{$val->called}}</span>
                                    	@else
                                    	{{$none}}
                                    	@endif                                    	
                                    	&nbsp;&nbsp;BOOKED : 
                                    	 @if($val->app!=0)
                                    	<span class="label label-success" >{{$val->app}}</span>
                                    	@else
                                    	{{$none}}
                                    	@endif    
                                    	&nbsp;&nbsp;SOLD : 
                                    	 @if($val->sold!=0)
                                    	<span class="label label-success special" style='color:#000'>{{$val->sold}}</span>
                                    	@else
                                    	{{$none}}
                                    	@endif   
                                    	&nbsp;&nbsp;NI : 
                                    	 @if($val->ni!=0)
                                    	<span class="label label-important special">{{$val->ni}}</span>
                                    	@else
                                    	{{$none}}
                                    	@endif   
                                    	&nbsp;&nbsp;NQ : 
                                    	@if($val->ni!=0)
                                    	<span class="label label-important special" style='color:#000'>{{$val->nq}}</span>
                                    	@else
                                    	{{$none}}
                                    	@endif   
                                    	&nbsp;&nbsp;DNC : 
                                    	@if($val->dnc!=0)
                                    	<span class="label label-important special">{{$val->dnc}}</span>
                                    	@else
                                    	{{$none}}
                                    	@endif   

                                    </td>
                                    <td><center>@if($close!=0)<span class='badge badge-info special'>{{$close}} %</span>@endif</center></td>
                                   
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                      
                    


</div>
 <?php $arr=array();
	foreach($bookers as $val){
    	$arr[$val->firstname."|".$val->id] = $val->firstname." ".$val->lastname;
    };?>
<div class="push"></div>
<script src="{{URL::to_asset('js/include/gmap3.min.js')}}"></script>

<script src="{{URL::to_asset('js/editable.js')}}"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&amp;language=en"></script>

<script>
$(document).ready(function(){

$('.wrongNumReportView').click(function(e){
	e.preventDefault();
	$('.wrongNumReport').toggle();
});

var url = '../reports/paper/map';
var to="{{$startdate}}"; var from="{{$enddate}}";
var lat = "{{Setting::find(1)->lat}}"; var lng = "{{Setting::find(1)->lng}}";

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

$('.releaseLeads').click(function(data){
var city = $(this).data('city');
var date = $(this).data('date');
var row = $(this).data('row');

$.ajax({
  dataType: "json",
  url:'../../lead/releasemanilla',
  data: {city:city,date:date},
  beforeSend: function(){
  cnt = parseInt($('#row-'+row).html());
  $('#relrow-'+row).html("").append("<img src='https://s3.amazonaws.com/salesdash/loaders/56.gif'>");
  $('#row-'+row).html("").append("<img src='https://s3.amazonaws.com/salesdash/loaders/56.gif'>");
	},
  success: function(data){

	$('#row-'+row).html(parseInt(cnt)+parseInt(data));
	$('#relrow-'+row).html("");
	toastr.success('Succesfully released leads from '+city+' into pool','LEADS RELEASED');
	}
});
});

$('.sendleads').editable('{{URL::to("lead/assignleads/manilla")}}',{
	data : '<?php echo  json_encode($arr);?>',
	type:'select',
	submit:'OK',
    	indicator : '<img src="https://s3.amazonaws.com/salesdash/loaders/56.gif">',
    	width:'40',
    	callback: function(value, settings){
    	var d = JSON.parse(value);
    	$(this).html(d.count);
    	location.reload();

    	}
});





});
</script>
@endsection