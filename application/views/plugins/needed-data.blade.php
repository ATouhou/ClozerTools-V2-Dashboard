
<style>
.cityRow {display:none;}
.apptimetable td {font-weight:bolder; text-align:center;}
.apptimetable td.nocenter {text-align:left!important; font-weight:normal;}
.apptimetable th {background:#ddd;color:#000!important;font-size:14px!important;}
</style>

<button class="cityButton-area btn btn-default switchArea" data-type="area">AREA / COUNTIES</button>
<button class="cityButton-city btn btn-default switchArea" data-type="city">CITIES</button>
<a href='{{URL::to("appointment/needed")}}'>
<button class='btn btn-primary pull-right' style='margin-top:0px;'>MANAGE APPOINTMENTS NEEDED</button>
</a>
                    
                    @if(!empty($neededarea))
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
                       
                    @foreach($neededarea as $key=>$val)
                  
                        <tr>
                            <td class="span3 nocenter" >
                                <b style="font-size:17px;color:#000;">{{$val['day1']['needed']['name']}}</b><br/>
                            </td>
                        <td class="centerme" style="border-left:4px solid #1f1f1f;">
                            {{$slots[0]['title']}}<br/>

                            @if(isset($val['day1']['onboard'])) 
                            
                            <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="{{$val['day1']['onboard'][0]}}|today_slot1|{{$val['day1']['needed']['id']}}">
                            @if($val['day1']['onboard'][0]!=0)
                                {{$val['day1']['needed'][0]-$val['day1']['onboard'][0]}}
                                @else {{$val['day1']['needed'][0]}}@endif 
                                @else <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="0|today_slot1|{{$val['day1']['needed']['id']}}">{{$val['day1']['needed'][0]}}@endif
                            </span>
                            </td>
                        <td class="centerme">
                            {{$slots[1]['title']}}<br/>
                           
                            @if(isset($val['day1']['onboard'])) 
                            
                            <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="{{$val['day1']['onboard'][1]}}|today_slot2|{{$val['day1']['needed']['id']}}">
                            @if($val['day1']['onboard'][1]!=0)
                                {{$val['day1']['needed'][1]-$val['day1']['onboard'][1]}}
                                @else {{$val['day1']['needed'][1]}}@endif 
                                @else <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="0|today_slot2|{{$val['day1']['needed']['id']}}">{{$val['day1']['needed'][1]}}@endif
                            </span>
                        </td>
                        <td class="centerme">
                            {{$slots[2]['title']}}<br/>
                            @if(isset($val['day1']['onboard'])) 
                            
                            <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="{{$val['day1']['onboard'][2]}}|today_slot3|{{$val['day1']['needed']['id']}}">
                            @if($val['day1']['onboard'][2]!=0)
                                {{$val['day1']['needed'][2]-$val['day1']['onboard'][2]}}
                                @else {{$val['day1']['needed'][2]}}@endif 
                                @else <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="0|today_slot3|{{$val['day1']['needed']['id']}}">{{$val['day1']['needed'][2]}}@endif
                            </span>
                        </td>
                        <td class="centerme">
                            {{$slots[3]['title']}}<br/>
                            @if(isset($val['day1']['onboard'])) 
                            
                            <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="{{$val['day1']['onboard'][3]}}|today_slot4|{{$val['day1']['needed']['id']}}">
                            @if($val['day1']['onboard'][3]!=0)
                                {{$val['day1']['needed'][3]-$val['day1']['onboard'][3]}}
                                @else {{$val['day1']['needed'][3]}}@endif 
                                @else <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="0|today_slot4|{{$val['day1']['needed']['id']}}">{{$val['day1']['needed'][3]}}@endif
                            </span>
                        </td>
                        <td class="centerme">
                            {{$slots[4]['title']}}<br/>
                            @if(isset($val['day1']['onboard'])) 
                            
                            <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="{{$val['day1']['onboard'][4]}}|today_slot5|{{$val['day1']['needed']['id']}}">
                            @if($val['day1']['onboard'][4]!=0)
                                {{$val['day1']['needed'][4]-$val['day1']['onboard'][4]}}
                                @else {{$val['day1']['needed'][4]}}@endif 
                                @else <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="0|today_slot5|{{$val['day1']['needed']['id']}}">{{$val['day1']['needed'][4]}}@endif
                            </span>
                        </td>
                        <td class="centerme" style="border-left:4px solid #1f1f1f;">
                            {{$slots[0]['title']}}<br/>
                            @if(isset($val['day2']['onboard'])) 
                            
                            <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="{{$val['day2']['onboard'][0]}}|today_slot1|{{$val['day1']['needed']['id']}}">
                            @if($val['day2']['onboard'][0]!=0)
                                {{$val['day2']['needed'][0]-$val['day2']['onboard'][0]}}
                                @else {{$val['day2']['needed'][0]}}@endif 
                                @else <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="0|tomorrow_slot1|{{$val['day1']['needed']['id']}}">{{$val['day2']['needed'][0]}}@endif
                            </span>
                            </td>
                        <td class="centerme">
                            {{$slots[1]['title']}}<br/>
                           
                            @if(isset($val['day2']['onboard'])) 
                            
                            <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="{{$val['day2']['onboard'][1]}}|tomorrow_slot2|{{$val['day1']['needed']['id']}}">
                            @if($val['day2']['onboard'][1]!=0)
                                {{$val['day2']['needed'][1]-$val['day2']['onboard'][1]}}
                                @else {{$val['day2']['needed'][1]}}@endif 
                                @else <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="0|tomorrow_slot2|{{$val['day1']['needed']['id']}}">{{$val['day2']['needed'][1]}}@endif
                            </span>
                        </td>
                        <td class="centerme">
                            {{$slots[2]['title']}}<br/>
                            @if(isset($val['day2']['onboard'])) 
                            
                            <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="{{$val['day2']['onboard'][2]}}|tomorrow_slot3|{{$val['day1']['needed']['id']}}">
                            @if($val['day2']['onboard'][2]!=0)
                                {{$val['day2']['needed'][2]-$val['day2']['onboard'][2]}}
                                @else {{$val['day2']['needed'][2]}}@endif 
                                @else <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="0|tomorrow_slot3|{{$val['day1']['needed']['id']}}">{{$val['day2']['needed'][2]}}@endif
                            </span>
                        </td>
                        <td class="centerme">
                            {{$slots[3]['title']}}<br/>
                            @if(isset($val['day2']['onboard'])) 
                            
                            <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="{{$val['day2']['onboard'][3]}}|tomorrow_slot4|{{$val['day1']['needed']['id']}}">
                            @if($val['day2']['onboard'][3]!=0)
                                {{$val['day2']['needed'][3]-$val['day2']['onboard'][3]}}
                                @else {{$val['day2']['needed'][3]}}@endif 
                                @else <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="0|tomorrow_slot4|{{$val['day1']['needed']['id']}}">{{$val['day2']['needed'][3]}}@endif
                            </span>
                        </td>
                        <td class="centerme">
                            {{$slots[4]['title']}}<br/>
                            @if(isset($val['day2']['onboard'])) 
                            
                            <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="{{$val['day2']['onboard'][4]}}|tomorrow_slot5|{{$val['day1']['needed']['id']}}">
                            @if($val['day2']['onboard'][4]!=0)
                                {{$val['day2']['needed'][4]-$val['day2']['onboard'][4]}}
                                @else {{$val['day2']['needed'][4]}}@endif 
                                @else <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="0|tomorrow_slot5|{{$val['day1']['needed']['id']}}">{{$val['day2']['needed'][4]}}@endif
                            </span>
                        </td>
                        <td class="centerme" style="border-left:4px solid #1f1f1f;">
                            {{$slots[0]['title']}}<br/>
                            @if(isset($val['day3']['onboard'])) 
                            
                            <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="{{$val['day3']['onboard'][0]}}|twoday_slot1|{{$val['day1']['needed']['id']}}">
                            @if($val['day3']['onboard'][0]!=0)
                                {{$val['day3']['needed'][0]-$val['day3']['onboard'][0]}}
                                @else {{$val['day3']['needed'][0]}}@endif 
                                @else <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="0|twoday_slot1|{{$val['day1']['needed']['id']}}">{{$val['day3']['needed'][0]}}@endif
                            </span>
                        </td>
                        <td class="centerme">
                            {{$slots[1]['title']}}<br/>
                           
                            @if(isset($val['day3']['onboard'])) 
                            
                            <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="{{$val['day3']['onboard'][1]}}|twoday_slot2|{{$val['day1']['needed']['id']}}">
                            @if($val['day3']['onboard'][1]!=0)
                                {{$val['day3']['needed'][1]-$val['day3']['onboard'][1]}}
                                @else {{$val['day3']['needed'][1]}}@endif 
                                @else <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="0|twoday_slot2|{{$val['day1']['needed']['id']}}">{{$val['day3']['needed'][1]}}@endif
                            </span>
                        </td>
                        <td class="centerme">
                            {{$slots[2]['title']}}<br/>
                            @if(isset($val['day3']['onboard'])) 
                            
                            <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="{{$val['day3']['onboard'][2]}}|twoday_slot3|{{$val['day1']['needed']['id']}}">
                            @if($val['day3']['onboard'][2]!=0)
                                {{$val['day3']['needed'][2]-$val['day3']['onboard'][2]}}
                                @else {{$val['day3']['needed'][2]}}@endif 
                                @else <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="0|twoday_slot3|{{$val['day1']['needed']['id']}}">{{$val['day3']['needed'][2]}}@endif
                            </span>
                        </td>
                        <td class="centerme">
                            {{$slots[3]['title']}}<br/>
                            @if(isset($val['day3']['onboard'])) 
                            
                            <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="{{$val['day3']['onboard'][3]}}|twoday_slot4|{{$val['day1']['needed']['id']}}">
                            @if($val['day3']['onboard'][3]!=0)
                                {{$val['day3']['needed'][3]-$val['day3']['onboard'][3]}}
                                @else {{$val['day3']['needed'][3]}}@endif 
                                @else <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="0|twoday_slot4|{{$val['day1']['needed']['id']}}">{{$val['day3']['needed'][3]}}@endif
                            </span>
                        </td>
                        <td class="centerme">
                            {{$slots[4]['title']}}<br/>
                            @if(isset($val['day3']['onboard'])) 
                            
                            <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="{{$val['day3']['onboard'][4]}}|twoday_slot5|{{$val['day1']['needed']['id']}}">
                                @if($val['day3']['onboard'][4]!=0)
                                    {{$val['day3']['needed'][4]-$val['day3']['onboard'][4]}}
                                @else {{$val['day3']['needed'][4]}}
                                @endif 
                            @else <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="0|twoday_slot5|{{$val['day1']['needed']['id']}}">{{$val['day3']['needed'][4]}}@endif
                            </span>
                        </td>
                        </tr>
                        @endforeach
                        </tbody>
                        </table>
                        @endif


                    @if(!empty($needed))
                    <table class="table table-condensed neededTable city table-bordered apptimetable" style="margin-top:5px;padding:15px;">
                    <thead>
                        <tr align="center">
                            <th style="width:17%;font-weight:bolder;">CITY NAME</th>                  
                            <th colspan=5 style="border-left:4px solid #1f1f1f;"><center>{{date('l - M d')}}</center></th>
                            <th colspan=5 style="border-left:4px solid #1f1f1f;"><center>{{date('l - M d',strtotime('+1 Day'))}}</center></th>
                            <th colspan=5 style="border-left:4px solid #1f1f1f;"><center>{{date('l - M d',strtotime('+2 Day'))}}</center></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($needed as $key=>$val)
                       

                        <tr>
                        <td class="span3 nocenter" ><b style="font-size:17px;color:#000;">{{$val['day1']['needed']['name']}}</b><br/>
                            @foreach($cities as $val2)
                            @if($val2->cityname==$val['day1']['needed']['name'])
                            
                                <span class="small" style="color:#333">RIGHT AWAY | <span class="badge badge-info special" style="cursor:pointer;" id="rightaway|{{$val2->id}}" >{{$val2->rightaway}}</span></span>
                            @endif
                            @endforeach
                        </td>
                        <td class="centerme" style="border-left:4px solid #1f1f1f;">
                            {{$slots[0]['title']}}<br/>
                            @if(isset($val['day1']['onboard'])) 
                            
                            <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="{{$val['day1']['onboard'][0]}}|today_slot1|{{$val['day1']['needed']['id']}}">
                            @if($val['day1']['onboard'][0]!=0)
                                {{$val['day1']['needed'][0]-$val['day1']['onboard'][0]}}
                                @else {{$val['day1']['needed'][0]}}@endif 
                                @else <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="0|today_slot1|{{$val['day1']['needed']['id']}}">{{$val['day1']['needed'][0]}}@endif
                            </span>
                            </td>
                        <td class="centerme">
                            {{$slots[1]['title']}}<br/>
                           
                            @if(isset($val['day1']['onboard'])) 
                            
                            <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="{{$val['day1']['onboard'][1]}}|today_slot2|{{$val['day1']['needed']['id']}}">
                            @if($val['day1']['onboard'][1]!=0)
                                {{$val['day1']['needed'][1]-$val['day1']['onboard'][1]}}
                                @else {{$val['day1']['needed'][1]}}@endif 
                                @else <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="0|today_slot2|{{$val['day1']['needed']['id']}}">{{$val['day1']['needed'][1]}}@endif
                            </span>
                        </td>
                        <td class="centerme">
                            {{$slots[2]['title']}}<br/>
                            @if(isset($val['day1']['onboard'])) 
                            
                            <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="{{$val['day1']['onboard'][2]}}|today_slot3|{{$val['day1']['needed']['id']}}">
                            @if($val['day1']['onboard'][2]!=0)
                                {{$val['day1']['needed'][2]-$val['day1']['onboard'][2]}}
                                @else {{$val['day1']['needed'][2]}}@endif 
                                @else <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="0|today_slot3|{{$val['day1']['needed']['id']}}">{{$val['day1']['needed'][2]}}@endif
                            </span>
                        </td>
                        <td class="centerme">
                            {{$slots[3]['title']}}<br/>
                            @if(isset($val['day1']['onboard'])) 
                            
                            <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="{{$val['day1']['onboard'][3]}}|today_slot4|{{$val['day1']['needed']['id']}}">
                            @if($val['day1']['onboard'][3]!=0)
                                {{$val['day1']['needed'][3]-$val['day1']['onboard'][3]}}
                                @else {{$val['day1']['needed'][3]}}@endif 
                                @else <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="0|today_slot4|{{$val['day1']['needed']['id']}}">{{$val['day1']['needed'][3]}}@endif
                            </span>
                        </td>
                        <td class="centerme">
                            {{$slots[4]['title']}}<br/>
                            @if(isset($val['day1']['onboard'])) 
                            
                            <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="{{$val['day1']['onboard'][4]}}|today_slot5|{{$val['day1']['needed']['id']}}">
                            @if($val['day1']['onboard'][4]!=0)
                                {{$val['day1']['needed'][4]-$val['day1']['onboard'][4]}}
                                @else {{$val['day1']['needed'][4]}}@endif 
                                @else <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="0|today_slot5|{{$val['day1']['needed']['id']}}">{{$val['day1']['needed'][4]}}@endif
                            </span>
                        </td>
                        <td class="centerme" style="border-left:4px solid #1f1f1f;">
                            {{$slots[0]['title']}}<br/>
                            @if(isset($val['day2']['onboard'])) 
                            
                            <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="{{$val['day2']['onboard'][0]}}|tomorrow_slot1|{{$val['day1']['needed']['id']}}">
                            @if($val['day2']['onboard'][0]!=0)
                                {{$val['day2']['needed'][0]-$val['day2']['onboard'][0]}}
                                @else {{$val['day2']['needed'][0]}}@endif 
                                @else <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="0|tomorrow_slot1|{{$val['day1']['needed']['id']}}">{{$val['day2']['needed'][0]}}@endif
                            </span>
                            </td>
                        <td class="centerme">
                            {{$slots[1]['title']}}<br/>
                           
                            @if(isset($val['day2']['onboard'])) 
                            
                            <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="{{$val['day2']['onboard'][1]}}|tomorrow_slot2|{{$val['day1']['needed']['id']}}">
                            @if($val['day2']['onboard'][1]!=0)
                                {{$val['day2']['needed'][1]-$val['day2']['onboard'][1]}}
                                @else {{$val['day2']['needed'][1]}}@endif 
                                @else <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="0|tomorrow_slot2|{{$val['day1']['needed']['id']}}">{{$val['day2']['needed'][1]}}@endif
                            </span>
                        </td>
                        <td class="centerme">
                            {{$slots[2]['title']}}<br/>
                            @if(isset($val['day2']['onboard'])) 
                            
                            <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="{{$val['day2']['onboard'][2]}}|tomorrow_slot3|{{$val['day1']['needed']['id']}}">
                            @if($val['day2']['onboard'][2]!=0)
                                {{$val['day2']['needed'][2]-$val['day2']['onboard'][2]}}
                                @else {{$val['day2']['needed'][2]}}@endif 
                                @else <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="0|tomorrow_slot3|{{$val['day1']['needed']['id']}}">{{$val['day2']['needed'][2]}}@endif
                            </span>
                        </td>
                        <td class="centerme">
                            {{$slots[3]['title']}}<br/>
                            @if(isset($val['day2']['onboard'])) 
                            
                            <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="{{$val['day2']['onboard'][3]}}|tomorrow_slot4|{{$val['day1']['needed']['id']}}">
                            @if($val['day2']['onboard'][3]!=0)
                                {{$val['day2']['needed'][3]-$val['day2']['onboard'][3]}}
                                @else {{$val['day2']['needed'][3]}}@endif 
                                @else <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="0|tomorrow_slot4|{{$val['day1']['needed']['id']}}">{{$val['day2']['needed'][3]}}@endif
                            </span>
                        </td>
                        <td class="centerme">
                            {{$slots[4]['title']}}<br/>
                            @if(isset($val['day2']['onboard'])) 
                            
                            <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="{{$val['day2']['onboard'][4]}}|tomorrow_slot5|{{$val['day1']['needed']['id']}}">
                            @if($val['day2']['onboard'][4]!=0)
                                {{$val['day2']['needed'][4]-$val['day2']['onboard'][4]}}
                                @else {{$val['day2']['needed'][4]}}@endif 
                                @else <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="0|tomorrow_slot5|{{$val['day1']['needed']['id']}}">{{$val['day2']['needed'][4]}}@endif
                            </span>
                        </td>
                        <td class="centerme" style="border-left:4px solid #1f1f1f;">
                            {{$slots[0]['title']}}<br/>
                            @if(isset($val['day3']['onboard'])) 
                            
                            <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="{{$val['day3']['onboard'][0]}}|twoday_slot1|{{$val['day1']['needed']['id']}}">
                            @if($val['day3']['onboard'][0]!=0)
                                {{$val['day3']['needed'][0]-$val['day3']['onboard'][0]}}
                                @else {{$val['day3']['needed'][0]}}@endif 
                                @else <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="0|twoday_slot1|{{$val['day1']['needed']['id']}}">{{$val['day3']['needed'][0]}}@endif
                            </span>
                        </td>
                        <td class="centerme">
                            {{$slots[1]['title']}}<br/>
                           
                            @if(isset($val['day3']['onboard'])) 
                            
                            <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="{{$val['day3']['onboard'][1]}}|twoday_slot2|{{$val['day1']['needed']['id']}}">
                            @if($val['day3']['onboard'][1]!=0)
                                {{$val['day3']['needed'][1]-$val['day3']['onboard'][1]}}
                                @else {{$val['day3']['needed'][1]}}@endif 
                                @else <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="0|twoday_slot2|{{$val['day1']['needed']['id']}}">{{$val['day3']['needed'][1]}}@endif
                            </span>
                        </td>
                        <td class="centerme">
                            {{$slots[2]['title']}}<br/>
                            @if(isset($val['day3']['onboard'])) 
                            
                            <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="{{$val['day3']['onboard'][2]}}|twoday_slot3|{{$val['day1']['needed']['id']}}">
                            @if($val['day3']['onboard'][2]!=0)
                                {{$val['day3']['needed'][2]-$val['day3']['onboard'][2]}}
                                @else {{$val['day3']['needed'][2]}}@endif 
                                @else <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="0|twoday_slot3|{{$val['day1']['needed']['id']}}">{{$val['day3']['needed'][2]}}@endif
                            </span>
                        </td>
                        <td class="centerme">
                            {{$slots[3]['title']}}<br/>
                            @if(isset($val['day3']['onboard'])) 
                            
                            <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="{{$val['day3']['onboard'][3]}}|twoday_slot4|{{$val['day1']['needed']['id']}}">
                            @if($val['day3']['onboard'][3]!=0)
                                {{$val['day3']['needed'][3]-$val['day3']['onboard'][3]}}
                                @else {{$val['day3']['needed'][3]}}@endif 
                                @else <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="0|twoday_slot4|{{$val['day1']['needed']['id']}}">{{$val['day3']['needed'][3]}}@endif
                            </span>
                        </td>
                        <td class="centerme">
                            {{$slots[4]['title']}}<br/>
                            @if(isset($val['day3']['onboard'])) 
                            
                            <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="{{$val['day3']['onboard'][4]}}|twoday_slot5|{{$val['day1']['needed']['id']}}">
                                @if($val['day3']['onboard'][4]!=0)
                                    {{$val['day3']['needed'][4]-$val['day3']['onboard'][4]}}
                                @else {{$val['day3']['needed'][4]}}
                                @endif 
                            @else <span class='needed badge edit-needed tooltwo special totalStat ' title='CLICK TO EDIT NEEDED SLOT COUNT' id="0|twoday_slot5|{{$val['day1']['needed']['id']}}">{{$val['day3']['needed'][4]}}@endif
                            </span>
                        </td>
                        </tr>
                        @endforeach
                        </tbody>
                        </table>
                        @endif
      
 
            <script>
            $(document).ready(function(){
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

                $('.edit-needed').editable('{{URL::to("cities/timeslot")}}',{
                        indicator : 'Saving...',
                        submit  : 'OK',
                        placeholder: '.',
                        width:'30',
                        height:'20',
                });

                $('.tooltwo').tooltipster();

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
            });
            </script>