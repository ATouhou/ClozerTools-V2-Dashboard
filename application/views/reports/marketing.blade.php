@layout('layouts/main')
@section('content')
<style>

.processapp{width:90%!important;}
.bignum3{font-size:12px;padding:5px;}

div.jGrowl.myposition {
 position: absolute;
 font-size:200%;
 margin-left:150px;
 top: 20%;
}

.rightbutton{float:right;margin-top:10px;margin-right:10px;}

.totaltable {border:1px solid #1f1f1f;}
.totaltable td:first-child {font-weight:bolder;font-size:14px;}
.totaltable td {border:1px solid #1f1f1f;}
.largestats {margin-top:50px!important;margin-right:10px;}
</style>
<?php $settings = Setting::find(1);?>
<?php $totalsurveys=0;$totalmas=0;$totalsts=0;$totalsurvey=0;$totalreggies=0;$totalscratch=0;$totalsold=0;$totaldems=0;$tot_slotone=0;$tot_slottwo=0;$tot_slotthree=0;$tot_slotfour=0;$tot_slotfive=0;?>
@if(!empty($paperanddoor))

<?php foreach($paperanddoor as $val){
 if($val->original_leadtype=="paper" ){
    $totalsurveys += $val->tot;
    $totalmas += $val->tot;
} else if($val->original_leadtype=="secondtier"){
    $totalsts += $val->tot;
} else if($val->original_leadtype=="door"){
	$totalsurveys += $val->tot;
	$totalreggies=$val->tot;
}
$totalsold = $totalsold+$val->sold;
$totaldems = $totaldems+($val->sold+$val->dns);

}
if($totalreggies+$totalmas!=0){
$totalmarketing = number_format(($totalreggies+$totalmas)/7,2,'.','');
} else {$totalmarketing = 0;}
?>
@endif
{{$totalmas}}

<div id="main"  class="container-fluid lightPaperBack" style="min-height:1000px;padding:45px;padding-top:30px;margin-top:-20px;padding-bottom:800px;">
				<h3>{{$title}}
				@include('plugins.reportmenu')
				</h3>
      				<div class="well row-fluid" style="padding-left:40px;padding-right:40px;">
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
                        <button class="btn btn-default" style="margin-left:20px;margin-top:-6px;"><i class="cus-application-view-tile"></i>&nbsp;GENERATE REPORT</button></form>
                        @if(isset($_GET['startdate']))
            	<a class='healthMor'  href='{{URL::to("reports/generateExcelMarketing")}}/?startdate={{$startdate}}&enddate={{$enddate}}' >
            		<button class="btn btn-warning " style="float:right;margin-top:-41px;margin-right:180px;color:black;" >
            			<i class="cus-doc-excel-table"></i>&nbsp;&nbsp;DOWNLOAD EXCEL REPORT
            		</button>
            	</a>
            	@endif
                          <button class="btn btn-primary" style="float:right;margin-top:-41px;" onclick="$('#stats').toggle(300);"><i class="cus-chart-bar"></i>&nbsp;SHOW STATS</button>
                          <div id="stats" style="display:none;" >
                            	<div class="row-fluid" style="margin-top:20px;">
                            	 	@if($settings->lead_paper==1)<button class="btn btn-warning filter" data-filter="paper">MANILLAS</button>@endif
                                    @if($settings->lead_secondtier==1)<button class="btn btn-warning filter" data-filter="secondtier">SECOND TIER</button>@endif
                                    @if($settings->lead_survey==1)<button class="btn btn-primary filter" data-filter="survey">FRESH SURVEYS</button>@endif
                                    @if($settings->lead_coldcall==1)<button class="btn btn-inverse filter" data-filter="coldcall">COLD CALLS</button>@endif
                            	 	@if($settings->lead_door==1)<button class="btn btn-success filter" data-filter="door">DOOR SURVEYS</button>@endif 	
                            	 	@if($settings->lead_scratch==1)<button class="btn btn-primary filter" data-filter="other">SCRATCH CARDS</button>@endif
                            	 	@if($settings->lead_ballot==1)<button class="btn btn-success filter" data-filter="ballot">BALLOT BOXES</button>@endif 	
                            	 	@if($settings->lead_homeshow==1)<button class="btn btn-primary filter" data-filter="homeshow">HOME SHOWS</button>@endif
                            	    @if($settings->lead_personal==1)<button class="btn btn-inverse filter" data-filter="personal">PERSONAL</button>@endif
                                    @if($settings->lead_referral==1)<button class="btn btn-inverse filter" data-filter="referral">REFERRAL</button>@endif
                                    @if($settings->lead_doorknock==1)<button class="btn btn-inverse filter" data-filter="doorknock">DOOR KNOCK</button>@endif
                                </div>
                                <?php $totalsurveyed=0;?>
                            	@if(!empty($paperanddoor))
                            		@foreach($paperanddoor as $val)
                            		@if(($val->original_leadtype!=""))
                            		<?php
                            		$total=0;
                            		if($val->original_leadtype=="door"){
                            		$total = number_format($val->tot*Setting::find(1)->reggie_rate,2,'.','');
                            		} else if($val->original_leadtype=="paper") {
                            		$total = number_format($val->tot/7*10.50,2,'.','');
                            		} else if($val->original_leadtype=="secondtier") {
                                        $totalsurveyed += $val->tot;
                                        $total = number_format($val->tot/7*10.50,2,'.','');
                                    
                                    } else if($val->original_leadtype=="survey") {
                                    $total = number_format($val->tot/7*10.50,2,'.',''); 
                                    } else if($val->original_leadtype=="other"){
                            		$total = number_format($val->tot/0.21,2,'.','');
                            		};
                            		if(($total!=0)&&($val->sold!=0)){
                            		$cps = number_format($total/$val->sold,2,'.','');} else {$cps=0;}
                            		if(($total!=0)&&($val->sold+$val->dns!=0)){
                            		$cpd = number_format($total/($val->sold+$val->dns),2,'.','');} else {$cpd=0;}
                            		if(($totalsold!=0)&&($total!=0)){
                            		$avgcps = number_format($total/$totalsold,2,'.','');} else {$avgcps=0;}
                            		if(($totaldems!=0)&&($total!=0)){
                            		$avgcpd = number_format($total/$totaldems,2,'.','');} else {$avgcpd=0;}
                            	
                            		?>
                            	<div class="row-fluid well leadtypebox box-{{$val->original_leadtype}}" style="margin-top:20px;display:none">
                            		 <h3 style="margin-left:10px;"><span style="color:#000;font-weight:bold;">{{$val->tot}}</span> {{ucfirst($val->leadtype)}} Surveys for {{$title}}</h3>
                            		
                            	 	<div class="largestats end ">
                            		    <span class="bignum2 BOOK">${{$total}}</span><br/>
                            		    <h5>TOTAL COST</h5>
                            		</div>
                            		<div class="largestats end ">
                            		    <span class="bignum2 PUTON">${{$cps}}</span><br/>
                            		    <h5>TRUE COST PER SALE</h5>
                            		</div>
                            		<div class="largestats end ">
                            		    <span class="bignum2 BOOK">${{$cpd}}</span><br/>
                            		    <h5>TRUE COST PER DEM</h5>
                            		</div>
                            		<div class="largestats end ">
                            		    <span class="bignum2 PUTON">${{$avgcps}}</span><br/>
                            		    <h5>AVG. COST PER SALE</h5>
                            		</div>
                            		<div class="largestats end ">
                            		    <span class="bignum2 BOOK">${{$avgcpd}}</span><br/>
                            		    <h5>AVG COST PER DEM</h5>
                            		</div>
                            		
                            		<div class="largestats end ">
                            		    <span class="bignum2 SOLD">{{$val->sold}}</span><br/>
                            		    <h5>SOLD BY LEAD</h5>
                            		</div>
                            		<div class="largestats end ">
                            		    <span class="bignum2 DNS2">{{$val->dns}}</span><br/>
                            		    <h5>DNS BY LEAD</h5>
                            		</div>
                            	</div>
                            		@endif
                            		@endforeach
                            	@endif
                        		<div class="row-fluid" style="margin-bottom:40px;">
                        			<div class="span12">
                        				<h4>Phone Call Stats for {{$title}}</h5>
                        				<table class="table table-bordered table-condensed " style="border:1px solid #1f1f1f;" >
                        				    <thead style="color:#000!important">

                        				        <th style="width:16%;">Booker</th>
                        				        <th style="width:4%;"><center><span id="close-survey">Close %</span></center></th>
                        				        <th style="width:5%;"><center>APP</center></th>
                        				       
                        				        <th  style="width:5%;"><center><span id="nid">NI</span></center></th>
                        				        <th  style="width:5%;"><center>NH</center></th>
                        				        <th  style="width:5%;"><center>NQ</center></th>
                        				        <th  style="width:5%;"><center>DNC</center></th>
                        				        <th  style="width:5%;"><center>Wrong</center></th>
                        				        <th  style="width:5%;"><center>Recalls</center></th>
                        				        <th style="width:5%;"><center>TOTAL</center></th>
                        				 
                        				    </thead>
                        				    <tbody class='marketingstats'>
                        				    	<?php $ni = 0;$nh=0;$wrong=0; $dnc=0; $recall=0; $app=0; $totals=0; $totalsurveyed1=0;$nq=0;$nid=0;?>

                        				        @foreach($marketstats['stats'] as $val)
                        				        <tr class='{{$val->leadtype}}' style="display:none;" data-leadtype='{{$val->leadtype}}'>
                        				        	<?php $app = $app+$val->app; 
                        				        	$ni = $ni+$val->ni;
                        				        	$nid = $nid+$val->nid;
                        				        	$nq = $nq+$val->nq;
                        				        	$nh = $nh+$val->nh;
                        				        	$wrong = $wrong+$val->wrong;
                        				        	$dnc = $dnc+$val->dnc;
                        				        	$recall = $recall+$val->recall;
                        				        	$totals = $totals+$val->tot;
                        				        	$totalsurveyed1 = $totals-($recall+$dnc+$wrong+$nh+$nq+$ni+$app);

                        				        	?>
                        				            <td><a href="{{URL::to('users/profile/')}}{{$val->booker_id}}">{{$val->caller_id}}</a></td>
                        				            
                                                    @if($val->leadtype=="survey")
                                                     <td><center><span class='label label-info special'>{{$totalsurveyed1}}</span></center></td>
                                                    @else
                                                    <td>
                                                    @if(($val->app!=0)&&($val->ni!=0)) {{number_format(($val->app/($val->app+$val->ni)*100),2,'.','')}}% @endif
                                                    </td>
                                                    @endif
                                                    
                        				            <td><center>@if($val->app!=0)<span class="label label-success">{{$val->app}}</span>@endif</center></td>
                                                    @if($val->leadtype=="survey")
                                                     <td><center>
                                                     	@if($val->nid!=0)<span class="label label-success">{{$val->nid}}</span>@endif
                                                     	@if($val->nid!=0) / <span class="label label-important special">{{$val->ni}}</span>@endif
                                                     </center></td>
                                                    @else
                                                     <td><center>@if($val->ni!=0)<span class="label label-important">{{$val->ni}}</span>@endif</center></td>
                                                    @endif

                        				            <td><center>@if($val->nh!=0)<span class="label label-inverse">{{$val->nh}}</span>@endif</center></td>
                        				            <td><center>@if($val->nq!=0)<span class="label label-important special">{{$val->nq}}</span>@endif</center></td>
                        				            <td><center>@if($val->dnc!=0)<span class="label label-important special">{{$val->dnc}}</span>@endif</center></td>
                        				            <td><center>@if($val->wrong!=0)<span class="label label-warning">{{$val->wrong}}</span>@endif</center></td>
                        				            <td><center>@if($val->recall!=0){{$val->recall}}@endif</center></td>
                        				            <td><center><span class='label label-info special'>{{$val->tot}}</span></td>
                        				        </tr>
                        				        @endforeach
                        				    </tbody>
                        				</table>
                        			</div>
                        		</div>

                        	</div>
                    </div>
                 			<div class="row-fluid">
                                <table class="table apptable" style="margin-top:20px;" >
                                <thead>
                                    <tr>
                                        <th>Booker</th>
                                        <th>Booked</th>
                                        <th style="width:2%;">10:30</th>
                        			    <th style="width:2%;">1:30</th>
                        			    <th style="width:2%;">3:30</th>
                        			    <th style="width:2%;">6:30</th>
                        			    <th style="width:2%;">8:30</th>
                                        <th>SOLD</th>
                                        <th>DNS</th>
                                        <th>INC</th>
                                        <th>CXL</th>
                                        <th>PUT ON</th>
                                        <th>BPH</th>
                                        <th>HOLD %</th>
                                        <th>HRS</th>
                                        <th>PAYRATE</th>
                                        <th>BOOK %</th>
                                        <th>CPD</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $total=0;$sales=0;$dns=0;$inc=0;$puton=0;$hours=0;$cxl=0;?>
                                @foreach($marketingreports as $val)
                                <?php $total=$total+$val['salestats']->total;
                                $sales=$sales+$val['salestats']->sales;
                                $dns=$dns+$val['salestats']->dns;
                                $inc=$inc+$val['salestats']->inc;
                                $cxl=$cxl+$val['salestats']->cxl;
                                $puton=$puton+$val['salestats']->puton;?>
                                <tr>

                                    <td>
                                    <?php $u = User::find($val['salestats']->booker_id);?>
                                    @if(!empty($u))
                                        <img src="{{$u->avatar_link()}}" width=30px>
                                    @else
                                        <img src="{{URL::to_asset('images/avatar.jpg')}}" width=30px>
                                    @endif
                                    	<a href="{{URL::to('users/profile')}}/{{$val['salestats']->booker_id}}">
                                     		<button class="btn btn-mini btn-primary">VIEW USER PROFILE</button>
                                     	</a>
                                    	<span style="margin-top:10px;margin-left:10px;">{{strtoupper($val['salestats']->booked_by)}}</span>
                             		</td>
                                    <td><span class='label bigtext label-success special blackText'>{{$val['salestats']->total}}</span></td>
                                    
                                    
                                    @foreach($apptimes as $v)
                        				@if($v->booker_id==$val['salestats']->booker_id)
                        				    <?php $p = 1;?>
                        				    <td><center>@if($v->slotone!=0)<span class="label bigtext label-info">{{$v->slotone}}</span>@endif</center></td>
                        				    <td><center>@if($v->slottwo!=0)<span class="label bigtext label-info">{{$v->slottwo}}</span>@endif</center></td>
                        				    <td><center>@if($v->slotthree!=0)<span class="label bigtext label-info">{{$v->slotthree}}</span>@endif</center></td>
                        				    <td><center>@if($v->slotfour!=0)<span class="label bigtext label-info">{{$v->slotfour}}</span>@endif</center></td>
                        				    <td><center>@if($v->slotfive!=0)<span class="label bigtext label-info">{{$v->slotfive}}</span>@endif</center></td>
                        				@endif
                    			    @endforeach
                                    <td><center>@if($val['salestats']->sales!=0)<span class='label bigtext label-success special blackText'>{{$val['salestats']->sales}}</span>@endif</center></td>
                                    <td><center>@if($val['salestats']->dns!=0)<span class='label bigtext label-important special'>{{$val['salestats']->dns}}</span>@endif</center></td>
                                    <td><center>@if($val['salestats']->inc!=0)<span class='label bigtext label-warning special blackText'>{{$val['salestats']->inc}}</span>@endif</center></td>
                                    <td><center>@if($val['salestats']->cxl!=0)<span class='label bigtext label-important special blackText'>{{$val['salestats']->cxl}}</span>@endif</center></td>
                                    <td><center>@if($val['salestats']->puton!=0)<span class='label bigtext label-info special' style='color:white;'>{{$val['salestats']->puton}}</span>@endif</center></td>
                                    <td><center><span id="bps-{{$val['salestats']->booker_id}}"></span></center></td>
                                    <td>{{number_format($val['salestats']->hold,2,'.','')}}%</td>
                                    <td style="width:9%;"><input type="text" class="tooltwo hourly" title="This is an estimate based on the call data." data-puton="{{$val['salestats']->puton}}" data-booked="{{$val['salestats']->total}}" data-pay="{{$val['payrate']}}" name="{{$val['salestats']->booker_id}}" style="width:65%;" value="{{$u->hours($startdate,$enddate)}}" /> </td>
                                    <td>${{$val['payrate']}}/hr</td>
                                    <td>
                                        <span id="bookper-{{$val['salestats']->booker_id}}"> </span>
                                    </td>
                                    <td>
                                        <span id="cpd-{{$val['salestats']->booker_id}}"> </span>
                                    </td>
                                </tr>
                                @endforeach
                                <tr style="background:#4e4e4e;color:#fff;font-weight:bolder;" >
                                    <td><strong>TOTAL</strong></td>
                                    <td>{{$total}}</td>
                                    <td></td><td></td><td></td><td></td><td></td><td></td>
                                    <td>{{$sales}}</td>
                                    <td>{{$dns}}</td>
                                    <td>{{$inc}}</td>
                                    <td>{{$cxl}}</td>
                                    <td>{{$puton}}</td>
                                    <td>@if(($puton!=0)&&($total!=0)){{number_format(($puton/$total*100),2,'.','')}}% @else 0 % @endif</td>
                                    <td></td><td></td><td></td><td></td><td></td>
                                </tr>
                                </tbody>
                            </table>
                            </div>
                            <div class="row-fluid well" style="margin-top:20px;">
                            	<div class="largestats end ">
                            	    <span class="bignum2 BOOK">$<span class='finaltotal'></span></span><br/>
                            	    <h5>TOTAL MARKETING $</h5>
                            	</div>
                            	<div class="largestats end ">
                            	    <span class="bignum2 BOOK">$<span class='costperdem'>{{$puton}}</span></span><br/>
                            	    <h5>COST PER DEM</h5>
                            	</div>
                            	<div class="largestats end ">
                            	    <span class="bignum2 PUTON">$<span class='costpersale'>{{$sales}}</span></span><br/>
                            	    <h5>COST PER SALE</h5>
                            	</div>

                            	<div class="span3">
                                <h5>HOLD RATIO</h5>
                                	<?php if(($puton!=0)&&($total!=0)){$valu=number_format(($puton/$total)*100,2,'.','');} else{$valu=0;};?>
                                	<div class="guagechart" style="width:170px;height:100px;float:left;margin-left:0px;">
                                	    <canvas id="hold" data-value="{{$valu}}" style="width:93%;"></canvas>
                                	</div><br/>
                                	<span class="badge badge-info special" style="font-size:25px;padding:10px;"><span id="spanhold"></span>&nbsp;%</span>
                            	</div>
                            	<div class="span3">
                                <h5>SALE PERCENTAGE</h5>
                                  <?php if(($sales!=0)&&($puton!=0)){$valu=number_format(($sales/($sales+$dns))*100,2,'.','');} else{$valu=0;};?>
                                	<div class="guagechart" style="width:170px;height:100px;float:left;margin-left:0px;">
                                	    <canvas id="sales"  data-value="{{$valu}}" style="width:93%;"></canvas>
                                	</div><br/>
                                	<span class="badge badge-success special" style="font-size:25px;padding:10px;"><span id="spansales"></span>&nbsp;%</span>
                            	</div>
                            </div>

                            <div class="row-fluid" style="margin-top:20px;">

                            	<div class="span4">
                            		<table class="table table-condensed totaltable">

                            			<tbody>
                            			<tr><td>Total Phone Room Booking Hours</td><td>{{$hours}}</td></tr>
                            			<tr><td>Total Marketing Hours</td><td>{{$totalmarketing}}</td></tr>
                            			<tr><td>Total Booked</td><td>{{$total}}</td></tr>
                            			<tr><td>Total Demos</td><td>{{$puton}}</td></tr>
                            			<tr><td>Total Puton</td><td>{{$sales+$dns}}</td></tr>
                            			</tbody>
                            		</table>

                            		<table class="table table-condensed totaltable" style="margin-top:20px;">
                            			<tbody>
                            			<tr><td>Hold Ratio</td><td>@if(($puton!=0)&&($total!=0)){{number_format(($puton/$total)*100,2,'.','')}}%@else 0 @endif</td></tr>
                            			<tr><td>Set Ratio (Apts / Hour)</td><td>@if(($puton!=0)&&($hours!=0)){{number_format($puton/$hours,2,'.','')}}%@else 0 @endif</td></tr>
                            			<tr><td>Total MA's</td><td>{{$totalmas}}</td></tr>
                            			<tr><td>Mall Shows</td><td></td></tr>
                            			<tr><td>Flyers</td><td></td></tr>
                            			<tr><td>DR Hours</td><td></td></tr>
                            			<tr><td>Door Reggies</td><td>{{$totalreggies}}</td></tr>
                            			</tbody>

                            		</table>
                            			<table class="table table-condensed totaltable" style="margin-top:20px;">
                            			
                            		
                            			<tr><td>Phone Marketing</td><td>$<span class='totalhours total'></span></td></tr>
                            			<tr><td>Door Reggies</td><td>$<span class='total'>{{$totalreggies*3}}</span></td></tr>
                            			<tr><td>Manilla's</td><td>$<span class='total'>{{($totalmas/7)*10.50}}</span></td></tr>
                            			<tr></tr>
                            			<tr><td>TOTAL MARKETING COST</td><td>$<span class='finaltotal'></span></td></tr>
                            			</tbody>
                            		</table>
                            	</div>



                            </div>
				
</div>
<!--end fluid-container-->
<div class="push"></div>
<!---SCRIPTS FOR THIS PAGE-->

<script src="{{URL::to_asset('js/timepicker.js')}}"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&amp;language=en"></script>
<script src="{{URL::to_asset('js/include/guage.min.js')}}"></script>



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
$(document).ready(function(){

$('.marketingstats tr').each(function(i,val){
	var type = $(this).data('leadtype');
	$('.leadtypebox').hide();
if(type=="paper"){
	
	$(this).show();
}});

$('.box-paper').show();

$('.filter').click(function(){
var type=$(this).data("filter");
$('.leadtypebox').hide();
if(type=="survey"){
    $('#close-survey').html("Done Survey");
    $('#nid').html("NID / NI");
} else {
    $('#close-survey').html("Close %");
    $('#nid').html("NI");
}
$('.marketingstats tr').hide();
$('.'+type).show();
$('.box-'+type).show();
});


var sales = $('#sales').data('value');
getguageslim(sales, 'sales', 100,'spansales');
var holdval = $('#hold').data('value');
getguageslim(holdval, 'hold', 100,'spanhold');



	
	totalhours = 0;
	$('.hourly').each(function(i,val){
        var pay = $(this).data('pay');
        var hours = $(this).val();
        totalhours+=hours*pay;
	    resetStats($(this));
    
	});

	$('span.totalhours').html(totalhours);

	$('.hourly').blur(function(){
        resetStats($(this));
    });

    function resetStats(theElement){
        var id = theElement.attr('name');
        var pay = theElement.data('pay');
        var booked = theElement.data('booked');
        var puton = theElement.data('puton');
        var bps = $('#bps-'+id);var cpd = $('#cpd-'+id);bookper=$('#bookper-'+id);
        var hours = theElement.val();
        if(hours==0){
            $('#bookper-'+id).html("N/A");
        } else {
            $('#bookper-'+id).html(((puton/hours)*100).toFixed(0)+"%");
        }
        var b = (booked/hours).toFixed(2);
        if(isNaN(b)){bps.html("");} else if(isFinite(b)) {
        bps.html((booked/hours).toFixed(2));}
        if(puton==0){
            cpd.html("$"+((hours*pay)).toFixed(2));
        } else {
             cpd.html("$"+((hours*pay)/puton).toFixed(2));
        }
        if(hours==0){
            bookper.html("N/A");
        } else {
            bookper.html(((puton/hours)*100).toFixed(0)+"%");
        }
    }

	thetotal=0;cpd=0;cps=0;
	$('.total').each(function(){
		var amount = $(this).html();
		thetotal=eval(thetotal)+eval(amount);	
		cpd = $('.costperdem').html();
		cps = $('.costpersale').html();
	});

	$('.finaltotal').html(thetotal);
	if((cpd!=0)&&(cps!=0)&&(thetotal!=0)){
   	$('.costperdem').html((thetotal/cpd).toFixed(2));
   	$('.costpersale').html((thetotal/cps).toFixed(2));}

        $('#dtable2').dataTable({
            // define table layout
            "sDom" : "<'row-fluid dt-header'<'span6'f><'span6 hidden-phone'T>r>t<'row-fluid dt-footer'<'span6 visible-desktop'i><'span6'p>>",
            // add paging 
            "sPaginationType" : "bootstrap",
            "oLanguage" : {
                "sLengthMenu" : "Showing: 25",
                "sSearch": "" 
            },
            "aaSorting": [],
            "aLengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "All"]],
            "iDisplayLength":500,
            "oTableTools": {
                "sSwfPath": "../js/include/assets/DT/swf/copy_csv_xls_pdf.swf",
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sButtonText": '<i class="cus-doc-excel-table oTable-adjust"></i>'+" BACKUP TO EXCEL"
                    }
                ]
            }
        }); 


$('.showavailable').click(function(){
$('.CXL').toggle();
$('.RB-TF').toggle();
$('.RB-OF').toggle();
$('.SOLD').toggle();
$('.INC').toggle();
$('.NQ').toggle();
$('.DNS').toggle();
});



});
</script>
@endsection