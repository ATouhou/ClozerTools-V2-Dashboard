@layout('layouts/main')
@section('content')
<div id="main" role="main" class="container-fluid">
    <div class="contained">
    	<aside>
        	@render('layouts.managernav')
        	@render('sidewidgets.leftside')
        </aside>

        <div id="page-content" >
            <h1 id="page-header">Weekly Booking Goals <button class="btn btn-default viewmonth right-button" onclick="$('#monthstars').show();$('#podiums').hide();">VIEW MONTHS STARS</button><button class="btn btn-default viewmonth right-button" onclick="$('#podiums').show();$('#monthstars').hide();" >VIEW TEAM RANKING</button><div class="startotal animated rollIn"></div><div class="startotal week animated rollIn"></div></h1>   
				<div class="fluid-container" >
                    <section id="widget-grid" class="">
                    	<div class="row-fluid">
                   		
                        <div class="well span12 animated fadeInUp" id="podiums" >
                        	<h2>Top Marketers for this Week</h2>
                        	
                            <div class="row-fluid">
            @if(!empty($marketpodium['booked']))
            <div class="span4">
                <div class="podium">    
                    <div class="avatar1 ">
                        @if(isset($marketpodium['booked'][1]['booker_name'])) 
                        {{$marketpodium['booked'][1]['booker_name']}}<br/><img src="{{User::find($marketpodium['booked'][1]['booker_id'])->avatar_link()}}" >
                        @endif
                    </div>
                    <div class="avatar2 animated fadeInDownBig">
                        @if(isset($marketpodium['booked'][0]['booker_name'])) 
                        {{$marketpodium['booked'][0]['booker_name']}}<br/><img src="{{User::find($marketpodium['booked'][0]['booker_id'])->avatar_link()}}" >
                        @endif
                    </div>
                    <div class="avatar3 ">
                        @if(isset($marketpodium['booked'][2]['booker_name'])) 
                        {{$marketpodium['booked'][2]['booker_name']}}<br/><img src="{{User::find($marketpodium['booked'][2]['booker_id'])->avatar_link()}}" >
                        @endif</div>
                    <div class="podiumhead" style="margin-left:90px">DEMOS BOOKED</div>
                </div>
                <table class="table table-bordered table-condensed toptable" />
                    <thead>
                        <th><center>Rank</center></th>
                        <th>Booker</th>
                        <th><center>Booked</center></th>
                        <th><center>Close %</center></th>
                    </thead>
                    <tbody >
                    <?php $count=0;?>
                    @foreach($marketpodium['booked'] as $val)
                    <?php $count++;?>
                        <tr>
                            <td><center>{{$count}}</center></td>
                            <td class="left">{{$val['booker_name']}}</center></td>
                            <td><center><strong>{{$val['app']}}</strong></center></td>
                            <td><center><span class="small">{{number_format($val['bookper'],2,'.','')}}%</span></center></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="span4">
                <h4 style="margin-top:20px;margin-left:10px;">NOT ENOUGH DATA TO CALCULATE STATS</h4>
                <div class="podium" style="margin-bottom:40px;"></div>
            </div>
            @endif
            @if(!empty($marketpodium['puton']))
            <div class="span4">
                <div class="podium">    
                    <div class="avatar1 ">
                         @if(isset($marketpodium['puton'][1]['booker_name'])) 
                        {{$marketpodium['puton'][1]['booker_name']}}<br/><img src="{{User::find($marketpodium['puton'][1]['booker_id'])->avatar_link()}}" >
                        @endif
                    </div>
                    <div class="avatar2 animated fadeInDownBig">
                         @if(isset($marketpodium['puton'][0]['booker_name'])) 
                        {{$marketpodium['puton'][0]['booker_name']}}<br/><img src="{{User::find($marketpodium['puton'][0]['booker_id'])->avatar_link()}}" >
                        @endif
                    </div>
                    <div class="avatar3 ">
                         @if(isset($marketpodium['puton'][2]['booker_name'])) 
                        {{$marketpodium['puton'][2]['booker_name']}}<br/><img src="{{User::find($marketpodium['puton'][2]['booker_id'])->avatar_link()}}" >
                        @endif
                    </div>
                    <div class="podiumhead" style="margin-left:90px">PUTON DEMOS</div>
                </div>
                <table class="table table-bordered table-condensed toptable" />
                    <thead>
                        <th><center>Rank</center></th>
                        <th>Booker</th>
                        <th><center>Put On</center></th>
                    </thead>
                    <tbody >
                    <?php $count=0;?>
                        @foreach($marketpodium['puton'] as $val)
                        <?php $count++;?>
                        <tr>
                            <td><center>{{$count}}</center></td>
                            <td class="left">{{$val['booker_name']}}</center></td>
                            <td><center><strong>{{$val['puton']}}</strong></center></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="span4">
                <h4 style="margin-top:20px;margin-left:10px;">NOT ENOUGH DATA TO CALCULATE STATS</h4>
                <div class="podium" style="margin-bottom:40px;"></div>
            </div>
            @endif
            @if(!empty($marketpodium['hold']))
            <div class="span4">
                <div class="podium">    
                    <div class="avatar1 ">
                        @if(isset($marketpodium['hold'][1]['booker_name'])) 
                        {{$marketpodium['hold'][1]['booker_name']}}<br/><img src="{{User::find($marketpodium['hold'][1]['booker_id'])->avatar_link()}}" >
                        @endif
                    </div>
                    <div class="avatar2 animated fadeInDownBig">
                         @if(isset($marketpodium['hold'][0]['booker_name'])) 
                        {{$marketpodium['hold'][0]['booker_name']}}<br/><img src="{{User::find($marketpodium['hold'][0]['booker_id'])->avatar_link()}}" >
                        @endif
                    </div>
                    <div class="avatar3 ">
                         @if(isset($marketpodium['hold'][2]['booker_name'])) 
                        {{$marketpodium['hold'][2]['booker_name']}}<br/><img src="{{User::find($marketpodium['hold'][2]['booker_id'])->avatar_link()}}" >
                        @endif
                    </div>
                    <div class="podiumhead" style="margin-left:90px">PUTON DEMOS</div>
                </div>
                <table class="table table-bordered table-condensed toptable" />
                    <thead>
                        <th><center>Rank</center></th>
                        <th>Booker</th>
                        <th><center>Hold %</center></th>
                    </thead>
                    <tbody >
                    <?php $count=0;?>
                        @foreach($marketpodium['hold'] as $val)
                        <?php $count++;?>
                        <tr>
                            <td><center>{{$count}}</center></td>
                            <td class="left">{{$val['booker_name']}}</center></td>
                            <td><center><strong>{{number_format($val['hold'],2,'.','')}}%</strong></center></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="span4">
                <h4 style="margin-top:20px;margin-left:10px;">NOT ENOUGH DATA TO CALCULATE STATS</h4>
                <div class="podium" style="margin-bottom:40px;"></div>
            </div>
            @endif
        </div>

                        @if(!empty($bookerstats))
                        <div class="row-fluid">
                         	<div class="span5" style="padding-left:15px;margin-top:25px;">
                                 <?php $recent = Auth::user()->recentActivity(); $allrecent = Auth::user()->recentActivity("all");?>
                                 <h5>Last Activity for {{Auth::user()->fullName()}}</h5>
                        <ul class='recentActivity'>
                    <?php $ct = 0;?>
                @foreach($recent as $act)
                <?php $ct++;?>
                @if($ct<=1)
                    <li><span class='bigCount'>{{$act->points}}</span><span class='smallCount'>Pts</span>&nbsp;&nbsp;&nbsp;&nbsp;<span style='font-size:12px;'>{{$act->historyMessage()}}</span><span style='color:#aaa;'>| {{date('M-d',strtotime($act->history_date))}}</span> 
                        @if($act->sale_id!=0)
                            &nbsp;&nbsp;<img src='{{URL::to("images/pureop-small-")}}{{$act->appt->systemsale}}.png' style='width:30px;'>
                            @endif
                        <br/>
                        <span class='smallSideNote'>
                            @if($act->lead_id!=0 && $act->appt_id!=0)
                            <?php $nm = explode(" ",$act->lead->cust_name);?>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Appointment Booked By : {{$act->appt->booked_by}} | Customer : {{ucfirst(strtolower($nm[0]))}}

                            @endif
                        </span>
                    </li>
                    @endif
                @endforeach
                </ul>
                <h5>Recent Marketing Team Feed</h5>
                <ul class='recentActivity'>
                @foreach($allrecent as $act)
                    <li><span class='bigCount'>{{$act->points}}</span><span class='smallCount'>Pts</span>&nbsp;&nbsp;&nbsp;&nbsp;<span style='font-size:12px;'>{{$act->message}}</span> <span style='color:#aaa;'>| {{date('M-d',strtotime($act->history_date))}}</span> 
                        @if($act->sale_id!=0)
                            &nbsp;&nbsp;<img src='{{URL::to("images/pureop-small-")}}{{$act->appt->systemsale}}.png' style='width:30px;'>
                            @endif
                        <br/>
                        <span class='smallSideNote'>
                            @if($act->lead_id!=0 && $act->appt_id!=0)
                            <?php $nm = explode(" ",$act->lead->cust_name);?>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Appointment Booked By : {{$act->appt->booked_by}} | Customer : {{ucfirst(strtolower($nm[0]))}}

                            @endif
                        </span>
                    </li>
                @endforeach
                </ul>
							
                        </div>

                        <div class="span6" style="margin-top:30px;">
                        <h5>MARKETING STATS FOR THE WEEK</h5>
                        <table class="table table-bordered table-condensed " style="border:1px solid #1f1f1f;" >
                            <thead style="color:#000!important">
                                <th>Booker</th>
                                <th>Close</th>
                                <th>APP</th>
                                <th>NI</th>
                                <th>NH</th>
                                <th>NQ</th>
                                <th>DNC</th>
                                <th>Wrong</th>
                                <th>Recalls</th>
                                <th>TOTAL</th>
                            </thead>
                            <tbody class=''>
                            	<?php $ni = 0; $app=0; $totals=0;?>
                                @foreach($bookerstats as $val)

                                <?php $u = User::find($val->caller_id);?>
                                @if(!empty($u))
                                @if($u->user_type=="agent")
                                <tr><?php $app = $app+$val->app; $ni = $ni+$val->ni;$totals = $totals+$val->tot;?>
                                    <td>{{$u->firstname}}</td>
                                    <td>@if(($val->app!=0)&&($val->ni!=0)) {{number_format(($val->app/($val->app+$val->ni)*100),2,'.','')}}% @endif</td>
                                    <td><center>@if($val->app!=0)<span class="label label-success">{{$val->app}}</span>@endif</center></td>
                                    <td><center>@if($val->ni!=0)<span class="label label-important">{{$val->ni}}</span>@endif</center></td>
                                    <td><center>@if($val->nh!=0)<span class="label label-inverse">{{$val->nh}}</span>@endif</center></td>
                                    <td><center>@if($val->nq!=0)<span class="label label-important special">{{$val->nq}}</span>@endif</center></td>
                                    <td><center>@if($val->dnc!=0)<span class="label label-important special">{{$val->dnc}}</span>@endif</center></td>
                                    <td><center>@if($val->wrong!=0)<span class="label label-warning">{{$val->wrong}}</span>@endif</center></td>
                                    <td><center>@if($val->recall!=0){{$val->recall}}@endif</center></td>
                                    <td><center><span class='label label-info special'>{{$val->tot}}</span></td>
                                </tr>
                                @endif
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                        <br/><br/>
                        <div style="margin-top:40px;margin-right:60px;margin-bottom:40px;">
                            <center>
                                <?php $ni = 0; $app=0; $totals=0;
                                foreach($bookerstats as $val){
                                    $u = User::find($val->caller_id);
                                    if(!empty($u)){
                                    if($u->user_type=="agent"){
                                    $ni = $ni+$val->ni;$totals=$totals+$val->tot;$app=$app+$val->app;}}

                                };
                                if(($app!=0)&&($ni!=0)){
                                    $percent = number_format(($ni/($ni+$app)*100),2,'.','');
                                } else {$percent=0.01;}
                                ?>

                                <h5>MARKETING TEAM CLOSING %</h5>
                                <canvas id="teamsales" data-value="{{$percent}}"></canvas> <br><span class="shadow" style="font-size:25px;">{{$percent}}%</span><hr>
                                <h4>We made <span style="padding-left:6px;padding:5px;background:#1f1f1f;color:#fff;border-radius:4px;">{{$totals}} </span> &nbsp;calls this week so far...</h4>
                            </center>
                            </div>
                        </div>
                       
                        </div>
                        @endif
                        
                        </div>
                    </div>
                
                    	

                        <div class="row-fluid animated fadeInUp" id="monthstars" style="display:none;">
                        	<?php $start  = new DateTime('first day of this month');
								  $end    = new DateTime('first day of this month + 1 month');
								  $period = new DatePeriod($start, new DateInterval('P1D'), $end);
								  $starcount = 0;
							?>

                        <div class="well span12" >
                        	<h2>Stars for the Month <div class="startotal"></div></h2>
                        	<h5 style="margin-left:8px;">Your Stars Earned for the Week of {{date('M-d')}}</h5>
                        	<div class="datebox" style="padding-left:20px;">
                       		@foreach($period as $day)
                        		<div class="monthbox"  style="width:20%;font-size:14px;">
                        			<div class="datehead">{{$day->format('D M-d')}}</div>
                        		
                        			<center>
                        				@if(isset($yourstats[$day->format('Y-m-d')])&&(isset($holdstats[$day->format('Y-m-d')])))
                        				
                        				<div style="padding:20px;">
                        				<table class="table table-condensed monthstartable" >
                        				
                        					<tbody>
                        						<tr>
                        							<td><strong>Book / Hr</strong></td>
                        							<td><center>{{$yourstats[$day->format('Y-m-d')]['avg']}}/hr</center></td>
                        							<td style="width:23px;">@if($yourstats[$day->format('Y-m-d')]['avg']>=1.5) 
                        								<?php $starcount++;?>
                        								<img src="{{URL::to_asset('images/star-mini.png')}}"> 
                        								@endif</td>
                        						</tr>
                        						<tr>
                        							<td><strong>Booked</strong></td>
                        							<td><center>{{$yourstats[$day->format('Y-m-d')]['booked']}}</center></td>
                        							<td style="width:23px;">@if($yourstats[$day->format('Y-m-d')]['booked']>=10)
                        							<?php $starcount++;?> 
                        								<img src="{{URL::to_asset('images/star-mini.png')}}"> 
                        								@endif</td>
                        						</tr>
                        						<tr>
                        							<td><strong>Put On</strong></td>
                        							<td><center>{{$holdstats[$day->format('Y-m-d')]['puton']}}</center></td>
                        							<td style="width:23px;">@if($holdstats[$day->format('Y-m-d')]['puton']>=5) 
                        								<?php $starcount++;?>
                        								<img src="{{URL::to_asset('images/star-mini.png')}}"> 
                        								@endif</td>
                        						</tr>
                        						<tr>
                        							<td><strong>Close %</strong></td>
                        							<td><center>{{$yourstats[$day->format('Y-m-d')]['bookper']}}%</center></td>
                        							<td style="width:23px;">@if($yourstats[$day->format('Y-m-d')]['bookper']>=46) 
                        								<?php $starcount++;?>
                        								<img src="{{URL::to_asset('images/star-mini.png')}}"> 
                        								@endif</td>
                        						</tr>

                        					
                        						<tr>
                        							<td><strong>Hold %</strong></td>
                        							<td><center>{{number_format($holdstats[$day->format('Y-m-d')]['hold'],2,'.','')}}%</center></td>
                        							<td style="width:23px;">@if($holdstats[$day->format('Y-m-d')]['hold']>=46)
                        							<?php $starcount++;?> 
                        								<img src="{{URL::to_asset('images/star-mini.png')}}"> 
                        								@endif
                        							</td>
                        						</tr>
                        					</tbody>
                         				</table>
                         				</div>
                        			
                        				@else 

                        				
                        				<div style="padding:20px;">
                        				<table class="table table-condensed monthstartable" >
                        					
                        					<tbody>
                        						<tr>
                        							<td><strong>Book / Hr</strong></td>
                        							<td><center></center></td>
                        							<td style="width:30px;"></th>
                        						</tr>
                        						<tr>
                        							<td><strong>Booked</strong></td>
                        							<td><center></center></td>
                        							<td style="width:30px;"></th>
                        						</tr>
                        						<tr>
                        							<td><strong>Put On</strong></td>
                        							<td><center></center></td>
                        							<td style="width:30px;"></th>
                        						</tr>
                        						<tr>
                        							<td><strong>Close %</strong></td>
                        							<td><center></center></td>
                        							<td style="width:30px;"></th>
                        						</tr>

                        					
                        						<tr>
                        							<td><strong>Hold %</strong></td>
                        							<td><center></center></td>
                        							<td style="width:30px;"></th>
                        						</tr>
                        					</tbody>
                         				</table>
                         				</div>


                        				@endif
                        			</center>
                        		</div>

                      		@endforeach
                        	</div>  
                        </div>
                    </div>

                       

                        <div class="well row-fluid">
                        	<?php $date = new DateTime();
								  $date->modify('this week');
								  $weekstars = 0;?>
                            <div class='row-fluid'>
                        	<h3 style="margin-left:20px;">Your Daily Closing % for Week <span class="goals">1 Star :  > 46% </span> </h3>
                              	<div class="datebox">
                          		@for($i=0;$i<=6;$i++)
                           		<?php $date->modify('this week +'.$i.' days');?>

                        		<div class="daybox">
                        			<div class="datehead">{{$date->format('D M-d')}}</div>
                        			<center>
                        				@if(isset($yourstats[$date->format('Y-m-d')]))
                        				
                        				@if($yourstats[$date->format('Y-m-d')]['bookper']<46)
                        				<img src="{{URL::to_asset('images/star-grey.png')}}" >
                        				@elseif($yourstats[$date->format('Y-m-d')]['bookper']>=46)
                        				<?php $weekstars++;?>
                        				<img src="{{URL::to_asset('images/star-color.png')}}" class="animated fadeInUpBig">
                        				@elseif($yourstats[$date->format('Y-m-d')]['bookper']>60)
                        				<?php $weekstars++;?>
                        				<img src="{{URL::to_asset('images/star-color.png')}}" class="animated fadeInUpBig">
                        				@endif
                        				<div class="avg">{{$yourstats[$date->format('Y-m-d')]['bookper']}}%</div>
                        				@else 
                        				<img src="{{URL::to_asset('images/star-grey.png')}}" >
                        				@endif
                        				
                        			</center>
                        		</div>
                        		@endfor
                        	</div>
                            </div>

                        
                        	<?php 
         						$date = new DateTime();
								$date->modify('this week');
							?>
                            <div class='row-fluid'>
                        	<h3 style="margin-left:20px;">Your Bookings Per Hour For Week <span class="goals">1 Star : 1.5  &nbsp;&nbsp;&nbsp;2 Star : 2.5</span> </h3>
                              	<div class="datebox">
                          		@for($i=0;$i<=6;$i++)
                           		<?php $date->modify('this week +'.$i.' days');?>

                        		<div class="daybox">
                        			<div class="datehead">{{$date->format('D M-d')}}</div>
                        			<center>
                        				@if(isset($yourstats[$date->format('Y-m-d')]))
                        				
                        				@if($yourstats[$date->format('Y-m-d')]['avg']<1.5)
                        				<img src="{{URL::to_asset('images/star-grey.png')}}" >
                        				@elseif($yourstats[$date->format('Y-m-d')]['avg']>=1.5)
                        				<?php $weekstars++;?>
                        				<img src="{{URL::to_asset('images/star-color.png')}}" class="animated fadeInUpBig">
                        				@elseif($yourstats[$date->format('Y-m-d')]['avg']>=2.5)
                        				<?php $weekstars++;?>
                        				<img src="{{URL::to_asset('images/star-color.png')}}" class="animated fadeInUpBig">
                        				@endif

                        				<div class="avg">{{$yourstats[$date->format('Y-m-d')]['avg']}} / hr</div>
                        				@else 
                        				<img src="{{URL::to_asset('images/star-grey.png')}}">
                        				@endif
                        				
                        			</center>
                        		</div>
                        		@endfor
                        	</div>
                            </div>

                        	 <div class="row-fluid">
                            <?php 
         						$date = new DateTime();
								$date->modify('this week');
								
							?>
                            <div class='row-fluid'>
                        	<h3 style="margin-left:20px;">Your Daily Bookings for Week <span class="goals">49 / 10</span></h3>
                              	<div class="datebox">
                          		@for($i=0;$i<=6;$i++)
                           		<?php $date->modify('this week +'.$i.' days');?>

                        		<div class="daybox">
                        			<div class="datehead">{{$date->format('D M-d')}}</div>
                        			<center>
                        				@if(isset($yourstats[$date->format('Y-m-d')]))
                        				@if($yourstats[$date->format('Y-m-d')]['booked']<10)
                        				<img src="{{URL::to_asset('images/star-grey.png')}}" >
                        				@elseif($yourstats[$date->format('Y-m-d')]['booked']>=10)
                        				<?php $weekstars++;?>
                        				<img src="{{URL::to_asset('images/star-color.png')}}" class="animated fadeInUpBig">
                        				@elseif($yourstats[$date->format('Y-m-d')]['booked']>=16)
                        				<?php $weekstars++;?>
                        				<img src="{{URL::to_asset('images/star-color.png')}}" class="animated fadeInUpBig">
                        				@endif
                        				<div class="avg">{{$yourstats[$date->format('Y-m-d')]['booked']}}</div>
                        				@else 
                        				<img src="{{URL::to_asset('images/star-grey.png')}}" >
                        				@endif
                        			</center>
                        		</div>
                        		@endfor
                        		
                        	</div>
                        </div>
                        	<button class="btn btn-small btn-default showstatsbutton" data-id="booked" >SHOW MONTH</button>
                        	<div class="span4">
                        		<table class="responsive table table-condensed bookertables" id="booktable-booked" style="border:1px solid #1f1f1f;margin-left:-10px;">
                        			<thead>
                        				<th>Date</th><th>Booked</th>
                        			</thead>

                        			<tbody>
                        				@foreach($yourstats as $val)
                        				<?php if($val['booked']>=10){$status = "success special";$star = "&nbsp;&nbsp;<img src='".URL::to_asset('images/star-mini.png')."'>";} else {$status="inverse";$star="";};?>
                        				<tr>
                        					<td>{{date('D M-d', strtotime($val['date']))}}</td>
                        					<td>@if($val['booked']!=0)<span class="label label-{{$status}}">{{$val['booked']}}</span>{{$star}}@endif</td>
                        				</tr>
                        				@endforeach
                        			</tbody>
                        		</table>
                        	</div>
                        	</div>

                        	
                       		
                        	<div class="row-fluid">
                        	@if(!empty($holdstats))
							<?php 
         						$date = new DateTime();
								$date->modify('this week');
							?>
                        	<h3 style="margin-left:20px;">Your Put On Demos for Week <span class="goals">23 / 5</span></h3>
                              	<div class="datebox">
                          		@for($i=0;$i<=6;$i++)
                           		<?php $date->modify('this week +'.$i.' days');?>

                        		<div class="daybox">
                        			<div class="datehead">{{$date->format('D M-d')}}</div>
                        			<center>
                        				@if(isset($holdstats[$date->format('Y-m-d')]))
                        				
                        				@if($holdstats[$date->format('Y-m-d')]['puton']<5)
                        				<img src="{{URL::to_asset('images/star-grey.png')}}" >
                        				@elseif($holdstats[$date->format('Y-m-d')]['puton']>=5)
                        				<?php $weekstars++;?>
                        				<img src="{{URL::to_asset('images/star-color.png')}}" class="animated fadeInUpBig">
                        				@elseif($holdstats[$date->format('Y-m-d')]['puton']>=9)
                        				<?php $weekstars++;?>
                        				<img src="{{URL::to_asset('images/star-color.png')}}" class="animated fadeInUpBig">
                        				@endif
                        				<div class="avg">@if($holdstats[$date->format('Y-m-d')]['puton']!=0){{$holdstats[$date->format('Y-m-d')]['puton']}}@endif</div>
                        				@else 
                        				<img src="{{URL::to_asset('images/star-grey.png')}}" >
                        				@endif
                        				
                        			</center>
                        		</div>
                        		@endfor
                        	</div>
                        	 <button class="btn btn-small btn-default showstatsbutton" data-id="puton" >SHOW MONTH</button>
                                <div class="span4">
                                        <table class="responsive table table-condensed bookertables" id="booktable-puton" style="border:1px solid #1f1f1f;margin-left:-5px;">
                                                <thead>
                                                        <th>Date</th><th>Demos Put On</th>
                                                </thead>

                                                <tbody>
                                                        @foreach($holdstats as $val)
                                                        <?php if($val['puton']>=5){$status = "success special";$star = "&nbsp;&nbsp;<img src='".URL::to_asset('images/star-mini.png')."'>";} else {$status="inverse";$star="";};?>
                                                        <tr>
                                                                <td>{{date('D M-d', strtotime($val['date']))}}</td>
                                                                <td>@if($val['puton']!=0)<span class="label label-{{$status}}">{{$val['puton']}}</span>{{$star}}@endif</td>
                                                        </tr>
                                                        @endforeach
                                                </tbody>
                                        </table>
                                </div>
                        	</div>
                        	
                        	<div class="row-fluid">
                            <?php 
         						$date = new DateTime();
								$date->modify('this week');
							?>
                        	<h3 style="margin-left:20px;">Your HOLD % for Week <span class="goals">46%</span></h3>
                              	<div class="datebox">
                          		@for($i=0;$i<=6;$i++)
                           		<?php $date->modify('this week +'.$i.' days');?>

                        		<div class="daybox">
                        			<div class="datehead">{{$date->format('D M-d')}}</div>
                        			<center>
                        				@if(isset($holdstats[$date->format('Y-m-d')]))
                        				
                        				@if($holdstats[$date->format('Y-m-d')]['hold']<46)
                        				<img src="{{URL::to_asset('images/star-grey.png')}}" >
                        				@elseif($holdstats[$date->format('Y-m-d')]['hold']>=46)
                        				<?php $weekstars++;?>
                        				<img src="{{URL::to_asset('images/star-color.png')}}" class="animated fadeInUpBig">
                        				@elseif($holdstats[$date->format('Y-m-d')]['hold']>=65)
                        				<?php $weekstars++;?>
                        				<img src="{{URL::to_asset('images/star-color.png')}}" class="animated fadeInUpBig">
                        				@endif
                        				<div class="avg">@if($holdstats[$date->format('Y-m-d')]['hold']!=0){{$holdstats[$date->format('Y-m-d')]['hold']}}%@endif</div>
                        				@else 
                        				<img src="{{URL::to_asset('images/star-grey.png')}}" >
                        				@endif
                        				
                        			</center>
                        		</div>
                        		@endfor
                        	</div>
                        		<button class="btn btn-small btn-default showstatsbutton" data-id="hold" >SHOW MONTH</button>
                                <div class="span4">
                                        <table class="responsive table table-condensed bookertables" id="booktable-hold" style="border:1px solid #1f1f1f;margin-left:-10px;">
                                                <thead>
                                                        <th>Date</th><th>HOLD Percent</th>
                                                </thead>

                                                <tbody>
                                                        @foreach($holdstats as $val)
                                                        <?php if($val['hold']>=46){$status = "success special";$star = "&nbsp;&nbsp;<img src='".URL::to_asset('images/star-mini.png')."'>";} else {$status="inverse";$star="";};?>
                                                        <tr>
                                                                <td>{{date('D M-d', strtotime($val['date']))}}</td>
                                                                <td>@if($val['hold']!=0)<span class="label label-{{$status}}">{{$val['hold']}}%</span>{{$star}}@endif</td>
                                                        </tr>
                                                        @endforeach
                                                </tbody>
                                        </table>
                                </div>

                        	</div>
                        	@endif 
                        
                    </div>
                    </section>
                        <!-- end widget grid -->
                    </div>    
                    <aside class="right">
                    @render('layouts.chat')
                    </aside>  
            </div>
                <!-- end main content -->
            </div>
                   
        </div><!--end fluid-container-->
        <div class="push"></div>
         <input id="starcount" type="hidden" value="{{$starcount}}"/>
          <input id="weekstarcount" type="hidden" value="{{$weekstars}}"/>
    </div>
    
<script src="{{URL::to_asset('js/include/guage.min.js')}}"></script>
<script>
function getguage(gval){
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
var target = document.getElementById('teamsales'); 
var gauge = new Gauge(target).setOptions(opts); 
gauge.maxValue = 100; 
gauge.animationSpeed = 32; 
gauge.set(gval); 

}

$(document).ready(function(){

var gval = $('#teamsales').data('value');
getguage(gval);
$('#dashboardmenu').addClass('expanded');

var stars = $('#starcount').val();
var wkstars = $('#weekstarcount').val();
$('.startotal').html(stars+"<br/><div style='color:#000;float:left;margin-left:18px;margin-top:8px;font-size:9px;line-height:12px;'>Month</div>");
$('.week').html(wkstars+"<br/><div style='color:#000;float:left;margin-left:18px;margin-top:8px;font-size:9px;line-height:12px;'>Week</div>")

$('.showstatsbutton').click(function(){
var id = $(this).data('id');
$('.booktables')
$('#booktable-'+id).toggle().addClass('animated fadeInUp');
});
});
</script>
@endsection