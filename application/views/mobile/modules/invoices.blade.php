<?php $date="";$prevdate="";?>

@if(!empty($invoices))
	@foreach($invoices as $inv)
		
	<li class="invoice-{{$inv->id}} smallListItem">Issued : <b>{{date('M-d Y',strtotime($inv->date_issued))}}</b>

		@if($inv->status=="unpaid")
		<button class='button deleteInvoice' style='float:right;padding:3px;margin-top:-3px;color:white;background:red;' data-id='{{$inv->id}}'>DELETE</button>
		@endif
		<button class='button viewInvoice' style='float:right;padding:3px;margin-right:4px;margin-top:-3px;' data-id='{{$inv->id}}'>VIEW</button>
	</li>
		<li class="invoice-{{$inv->id}}" data-id="{{$inv->id}}" style='height:160px;'> 
			Invoice# - {{strtoupper($inv->invoice_no)}}<br/>
			<span style='float:right;'>{{$inv->amount}}</span>
			<span style='color:#0099FF'><b>{{strtoupper($inv->status)}}</b></span><br/>
			@if($inv->status=="paid")
			<span style='font-size:11px;'>Paid On - <b>{{date('M-d',strtotime($inv->date_paid))}}</b></span><br/>
				@if(!empty($inv->cheque_no))
					<span style='font-size:11px;'>Pay Info - <b> {{strtoupper($inv->cheque_no)}}</b></span><br/>
				@endif
			@endif
			<br/>
			<span class='smallText'>Sales on Invoice : </span><br/>
			@if(!empty($inv->sale))
				@foreach($inv->sale as $s)
				@if($inv->status!='paid')
				<button class='salePic-{{$s->id}} smallButton removeDeal' data-id='{{$s->id}}'>
					<img style='float:left;width:22px;' src='{{URL::to_asset("images/")}}pureop-small-{{$s->typeofsale}}.png'>
				</button>
				@else
					<img style='float:left;width:22px;' src='{{URL::to_asset("images/")}}pureop-small-{{$s->typeofsale}}.png'>
				@endif
				@endforeach
			@endif
			<br/>
			@if($inv->status!='paid')
				<button class='addDeals button' data-id='{{$inv->id}}' style='padding:4px;border:1px solid #ccc;margin-bottom:10px;'>ADD SALES TO INVOICE</button>
			@endif
		</li>
	@endforeach

@else
<br/><br/><br/><center><h2>NO INVOICES FOUND</h2>
@endif
