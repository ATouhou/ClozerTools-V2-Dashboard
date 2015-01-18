 @if(Setting::find(1)->office_access==1 || $viewMyself==true)

 <?php 
 $set = Setting::find(1);
 $title = explode("-",$set->title);
if($viewMyself==true){
    $showlead = "revealDetails";
} else {
    $showlead="";
}
    function days($month, $year)
    {
        return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year %400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
    };
    $daysm=days(date('M'),date('Y')); 
    $week_ending = date('Y-m-d', strtotime( 'This Sunday'));
    $daysw=7;
    $timeweek = strtotime($week_ending) - strtotime(date('Y-m-d')); 
    $timeweek = $timeweek/86400;
    $timeleftm = date('t')-date('j');
    $onpace=0; $clearpercent=0;$grossunits=0;$netunits=0;$avgunits=0;
    if(($monthSales['totals']['totgrossunits']!=0)&&(count($sales)!=0)){ 
        $avgunits = number_format($monthSales['totals']['totgrossunits']/count($sales), 2, '.', ' '); } else {$avgunits = 0;};
    if(($monthSales['totals']['totnetunits']!=0)&&($monthSales['totals']['totgrossunits']!=0)){ 
        $clearpercent = number_format(($monthSales['totals']['totnetunits']/$monthSales['totals']['totgrossunits'])*100,0,'.','');
    } else { $clearpercent=0;};

    if(($monthSales['totals']['totgrossunits']!=0)&&($daysm-$timeleftm!=0)){
        $onpace = $monthSales['totals']['totgrossunits']/($daysm-$timeleftm);
        $onpace = number_format(($monthSales['totals']['totgrossunits'] + ($onpace*$timeleftm)),0,'.','');
    } else {
        $onpace = $monthSales['totals']['totgrossunits']/1;
        $onpace = number_format(($monthSales['totals']['totgrossunits'] + ($onpace*$timeleftm)),0,'.','');
    }
    if(($monthSales['totals']['totnetunits']!=0)&&($daysm-$timeleftm!=0)){
        $onpacen = $monthSales['totals']['totnetunits']/($daysm-$timeleftm);
        $onpacen = number_format(($monthSales['totals']['totnetunits'] + ($onpacen*$timeleftm)),0,'.','');
    } else {
        $onpacen = $monthSales['totals']['totnetunits']/1;
        $onpacen = number_format(($monthSales['totals']['totnetunits'] + ($onpacen*$timeleftm)),0,'.','');
    }
     $g_number = str_split($monthSales['totals']['totgrossunits']);
    if(count($g_number)==2) array_unshift($g_number,"");
    if(count($g_number)==1) array_unshift($g_number,"","");?>
    <?php $g_number2 = str_split($weekSales['totals']['totgrossunits']);
    if(count($g_number2)==2) array_unshift($g_number2,"");
    if(count($g_number2)==1) array_unshift($g_number2,"","");?>
    <?php $gpace_num = str_split($onpace);
    if(count($gpace_num)==2) array_unshift($gpace_num,"");
    if(count($gpace_num)==1) array_unshift($gpace_num,"","");
     $n_number = str_split($monthSales['totals']['totnetunits']);
    if(count($n_number)==2) array_unshift($n_number,"");
    if(count($n_number)==1) array_unshift($n_number,"","");?>
    <?php $n_number2 = str_split($weekSales['totals']['totnetunits']);
    if(count($n_number2)==2) array_unshift($n_number2,"");
    if(count($n_number2)==1) array_unshift($n_number2,"","");?>
    <?php $npace_num = str_split($onpacen);
    if(count($npace_num)==2) array_unshift($npace_num,"");
    if(count($npace_num)==1) array_unshift($npace_num,"","");
    ?>

<div class="span12" id="pureOpStats" style="margin-top:20px;padding-bottom:25px;">

        <input type="hidden" id="thisSiteURL" value="{{URL::to('')}}">
        <input type="hidden" id="otherSiteURL" value="{{URL::to('')}}">

    <div class="row-fluid medShadow" style="background:white;width:98%;margin:0 auto;padding-top:10px;padding-bottom:20px;border-top:1px solid #bbb;border-bottom:1px solid #bbb;" >
        <?php $logo = "logo-".$set->shortcode.".png";?>
        <div style="width:17%;float:left;">
            <img src="{{URL::to('img/pureop-logo.png')}}"  >
        </div>

    <div class="span8" >
        
        <div class="bigSTATS" id="counter-GROSS" >
            <div class="counter" style="float:left;margin-left:24px;margin-top:2px">
                <h4>GROSS UNITS WEEK</h4>
                <div class="num">@if(!empty($g_number2[0])){{$g_number2[0]}}@else0@endif</div>
                <div class="num">@if(!empty($g_number2[1])){{$g_number2[1]}}@else0@endif</div>
                <div class="num">@if(!empty($g_number2[2])){{$g_number2[2]}}@else0@endif</div>
            </div>
            <div class="counter" style="float:left;margin-left:24px;margin-top:2px">
                <h4>GROSS UNITS MONTH</h4>
                <div class="num">@if(!empty($g_number[0])){{$g_number[0]}}@else0@endif</div>
                <div class="num">@if(!empty($g_number[1])){{$g_number[1]}}@else0@endif</div>
                <div class="num">@if(!empty($g_number[2])){{$g_number[2]}}@else0@endif</div>
            </div>
            <div class="counter" style="float:left;margin-left:24px;margin-top:2px">
                <h4>GROSS ON PACE MONTH</h4>
                <div class="num">@if(!empty($gpace_num[0])){{$gpace_num[0]}}@else0@endif</div>
                <div class="num">@if(!empty($gpace_num[1])){{$gpace_num[1]}}@else0@endif</div>
                <div class="num">@if(!empty($gpace_num[2])){{$gpace_num[2]}}@else0@endif</div>
            </div>
        </div>
  
        
        <div class="bigSTATS" id="counter-NET" style="display:none;">
            <div class="counter" style="float:left;margin-left:24px;margin-top:2px">
                <h4>NET UNITS WEEK</h4>
                <div class="num">@if(!empty($n_number2[0])){{$n_number2[0]}}@else0@endif</div>
                <div class="num">@if(!empty($n_number2[1])){{$n_number2[1]}}@else0@endif</div>
                <div class="num">@if(!empty($n_number2[2])){{$n_number2[2]}}@else0@endif</div>
            </div>
            <div class="counter" style="float:left;margin-left:24px;margin-top:2px">
                <h4>NET UNITS MONTH</h4>
                <div class="num">@if(!empty($n_number[0])){{$n_number[0]}}@else0@endif</div>
                <div class="num">@if(!empty($n_number[1])){{$n_number[1]}}@else0@endif</div>
                <div class="num">@if(!empty($n_number[2])){{$n_number[2]}}@else0@endif</div>
            </div>
            <div class="counter" style="float:left;margin-left:24px;margin-top:2px">
                <h4>NET ON PACE MONTH</h4>
                <div class="num">@if(!empty($npace_num[0])){{$npace_num[0]}}@else0@endif</div>
                <div class="num">@if(!empty($npace_num[1])){{$npace_num[1]}}@else0@endif</div>
                <div class="num">@if(!empty($npace_num[2])){{$npace_num[2]}}@else0@endif</div>
            </div>
        </div>
    </div>
   
    <div style="float:right;width:14%;" >
          <b>{{$title[0]}}</b>
          <br/>
          {{$set->company_address}}
          <br/>
            <div style="margin-top:10px;">
            <button class='btn btn-small btn-default switchSaleType' data-type='NET'>NET</button>
            <button class='btn btn-small btn-primary switchSaleType' data-type='GROSS'>GROSS</button>
            </div>
            <div style="margin-top:10px;">
            <button class='btn btn-small btn-default showSaleTable' data-type='week'>WEEK</button>
            <button class='btn btn-small btn-inverse showSaleTable' data-type='month'>MONTH</button>
            </div>
    </div>
</div>

            <div class="row-fluid" style="margin-top:10px;padding-top:40px;">
                @if(!empty($sales))
                <div class="span6" id="productTable">
                <?php
                $day = date('w');
                $week_start = date('Y-m-d', strtotime('-'.$day.' days'));
               
                $c=0;$q=0;?>
                <table class="table table-bordered table-condensed saleTable dateTable animated fadeInUp" id="weekSaleTable"  style="display:none;background:white;">
                    <tr style="background:black;color:#fff;font-size:18px; ">
                        @for($i=1;$i<=7;$i++)
                        <?php $q++;?>
                            <th style="width:10%;">{{date('D d',strtotime($week_start. ' + '.$q.' days'))}}</th>
                        @endfor
                    </tr>
                    <tr >
                    @for($i=1;$i<=7;$i++)
                    <?php $c++;?>
                            <td height=75px>
                               
                                @foreach($sales as $s)

                                    @if($s->date==date('Y-m-d',strtotime($week_start.'+'.$c.' days')))
                                    <?php $u = User::find($s->user_id);?>
                                    <a href='#' class='{{$showlead}} tooltwo' title="Click to view more info..." data-type="lead" data-id="{{$s->lead_id}}">                                    
                                    @if($s->typeofsale=="2defenders")
                                    <img class='tooltwo littleProduct {{$s->status}}-sale {{$s->picked_up}}-pickup' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}defender.png' >
                                    <img class='tooltwo littleProduct {{$s->status}}-sale {{$s->picked_up}}-pickup' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}defender.png' >
                                    @elseif($s->typeofsale=="3defenders")
                                    <img class='tooltwo littleProduct {{$s->status}}-sale {{$s->picked_up}}-pickup' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}defender.png' >
                                    <img class='tooltwo littleProduct {{$s->status}}-sale {{$s->picked_up}}-pickup' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}defender.png' >
                                    <img class='tooltwo littleProduct {{$s->status}}-sale {{$s->picked_up}}-pickup' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}defender.png' >
                                    @else
                                    <img class="tooltwo littleProduct {{$s->status}}-sale {{$s->picked_up}}-pickup" title="{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}" src='{{URL::to_asset("images/pureop-small-")}}{{$s->typeofsale}}.png' >
                                    @endif
                                    </a>
                                    
                                    @endif
                                @endforeach
                            </td>
                        @endfor
                        </tr>
                      </tr>
                    </table>
                <?php $num = cal_days_in_month(CAL_GREGORIAN, 5, 1979) ; 
                $date =  date('1-m-Y',strtotime('this month'));
                $c=-1;$q=-1;?>

               
                    <table class="table table-bordered table-condensed saleTable dateTable animated fadeInUp" id="monthSaleTable" style="background:white;" >
                      <tr style="background:black;color:#fff; font-size:13px;;">
                        @for($i=1;$i<=7;$i++)
                        <?php $q++;?>
                        <th style="width:10%;">{{date('D d',strtotime($date. ' + '.$q.' days'))}}</th>
                        @endfor
                      </tr>
                      <tr >
                    @for($i=1;$i<=7;$i++)
                    <?php $c++;?>
                            <td height=40px>
                                @foreach($sales as $s)
                                
                                    @if($s->date==date('Y-m-d',strtotime($date.'+'.$c.' days')))
                                    <a href='#' class='{{$showlead}} tooltwo' title="Click to view more info..." data-type="lead" data-id="{{$s->lead_id}}">                                    
                                    @if($s->typeofsale=="2defenders")
                                    <img class='tooltwo tinyProduct {{$s->status}}-sale {{$s->picked_up}}-pickup' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-")}}defender.png' >
                                    <img class='tooltwo tinyProduct {{$s->status}}-sale {{$s->picked_up}}-pickup' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-")}}defender.png' >
                                    @elseif($s->typeofsale=="3defenders")
                                    <img class='tooltwo tinyProduct {{$s->status}}-sale {{$s->picked_up}}-pickup' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-")}}defender.png' >
                                    <img class='tooltwo tinyProduct {{$s->status}}-sale {{$s->picked_up}}-pickup' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-")}}defender.png' >
                                    <img class='tooltwo tinyProduct {{$s->status}}-sale {{$s->picked_up}}-pickup' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-")}}defender.png' >
                                    @else
                                    <img class="tooltwo tinyProduct {{$s->status}}-sale {{$s->picked_up}}-pickup" title="{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}" src='{{URL::to_asset("images/pureop-")}}{{$s->typeofsale}}.png' >
                                    @endif
                                    </a>
                                    @endif
                                
                                @endforeach
                            </td>
                            @endfor
                      </tr>
                      <tr style="background:black;color:#fff;font-size:13px;">
                            @for($i=8;$i<=14;$i++)
                        <?php $q++;?>
                        <th style="width:10%;">{{date('D d',strtotime($date. ' + '.$q.' days'))}}</th>
                        @endfor
                      </tr>
                      <tr >
                    @for($i=8;$i<=14;$i++)
                    <?php $c++;?>
                            <td height=40px >
                                @foreach($sales as $s)
                                    @if($s->date==date('Y-m-d',strtotime($date.'+'.$c.' days')))
                                
                                
                                <a href='#' class='{{$showlead}} tooltwo' title="Click to view more info..." data-type="lead" data-id="{{$s->lead_id}}">                                    
                                    @if($s->typeofsale=="2defenders")
                                    <img class='tooltwo tinyProduct {{$s->status}}-sale {{$s->picked_up}}-pickup' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-")}}defender.png' >
                                    <img class='tooltwo tinyProduct {{$s->status}}-sale {{$s->picked_up}}-pickup' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-")}}defender.png' >
                                    @elseif($s->typeofsale=="3defenders")
                                    <img class='tooltwo tinyProduct {{$s->status}}-sale {{$s->picked_up}}-pickup' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-")}}defender.png' >
                                    <img class='tooltwo tinyProduct {{$s->status}}-sale {{$s->picked_up}}-pickup' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-")}}defender.png' >
                                    <img class='tooltwo tinyProduct {{$s->status}}-sale {{$s->picked_up}}-pickup' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-")}}defender.png' >
                                    @else
                                    <img class='tooltwo tinyProduct {{$s->status}}-sale {{$s->picked_up}}-pickup' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-")}}{{$s->typeofsale}}.png' >
                                    @endif
                                </a>
                                    @endif
                                @endforeach
                            </td>
                            @endfor
                      </tr>
                      <tr style="background:black;color:#fff;font-size:13px;">
                       @for($i=15;$i<=21;$i++)
                        <?php $q++;?>
                        <th style="width:10%;">{{date('D d',strtotime($date. ' + '.$q.' days'))}}</th>
                        @endfor
                      </tr>
                      <tr >
                    @for($i=15;$i<=21;$i++)
                    <?php $c++;?>
                            <td height=40px >
                                @foreach($sales as $s)
                                    @if($s->date==date('Y-m-d',strtotime($date.'+'.$c.' days')))
                                    <a href='#' class='{{$showlead}} tooltwo' title="Click to view more info..." data-type="lead" data-id="{{$s->lead_id}}">                                    
                                    @if($s->typeofsale=="2defenders")
                                    <img class='tooltwo tinyProduct {{$s->status}}-sale {{$s->picked_up}}-pickup' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}defender.png' >
                                    <img class='tooltwo tinyProduct {{$s->status}}-sale {{$s->picked_up}}-pickup' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}defender.png' >
                                    @elseif($s->typeofsale=="3defenders")
                                    <img class='tooltwo tinyProduct {{$s->status}}-sale {{$s->picked_up}}-pickup' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}defender.png' >
                                    <img class='tooltwo tinyProduct {{$s->status}}-sale {{$s->picked_up}}-pickup' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}defender.png' >
                                    <img class='tooltwo tinyProduct {{$s->status}}-sale {{$s->picked_up}}-pickup' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}defender.png' >
                                    @elseif($s->typeofsale=="2maj")
                                    <img class='tooltwo tinyProduct {{$s->status}}-sale {{$s->picked_up}}-pickup' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}majestic.png' >
                                    <img class='tooltwo tinyProduct {{$s->status}}-sale {{$s->picked_up}}-pickup' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}majestic.png' >
                                    @elseif($s->typeofsale=="3maj")
                                    <img class='tooltwo tinyProduct {{$s->status}}-sale {{$s->picked_up}}-pickup' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}majestic.png' >
                                    <img class='tooltwo tinyProduct {{$s->status}}-sale {{$s->picked_up}}-pickup' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}majestic.png' >
                                    <img class='tooltwo tinyProduct {{$s->status}}-sale {{$s->picked_up}}-pickup' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}majestic.png' >
                                    @else
                                    <img class='tooltwo tinyProduct {{$s->status}}-sale {{$s->picked_up}}-pickup' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}{{$s->typeofsale}}.png' >
                                    @endif
                                </a>
                                    @endif
                                @endforeach
                            </td>
                            @endfor
                      </tr>
                       <tr style="background:black;color:#fff;font-size:13px;">
                            @for($i=23;$i<=29;$i++)
                        <?php $q++;?>
                        <th style="width:10%;">{{date('D d',strtotime($date. ' + '.$q.' days'))}}</th>
                        @endfor
                      </tr>
                      <tr >
                    @for($i=23;$i<=29;$i++)
                    <?php $c++;?>
                            <td height=40px >
                                @foreach($sales as $s)
                                    @if($s->date==date('Y-m-d',strtotime($date.'+'.$c.' days')))
                                    <a href='#' class='{{$showlead}} tooltwo' title="Click to view more info..." data-type="lead" data-id="{{$s->lead_id}}">                                    
                                    @if($s->typeofsale=="2defenders")
                                    <img class='tooltwo tinyProduct {{$s->status}}-sale {{$s->picked_up}}-pickup' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}defender.png' >
                                    <img class='tooltwo tinyProduct {{$s->status}}-sale {{$s->picked_up}}-pickup' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}defender.png' >
                                    @elseif($s->typeofsale=="3defenders")
                                    <img class='tooltwo tinyProduct {{$s->status}}-sale {{$s->picked_up}}-pickup' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}defender.png' >
                                    <img class='tooltwo tinyProduct {{$s->status}}-sale {{$s->picked_up}}-pickup' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}defender.png' >
                                    <img class='tooltwo tinyProduct {{$s->status}}-sale {{$s->picked_up}}-pickup' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}defender.png' >
                                    @elseif($s->typeofsale=="2maj")
                                    <img class='tooltwo tinyProduct {{$s->status}}-sale {{$s->picked_up}}-pickup' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}majestic.png' >
                                    <img class='tooltwo tinyProduct {{$s->status}}-sale {{$s->picked_up}}-pickup' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}majestic.png' >
                                    @elseif($s->typeofsale=="3maj")
                                    <img class='tooltwo tinyProduct {{$s->status}}-sale {{$s->picked_up}}-pickup' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}majestic.png' >
                                    <img class='tooltwo tinyProduct {{$s->status}}-sale {{$s->picked_up}}-pickup' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}majestic.png' >
                                    <img class='tooltwo tinyProduct {{$s->status}}-sale {{$s->picked_up}}-pickup' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}majestic.png' >
                                    @else
                                    <img class='tooltwo tinyProduct {{$s->status}}-sale {{$s->picked_up}}-pickup' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}{{$s->typeofsale}}.png' >
                                    @endif
                                </a>
                                    @endif
                                @endforeach
                            </td>
                            @endfor
                      </tr>
                      <tr style="background:black;color:#fff;font-size:13px;">
                            @for($i=31;$i<=32;$i++)
                        <?php $q++;?>
                        <th style="width:10%;">{{date('D d',strtotime($date. ' + '.$q.' days'))}}</th>
                        @endfor
                      </tr>
                      <tr >
                    @for($i=31;$i<=32;$i++)
                    <?php $c++;?>
                            <td height=40px >
                                @foreach($sales as $s)
                                    @if($s->date==date('Y-m-d',strtotime($date.'+'.$c.' days')))
                                    <a href='#' class='{{$showlead}} tooltwo' title="Click to view more info..." data-type="lead" data-id="{{$s->lead_id}}">                                    
                                    @if($s->typeofsale=="2defenders")
                                    <img class='tooltwo tinyProduct {{$s->status}}-sale {{$s->picked_up}}-pickup' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}defender.png' >
                                    <img class='tooltwo tinyProduct {{$s->status}}-sale {{$s->picked_up}}-pickup' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}defender.png' >
                                    @elseif($s->typeofsale=="3defenders")
                                    <img class='tooltwo tinyProduct {{$s->status}}-sale {{$s->picked_up}}-pickup' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}defender.png' >
                                    <img class='tooltwo tinyProduct {{$s->status}}-sale {{$s->picked_up}}-pickup' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}defender.png' >
                                    <img class='tooltwo tinyProduct {{$s->status}}-sale {{$s->picked_up}}-pickup' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}defender.png' >
                                    @elseif($s->typeofsale=="2maj")
                                    <img class='tooltwo tinyProduct {{$s->status}}-sale {{$s->picked_up}}-pickup' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}majestic.png' >
                                    <img class='tooltwo tinyProduct {{$s->status}}-sale {{$s->picked_up}}-pickup' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}majestic.png' >
                                    @elseif($s->typeofsale=="3maj")
                                    <img class='tooltwo tinyProduct {{$s->status}}-sale {{$s->picked_up}}-pickup' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}majestic.png' >
                                    <img class='tooltwo tinyProduct {{$s->status}}-sale {{$s->picked_up}}-pickup' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}majestic.png' >
                                    <img class='tooltwo tinyProduct {{$s->status}}-sale {{$s->picked_up}}-pickup' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}majestic.png' >
                                    @else
                                    <img class='tooltwo tinyProduct {{$s->status}}-sale {{$s->picked_up}}-pickup' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}{{$s->typeofsale}}.png' >
                                    @endif
                                </a>
                                    @endif
                                @endforeach
                            </td>
                            @endfor
                      </tr>
                    </table>

                </div>
                @endif
                <div class='span6 ' style="margin-left:25px;">

                    <table class="table table-bordered table-condensed "  style="display:none;" >
                        <thead style="">
                            <tr  style="background:#eee;">
                                <th>SPECIALIST</th>
                                <th colspan=2>PURE OP</th>
                                <th colspan=2><center>Gross</center></th>
                                <th colspan=2><center>Net</center></th>
                                <th>UNITS</th>
                                <th>DNS</th>
                                <th>CXL</th>
                                <th>INC</th>
                                <th>CLOSE</th>
                            </tr>
                      <tr>
                    <th></th>
                    <th style="font-size:13px;"><center>Lvl</center></th>
                    <th style="font-size:13px;"><center>Sales</center></th>
                    <th style="font-size:13px;"><center>Maj</center></th>
                    <th style="font-size:13px;"><center>Def</center></th>
                    <th style="font-size:13px;"><center>Maj</center></th>
                    <th style="font-size:13px;"><center>Def</center></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                      </tr>
                        </thead>
                        <tbody class=''>
                            @foreach($companies as $c)
                            <tr>
                                <td><button class='btn btn-default btn-mini' style="width:100%;height:100%;font-size:13px;;" data-link="{{$c->web_address}}"><div style="float:left"><b>{{$c->company_name}}</b></div></button></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>



                    <table class="table table-bordered table-condensed repTable animated fadeInUp" id="monthRepTable" style="background:white;border:1px solid #aaa;" >
                        <thead style="">
                            <tr  style="background:#eee;">
                                <th>SPECIALIST</th>
                                <th colspan=2>PURE OP</th>
                                <th class="saleColumn column-GROSS" colspan=2><center>Gross</center></th>
                                <th class="saleColumn column-NET" colspan=2><center>Net</center></th>
                                <th>UNITS</th>
                                <th>DNS</th>
                                <th>CXL</th>
                                <th>INC</th>
                                <th>CLOSE</th>
                            </tr>
                      <tr>
                    <th></th>
                    <th style="font-size:10px;"><center>Lvl</center></th>
                   
                    <th style="font-size:10px;"><center>Sales</center></th>
                    <th class="saleColumn column-GROSS" style="font-size:10px;"><center>Maj</center></th>
                    <th class="saleColumn column-GROSS" style="font-size:10px;"><center>Def</center></th>

                    <th class="saleColumn column-NET" style="font-size:10px;"><center>Maj</center></th>
                    <th class="saleColumn column-NET" style="font-size:10px;"><center>Def</center></th>
                   
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                      </tr>
                        </thead>
                        <tbody class=''>
                            @if(!empty($monthSales))
                            @foreach($monthSales as $val)
                                @if(isset($val["name"]))
                                    @if($val["name"]!="totals")
                                    <?php $u=User::find($val["rep_id"]);?>
                                    @if($u)

                                    <?php if($u->level==99){$active = "notactive";} else {$active = "isactive";};?>
                                    <tr class='{{$active}} allReps'>
                                    <?php $label = ($val["grosssales"]>0) ? $label="success special" : $label = "inverse";?>
                                    <td>

                                            <!--<button class='btn btn-default btn-mini  viewRepInfo showPureOp' style="width:100%;height:100%;font-size:13px;;" data-id="{{$val['rep_id']}}">
                                    <div style="float:left">-->
                                    <b>{{$u->fullName()}}</b><!--</div>
                                    </button>-->
                                    </td>
                                    <td><img class="tooltwo" title="{{$u->fullName()}} is a level {{$u->level}} representative" src="{{URL::to_asset('images/')}}level{{$u->level}}.png" style="width:28px;"></td>
                                   
                                    <td>@if($val["grosssales"]!=0) <span class='saleColumn column-GROSS label label-inverse bigtext tooltwo' style='color:#fff;' title="{{$u->fullName()}} needs {{10-$val['netmd']['majestic']}} majestics and {{10-$val['netmd']['defender']}} defenders to level up. ">{{$val["grosssales"]}} Sales </span>@endif
                                        @if($val["netsales"]!=0) <span class='saleColumn column-NET label label-inverse bigtext tooltwo' style='color:#fff;' >{{$val["netsales"]}} Sales </span>@endif
                                    </td>
                                    
                                    <td class="saleColumn column-GROSS">@if($val["grossmd"]["majestic"]!=0)<center><span class='label label-info bigbox special '>{{$val["grossmd"]["majestic"]}}</span></center>@endif
                                    </td>
                                    <td class="saleColumn column-GROSS">@if($val["grossmd"]["defender"]!=0)<center><span class='label label-info bigbox special '>{{$val["grossmd"]["defender"]}}</span></center>@endif
                                    </td>
                                    <td class="saleColumn column-NET">@if($val["netmd"]["majestic"]!=0)<center><span class='label label-info bigbox special '>{{$val["netmd"]["majestic"]}}</span></center>@endif
                                    </td>
                                    <td class="saleColumn column-NET">@if($val["netmd"]["defender"]!=0)<center><span class='label label-info bigbox special '>{{$val["netmd"]["defender"]}}</span></center>@endif
                                    </td>
                                    <td>@if($val["totgrossunits"]!=0)<center><span class=' saleColumn column-GROSS label label-success bigtext special '>{{$val["totgrossunits"]}}</span><span class=' saleColumn column-NET label label-success bigtext special '>{{$val["totnetunits"]}}</span></center>@endif
                                    </td>
                                    <td><center>@if($val["appointment"]["DNS"]!=0)<span class="label label-important bigbox special">{{$val["appointment"]["DNS"]}}</span>@endif</center></td>
                                    <td><center>@if($val["appointment"]["CXLREP"]!=0)<span class="label label-warning bigbox" style="color:#000">{{$val["appointment"]["CXLREP"]}}</span>@endif</center></td>
                                    <td><center>@if($val["appointment"]["INC"]!=0)<span class="label label-warning bigbox special" style="color:#000">{{$val["appointment"]["INC"]}}</span>@endif</center></td>
                                    <td><center>@if($val["appointment"]["CLOSE"]!=0)<span class="label label-inverse bigbox">{{number_format($val["appointment"]["CLOSE"],2,'.','')}}%</span>@endif</center></td>
                                </tr>
                                    @endif
                                    
                                    @else
                                    <tr style="background:#aaa;"><td colspan=12></td></tr>
                                    <tr class=' allReps'>
                                    <td></td>
                                    <?php $label = ($val["grosssales"]>0) ? $label="success special" : $label = "inverse";?> 
                                    <td></td>
                                    <td>@if($val["grosssales"]!=0) <span class='saleColumn column-GROSS label label-inverse bigtext tooltwo' style='color:#fff;' title="">{{$val["grosssales"]}} Sales </span>@endif
                                        @if($val["netsales"]!=0) <span class='saleColumn column-NET label label-inverse bigtext tooltwo' style='color:#fff;' title="">{{$val["netsales"]}} Sales </span>@endif

                                    </td>
                                    
                                    <td class="saleColumn column-GROSS">@if($val["grossmd"]["majestic"]!=0)<center><span class='label label-info bigbox special '>{{$val["grossmd"]["majestic"]}}</span></center>@endif
                                    </td>
                                    <td class="saleColumn column-GROSS">@if($val["grossmd"]["defender"]!=0)<center><span class='label label-info bigbox special '>{{$val["grossmd"]["defender"]}}</span></center>@endif
                                    </td>
                                    <td class="saleColumn column-NET">@if($val["netmd"]["majestic"]!=0)<center><span class='label label-info bigbox special '>{{$val["netmd"]["majestic"]}}</span></center>@endif
                                    </td>
                                    <td class="saleColumn column-NET">@if($val["netmd"]["defender"]!=0)<center><span class='label label-info bigbox special '>{{$val["netmd"]["defender"]}}</span></center>@endif
                                    </td>
                                    <td>@if($val["totgrossunits"]!=0)<center><span class=' saleColumn column-GROSS label label-success bigtext special '>{{$val["totgrossunits"]}}</span><span class=' saleColumn column-NET label label-success bigtext special '>{{$val["totnetunits"]}}</span></center>@endif
                                    </td>
                                    <td><center>@if($val["appointment"]["DNS"]!=0)<span class="label label-important bigbox special">{{$val["appointment"]["DNS"]}}</span>@endif</center></td>
                                    <td><center>@if($val["appointment"]["CXLREP"]!=0)<span class="label label-warning bigbox" style="color:#000">{{$val["appointment"]["CXLREP"]}}</span>@endif</center></td>
                                    <td><center>@if($val["appointment"]["INC"]!=0)<span class="label label-warning bigbox special" style="color:#000">{{$val["appointment"]["INC"]}}</span>@endif</center></td>
                                    <td><center>@if($val["appointment"]["CLOSE"]!=0)<span class="label label-inverse bigbox">{{number_format($val["appointment"]["CLOSE"],2,'.','')}}%</span>@endif</center></td>
                                    
                                  
                                    </tr>
                                    <tr style="background:#aaa;"><td colspan=12></td></tr>
                                    @endif
                                    @endif
                                
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                    <table class="table table-bordered table-condensed repTable animated fadeInUp " id="weekRepTable" style="background:white;display:none;border:1px solid #1f1f1f;" >
                        <thead style="">
                            <tr  style="background:#eee;">
                            <th>SPECIALIST</th>
                            <th colspan=2>PURE OP</th>
                            <th class="saleColumn column-GROSS" colspan=2><center>Gross</center></th>
                            <th class="saleColumn column-NET" colspan=2><center>Net</center></th>
                            <th>UNITS</th>
                            <th>DNS</th>
                            <th>CXL</th>
                            <th>INC</th>
                            <th>CLOSE</th>
                      </tr>
                      <tr>
                    <th></th>
                    <th style="font-size:10px;"><center>Lvl</center></th>
                   
                    <th style="font-size:10px;"><center>Sales</center></th>
                    <th class="saleColumn column-GROSS" style="font-size:10px;"><center>Maj</center></th>
                    <th class="saleColumn column-GROSS" style="font-size:10px;"><center>Def</center></th>

                    <th class="saleColumn column-NET" style="font-size:10px;"><center>Maj</center></th>
                    <th class="saleColumn column-NET" style="font-size:10px;"><center>Def</center></th>
                   
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                      </tr>
                        </thead>
                        <tbody class=''>
                            @if(!empty($weekSales))
                            @foreach($weekSales as $val)
                                @if(isset($val["name"]))
                                    @if($val["name"]!="totals")
                                    <?php $u=User::find($val["rep_id"]);?>
                                    @if($u)
                                    <?php if($u->level==99){$active = "notactive";} else {$active = "isactive";};?>
                                    <tr class='{{$active}} allReps'>
                                    <?php $label = ($val["grosssales"]>0) ? $label="success special" : $label = "inverse";?>
                                    <td>
                                    <!--<button class='btn btn-default btn-mini  viewRepInfo showPureOp' style="width:100%;height:100%;font-size:13px;;" data-id="{{$val['rep_id']}}">
                                    <div style="float:left">-->
                                    <b>{{$u->fullName()}}}</b><!--</div>
                                    </button>-->
                                    </td>
                                    <td><img class="tooltwo" title="{{$u->fullName()}} is a level {{$u->level}} representative" src="{{URL::to_asset('images/')}}level{{$u->level}}.png" style="width:28px;"></td>
                                   
                                    <td>@if($val["grosssales"]!=0) <span class='saleColumn column-GROSS label label-inverse bigtext tooltwo' style='color:#fff;' title="{{$u->fullName()}} needs {{10-$val['netmd']['majestic']}} majestics and {{10-$val['netmd']['defender']}} defenders to level up. ">{{$val["grosssales"]}} Sales </span>@endif
                                        @if($val["netsales"]!=0) <span class='saleColumn column-NET label label-inverse bigtext tooltwo' style='color:#fff;'>{{$val["netsales"]}} Sales </span>@endif
                                    </td>
                                    
                                    <td class="saleColumn column-GROSS">@if($val["grossmd"]["majestic"]!=0)<center><span class='label label-info bigbox special '>{{$val["grossmd"]["majestic"]}}</span></center>@endif
                                    </td>
                                    <td class="saleColumn column-GROSS">@if($val["grossmd"]["defender"]!=0)<center><span class='label label-info bigbox special '>{{$val["grossmd"]["defender"]}}</span></center>@endif
                                    </td>
                                    <td class="saleColumn column-NET">@if($val["netmd"]["majestic"]!=0)<center><span class='label label-info bigbox special '>{{$val["netmd"]["majestic"]}}</span></center>@endif
                                    </td>
                                    <td class="saleColumn column-NET">@if($val["netmd"]["defender"]!=0)<center><span class='label label-info bigbox special '>{{$val["netmd"]["defender"]}}</span></center>@endif
                                    </td>
                                    <td>@if($val["totgrossunits"]!=0)<center><span class='saleColumn column-GROSS label label-success bigtext special '>{{$val["totgrossunits"]}}</span><span class='saleColumn column-NET label label-success bigtext special '>{{$val["totnetunits"]}}</span></center>@endif
                                    </td>
                                    <td><center>@if($val["appointment"]["DNS"]!=0)<span class="label label-important bigbox special">{{$val["appointment"]["DNS"]}}</span>@endif</center></td>
                                    <td><center>@if($val["appointment"]["CXL"]!=0)<span class="label label-warning bigbox" style="color:#000">{{$val["appointment"]["CXL"]}}</span>@endif</center></td>
                                    <td><center>@if($val["appointment"]["INC"]!=0)<span class="label label-warning bigbox special" style="color:#000">{{$val["appointment"]["INC"]}}</span>@endif</center></td>
                                    <td><center>@if($val["appointment"]["CLOSE"]!=0)<span class="label label-inverse bigbox">{{number_format($val["appointment"]["CLOSE"],2,'.','')}}%</span>@endif</center></td>
                                </tr>
                                    @endif
                                    
                                    @else
                                    <tr style="background:#ccc;"><td colspan=12></td></tr>
                                    <tr class=' allReps'>
                                    <td><button class='btn btn-primary btn-mini  viewOffice viewRepInfo showPureOp' style="width:100%;height:30px;font-size:13px;;" data-id="all">OFFICE</button></td>
                                    <?php $label = ($val["grosssales"]>0) ? $label="success special" : $label = "inverse";?> 
                                    <td></td>
                                    <td>@if($val["grosssales"]!=0) <span class='saleColumn column-GROSS label label-inverse bigtext tooltwo' style='color:#fff;' title="">{{$val["grosssales"]}} Sales </span>@endif
                                        @if($val["netsales"]!=0) <span class='saleColumn column-NET label label-inverse bigtext tooltwo' style='color:#fff;' title="">{{$val["netsales"]}} Sales </span>@endif
                                    </td>
                                    <td class="saleColumn column-GROSS">@if($val["grossmd"]["majestic"]!=0)<center><span class='label label-info bigbox special '>{{$val["grossmd"]["majestic"]}}</span></center>@endif
                                    </td>
                                    <td class="saleColumn column-GROSS">@if($val["grossmd"]["defender"]!=0)<center><span class='label label-info bigbox special '>{{$val["grossmd"]["defender"]}}</span></center>@endif
                                    </td>
                                    <td class="saleColumn column-NET">@if($val["netmd"]["majestic"]!=0)<center><span class='label label-info bigbox special '>{{$val["netmd"]["majestic"]}}</span></center>@endif
                                    </td>
                                    <td class="saleColumn column-NET">@if($val["netmd"]["defender"]!=0)<center><span class='label label-info bigbox special '>{{$val["netmd"]["defender"]}}</span></center>@endif
                                    </td>
                                    <td class="saleColumn column-NET">@if($val["totgrossunits"]!=0)<center><span class='saleColumn column-GROSS label label-success bigtext special '>{{$val["totgrossunits"]}}</span><span class='saleColumn column-NET label label-success bigtext special '>{{$val["totnetunits"]}}</span></center>@endif
                                    </td>
                                    <td><center>@if($val["appointment"]["DNS"]!=0)<span class="label label-important bigbox special">{{$val["appointment"]["DNS"]}}</span>@endif</center></td>
                                    <td><center>@if($val["appointment"]["CXL"]!=0)<span class="label label-warning bigbox" style="color:#000">{{$val["appointment"]["CXL"]}}</span>@endif</center></td>
                                    <td><center>@if($val["appointment"]["INC"]!=0)<span class="label label-warning bigbox special" style="color:#000">{{$val["appointment"]["INC"]}}</span>@endif</center></td>
                                    <td><center>@if($val["appointment"]["CLOSE"]!=0)<span class="label label-inverse bigbox">{{number_format($val["appointment"]["CLOSE"],2,'.','')}}%</span>@endif</center></td>
                                    
                                  
                                    </tr>
                                    <tr style="background:#ccc;"><td colspan=12></td></tr>
                                    @endif
                                    @endif
                                
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
           </div>

          


<script>
$(document).ready(function(){
    $('.column-NET').hide();
    $('.showSaleTable').click(function(){
        $('.showSaleTable').removeClass('btn-inverse');
        $(this).addClass('btn-inverse');
        var type=$(this).data('type');
        $('.saleTable').hide();
        $('.repTable').hide();
        $('#'+type+'SaleTable').show();
        $('#'+type+'RepTable').show();
    });
    
});
</script>
@else
<center>
    <br/><br/><br/><br/><br/><br/><br/><br/><br/>
    <h1 style="color:#fff;">Data is Not Shared</h1>
    <p style="color:#fff;">You are trying to access data, that has otherwise been blocked by this Distributor</p>
    <br/>
</center>
@endif
         	