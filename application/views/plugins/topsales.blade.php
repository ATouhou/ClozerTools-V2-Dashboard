        <style>
        .sortReps {cursor:pointer;margin-bottom:20px;}
        .crown {position:relative;
        margin-top:-20px;margin-bottom:5px;}

.bigtext2 {
  color:#000;
  font-size:17px;
  padding:4px;
}
.dealerStats {cursor:pointer;}
.dealerStats:hover {
  background:black;
}
.invalid  {background: #febbbb; /* Old browsers */
background: -moz-linear-gradient(top,  #febbbb 0%, #fe9090 45%, #ffa3a3 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#febbbb), color-stop(45%,#fe9090), color-stop(100%,#ffa3a3)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #febbbb 0%,#fe9090 45%,#ffa3a3 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #febbbb 0%,#fe9090 45%,#ffa3a3 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #febbbb 0%,#fe9090 45%,#ffa3a3 100%); /* IE10+ */
background: linear-gradient(to bottom,  #febbbb 0%,#fe9090 45%,#ffa3a3 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#febbbb', endColorstr='#ffa3a3',GradientType=0 ); /* IE6-9 */
}

.valid{
  background: #b4e391; /* Old browsers */
background: -moz-linear-gradient(top,  #b4e391 0%, #61c419 50%, #b4e391 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#b4e391), color-stop(50%,#61c419), color-stop(100%,#b4e391)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #b4e391 0%,#61c419 50%,#b4e391 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #b4e391 0%,#61c419 50%,#b4e391 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #b4e391 0%,#61c419 50%,#b4e391 100%); /* IE10+ */
background: linear-gradient(to bottom,  #b4e391 0%,#61c419 50%,#b4e391 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#b4e391', endColorstr='#b4e391',GradientType=0 ); /* IE6-9 */

}
.salesBOX {display:none;}
        </style>
          <div id="statSide" style="width:100%;">
        	 @if(!empty($salespodium['reps']))
                    @if(isset($displaypodium))
                     <div class="podium" style="margin-left:-20px;">    
                    <div class="avatar1 animated rollIn">
                        @if(isset($salespodium['reps'][1]->rep_name)) 
                        {{$salespodium['reps'][1]->rep_name}}<br/><img src="{{User::find($salespodium['reps'][1]->rep_id)->avatar_link()}}" style="width:48px;margin-left:8px;">
                        @endif
                    </div>
                    <div class="avatar2 animated fadeInDownBig">
                        @if(isset($salespodium['reps'][0]->rep_name)) 
                        <img class="crown" src="{{URL::to_asset('images/crown.png')}}">
                       <br/><img src="{{User::find($salespodium['reps'][0]->rep_id)->avatar_link()}}" style="width:75px;" ><br/> {{$salespodium['reps'][0]->rep_name}}
                        @endif
                    </div>
                    <div class="avatar3 animated rollIn">
                        @if(isset($salespodium['reps'][2]->rep_name)) 
                        {{$salespodium['reps'][2]->rep_name}}<br/><img src="{{User::find($salespodium['reps'][2]->rep_id)->avatar_link()}}" style="width:48px;margin-left:6px;" >
                        @endif
                      </div>
                    <div class="podiumhead" style="margin-left:90px">Top Sales Reps</div>
                </div>
                @endif
              <br/>
              <!--<button class='btn btn-default btn-mini sortReps' data-type='units'>UNITS</button>&nbsp;&nbsp;&nbsp;<button class='btn btn-default btn-mini sortReps' data-type='commission'>COMMISSION</button><br/>-->
        	 <div class='repStats'>
           
        	 @foreach($salespodium['reps'] as $val)
           <?php $payout=0;$nunits=0;$gunits=0;$sales="<div class='salesBOX repBox-".$val->rep_id."'><table class='table well table-bordered condensed' style='color:#000'>";?>
            @foreach($salespodium["sales"] as $v)
            <?php $sale = Sale::find($v->id);?>
              @if($sale)
                  @if($v->ridealong_id==$val->rep_id)
                  <?php $payout = $payout+$v->ridealong_payout;?>
                @elseif($v->user_id==$val->rep_id)
                <?php $sales.="<tr class='invalid'><td>".ucfirst($sale->typeofsale)."</td><td><span class='label label-success special bigtext2'> ".$sale->units()." </span></td><td align='right'>$".$sale->payout."</td></tr>";
                ?>
                @if(($v->status!="TURNDOWN")&&($v->status!="CANCELLED"))
                 <?php $nunits =$nunits+intval($sale->units());?>
                  <?php $gunits =$gunits+intval($sale->units());?>
                <?php $payout = $payout+$v->payout;?>
                 <?php $sales.="<tr class='valid'><td>".ucfirst($sale->typeofsale)."</td><td><span class='label label-success special bigtext2'> ".$sale->units()." </span></td><td align='right'>$".$sale->payout."</td></tr>";
                ?>
                @endif
                <?php $gunits =$gunits+intval($sale->units());?>
                @endif
            @endif
              
            @endforeach
            <?php $sales.= "</table></div>";?>
        	 <div class="animated fadeInUp dealerStats tooltwo subtle-shadow" title="Click to reveal sale details" style="padding:3px; width:@if(!empty($displaystats))110%;@else 98% @endif" data-id="{{$val->rep_id}}" data-units='{{$units}}' data-commission='{{$payout}}'>
        	 <img src="{{User::find($val->rep_id)->avatar_link()}}" class="shadowBOX shadow" style="border:1px solid #1f1f1f;width:20px;margin-left:6px;margin-right:1px;" >
           <strong>
           <?php $str = explode(" ",$val->rep_name);?>
           @if(isset($str[0]))
            {{$str[0]}} @if(isset($str[1][0])) {{$str[1][0]}} @endif
           @endif
          </strong>&nbsp;<span class='label label-success special blackText'>{{$nunits}} Net</span>&nbsp;<span class='label label-inverse special ' style='border:1px solid #1f1f1f;'> {{$gunits}} Gross</span>
            @if(!empty($displaystats))<span class="commission-rate pull-right">${{$payout}}</span><br/>@endif
            {{$sales}}
             </div>
           
        	 @endforeach
          </div>


             @endif 
           </div>

           <script>
           $(document).ready(function(){

            $('.weekreport').mouseover(function(){
              $('.salesBOX').hide(200);
              $('.unitBox').hide();
            });

            $('.sortReps').click(function(){
              var type = $(this).data('type');
              console.log(type);
              $('.dealerStats').hide();
              if(type=="commission"){
                 $('.repStats .dealerStats').sort(function(a,b){
              return a.dataset.commission < b.dataset.commission
              }).appendTo('.repStats');
              } else {
                 $('.repStats .dealerStats').sort(function(a,b){
              return a.dataset.units < b.dataset.units
              }).appendTo('.repStats');
              }
              $('.dealerStats').show();
            });

            $('.dealerStats').click(function(){
              var id = $(this).data('id');
              $('.salesBOX').hide(100);
              $('.repBox-'+id).show(200);

            });

            $('.tooltwo').tooltipster();

           });
           </script>