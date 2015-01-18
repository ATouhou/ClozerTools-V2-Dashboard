<div class="row-fluid" >
    <h3>{{$user->profileName()}} Recruits</h3>
    @if(!empty($user->recruits))
    <div class="span12 well" style="margin-left:0px;">
    <?php $ct = 0;?>
    @foreach($user->recruits as $rec)
    <?php $ct++;
    $sale = $rec->lastSale();?>
    <div class='span12 starSearchList smallShadow animated fadeInUp' style="margin-left:-0px;">
        <div class="wrapper">
            <div  style="width:15%;float:left;margin-right:10px;margin-top:-38px;">
                <img class="smallShadow" src='{{$rec->avatar_link()}}' style='width:92%;margin-top:40px;margin-left:10px;margin-right:10px;'>
                <br/>
                <?php if($rec->silver_points>10){$color="sale-COMPLETE ";} else {$color="sale-TURNDOWN";};?>
            </div>
            <div class="span9">
                <b>{{$rec->fullName()}}</b> was recruited by {{$user->firstname}} on {{date('M-d',strtotime($rec->created_at))}}<br/>
                    @if(isset($sale) && !empty($sale))
                        <?php $s = $sale[0]->attributes;?>
                        <span class='smallText' style='color:#6e6e6e;'>Last Sold a {{ucfirst($s['typeofsale'])}} on {{date('M-d',strtotime($s['date']))}}</span>
                    @endif
                    <?php if($rec->silver_points<=10){
                        $points = $rec->silver_points*38;
                        $starWidth = "width:".number_format(($points/380*100),0,'.','')."%";
                        $msg = $rec->fullName()." has earned ".$rec->silver_points." Stars for ".$user->firstname. " StarSearch Credits";
                        } else {$starWidth="width:100%";
                            $points=10;
                            $msg = $rec->fullName()." is a Star!! He earned ".$user->firstname. " $1000!";
                        }; ?>
                    <div class="animated fadeInDown starSearch tooltwo" title="{{$msg}}">
                        <div class="colorStars"  style="{{$starWidth}}"></div>
                    </div>
            </div>
            <div class="span12" style="">
                @if(isset($stats['all'][$rec->id]))
                <?php $ustat = $stats['all'][$rec->id];?>
                <span class='tooltwo badge badge-inverse' style='font-size:16px;' title='Put On Demos | 1 Point , SOLD Demo | 5 Points'>{{$rec->system_points}}</span>&nbsp;&nbsp;
                <img src='{{URL::to("img/badges/")}}bronzecoins.png' style='width:20px;margin-bottom:8px;'>
                <span class='tooltwo badge bronzeCoins ' style='font-size:16px;' title='For every GROSS unit sold | 1 BRONZE'>{{$rec->bronze_points}} </span>
                <img src='{{URL::to("img/badges/")}}silvercoins.png' style='width:20px;margin-left:10px;margin-bottom:8px;'>
                <span class='tooltwo badge silverCoins blackText' style='font-size:16px;' title='For every GROSS sale | 1 SILVER'>{{$rec->silver_points}} </span>
                <img src='{{URL::to("img/badges/")}}goldcoins.png' style='width:20px;margin-left:10px;margin-bottom:8px;'>
                <span class='tooltwo badge goldCoins blackText' style='font-size:16px;' title='For every GROSS Super, Mega or Nova System sale | 1 GOLD'>{{$rec->gold_points}} </span>
                <br/>
                 <h5 style='color:#aaa;'>Total Sales By System Type</h5>
                <img src="{{URL::to('images/')}}pureop-small-defender.png"><span class='badge badge-warning GROSS special blackText'>{{$ustat['grossmd']['defender']}}</span><span class='badge badge-warning NET special blackText'>{{$ustat['netmd']['defender']}}</span>
                <img src="{{URL::to('images/')}}pureop-small-majestic.png"><span class='badge badge-warning GROSS special blackText'>{{$ustat['grossmd']['majestic']}}</span><span class='badge badge-warning NET special blackText'>{{$ustat['netmd']['majestic']}}</span>
                <img src="{{URL::to('images/')}}pureop-small-system.png"><span class='badge badge-warning GROSS special blackText'>{{$ustat['grosssale']['system']}}</span><span class='badge badge-warning NET special blackText'>{{$ustat['netsale']['system']}}</span>
                <img src="{{URL::to('images/')}}pureop-small-supersystem.png"><span class='badge GROSS badge-warning special blackText'>{{$ustat['grosssale']['supersystem']}}</span><span class='badge badge-warning NET special blackText'>{{$ustat['netsale']['supersystem']}}</span>
                <img src="{{URL::to('images/')}}pureop-small-megasystem.png"><span class='badge badge-warning GROSS special blackText'>{{$ustat['grosssale']['megasystem']}}</span><span class='badge badge-warning NET special blackText'>{{$ustat['netsale']['megasystem']}}</span>
                <img src="{{URL::to('images/')}}pureop-small-novasystem.png"><span class='badge badge-warning GROSS special blackText'>{{$ustat['grosssale']['novasystem']}}</span><span class='badge badge-warning NET special blackText'>{{$ustat['netsale']['novasystem']}}</span>
                <br/>
                @endif
            </div>
            @if($rec->silver_points>10)
                <div class="ribbon-wrapper-green"><div class="ribbon-green badge badge-inverse"  style='color:#000;'>$1,000</div></div>
            @endif
        </div>
    </div>
    @endforeach
    </div>
    @else
    <div class="span11 well" style="margin-left:-0px;">
        <h4>{{$user->profileName("has")}} no recruits yet</h4>
    </div>
    @endif
</div>
              
               