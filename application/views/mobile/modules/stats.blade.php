<div style='background:url("../images/subtle_clouds.jpg"); background-size:150%;width:110%;margin-left:-20px;margin-bottom:10px;border-bottom:1px solid #1f1f1f;'>
<center>
  <br/>
  <h3>YOU ARE LEVEL <strong style="color:green;">{{Auth::user()->level}}</strong>&nbsp;&nbsp;SPECIALIST</h3>
  <div class="button viewCommission" style='border:1px solid #bbb; padding:5px;font-size:10px;'>
                    VIEW COMMISSION LEVELS
                  </div>
                  <div class='commission' style='display:none;'>
                    <table class='table table-condensed'>
                      <tr><th>System</th><th>Payout</th></tr>
                      <?php $pureop = DB::query("SELECT * FROM pureop WHERE id = '".Auth::user()->level."'");
                        if(empty($pureop)){
                          $pureop = DB::query("SELECT * FROM pureop WHERE id = '1'");
                        };?>
                      <tr>
                        <td>Defender</td>
                        <td>${{$pureop[0]->defendercom}}</td>
                      </tr>
                      <tr>
                        <td>Majestic</td>
                        <td>${{$pureop[0]->majesticcom}}</td>
                      </tr>
                      <tr>
                        <td>System</td>
                        <td>${{$pureop[0]->systemcom}}</td>
                      </tr>
                      <tr>
                        <td>Super System</td>
                        <td>${{$pureop[0]->supercom}}</td>
                      </tr>
                    </table>
                  </div>
                  <br/>
                    <img class="animated fadeInUp" src="{{URL::to_asset('images/')}}level{{Auth::user()->level}}.png" style="width:12%">
                    <br/>
                  @if(!empty($month))
                    @foreach($month as $m)
                      @if(isset($m["name"]))
                        @if($m["name"]!="totals")
                          <?php $u=User::find($m["rep_id"]);?>
                          @if($u->id==Auth::user()->id)
                                @if(isset($year[$u->id])) 
                                    @if($year[$u->id]["totgrossunits"]!=0)<b>UNITS </b>(YEAR) : <b>{{$year[$u->id]["totgrossunits"]}}</b><br/> @endif
                                @else 
                                    <b>0</b><br/>
                                @endif
                               <b>UNITS </b>(MONTH) : @if($m["totgrossunits"]!=0) <b>{{$m["totgrossunits"]}}</b> @endif<br/>
                               <b>UNITS </b>(WEEK) :
                               @if(isset($week[$u->id])) 
                                @if($week[$u->id]["totgrossunits"]!=0) <b> {{$week[$u->id]["totgrossunits"]}}</b> @endif
                               @else 
                               <b>0</b>
                               @endif
                               <br/><br/>
                               <h2>THIS MONTH</h2>
                                <div>
                                  <img class='animated fadeInUp' src='{{URL::to_asset("images/pureop-maj.png")}}' style='width:45px;'>
                                  <img class='animated fadeInUp' src='{{URL::to_asset("images/pureop-def.png")}}' style='width:45px;'><br/>
                                </div>
                                <div style='margin-top:5px;'>
                                  <span class='statBox'>  @if($m["grossmd"]["majestic"]!=0) {{$m["grossmd"]["majestic"]}} @endif </span>
                                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                  <span class='statBox'>   @if($m["grossmd"]["defender"]!=0) {{$m["grossmd"]["defender"]}} @endif </span>
                                </div>
                               <br/>
                               <b>
                                &nbsp;&nbsp;&nbsp;<span style='color:green;'>SOLD : @if($m["grosssales"]!=0) {{$m["grosssales"]}} @endif </span>
                                &nbsp;&nbsp;&nbsp;
                                <span style='color:red;'>DNS : @if($m["appointment"]["DNS"]!=0) {{$m["appointment"]["DNS"]}} @endif </span> 
                                &nbsp;&nbsp;&nbsp;
                                <span class='color:#FF9900;'> INC : @if($m["appointment"]["INC"]!=0) {{$m["appointment"]["INC"]}} @endif </span>
                                </b>
                          @endif
                        @endif
                      @endif
                    @endforeach
                  @endif

                  <br/>
                  
                  <a href="#sales" class="button viewSales" style='border:1px solid #bbb'>
                        VIEW YOUR SALES
                    </a>
                </center>
                <br/>
                </div>
                <h4>Team Performance This Month</h4><br/>
                <?php $disp=0;$mega=0; $userdef=0;$nova=0;$twomaj=0; $threemaj=0; $twodef=0; $threedef=0; $super=0;$sys=0; $maj=0;$def=0;$dns=0;$inc=0;$cxl=0;$rb=0;$rbof=0;$rbtf=0;$close=0;$complete=0;$sales=0;$total=0;$totnits=0;$totsales=0;?>
                                
                   <ul class='list'>
                  @if(!empty($month))
                    @foreach($month as $m)
                      @if(isset($m["name"]))
                        @if($m["name"]!="totals")
                          <?php $u=User::find($m["rep_id"]);?>
                          @if($u)
                          <li class="" style='border-bottom:1px solid #1f1f1f;padding:12px;'>
                            <div style="float:left;width:16%;">
                             <img src="{{$u->avatar_link()}}" data-id="{{$u->id}}" style='width:38px;margin-right:25px;'>
                            </div>
                            <div style="width:80%;">
                               <b>{{$m["name"]}}</b><br/>
                               <b>UNITS :</b> @if($m["totgrossunits"]!=0) {{$m["totgrossunits"]}} @endif<br/>
                               Majestic : @if($m["grossmd"]["majestic"]!=0) {{$m["grossmd"]["majestic"]}} @endif &nbsp;&nbsp;
                               Defender : @if($m["grossmd"]["defender"]!=0) {{$m["grossmd"]["defender"]}} @endif<br/><br/>
                               <b>
                                &nbsp;&nbsp;&nbsp;<span style='color:green;'>SOLD : @if($m["grosssales"]!=0) {{$m["grosssales"]}} @endif </span>
                                &nbsp;&nbsp;&nbsp;
                                <span style='color:red;'>DNS : @if($m["appointment"]["DNS"]!=0) {{$m["appointment"]["DNS"]}} @endif </span> 
                                &nbsp;&nbsp;&nbsp;
                                <span class='color:#FF9900;'> INC : @if($m["appointment"]["INC"]!=0) {{$m["appointment"]["INC"]}} @endif </span>
                                </b>
                            </div>
                          </li>

                          @endif
                          <?php
                                
                                    $dns=$dns+$m["appointment"]["DNS"];$cxl=$cxl+$m["appointment"]["CXL"];
                                    $inc=$inc+$m["appointment"]["INC"];$rbtf=$rbtf+$m["appointment"]["RBTF"];
                                    $rbof=$rbof+$m["appointment"]["RBOF"];
                                    ;?>
                        @endif
                      @endif
                    @endforeach
                  @endif
                 </ul>

                             
                                
                                
                                
                                
                                    
                                    

                                   
                                       
                                       
                                       
                                   
                                    

                                    
                                   
                                   
                                 
                                