

<div style="width:100%;">

                @if(!empty($marketpodium['hold']))
        	 	<?php $count=0;?>
        		@foreach($marketpodium['hold'] as $val)
        		<?php $count++;?>
        	
        	<strong>{{$val['booker_name']}}</strong><strong class="pull-right">{{number_format($val['hold'],2,'.','')}}%</strong>
            <div class="progress progress-success slim"><div class="bar" data-percentage="{{$val['hold']}}"></div></div>
            <div class="topstats" ><font color=lime>BOOKED : {{$val['total']}}</font> &nbsp;&nbsp;|&nbsp;&nbsp;  PUTON : <strong style="color:yellow">{{$val['booked']}}    </strong></div>
            <?php if($count==3){break;};?>
        	@endforeach
            @endif       
        </div>