@layout('layouts/main')
@section('content')
<style>
.boldText {color:#000;
font-weight:bolder;}
@media print {
  aside, header, .alert, .btn, #page-header{
    display:none !important;
  }
  table {
    border-bottom:1px dotted #333;
    border-top:1px dotted #333;
  }
  .invoice {
    border:none;
    margin-top:-70px;
  }
  .invoice td a {
    font-weight:normal;
  }
  .invoice-body table td, .invoice-body table th, .invoice-header, .invoice-client-info, .invoice-footer {
    padding-left:16px;
    padding-right:16px;
    font-family: 'Segoe UI', Tahoma, sans-serif !important;
  }
  .footer, .push {
    display:none;
  }
  .theaddy{display:none;}

  .invoicePage {padding-top:0px;padding:0px;}

.boldText{font-weight:normal!important;color:#aaa;}
}



</style>

<div id="main"  class="container-fluid invoicePage" style="background:white;padding:45px;padding-top:30px;padding-bottom:800px;">
	 <!-- page header -->
 
          <h1 id="page-header">Viewing Invoice #  {{$invoice->invoice_no}}</h1> 

         
          
          <div class="fluid-container">
              
            <!-- invoice -->
                <div id="invoice-bar" class="btn-toolbar">
                                    <div class="btn-group">
                                       <a href='javascript:history.back();'> <button type="button" class="btn medium"><i class="cus-cross"></i></button></a>
                                
                                        <button type="button" id="invoice-print" class="btn medium">
                                            <i class="cus-printer"></i> Print Invoice
                                        </button>
                                    </div>
                                </div>
                                <div id="invoice-id-01" class="invoice">
                               
                                  <div class="invoice-client-info">
                                    <div class="client-info" style="width:10%;">
                                       <img src='{{URL::to("images/level")}}{{$invoice->user->level}}.png' width=50px height=50px> &nbsp;&nbsp;
                                       <!--<img src='{{$invoice->user->avatar_link()}}'  width=50px height=50px>-->
                                         <br/>

                                    </div>
                     <div class="client-info" style="width:30%;">
                      <h5>Invoice From:</h5><br/>
                       <strong>{{$invoice->user->firstname}} {{$invoice->user->lastname}}</strong><br/>
                        <span class='editAddress tooltwo' title='Click to edit this users current address' id='address|{{$invoice->user->id}}'>
                        @if(!empty($invoice->user->address))
                          <?php $add = explode(",",$invoice->user->address);
                         ?>
                          {{$add[0]}}<br/>
                          @if(isset($add[1]))
                          {{$add[1]}}
                          @endif
                          @if(isset($add[2]))
                          ,{{$add[2]}}
                          @endif
                          
                        @else

                        @endif
                        </span><br/><br/>
                        @if(!empty($invoice->user->phone_no))
                        Tel : {{$invoice->user->phone_no}}<br/>
                        @endif
                         @if(!empty($invoice->user->cell_no))
                           Cell : {{$invoice->user->cell_no}}<br/>
                        @endif
                        
                      
                    </div>  
                    <div class="client-info" style="width:30%;">
                      <h5>Invoiced to:</h5><br/>
                      <?php $add2 = explode(",",Setting::find(1)->company_address);?>
                          {{$add2[0]}}<br/>
                          @if(isset($add2[1]))
                          {{$add2[1]}}
                          @endif
                          @if(isset($add2[2]))
                          ,{{$add2[2]}}
                          @endif
                    </div>  
                    <div class="invoice-info">
                      <h3>INVOICE</h3>
                      <ul>
                        <li>
                          Invoice # <span>{{$invoice->invoice_no}}</span>
                        </li>
                        <li>
                          Date Issued: <span>{{date('M d Y',strtotime($invoice->date_issued))}}</span>
                        </li>
                       
                      </ul>
                    </div>  
                                  </div>
                                  <div class="invoice-body">
                    <table class="table table-striped responsive">
                                            <thead>
                                              @if($invoice->type=="dealer")
                                                <tr>
                                                    <th class="item">Type</th>
                                                    <th>Sale #ID</th>
                                                    <th class="desc">SKUS</th>
                                                    <th class="price">Customer</th>
                                                    <th class="qtn">Deal Price</th>
                                                    <th class="sub">Payout / Commission</th>
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
                                            </thead>
                                            <tbody>
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
                                                    <td><span style="font-weight:bold;color:#000;" >{{ucfirst($val->typeofsale)}}</span></td>
                                                    <td>#{{$val->id}}</td>
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
                                                    <td><span class="boldText">{{ucfirst($val->cust_name)}}</span><br/>
                                                      <span class='theaddy'>{{$val->lead->address}}</span>

                                                    </td>
                                                  
                                                    <td>${{$val->price}}</td>
                                                    <td>
                                                    ${{$payout}}
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
                                               
                                               
                                                <tr><td></td>
                                                  
                                                    <td class="invoice-sub" colspan="4">Sub-Total</td>
                                                    <td><strong>${{$total}}</strong></td>
                                                </tr>
                                              
                                            </tbody>
                                        </table>
                                  </div>
                                  <div class="invoice-footer">
                                   <?php $tax_rate = Setting::find(1)->tax_rate;?>
                                    
                                    <div class="invoice-sum-total">
                                      @if(Setting::find(1)->invoice_tax==1)
                                      <h4>Sub Total : ${{$total}}</h4>
                                      <?php $tax = number_format(floatval($total)*(floatval($tax_rate/100)),2,'.','');?>
                                      <h5>Tax Rate : {{$tax_rate}}% | Tax $ : ${{$tax}}</h5>
                                      <h3>TOTAL OWING : ${{$total+$tax}}</h3>
                                      @else
                                      <h3>TOTAL OWING : ${{$total}}</h3>
                                      @endif
                                    </div>
                                  </div>
                                </div>
            
            <!-- end invoice -->

   
</div>

<div class="push"></div>
<script src="{{URL::to_asset('js/editable.js')}}"></script>
<script>
$(document).ready(function(){
$('#invoice-print').on('click', function() { window.print(); });

$('.editAddress').editable('{{URL::to("users/edit")}}',{
 indicator : 'Saving...',
         tooltip   : 'Click to edit...',
         width:'200',
         height:'50',
         submit  : 'OK',
});

});
</script>

@endsection