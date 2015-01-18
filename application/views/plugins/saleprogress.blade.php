<?php 
                                 $progress=0;
                                 $t1=0;$t2=0;$t3=0;$t4=0;$t5=0;$t6=0;$t7=0;
                                 if(!empty($sale->payment)){$progress++; $t1=1;}
                                 if((!empty($sale->defone))||(!empty($sale->deftwo))||(!empty($sale->maj))||(!empty($sale->att))){$progress++;$t2=1;}
                                 
                                 if(($sale->payout!="0.00")){$progress++;$t3=1;}
                                 if(($sale->payout=="0.00")&&($sale->ridealong_payout!="0.00")){$progress++;$t3=1;}
                                 
                                 if((!empty($sale->docs))||($sale->conf==1)){$progress++;$t4=1;}
                     if($sale->funded==1){$progress++; $t5=1;}
                                 if(!empty($sale->invoice)){$progress++;$t6=1;}
                     if((!empty($sale->invoice))&&($sale->invoice->status=="paid")){$progress++;$t7=1;};
            
                     
                     $p="progress-success active";
                     if($progress<=1){$p = "progress-danger active";} 
                     if($progress<=2){$p = "progress-warning active";} 
                     if(($progress>2)&&($progress<=4)){$p = "active";} 
                     $progress=floor((($progress/7)*100));
                     ?>
                        

                                 <h5>This deal is {{$progress}}% complete</h5>
                      				<div class="progress {{$p}} progress-striped" style="width:90%;height:40px;">
                                                <div class="bar" style="width: {{$progress}}%; "></div>
                                          </div>
                                          
                                          <h5>Payment Method Entered : @if($t1==1)<i class='cus-accept'> @else <i class='cus-cancel'> @endif </i></h5>
                                          <h5>Serial Numbers Entered : @if($t2==1)<i class='cus-accept'> @else <i class='cus-cancel'> @endif </i></h5>
                                          <h5>Commission Entered : @if($t3==1)<i class='cus-accept'> @else <i class='cus-cancel'> @endif </i></h5>
                                          <h5>Documentation Received : @if($t4==1)<i class='cus-accept'> @else <i class='cus-cancel'> @endif </i></h5>
                                          <h5>Payment Accepted / Deal Funded : @if($t5==1)<i class='cus-accept'> @else <i class='cus-cancel'> @endif </i></h5>
                                          <h5>Invoice Issued By Dealer : @if($t6==1)<i class='cus-accept'> @else <i class='cus-cancel'> @endif </i></h5>
                                          <h5>Invoice Paid / Deal Complete : @if($t7==1)<i class='cus-accept'> @else <i class='cus-cancel'> @endif </i></h5>
                                             <button class='btn btn-danger btn-small ' style='margin-top:10px;margin-bottom:20px;' onclick="$('.infoHover').hide(100);"><i class='cus-cancel'></i>&nbsp;Close</button>
                           			