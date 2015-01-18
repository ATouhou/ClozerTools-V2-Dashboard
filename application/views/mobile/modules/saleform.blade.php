<h2 style="margin-top:10px;">{{$sale->cust_name}}</h2>
<p style="margin-top:-10px;">{{$sale->lead->address}}</p>
<br/>
<hr>
<form id="saleForm" method="POST" action="">
	<input type="hidden" id="sale_id" name="sale_id" value="{{$sale->id}}"/>
	<br/>
	Type Of System Sold : <br/>
	<div>
	<img id="systemType" src='{{URL::to_asset("images/")}}pureop-small-{{strtolower($sale->typeofsale)}}.png' style='margin-left:20px;margin-top:0px;width:15%'> 
	<select id="typeofsystem" name="typeofsystem" style="width:55%;float:left;" >
      
	    <option value='defender' @if($sale->typeofsale=="defender") selected="selected" @endif>DEFENDER</option>
	    <option value='majestic'  @if($sale->typeofsale=="majestic") selected="selected" @endif>MAJESTIC</option>
	    <option value='system'  @if($sale->typeofsale=="system") selected="selected" @endif>SYSTEM</option>
	    <option value='supersystem'  @if($sale->typeofsale=="supersystem") selected="selected" @endif>SUPER SYSTEM</option>
	    <option value='megasystem'  @if($sale->typeofsale=="megasystem") selected="selected" @endif>MEGA SYSTEM</option>
	    <option value='novasystem'  @if($sale->typeofsale=="novasystem") selected="selected" @endif>NOVA SYSTEM</option>
      <option value='supernova'  @if($sale->typeofsale=="supernova") selected="selected" @endif>SUPERNOVA SYSTEM</option>
	    <option value='2defenders'  @if($sale->typeofsale=="2defenders") selected="selected" @endif>2 DEFENDERS</option>
	    <option value='3defenders'  @if($sale->typeofsale=="3defenders") selected="selected" @endif>3 DEFENDERS</option>
	    <option value='2maj'  @if($sale->typeofsale=="2maj") selected="selected" @endif>2 MAJESTICS</option>
	    <option value='3maj'  @if($sale->typeofsale=="3maj") selected="selected" @endif>3 MAJESTICS</option>
       <option value='2system'  @if($sale->typeofsale=="2system") selected="selected" @endif>2 SYSTEMS</option>
    </select>
	</div>
    <br/>
    Payment Type : <br/>
    <div>
      <?php if(empty($sale->payment)){$paypic = "payment-none.png";} else {$paypic="payment-".strtolower($sale->payment).".png";};

      $pay_types = Sale::paymentTypes();

      ?>
    <img id="paymentMethod" src='{{URL::to_asset("images/")}}{{$paypic}}' style='margin-left:10px;margin-top:0px;width:30%;'> 
    <select id="methodofpay" name="methodofpay" style="width:55%;float:left;" >
          <option value='' @if(empty($sale->payment)) selected="selected" @endif>None</option>
          @if(!empty($pay_types))
            @foreach($pay_types as $k=>$pay)
            <option value='{{$k}}' @if($sale->payment==$k) selected="selected" @endif> {{$pay}}</option>
            @endforeach 
          @endif
    </select>
	</div>
	<?php if($sale->payment!="CASH" && $sale->payment!="CHQ" && $sale->payment!="AMEX" && $sale->payment!="VISA" && $sale->payment!="MasterCard"){$hide="";} else {$hide="display:none";};?>
	<div id="interest" class="animated fadeInUp" style="{{$hide}};border:1px solid #bbb;background:#eee;padding:15px;border-radius:5px;width:90%;margin-top:10px;">
		
    Interest Rate :<br/>
      <select name="interest" id="interest">
          @if(Setting::find(1)->shortcode=="putk")
          <option value="9.95" @if($sale->interest_rate=="9.95") selected="selected" @endif>9.95%</option>
          @endif
          <option value="19.95" @if($sale->interest_rate=="19.95") selected="selected" @endif>19.95%</option>
          <option value="29.90" @if($sale->interest_rate=="29.90") selected="selected" @endif>29.90%</options>
      </select><br/>
    <!--Term : <br/>
    <select name="term" id="term">
        <option value="6" @if($sale->interest_rate=="9.95") selected="selected" @endif>6 Months</option>
        <option value="12">12 Months</options>
        <option value="18">18 Months</options>
        <option value="24">24 Months</options>
        <option value="30">30 Months</options>
        <option value="36">36 Months</options>
        <option value="42" >42 Months</options>
        <option value="48" selected='selected'>48 Months</options>  
        <option value="54">54 Months</options>
        <option value="60" >60 Months</options>       
    </select>-->
	</div>
    <br/>
    Price :<br/>
    <input type="text" name="sale_price" id="sale_price" value="{{$sale->price}}" placeholder="Enter retail price of this sale"/>
    
    <br/>
    Down Payment : <br/>
    <input type="text" name="down_pay" id="down_pay" value="{{$sale->down_payment}}"/>
      <label for="deferal">Deferal</label>
      <select id="deferal" name="deferal" >
          <option value='NA' @if($sale->deferal=="NA") selected="selected" @endif>Not Applicable</option>
          <option value='30day'  @if($sale->deferal=="30day") selected="selected" @endif>30 Day</option>
          <option value='3month'  @if($sale->deferal=="3month") selected="selected" @endif>3 Month</option>
          <option value='6month'  @if($sale->deferal=="6month") selected="selected" @endif>6 Month</option>
      </select>
    <br/>





</form>
