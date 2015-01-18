               <!-- <h5 style='margin-top:20px;'>Recent Achievements</h5>
-->



                <h5>Last Activity for {{ucfirst(strtolower($user->firstname))}}</h5>
                <ul class='recentActivity'>
                    <?php $ct = 0;?>
                @foreach($user->recentActivity() as $act)
                <?php $ct++;?>
                @if($ct<=1)
                    <li class='smallShadow'>
                        <div class='listLeft'>
                            <span class='bigCount'>{{$act->points}}</span><span class='smallCount'>Pts</span>
                        </div>
                        &nbsp;&nbsp;{{str_replace($user->fullName(),"",$act->historyMessage())}} 
                        <br/>
                        <span class='smallSideNote'>
                            @if($act->lead_id!=0 && $act->appt_id!=0)
                            <?php $nm = explode(" ",$act->lead->cust_name);?>
                            &nbsp;&nbsp;&nbsp;Booked By : {{$act->appt->booked_by}} | Customer : {{ucfirst(strtolower($nm[0]))}}
                            @endif
                            <div style='float:right;margin-top:-20px;'>
                                @if($act->sale_id!=0)
                                &nbsp;<img src='{{URL::to("images/pureop-small-")}}{{$act->appt->systemsale}}.png' style='width:26px;'>
                                @endif
                                <br/>
                                <span style='color:#aaa;font-size:11px;'> {{date('M-d',strtotime($act->history_date))}}</span> 
                            </div>
                        </span>
                    </li>
                    @endif
                @endforeach
                </ul>
                <h5>Recent {{ucfirst($user->user_type)}} Activity</h5>
                <ul class='recentActivity'>
                @foreach($user->recentActivity("all") as $act)
                    <li  class='smallShadow'>
                        <div class='listLeft'>
                            <span class='bigCount'>{{$act->points}}</span><span class='smallCount'>Pts</span>
                        </div>
                        &nbsp;&nbsp;{{User::find($act->user_id)->fullName()}} {{$act->historyMessage()}} 
                        
                        <br/>
                        <span class='smallSideNote'>
                            @if($act->lead_id!=0 && $act->appt_id!=0)
                            <?php $nm = explode(" ",$act->lead->cust_name);?>
                            &nbsp;&nbsp;&nbsp;Booked By : {{$act->appt->booked_by}} | Customer : {{ucfirst(strtolower($nm[0]))}}
                            @endif
                            <div style='float:right;margin-top:-20px;'>
                                @if($act->sale_id!=0)
                                &nbsp;<img src='{{URL::to("images/pureop-small-")}}{{$act->appt->systemsale}}.png' style='width:26px;'>
                                @endif
                                <br/>
                                <span style='color:#aaa;font-size:11px;'> {{date('M-d',strtotime($act->history_date))}}</span> 
                            </div>
                        </span>
                    </li>
                @endforeach
                </ul>