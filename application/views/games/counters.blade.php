<div class="span12" style="border-right:1px solid #ccc;padding-right:10px;">
                <?php 
            function days($month, $year){
                return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year %400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
            };
                
            $daysm=days(date('M'),date('Y')); 
            $week_ending = date('Y-m-d', strtotime( 'This Sunday'));
            $daysw=7;
            $timeweek = strtotime($week_ending) - strtotime(date('Y-m-d')); 
            $timeweek = $timeweek/86400;
            $timeleftm = date('t')-date('j');
            $onpace=0; $clearpercent=0;$grossunits=0;$netunits=0;$avgunits=0;
            
            if(isset($stmonth)&&!empty($stmonth)&&isset($stweek)&&!empty($stweek)){
                if(($stmonth['totgrossunits']!=0)&&($stmonth['grosssales'])!=0){ 
                $avgunits = number_format($stmonth['totgrossunits']/($stmonth['grosssales']), 2, '.', ' '); } else {$avgunits = 0;};
                if(($stmonth['totnetunits']!=0)&&($stmonth['totgrossunits']!=0)){ 
                    $clearpercent = number_format(($stmonth['totnetunits']/$stmonth['totgrossunits'])*100,0,'.','');
                } else { $clearpercent=0;};
    
                if(($stmonth['totgrossunits']!=0)&&($daysm-$timeleftm!=0)){
                    $onpace = $stmonth['totgrossunits']/($daysm-$timeleftm);
                    $onpace = number_format(($stmonth['totgrossunits'] + ($onpace*$timeleftm)),0,'.','');
                } else {
                    $onpace = $stmonth['totgrossunits']/1;
                    $onpace = number_format(($stmonth['totgrossunits'] + ($onpace*$timeleftm)),0,'.','');
                }
                if(($stmonth['totnetunits']!=0)&&($daysm-$timeleftm!=0)){
                    $onpacen = $stmonth['totnetunits']/($daysm-$timeleftm);
                    $onpacen = number_format(($stmonth['totnetunits'] + ($onpacen*$timeleftm)),0,'.','');
                } else {
                    $onpacen = $stmonth['totnetunits']/1;
                    $onpacen = number_format(($stmonth['totnetunits'] + ($onpacen*$timeleftm)),0,'.','');
                }
                $g_number = str_split($stmonth['totgrossunits']);
                if(count($g_number)==1) array_unshift($g_number,"");
                $g_number2 = str_split($stweek['totgrossunits']);
                if(count($g_number2)==1) array_unshift($g_number2,"");
                $gpace_num = str_split($onpace);
                if(count($gpace_num)==1) array_unshift($gpace_num,"");
                $n_number = str_split($stmonth['totnetunits']);
                if(count($n_number)==1) array_unshift($n_number,"");
                $n_number2 = str_split($stweek['totnetunits']);
                if(count($n_number2)==1) array_unshift($n_number2,"");
                $npace_num = str_split($onpacen);
                if(count($npace_num)==1) array_unshift($npace_num,"");
            } else {
                $n_number = str_split("000");$n_number2 = str_split("000");$npace_num = str_split("000");
                $g_number = str_split("000");$g_number2 = str_split("000");$gpace_num = str_split("000");
            }
            ?>
            <div class="bigSTATS" id="counter-GROSS" >
                    <div class="counter" style="float:left;margin-top:2px">
                        <h4>WEEK GROSS</h4>
                        <div class="num">@if(!empty($g_number2[0])){{$g_number2[0]}}@else0@endif</div>
                        <div class="num">@if(!empty($g_number2[1])){{$g_number2[1]}}@else0@endif</div>
                    </div>
                    <div class="counter" style="float:left;margin-left:24px;margin-top:2px">
                        <h4>MONTH GROSS</h4>
                        <div class="num">@if(!empty($g_number[0])){{$g_number[0]}}@else0@endif</div>
                        <div class="num">@if(!empty($g_number[1])){{$g_number[1]}}@else0@endif</div>
                    </div>
                    <div class="counter" style="float:left;margin-left:24px;margin-top:2px">
                        <h4>ON PACE MONTH</h4>
                        <div class="num">@if(!empty($gpace_num[0])){{$gpace_num[0]}}@else0@endif</div>
                        <div class="num">@if(!empty($gpace_num[1])){{$gpace_num[1]}}@else0@endif</div>
                    </div>
                </div>
                <div class="bigSTATS" id="counter-NET" style="display:none;">
                    <div class="counter" style="float:left;margin-left:24px;margin-top:2px">
                        <h4>WEEK NET</h4>
                        <div class="num">@if(!empty($n_number2[0])){{$n_number2[0]}}@else0@endif</div>
                        <div class="num">@if(!empty($n_number2[1])){{$n_number2[1]}}@else0@endif</div>
                    </div>
                    <div class="counter" style="float:left;margin-left:24px;margin-top:2px">
                        <h4>MONTH NET</h4>
                        <div class="num">@if(!empty($n_number[0])){{$n_number[0]}}@else0@endif</div>
                        <div class="num">@if(!empty($n_number[1])){{$n_number[1]}}@else0@endif</div>
                    </div>
                    <div class="counter" style="float:left;margin-left:24px;margin-top:2px">
                        <h4>ON PACE NET</h4>
                        <div class="num">@if(!empty($npace_num[0])){{$npace_num[0]}}@else0@endif</div>
                        <div class="num">@if(!empty($npace_num[1])){{$npace_num[1]}}@else0@endif</div>
                    </div>
                </div>
            </div>