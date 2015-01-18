                     @if(Auth::user()->user_type=="manager")
                     <?php
                      $assigned = User::bookerleadsbycity();
                     $cnt = 0;
                     foreach($assigned['area'] as $v){
                        $cnt = $cnt+intval($v->tot);
                     };
                     foreach($assigned['city'] as $v){
                        $cnt = $cnt+intval($v->tot);
                     };
                     ?>
                     <input type="hidden" id="allAssignedLeads" value="{{$cnt}}"/>
                     <script>

                        $(document).ready(function(){
                            var cnt = 0;
                            var areas = {{json_encode($assigned['area'])}};
                            var citys = {{json_encode($assigned['city'])}};

                            $('.assignedValue').each(function(i,val){
                                var t = $(this);
                                t.html("0");
                                if(t.html().length>0){
                                    $.each(areas,function(i,val){
                                        if(val.area_id===t.data('thecity')){
                                            t.html(parseInt(t.html())+parseInt(val.tot)).show();
                                            if(t.html()==0){
                                                t.hide();
                                            }
                                        }
                                    });
                                    $.each(citys,function(i,val){
                                        if(val.city===t.data('thecity')){
                                            t.html(parseInt(t.html())+parseInt(val.tot)).show();
                                            if(t.html()==0){
                                                t.hide();
                                            }
                                        }
                                    });
                                }
                            });
                        });

                     </script>
                               
                         <?php $stack = DB::query("SELECT COUNT(*) as cnt FROM leads WHERE
                         assign_date = DATE('".date('Y-m-d')."') AND (status='NH' OR status='ASSIGNED')");
                         $stacksize = $stack[0]->cnt;
                         ?>
                          <div class="tooltwo" title="You'll want this number to get pretty high before sorting, to ensure you go through a good amount of leads" style="float:left;width:90%;margin-top:-10px;margin-left:10px;font-size:12px;margin-bottom:30px;">
                        <h5>STACK SIZE SINCE LAST SORT</h5>
                       
                        <div class="largestats end" style="margin-left:70px;">
                            <?php if($stacksize<300){$color="lime";} else if(($stacksize>=300)&&($stacksize<600)){$color="yellow";} else {$color="red";};?>
                            <span class="bignum2 BOOK assignedLeads " style="color:{{$color}}">{{$stacksize}}</span><br/>
                        </div>
                        </div>
                         <script>
                        $(document).ready(function(){
                            $('.tooltwo').tooltipster({fixedWidth: 20});
                        });
                        </script>
                        @endif

                    <?php 
                    $bookerstats = User::bookerstats();
                    
                    $surveystats = User::surveystats();
                    $set = Setting::find(1);?>

                    @if(Auth::user()->user_type=="manager" || (Auth::user()->user_type=="agent" && Auth::user()->assign_leads==1))
                    <style>
                        .sidetable {border:1px solid #1f1f1f!important;}
                         .sidetable td {border:1px solid #1f1f1f!important;padding:8px!important;}
                         .sidetable th {border:1px solid #1f1f1f!important;}

                    </style>
                    @endif
                    @if(Auth::user()->user_type=="manager")
                    <?php $cl = "well";?>
                    @else
                    <?php $cl = "";?>
                    @endif

                    @if(!empty($bookerstats))
                    <style>
                    .switchStats {margin-top:8px;margin-left:3px;}
                    .bookstatTable {color:#000!important;display:none;}

                    </style>
                        <div class="{{$cl}}" style="width:115%;color:#000!important;float:left;margin-top:15px;margin-left:-10px;font-size:12px;margin-bottom:20px;">
                        
                        <center><h5 style='color:#000;'>TODAYS TOTALS</h5>
                        <table class="table-condensed sidetable " style="color:#000!important;width:99%;margin-left:-11px;" >
                            <thead style="color:#000!important">
                                <th>Booker</th>
                                <th>APP</th>
                                <th>NI</th>
                                <th>NH</th>
                                <th>TOTAL</th>
                            </thead>
                 
                            @if(isset($bookerstats['totals']) && (!empty($bookerstats['totals'])))
                                <tbody class=" animated fadeInUp">
                                @foreach($bookerstats['totals'] as $val)
                                <tr>
                                    <td>{{$val['caller_id']}}</td>
                                    <td><center><span class='label label-success special' style="color:#000;">{{$val['app']}}</span></center></td>
                                    <td><center><span class='label label-important special' style="color:#fff;">{{$val['ni']}}</span></center></td>
                                    <td><center><span class='nothomes label label-info special' style="color:#fff;">{{$val['nh']}}</span></center></td>
                                    <td><center><span class='contacts label label-warning special' style="color:#000;">{{$val['tot']}}</span></td>
                                </tr>
                                @endforeach
                                </tbody>
                            @else
                            <tbody class=" animated fadeInUp" >
                                <tr><td colspan=5>NO DATA TO SHOW</td></tr>
                            </tbody>
                            @endif
                        </table>

                        <br/><br/>

                        <p>Filter By Leadtype</p>
                        <select name="filterBookingLeadtype" id="filterBookingLeadtype" style="width:90%;">
                            @if($set->lead_paper==1)
                            <option value='paper'>PAPER LEADS</option>
                            @endif
                            @if($set->lead_secondtier==1)
                            <option value='secondtier'>SECOND TIER SURVEYS</option>
                            @endif
                            @if($set->lead_door==1)
                            <option value='door'>DOOR REGGIES</option>
                            @endif
                             @if($set->lead_homeshow==1)
                            <option value='homeshow'>HOMESHOW</option>
                            @endif
                             @if($set->lead_finalnotice==1)
                            <option value='finalnotice'>FINAL NOTICE</option>
                            @endif
                            @if($set->lead_scratch==1)
                            <option value='other'>SCRATCH</option>
                            @endif
                            @if($set->lead_referral==1)
                            <option value='referral'>REFERRAL</option>
                            @endif
                        </select>
                        <script>
                        $(document).ready(function(){
                            $('.bookstatTable').hide();
                            if(localStorage.getItem("filterType")){
                                $('#filterBookingLeadtype').val(localStorage.getItem("filterType"));
                                filterBookStats();
                            }

                            $('#filterBookingLeadtype').change(function(){
                                var type = $(this).val();
                                var val = $(this).val();
                               $('.replaceHEADER').html(type.toUpperCase());
                                localStorage.setItem("filterType",type);
                                filterBookStats();
                            });

                            function filterBookStats(){
                                if(localStorage.getItem("filterType")){
                                    $('.bookstatTable').hide();
                                    $('.replaceHEADER').html(localStorage.getItem("filterType").toUpperCase());
                                    $('#stats-'+localStorage.getItem("filterType")).show();
                                } else {
                                    $('.bookstatTable').hide();
                                    $('#stats-'+type).show();
                                }
                            }
                        }); 
                        </script>
                        
                        <center><h5 style='color:#000;'>TODAYS <span class='replaceHEADER'></span> STATS</h5>
                        <table class="table-condensed sidetable " style="color:#000!important;width:99%;margin-left:-11px;" >
                            <thead style="color:#000!important">
                                <th>Booker</th>
                                <th>APP</th>
                                <th>NI</th>
                                <th>NH</th>
                                <th>TOTAL</th>
                            </thead>

                            @if(isset($bookerstats['paper']) && (!empty($bookerstats['paper'])))
                                <tbody class="bookstatTable animated fadeInUp" id="stats-paper">
                                @foreach($bookerstats['paper'] as $val)
                                <tr>
                                    <td>{{$val->caller_id}}</td>
                                    <td><center><span class='label label-success special' style="color:#000;">{{$val->app}}</span></center></td>
                                    <td><center><span class='label label-important special' style="color:#fff;">{{$val->ni}}</span></center></td>
                                    <td><center><span class='nothomes label label-info special' style="color:#fff;">{{$val->nh}}</span></center></td>
                                    <td><center><span class='contacts label label-warning special' style="color:#000;">{{$val->tot}}</span></td>
                                </tr>
                                @endforeach
                                </tbody>
                            @else
                            <tbody class="bookstatTable animated fadeInUp" id="stats-paper">
                                <tr><td colspan=5>NO DATA TO SHOW</td></tr>
                            </tbody>
                            @endif
                            @if(isset($bookerstats['homeshow']) && (!empty($bookerstats['homeshow'])))
                                <tbody class="bookstatTable animated fadeInUp" id="stats-homeshow">
                                @foreach($bookerstats['homeshow'] as $val)
                                <tr>
                                    <td>{{$val->caller_id}}</td>
                                    <td><center><span class='label label-success special' style="color:#000;">{{$val->app}}</span></center></td>
                                    <td><center><span class='label label-important special' style="color:#fff;">{{$val->ni}}</span></center></td>
                                    <td><center><span class='nothomes label label-info special' style="color:#fff;">{{$val->nh}}</span></center></td>
                                    <td><center><span class='contacts label label-warning special' style="color:#000;">{{$val->tot}}</span></td>
                                </tr>
                                @endforeach
                                </tbody>
                            @else
                            <tbody class="bookstatTable animated fadeInUp" id="stats-homeshow">
                                <tr><td colspan=5>NO DATA TO SHOW</td></tr>
                            </tbody>
                            @endif
                            @if(isset($bookerstats['finalnotice']) && (!empty($bookerstats['finalnotice'])))
                                <tbody class="bookstatTable animated fadeInUp" id="stats-finalnotice">
                                @foreach($bookerstats['finalnotice'] as $val)
                                <tr>
                                    <td>{{$val->caller_id}}</td>
                                    <td><center><span class='label label-success special' style="color:#000;">{{$val->app}}</span></center></td>
                                    <td><center><span class='label label-important special' style="color:#fff;">{{$val->ni}}</span></center></td>
                                    <td><center><span class='nothomes label label-info special' style="color:#fff;">{{$val->nh}}</span></center></td>
                                    <td><center><span class='contacts label label-warning special' style="color:#000;">{{$val->tot}}</span></td>
                                </tr>
                                @endforeach
                                </tbody>
                            @else
                            <tbody class="bookstatTable animated fadeInUp" id="stats-finalnotice">
                                <tr><td colspan=5>NO DATA TO SHOW</td></tr>
                            </tbody>
                            @endif
                            @if(isset($bookerstats['door']) && (!empty($bookerstats['door'])))
                                <tbody class="bookstatTable animated fadeInUp" id="stats-door">
                                @foreach($bookerstats['door'] as $val)
                                <tr>
                                    <td>{{$val->caller_id}}</td>
                                    <td><center><span class='label label-success special' style="color:#000;">{{$val->app}}</span></center></td>
                                    <td><center><span class='label label-important special' style="color:#fff;">{{$val->ni}}</span></center></td>
                                    <td><center><span class='nothomes label label-info special' style="color:#fff;">{{$val->nh}}</span></center></td>
                                    <td><center><span class='contacts label label-warning special' style="color:#000;">{{$val->tot}}</span></td>
                                </tr>
                                @endforeach
                                </tbody>
                            @else
                            <tbody class="bookstatTable animated fadeInUp" id="stats-door">
                                <tr><td colspan=5>NO DATA TO SHOW</td></tr>
                            </tbody>
                            @endif
                            @if(isset($bookerstats['other']) && (!empty($bookerstats['other'])))
                                <tbody class="bookstatTable animated fadeInUp" id="stats-other">
                                @foreach($bookerstats['other'] as $val)
                                <tr>
                                    <td>{{$val->caller_id}}</td>
                                    <td><center><span class='label label-success special' style="color:#000;">{{$val->app}}</span></center></td>
                                    <td><center><span class='label label-important special' style="color:#fff;">{{$val->ni}}</span></center></td>
                                    <td><center><span class='nothomes label label-info special' style="color:#fff;">{{$val->nh}}</span></center></td>
                                    <td><center><span class='contacts label label-warning special' style="color:#000;">{{$val->tot}}</span></td>
                                </tr>
                                @endforeach
                                </tbody>
                            @else
                            <tbody class="bookstatTable animated fadeInUp" id="stats-other">
                                <tr><td colspan=5>NO DATA TO SHOW</td></tr>
                            </tbody>
                            @endif
                            @if(isset($bookerstats['secondtier']) && (!empty($bookerstats['secondtier'])))
                                <tbody class="bookstatTable animated fadeInUp" id="stats-secondtier">
                                @foreach($bookerstats['secondtier'] as $val)
                                <tr>
                                    <td>{{$val->caller_id}}</td>
                                    <td><center><span class='label label-success special' style="color:#000;">{{$val->app}}</span></center></td>
                                    <td><center><span class='label label-important special' style="color:#fff;">{{$val->ni}}</span></center></td>
                                    <td><center><span class='nothomes label label-info special' style="color:#fff;">{{$val->nh}}</span></center></td>
                                    <td><center><span class='contacts label label-warning special' style="color:#000;">{{$val->tot}}</span></td>
                                </tr>
                                @endforeach
                                </tbody>
                            @else
                            <tbody class="bookstatTable animated fadeInUp" id="stats-secondtier">
                                <tr><td colspan=5>NO DATA TO SHOW</td></tr>
                            </tbody>
                            @endif
                            @if(isset($bookerstats['referral']) && (!empty($bookerstats['referral'])))
                                <tbody class="bookstatTable animated fadeInUp" id="stats-referral">
                                @foreach($bookerstats['referral'] as $val)
                                <tr>
                                    <td>{{$val->caller_id}}</td>
                                    <td><center><span class='label label-success special' style="color:#000;">{{$val->app}}</span></center></td>
                                    <td><center><span class='label label-important special' style="color:#fff;">{{$val->ni}}</span></center></td>
                                    <td><center><span class='nothomes label label-info special' style="color:#fff;">{{$val->nh}}</span></center></td>
                                    <td><center><span class='contacts label label-warning special' style="color:#000;">{{$val->tot}}</span></td>
                                </tr>
                                @endforeach
                                </tbody>
                            @else
                            <tbody class="bookstatTable animated fadeInUp" id="stats-referral">
                                <tr><td colspan=5>NO DATA TO SHOW</td></tr>
                            </tbody>
                            @endif
                        </table>
                        </center>
                        </div><br/><br/>
                        @endif
                  @if($set->lead_survey==1)
                  @if(!empty($surveystats))
                        <div style="float:left;width:90%;margin-top:15px;margin-left:-20px;font-size:12px;margin-bottom:20px;">

                        <center><h5>TODAYS SURVEYING STATS</h5>
                        <table class="table-condensed sidetable " >
                            <thead style="color:#000!important">
                                <th>Booker</th>
                                <th>COM</th>
                                <th>NID</th>
                                <th>NI</th>
                                <th>NQ</th>
                                <th>NH</th>
                                <th>TOT</th>
                            </thead>
                            <tbody class=''>
                                @foreach($surveystats as $val)
                                <tr>
                                    <td>{{$val->caller_id}}</td>
                                    <td><center><span class='label label-success special' style="color:#000;">{{$val->lead}}</span></center></td>
                                    <td><center><span class='label label-success ' style="color:#000;">{{$val->nid}}</span></center></td>
                                    <td><center><span class='label label-important special' style="color:#fff;">{{$val->ni}}</span></center></td>
                                    <td><center><span class='nothomes label label-info special' style="color:#fff;">{{$val->nq}}</span></center></td>
                                    <td><center><span class='nothomes label label-info special' style="color:#fff;">{{$val->nh}}</span></center></td>
                                    <td><center><span class='contacts label label-warning special' style="color:#000;">{{$val->tot}}</span></td>
                                </tr>
                                
                                @endforeach
                            </tbody>
                        </table>
                        </center>
                        </div><br/><br/>
                        @endif
                @endif
                       
                      
                       
                       

                        