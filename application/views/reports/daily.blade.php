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
<?php $totalsurveys=0;$totalmas=0;$totalreggies=0;$totalscratch=0;$totalsold=0;$totaldems=0;$tot_slotone=0;$tot_slottwo=0;$tot_slotthree=0;$tot_slotfour=0;$tot_slotfive=0;?>
@if(!empty($paperanddoor))

<?php foreach($paperanddoor as $val){
if($val->original_leadtype=="paper" ){
	$totalsurveys += $val->tot;
	$totalmas += $val->tot;
} else if($val->original_leadtype=="secondtier"){
    $totalsts += $val->totsecondtier;
} else if($val->original_leadtype=="door"){
	$totalsurveys = $totalsurveys+$val->tot;
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


<div id="main"  class="container-fluid lightPaperBack" style="min-height:1000px;padding:45px;padding-top:30px;padding-bottom:800px;">
				<h3>{{$title}} 
                    @include('plugins.reportmenu')
				</h3>
                <div style="margin-top:40px;"><center>
                <?php $todaysDate = date('Y-m-d');?>
                @for($i=7;$i>=1;$i--)
                <a href="{{URL::to('reports/dailysnapshot')}}?startdate={{date('Y-m-d',strtotime($todaysDate. ' - '.$i.' days'))}}&enddate={{date('Y-m-d',strtotime($todaysDate. ' - '.$i.' days'))}}">
                    <button class='btn btn-default btn-large @if($startdate==date('Y-m-d',strtotime($todaysDate. ' - '.$i.' days'))) btn-inverse  @else btn-default @endif btn-default medShadow'>
                        <span class='small' style='font-weight:normal;font-size:14px;' >{{date('D d',strtotime($todaysDate. ' - '.$i.' days'))}}</span>
                    </button>
                </a>                
                @endfor
                <a href="{{URL::to('reports/dailysnapshot')}}?startdate={{date('Y-m-d',strtotime($todaysDate))}}&enddate={{date('Y-m-d',strtotime($todaysDate))}}">
                    <button class='btn btn-default btn-large @if($startdate==date('Y-m-d',strtotime($todaysDate))) btn-inverse  @else btn-default @endif btn-default medShadow'>
                        <span class='small' style='font-weight:normal;font-size:14px;' >{{date('D d',strtotime($todaysDate))}}</span>
                    </button>
                </a>
                @for($i=1;$i<=7;$i++)
                <a href="{{URL::to('reports/dailysnapshot')}}?startdate={{date('Y-m-d',strtotime($todaysDate. ' + '.$i.' days'))}}&enddate={{date('Y-m-d',strtotime($todaysDate. ' + '.$i.' days'))}}">
                    <button class='btn btn-default btn-large @if($startdate==date('Y-m-d',strtotime($todaysDate. ' + '.$i.' days'))) btn-inverse  @else btn-default @endif btn-default medShadow'>
                        <span class='small' style='font-weight:normal;font-size:14px;' >{{date('D d',strtotime($todaysDate. ' + '.$i.' days'))}}</span>
                    </button>
                </a>
                @endfor
                </center>
            </div>
            <div class="row-fluid">
                                <br/>
                                <h3>Sales Snapshot For {{$startdate}}</h3>
                                <table class="table apptable medShadow" style="margin-top:20px;" id="dailyTable">
                                <thead style="color:#000!important">
                                    <th style="width:12%;">Dealer</th>
                                    <th style="width:4%;">SALES </th>
                                    <th style="width:2%;">MAJ UNITS</th>
                                    <th style="width:2%;">DEF UNITS</th>
                                    <th style="width:2%;">TOTAL UNITS </th>
                                    <th>Nova</th>
                                    <th>Mega</th>
                                    <th>Super</th>
                                    <th>System</th>
                                    <th>Majestic</th>
                                    <th>2 Maj</th>
                                    <th>3 Maj</th>
                                    <th>Defender</th>
                                    <th>2 Def</th>
                                    <th>3 Def</th>
                                    <th>DNS</th>
                                    <th>CXL</th>
                                    <th>INC</th>
                                    <th style="width:5%;">RB-TF</th>
                                    <th style="width:5%;">RB-OF</th>
                                    <th>Close %</th>
                                    <th>COM</th>
                                </thead>
                                <tbody class='marketingstats'>
                                <?php $disp=0;$mega=0; $userdef=0;$nova=0;$twomaj=0; $threemaj=0; $twodef=0; $threedef=0; $super=0;$sys=0; $maj=0;$def=0;$dns=0;$inc=0;$cxl=0;$rb=0;$rbof=0;$rbtf=0;$close=0;$complete=0;$sales=0;$total=0;$totnits=0;$totsales=0;?>
                                
                                @if(!empty($salestats))
                                @foreach($salestats as $val)
                                    @if(isset($val["name"]))
                                    @if($val["name"]!="totals")
                                      <?php $u=User::find($val["rep_id"]);?>
                                    @if($u)
                                    <?php if($u->level==99){$active = "notactive";} else {$active = "isactive";};?>

                                    <tr class='{{$active}} allReps'>
                                    
                                    <?php $label = ($val["grosssales"]>0) ? $label="success special" : $label = "inverse";?>
                                    <td>
                                        <div class='shadowBOX animated fadeInUp toggleView saleHistory-{{$u->id}}' style='padding:15px;position:absolute;background:#ddd; z-index:50000;display:none;border-radius:5px;background:white;border:1px solid #1f1f1f;margin-left:210px;margin-top:3px;'>
                                    <h4 style="margin-top:-7px;">Appointment Details</h4>
                                    <table class='table table-condensed'>
                                        <th>Time</th><th>Address</th><th>City</th><th>Dispatched</th><th>In | Out</th><th>Result</th>
                                    @foreach($appointments as $a)

                                        @if($a->rep_id==$u->id || $a->ridealong_id==$u->id)

                                        <?php if($a->status=="SOLD"){$l = "success special blackText";} else if($a->status=="DNS"){$l="important special";}
                                        else if($a->status=="INC"){$l="warning blackText special";} else if($a->status=="CXL"){$l="inverse";} else if($a->status=="NQ"){$l="important";}
                                        else {$l="";};?>
                                        <tr>
                                            <td>{{date('h:i a',strtotime($a->app_time))}}</td>
                                            <td>{{$a->lead->address}}</td>
                                            <td>{{$a->lead->city}}</td>
                                            <td> @if(!empty($a->rep_id))<span class='label label-info special'>{{User::find($a->rep_id)->truncName()}} </span> @endif 
                                                @if(!empty($a->ridealong_id)) <span class='label label-warning blackText special'><img src='{{URL::to("img/ride-along.png")}}' width=17px height=21px> {{User::find($a->ridealong_id)->truncName()}} </span>  @endif
                                            </td>
                                            <td>@if($a->in!='00:00:00') 
                                                {{date('h:i a',strtotime($a->in))}} 
                                                @else N/A 
                                                @endif | 
                                                @if($a->out!='00:00:00') 
                                                {{date('h:i a',strtotime($a->out))}} 
                                                @else N/A 
                                                @endif
                                            </td>
                                            <td><span class='label label-{{$l}}'>{{$a->status}}</span> @if($a->status=="SOLD") <?php if($a->systemsale=="3defenders"){$sale="3 Defenders";} else if($a->systemsale=="2maj"){$sale="2 Majestics";} else if ($a->systemsale=="3maj"){$sale="3 Majestics";} else if($a->systemsale=="3defenders"){$sale="3 Defenders";} else {$sale=ucfirst($a->systemsale);};?>| {{$sale}} @endif</td>
                                        </tr>
                                        @endif
                                    @endforeach
                                    </table>
                                    </div>
                                        <img src="{{$u->avatar_link()}}" width=30px>
                                        {{$val["name"]}} 
                                        @if($val["appointment"]["DISP"]!=0) 
                                        <span class='stillDISP animated shake badge badge-important special pull-right tooltwo revealDetails pull-right'  data-type='dispatched' data-id='{{$val["rep_id"]}}' title='Rep still has appointments leftover on Board. Click to finalize these appointments'>{{$val["appointment"]["DISP"]}} Disp.</span>@endif
                                        <br/>
                                        <button class="btn btn-mini btn-primary viewHourly" data-id="{{$u->id}}"> VIEW DETAILS</button>
                                    </td>
                                    <td>@if($val["grosssales"]!=0) <span class='label label-inverse bigtext' style='color:#fff;'>{{$val["grosssales"]}} Sales </span>@endif</td>
                                    
                                    <td>@if($val["grossmd"]["majestic"]!=0)<center><span class="label label-units special bigtext " >{{$val["grossmd"]["majestic"]}}</span></center>@endif
                                    </td>
                                    <td>@if($val["grossmd"]["defender"]!=0)<center><span class="label label-units special bigtext " >{{$val["grossmd"]["defender"]}}</span></center>@endif
                                    </td>
                                    <td>@if($val["totgrossunits"]!=0)<center><span class="label label-units special bigtext " >{{$val["totgrossunits"]}}</span></center>@endif
                                    </td>
                                    <td><center>@if($val["grosssale"]["novasystem"]!=0)<span class="label label-success special bigtext">{{$val["grosssale"]["novasystem"]}}</span>@endif</center></td>
                                    <td><center>@if($val["grosssale"]["megasystem"]!=0)<span class="label label-success special bigtext">{{$val["grosssale"]["megasystem"]}}</span>@endif</center></td>
                                    <td><center>@if($val["grosssale"]["supersystem"]!=0)<span class="label label-success special bigtext">{{$val["grosssale"]["supersystem"]}}</span>@endif</center></td>
                                    <td><center>@if($val["grosssale"]["system"]!=0)<span class="label label-success special bigtext">{{$val["grosssale"]["system"]}}</span>@endif</center></td>
                                    <td><center>@if($val["grosssale"]["majestic"]!=0)<span class="label label-success special bigtext">{{$val["grosssale"]["majestic"]}}</span>@endif</center></td>
                                    <td><center>@if($val["grosssale"]["2maj"]!=0)<span class="label label-success special bigtext">{{$val["grosssale"]["2maj"]}}</span>@endif</center></td>
                                    <td><center>@if($val["grosssale"]["3maj"]!=0)<span class="label label-success special bigtext">{{$val["grosssale"]["3maj"]}}</span>@endif</center></td>
                                    <td><center>@if($val["grosssale"]["defender"]!=0)<span class="label label-success special bigtext">{{$val["grosssale"]["defender"]}}</span>@endif</center></td>
                                    <td><center>@if($val["grosssale"]["2defenders"]!=0)<span class="label label-success special bigtext">{{$val["grosssale"]["2defenders"]}}</span>@endif</center></td>
                                    <td><center>@if($val["grosssale"]["3defenders"]!=0)<span class="label label-success special bigtext">{{$val["grosssale"]["3defenders"]}}</span>@endif</center></td>
                                    <td><center>@if($val["appointment"]["DNS"]!=0)<span class="label bigtext label-important special" style="color:white;">{{$val["appointment"]["DNS"]}}</span>@endif</center></td>
                                    <td><center>@if($val["appointment"]["CXL"]!=0)<span class="label bigtext label-warning" style="color:#000">{{$val["appointment"]["CXL"]}}</span>@endif</center></td>
                                    <td><center>@if($val["appointment"]["INC"]!=0)<span class="label bigtext label-warning special" style="color:#000">{{$val["appointment"]["INC"]}}</span>@endif</center></td>
                                    <td><center>@if($val["appointment"]["RBTF"]!=0)<span class="label bigtext label-info special" style="color:white;">{{$val["appointment"]["RBTF"]}}</span>@endif</center></td>
                                    <td><center>@if($val["appointment"]["RBOF"]!=0)<span class="label bigtext label-info special" style="color:white;">{{$val["appointment"]["RBOF"]}}</span>@endif</center></td>
                                    <td><center>@if($val["appointment"]["CLOSE"]!=0)<span class="label bigtext label-inverse" style="color:white;">{{number_format($val["appointment"]["CLOSE"],2,'.','')}}%</span>@endif</center></td>
                                    <td><center>@if(($val["appointment"]["COMPLETE"]!=0)&&($val["appointment"]["COMPLETE"]!=100))<span class="label bigtext label-inverse special" style="color:white;">{{number_format($val["appointment"]["COMPLETE"],2,'.','')}}%</span>@endif</center></td>
                                </tr>
                                    @endif
                                    <?php
                                
                                    $dns=$dns+$val["appointment"]["DNS"];$cxl=$cxl+$val["appointment"]["CXL"];
                                    $inc=$inc+$val["appointment"]["INC"];$rbtf=$rbtf+$val["appointment"]["RBTF"];
                                    $rbof=$rbof+$val["appointment"]["RBOF"];
                                    ;?>
                                    @endif
                                    @endif
                                @endforeach

                                @endif
                                <tr style="height:15px;background:#3e3e3e"><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                                </tr>
                                <tr style="background:#6e6e6e;color:#fff">
                                    <td>

                                    </td>
                                    <?php $tot=$salestats["totals"];$app=$salestats["totals"]["appointment"];?>
                                    <td><span class="totalStat label label-inverse" style='color:#fff;'>{{$tot["grosssales"]}} Sales</span></td>
                                    <td><center>@if($tot["grossmd"]["majestic"]!=0)<span class="totalStat label label-info special blacktext">{{$tot["grossmd"]["majestic"]}}</span>@endif</center></td>
                                    <td><center>@if($tot["grossmd"]["defender"]!=0)<span class="totalStat label label-info special blacktext">{{$tot["grossmd"]["defender"]}}</span>@endif</center></td>
                                    <td><center>@if($tot["totgrossunits"]!=0)<span class="totalStat label label-info special blacktext">{{$tot["totgrossunits"]}}</span>@endif</center></td>
                                    <td><center>@if($tot["grosssale"]["novasystem"]!=0)<span class="totalStat label label-success special blacktext" >{{$tot["grosssale"]["novasystem"]}}</span>@endif</center></td>
                                    <td><center>@if($tot["grosssale"]["megasystem"]!=0)<span class="totalStat label label-success special blacktext">{{$tot["grosssale"]["megasystem"]}}</span>@endif</center></td>
                                    <td><center>@if($tot["grosssale"]["supersystem"]!=0)<span class="totalStat label label-success special blacktext">{{$tot["grosssale"]["supersystem"]}}</span>@endif</center></td>
                                    <td><center>@if($tot["grosssale"]["system"]!=0)<span class="totalStat label label-success special blacktext">{{$tot["grosssale"]["system"]}}</span>@endif</center></td>
                                    <td><center>@if($tot["grosssale"]["majestic"]!=0 )<span class="totalStat label label-success special blacktext">{{$tot["grosssale"]["majestic"]}}</span>@endif</center></td>
                                    <td><center>@if($tot["grosssale"]["2maj"]!=0)<span class="totalStat label label-success special blacktext">{{$tot["grosssale"]["2maj"]}}</span>@endif</center></td>
                                    <td><center>@if($tot["grosssale"]["3maj"]!=0)<span class="totalStat label label-success special blacktext">{{$tot["grosssale"]["3maj"]}}</span>@endif</center></td>
                                    <td><center>@if($tot["grosssale"]["defender"]!=0 )<span class="totalStat label label-success special blacktext">{{$tot["grosssale"]["defender"] }}</span>@endif</center></td>
                                    <td><center>@if($tot["grosssale"]["2defenders"]!=0 )<span class="totalStat label label-success special blacktext">{{$tot["grosssale"]["2defenders"] }}</span>@endif</center></td>
                                    <td><center>@if($tot["grosssale"]["3defenders"]!=0 )<span class="totalStat label label-success special blacktext">{{$tot["grosssale"]["3defenders"] }}</span>@endif</center></td>
                                    <td><center>@if($app["DNS"]!=0)<span class="totalStat label label-important special">{{$app["DNS"]}}</span>@endif</center></td>
                                    <td><center>@if($cxl!=0)<span class="totalStat label label-warning" style="color:#000">{{$cxl}}</span>@endif</center></td>
                                    <td><center>@if($inc!=0)<span class="totalStat label label-warning special" style="color:#000">{{$inc}}</span>@endif</center></td>
                                    <td><center>@if($rbtf!=0)<span class="totalStat label label-info special">{{$rbtf}}</span>@endif</center></td>
                                    <td><center>@if($rbof!=0)<span class="totalStat label label-info special">{{$rbof}}</span>@endif</center></td>
                                    <td><center>@if(($tot["grosssales"]!=0)&&($dns!=0))<span class="totalStat label label-inverse">{{$app["CLOSE"]}}%</span>    @endif</center></td>
                                    <td><center>@if(($totsales+$dns!=0)&&($cxl+$inc+$rbtf+$rbof+$dns+$totsales!=0))<span class="totalStat label label-inverse special">
                                    {{number_format(100-(($tot["grosssales"]+$app["DNS"])/($cxl+$inc+$rbtf+$rbof+$tot["grosssales"]+$app["DNS"]))*100,2,'.','')}}%</span>@endif</center>
                                </tr>
                            </tbody>
                            </table>
                            </div>
                 			<div class="row-fluid">
                                <br/>
                                <h3>Marketing Snapshot For {{$startdate}}</h3>
                                <table class="table apptable medShadow" style="margin-top:20px;" id="dailyTable">
                                <thead>
                                    <tr><th style="width:1%;"></th>
                                        <th style="width:25%;">Booker</th>
                                        <th></th>
                                        <th>Calls</th>
                                        <th>Booked</th>
                                        <th>NI</th>
                                        <th>NQ</th>
                                        <th>DNC</th>
                                        <th>NH</th>
                                        <th>RECALL</th>
                                        <th>WRONG</th>
                                        <th>CONF</th>
                                        <th>NA</th>
                                        <th></th>
                                        <th>Running</th>
                                        <th>SOLD</th>
                                        <th>DNS</th>
                                        <th>INC</th>
                                        <th>CXL</th>
                                        <th>RB-TF</th>
                                        <th>RB-OF</th>
                                        <th>PUT ON</th>
                                        <th></th>
                                        <th>BPH</th>
                                        <th>HOLD %</th>
                                        <th style="width:1%;">HRS</th>
                                        <th>PAYRATE</th>
                                        <th>BOOK %</th>
                                        <th>CPD</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $total=0;$sales=0;$dns=0;$inc=0;$puton=0;$hours=0;$cxl=0;
                                        $totalcalls=0;$totalapps=0;$totalni=0;$totalnq=0;$totalnh=0;$totaldnc=0;$totalwrong=0;$totalrecall=0;
                                        $totalnas=0;$totalconfirms=0;$rbtf=0;$rbof=0

                                ?>


                                @foreach($bookdetails as $val)
                                <?php 
                                if(!empty($val['callstats'])){
                                    $totalcalls = $totalcalls+$val['callstats']->totals;
                                    $totalrecall = $totalrecall+$val['callstats']->recall;
                                    $totalwrong = $totalwrong+$val['callstats']->wrong;
                                    $totalnh = $totalnh+$val['callstats']->nh;
                                    $totalni = $totalni+$val['callstats']->ni;
                                    $totalnq = $totalnq+$val['callstats']->nq;
                                    $totaldnc = $totaldnc+$val['callstats']->dnc;
                                    $totalapps = $totalapps+$val['callstats']->app;
                                    $totalconfirms = $totalconfirms+$val['callstats']->confirms;
                                    $totalnas = $totalnas+$val['callstats']->na;
                                }
                               
                                $total=$total+$val['salestats']->total;
                                $sales=$sales+$val['salestats']->sales;
                                $dns=$dns+$val['salestats']->dns;
                                $inc=$inc+$val['salestats']->inc;
                                $cxl=$cxl+$val['salestats']->cxl;
                                $rbtf=$rbtf+$val['salestats']->rbtf;
                                $rbof=$rbof+$val['salestats']->rbof;
                                $puton=$puton+$val['salestats']->puton;?>
                                <tr><td style='background:#3f3f3f;'></td>
                                    <td>
                                    <?php $u = User::find($val['salestats']->booker_id);?>
                                    @if(!empty($u))
                                        <img src="{{$u->avatar_link()}}" width=30px>
                                    @else
                                        <img src="{{URL::to_asset('images/avatar.jpg')}}" width=30px>
                                    @endif
                                    	<span style="margin-top:10px;margin-left:10px;">{{strtoupper($val['salestats']->booked_by)}} @if(!empty($val['callstats'])) | <b>Avg Time : </b><span class='label label-info special'>{{$val['callstats']->avgtime}}</span> @endif</span><br/>
                                        <button class="btn btn-mini btn-primary viewHourly" data-id="{{$u->id}}">VIEW HOURLY BREAKDOWN</button>
                             		</td>
                                    <td style='background:#3f3f3f;'></td>
                                    @if(!empty($val['callstats']))

                                    <td><center>@if($val['callstats']->totals!=0) <span class="label bigtext label-inverse " style='color:white'>{{$val['callstats']->totals}} </span>@endif</center></td>
                                    <td><center>@if($val['callstats']->app!=0) <span class="label bigtext label-success special"> {{$val['callstats']->app}} </span>@endif</center></td>
                                    <td><center>@if($val['callstats']->ni!=0) <span class="label bigtext label-important"> {{$val['callstats']->ni}} </span>@endif</center></td>
                                    <td><center>@if($val['callstats']->nq!=0) <span class="label bigtext label-important"> {{$val['callstats']->nq}} </span>@endif</center></td>
                                    <td><center>@if($val['callstats']->dnc!=0) <span class="label bigtext label-important special"> {{$val['callstats']->dnc}} </span>@endif</center></td>
                                    <td><center>@if($val['callstats']->nh!=0) <span class="label bigtext label-info"> {{$val['callstats']->nh}} </span>@endif</center></td>
                                    <td><center>@if($val['callstats']->recall!=0) <span class="label bigtext label-warning special"> {{$val['callstats']->recall}} </span>@endif</center></td>
                                    <td><center>@if($val['callstats']->wrong!=0) <span class="label bigtext label-warning"> {{$val['callstats']->wrong}} </span>@endif</center></td>
                                    <td><center>@if($val['callstats']->confirms!=0) <span class="label bigtext label-success"> {{$val['callstats']->confirms}} </span>@endif</center></td>
                                    <td><center>@if($val['callstats']->na!=0) <span class="label bigtext"> {{$val['callstats']->na}} </span>@endif</center></td>
                                    @else
                                    <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                                    @endif
                                    <td style='background:#3f3f3f;'>
                                        <div class='shadowBOX animated fadeInUp toggleView saleHistory-{{$u->id}}' style='padding:15px;position:absolute;background:#ddd; z-index:50000;display:none;border-radius:5px;background:white;border:1px solid #1f1f1f;width:550px;margin-left:30px;margin-top:70px;'>
                                    <h4 style="margin-top:-7px;">Appointment Details</h4>
                                    <table class='table table-condensed'>
                                        <th>Time</th><th>City</th><th>Dispatched</th><th>Result</th>
                                    @foreach($appointments as $a)
                                        @if($a->booker_id==$u->id)
                                        <?php if($a->status=="SOLD"){$l = "success special blackText";} else if($a->status=="DNS"){$l="important special";}
                                        else if($a->status=="INC"){$l="warning blackText special";} else if($a->status=="CXL"){$l="inverse";} else if($a->status=="NQ"){$l="important";}
                                        else {$l="";};?>
                                        <tr>
                                            <td>{{date('h:i a',strtotime($a->app_time))}}</td>
                                            <td>{{$a->lead->city}}</td>
                                            <td> @if(!empty($a->rep_name))<span class='label label-info special'>{{$a->rep_name}} </span>@endif</td>
                                            <td><span class='label label-{{$l}}'>{{$a->status}}</span> @if($a->status=="SOLD") <?php if($a->systemsale=="3defenders"){$sale="3 Defenders";} else if($a->systemsale=="2maj"){$sale="2 Majestics";} else if ($a->systemsale=="3maj"){$sale="3 Majestics";} else if($a->systemsale=="3defenders"){$sale="3 Defenders";} else {$sale=ucfirst($a->systemsale);};?>| {{$sale}} @endif</td>
                                        </tr>
                                        @endif
                                    @endforeach
                                    </table>
                                </div>
                                    </td>
                                    <td><span class='label bigtext label-success special blackText'>{{$val['salestats']->total}}</span></td>
                                    <td><center>@if($val['salestats']->sales!=0)<span class='label bigtext label-success special blackText'>{{$val['salestats']->sales}}</span>@endif</center></td>
                                    <td><center>@if($val['salestats']->dns!=0)<span class='label bigtext label-important special'>{{$val['salestats']->dns}}</span>@endif</center></td>
                                    <td><center>@if($val['salestats']->inc!=0)<span class='label bigtext label-warning special blackText'>{{$val['salestats']->inc}}</span>@endif</center></td>
                                    <td><center>@if($val['salestats']->cxl!=0)<span class='label bigtext label-important special blackText'>{{$val['salestats']->cxl}}</span>@endif</center></td>
                                    <td><center>@if($val['salestats']->rbtf!=0)<span class='label bigtext  special' style='color:white;'>{{$val['salestats']->rbtf}}</span>@endif</center></td>
                                    <td><center>@if($val['salestats']->rbof!=0)<span class='label bigtext  special' style='color:white;'>{{$val['salestats']->rbof}}</span>@endif</center></td>
                                    <td><center>@if($val['salestats']->puton!=0)<span class='label bigtext label-info special' style='color:white;'>{{$val['salestats']->puton}}</span>@endif</center></td>
                                    <td style='background:#3f3f3f;'></td>
                                    <td><center><span id="bps-{{$val['salestats']->booker_id}}"></span></center></td>
                                    <td>{{number_format($val['salestats']->hold,2,'.','')}}%</td>
                                    <td style="width:4%;"><input type="text" class="tooltwo hourly" title="This is an estimate based on the call data." data-puton="{{$val['salestats']->puton}}" @if(!empty($val['callstats'])) data-booked="{{$val['callstats']->app}}" @else data-booked="" @endif data-pay="{{$val['payrate']}}" name="{{$val['salestats']->booker_id}}" style="width:65%;" value="{{$u->hours($startdate,$enddate)}}" /> </td>
                                    <td>${{$val['payrate']}}/hr</td>
                                    <td>
                                        <span id="bookper-{{$val['salestats']->booker_id}}"> </span>
                                    </td>
                                    <td>
                                        <span id="cpd-{{$val['salestats']->booker_id}}"> </span>
                                    </td>
                                </tr>
                                @if(!empty($val['hourlystats']))
                                @foreach($val['hourlystats'] as $st)
                                <tr class="animated fadeInUp toggleView hourly-{{$u->id}}" style="display:none;background:#ddd">
                                    <td style='background:#3f3f3f;'></td>
                                    <td><center>{{date('M-d h:i a',strtotime($st->cre))}} | <b>Avg Time : </b><span class='label label-info special'>{{$st->avgtime}}</span>
                                        </center>
                                    </td>
                                    <td style='background:#3f3f3f;'></td>
                                    <td><center>@if($st->tot!=0) <span class="label bigtext label-inverse " style='color:white'>{{$st->tot}} </span>@endif</center></td>
                                    <td><center>@if($st->app!=0) <span class="label bigtext label-success special"> {{$st->app}} </span>@endif</center></td>
                                    <td><center>@if($st->ni!=0) <span class="label bigtext label-important"> {{$st->ni}} </span>@endif</center></td>
                                    <td><center>@if($st->nq!=0) <span class="label bigtext label-important"> {{$st->nq}} </span>@endif</center></td>
                                    <td><center>@if($st->dnc!=0) <span class="label bigtext label-important special"> {{$st->dnc}} </span>@endif</center></td>
                                    <td><center>@if($st->nh!=0) <span class="label bigtext label-info"> {{$st->nh}} </span>@endif</center></td>
                                    <td><center>@if($st->recall!=0) <span class="label bigtext label-warning special"> {{$st->recall}} </span>@endif</center></td>
                                    <td><center>@if($st->wrong!=0) <span class="label bigtext label-warning"> {{$st->wrong}} </span>@endif</center></td>
                                    <td><center>@if($st->confirms!=0) <span class="label bigtext label-success"> {{$st->confirms}} </span>@endif</center></td>
                                    <td><center>@if($st->na!=0) <span class="label bigtext "> {{$st->na}} </span>@endif</center></td>
                                    <td style='background:#3f3f3f;'></td>
                                    <td colspan=15>

                                    </td>
                                </tr>
                                @endforeach
                                @endif
                                @endforeach
                                <tr style="background:#4e4e4e;color:#fff;font-weight:bolder;" >
                                    <td style='background:#3f3f3f;'></td>
                                    <td></td>
                                    <td></td>
                                    <td><center>{{$totalcalls}}</center></td>
                                    <td><center>{{$totalapps}}</center></td>
                                    <td><center>{{$totalni}}</center></td>
                                    <td><center>{{$totalnq}}</center></td>
                                    <td><center>{{$totaldnc}}</center></td>
                                    <td><center>{{$totalnh}}</center></td>
                                    <td><center>{{$totalrecall}}</center></td>
                                    <td><center>{{$totalwrong}}</center></td>
                                    <td><center>{{$totalconfirms}}</center></td>
                                    <td><center>{{$totalnas}}</center></td>
                                    <td></td>
                                    <td><center>{{$total}}</center></td>
                                    <td><center>{{$sales}}</center></td>
                                    <td><center>{{$dns}}</center></td>
                                    <td><center>{{$inc}}</center></td>
                                    <td><center>{{$cxl}}</center></td>
                                    <td><center>{{$rbtf}}</center></td>
                                    <td><center>{{$rbof}}</center></td>
                                    <td><center>{{$puton}}</center></td>
                                    <td></td><td></td>
                                    <td>@if(($puton!=0)&&($total!=0)){{number_format(($puton/$total*100),2,'.','')}}% @else 0 % @endif</td>
                                    <td></td><td></td><td></td><td></td>
                                </tr>
                                </tbody>
                            </table>
                            </div>

                            <div class="row-fluid" style="margin-top:20px;">
                            <div class="span12">
                                <a href='{{URL::to("reports/wrongnums")}}?startdate={{$startdate}}&enddate={{$startdate}}' target=_blank><button class="btn btn-large medShadow btn-default">WRONG NUMBER LIST FOR <b> {{date('M-d',strtotime($startdate))}} </b></button></a>

                                <a href='{{URL::to("reports/soldapps")}}?startdate={{$startdate}}&enddate={{$startdate}}' target=_blank><button class="btn btn-large medShadow btn-default">SOLD LIST FOR <b> {{date('M-d',strtotime($startdate))}} </b></button></a>
                            </div>
                            </div>
                          

                            
				
</div>
<!--end fluid-container-->
<div class="push"></div>
<!---SCRIPTS FOR THIS PAGE-->



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
$('.marketingstats tr').hide();
$('.'+type).show();
$('.box-'+type).show();
});


    $('.viewHourly').click(function(){
        var id = $(this).data('id');
        $('.toggleView').hide();
        $('.hourly-'+id).toggle();
        $('.saleHistory-'+id).toggle();
    });
	
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

    $('.toggleView').click(function(){
        $('.toggleView').hide();
    });

    function resetStats(theElement){
        var id = theElement.attr('name');
        var pay = theElement.data('pay');
        var booked = theElement.data('booked');
        var puton = theElement.data('puton');
        var bps = $('#bps-'+id);var cpd = $('#cpd-'+id);bookper=$('#bookper-'+id);
        var hours = theElement.val();
        
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