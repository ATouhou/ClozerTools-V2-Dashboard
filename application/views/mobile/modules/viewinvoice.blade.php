<br/><br/>
<?php $tax_rate = Setting::find(1)->tax_rate;?>
<div style='width:46%;float:left;'>
  <h5>INVOICE FROM : </h5>
    <b style='font-size:12px;'> {{$invoice->user->firstname}} {{$invoice->user->lastname}}</b>
    <br/>
    <span class='smallText'>
    @if(!empty($invoice->user->phone_no))
    Tel : {{$invoice->user->phone_no}}<br/>
    @endif
      @if(!empty($invoice->user->cell_no))
        Cell : {{$invoice->user->cell_no}}<br/>
    @endif
    </span>
</div>
<div style='width:46%;float:left;'>
  <h5>INVOICE TO :</h5>
  <b style='font-size:12px;'>{{str_replace(' - Rep Dashboard','',Setting::find(1)->title)}}</b><br/>
  <span class='smallText'>
    <?php $add2 = explode(",",Setting::find(1)->company_address);?>
     {{$add2[0]}}<br/>
     {{$add2[1]}},{{$add2[2]}}
  </span>
              
</div>
<br/><br/><br/><br/>
<ul style="margin-top:20px;">
  <li>
    Invoice # <span><b>{{$invoice->invoice_no}}</b></span>
  </li>
  <li>
    Date Issued: <span>{{date('M d Y',strtotime($invoice->date_issued))}}</span>
  </li>
  <li>
    Status : <b>{{strtoupper($invoice->status)}}</b>
  </li>
 
</ul>
       
                                

                                              <table class="smallTable" style="margin-top:10px;">
                                              @if($invoice->type=="dealer")
                                                <tr>
                                                    <th class="item">SALE</th>
                                                    <th class="desc">SKUS</th>
                                                    <th class="sub">Price / Payout</th>
                                                </tr>
                                                @else
                                                <tr>
                                                    <th class="item">Invoice Period</th>
                                                    <th class="desc">Valid Leads</th>
                                                    <th class="price">Wrong #</th>
                                                    <th></th>
                                                    <th></th>
                                                    <th class="sub">Payout / Commission</th>
                                                </tr>
                                                @endif
                                              <?php $total = 0;?>
                                              @if(!empty($invoice->sale))
                                              @foreach($invoice->sale as $val)
                                              <?php 
                                              if($invoice->user_id==$val->user_id) {$payout = $val->payout;}
                                              elseif($invoice->user_id==$val->ridealong_id) {$payout = $val->ridealong_payout;}
                                              else {$payout = 0;}
                                              if($payout!=0) {$total = $total+$payout;} else {$total=0;}
                                              
                                              ?>
                                              @if($invoice->type=="dealer")
                                               <tr>
                                                  <td colspan=4>
                                                   <b style='font-size:12px;'>{{ucfirst($val->cust_name)}}</b><br/>
                                                   {{$val->lead->address}}
                                                  </td>
                                                </tr>
                                               <tr>
                                                    <td><span style="font-weight:bold;color:#000;" >{{ucfirst($val->typeofsale)}}</span><br/>
                                                      Sale #{{$val->id}}
                                                    </td>
                                                    <td>
                                                      @if(!empty($val->defone))
                                                      <?php $t = Inventory::find($val->defone);?>
                                                      #{{$t->sku}} |  {{ucfirst($t->item_name)}}<br/>
                                                      @endif

                                                       @if(!empty($val->deftwo))
                                                     <?php $t = Inventory::find($val->deftwo);?>
                                                      #{{$t->sku}} |  {{ucfirst($t->item_name)}}<br/>
                                                      @endif

                                                       @if(!empty($val->defthree))
                                                      <?php $t = Inventory::find($val->defthree);?>
                                                      #{{$t->sku}} |  {{ucfirst($t->item_name)}}<br/>
                                                      @endif

                                                       @if(!empty($val->deffour))
                                                      <?php $t = Inventory::find($val->deffour);?>
                                                      #{{$t->sku}} |  {{ucfirst($t->item_name)}}<br/>
                                                      @endif

                                                       @if(!empty($val->att))
                                                      <?php $t = Inventory::find($val->att);?>
                                                      #{{$t->sku}} |  {{ucfirst($t->item_name)}}<br/>
                                                      @endif

                                                       @if(!empty($val->maj))
                                                      <?php $t = Inventory::find($val->maj);?>
                                                      #{{$t->sku}} |  {{ucfirst($t->item_name)}}<br/>
                                                      @endif
                                                    </td>
                                                    <td>Price : ${{$val->price}}
                                                      <br/> Payout : {{$payout}}
                                                    </td>
                                                   
                                                </tr>

                                                @else
                                                <tr>
                                                 
                                                  <?php $total = $invoice->amount;?>
                                               
                                                  <td><span style="font-weight:bold;color:#000;" >{{date('M-d',strtotime($invoice->startdate))}} - {{date('M-d',strtotime($invoice->enddate))}}</span></td>
                                                  <td>{{$invoice->valid}}</td>
                                                  <td>{{$invoice->invalid}}</td>
                                                  <td></td>
                                                  <td></td>
                                                  <td>${{$invoice->amount}}</td>
                                                </tr>
                                                @endif
                                              @endforeach
                                              @endif

                                              @if(Setting::find(1)->invoice_tax==1)
                                                <tr>
                                                  <td></td>
                                                  <td >Sub Total</td>
                                                  <td><strong>${{$total}}</strong></td>
                                                </tr>
                                                <tr>
                                                  <td></td>
                                                  <td >Tax &nbsp;&nbsp;&nbsp; <span style='font-size:9px;'>(Rate : {{$tax_rate}}%)</span></td>
                                                  <td><strong>${{floatval($total)*floatval($tax_rate/100)}}</strong></td>
                                                </tr>
                                                <tr>
                                                  <td></td>
                                                  <td >TOTAL</td>
                                                  <td><strong>${{$total+(floatval($total)*floatval($tax_rate/100))}}</strong></td>
                                                </tr>
                                                @else
                                                <tr>
                                                  <td></td>
                                                  <td >TOTAL</td>
                                                  <td><strong>${{$total}}</strong></td>
                                                </tr>
                                                @endif
                                        </table>
                                
                                
                                      <br/><br/><br/>
                                      @if(Setting::find(1)->invoice_tax==1)
                                      <h3>Total Owed: $ {{$total+(floatval($total)*floatval($tax_rate/100))}}</h3>
                                      @else
                                       <h3>Total Owed: $ {{$total}}</h3>
                                      @endif
                                  
                  