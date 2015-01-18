@layout('layouts/main')
@section('content')
<?php $setting = Setting::find(1);?>
<style>
.notactive {background:#FFE0E0;}
.isactive {background:#CCFFCC;}
.statusedit {cursor:pointer;}
.termsedit {cursor:pointer;}
.closePercent {
	font-size:15px;
	font-weight:bolder;
}
.dealerStats{
	width:100%;
	padding:15px;
	padding-bottom:5px;
	background:#3e3e3e;
	color:#fff!important;
	border:1px solid #1f1f1f;
	margin-bottom:10px;
	float:left;
}

.tbscancel {
    background:#FFCCCC;
}
.openUnitBox {cursor:pointer;}
.unitBox{display:none;}
.stillDISP{
background: #f3c5bd; /* Old browsers */
background: -moz-linear-gradient(top,  #f3c5bd 0%, #e86c57 50%, #ea2803 51%, #ff6600 75%, #c72200 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#f3c5bd), color-stop(50%,#e86c57), color-stop(51%,#ea2803), color-stop(75%,#ff6600), color-stop(100%,#c72200)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #f3c5bd 0%,#e86c57 50%,#ea2803 51%,#ff6600 75%,#c72200 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #f3c5bd 0%,#e86c57 50%,#ea2803 51%,#ff6600 75%,#c72200 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #f3c5bd 0%,#e86c57 50%,#ea2803 51%,#ff6600 75%,#c72200 100%); /* IE10+ */
background: linear-gradient(to bottom,  #f3c5bd 0%,#e86c57 50%,#ea2803 51%,#ff6600 75%,#c72200 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f3c5bd', endColorstr='#c72200',GradientType=0 ); /* IE6-9 */
	cursor:pointer;
	border:2px solid #000!important;
	margin-right:4px!important;
}

.legend {padding:5px;border-radius:5px;border:1px solid #bbb;cursor:pointer;}
.label-units {background: #b7deed; /* Old browsers */
background: -moz-linear-gradient(top,  #b7deed 0%, #71ceef 50%, #21b4e2 51%, #b7deed 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#b7deed), color-stop(50%,#71ceef), color-stop(51%,#21b4e2), color-stop(100%,#b7deed)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #b7deed 0%,#71ceef 50%,#21b4e2 51%,#b7deed 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #b7deed 0%,#71ceef 50%,#21b4e2 51%,#b7deed 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #b7deed 0%,#71ceef 50%,#21b4e2 51%,#b7deed 100%); /* IE10+ */
background: linear-gradient(to bottom,  #b7deed 0%,#71ceef 50%,#21b4e2 51%,#b7deed 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#b7deed', endColorstr='#b7deed',GradientType=0 ); /* IE6-9 */

border:1px solid #1f1f1f;}
</style>
@include('plugins.saleextra')
@if($displaystats=="no")
<style>
#statsTable {
 display:none;
}
</style>

@endif
<?php if(isset($_GET['city'])) {$city = $_GET['city'];} else {$city='all';};?>
<div id="main"  class="container-fluid lightPaperBack" style="padding:45px;padding-top:30px;padding-bottom:80px;min-height:1000px;">
	<h3>{{$title}} &nbsp;&nbsp; 
		
	@include('plugins.reportmenu')
    <a href='{{URL::to("reports/sales")}}?financedeals=true'><button class='btn btn-danger '>VIEW ALL INCOMPLETE FINANCE DEALS</button></a>
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
            	<div class='span4' style="margin-top:5px;" id="cityname">
            		<div class='double' style='float:left;'><i class='cus-doc-excel-table'></i></div>&nbsp;&nbsp;&nbsp;<b>DOWNLOAD</b> XLS REPORTS : &nbsp;&nbsp;
                		<select name='download_report' id='download_report'>
                            <option value=''></option>
                			<option value='all'>All Reports for {{date('M-d',strtotime($startdate))}} - {{date('M-d',strtotime($enddate))}}</option>
                            <option value='{{URL::to("reports/generateExcelDealer")}}?startdate={{$startdate}}&enddate={{$enddate}}' >Dealer Report for {{date('M-d',strtotime($startdate))}} - {{date('M-d',strtotime($enddate))}}</option>
                            <option value='{{URL::to("reports/generateExcelMarketing")}}?startdate={{$startdate}}&enddate={{$enddate}}' >Marketing Report {{date('M-d',strtotime($startdate))}} - {{date('M-d',strtotime($enddate))}}</option>                      
                			<option value='{{URL::to("reports/generateExcelSale")}}?startdate={{$startdate}}&enddate={{$enddate}}' >Sales Journal for {{date('M-d',strtotime($startdate))}} - {{date('M-d',strtotime($enddate))}}</option>
                            <option value='{{URL::to("reports/monthlyReport")}}?date={{$startdate}}' >Monthly Distributor Stats Report {{date('M',strtotime($startdate))}}  </option>   
                            <option value='{{URL::to("reports/generateHealthmor")}}?date={{$startdate}}' >Monthly / Weekly Distributor Stats for Week {{date('M-d',strtotime($startdate))}}</option>
                		</select>
            	</div>
            	<input type="hidden" name="displayStats" id="displayStats" value="{{$displaystats}}">
            	<button class="btn btn-default btn-small generateReport" style="margin-left:10px;margin-top:-6px;">
            		<i class="cus-application-view-tile"></i>&nbsp;GENERATE REPORT
            	</button>

            	@if($displaystats=="yes")
            	<button class="btn btn-danger btn-small right-button showStats"  style='margin-top:5px;'>
            		<i class="cus-user"></i>&nbsp;<span class='dealerStatText'>CLOSE DEALER STATS</span>
            	</button>
            	@else
            	<button class="btn btn-primary btn-small right-button showStats" style='margin-top:5px;'  >
            		<i class="cus-user"></i>&nbsp;<span class='dealerStatText'>SHOW DEALER STATS</span>
            	</button>
            	@endif
        		</form>
            	

        	<div class="row-fluid animated fadeInUp" id="statsTable" style="padding-left:20px;margin-bottom:20px;margin-top:20px;" >
                 
                  <div class="span11"  class="subtle-shadow" >
                  	
                        <h4>Week Report By Dealer for {{$title}} &nbsp;&nbsp;&nbsp; </h5>
                        	<span class='notactive legend tooltwo' title='Click to show only reps who are no longer working'>Quit / Fired</span>&nbsp;&nbsp; <span class='isactive legend tooltwo' title='Click to show only reps who are currently working' >Active Rep</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;<button class='btn btn-default pull-right switchSaleType' data-type='NET'>NET UNITS</button>&nbsp;&nbsp;<button class='btn btn-default pull-right  btn-primary switchSaleType' style="margin-right:5px;" data-type='GROSS'>GROSS UNITS</button><br/><br/>
                        <table class="table table-bordered table-condensed weekreport" style="background:white;border:1px solid #1f1f1f;" >
                            <thead style="color:#000!important">
                                <th style="width:19%;">Dealer</th>
                                <th>SALES </th>
                                <th>Prev WK (S)</th>
                                <th>MAJ UNITS</th>
                                <th>DEF UNITS</th>
                                <th>TOTAL UNITS </th>
                                <th>Prev WK (U)</th>
                                <th>Super Nova</th>
                                <th>Nova</th>
                                <th>Mega</th>
                                <th>Super</th>
                                <th>System</th>
                                <th>Majestic</th>
                                <th>Defender</th>
                                <th>DNS</th>
                                <th>CXL</th>
                                <th>INC</th>
                                <th style="width:5%;">RB-TF</th>
                                <th style="width:5%;">RB-OF</th>
                                <th>Close %</th>
                                <th>COM</th>
                                
                                
                            </thead>

                        	<tbody class='marketingstats'>
                        		
                        	    @if(!empty($mainstats))
                        	    @foreach($mainstats as $val)
                        	    	@if(isset($val["name"]))
                        	    	@if($val["name"]!="totals")
                        	    		<?php $u=User::find($val["rep_id"]);?>
                        	    		@if($u)
                        	    	<?php if($u->level==99){$active = "notactive";} else {$active = "isactive";};?>
                        	    	<tr class='{{$active}} allReps'>
                        			<?php $label = ($val["grosssales"]>0) ? $label="success special" : $label = "inverse";?>
                        			<td>{{$val["name"]}} 
                        				@if($val["appointment"]["DISP"]!=0) 
                        			<span class='stillDISP animated shake badge badge-important special pull-right tooltwo revealDetails pull-right'  data-type='dispatched' data-id='{{$val["rep_id"]}}' title='Rep still has appointments leftover on Board. Click to finalize these appointments'>{{$val["appointment"]["DISP"]}} Disp.</span>@endif
                        			</td>
                        			<td>
                                        <span class="saleColumn column-GROSS totalStat label label-inverse" style='color:#fff;'>{{$val["grosssales"]}} Sales</span>
                                         <span class="saleColumn column-NET totalStat label label-inverse" style='color:#fff;'>{{$val["netsales"]}} Sales</span>

                                    </td>
                                    <td>
                                        <center> 
                                        @if(isset($prevStats[$u->id]))<span class="saleColumn totalStat column-GROSS label label-inverse special" style="color:#fff">{{$prevStats[$u->id]["grosssales"]}}</span>
                                        <span class="saleColumn totalStat label column-NET label-inverse special" style="color:#fff">{{$prevStats[$u->id]["netsales"]}}</span>
                                        @endif
                                        </center>
                                    </td>
                                    <td><center>
                                        @if($val["grossmd"]["majestic"]!=0)<span class="totalStat label label-units saleColumn column-GROSS special blacktext">{{$val["grossmd"]["majestic"]}}</span>
                                        @endif
                                        @if($val["netmd"]["majestic"]!=0)<span class="totalStat label label-units saleColumn column-NET special blacktext">{{$val["netmd"]["majestic"]}}</span>
                                        @endif

                                    </center></td>
                        			<td><center>
                                        @if($val["grossmd"]["defender"]!=0)<span class="totalStat label label-units saleColumn column-GROSS special blacktext">{{$val["grossmd"]["defender"]}}</span>
                                        @endif
                                        @if($val["netmd"]["defender"]!=0)<span class="totalStat label label-units saleColumn column-NET special blacktext">{{$val["netmd"]["defender"]}}</span>
                                        @endif
                                    </center></td>
                                    <td><center>
                                        @if($val["totgrossunits"]!=0)<span class="totalStat label label-units saleColumn column-GROSS special blacktext">{{$val["totgrossunits"]}}</span>
                                        @endif
                                         @if($val["totnetunits"]!=0)<span class="totalStat label label-units saleColumn column-NET special blacktext">{{$val["totnetunits"]}}</span>
                                        @endif
                                    </center></td>
                                    <td>
                                        <center> 
                                        @if(isset($prevStats[$u->id]))<span class="saleColumn totalStat column-GROSS label label-units special" style="color:#000">{{$prevStats[$u->id]["totgrossunits"]}}</span>
                                        <span class="saleColumn totalStat label column-NET label-units special" style="color:#000">{{$prevStats[$u->id]["totnetunits"]}}</span>
                                        @endif
                                        </center>
                                    </td>
                                    <td><center>
                                        @if($val["grosssale"]["supernovasystem"]!=0)<span class="totalStat label label-success saleColumn column-GROSS special blacktext" >{{$val["grosssale"]["supernovasystem"]}}</span>
                                        @endif
                                        @if($val["netsale"]["supernovasystem"]!=0)<span class="totalStat label label-success saleColumn column-NET special blacktext" >{{$val["netsale"]["supernovasystem"]}}</span>
                                        @endif
                                    </center></td>


                                    <td><center>
                                        @if($val["grosssale"]["novasystem"]!=0)<span class="totalStat label label-success saleColumn column-GROSS special blacktext" >{{$val["grosssale"]["novasystem"]}}</span>
                                        @endif
                                        @if($val["netsale"]["novasystem"]!=0)<span class="totalStat label label-success saleColumn column-NET special blacktext" >{{$val["netsale"]["novasystem"]}}</span>
                                        @endif
                                    </center></td>
                                    <td><center>
                                        @if($val["grosssale"]["megasystem"]!=0)<span class="totalStat label label-success saleColumn column-GROSS special blacktext">{{$val["grosssale"]["megasystem"]}}</span>
                                        @endif
                                        @if($val["netsale"]["megasystem"]!=0)<span class="totalStat label label-success saleColumn column-NET special blacktext">{{$val["netsale"]["megasystem"]}}</span>
                                        @endif
                                    </center></td>
                                    <td><center>
                                        @if($val["grosssale"]["supersystem"]!=0)<span class="totalStat label label-success saleColumn column-GROSS special blacktext">{{$val["grosssale"]["supersystem"]}}</span>
                                        @endif
                                        @if($val["netsale"]["supersystem"]!=0)<span class="totalStat label label-success saleColumn column-NET special blacktext">{{$val["netsale"]["supersystem"]}}</span>
                                        @endif
                                    </center></td>
                                    <td><center>
                                        @if($val["grosssale"]["system"]!=0)<span class="totalStat label label-success saleColumn column-GROSS special blacktext">{{$val["grosssale"]["system"]}}</span>
                                        @endif
                                        @if($val["netsale"]["system"]!=0)<span class="totalStat label label-success saleColumn column-NET special blacktext">{{$val["netsale"]["system"]}}</span>
                                        @endif
                                    </center></td>
                                    <td><center>
                                        @if($val["grosssale"]["majestic"]!=0)<span class="totalStat label label-success saleColumn column-GROSS special blacktext">{{$val["grosssale"]["majestic"]}}</span>
                                        @endif
                                        @if($val["netsale"]["majestic"]!=0)<span class="totalStat label label-success saleColumn column-NET special blacktext">{{$val["netsale"]["majestic"]}}</span>
                                        @endif
                                    </center></td>
                                    <td><center>
                                        @if($val["grosssale"]["defender"]!=0)<span class="totalStat label label-success saleColumn column-GROSS special blacktext">{{$val["grosssale"]["defender"]}}</span>
                                        @endif
                                        @if($val["netsale"]["defender"]!=0)<span class="totalStat label label-success saleColumn column-NET special blacktext">{{$val["netsale"]["defender"]}}</span>
                                        @endif
                                    </center></td>
                        			<td><center>@if($val["appointment"]["DNS"]!=0)<span class="label label-important  totalStat special">{{$val["appointment"]["DNS"]}}</span>@endif</center></td>
                        			<td><center>@if($val["appointment"]["CXLREP"]!=0)<span class="totalStat label label-warning" style="color:#000">{{$val["appointment"]["CXLREP"]}}</span>@endif</center></td>
                        			<td><center>@if($val["appointment"]["INC"]!=0)<span class="totalStat label label-warning special" style="color:#000">{{$val["appointment"]["INC"]}}</span>@endif</center></td>
                        			<td><center>@if($val["appointment"]["RBTF"]!=0)<span class="totalStat label label-info special">{{$val["appointment"]["RBTF"]}}</span>@endif</center></td>
                        			<td><center>@if($val["appointment"]["RBOF"]!=0)<span class="totalStat label label-info special">{{$val["appointment"]["RBOF"]}}</span>@endif</center></td>
                        			<td><center>@if($val["appointment"]["CLOSE"]!=0)<span class="totalStat label label-inverse">{{number_format($val["appointment"]["CLOSE"],2,'.','')}}%</span>@endif</center></td>
                        			<td><center>@if(($val["appointment"]["COMPLETE"]!=0)&&($val["appointment"]["COMPLETE"]!=100))<span class="totalStat label label-inverse special">{{number_format($val["appointment"]["COMPLETE"],2,'.','')}}%</span>@endif</center></td>
                        		    
                                    
                                </tr>
                        	    	@endif
                        	    	@endif
                        	    	@endif
                        	    @endforeach

                        	    @endif
                        	    <tr style="height:15px;background:#3e3e3e"><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                        	    </tr>
                        		<tr style="background:#6e6e6e;color:#fff">
                       				<td>

                       				</td>
                       				<?php $tot=$mainstats["totals"];$app=$mainstats["totals"]["appointment"];?>
                       				<td>
                                        <span class="saleColumn column-GROSS totalStat label label-inverse" style='color:#fff;'>{{$tot["grosssales"]}} Sales</span>
                                         <span class="saleColumn column-NET totalStat label label-inverse" style='color:#fff;'>{{$tot["netsales"]}} Sales</span>

                                    </td>
                                    <td></td>
                       				<td><center>
                                        @if($tot["grossmd"]["majestic"]!=0)<span class="totalStat label label-units saleColumn column-GROSS special blacktext">{{$tot["grossmd"]["majestic"]}}</span>
                                        @endif
                                        @if($tot["netmd"]["majestic"]!=0)<span class="totalStat label label-units saleColumn column-NET special blacktext">{{$tot["netmd"]["majestic"]}}</span>
                                        @endif

                                    </center></td>
                       				<td><center>
                                        @if($tot["grossmd"]["defender"]!=0)<span class="totalStat label label-units saleColumn column-GROSS special blacktext">{{$tot["grossmd"]["defender"]}}</span>
                                        @endif
                                        @if($tot["netmd"]["defender"]!=0)<span class="totalStat label label-units saleColumn column-NET special blacktext">{{$tot["netmd"]["defender"]}}</span>
                                        @endif
                                    </center></td>
                       				<td><center>
                                        @if($tot["totgrossunits"]!=0)<span class="totalStat label label-units saleColumn column-GROSS special blacktext">{{$tot["totgrossunits"]}}</span>
                                        @endif
                                         @if($tot["totnetunits"]!=0)<span class="totalStat label label-units saleColumn column-NET special blacktext">{{$tot["totnetunits"]}}</span>
                                        @endif
                                    </center></td>
                                    <td></td>
                                    <td><center>
                                        @if($tot["grosssale"]["supernovasystem"]!=0)<span class="totalStat label label-success saleColumn column-GROSS special blacktext" >{{$tot["grosssale"]["supernovasystem"]}}</span>
                                        @endif
                                        @if($tot["netsale"]["supernovasystem"]!=0)<span class="totalStat label label-success saleColumn column-NET special blacktext" >{{$tot["netsale"]["supernovasystem"]}}</span>
                                        @endif
                                    </center></td>
                       				<td><center>
                                        @if($tot["grosssale"]["novasystem"]!=0)<span class="totalStat label label-success saleColumn column-GROSS special blacktext" >{{$tot["grosssale"]["novasystem"]}}</span>
                                        @endif
                                        @if($tot["netsale"]["novasystem"]!=0)<span class="totalStat label label-success saleColumn column-NET special blacktext" >{{$tot["netsale"]["novasystem"]}}</span>
                                        @endif
                                    </center></td>
                        			<td><center>
                                        @if($tot["grosssale"]["megasystem"]!=0)<span class="totalStat label label-success saleColumn column-GROSS special blacktext">{{$tot["grosssale"]["megasystem"]}}</span>
                                        @endif
                                        @if($tot["netsale"]["megasystem"]!=0)<span class="totalStat label label-success saleColumn column-NET special blacktext">{{$tot["netsale"]["megasystem"]}}</span>
                                        @endif
                                    </center></td>
                        			<td><center>
                                        @if($tot["grosssale"]["supersystem"]!=0)<span class="totalStat label label-success saleColumn column-GROSS special blacktext">{{$tot["grosssale"]["supersystem"]}}</span>
                                        @endif
                                        @if($tot["netsale"]["supersystem"]!=0)<span class="totalStat label label-success saleColumn column-NET special blacktext">{{$tot["netsale"]["supersystem"]}}</span>
                                        @endif
                                    </center></td>
                        			<td><center>
                                        @if($tot["grosssale"]["system"]!=0)<span class="totalStat label label-success saleColumn column-GROSS special blacktext">{{$tot["grosssale"]["system"]}}</span>
                                        @endif
                                        @if($tot["netsale"]["system"]!=0)<span class="totalStat label label-success saleColumn column-NET special blacktext">{{$tot["netsale"]["system"]}}</span>
                                        @endif
                                    </center></td>
                        			<td><center>
                                        @if($tot["grosssale"]["majestic"]!=0)<span class="totalStat label label-success saleColumn column-GROSS special blacktext">{{$tot["grosssale"]["majestic"]}}</span>
                                        @endif
                                        @if($tot["netsale"]["majestic"]!=0)<span class="totalStat label label-success saleColumn column-NET special blacktext">{{$tot["netsale"]["majestic"]}}</span>
                                        @endif
                                    </center></td>
                        			<td><center>
                                        @if($tot["grosssale"]["defender"]!=0)<span class="totalStat label label-success saleColumn column-GROSS special blacktext">{{$tot["grosssale"]["defender"]}}</span>
                                        @endif
                                        @if($tot["netsale"]["defender"]!=0)<span class="totalStat label label-success saleColumn column-NET special blacktext">{{$tot["netsale"]["defender"]}}</span>
                                        @endif
                                    </center></td>
                        			<td><center>@if($app['DNS']!=0)<span class="totalStat label label-important special">{{$app['DNS']}}</span>@endif</center></td>
                        			<td><center>@if($app['CXLREP']!=0)<span class="totalStat label label-warning" style="color:#000">{{$app['CXLREP']}}</span>@endif</center></td>
                        			<td><center>@if($app['INC']!=0)<span class="totalStat label label-warning special" style="color:#000">{{$app['INC']}}</span>@endif</center></td>
                        			<td><center>@if($app['RBTFREP']!=0)<span class="totalStat label label-info special">{{$app['RBTFREP']}}</span>@endif</center></td>
                        			<td><center>@if($app['RBOFREP']!=0)<span class="totalStat label label-info special">{{$app['RBOFREP']}}</span>@endif</center></td>
                        			<td><center>@if(($tot["grosssales"]!=0)&&($app['DNS']!=0))<span class="totalStat label label-inverse">{{$app['CLOSE']}}%</span>	@endif</center></td>
                        			<td><center>@if(!empty($app['COMPLETE']))<span class="totalStat label label-inverse special">
                        			{{$app["COMPLETE"]}}%</span>@endif</center></td>
                                    
                                    
                       			</tr>
                        	</tbody>
                        </table>
                        <br/><br/>
                       
    			 </div>

                  <div class="span2" style="padding-left:15px;">
                  	
                  </div>
     		</div>
    	</div>
    	<div class='row-fluid'>
  
@if($setting->quick_pick_buttons==1)
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
    		<a href='{{URL::to("reports/sales/")}}?startdate={{date("Y-m-d",strtotime($d))}}&enddate={{date("Y-m-d",$date)}}'>
    			<button class='btn btn-primary btn-small'>
    				<b>{{date('Md',strtotime($d))}} </b>- <b>{{date('Md',$date)}}</b>
    			</button>
    		</a>
    @endif
	@endforeach
&nbsp;&nbsp;
@endif
      
	<a href='{{URL::to("reports/monthlyReport")}}?date={{date("Y-m-1",strtotime("-1 Month"))}}'>
		<button class='btn btn-small btn-default' style='margin-top:-1px;'>
			<i class='cus-application-view-tile'></i>
			&nbsp;&nbsp;DOWNLOAD MONTHLY REPORT | <b>{{strtoupper(date('M',strtotime('-1 Month')))}}</b>
		</button>
	</a>
	
	&nbsp;&nbsp;<a href='{{URL::to("reports/monthlyReport")}}?date={{date("Y-m-1",strtotime($startdate))}}'>
		<button class='btn btn-small btn-default' style='margin-top:-1px;'>
			<i class='cus-application-view-tile'></i>
			&nbsp;&nbsp;DOWNLOAD MONTHLY REPORT | <b>{{strtoupper(date('M',strtotime(date('Y-m-d'))))}}</b>
		</button>
		</a>

    	</div>
    	<div class='row-fluid'><br/>
            <button class='btn btn-default machineDeals' data-type="all">SHOW ALL DEALS</button> &nbsp;&nbsp;
            <button class='btn btn-default machineDeals' data-type="hasmachines">DEALS WITH MACHINES</button> &nbsp;&nbsp;
            <button class='btn btn-default machineDeals' data-type="nomachines">DEALS WITHOUT MACHINES</button>&nbsp;&nbsp;
            <button class='btn btn-default machineDeals' data-type="cancelled">CANCELLED DEALS</button>&nbsp;&nbsp;
            <button class='btn btn-default machineDeals' data-type="incomplete">INCOMPLETE DEALS</button>&nbsp;&nbsp;&nbsp;&nbsp;
            <select id="repFilter" style="margin-top:6px;">
            <option value="0" placeholder="Select a Rep to filter">All Reps</option>
            @foreach($reps as $r)
            <option value="{{$r->id}}">{{strtoupper($r->fullName())}}</option>
            @endforeach
            </select>
            <div class="pull-right">
            Show/Hide Inventory 
            <div class="double">
                <input type="checkbox" name="show_inventory" id="show_inventory" style="margin-top:-0px;" checked="checked" > 
            </div>
            </div>
                
            
        	<table class="table apptable table-condensed medShadow" style="background:white;" id="dtable2">
            	<thead>
            	    <tr>
            	        <th style="width:1%;"></th>
            	        <th style="width:2%;">Date</th>
            	        <th style="width:1%;">Sale</th>
            	        <th style="width:8%;">Customer</th>
                        <th style="width:4%;">Type</th>
            	        <th style="width:4%;">City</th>
            	        <th>Payment</th>
            	        <th>Type</th>
            	 	    <th>Terms</th>
            	 	    <th>Down Payment</th>
            	        <th>Status</th>
            	        <th>System Type</th>
                        <th class="machineCol" style='width:4%;'>MAJESTICS</th>
                        <th class="machineCol" style='width:4%;'>DEFENDERS</th>
            	        
            	        <th class="machineCol" style='width:4%;'>ATTACHMENTS</th>
            	        
            	        <th style="width:7%;">Dealer</th>
            	        <th style="width:4%;">Booker</th>
            	        <th style="width:1%;">Notes</th>
                        @if(Auth::user()->view_invoices==1)
            	           <th>Paid/Unpaid</th>
                        @endif
            	        @if(Auth::user()->view_commission==1)
                            <th>COMMISION</th>
                        @endif
            	        <th>PRICE</th>
            	        @if($setting->extra_info_sale==1)
                        <th>OTHER</th>
                        @endif
                        @if($setting->document_uploads==1)
            	        <th>FILES</th>
                        @endif
            	    </tr>
            	</thead>
            	<tbody>
                  <?php $count=0;?>
                  @foreach($salesreport as $val)
                  <?php $sale = Sale::find($val->id);?>
                   <?php
                   $items = $sale->items;
                   //||(!empty($sale->deftwo))||(!empty($sale->defthree))||(!empty($sale->deffour))||(!empty($sale->maj))||(!empty($sale->att))||(!empty($sale->twomaj))||(!empty($sale->threemaj)))
                    if(!empty($sale->defone)||!empty($sale->deftwo)||!empty($sale->defthree)||!empty($sale->deffour)||!empty($sale->maj)||!empty($sale->twomaj)||!empty($sale->threemaj)||!empty($sale->att))
                    {
                        $hasmachine = "hasmachines";
                    } else {
                        $hasmachine = "nomachines";
                    }
                  ;?>

                  @if(!empty($sale))
                  @if(($city==$sale->lead->city)||($city=='all'))

                  <?php $count++;?>
                  @if(($val->funded==1)&&($val->status!="COMPLETE"))
                  <?php $row="PAID";?>
                  @endif
                  @if(($val->paid==1)&&($val->status!="COMPLETE"))
                  <?php $row="PAID";?>
                  @endif
                  @if($val->status=="COMPLETE" || $val->status=="PAID")
                  <?php $row="PAID";?>
                  @endif

                  <?php $filter="";?>

                  @if($val->paid==0 && $val->funded==0 && $val->status!="COMPLETE" && $val->status!="PAID")
                  <?php $row="UNPAID";?>
                  @endif

                  @if($val->status=="CANCELLED" || $val->status=="TURNDOWN")
                  <?php $filter = "cancelled";?>
                  @endif

                  @if($val->status!="PAID" && $val->status!="COMPLETE" && $val->status!="CANCELLED" && $val->status!="TURNDOWN")
                  <?php $filter = "incomplete";?>
                  @endif

                  <?php if(($val->status=="CANCELLED" || $val->status=="TURNDOWN")&&($val->picked_up==1)) {$row = "finishcancel";} else {$row = $val->status;};
                    if(($val->status=="TBS")&&($val->picked_up==0)) {$row = "tbscancel";} else {$row = $val->status;};
                  ?>
                   <?php if($sale->lead->original_leadtype=="door"){$type="cus-door";$thetype="Door Reggie";} 
                        else if($sale->lead->original_leadtype=="paper"){$type="cus-script";$thetype="Manilla Survey";} 
                        else if($sale->lead->original_leadtype=="secondtier"){$type="cus-script";$thetype="Second Tier Survey";} 
                        else if($sale->lead->original_leadtype=="other"){$type="cus-zone-money"; $thetype="Scratch Card";} 
                        else if($sale->lead->original_leadtype=="homeshow"){$type="cus-house";$thetype="Home Show";} 
                        else if($sale->lead->original_leadtype=="ballot"){$type="cus-ticket";$thetype="Ballot Box";} 
                        else if($sale->lead->original_leadtype=="referral"){$type="cus-user";$thetype="Referral";} 
                        else if($sale->lead->original_leadtype=="personal"){$type="cus-user";$thetype="Personal Lead";} 
                        else if($sale->lead->original_leadtype=="coldcall"){$type="cus-telephone";$thetype="Cold Call";} 
                        else if($sale->lead->original_leadtype=="doorknock"){$type="cus-door";$thetype="Door Knock";} 
                        else {$type="";$thetype="";};?>
                        <tr class='{{$filter}} {{$row}} {{$hasmachine}} repRow saleRow rep-{{$sale->user_id}}' id='rowid-{{$val->id}}'>

                            <td>{{$count}}</td>
                              <td>
                                    <span class="small">{{date('M d',strtotime($val->date))}}</span>
                                    <br/>
                                    <span class='badge badge-info tooltwo special revealDetails' data-type='sales' title='Click to see this leads Information' data-id="{{$val->id}}" >I</span>
                              </td>
                              <td>{{$val->id}}</td>
                              
                              <td><span class="edit tooltwo" title="Click to change Customer Name" id="cust_name|{{$val->id}}">{{$val->cust_name}}</span><br/>
                              @if(($val->status!="CANCELLED")&&($val->status!="TURNDOWN")&&($val->status!="TBS"))
                              <?php 
                                          $progress=0;
                                          $t1=0;$t2=0;$t3=0;$t4=0;$t5=0;$t6=0;$t7=0;
                                          if(!empty($sale->payment)){$progress++; $t1=1;}
                                          if((!empty($sale->defone))||(!empty($sale->deftwo))||(!empty($sale->maj))||(!empty($sale->att))){$progress++;$t2=1;}
                                          
                                          if(($sale->payout!="0.00")){$progress++;$t3=1;}
                                          if(($sale->payout=="0.00")&&($sale->ridealong_payout!="0.00")){$progress++;$t3=1;}
                                          
                                          if((!empty($sale->docs))||($sale->conf==1)){$progress++;$t4=1;}
                                          if($sale->funded==1){$progress++; $t5=1;}
                                          if(!empty($sale->invoice)){$progress++;$t6=1;}
                                          if((!empty($sale->invoice))&&($sale->invoice->status=="paid")){$progress++;$t7=1;};
                        
                                          
                                          $p="progress-success active";
                                          if($progress<=1){$p = "progress-danger active";} 
                                          if($progress<=2){$p = "progress-warning active";} 
                                          if(($progress>2)&&($progress<=4)){$p = "active";} 
                                          $progress=floor((($progress/7)*100));
                                          ?>
                              
                                <div class=" progress {{$p}} slim tooltwo revealDetails" data-type="progress" data-id="{{$val->id}}"  title="Click to view progress of this sale" style="width:80%;">
                                    <div class="bar progID-{{$val->id}}" data-percentage="{{$progress}}"></div>
                                </div>
                                @endif
                              </td>
                              <td><center>
                                <i class='{{$type}} tooltwo' title='{{$thetype}}<?php if(($thetype=="Door Reggie")||($thetype=="Referral")) { ;?> - {{$sale->lead->researcher_name}}<?php };?>'></i> @if($sale->lead->leadtype=="rebook") &nbsp;<i class='cus-arrow-redo tooltwo' title='This lead has been rebooked!'></i>&nbsp; @endif
                                </center>
                            </td>

                              <td><span class="small">{{substr($sale->lead->city,0,12)}}...</span></td>
                              <td><span class="paymentedit tooltwo" data-id='{{$val->id}}' title="Click to change payment type" id="payment|{{$val->id}}">@if(!empty($val->payment)){{$val->payment}} @endif</span>
                                    <br/>
                                    @if((!empty($val->payment))&&($val->status!="CANCELLED")&&($val->status!="TURNDOWN")&&($val->status!="TBS"))
                                    <?php $h = "";?>
                                    @else
                                    <?php $h = "hide";?>
                                    @endif
                                    <input id="funded-{{$sale->id}}" data-theid='{{$val->id}}' class='markpaid tooltwo {{$h}}' title='Click here to mark this deal as funded' data-id='funded|{{$val->id}}' type='checkbox' @if(!empty($val->funded)&&($val->funded==1)) checked='checked' @endif /> 
                                    
                                    <span class='checkboxAcceptance {{$h}} payAccept-{{$sale->id}} @if($val->funded==1) blackText' @else redText' @endif'>
                                        @if($val->payment!="CASH" && $val->payment!="CHQ" && $val->payment!="MasterCard" && $val->payment!="VISA" && $val->payment!="AMEX")
                                        Funded
                                        @endif

                                          @if(($val->payment=="CASH")||($val->payment=="CHQ"))
                                          Paid
                                          @endif

                                          @if(($val->payment=="MasterCard")||($val->payment=="VISA")||($val->payment=="AMEX"))
                                          Accepted
                                          @endif


                                    </span><br/>
                                    <input id="comp-{{$sale->id}}" data-theid='{{$val->id}}' class='markpaid tooltwo {{$h}}' title='Click here to mark this deal as confirmed and complete' data-id='comp|{{$val->id}}' type='checkbox' @if(!empty($val->comp)&&($val->comp==1)) checked='checked' @endif /> 
                                    
                                    <span class='checkboxAcceptance {{$h}}  @if($val->comp==1) blackText' @else redText' @endif'>
                                          Confirmed
                                    </span>
                              </td>
                              <td>
                                    <span class="type-{{$val->id}} pay_typedit tooltwo" title="Click to change payment type" data-id="{{$val->id}}" id="pay_type|{{$val->id}}">{{$val->pay_type}}</span>
                              </td>
                              <td>
                                    <span class="termsedit tooltwo deferal-{{$val->id}}" title="Click to change the terms" data-id="{{$val->id}}" id="deferal|{{$val->id}}">{{$val->deferal}}</span><br/>
                                    <?php  if(empty($val->interest_rate)){$ir = "0.00";} else {$ir = $val->interest_rate;};?>
                                    <span class="interestedit interest_rate-{{$val->id}}" data-id="{{$val->id}}" id="interest_rate|{{$val->id}}" @if($val->deferal=="NA") style="display:none;" @endif>{{$ir}}%</span>
                              </td>
                              <td>
                                    <span class="downedit tooltwo" title="Click to change the down payment type" data-id="{{$val->id}}" id="down_payment_type|{{$val->id}}">{{strtoupper($val->down_payment_type)}}</span><br/>

                                    <div class="downpay-{{$val->id}}" @if($val->down_payment_type=="none") style="display:none;" @endif>
                                    <span class="edit" id="down_payment|{{$val->id}}">@if($val->down_payment==0) @else {{$val->down_payment}} @endif</span><br/>
                                    <input type="checkbox" data-theid="{{$val->id}}" class="markpaid downPay tooltwo downPayAccept-{{$val->id}}" title="Click to mark that a down payment has been made" data-id="paid_down|{{$val->id}}" @if($val->paid_down==1) checked='checked' @endif />
                                    <span class='checkboxAcceptance @if($val->paid_down==1) blackText @else redText @endif 
                                          '>Paid </span>
                                    </div>
                              </td>

                              <td id='status-{{$val->id}}'>
                                    @if(($val->status=="CANCELLED")||($val->status=="TURNDOWN")||($val->status=="TBS"))
                                    @if($val->picked_up==0)
                                    <span class="statusedit status-{{$sale->id}} tooltwo" title="Click to change the status of this deal" data-id='{{$val->id}}' id="status|{{$val->id}}">{{$val->status}}</span>
                                    <div id='pickup-{{$val->id}}'>
                                    <a class='tooltwo btn bordbut btn-mini btn-success pickupSale' title='Click if machines are PICKED UP. This will return machines to Stock/Rep' style='color:#000;' data-id='{{$val->id}}'>RETURN</a>
                                    @else
                                    <span class="statusedit status-{{$sale->id}} tooltwo" title="Click to change the status of this deal" data-id='{{$val->id}}' id="status|{{$val->id}}">{{$val->status}}</span>
                                    <div id='pickup-{{$val->id}}'>
                                    @endif
                                    @else
                                    <span class="statusedit status-{{$sale->id}} tooltwo" title="Click to change the status of this deal" data-id='{{$val->id}}' id="status|{{$val->id}}">{{$val->status}}</span>
                                    <div id='pickup-{{$val->id}}'>


                                    @endif
                              </div>

                                    <br/>
                                    @if(($val->status=="CANCELLED")||($val->status=="TURNDOWN"))
                                    <?php 
                                    if($val->cancel_date!='0000-00-00'){
                                          $refund = date('M-d Y',strtotime('+15 Days',strtotime($val->cancel_date)));
                                          $now = time(); // or your date as well
                                          $your_date = strtotime($refund);
                                          $datediff = $now - $your_date;
                                           $refundcount = floor($datediff/(60*60*24))*-1;
                                           if($refundcount<=0){
                                                $col = "success special blackText";
                                           } else {
                                                $col = "warning blackText";
                                           }
                                    } else {
                                          $refund="";$refundcount="";$col="";
                                    };?>
                                    @if($val->refunded==0)
                                    <span class='smallbadge badge badge-{{$col}} tooltwo' title="This sale can be refunded in {{$refundcount}} days | Date :  {{$refund}}" >{{$refundcount}}</span><br/>
                                    @endif
                                    <input type="checkbox" data-theid="{{$val->id}}" class="markpaid tooltwo refund-{{$val->id}}" title="Click to mark that a refund was succesful" data-id="refunded|{{$val->id}}" @if($val->refunded==1) checked='checked' @endif />
                                    <span class='checkboxAcceptance @if($val->refunded==1) blackText @else redText @endif 
                                          '>Refunded </span>
                                    @endif
                              </td>
                                <?php 
                                if($val->typeofsale=="2maj") {$systemType="2 Majestics";} 
                                else if($val->typeofsale=="3maj") {$systemType="3 Majestics";}
                                else if($val->typeofsale=="2system"){$systemType="2 Systems";}
                                else if($val->typeofsale=="supernova"){$systemType="Super Nova System";}
                                else if($val->typeofsale=="2defenders"){$systemType="2 Defenders";}
                                else if($val->typeofsale=="3defenders"){$systemType="3 Defenders";}
                                else {$systemType=ucfirst($val->typeofsale);};
                                ?>
                              <td class='tooltwo' title='Click to Change Sale Type' ><center><span class="systemedit"  id="typeofsale|{{$val->id}}">{{$systemType}}</span></center></td>
                             
                             <?php 

                                $itemcount = Sale::getUnits($val->typeofsale);
                                $defcount=0;$majcount=0;
                                if(!empty($items)){
                                    foreach($items as $i){
                                        if($i->item_name=="defender"){
                                            $defcount++;
                                        }
                                        if($i->item_name=="majestic"){
                                            $majcount++;
                                        }
                                    }
                                }


                             ?>

                              @if(($val->status=="CANCELLED")||($val->status=="TURNDOWN"))
                                
                                @if($val->picked_up==1)
                                <?php $machines = unserialize($val->old_machines);?>
                                <td class='machines machineCol' id='maj-{{$val->id}}'>
                                    <center>
                                      @if(!empty($machines['majestic']))
                                        @foreach($machines['majestic'] as $i)
                                        <span class='label label-inverse' >{{$i}}</span>
                                        @endforeach
                                      @endif
                                    </center>
                                </td>

                                <td class='machines machineCol' id='def-{{$val->id}}' >
                                      <center>
                                      @if(!empty($machines['defender']))
                                        @foreach($machines['defender'] as $i)
                                        <span class='label label-inverse' >{{$i}}</span>
                                        @endforeach
                                      @endif
                                      </center>
                                </td>
                                
                                <td class='machines machineCol' id='att-{{$val->id}}' >
                                    <center>
                                     @if(!empty($machines['attachment']))
                                        @foreach($machines['attachment'] as $i)
                                        <span class='label label-inverse' >{{$i}}</span>
                                        @endforeach
                                      @endif
                                    </center>
                                </td>

                              @else

                              <td class='machines machineCol' id='maj-{{$val->id}}'>
                                    <center>
                                    @if(!empty($items))
                                        @foreach($items as $i)
                                            @if($i->item_name=="majestic")
                                                <span class='label label-important  special blackText' id='maj-span-{{$val->id}}'>{{$i->sku}}</span>
                                            @endif
                                        @endforeach
                                    @endif
                                    </center>
                              </td>
                              <td class='machines machineCol' id='def-{{$val->id}}'>
                                    <center>
                                    @if(!empty($items))
                                        @foreach($items as $i)
                                            @if($i->item_name=="defender")
                                                <span class='label label-important special blackText' id='def-span-{{$val->id}}'>{{$i->sku}}</span>
                                            @endif
                                        @endforeach
                                    @endif
                                    </center>
                              </td>
                              
                              <td class='machines machineCol' id='att-{{$val->id}}'>
                                    <center>
                                    @if(!empty($items))
                                        @foreach($items as $i)
                                            @if($i->item_name=="attachment")
                                                <span class='label label-important  special blackText' id='att-span-{{$val->id}}'>{{$i->sku}}</span>
                                            @endif
                                        @endforeach
                                    @endif
                                    </center>
                              </td>
                              @endif
                              @else

                              

                              <?php 
                              $warn="";
                              if(intval($itemcount['maj']-intval($majcount) >0)){
                                $warn = "DNS";
                              }
                              ;?>
                              <td class='{{$warn}} machines machineCol majestic-td-{{$val->id}}' id='maj-{{$val->id}}'>
                                    <center>
                                    @if($val->typeofsale!="other")
                                    @if(intval($itemcount['maj']!=0))
                                    <button id="majestic-addbutton-{{$val->id}}" class='btn btn-mini btn-default addItem revealDetails' data-type="machines" data-machine="Majestic" data-expcount="{{$itemcount['maj']}}" data-count="{{$majcount}}" data-id="{{$val->id}}">ADD
                                        @if(intval($itemcount['maj']-intval($majcount) >0)) 
                                        <span class='majestic-count-{{$val->id}} badge badge-important special' > {{$itemcount['maj']-$majcount}} </span>
                                        @else
                                        <span class='majestic-count-{{$val->id}} badge badge-important special' style="display:none;"  > {{$itemcount['maj']-$majcount}} </span>
                                        @endif
                                    </button>
                                    @endif
                                    @else
                                    <button id="majAddButton-{{$val->id}}" class='btn btn-mini btn-default addItem revealDetails' data-type="machines" data-machine="Majestic" data-expcount="{{$itemcount['maj']}}" data-count="{{$majcount}}" data-id="{{$val->id}}">ADD
                                        
                                    </button>
                                    @endif
                                    <br/>
                                        <div id="majestic-{{$val->id}}" style="margin-top:9px;">
                                        @if(!empty($items))
                                            @foreach($items as $i)
                                                @if($i->item_name=="majestic")
                                                    <span class='label label-info special removeMachine tooltwo'  data-type='{{$i->item_name}}' data-sale='{{$i->sale_id}}' data-machine='{{$i->id}}' title="Click to remove item from Sale" id='maj-span-{{$val->id}}'>{{$i->sku}}</span>
                                                @endif
                                            @endforeach
                                        @endif
                                        </div>
                                    </center>
                              </td>

                              <?php 
                              $warn="";
                              if(intval($itemcount['def']-intval($defcount) >0)){
                                $warn = "DNS";
                              }
                              ;?>
                              <td class='{{$warn}} machines machineCol defender-td-{{$val->id}}' id='def-{{$val->id}}'>
                                    <center>
                                    @if($val->typeofsale!="other")
                                     @if(intval($itemcount['def']!=0))
                                    <button id="defender-addbutton-{{$val->id}}" class='btn btn-mini btn-default addItem revealDetails' data-type="machines" data-machine="Defender" data-expcount="{{$itemcount['def']}}" data-count="{{$defcount}}" data-id="{{$val->id}}">ADD
                                        @if(intval($itemcount['def']-intval($defcount) >0)) 
                                        <span class='defender-count-{{$val->id}} badge badge-important special' > {{$itemcount['def']-$defcount}} </span>
                                        @else
                                        <span class='defender-count-{{$val->id}} badge badge-important special' style="display:none;"  > {{$itemcount['def']-$defcount}} </span>
                                        @endif
                                    </button>
                                    @endif
                                    @else
                                    <button id="defAddButton-{{$val->id}}" class='btn btn-mini btn-default addItem revealDetails' data-type="machines" data-machine="Defender" data-expcount="{{$itemcount['def']}}" data-count="{{$defcount}}" data-id="{{$val->id}}">ADD
                                       
                                    </button>
                                    @endif
                                    <br/>
                                        <div id="defender-{{$val->id}}" style="margin-top:9px;">
                                        @if(!empty($items))
                                            @foreach($items as $i)
                                                @if($i->item_name=="defender")
                                                <span class='label label-info special removeMachine tooltwo' data-type='{{$i->item_name}}' data-sale='{{$i->sale_id}}' data-machine='{{$i->id}}'  title="Click to remove item from Sale" id='def-span-{{$val->id}}'>{{$i->sku}}</span>
                                                @endif
                                            @endforeach
                                        @endif
                                        </div>
                                    </center>
                              </td>
                              
                              <td class=' machines machineCol attachment-td-{{$val->id}}' id='att-{{$val->id}}'>
                                    <center>
                                    <button id="attachment-addbutton-{{$val->id}}" class='btn btn-mini btn-default addItem revealDetails' data-type="machines" data-machine="Attachment" data-count=""  data-id="{{$val->id}}">ADD</button>
                                    <br/>
                                        <div id="attachment-{{$val->id}}" style="margin-top:9px;">
                                        @if(!empty($items))
                                            @foreach($items as $i)
                                                @if($i->item_name=="attachment")
                                                <span class='label label-info special removeMachine tooltwo'  data-type='{{$i->item_name}}' data-sale='{{$i->sale_id}}' data-machine='{{$i->id}}'  title="Click to remove item from Sale" data-id="{{$i->id}}" id='att-span-{{$val->id}}'>{{$i->sku}}</span>
                                                @endif
                                            @endforeach
                                        @endif
                                        </div>
                                    </center>
                              </td>
                              
                              @endif
                              <td> 
                                    <span class='small label label-inverse'>{{$val->sold_by}}</span>
                                    @if(($sale->ridealong_id!=0)&&(!empty($sale->ridealong)))
                                    <img src='{{URL::to('img/ride-along.png')}}' class='tooltwo' title='This Sale was accompanied by {{$sale->ridealong->firstname}} {{$sale->ridealong->lastname}}  as a ridealong' width=25px height=25px> @endif 
                              </td>
                              <td>
                                    <span class='small label label-inverse'>{{$sale->appointment->booked_by}}</span>
                              </td>
                              <td>
                              @if(!empty($val->comments))
                              <center>
                                    <span class='badge badge-info special tooltwo showNotes' onclick="$('.hideNotes').hide();$('.seeNotes-'+{{$val->id}}).show(200);" data-id='{{$val->id}}' title='Click to reveal / enter Notes for this sale'>N</span>
                              </center>
                              @endif
                                    <span class="edit tooltwo seeNotes-{{$val->id}} hideNotes @if(!empty($val->comments)) hide @endif" title="Click to enter some notes for this sale" id="comments|{{$val->id}}">
                                          {{$val->comments}}
                                    </span>
                                    
                              </td>
                              @if(Auth::user()->view_invoices==1)
                              <td>
                                    @if(($val->status!="CANCELLED")&&($val->status!="TURNDOWN"))
                                    @if(!empty($sale->invoice))
                                          @if(($sale->invoice->status==0)&&($sale->paid==0))
                                          <?php $lab = "important blackText";$ic="cus-cancel";?>
                                          @else
                                          <?php $lab="success blackText";$ic="cus-money";?>
                                          @endif

                                          <span class='label label-{{$lab}} special tooltwo revealDetails' data-type="invoice" data-id='{{$sale->id}}' title="Click to View Invoice">
                                          <i class='{{$ic}} tooltwo' title='This sale has been attached to an invoice!  Click to View!'></i> {{strtoupper($sale->invoice->status)}}</span>
                                    @else
                                          <span class='label label-inverse special tooltwo revealDetails' data-type="progress-side" data-id='{{$sale->id}}' title='Click to view current Sale Progress'>No Invoice</span>
                                    @endif
                                    
                                    @endif
                              </td>
                              @endif
                               @if(Auth::user()->view_commission==1)
                              <td>  
                                    @if($val->payout==0)
                                    <?php $t="redText animated shake";?>
                                    @else 
                                    <?php $t="";?>
                                    @endif
                                    @if(($val->status!="CANCELLED")&&($val->status!="TURNDOWN"))
                                    @if(!empty($sale->ridealong)) <span class='small'>1st Rep :</span> @endif 
                                    <span class="edit tooltwo label label-inverse {{$t}} payoutField-{{$val->id}}" data-id="{{$val->id}}" title="Click to enter a Commission payment for {{$val->sold_by}}" id="payout|{{$val->id}}">@if(!empty($val->payout)){{number_format($val->payout,2,'.','')}}@endif</span>
                                    
                                    @if(($sale->ridealong_id!=0)&&(!empty($sale->ridealong)))
                                    <div class="animated fadeInUp ">
                                    
                                    @if($val->ridealong_payout==0)
                                    <?php $t="redText";?>
                                    @else 
                                    <?php $t="";?>
                                    @endif
                                    <span class='small'>2nd Rep :</span>
                                    <span class=" edit tooltwo label label-inverse {{$t}} ridealong_payoutField-{{$val->id}}" data-id="{{$val->id}}"  title="Click to enter a Commission split for {{$sale->ridealong->firstname}} {{$sale->ridealong->lastname}} this deal" id="ridealong_payout|{{$val->id}}">@if(!empty($val->ridealong_payout)){{number_format($val->ridealong_payout,2,'.','')}}@endif</span>
                                    </div>
                                    @endif
                                    @endif
                              </td>
                              @endif

                              <td><span class="edit tooltwo" title="Click to enter the Retail price of this deal" id="price|{{$val->id}}">@if(!empty($val->price)){{number_format($val->price,2,'.','')}}@endif</span></td>
                              @if($setting->extra_info_sale==1)
                              <td>  
                                    <?php if(empty($val->postal_code)){
                                                $otherbutton = "btn-danger blackText";
                                          } else if((empty($val->filter_one))&&(empty($val->filter_two))) {
                                                $otherbutton="btn-warning blackText";
                                          } else {
                                                $otherbutton="btn-success blackText";
                                          }
                                    ;?>
                              <button title='Click here to Enter Extra Info' id="extrainfo-{{$val->id}}" class='tooltwo bordbut btn btn-mini {{$otherbutton}} extraInfo' data-emailaddress='{{$val->emailaddress}}' data-filtone='{{$val->filter_one}}' data-postalcode='{{$val->postal_code}}' data-filttwo='{{$val->filter_two}}' data-thelead='{{$val->lead_type}}' data-id='{{$val->id}}'>
                                    OTHER
                              </button>
                              <br/>
                              <input type="checkbox" class="checkEdit" id="warrantyCheck-{{$val->id}}" name="warrantied" data-id="warrantied|{{$val->id}}" @if($val->warrantied==1) checked='checked' @endif /> <span style='font-size:12px;'>Warranty</span>
                              </td>
                              @endif
                              @if($setting->document_uploads==1)
                              <td>  
                              <button title='Click here to Upload'  class='tooltwo bordbut btn btn-mini btn-primary uploadDoc' data-lid='{{$val->lead_id}}' data-id='{{$val->id}}'><i class='icon-file'></i> Upload </button>

                                    @if(count($sale->docs)>=1)
                                    <span  title='Click here to View Files' class='tooltwo viewDoc bordbut badge badge-important special' data-id='{{$val->id}}'  data-name='{{$val->cust_name}}' data-type='{{ucfirst($val->typeofsale)}}' style='cursor:pointer'><i class='icon-eye-open'></i>
                                    </span>
                                    @endif

                                    <br/>
                                    <input type="checkbox" data-theid="{{$val->id}}" class="markpaid tooltwo" title="Click to mark that you have the original documents on hand, and not just digital copies" data-id="conf|{{$val->id}}" @if($val->conf==1) checked='checked' @endif />
                                    <span class='checkboxAcceptance @if($val->conf==1) blackText @else redText @endif 
                                          '>Originals </span>
                              </td>
                              @endif
                        </tr>
                        @endif
                        @endif
                        @endforeach

                  </tbody>
        	</table>
    	</div>
  
</div>
<div class="push"></div>
<?php 
$data = Sale::paymentTypes();
$finper = Sale::financePercentages();

?>



<script src="{{URL::to_asset('js/editable.js')}}"></script>
<script>
$(document).ready(function(){
    $('#download_report').change(function(){
        var val = $(this).val();
        if(val!="" && val!=undefined){
            if(val=="all"){
                $('.oneTouchReports').trigger('click');
            } else {
                window.location.href = val;
                $('.ajax-heading').html("Downloading Report...");
                $('.ajaxWait').show();
                setTimeout(function(){
                    $('.ajaxWait').hide();
                },1500);
            }
        }
        
    });


    $('.column-NET').hide();
    $('body').css('background','white');
    window.scrollTo(0,0);

$('.healthMor').click(function(e){
	e.preventDefault();
	var link = $(this).attr('href');
	window.open(link);
});

$('.machineDeals').click(function(){
    $('.machineDeals').removeClass('btn-inverse');
    $(this).addClass('btn-inverse');
    filterDeals();
});

function filterDeals(){
    var type="";var otherfilter="";
    $('.machineDeals').each(function(i,val){
        if($(this).hasClass('btn-inverse')){
            type = $(this).data('type');
        }
    });
    var repfilter = $('#repFilter').find("option:selected").val();
    if(repfilter==0){
        repfilter="";
    } else {
        repfilter = ".rep-"+repfilter;
    }
    if(type=="" || type=="all"){
        otherfilter = ".saleRow";
    } else {
       otherfilter = "."+type;
    }
    $('.saleRow').hide();
    $(otherfilter+repfilter).show();
        
}

$('#repFilter').change(function(){
    filterDeals();
});

$(document).on('click','.pickupSale',function(data){
       var id = $(this).attr('data-id');
        $.getJSON('{{URL::to("sales/pickupsale/")}}'+id, function(data){
            if(data=="success"){
                console.log(data);
                toastr.success("Succesfully returned items to Stock");
                location.reload();
            } else {
                toastr.error("Failed to Return Items, Contact System Administrator");
            }
        });
    });

$('.extraInfo').click(function(){
	$('#sale-filterone').val($(this).attr('data-filtone'));
	$('#sale-filtertwo').val($(this).attr('data-filttwo'));
	$('#sale-emailaddress').val($(this).attr('data-emailaddress'));
	$('#sale-postal_code').val($(this).attr('data-postalcode'));
	$('#sale-leadtype').val($(this).attr('data-thelead'));
	$('#sale-extra-id').val($(this).attr('data-id'));
	$('.infoHover').hide();
	$('.modal').hide();
	$('#payment_calc_modal').modal('hide');
	$('#contacts_modal').modal('hide');		
	$('#extra_sale_info').modal({backdrop:'static'});

});

$(document).on('click','.enterInfo',function(e){
e.preventDefault;
var form = $('#sale-info-form').serialize();
	$.getJSON('{{URL::to("sales/otherinfo")}}',form,function(data){
		console.log(data);
		if(data!="failed"){
			var clas = 'bordbut btn btn-mini';
			if((data.postal_code=='')&&(data.filter_one=='')&&(data.filter_two=='')){
				clas = clas+' btn-danger blackText';
			}
			if(data.postal_code!=''){
				clas = clas+' btn-warning blackText';
			}
				
			if(((data.filter_one!='')&&(data.postal_code!=''))||((data.filter_two!='')&&(data.postal_code!=''))) {
				clas = clas+' btn-success blackText';
			}
			$('#extrainfo-'+data.id).attr('data-thelead',data.lead_type).attr('data-emailaddress',data.emailaddress).attr('data-filtone',data.filter_one).attr('data-filttwo',data.filter_two).attr('data-postalcode',data.postal_code).removeClass().addClass(clas);
			toastr.success('Sale updated successfully!');

			$('#extra_sale_info').modal('hide');		
		}
	});
});

$('.showStats').click(function(e){
	e.preventDefault();
	if($('#displayStats').val()=="no"){
		$('#displayStats').val("yes");
		$('.dealerStatText').html("CLOSE DEALER STATS");
		$(this).removeClass("btn-primary").addClass("btn-danger");
		
	} else {
		$('#displayStats').val("no");
		$('.dealerStatText').html("SHOW DEALER STATS");
		$(this).removeClass("btn-danger").addClass("btn-primary");
	}
	
	$('#statsTable').toggle();
});

if(localStorage){

    if(!!localStorage.getItem("hideInventory")){
        if(localStorage.getItem("hideInventory")==="activated"){
            $('.machineCol').show();
            $('#show_inventory').prop('checked',true);
        } else {
            $('.machineCol').hide();
            $('#show_inventory').prop('checked',false);
        }
    } else {
        $('.machineCol').show();
        $('#show_inventory').prop('checked',true);
    }
}


$('#show_inventory').click(function(){
    if($(this).is(':checked')){
        localStorage.setItem("hideInventory","activated");
        $('.machineCol').show();
    } else {
        localStorage.setItem("hideInventory","deactivated");
        $('.machineCol').hide();
    }
    
});



$('.legend').click(function(){
	$('.allReps').hide();
	if($(this).hasClass('isactive')){
		$('tr.isactive').show();
	} else {
		$('tr.notactive').show();
	}
});

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
                        "sButtonText": ""
                    }
                ]
            }
        }); 
	
	$(document).on('click','.removeMachine',function(){
		var machine = $(this).data('machine');
        var type = $(this).attr('data-type');
        var id = $(this).attr('data-sale');
        var cnt = $('#'+type+'-addbutton-'+id).attr('data-count');
        var exp = $('#'+type+'-addbutton-'+id).attr('data-expcount');
        

		var thebut = $(this);
        var t = confirm("Are you sure you want to remove this machine from the sale??");
        if(t){
            $.getJSON('{{URL::to("sales/removeitem/")}}',{machine:machine},function(data){
                if(data=="success"){
                    toastr.success("Removed this item from sale","Returned to Stock");
                    $('#'+type+'-addbutton-'+id).attr('data-count',parseInt(+cnt-1));
                    var finalCount = parseInt(exp)-parseInt(+cnt-1);
                    $('.'+type+'-count-'+id).html(finalCount);
                    if(finalCount!=0){
                        $('.'+type+'-td-'+id).addClass('DNS');
                        $('.'+type+'-count-'+id).show();
                    } 
                    thebut.remove();
                } else if(data=="failed") {
                    toastr.error("Refresh the page, and try again!", "Remove failed!");
                }
            });
        }
	});

 	function replaceRowNoMach(id){
 		var html = "";
 		$.getJSON('{{URL::to("sales/getsalerow/")}}'+id, function(data){
 			var sale = data.sale.attributes;
 			var accept;var downClass;

            if(sale.payment!="VISA" && sale.payment!="MasterCard" && sale.payment!="AMEX" && sale.payment!="CHQ" && sale.payment!="CASH"){
                accept = 'Funded';
            }

 			if((sale.payment=="VISA")||(sale.payment=="MasterCard")||(sale.payment=="AMEX")){
 				accept = 'Accepted';
 			} 
            if(sale.payment=="CHQ" || sale.payment=="CASH"){
 				accept = 'Paid';
            }
 				

 			if(sale.funded==0){
 				newClass='redText';
 				
 			} else {
 				newClass='blackText';
 			}

 			if(sale.paid_down==0){
 				downClass='redText';
 			} else {
 				downClass='blackText';
 			}

 			if(sale.down_payment_type=="none"){
 				$('.downpay-'+sale.id).hide();
 			} else {
 				$('.downpay-'+sale.id).show();
 			}
 			$('.deferal-'+sale.id).html(sale.deferal);
 			if(sale.deferal!="NA"){

 				$('.interest_rate-'+sale.id).show();
 			} else {
 				$('.interest_rate-'+sale.id).hide();
 			}

 			$('.downPayAccept-'+sale.id).show().addClass(downClass); 

 			$('.payAccept-'+sale.id).show().addClass(newClass).html(accept); 
 			$('#funded-'+sale.id).show();
 			$('.status-'+sale.id).html(sale.status);
 			$('.type-'+sale.id).html(sale.pay_type);
 			if(sale.payout!="0.00"){$('.payoutField-'+sale.id).removeClass('redText');} else {$('.payoutField-'+sale.id).addClass('redText');}
 			if(sale.ridealong_payout!="0.00"){$('.ridealong_payoutField-'+sale.id).removeClass('redText');} else {$('.ridealong_payoutField-'+sale.id).addClass('redText');}

 			progress=0;
                 
                  if(sale.payment){progress++; }
                  if((sale.defone)||(sale.deftwo)||(sale.maj)||(sale.att)){progress++;}
                  if(sale.payout!="0.00"){progress++;}
                  if((sale.payout=="0.00")&&(sale.ridealong_payout!="0.00")){progress++;}
                                 
                     if((sale.docs)||(sale.conf==1)){progress++;}
                     if(sale.funded==1){progress++; }
                     if(sale.status=="unpaid"){progress++;}
                     if(sale.status=="paid"){progress++;};
                     
                     p="progress-success active";
                     if(progress<=1){p = "progress-danger active";} 
                     if(progress<=2){p = "progress-warning active";} 
                     if((progress>2)&&(progress<=4)){p = "active";} 
                     progress=Math.floor(((progress/7)*100));
      			$('.progID-'+sale.id).addClass(p).css('width',progress+'%');

      		toastr.success('Sale updated');
 		});


 	}

 	$('.openUnitBox').click(function(){
 		var id =$(this).data('id');
 		$('.unitBox').hide();
 		$('.unitBox-'+id).show();
 	});

 	function replaceRow(id){
 		var html = "";
 		$.getJSON('{{URL::to("sales/getsalerow/")}}'+id, function(data){
 			var sale = data.sale.attributes;
 			var d = data;
 			var mach1, mach2;
 			var status;
 			var defone1 = d.defone;
 			var deftwo1=d.deftwo;
 			var defthree1=d.defthree;
 			var deffour1=d.deffour;
            var deffive1=d.deffive;
            var maj2 = d.twomaj;
            var maj3 = d.threemaj;
 			var att1 = d.att;
 			var maj1 = d.maj;
 			if((d.status=='CANCELLED')||(d.status=='TURNDOWN')||(d.status=='TBS')){
 				
 				if(d.pickedup==0){
 					status = 'label-important';
 					remove = 'revealDetails removeMachine label-info bordbut special';
                    if(d.status=='TBS'){
                        $('tr#rowid-'+d.id).removeClass().addClass('tbscancel');
                    } else {
                        $('tr#rowid-'+d.id).removeClass().addClass(d.status);
                    };
					
					$('#pickup-'+id).html("<a class='btn bordbut btn btn-mini btn-success pickupSale' data-id='"+d.id+"' style='color:#000;'>RETURN</a>");
 				} else {
 					$('#pickup-'+id).html("");
                    if(d.status=='TBS'){
                        $('tr#rowid-'+d.id).removeClass().addClass('tbscancel');
                    } else {
                        $('tr#rowid-'+d.id).removeClass().addClass('finishcancel');
                    };
 					
 					status = 'label';
 					remove = 'revealDetails removeMachine label-info label-important bordbut special';
				}

			} else if(d.status=="COMPLETE") {
				$('tr#rowid-'+d.id).removeClass().addClass(d.status);
			} else {
				location.reload();
			}

			if(d.down_payment_type!="none"){
				$('.downpay').show();
			} else {
				$('.downpay').hide();
			}


			    if(maj1!=0){
 				$('#maj-span-'+id).removeClass(remove).addClass(status).html(maj1);} 

                if(maj2!=0){
                $('#twomaj-span-'+id).removeClass(remove).addClass(status).html(maj2);} 

                if(maj3!=0){
                $('#threemaj-span-'+id).removeClass(remove).addClass(status).html(maj3);} 
 			
 				if(att1!=0){
 				$('#att-span-'+id).removeClass(remove).addClass(status).html(att1);} 
 				
 				if(defone1!=0){
 				$('#defone-span-'+id).removeClass(remove).addClass(status).html(defone1);} 
 				
 				if(deftwo1!=0){
 				$('#deftwo-span-'+id).removeClass(remove).addClass(status).html(deftwo1);} 
 				
 				if(defthree1!=0){
 				$('#defthree-span-'+id).removeClass(remove).addClass(status).html(defthree1);} 
 				
 				if(deffour1!=0){
 				$('#deffour-span-'+id).removeClass(remove).addClass(status).html(deffour1);}

                if(deffive1!=0){
                $('#deffive-span-'+id).removeClass(remove).addClass(status).html(deffive1);}
 			
 		});

 	}

    var paymentData = '{{json_encode($data)}}';
    var financePercentage = '{{json_encode($finper)}}';


	$('.edit').editable('{{URL::to("sales/edit")}}',{
		submit:'OK',
    		indicator : 'Saving...',
    		width:'100px',
    		placeholder:"..................",
    		callback : function(value, settings) {
    	      replaceRowNoMach($(this).data('id'));
    		}
	});

	$('.dropdownEdit').editable('{{URL::to("sales/edit")}}',{
		data : $(this).data('theDat'),
		type:'select',
		submit:'OK',
    		indicator : 'Saving...',
    		placeholder:"..................",
    		callback : function(value, settings) {
    	      replaceRow($(this).data('id'));
     	    }
    });


	$('.statusedit').editable('{{URL::to("sales/edit")}}',{
		data : '{"APPROVAL":"Waiting Approval","COMPLETE":"Completed","TBS":"To Be Saved","CANCELLED":"Cancelled","TURNDOWN":"Turndown"}',
		type:'select',
		submit:'OK',
    		indicator : 'Saving...',
    		placeholder:".......",
    		callback : function(value, settings) {
    	      replaceRow($(this).data('id'));
     	}
    	});
    	$('.termsedit').editable('{{URL::to("sales/edit")}}',{
		data : '{"NA":"NA","30day":"30 Day","3month":"3 Month","6month":"6 Month","12month":"12 Month"}',
		type:'select',
		submit:'OK',
    		indicator : 'Saving...',
    		placeholder:".......",
    		width:'10',
    		callback : function(value, settings) {
    	      replaceRowNoMach($(this).data('id'));
     	}
    	});

    	$('.interestedit').editable('{{URL::to("sales/edit")}}',{
		data : financePercentage,
		type:'select',
		submit:'OK',
    		indicator : 'Saving...',
    		placeholder:".......",
    		width:'50',
    		callback : function(value, settings) {
    			if(value=="%"){$(this).html("0.00 %");}
    	      replaceRowNoMach($(this).data('id'));
     	}
    	});

    	$('.pay_typedit').editable('{{URL::to("sales/edit")}}',{
		data : '{"NA":"NA","APP A":"APP A","APP B":"APP B","APP C":"APP C","APP D":"APP D","APP E":"APP E","CREDITCARD": "Credit Card","CHEQUE":"Cheque","CASH":"Cash"}',
		type:'select',
		submit:'OK',
    		indicator : 'Saving...',
    		placeholder:".......",
    		width:'20px',
    		callback : function(value, settings) {
    	      replaceRowNoMach($(this).data('id'));
     	}
    	});

    	$('.paymentedit').editable('{{URL::to("sales/edit")}}',{
		data : paymentData,
		type:'select',
		submit:'OK',
    		indicator : 'Saving...',
    		placeholder:"........",
    		callback : function(value, settings) {
    		replaceRowNoMach($(this).data('id'));
      }
    	});

    	$('.downedit').editable('{{URL::to("sales/edit")}}',{
		data : '{"visa":"Visa","mc":"MasterCard","amex":"American Express","cheque":"Cheque","cash":"Cash","none":"None"}',
		type:'select',
		submit:'OK',
    		indicator : 'Saving...',
    		placeholder:"........",
    		callback : function(value, settings) {
    		replaceRowNoMach($(this).data('id'));
      }
    	});

	$('.systemedit').editable('{{URL::to("sales/edit")}}',{
		data : '{"defender":"Defender","2defenders":"2 Defenders","3defenders":"3 Defenders","majestic":"Majestic","2maj":"2 Majestics","3maj":"3 Majestics","system":"System","supersystem":"Super System","megasystem":"Mega System","novasystem":"Nova System","supernova":"Super Nova System","2system":"2 Systems","other":"Other"}',
		type: 'select',
		submit:'OK',
		indicator: 'saving',
		callback: function(value, settings){
          loadingAnimation();
		  location.reload();
	    }
	});

	$(document).on('click','.markpaid',function(){
		var id = $(this).data('id');
		var therow = $(this).data('theid');
		var funded = $(this).data('funded');
		t = $(this);
		if($(this).is(":checked")){
			var value=1;
			$('#fundedbutton-'+funded).removeClass('btn-danger').addClass('btn-success');
			t.next().removeClass('redText').addClass('blackText');
		} else {
			$('#fundedbutton-'+funded).removeClass('btn-success').addClass('btn-danger');
			var value=0;
			$('tr#rowid-'+therow).removeClass('PAID');
			t.next().removeClass('blackText').addClass('redText');
		}
		
		$.get('{{URL::to("sales/edit")}}',{id:id,value:value},function(data){
		if(data==1) {
			if(($('tr#rowid-'+therow).hasClass('completed'))||($('tr#rowid-'+therow).hasClass('finishcancel'))||($('tr#rowid-'+therow).hasClass('CANCELLED'))){

				} else {
				if(!t.hasClass('downPay')){
					//$('tr#rowid-'+therow).removeClass().addClass('PAID');
				} 
			}
			toastr.success('Sale updated');
		} else if(data==2) {
			toastr.success('You received original documents instead of uploads.','CHECKED ORIGINALS RECEIVED');
		} else {
			toastr.success('Sale updated');
		}
		});
		//replaceRowNoMach(therow);
	});

$(document).on('click','.checkEdit',function(){
    var id = $(this).data('id');

    if($(this).is(':checked')){
       var val = 1;
       var msg = "Sale marked as Warrantied";
    } else {
       var val = 0;
       var msg = "Sale marked as Not Warrantied";
    }
    
    $.getJSON('{{URL::to("sales/edit")}}',{id:id,value:val},function(data){
        if(data){
          toastr.success(msg,"Sale Updated");
        }
    });
});

function loadingAnimation(){
    $('.ajaxWait').show();
    $('.loadanimation').show();
    $('.ajax-heading').html('Loading...');
}

});
</script>

@endsection