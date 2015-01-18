            

            <div class="row-fluid">
                        @if(!empty($stats))
                        <div class="well span6 animated fadeInUp">
                        <h2>{{$title['app']}}</h2>   
                            <div class="largestats ">
                                <span class="bignum2 BOOK">{{$stats[0]->total}}</span><br/>
                                <h5>On Board</h5>
                            </div>
                            <div class="largestats ">
                                <span class="bignum2 PUTON">{{$stats[0]->dispatched}}</span><br/>
                                <h5>Dispatched</h5>
                            </div>
                            <div class="largestats ">
                                <span class="bignum2">{{$stats[0]->sold}}</span><br/>
                                <h5>Sales</h5>
                            </div>
                            <div class="largestats end ">
                                <span class="bignum2 DNS2">{{$stats[0]->dns}}</span><br/>
                                <h5>DNS</h5>
                            </div>
               		 	
                         @if(!empty($appts))
                         
                        <div class="span11" style="margin-top:20px;padding-top:10px;border-top:1px solid #ddd">
                        <h5>TODAYS BOARD (without Rebooks)

                            <a href="{{URL::to('appointment')}}">
                                <button class="btn btn-default btn-mini" style="float:right;">VIEW BOARD</button>
                            </a>
                        </h5>
                        <br/>
                        <input type="checkbox" class="show_lead_details" name="show_info" id="show_lead_info|1" @if(Setting::find(1)->show_lead_info==1) checked="checked" @endif > Show Lead Details<br/>
                        <table class="table table-bordered table-condensed "  style="float:left;border:1px solid #1f1f1f;"  >
                            <thead>
                                <th style="width:4%;">Time</th>
                                <th style="width:14%;">Name</th>
                                <th>Sales Rep</th>
                                @if(Setting::find(1)->show_lead_info==1)
                                    <?php $cla="";?>
                                    @else
                                    <?php $cla="hidden";?>
                                @endif
                                <th class="tooltwo lead_info {{$cla}}" title="SMOKE">S</th>
                                <th class="tooltwo lead_info {{$cla}} " title="PETS">P</th>
                                <th class="tooltwo lead_info {{$cla}}" title="ASTHMA">A</th>
                                <th class="tooltwo lead_info {{$cla}}" title="RENT / OWN">R/O</th>
                                <th class="lead_info {{$cla}}" title="Job">Job</th>
                                <th>City</th>
                                <th></th>
                            </thead>
                            <tbody class='appttable'>
                                @foreach($appts as $val)
                                <?php if($val->status=="DISP"){$label="inverse";$class="";}
                                      elseif($val->status=="CONF"){$label = "success";$class="CONF";}
                                      elseif($val->status=="SOLD"){$label="warning special black"; $class="";} 
                                      elseif($val->status=="CXL"){$label="important";$class="CXL";}
                                      elseif($val->status=="NQ"){$label="important special";$class="";}
                                      elseif($val->status=="DNS"){$label="important special";$class="";}
                                      elseif($val->status=="INC"){$label="warning";$class="";}
                                      elseif(($val->status=="RB-TF")||($val->status=="RB-OF")){$label="info special";$class="RB-TF";}
                                      elseif($val->status=="NA"){$label="warning black";$class="NA";} elseif($val->status=="BUMP") {$label="bump";$class="";} else {$label="success special"; $class="";}
                                    if($val->lead->leadtype=="door"){$type="DR";} else if($val->lead->leadtype=="paper"){$type="MA";} else if($val->lead->leadtype="other"){$type="SC";}else if($val->lead->leadtype=="rebook"){$type="RB";}
                                ?>

                                    @if(($val->status!="RB-TF")&&($val->status!="RB-OF"))
                                    <tr class="{{$val->status}}">
                                        <td><span class="small">{{date('h:i ', strtotime($val->app_time))}}</small></td>
                                        <td><span class="small">{{$val->lead->cust_name}}</span></td>
                                        <td>@if(!empty($val->rep_name))<span class='label label-{{$label}}'>{{$val->rep_name}}</span>@endif</td>
                                        <td class="lead_info {{$cla}}">{{$val->lead->smoke}}</td>
                                        <td class="lead_info {{$cla}}">{{$val->lead->pets}}</td>
                                        <td class="lead_info {{$cla}}">{{$val->lead->asthma}}</td>
                                        <td class="lead_info {{$cla}}">{{$val->lead->rentown}}</td>
                                        <td class="lead_info {{$cla}}">{{$val->lead->job}}</td>
                                        <td>
                                            <span class="small black">{{$val->lead->city}}</span>
                                        </td>
                                        <td>
                                            <span class="label label-{{$label}}">{{$val->status}}</span>
                                        </td>
                                       
                                    </tr>
                                    @endif
                               @endforeach
                            </tbody>
                        </table>
                        </div>
                        @endif
                       
                        </div>
                        @endif
                    
                        @if(!empty($callstats))
                        <?php 
                        if($callstats[0]->tot!=0){
                        	 $contact = number_format((($callstats[0]->app+$callstats[0]->ni)/$callstats[0]->tot)*100,0,'.','');
                        } else {
                        	$contact=0;
                        };?>
                      
                        <div class="well span6 animated fadeInUp">

                        <h2>{{$title['mark']}} Stats</h2>   
                        <div class="largestats " style='margin-left:7px'>
                                <span class="bignum2 PUTON smallPad" >{{$contact}} %</span><br/>
                                <h5>Contact</h5>
                            </div>
                            <div class="largestats " style='margin-left:7px'>
                                <span class="bignum2 BOOK smallPad">{{$callstats[0]->tot}}</span><br/>
                                <h5>Called</h5>
                            </div>

                            <div class="largestats " style='margin-left:7px'>
                                <span class="bignum2">{{$callstats[0]->app}}</span><br/>
                                <h5>Booked</h5>
                            </div>
                            <div class="largestats " style='margin-left:7px'>
                                <span class="bignum2 DNS2">{{$callstats[0]->ni}}</span><br/>
                                <h5>NI's</h5>
                            </div>
     
                            <div class="largestats end" style='margin-left:7px'>
                                <span class="bignum2 RECALL">{{$callstats[0]->recall}}</span><br/>
                                <h5>Recall</h5>
                            </div>
                        <?php if($date==date('Y-m-d')){;?>
                        @include('plugins.bookerleads')
                        
                        <?php } ;?>
                        
                        @if(Setting::find(1)->lead_paper==1 || Setting::find(1)->lead_secondtier==1)
                        


                        @if(!empty($bookerstats))
                        <div class="span11" style="margin-top:20px;">
                        <h5>BOOKER STATS FOR {{strtoupper(date('M-d',strtotime($date)))}}</h5>
                        <table class="table table-bordered table-condensed " style="border:1px solid #1f1f1f;" >
                            <thead style="color:#000!important">
                                <th>Booker</th>
                                @if($date==date('Y-m-d'))
                                <th>TBC</th>
                                @endif
                                <th>BPH</th>
                               
                                <th>APP</th>
                                <th>NI</th>
                                <th>NH</th>
                                <th>NQ</th>
                                <th>DNC</th>
                                <th>Wrong</th>
                                <th>Recalls</th>
                                <th>Contact</th>
                                <th>TOTAL</th>
                            </thead>
                            <tbody class=''>
                                @foreach($bookerstats as $val)

                                <?php $contact = 0;$color = "label-inverse"; 
                                if(($val->app+$val->ni+$val->nq+$val->dnc+$val->wrong)!=0){
                                    $contact = (($val->app+$val->ni)/$val->total)*100;
                                    
                                    if($contact<=10){
                                        $color = "label-important special";
                                    } else if($contact>10 && $contact<=14){
                                        $color = "label-warning blackText special";
                                    } else {
                                        $color = "label-success blackText special";
                                    }
                                }
                                ;?>
                                <tr>
                                    <td>{{$val->caller_id}}</td>
                                    @if($date==date('Y-m-d'))
                                    <td class='tooltwo' title='Time Between Calls'>{{$val->call_time}}</td>
                                    @endif
                                    <td>
                                        @if($val->bph!=0 && $val->app!=0)
                                        <span class='label label-info special'>
                                        {{number_format(intval($val->app)/floatval($val->bph),2,'.','')}}
                                        </span>
                                        @else
                                        N/A
                                        @endif
                                    </td>

                                    <td><center>{{$val->app}}</center></td>
                                    <td><center>{{$val->ni}}</center></td>
                                    <td><center>{{$val->nh}}</center></td>
                                    <td><center>{{$val->nq}}</center></td>
                                    <td><center>{{$val->dnc}}</center></td>
                                    <td><center>{{$val->wrong}}</center></td>
                                    <td><center>{{$val->recall}}</center></td>
                                    <td ><center><span class="label {{$color}}" style="font-size:15px;">{{number_format($contact,'0',',','')}} %</span></center></td>
                                    <td><center><span class='label label-info special'>{{$val->tot}}</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                        @endif

                        @if(!empty($bookerstats))
                        <div class="span11" style="margin-top:20px;">
                        <h5>AVERAGE TIME SPENT ON CALLS </h5>
                        <table class="table table-bordered table-condensed " style="border:1px solid #1f1f1f;" >
                            <thead style="color:#000!important">
                                <th>Booker</th>
                                <th>APP</th>
                                <th>NI</th>
                                <th>NH</th>
                                <th>TOTAL</th>
                            </thead>
                            <tbody class=''>
                                @foreach($bookerstats as $val)
                                <?php $averages = User::getAverageTimes($val->theid, $date,"regular");?>

                                <tr>
                                    <td>{{$val->caller_id}}</td>
                                    <td><center><span class='label label-success special blackText'>{{$averages['app']}}</span></center></td>
                                    <td><center><span class='label label-important'>{{$averages['ni']}}</span></center></td>
                                    <td><center><span class='label label-info'>{{$averages['nh']}}</span></center></td>
                                    <td><center><span class='label label-warning special blackText'>{{$averages['all']}}</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                        @endif
                        @endif
                        <div style="width:100%;float:left;height:40px;"></div>
                        @if(Setting::find(1)->lead_survey==1)
                        
                        @if(!empty($surveycallstats))
                        <?php 
                        if($surveycallstats[0]->tot!=0){
                             $contact = number_format((($surveycallstats[0]->complete+$surveycallstats[0]->ni)/$surveycallstats[0]->tot)*100,0,'.','');
                        } else {
                            $contact=0;
                        };?>
                        <br/><br/>
                        <h2 style="margin-top:20px;">Survey Call Stats</h2>   
                        <div class="largestats " style='margin-left:7px'>
                                <span class="bignum2 PUTON smallPad" >{{$contact}} %</span><br/>
                                <h5>Contact</h5>
                            </div>
                            <div class="largestats " style='margin-left:7px'>
                                <span class="bignum2 BOOK smallPad">{{$surveycallstats[0]->tot}}</span><br/>
                                <h5>Called</h5>
                            </div>

                            <div class="largestats " style='margin-left:7px'>
                                <span class="bignum2">{{$surveycallstats[0]->complete}}</span><br/>
                                <h5>COMPLETE</h5>
                            </div>
                            <div class="largestats " style='margin-left:7px'>
                                <span class="bignum2 DNS2">{{$surveycallstats[0]->ni}}</span><br/>
                                <h5>NI's</h5>
                            </div>
     
                            <div class="largestats end" style='margin-left:7px'>
                                <span class="bignum2 RECALL">{{$surveycallstats[0]->wrong}}</span><br/>
                                <h5>Wrong</h5>
                            </div>
                        @endif

                        @if(!empty($surveystats))
                        <div class="span11" >
                        <h5>SURVEY STATS FOR {{strtoupper(date('M-d',strtotime($date)))}}</h5>
                        <table class="table table-bordered table-condensed " style="border:1px solid #1f1f1f;" >
                            <thead style="color:#000!important">
                                <th>Booker</th>
                                @if($date==date('Y-m-d'))
                                <th>Time between last</th>
                                @endif
                                <th>DONE</th>
                                <th>NI</th>
                                <th>NH</th>
                                <th>DNC</th>
                                <th>TOTAL</th>
                            </thead>
                            <tbody class=''>
                                @foreach($surveystats as $val)
                                <tr>
                                    <td>{{$val->caller_id}}</td>
                                    @if($date==date('Y-m-d'))
                                    <td>{{$val->call_time}}</td>
                                    @endif
                                    <td><center>{{$val->complete}}</center></td>
                                    <td><center>{{$val->ni}}</center></td>
                                    <td><center>{{$val->nh}}</center></td>
                                    <td><center>{{$val->dnc}}</center></td>
                                    <td><center><span class='label label-info special'>{{$val->tot}}</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                        @endif



                        @if(!empty($surveystats))
                        <div class="span11" style="margin-top:20px;">
                        <h5>AVERAGE TIME SPENT SURVEYING</h5>
                        <table class="table table-bordered table-condensed " style="border:1px solid #1f1f1f;" >
                            <thead style="color:#000!important">
                                <th>Booker</th>
                                <th>DONE</th>
                                <th>NI</th>
                                <th>NH</th>
                                <th>TOTAL</th>
                            </thead>
                            <tbody class=''>
                                @foreach($surveystats as $val)
                                <?php $averages = User::getAverageTimes($val->theid, $date,"survey");?>
                                <tr>
                                    <td>{{$val->caller_id}}</td>
                                    <td><center><span class='label label-success special blackText'>{{$averages['surv']}}</span></center></td>
                                    <td><center><span class='label label-important'>{{$averages['ni']}}</span></center></td>
                                    <td><center><span class='label label-info'>{{$averages['nh']}}</span></center></td>
                                    <td><center><span class='label label-warning special blackText'>{{$averages['all']}}</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                        @endif
                        @endif

                        </div>
                        @endif
                    </div>

                    
                    



                    
