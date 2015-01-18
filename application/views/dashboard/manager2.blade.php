@layout('layouts/main')
@section('content')
<?php $settings = Setting::find(1);?>
<?php $goalDemWEEK = Goal::find(1)->goal;
$goalDemMONTH = Goal::find(3)->goal;
if($goalDemMONTH==0){
    $goalDemMONTH = 1;
}
$goalSalesWEEK = Goal::find(2)->goal;
if($goalSalesWEEK==0){
    $goalSalesWEEK = 1;
}
$goalSalesMONTH = Goal::find(4)->goal;
if($goalSalesMONTH==0){
    $goalSalesMONTH = 1;
}
$goalUnitsWEEK = Goal::find(7)->goal;
if($goalUnitsWEEK==0){
    $goalUnitsWEEK = 1;
}
$goalUnitsMONTH = Goal::find(8)->goal;
if($goalUnitsMONTH==0){
    $goalUnitsMONTH = 1;
}
?>
<!--LARGE MAP AND SIDEWIDGET-->
<div class="row-fluid" style="margin-top:15px;">

	<div class="span12" id="leadview" style="display:none;">
  		<button class="btn btn-danger animated fadeInUp backtoreports" style="position:fixed;right:10px;margin-top:45px;z-index:250000;padding:25px;font-size:15px;"><i class="cus-cancel"></i>&nbsp;&nbsp;BACK TO DASHBOARD</button>
                        		
  		<div id="viewleadbox">
     		<h2 style="margin-left:0px;"><span class="cust_num">250-555-5555</span><button style="float:right;margin-right:10px;" onclick="$('#viewleadbox').hide(200);"><i class="cus-cancel"></i></button></h2>
  			<h4 class="cust_name">Customer Name</h4>

       		<div id="wellbox" class="well" style="width:100%;float:left;">
      			<div style="width:43%;float:left;margin-top:20px;">
           			<b>Customer Name :</b> <span class="cust_name">John</span><br/>
          			<b>Spouse Name :</b> <span class="spouse_name"> Spouse</span><br/>
           			<b>Phone : </b><span class="cust_num">2505555555</span><br/><br/>
          			<b>Address :</b>  <span class="address"> 123test</span><br/><br/><br/>
       			<div class='salebutton' style="margin-bottom:20px;"></div>
	       		</div>
    	   			<div style="width:43%;float:left;margin-left:10px;margin-top:20px;">
      			<b>Leadtype :</b> <span class="leadtype">Door</span><br/><br/>
             		<b>STATUS :</b> <span class="status"> APP</span><br/>
               		<b>RESULT :</b> <span class="result">CXL</span><br/><br/>
                   	<b>Last Updated By:</b>  <span class="booked_by"> Rainer Kern</span><br/><br/>
                </div>
            </div>
            <h4 >Call History</h4>
            <table class="table table-bordered table-condensed" >
                <thead>
                    <tr>
                        <th>CALL DATE</th>
                        <th>CALLED BY</th>
                        <th>RESULT</th>
                    </tr>
                </thead>
                <tbody class="callhistory">
                </tbody>
            </table>
            <h4 >Appointment History</h4>
            <table class="table table-bordered table-condensed" >
                <thead>
                    <tr>
                        <th>APP TIME</th>
                        <th>APP DATE</th>
                        <th>BOOKER</th>
                        <th>BOOKED AT</th>
                        <th>STATUS</th>
                    </tr>
                </thead>
                <tbody class="appointmenthistory">
                </tbody>
            </table>
        </div>
        <div id="map2" style="height:1200px;width:100%;"></div>
    </div>
</div>
<!----END SIDE MAP WIDGET-->


<div id="main" role="main" class="container-fluid">
    @render('plugins.profileoverlay')
    <div class="contained">
        <!-- LEFT SIDE WIDGETS & MENU -->
        <aside> 
        	
            @render('layouts.managernav')
       </aside>
        <!-- END WIDGETS -->
               
        <!-- MAIN CONTENT -->
        <div id="page-content" > 
           <h1 id="page-header" style="margin-top:-20px;color:#000;font-weight:bolder;">
           	<img src='{{URL::to("images/clozer-cup.png")}}' style='margin-right:-10px;'>&nbsp;{{str_replace("- Rep Dashboard","",$settings->title)}}
           	<a href='{{URL::to("dashboard/pureop")}}'><img class="viewpureop tooltwo" title="Click to Access Pure Opportunity Dealer Information " style="margin-top:15px;margin-right:-6px;" src="{{URL::to_asset('img/salesstats-button.png')}}" width=140px ></a>&nbsp;&nbsp;
            <a href='{{URL::to("stats")}}' style='display:none;'><img class="viewpureop tooltwo" title="Click to Access All Time Stats" style="margin-top:15px;margin-right:-6px;" src="{{URL::to_asset('img/salesstats-button.png')}}" width=140px ></a>&nbsp;&nbsp;
           
           </h1>

         <div class="row-fluid" style="margin-top:-28px;">
<?php function days($month, $year)
{
   return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year %400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
};
?>
         	<?php 

         	function calculatePace($input,$time,$ifzero=null){
         		if($time=="WEEK"){
         			$week_ending = date('Y-m-d', strtotime( 'This Sunday'));
         			$days=7;
         			$timeleft = strtotime($week_ending) - strtotime(date('Y-m-d')); 
         			$timeleft = $timeleft/86400;
         		} else if($time=="MONTH"){
         			$days=days(date('M'),date('Y'));
         			$timeleft = date('t')-date('j');
         		}
         		$onpace=0;
         		if($ifzero!=null){
         			$onpace = $input/1;
         		} else {
                    if($input!=0 &&($days-$timeleft)!=0){
                        $onpace = $input/($days-$timeleft);
                    } else {
                        $onpace=0;
                    }
         			
         		}
        		$onpace = number_format(($input + ($onpace*$timeleft)),0,'.','');
         		return $onpace;
         	}

            $clearpercent=0;$avgunits=0;?>
         	@if(!empty($monthSales['totals']['grosssales']))
         	<?php 
         	if(($monthSales['totals']['totgrossunits']!=0)&&($monthSales['totals']['grosssales']!=0)){ 
        		$avgunits = number_format($monthSales['totals']['totgrossunits']/$monthSales['totals']['grosssales'], 2, '.', ' '); 
        	} else {
        		$avgunits = 0;
        	};
    		if(($monthSales['totals']['totnetunits']!=0)&&($monthSales['totals']['totgrossunits']!=0)){ 
        		$clearpercent = number_format(($monthSales['totals']['totnetunits']/$monthSales['totals']['totgrossunits'])*100,0,'.','');
    		} else { 
    			$clearpercent=0;
    		};
         	;?>
         	@endif

         	<?php $wavg=0;$wclear=0;?>
         	@if(!empty($weekSales['totals']['grosssales']))
         	<?php 
            if($weekSales['totals']['totgrossunits']!=0 && $weekSales['totals']['grosssales']!=0 ){
                $wavg = number_format($weekSales['totals']['totgrossunits']/$weekSales['totals']['grosssales'], 2, '.', ' ');} 
                else {$wavg= 0;};
       	    if($weekSales['totals']['totgrossunits']!=0 && $weekSales['totals']['grosssales']!=0){
                $wclear = number_format(($weekSales['totals']['totnetunits']/$weekSales['totals']['totgrossunits'])*100,0,'.','');} 
                else { $wclear=0;};
            ?>
         	@endif

         	<?php

         	if(($monthSales['totals']['totgrossunits']!=0)){
         		$onpace = calculatePace($monthSales['totals']['totgrossunits'],"MONTH");
   		} else {
   			$onpace = 0;
    		}
         	if(($weekSales['totals']['totgrossunits']!=0)){
         		$onpacew = calculatePace($weekSales['totals']['totgrossunits'],"WEEK");
         	} else {
         		$onpacew = 0;
         	}
         	?>
            </div>
  
        <div class="alert adjusted alert-info">
            <button class="close" data-dismiss="alert">×</button>
                <i class="cus-exclamation"></i>
                <strong>{{$latestalert->title}}</strong>{{$latestalert->message}}
        </div>
        <input type="hidden" id="thisSiteURL" value="{{URL::to('')}}">
        <input type="hidden" id="otherSiteURL" value="{{URL::to('')}}">
        <div class="row-fluid" >
            <div class="span6 well onpace-info" style="margin-bottom:20px;">
                <h4 >WEEKLY STATS</h4>
                <div class='row-fluid' style="border-bottom:1px solid #ddd;border-top:1px solid #ddd;padding-top:10px;">
                <div class="number-block" style="margin-right:25px" >
                        <center><span class="dailystats2 BOOK" style="color:white;padding-left:10px;padding-right:20px;">{{$wclear}}%</span></center><br/>
                            <h5>CLEAR</h5>
                    </div>
                    <div class="number-block border-right" style="margin-left:30px;padding-right:28px;">
                        <center><span class="dailystats2 PUTON" style="Padding-left:10px;padding-right:10px;" >{{$wavg}}</span></center><br/>
                        <h5>U/SALE</h5> 
                    </div>
                    <div class="number-block" style="margin-left:0px;">
                        <center><span class="dailystats2 shinygreen" style="color:white;">{{$weekSales['totals']['totgrossunits']}}</span></center><br/>
                            <h5>GROSS</h5>
                    </div>

                    <div class="number-block border-right">
                        <center><span class="dailystats2 shinygreen" style="color:black;">{{$weekSales['totals']['totnetunits']}}</span></center><br/>
                            <h5>NET</h5>
                    </div>
                    <div class="number-block ">
                        <center><span class="dailystats2 BOOK" style="color:aqua;">{{$onpacew}}</span></center><br/>
                            <h5>PACE </h5>
                    </div>
                </div>
                <br/><br/>
                    @if(!empty($weekSales['totals']['appointment']['PUTON']))<?php $puton = $weekSales['totals']['appointment']['PUTON'];?>  @else <?php $puton = 0;?>@endif
                    @if(!empty($weekSales['totals']['totgrossunits']))<?php $units = $weekSales['totals']['totgrossunits'];?>  @else <?php $units = 0;?>@endif
                    @if(!empty($weekSales['totals']['appointment']['PUTON']))<?php $needweekDems = $goalDemWEEK-$weekSales['totals']['appointment']['PUTON'];?>  @else <?php $needweekDems = $goalDemWEEK;?>@endif
                    @if(!empty($weekSales['totals']['grosssales']))<?php $needweekSales = $goalSalesWEEK-$weekSales['totals']['grosssales'];?>  @else <?php $needweekSales = $goalSalesWEEK;?>@endif
                    @if(!empty($weekSales['totals']['totgrossunits']))<?php $needweekUnits = $goalUnitsWEEK-$weekSales['totals']['totgrossunits'];?>  @else <?php $needweekUnits = $goalUnitsWEEK;?>@endif
                <div class="well span4" style="background:url('../images/cardboard_flat.png');">
                    <center>
                    <span class="label label-info special">WEEKS DEMOS</span>
                        <div id="counterdemos" class="counter2"><input type="hidden" name="counter-demos" id="demnum" value="{{$puton}}" /></div>
                        <hr/>
                    <span class="tooltwo label label-inverse" title="YOU NEED {{$needweekDems}} DEMOS TO REACH GOAL FOR PUT ON DEMOS"> NEEDED FOR GOAL</span>
                    <div id="countergoals" class="counter2"><input type="hidden" name="counter-demos" id="goalnum" value="{{$needweekDems}}" /></div>
                    <hr/>
                    <span class="label label-success special">WEEKS UNITS</span>
                        <div id="counterunits" class="counter2"><input type="hidden" name="counter-demos" id="unitnum" value="{{$weekSales['totals']['totgrossunits']}}" /></div>
                    </center>
                </div>

                @if(!empty($weekSales['totals']['appointment']))
                <?php $v=$weekSales['totals'];?>
                <div class="span7" >
                    <center>
                        <h4 style="margin-top:-10px;">SALES THIS WEEK</h4>
                        <canvas id="teamsalespodium" data-value="{{$v['grosssales']}}" style="width:93%;"></canvas>
                        <div class="guagestats" style="margin-left:36px;">
                        </div>
                        <div class="closePercent" style="font-size:30px;float:left;width:100%;height:22px;margin-top:-15px;">
                        Close : <span style='color:#000;'><b>
                         {{number_format($v['appointment']['CLOSE'],0,'.','')}} %
                        </b></span>
                        </div>
                        <div style="width:100%;float:left;margin-left:35px;">
                        <div class="daily-outer">
                            <span class="dailystats PUTON">{{$v['appointment']['PUTON']}}</span><br/>
                            <h5>DEMOS</h5>
                        </div>
                        <div class="daily-outer">
                            <span class="dailystats SOLD" id="week-sales">{{$v['grosssales']}}</span><br/>
                            <h5>SALES</h5>
                        </div>
                        
                        <div class="daily-outer">
                            <span class="dailystats DNS2">{{$v['appointment']['DNS']}}</span><br/>
                            <h5>DNS</h5>
                        </div>
                        </div>
                    </center>
                </div>
                @else

                @endif

                @if($settings->goals==1)

                  <?php $demoGoalWidth = number_format(((intval($weekSales['totals']['appointment']['PUTON'])/intval($goalDemWEEK))*100),0,'.','')."%";
                    	$unitGoalWidth = number_format(((intval($weekSales['totals']['totgrossunits'])/intval($goalUnitsWEEK))*100),0,'.','')."%";
                    	$saleGoalWidth = number_format(((intval($weekSales['totals']['grosssales'])/intval($goalSalesWEEK))*100),0,'.','')."%";

                    	// Pace calculations for goal modules
				$wgoal1pace = 1;$wgoal2pace=1;$wgoal3pace=1;$wgoal1paceper=0;$wgoal2paceper=0;$wgoal3paceper=0;
   				//Goal 1 Pace
				if(($weekSales['totals']['appointment']['PUTON']!=0)){
					$wgoal1pace = calculatePace($weekSales['totals']['appointment']['PUTON'],"WEEK");
					$wgoal1paceper = number_format(((intval($wgoal1pace)/intval($goalDemWEEK))*100),0,'.','')."%";
				}
   				//Goal 2 Pace
				if(($weekSales['totals']['grosssales']!=0)){
					$wgoal2pace = calculatePace($weekSales['totals']['grosssales'],"WEEK");
					$wgoal2paceper = number_format(((intval($wgoal2pace)/intval($goalSalesWEEK))*100),0,'.','')."%";
				}
   				//Goal 3 Pace
				if(($weekSales['totals']['totgrossunits']!=0)){
					$wgoal3pace = calculatePace($weekSales['totals']['totgrossunits'],"WEEK");
					$wgoal3paceper = number_format(((intval($wgoal3pace)/intval($goalUnitsWEEK))*100),0,'.','')."%";
				}

                  ?>
                <div class="span12">
                	<h4>Goal Completion for Week 
                        <a href='{{URL::to("system/settings")}}?goals=true'>
                            <button class='btn btn-default btn-mini pull-right' style='margin-right:55px;'>SET GOALS</button>
                        </a>
                    </h4>
                	@if($settings->goal_type=="guage")
                	<div class="span12" style="margin-left:-20px;margin-top:10px;">
                		<center>
                  <div class="easypie">
				<div class="percentage easyPieChart" data-percent="{{$demoGoalWidth}}" style="width: 88px; height: 88px; line-height: 88px;">
					<span>{{$demoGoalWidth}}</span>
					<canvas width="88" height="88"></canvas>
				</div>
				<div class="easypie-text">
					PUT ON DEMOS<br/>
					{{$weekSales['totals']['appointment']['PUTON']}} out of {{$goalDemWEEK}}
				</div>
			</div>
			<div class="easypie">
				<div class="percentage easyPieChart" data-percent="{{$saleGoalWidth}}" style="width: 88px; height: 88px; line-height: 88px;">
					<span>{{$saleGoalWidth}}</span>
					<canvas width="88" height="88"></canvas>
				</div>
				<div class="easypie-text">
					SOLD DEMOS<br/>
					{{$weekSales['totals']['grosssales']}} out of {{$goalSalesWEEK}} 
				</div>
			</div>
			<div class="easypie">
				<div class="percentage easyPieChart" data-percent="{{$unitGoalWidth}}" style="width: 88px; height: 88px; line-height: 88px;">
					<span>{{$unitGoalWidth}}</span>
					<canvas width="88" height="88"></canvas>
				</div>
				<div class="easypie-text">
					UNITS SOLD<br/>
					{{$weekSales['totals']['totgrossunits']}} out of {{$goalUnitsWEEK}} 
				</div>
			</div>
			</center>
			</div>
			@else
			<style>
				.bar2 {
				  width: 0%;
  				  height: 100%;
  				  color: #ffffff;
  				  float: left;
  				  font-size: 12px;
  				  text-align: center;
  				  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
  				  
  				  background-repeat: repeat-x;
  				  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff149bdf', endColorstr='#ff0480be', GradientType=0);
  				  -webkit-box-shadow: inset 0 -1px 0 rgba(0, 0, 0, 0.15);
  				  -moz-box-shadow: inset 0 -1px 0 rgba(0, 0, 0, 0.15);
  				  box-shadow: inset 0 -1px 0 rgba(0, 0, 0, 0.15);
  				  -webkit-box-sizing: border-box;
  				  -moz-box-sizing: border-box;
  				  box-sizing: border-box;
  				  -webkit-transition: width 0.6s ease;
  				  -moz-transition: width 0.6s ease;
  				  -o-transition: width 0.6s ease;
  				  transition: width 0.6s ease;

				}
				.onpaceArrow {
					float:right;
					color:#000;
					height:100%;
				}
				.littleArrow {
					position:relative;
					margin-top:-26px;
					margin-left:200px;
					z-index:50000;
				}
			</style>
			<br/>
                    <b>Put On Demos :</b> {{$weekSales['totals']['appointment']['PUTON']}} out of {{$goalDemWEEK}}
                    <span class='pull-right' style="margin-right:60px;">
                    @if(intval($needweekDems)< 0)
                        GOAL COMPLETED!! 
                    @else
                        {{$needweekDems}} Needed
                    @endif
                    </span>
                    <div class=" progress " data-type="progress" data-id="{{$needweekDems}}" style="width:90%;">
                        <div class="bar" data-percentage="" style="width:{{$demoGoalWidth}}"></div>

                        <div class="bar2" data-percentage="" style="width:{{$wgoal1paceper}}">
                        	<div class="onpaceArrow tooltwo" title="On Pace for {{$wgoal1pace}} Demos This Week">
                        		<img src="{{URL::to('images/little-arrow.png')}}" style="margin-top:-29px;">
                        	</div>
                        </div>
                    </div>
                    <b>Demos Sold :</b> {{$weekSales['totals']['grosssales']}} out of {{$goalSalesWEEK}} 
                    <span class='pull-right' style="margin-right:60px;">
                    @if(intval($needweekSales)< 0)
                        GOAL COMPLETED!! 
                    @else
                        {{$needweekSales}} Needed
                    @endif
                    </span>
                    <div class=" progress " data-type="progress" data-id="{{$needweekSales}}" style="width:90%;">
                        <div class="bar" data-percentage="" style="width:{{$saleGoalWidth}}"></div>
                        <div class="bar2" data-percentage="" style="width:{{$wgoal2paceper}}">
                        	<div class="onpaceArrow tooltwo" title="On Pace for {{$wgoal2pace}} Sales This Week">
                        		<img src="{{URL::to('images/little-arrow.png')}}" style="margin-top:-29px;">
                        	</div>
                        </div>
                    </div>
                    
                    <b>Units Sold :</b> {{$weekSales['totals']['totgrossunits']}} out of {{$goalUnitsWEEK}} 
                    <span class='pull-right' style="margin-right:60px;">
                    @if(intval($needweekUnits)< 0)
                        GOAL COMPLETED!! 
                    @else
                        {{$needweekUnits}} Needed
                    @endif
                    </span>
                    <div class=" progress " data-type="progress" data-id="{{$needweekUnits}}" style="width:90%;">
                        <div class="bar" data-percentage="" style="width:{{$unitGoalWidth}}"></div>
                        <div class="bar2" data-percentage="" style="width:{{$wgoal3paceper}}">
                        	<div class="onpaceArrow tooltwo" title="On Pace for {{$wgoal3pace}} Units This Week">
                        		<img src="{{URL::to('images/little-arrow.png')}}" style="margin-top:-29px;">
                        	</div>
                        </div>
                    </div>
			     @endif
                </div>
                @endif
            
            </div>


            <div class="span6 well onpace-info" style="margin-bottom:20px;">
                    <h4 >MONTHLY STATS</h4>
                <div class='row-fluid' style="border-bottom:1px solid #ddd;border-top:1px solid #ddd;padding-top:10px;">
                <div class="number-block" style="margin-right:25px"  >
                        <center><span class="dailystats2 BOOK" style="color:white;padding-left:10px;padding-right:20px;">{{$clearpercent}}%</span></center><br/>
                            <h5>CLEAR</h5>
                    </div>
                    <div class="number-block border-right" style="margin-left:30px;padding-right:28px;">
                        <center><span class="dailystats2 PUTON" style="Padding-left:10px;padding-right:10px;">{{$avgunits}}</span></center><br/>
                        <h5>U/SALE</h5>
                    </div>
                    <div class="number-block"  style="margin-left:0px;">
                        <center><span class="dailystats2 shinygreen" style="color:white;">{{$monthSales['totals']['totgrossunits']}}</span></center><br/>
                            <h5>GROSS</h5>
                    </div>
                    <div class="number-block border-right" >
                        <center><span class="dailystats2 shinygreen" style="color:black;">{{$monthSales['totals']['totnetunits']}}</span></center><br/>
                                <h5>NET</h5>
                    </div>
                    <div class="number-block">
                        <center><span class="dailystats2 BOOK" style="color:aqua;">{{$onpace}}</span></center><br/>
                                <h5>PACE</h5>
                    </div>
                </div>
                <br/><br/>
                
                
                    @if(!empty($monthSales['totals']['appointment']['PUTON']))<?php $putonmonth = $monthSales['totals']['appointment']['PUTON'];?>  @else <?php $putonmonth = 0;?>@endif
                    @if(!empty($monthSales['totals']['totgrossunits']))<?php $unitsmonth = $monthSales['totals']['totgrossunits'];?>  @else <?php $unitsmonth = 0;?>@endif
                    @if(!empty($monthSales['totals']['appointment']['PUTON']))<?php $needmonthDems = $goalDemMONTH-$monthSales['totals']['appointment']['PUTON'];?>  @else <?php $needmonthDems = $goalDemMONTH;?>@endif
                    @if(!empty($monthSales['totals']['grosssales']))<?php $needmonthSales = $goalSalesMONTH-$monthSales['totals']['grosssales'];?>  @else <?php $needmonthSales = $goalSalesMONTH;?>@endif
                    @if(!empty($monthSales['totals']['totgrossunits']))<?php $needmonthUnits = $goalUnitsMONTH-$monthSales['totals']['totgrossunits'];?>  @else <?php $needmonthUnits = $goalUnitsMONTH;?>@endif
                    <div class="well span4" style="background:url('../images/cardboard_flat.png');">
                        <center>
                    <span class="label label-info special">MONTHS DEMOS</span>
                    <div id="counterdemosmonth" class="counter2"><input type="hidden" name="counter-demos" id="demnummonth" value="{{$putonmonth}}" /></div><hr/>
                    <span class="label label-inverse tooltwo" title="YOU NEED {{$needmonthDems}} TO REACH GOAL FOR PUT ON DEMOS"> NEEDED FOR GOAL</span>
                    <div id="countergoalsmonth" class="counter2"><input type="hidden" name="counter-demos" id="goalnummonth" value="{{$needmonthDems}}" /></div>
                    <hr/>
                    <span class="label label-success special">MONTHS UNITS</span>
                    <div id="counterunitsmonth" class="counter2"><input type="hidden" name="counter-demos" id="unitnummonth" value="{{$unitsmonth}}" /></div>
                    </center>
                    </div>
                
                @if(!empty($monthSales['totals']['appointment']))
                <?php $v=$monthSales['totals'];?>
                <div class="span7" >
                    <center>
                        <h4 style="margin-top:-10px;">SALES THIS MONTH</h4>
                        <canvas id="teamsalesmonth" data-value="{{$v['grosssales']}}" style="width:93%;"></canvas>
                        <div class="guagestats" style="margin-left:36px;">
                        </div>
                        <div class="closePercent" style="font-size:30px;float:left;width:100%;height:22px;margin-top:-15px;">
                        Close : <span style='color:#000;'>
                        <b>
                        {{number_format($v['appointment']['CLOSE'],0,'.','')}} %
                        </b></span>
                        </div>
                        <div style="width:100%;float:left;margin-left:35px;">
                        <div class="daily-outer">
                            <span class="dailystats PUTON">{{$v['appointment']['PUTON']}}</span><br/>
                            <h5>DEMOS</h5>
                        </div>
                        <div class="daily-outer">
                            <span class="dailystats SOLD" id="month-sales">{{$v['grosssales']}}</span><br/>
                            <h5>SALES</h5>
                        </div>
                       
                        <div class="daily-outer">
                            <span class="dailystats DNS2">{{$v['appointment']['DNS']}}</span><br/>
                            <h5>DNS</h5>
                        </div>
                        </div>
                    </center>
                </div>
                @endif

                @if($settings->goals==1)
                <?php   $demoGoalWidth = number_format(((intval($monthSales['totals']['appointment']['PUTON'])/intval($goalDemMONTH))*100),0,'.','')."%";
                    	$unitGoalWidth = number_format(((intval($monthSales['totals']['totgrossunits'])/intval($goalUnitsMONTH))*100),0,'.','')."%";
                    	$saleGoalWidth = number_format(((intval($monthSales['totals']['grosssales'])/intval($goalSalesMONTH))*100),0,'.','')."%";
                    	$mgoal1pace=1;$mgoal2pace=1;$mgoal3pace=1;$mgoal1paceper=0;$mgoal2paceper=0;$mgoal3paceper=0;
				// Month
				//Goal 1 Pace
				if(($monthSales['totals']['appointment']['PUTON']!=0)){
					$mgoal1pace = calculatePace($monthSales['totals']['appointment']['PUTON'],"MONTH");
					$mgoal1paceper = number_format(((intval($mgoal1pace)/intval($goalDemMONTH))*100),0,'.','')."%";
				}
   				//Goal 2 Pace
				if(($monthSales['totals']['grosssales']!=0)){
					$mgoal2pace = calculatePace($monthSales['totals']['grosssales'],"MONTH");
					$mgoal2paceper = number_format(((intval($mgoal2pace)/intval($goalSalesMONTH))*100),0,'.','')."%";
				}
   				//Goal 3 Pace
				if(($monthSales['totals']['totgrossunits']!=0)){
					$mgoal3pace = calculatePace($monthSales['totals']['totgrossunits'],"MONTH");
					$mgoal3paceper = number_format(((intval($mgoal3pace)/intval($goalUnitsMONTH))*100),0,'.','')."%";
				}


                  ?>
                <div class="span12">
                	<h4>Goal Completion for Month
                    <a href='{{URL::to("system/settings")}}?goals=true'>
                            <button class='btn btn-default btn-mini pull-right' style='margin-right:55px;'>SET GOALS</button>
                        </a>
                    </h4>
                	@if($settings->goal_type=="guage")
                	<div class="span12" style="margin-left:-20px;margin-top:10px;">
                	<center>
                  <div class="easypie">
				<div class="percentage easyPieChart" data-percent="{{$demoGoalWidth}}" style="width: 88px; height: 88px; line-height: 88px;">
					<span>{{$demoGoalWidth}}</span>
					<canvas width="88" height="88"></canvas>
				</div>
				<div class="easypie-text">
					PUT ON DEMOS<br/>
					{{$monthSales['totals']['appointment']['PUTON']}} out of {{$goalDemMONTH}}
				</div>
			</div>
			<div class="easypie">
				<div class="percentage easyPieChart" data-percent="{{$saleGoalWidth}}" style="width: 88px; height: 88px; line-height: 88px;">
					<span>{{$saleGoalWidth}}</span>
					<canvas width="88" height="88"></canvas>
				</div>
				<div class="easypie-text">
					SOLD DEMOS<br/>
					{{$monthSales['totals']['grosssales']}} out of {{$goalSalesMONTH}} 
				</div>
			</div>
			<div class="easypie">
				<div class="percentage easyPieChart" data-percent="{{$unitGoalWidth}}" style="width: 88px; height: 88px; line-height: 88px;">
					<span>{{$unitGoalWidth}}</span>
					<canvas width="88" height="88"></canvas>
				</div>
				<div class="easypie-text">
					UNITS SOLD<br/>
					{{$monthSales['totals']['totgrossunits']}} out of {{$goalUnitsMONTH}} 
				</div>
			</div>
			</center>
			</div>
			@else 
			<br/>
                    <b>Put On Demos :</b> {{$monthSales['totals']['appointment']['PUTON']}} out of {{$goalDemMONTH}}
                    <span class='pull-right' style="margin-right:60px;">
                     @if(intval($needmonthDems)< 0)
                        GOAL COMPLETED!! 
                    @else
                        {{$needmonthDems}} Needed
                    @endif
                    </span>
                    <div class=" progress " data-type="progress" data-id="{{$needmonthDems}}" style="width:90%;">
                        <div class="bar" data-percentage="{{$needmonthDems}}" style="width:{{$demoGoalWidth}}"></div>
                         <div class="bar2" data-percentage="" style="width:{{$mgoal1paceper}}">
                        	<div class="onpaceArrow tooltwo" title="On Pace for {{$mgoal1pace}} Demos This Month">
                        		<img src="{{URL::to('images/little-arrow.png')}}" style="margin-top:-29px;">
                        	</div>
                        </div>
                    </div>
                    <b>Demos Sold :</b> {{$monthSales['totals']['grosssales']}} out of {{$goalSalesMONTH}} 
                    <span class='pull-right' style="margin-right:60px;">
                    @if(intval($needmonthSales)< 0)
                        GOAL COMPLETED!! 
                    @else
                        {{$needmonthSales}} Needed
                    @endif
                    </span>
                    <div class=" progress " data-type="progress" data-id="{{$needmonthSales}}" style="width:90%;">
                        <div class="bar" data-percentage="{{$needmonthSales}}" style="width:{{$saleGoalWidth}}"></div>
                        <div class="bar2" data-percentage="" style="width:{{$mgoal2paceper}}">
                        	<div class="onpaceArrow tooltwo" title="On Pace for {{$mgoal2pace}} Sales This Month">
                        		<img src="{{URL::to('images/little-arrow.png')}}" style="margin-top:-29px;">
                        	</div>
                        </div>
                    </div>
                    <b>Units Sold :</b> {{$monthSales['totals']['totgrossunits']}} out of {{$goalUnitsMONTH}} 
                    <span class='pull-right' style="margin-right:60px;">
                    @if(intval($needmonthUnits)< 0)
                        GOAL COMPLETED!! 
                    @else
                        {{$needmonthUnits}} Needed
                    @endif
                    </span>
                    <div class=" progress " data-type="progress" data-id="{{$needmonthUnits}}" style="width:90%;">
                        <div class="bar" data-percentage="{{$needmonthUnits}}" style="width:{{$unitGoalWidth}}"></div>
                         <div class="bar2" data-percentage="" style="width:{{$mgoal3paceper}}">
                        	<div class="onpaceArrow tooltwo" title="On Pace for {{$mgoal3pace}} Units This Month">
                        		<img src="{{URL::to('images/little-arrow.png')}}" style="margin-top:-29px;">
                        	</div>
                        </div>
                    </div>
			@endif
                </div>
                @endif


               

            </div>
    </div>


   		
	@if(Setting::find(1)->needed==1)
         <div class="row-fluid well" style="padding-bottom:20px;">
         	<h4>Appointments Needed 
         	<a style="float:right;" href="{{URL::to('appointment/needed')}}"><button btn class="btn-primary btn-mini">MANAGE APPOINTMENTS NEEDED</button></a></h4>
          <button class="cityButton-area btn btn-default switchArea" data-type="area">AREA / COUNTIES</button>
          <button class="cityButton-city btn btn-default switchArea" data-type="city">CITIES</button>
                    
                    @if(!empty($needed['needed']))
                    <table class="table table-condensed neededTable city table-bordered apptimetable" style="margin-top:5px;padding:15px;">
                    <thead>
                        <tr align="center">
                            <th style="width:17%;font-weight:bolder">CITIES</th>                  
                            <th colspan=5 style="border-left:4px solid #1f1f1f;"><center>{{date('l - M d')}}</center></th>
                            <th colspan=5 style="border-left:4px solid #1f1f1f;"><center>{{date('l - M d',strtotime('+1 Day'))}}</center></th>
                            <th colspan=5 style="border-left:4px solid #1f1f1f;"><center>{{date('l - M d',strtotime('+2 Day'))}}</center></th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($needed['needed'] as $key=>$val)
                        <tr>
                        <td class="span3 nocenter"><span class="small">{{$val['day1']['needed']['name']}}</span><br/>
                        	@foreach($cities as $val2)
                        	@if($val2->cityname==$val['day1']['needed']['name'])
                        		<span class="small" style="color:#333">RIGHT AWAY | <span class="badge badge-info special edit" style="cursor:pointer;" id="rightaway|{{$val2->id}}" >{{$val2->rightaway}}</span></span>
                        	@endif
                        	@endforeach
                        </td>
                        <td style="border-left:4px solid #1f1f1f;"><center>
                        	{{$needed['slots'][0]['title']}}<br/>
                        	@if(isset($val['day1']['onboard'])) 
                            <span class="label label-inverse">{{$val['day1']['onboard'][0]}}</span> | 
                            <span class='needed label'>
                            @if($val['day1']['onboard'][0]!=0)
                                {{$val['day1']['needed'][0]-$val['day1']['onboard'][0]}}
                                @else {{$val['day1']['needed'][0]}}@endif 
                                @else <span class='needed label'>{{$val['day1']['needed'][0]}}@endif
                            </span>
                            </center>
                            </td>
                        <td><center>
                            {{$needed['slots'][1]['title']}}<br/>
                           
                            @if(isset($val['day1']['onboard'])) 
                            <span class="label label-inverse">{{$val['day1']['onboard'][1]}}</span> | 
                            <span class='needed label'>
                            @if($val['day1']['onboard'][1]!=0)
                                {{$val['day1']['needed'][1]-$val['day1']['onboard'][1]}}
                                @else {{$val['day1']['needed'][1]}}@endif 
                                @else <span class='needed label'>{{$val['day1']['needed'][1]}}@endif
                            </span>
                            </center>
                        </td>
                        <td><center>
                            {{$needed['slots'][2]['title']}}<br/>
                            @if(isset($val['day1']['onboard'])) 
                            <span class="label label-inverse">{{$val['day1']['onboard'][2]}}</span> | 
                            <span class='needed label'>
                            @if($val['day1']['onboard'][2]!=0)
                                {{$val['day1']['needed'][2]-$val['day1']['onboard'][2]}}
                                @else {{$val['day1']['needed'][2]}}@endif 
                                @else <span class='needed label'>{{$val['day1']['needed'][2]}}@endif
                            </span>
                            </center>
                        </td>
                        <td><center>
                            {{$needed['slots'][3]['title']}}<br/>
                            @if(isset($val['day1']['onboard'])) 
                            <span class="label label-inverse">{{$val['day1']['onboard'][3]}}</span> | 
                            <span class='needed label'>
                            @if($val['day1']['onboard'][3]!=0)
                                {{$val['day1']['needed'][3]-$val['day1']['onboard'][3]}}
                                @else {{$val['day1']['needed'][3]}}@endif 
                                @else <span class='needed label'>{{$val['day1']['needed'][3]}}@endif
                            </span>
                            </center>
                        </td>
                        <td><center>
                            {{$needed['slots'][4]['title']}}<br/>
                            @if(isset($val['day1']['onboard'])) 
                            <span class="label label-inverse">{{$val['day1']['onboard'][4]}}</span> | 
                            <span class='needed label'>
                            @if($val['day1']['onboard'][4]!=0)
                                {{$val['day1']['needed'][4]-$val['day1']['onboard'][4]}}
                                @else {{$val['day1']['needed'][4]}}@endif 
                                @else <span class='needed label'>{{$val['day1']['needed'][4]}}@endif
                            </span>
                            </center>
                        </td>
                        <td style="border-left:4px solid #1f1f1f;"><center>
                        	{{$needed['slots'][0]['title']}}<br/>
                        	@if(isset($val['day2']['onboard'])) 
                            <span class="label label-inverse">{{$val['day2']['onboard'][0]}}</span> | 
                            <span class='needed label'>
                            @if($val['day2']['onboard'][0]!=0)
                                {{$val['day2']['needed'][0]-$val['day2']['onboard'][0]}}
                                @else {{$val['day2']['needed'][0]}}@endif 
                                @else <span class='needed label'>{{$val['day2']['needed'][0]}}@endif
                            </span>
                      </center>
                        </td>
                        <td><center>
                            {{$needed['slots'][1]['title']}}<br/>
                           
                            @if(isset($val['day2']['onboard'])) 
                            <span class="label label-inverse">{{$val['day2']['onboard'][1]}}</span> | 
                            <span class='needed label'>
                            @if($val['day2']['onboard'][1]!=0)
                                {{$val['day2']['needed'][1]-$val['day2']['onboard'][1]}}
                                @else {{$val['day2']['needed'][1]}}@endif 
                                @else <span class='needed label'>{{$val['day2']['needed'][1]}}@endif
                            </span>
                            </center>
                        </td>
                        <td><center>
                            {{$needed['slots'][2]['title']}}<br/>
                            @if(isset($val['day2']['onboard'])) 
                            <span class="label label-inverse">{{$val['day2']['onboard'][2]}}</span> | 
                            <span class='needed label'>
                            @if($val['day2']['onboard'][2]!=0)
                                {{$val['day2']['needed'][2]-$val['day2']['onboard'][2]}}
                                @else {{$val['day2']['needed'][2]}}@endif 
                                @else <span class='needed label'>{{$val['day2']['needed'][2]}}@endif
                            </span>
                            </center>
                        </td>
                        <td><center>
                            {{$needed['slots'][3]['title']}}<br/>
                            @if(isset($val['day2']['onboard'])) 
                            <span class="label label-inverse">{{$val['day2']['onboard'][3]}}</span> | 
                            <span class='needed label'>
                            @if($val['day2']['onboard'][3]!=0)
                                {{$val['day2']['needed'][3]-$val['day2']['onboard'][3]}}
                                @else {{$val['day2']['needed'][3]}}@endif 
                                @else <span class='needed label'>{{$val['day2']['needed'][3]}}@endif
                            </span>
                            </center>
                        </td>
                        <td><center>
                            {{$needed['slots'][4]['title']}}<br/>
                            @if(isset($val['day2']['onboard'])) 
                            <span class="label label-inverse">{{$val['day2']['onboard'][4]}}</span> | 
                            <span class='needed label'>
                            @if($val['day2']['onboard'][4]!=0)
                                {{$val['day2']['needed'][4]-$val['day2']['onboard'][4]}}
                                @else {{$val['day2']['needed'][4]}}@endif 
                                @else <span class='needed label'>{{$val['day2']['needed'][4]}}@endif
                            </span>
                            </center>
                        </td>
                        <td style="border-left:4px solid #1f1f1f;"><center>
                        	{{$needed['slots'][0]['title']}}<br/>
                        	@if(isset($val['day3']['onboard'])) 
                            <span class="label label-inverse">{{$val['day3']['onboard'][0]}}</span> | 
                            <span class='needed label'>
                            @if($val['day3']['onboard'][0]!=0)
                                {{$val['day3']['needed'][0]-$val['day3']['onboard'][0]}}
                                @else {{$val['day3']['needed'][0]}}@endif 
                                @else <span class='needed label'>{{$val['day3']['needed'][0]}}@endif
                            </span>
                      </center>
                        </td>
                        <td><center>
                            {{$needed['slots'][1]['title']}}<br/>
                           
                            @if(isset($val['day3']['onboard'])) 
                            <span class="label label-inverse">{{$val['day3']['onboard'][1]}}</span> | 
                            <span class='needed label'>
                            @if($val['day3']['onboard'][1]!=0)
                                {{$val['day3']['needed'][1]-$val['day3']['onboard'][1]}}
                                @else {{$val['day3']['needed'][1]}}@endif 
                                @else <span class='needed label'>{{$val['day3']['needed'][1]}}@endif
                            </span>
                            </center>
                        </td>
                        <td><center> 
                            {{$needed['slots'][2]['title']}}<br/>
                            @if(isset($val['day3']['onboard'])) 
                            <span class="label label-inverse">{{$val['day3']['onboard'][2]}}</span> | 
                            <span class='needed label'>
                            @if($val['day3']['onboard'][2]!=0)
                                {{$val['day3']['needed'][2]-$val['day3']['onboard'][2]}}
                                @else {{$val['day3']['needed'][2]}}@endif 
                                @else <span class='needed label'>{{$val['day3']['needed'][2]}}@endif
                            </span>
                            </center>
                        </td>
                        <td><center>
                            {{$needed['slots'][3]['title']}}<br/>
                            @if(isset($val['day3']['onboard'])) 
                            <span class="label label-inverse">{{$val['day3']['onboard'][3]}}</span> | 
                            <span class='needed label'>
                            @if($val['day3']['onboard'][3]!=0)
                                {{$val['day3']['needed'][3]-$val['day3']['onboard'][3]}}
                                @else {{$val['day3']['needed'][3]}}@endif 
                                @else <span class='needed label'>{{$val['day3']['needed'][3]}}@endif
                            </span>
                            </center>
                        </td>
                        <td><center>
                            {{$needed['slots'][4]['title']}}<br/>
                            @if(isset($val['day3']['onboard'])) 
                            <span class="label label-inverse">{{$val['day3']['onboard'][4]}}</span> | 
                            <span class='needed label'>
                            @if($val['day3']['onboard'][4]!=0)
                                {{$val['day3']['needed'][4]-$val['day3']['onboard'][4]}}
                                @else {{$val['day3']['needed'][4]}}@endif 
                                @else <span class='needed label'>{{$val['day3']['needed'][4]}}@endif
                            </span>
                            </center>
                        </td>
                        </tr>
                        @endforeach
                        @endif
                        </tbody>
         	          </table>

                    @if(!empty($neededarea['needed']))
                    <table class="table table-condensed neededTable area table-bordered apptimetable" style="margin-top:5px;padding:15px;">
                    <thead>
                        <tr align="center">
                            <th style="width:17%;font-weight:bolder">AREA / COUNTY</th>                  
                            <th colspan=5 style="border-left:4px solid #1f1f1f;"><center>{{date('l - M d')}}</center></th>
                            <th colspan=5 style="border-left:4px solid #1f1f1f;"><center>{{date('l - M d',strtotime('+1 Day'))}}</center></th>
                            <th colspan=5 style="border-left:4px solid #1f1f1f;"><center>{{date('l - M d',strtotime('+2 Day'))}}</center></th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($neededarea['needed'] as $key=>$val)
                        <tr>
                        <td class="span3 nocenter"><span class="small">{{$val['day1']['needed']['name']}}</span><br/>
                          @foreach($cities as $val2)
                          @if($val2->cityname==$val['day1']['needed']['name'])
                            <span class="small" style="color:#333">RIGHT AWAY | <span class="badge badge-info special edit" style="cursor:pointer;" id="rightaway|{{$val2->id}}" >{{$val2->rightaway}}</span></span>
                          @endif
                          @endforeach
                        </td>
                        <td style="border-left:4px solid #1f1f1f;"><center>
                          {{$neededarea['slots'][0]['title']}}<br/>
                          @if(isset($val['day1']['onboard'])) 
                            <span class="label label-inverse">{{$val['day1']['onboard'][0]}}</span> | 
                            <span class='needed label'>
                            @if($val['day1']['onboard'][0]!=0)
                                {{$val['day1']['needed'][0]-$val['day1']['onboard'][0]}}
                                @else {{$val['day1']['needed'][0]}}@endif 
                                @else <span class='needed label'>{{$val['day1']['needed'][0]}}@endif
                            </span>
                            </center>
                            </td>
                        <td><center>
                            {{$neededarea['slots'][1]['title']}}<br/>
                           
                            @if(isset($val['day1']['onboard'])) 
                            <span class="label label-inverse">{{$val['day1']['onboard'][1]}}</span> | 
                            <span class='needed label'>
                            @if($val['day1']['onboard'][1]!=0)
                                {{$val['day1']['needed'][1]-$val['day1']['onboard'][1]}}
                                @else {{$val['day1']['needed'][1]}}@endif 
                                @else <span class='needed label'>{{$val['day1']['needed'][1]}}@endif
                            </span>
                            </center>
                        </td>
                        <td><center>
                            {{$neededarea['slots'][2]['title']}}<br/>
                            @if(isset($val['day1']['onboard'])) 
                            <span class="label label-inverse">{{$val['day1']['onboard'][2]}}</span> | 
                            <span class='needed label'>
                            @if($val['day1']['onboard'][2]!=0)
                                {{$val['day1']['needed'][2]-$val['day1']['onboard'][2]}}
                                @else {{$val['day1']['needed'][2]}}@endif 
                                @else <span class='needed label'>{{$val['day1']['needed'][2]}}@endif
                            </span>
                            </center>
                        </td>
                        <td><center>
                            {{$neededarea['slots'][3]['title']}}<br/>
                            @if(isset($val['day1']['onboard'])) 
                            <span class="label label-inverse">{{$val['day1']['onboard'][3]}}</span> | 
                            <span class='needed label'>
                            @if($val['day1']['onboard'][3]!=0)
                                {{$val['day1']['needed'][3]-$val['day1']['onboard'][3]}}
                                @else {{$val['day1']['needed'][3]}}@endif 
                                @else <span class='needed label'>{{$val['day1']['needed'][3]}}@endif
                            </span>
                            </center>
                        </td>
                        <td><center>
                            {{$neededarea['slots'][4]['title']}}<br/>
                            @if(isset($val['day1']['onboard'])) 
                            <span class="label label-inverse">{{$val['day1']['onboard'][4]}}</span> | 
                            <span class='needed label'>
                            @if($val['day1']['onboard'][4]!=0)
                                {{$val['day1']['needed'][4]-$val['day1']['onboard'][4]}}
                                @else {{$val['day1']['needed'][4]}}@endif 
                                @else <span class='needed label'>{{$val['day1']['needed'][4]}}@endif
                            </span>
                            </center>
                        </td>
                        <td style="border-left:4px solid #1f1f1f;"><center>
                          {{$neededarea['slots'][0]['title']}}<br/>
                          @if(isset($val['day2']['onboard'])) 
                            <span class="label label-inverse">{{$val['day2']['onboard'][0]}}</span> | 
                            <span class='needed label'>
                            @if($val['day2']['onboard'][0]!=0)
                                {{$val['day2']['needed'][0]-$val['day2']['onboard'][0]}}
                                @else {{$val['day2']['needed'][0]}}@endif 
                                @else <span class='needed label'>{{$val['day2']['needed'][0]}}@endif
                            </span>
                      </center>
                        </td>
                        <td><center>
                            {{$neededarea['slots'][1]['title']}}<br/>
                           
                            @if(isset($val['day2']['onboard'])) 
                            <span class="label label-inverse">{{$val['day2']['onboard'][1]}}</span> | 
                            <span class='needed label'>
                            @if($val['day2']['onboard'][1]!=0)
                                {{$val['day2']['needed'][1]-$val['day2']['onboard'][1]}}
                                @else {{$val['day2']['needed'][1]}}@endif 
                                @else <span class='needed label'>{{$val['day2']['needed'][1]}}@endif
                            </span>
                            </center>
                        </td>
                        <td><center>
                            {{$neededarea['slots'][2]['title']}}<br/>
                            @if(isset($val['day2']['onboard'])) 
                            <span class="label label-inverse">{{$val['day2']['onboard'][2]}}</span> | 
                            <span class='needed label'>
                            @if($val['day2']['onboard'][2]!=0)
                                {{$val['day2']['needed'][2]-$val['day2']['onboard'][2]}}
                                @else {{$val['day2']['needed'][2]}}@endif 
                                @else <span class='needed label'>{{$val['day2']['needed'][2]}}@endif
                            </span>
                            </center>
                        </td>
                        <td><center>
                            {{$neededarea['slots'][3]['title']}}<br/>
                            @if(isset($val['day2']['onboard'])) 
                            <span class="label label-inverse">{{$val['day2']['onboard'][3]}}</span> | 
                            <span class='needed label'>
                            @if($val['day2']['onboard'][3]!=0)
                                {{$val['day2']['needed'][3]-$val['day2']['onboard'][3]}}
                                @else {{$val['day2']['needed'][3]}}@endif 
                                @else <span class='needed label'>{{$val['day2']['needed'][3]}}@endif
                            </span>
                            </center>
                        </td>
                        <td><center>
                            {{$neededarea['slots'][4]['title']}}<br/>
                            @if(isset($val['day2']['onboard'])) 
                            <span class="label label-inverse">{{$val['day2']['onboard'][4]}}</span> | 
                            <span class='needed label'>
                            @if($val['day2']['onboard'][4]!=0)
                                {{$val['day2']['needed'][4]-$val['day2']['onboard'][4]}}
                                @else {{$val['day2']['needed'][4]}}@endif 
                                @else <span class='needed label'>{{$val['day2']['needed'][4]}}@endif
                            </span>
                            </center>
                        </td>
                        <td style="border-left:4px solid #1f1f1f;" ><center>
                          {{$neededarea['slots'][0]['title']}}<br/>
                          @if(isset($val['day3']['onboard'])) 
                            <span class="label label-inverse">{{$val['day3']['onboard'][0]}}</span> | 
                            <span class='needed label'>
                            @if($val['day3']['onboard'][0]!=0)
                                {{$val['day3']['needed'][0]-$val['day3']['onboard'][0]}}
                                @else {{$val['day3']['needed'][0]}}@endif 
                                @else <span class='needed label'>{{$val['day3']['needed'][0]}}@endif
                            </span>
                      </center>
                        </td>
                        <td><center>
                            {{$neededarea['slots'][1]['title']}}<br/>
                           
                            @if(isset($val['day3']['onboard'])) 
                            <span class="label label-inverse">{{$val['day3']['onboard'][1]}}</span> | 
                            <span class='needed label'>
                            @if($val['day3']['onboard'][1]!=0)
                                {{$val['day3']['needed'][1]-$val['day3']['onboard'][1]}}
                                @else {{$val['day3']['needed'][1]}}@endif 
                                @else <span class='needed label'>{{$val['day3']['needed'][1]}}@endif
                            </span>
                            </center>
                        </td>
                        <td><center> 
                            {{$neededarea['slots'][2]['title']}}<br/>
                            @if(isset($val['day3']['onboard'])) 
                            <span class="label label-inverse">{{$val['day3']['onboard'][2]}}</span> | 
                            <span class='needed label'>
                            @if($val['day3']['onboard'][2]!=0)
                                {{$val['day3']['needed'][2]-$val['day3']['onboard'][2]}}
                                @else {{$val['day3']['needed'][2]}}@endif 
                                @else <span class='needed label'>{{$val['day3']['needed'][2]}}@endif
                            </span>
                            </center>
                        </td>
                        <td><center>
                            {{$neededarea['slots'][3]['title']}}<br/>
                            @if(isset($val['day3']['onboard'])) 
                            <span class="label label-inverse">{{$val['day3']['onboard'][3]}}</span> | 
                            <span class='needed label'>
                            @if($val['day3']['onboard'][3]!=0)
                                {{$val['day3']['needed'][3]-$val['day3']['onboard'][3]}}
                                @else {{$val['day3']['needed'][3]}}@endif 
                                @else <span class='needed label'>{{$val['day3']['needed'][3]}}@endif
                            </span>
                            </center>
                        </td>
                        <td><center>
                            {{$neededarea['slots'][4]['title']}}<br/>
                            @if(isset($val['day3']['onboard'])) 
                            <span class="label label-inverse">{{$val['day3']['onboard'][4]}}</span> | 
                            <span class='needed label'>
                            @if($val['day3']['onboard'][4]!=0)
                                {{$val['day3']['needed'][4]-$val['day3']['onboard'][4]}}
                                @else {{$val['day3']['needed'][4]}}@endif 
                                @else <span class='needed label'>{{$val['day3']['needed'][4]}}@endif
                            </span>
                            </center>
                        </td>
                        </tr>
                        @endforeach
                        @endif
                        </tbody>
                    </table>
         </div>
         @endif
         <?php
         if(isset($_GET['app_date'])){
         	$datepass = $_GET['app_date'];
         } else {
         	$datepass = date('Y-m-d');
         }

         ;?>
         <div class='row-fluid'>
         	<div class="span1">
        	<div class="input-append date" id="datepicker-js" data-date="{{date('Y-m-d')}}" data-date-format="yyyy-mm-dd">
        		<label>Viewing Date : </label>
     			<input class="datepicker-input changedate" size="16" id="appdate" name="appdate" type="text" 
     			@if(isset($datepass))
     			value="{{date('Y-m-d',strtotime($datepass))}}" 
     			@endif
     			placeholder="Select a date" />
  			<span class="add-on"><i class="cus-calendar-2"></i></span>	
  		</div>
  		</div>
  		<div style='margin:auto;width:100%;float:left;'>
        		<?php $num = cal_days_in_month(CAL_GREGORIAN, 5, 1979) ; 
        		$date =  date('1-m-Y',strtotime('this month'));
        		$c=-1;?>

        		@for($i=1;$i<=31;$i++)
        		<?php $c++;?>
        			<button class='changeStatDate btn btn-mini @if(date('Y-m-d')==date('Y-m-d',strtotime($date. ' + '.$c.' days'))) btn-inverse  @else btn-default @endif btn-default' data-date='{{date('Y-m-d', strtotime($date. ' + '.$c.' days'));}}' style='margin-top:4px;'>
        			<span class='small' style='font-weight:normal;font-size:9px;' >{{date('D d',strtotime($date. ' + '.$c.' days'))}}</span>
        			</button>
        		@endfor
        		</div>
         	</div>
         	<input type="hidden" name="dashstats" id="dashstats" value="{{date('Y-m-d')}}"/>
         	<div class="loading-stats" style="width:100%;height:400px;float:left;padding-top:60px;display:none;">
         		<center><img src='{{URL::to('img/loaders/misc/200.gif')}}'></center>
         	</div>
            <div class="dash-stats fluid-container" style="margin-top:20px;" >

            </div>    
            
            <!--RIGHT SIDE WIDGETS-->
        <aside class="right" style="color:#fff;">



        <?php $number = str_split($weekSales['totals']['appointment']['PUTON']);
                if(count($number)==2) array_unshift($number,"");
                if(count($number)==1) array_unshift($number,"","");?>
                <div class="counter" style="margin-left:15px;">
                        <h1 style="margin-left:5px;">PUT ON DEMOS</h1>
                    <div class="num">@if(!empty($number[0])){{$number[0]}}@else0@endif</div>
                    <div class="num">@if(!empty($number[1])){{$number[1]}}@else0@endif</div>
                    <div class="num">@if(!empty($number[2])){{$number[2]}}@else0@endif</div>
                    <h2 style="margin-left:30px;">THIS WEEK</h2>
                </div>
            @render('layouts.chat')
           <br/><br/>
           <h4>TOP MARKETERS FOR WEEK</h4>
            @include('plugins.topmarketers')
     
          
        </aside>
        <!--END RIGHT SIDE WIDGETS-->

        </div>
        <!-- end main content -->
    </div>
</div><!--end fluid-container-->
<div class="push"></div>
<script src="{{URL::to_asset('js/highcharts.js')}}"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
<script src="{{URL::to_asset('js/include/gmap3.min.js')}}"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&amp;language=en"></script>
<script src="{{URL::to_asset('js/include/guage.min.js')}}"></script>
<script src="{{URL::to_asset('js/flip2.js')}}"></script>
<script src="{{URL::to_asset('js/editable.js')}}"></script>

 
<script>
$(document).ready(function(){

$('.switchArea').click(function(){
     var type=$(this).data('type');
     $('.switchArea').removeClass('btn-inverse');
     localStorage.setItem("areaType",type);
     $(this).addClass('btn-inverse');
      $('.neededTable').hide();
     $('.neededTable.'+type).show();
 });
 if(localStorage.getItem("areaType")){
     $('.cityButton-'+localStorage.getItem("areaType")).trigger('click');
 }
var date = $('#dashstats').val();
$('.dash-stats').load('{{URL::to("dashboard/managerdashstats")}}?dash_date='+date);

var refresh = function(){
    $('.dash-stats').load('{{URL::to("dashboard/managerdashstats")}}?dash_date='+date);
}
setInterval(refresh,35000);


$('.viewSaleModal').click(function(e){
    e.preventDefault();
    var id = $(this).data('id');
});


$(document).on('click','.show_lead_details',function(){
    if($(this).is(':checked')){
        var val=1;
    } else {
        var val=0;
    }
    $.post('{{URL::to("settings/edit")}}',{field:'show_lead_info',value: val},function(data){
        if(data!="failed"){
            toastr.success("Setting Saved","SAVED");
            if(val==1){
                $('.lead_info').removeClass('hidden');
            } else {
                $('.lead_info').addClass('hidden');
            }
        }
    });
});


$('#appdate').change(function(){
	var date = $(this).val();
	$('.dash-stats').load('{{URL::to("dashboard/managerdashstats")}}?dash_date='+date);
});

$('.changeStatDate').click(function(){
	$('.changeStatDate').removeClass('btn-inverse');
	$(this).addClass('btn-inverse');
	var date = $(this).data('date');
	
	$('#appdate').val(date);
	$('.loading-stats').show();
	$('.dash-stats').hide();
	$('.dash-stats').load('{{URL::to("dashboard/managerdashstats")}}?dash_date='+date,function(){
		$('.loading-stats').hide();
		$('.dash-stats').show();
	});
});

$('.needed').each(function(i,val){
  var value = $(this).html();
  if((value<=2)){
      $(this).addClass("label-important blackText bordbut special");
  }else if((value>=3)&&(value<=5)){
      $(this).addClass("label-info bordbut special");
  } else if((value>5)&&(value<=8)){
      $(this).addClass("label-success bordbut special");
  } else {
      $(this).addClass("label-warning special blackText");
  }
});




$('.edit').editable('{{URL::to("cities/edit")}}',{
        indicator : 'Saving...',
         tooltip   : 'Click to edit...',
         submit  : 'OK',
         width:'40',
         height:'25'
});
});
</script>


<script>
function getguageslim(gval, element, max, linecolor, backcolor, guagewidth){
var opts = {
  lines: 22, 
  angle: 0,
  lineWidth: guagewidth, 
  pointer: {
    length: 0.9, 
    strokeWidth: 0.08,
    color: linecolor
  },
  limitMax: 'true',   
  colorStart: '#002906',  
  colorStop: '#00DA41',    
  strokeColor: backcolor,  
  generateGradient: true
};
var target = document.getElementById(element); 
var gauge = new Gauge(target).setOptions(opts); 
gauge.maxValue = max; 
gauge.animationSpeed = 32; 
if(gval>max){
    theValue = max;
} else if(gval==0){
    theValue = 0.01;
} else {
    theValue = gval;
}
gauge.set(theValue); 

}
</script>


<?php
$string = ""; $total=0;
if(!empty($crosslinks)){
	foreach($crosslinks as $v){
		$total=intval($total)+intval($v[0]->contest_totals);
	}
}

?>

<script>
$(document).ready(function(){

total = {{intval($total)}}

console.log(total);
$("#contestcounter").flipCounter(
        "startAnimation", 
        {
        numIntegralDigits:3,
        duration:1000,
        number:0,
        end_number: parseInt($('#contestnum').val())+parseInt(total)
  }
);

$("#counterdemos").flipCounter(
        "startAnimation", 
        {
        numIntegralDigits:3,
        duration:1000,
        number:0,
        end_number: $('#demnum').val()}
);

$("#counterunits").flipCounter(
        "startAnimation", 
        {
        numIntegralDigits:3,
        duration:1000,
        number:0,
        end_number: $('#unitnum').val()}
);

$("#countergoals").flipCounter(
        "startAnimation", 
        {
        numIntegralDigits:3,
        duration:1000,
        number:0,
        end_number: $('#goalnum').val()}
);



$('.viewOffice').click(function(){
	$('.specialist-BOXES').hide();
});

$("#counterdemosmonth").flipCounter(
        "startAnimation", 
        {
        numIntegralDigits:3,
        duration:1000,
        number:0,
        end_number: $('#demnummonth').val()}
);

$("#counterunitsmonth").flipCounter(
        "startAnimation", 
        {
        numIntegralDigits:3,
        duration:1000,
        number:0,
        end_number: $('#unitnummonth').val()}
);

$("#countergoalsmonth").flipCounter(
        "startAnimation", 
        {
        numIntegralDigits:3,
        duration:1000,
        number:0,
        end_number: $('#goalnummonth').val()}
);

var weekval = $('#teamsalespodium').data('value');
var monthval = $('#teamsalesmonth').data('value');
var goalSalesWEEK = "{{$goalSalesWEEK}}";
var goalSalesMONTH = "{{$goalSalesMONTH}}";

getguageslim(weekval, 'teamsalespodium', goalSalesWEEK,'#000','#AAA',0.27);
getguageslim(monthval, 'teamsalesmonth', goalSalesMONTH,'#000','#AAA',0.27);
$('.viewmarketingstats').click(function(){
$('#marketingstats').show().addClass('animated fadeInUp');
});



$('.showPureOp').click(function(){
	var id = $(this).data('id');
	$('.specialistbox').hide();
	$('#rep-'+id).show();
})

$(document).on('click','.backToList',function(){
   var imageUrl = "{{URL::to('images/subtle_clouds.jpg')}}";
   $('#pureOpInfoPanel').css('background-image', 'url(' + imageUrl + ')');
	$(this).hide();
	$('#leadViewer').hide();
	$('.pureOpInfoPanel').show();
	$('.repInfo-charts').hide();
    	$('.saleTable').hide();
    	$('.repTable').hide();
    	$('#monthRepTable').show();
    	$('#monthSaleTable').show();
    	$('#productTable').show();
    	$('.showSaleTable').show();


	$('.backToList').hide();
	
});



$('.filter').click(function(){
var filter = $(this).data('status');
hide(filter);
});

function hide(category) {
    var objs = $("#map2").gmap3({
        get: {
            name:"marker",
            all: true
        }
    });    
    $.each(objs, function(i, obj){
        obj.setVisible(false);
    });

    var objs = $("#map").gmap3({
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