<?php $date="";$prevdate="";?>

@if(!empty($sales))
	@foreach($sales as $s)
		<?php $date = $s->date;?>
		<?php if($prevdate!=$date){;?>
			<li class="smallListItem"><b>{{date('M-d Y',strtotime($s->date))}}</b></li>
		<?php 
			$prevdate=$date;
		};?>
		<?php if($s->typeofsale=="3maj") {$type="3 Majestics";}
		else if($s->typeofsale=="2maj"){$type="2 Majestics";}
		else if($s->typeofsale=="3defenders"){$type="3 Defenders";}
		else if($s->typeofsale=="2defenders"){$type="3 Defenders";}
		else if($s->typeofsale=="2system"){$type="2 Systems";}
		else if($s->typeofsale=="supernova"){$type="Super Nova System";}
		else if($s->typeofsale==""){$type="nomachine";}
		else {$type=ucfirst($s->typeofsale);};?>
		<?php if($s->status=="PAID" || $s->status=="COMPLETE"){$paid="";} else {$paid="viewSale";};?>
		<?php if(empty($s->payment)){$paypic = "payment-none.png";} else {$paypic="payment-".strtolower($s->payment).".png";};?>
		<li class="  {{$paid}}" data-id="{{$s->id}}"> 
			<img style='float:right;width:42px;' src='{{URL::to_asset("images/")}}pureop-small-{{$s->typeofsale}}.png'>
			<img style='float:right;width:80px;margin-right:10px;' src='{{URL::to_asset("images/")}}{{$paypic}}'>
			{{strtoupper($s->cust_name)}}<br/>
			<span style='color:#0099FF'><b>{{strtoupper($type)}}</b></span><br/>
			<span style='font-size:12px;'>Price : <b>${{$s->price}}</b></span>
			<br/><span style='font-size:12px;'>Payout : <span style='color:green'><b>${{$s->payout}}</b></span> </span> 
			<br/><br/>
			<span style='font-weight:bolder;padding:2px;' class='smallText {{$s->status}}'>{{$s->status}}</span> 
			@if($s->pay_type!="CHEQUE" && $s->pay_type!="CASH" && $s->pay_type!="CREDITCARD")
			<br/>
			<span style='float:right;font-size:10px;'><b>Interest : </b>{{$s->interest_rate}}%</span>
			@endif 
			@if($s->deferal!='NA')
			<br/>
			<span style='float:right;font-size:10px;'><b>Deferal : </b>{{$s->deferal}}</span>
			@endif
			<!---<button class='button uploadDocs'>Upload Docs</button>
			<br/>
			<span class='{{$s->status}}' style='float:right;'>{{$s->status}}</span>
			-->
		</li>
	@endforeach
@else
<br/><br/><br/><center><h2>NO {{strtoupper($type)}} DEALS FOUND</h2>
@endif
