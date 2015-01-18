 <form method="POST" action="{{ URL::to('sales/createinvoice') }}" id="invoiceForm">
  <input type="hidden" id="the-rep" name="the-rep" value="{{Auth::user()->id}}"/>
  
  <div class='newinvoice-form salesrep-form' >
  	@if(empty($invoice))
  	<input type="hidden" id="the-invoice" name="the-invoice" value="0">
  	 <h4 style='margin-top:4px;'>Select the Deals for this New Invoice</h4>
     <p style='color:red;'>If it is greyed out, the deal has not yet been funded and cannot be submitted</p>
  	@else
  	<input type="hidden" id="the-invoice" name="the-invoice" value="{{$invoice->id}}">
  	 <h4 style='margin-top:4px;'>Add Deals to Invoice #{{$invoice->invoice_no}} </h4>
  	@endif
   
    @for($v=0;$v<7;$v++)
    <p class='smallText' style='margin-bottom:-2px;'>Add Sale to Invoice</p>
     <select data-pay='0' id="selectdeal-{{$v}}" class='selectdeal' name="deals[]" style="width:100%;margin-bottom:-9px;">
      <option class='filter' value=''></option>
    @if(!empty($sales))
    @foreach($sales as $val)
    @if($val->funded==1 && $val->status=="COMPLETE")
    <option class='selectdeal-opt' data-user='{{$val->user_id}}' data-payout='{{$val->payout}}' value='{{$val->id}}'># {{$val->id}} | {{strtoupper($val->typeofsale)}} | {{strtoupper($val->cust_name)}} </option>
    @else
    <option class='selectdeal-opt' data-user='{{$val->user_id}}' data-payout='{{$val->payout}}' value='{{$val->id}}' disabled># {{$val->id}} | {{strtoupper($val->typeofsale)}} | {{strtoupper($val->cust_name)}} </option>
    @endif
    @endforeach
    @endif
    </select>
    @endfor
  </div>

    </form>
    
  </div>
 
</div>
