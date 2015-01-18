@layout('layouts/main')
@section('content')
      
<div id="main" role="main" class="container-fluid">
    <div class="contained">
        <!-- LEFT SIDE WIDGETS & MENU -->
        <aside> 
            @render('layouts.managernav')
       </aside>
        <!-- END WIDGETS -->
                
        <!-- MAIN CONTENT -->
        <div id="page-content" >
            <h1 id="page-header">Viewing Sale # {{$sale->id}}</h1>   
            <div class="fluid-container">
                
                <!-- widget grid 
                <section id="widget-grid" class="">
                </section>
                <!-- end widget grid -->

<div id="invoice-bar" class="btn-toolbar">
                                    <div class="btn-group">
                                        <button type="button" class="btn medium"><i class="cus-cross"></i></button>
                                        <button type="button" class="btn medium"><i class="cus-pencil"></i></button>
                                        <button type="button" id="invoice-print" class="btn medium">
                                            <i class="cus-printer"></i> Print Invoice
                                        </button>
                                    </div>
                                </div>
                                <div id="invoice-id-01" class="invoice">
                                    <div class="invoice-header" style="padding-bottom:60px;">
                                        <img src="{{URL::to('images/logo.png')}}" style="border:none;" width="300" height="300" >
                                        <div class="invoice-company-info pull-right">
                                            <strong>ADVANCED AIR SUPPLY</strong><br />
                                            #12 - 626 Esquimalt<br />
                                            Victoria, BC - V9A 3L4<br />
                                            Canada<br />
                                            Tel : 250-380-0029<br />
                                            Fax : 250-380-3841
                                        </div>
                                    </div>
                                    <div class="invoice-client-info">
                                        <div class="client-info">
                                            <h5>Sold to:</h5>
                                            {{ucfirst($sale->lead->cust_name)}}<@if(!empty($sale->lead->spouse_name)) and {{ucfirst($sale->lead->spouse_name)}} @endifbr />
                                           {{$sale->lead->address}}<br />
                                           {{$sale->lead->city}}<br />
                                            British Columbia<br />
                                            {{$sale->lead->cust_num}}<br /><br />
                                              <h5>Sold By:</h5>
                                            {{ucfirst($sale->lead->rep_name)}}<br />
                                           Pure Opportunity Level : {{User::find($sale->lead->rep)->level}}<br />
                                            
                                        </div>  
                                       
                                        <div class="invoice-info">
                                            <h3>INVOICE</h3>
                                            <ul>
                                                <li>
                                                    PAYMENT TYPE <span>{{strtoupper($sale->payment)}}</span>
                                                </li>
                                                <li>
                                                    TERMS <span>{{strtoupper($sale->deferal)}}</span>
                                                </li>
                                                <li>
                                                    Date Sold: <span>{{date('M d Y',strtotime($sale->date))}}</span>
                                                </li>
                                                <li>
                                                    Approval Date : <span>{{date('M d Y',strtotime($sale->date))}}</span>
                                                </li>
                                            </ul>
                                        </div>  
                                    </div>
                                    <div class="invoice-body">
                                        <table class="table table-striped responsive">
                                            <thead>
                                                <tr>
                                                    <th class="item">Item</th>
                                                    <th class="desc">SKU NUMBER</th>
                                                    <th class="qty">Quantity</th>
                                                    <th class="price">Price</th>
                                                    <th class="rep">Rep Payout</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $total=0;
                                                $paytotal=0;?>
                                                @foreach($sale->items as $val)
                                                  <tr>
                                                 
                                                    <td><strong>{{strtoupper($val->item_name)}}</strong></td>
                                                    <td>#{{$val->sku}}</td>
                                                    <td></td>
                                                    <td><?php if($val->item_name=="defender"){$price = 2495;$pay = $comm[0]->defendercom;} elseif($val->item_name=="majestic"){$price = 1295;$pay = $comm[0]->majesticcom;};
                                                    $total=$total+$price;
                                                    $paytotal = $paytotal+$pay;?>
                                                        ${{$price}}.00</td>
                                                    <td>x1</td>
                                                    <td>${{$pay}}.00</td>
                                                </tr>
                                                @endforeach
                                              
                                               
                                                <tr>
                                                    <td class="invoice-sub" colspan="4">Total</td>
                                                    <td><strong>${{$total}}.00</strong></td>
                                                    <td><strong>${{$paytotal}}.00</strong></td>
                                                </tr>
                                                <tr>
                                                    <td class="invoice-sub" colspan="4">HST/GST</td>
                                                    <td><strong>13%</strong></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="invoice-footer">
                                        
                                        <div class="payment-methods">
                                            <h5>Specilist Level<span class="pay" style="margin-left:50px;">Payment Method</span></h5> <img src="{{URL::to('images/level4.png')}}" width="64" height="64" alt="" />
                                            <img style="margin-left:80px;" src="{{URL::to('img/invoice/visa.png')}}" width="64" height="64" alt="" />
                                           
                                        </div>
                                        <div class="span5" style="height:100px;float:right;padding-top:20px;">
                                            @if((Auth::user()->user_type=="manager")&&($sale->status=="APPROVAL"))
                                            <button class="btn btn-default btn-large approve" style="margin-right:20px;" ><i class="cus-accept"></i>&nbsp;APPROVE THIS SALE</button>@endif
                                           Status : <span class="bignum2">
                                           @if($sale->status=="APPROVAL") 
                                           Awaiting Approval 
                                           @elseif($sale->status=="COMPLETE") 
                                           SALE PAID OUT 
                                           @elseif($sale->status=="CANCELLED") 
                                           SALE CANCELLED
                                           @endif
                                      
                                       </span>
                                           <br />
                                           
                                           <div class="invoice-sum-total">
                                            <h3>Total: ${{$total+($total*0.13)}}</h3>
                                        </div>
                                        </div>
                                         
                                    </div>
                                </div>



















            
            </div>    
            
            <!--RIGHT SIDE WIDGETS-->
        <aside class="right">
            @render('layouts.chat')
        </aside>
        <!--END RIGHT SIDE WIDGETS-->

        </div>
        <!-- end main content -->
    </div>
</div><!--end fluid-container-->
<div class="push"></div>
<script>
    
$(document).ready(function(){
$('.approve').click(function(){
var t = confirm("Are you sure you want to APPROVE this sale, and mark as PAID");
});
});
</script>

@endsection