@if(!empty($sales))
<h4 style="margin-top:-10px;">Total Sales by System Type</h4>
<div class="sideMachines well" style="margin-bottom:30px;">
                 @if(isset($stats['all'][$user->id]))
                <?php $st = $stats['all'][$user->id]; $app = $st['appointment'];?>
                <div class='profileStat animated slideInLeft '>
                        <img src='{{URL::to("images/pureop-defender.png")}}'>
                    @if($st['grossmd']['defender']!=0)
                        <span class='stats machine-statBubble animated rollIn GROSS'>{{$st['grossmd']['defender']}}</span>
                        <span class='stats machine-statBubble animated rollIn NET'>{{$st['netmd']['defender']}}</span>
                        @endif
                        <img src='{{URL::to("images/pureop-majestic.png")}}'>
                    @if($st['grossmd']['majestic']!=0)
                        <span class='stats machine-statBubble animated rollIn GROSS'>{{$st['grossmd']['majestic']}}</span>
                        <span class='stats machine-statBubble animated rollIn NET'>{{$st['netmd']['majestic']}}</span>
                        @endif
                        <img src='{{URL::to("images/pureop-system.png")}}'> 
                    @if($st['grosssale']['system']!=0)
                        <span class='stats machine-statBubble animated rollIn GROSS'>{{$st['grosssale']['system']}}</span>
                        <span class='stats machine-statBubble animated rollIn NET'>{{$st['netsale']['system']}}</span>
                        @endif
                        <img src='{{URL::to("images/pureop-supersystem.png")}}'> 
                    @if($st['grosssale']['supersystem']!=0)
                        <span class='stats machine-statBubble animated rollIn GROSS'>{{$st['grosssale']['supersystem']}}</span>
                        <span class='stats machine-statBubble animated rollIn NET'>{{$st['netsale']['supersystem']}}</span>
                        @endif
                        <img src='{{URL::to("images/pureop-megasystem.png")}}'> 
                    @if($st['grosssale']['megasystem']!=0)
                        <span class='stats machine-statBubble animated rollIn GROSS'>{{$st['grosssale']['megasystem']}}</span>
                        <span class='stats machine-statBubble animated rollIn NET'>{{$st['netsale']['megasystem']}}</span>
                        @endif
                        <img src='{{URL::to("images/pureop-novasystem.png")}}' class="last"> 
                        @if($st['grosssale']['novasystem']!=0)
                        <span class='stats machine-statBubble animated rollIn GROSS'>{{$st['grosssale']['novasystem']}}</span>
                        <span class='stats machine-statBubble animated rollIn NET'>{{$st['netsale']['novasystem']}}</span>
                        @endif
                </div>
                @endif
            </div>
@else
<h1>{{$user->profileName("has")}} no sales yet</h1>
@endif