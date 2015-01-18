
                                          <?php $tax = Setting::find(1)->tax_rate;?>
                                          @if(!empty($sale->invoice))
                                          <?php $total=0;?>
            	        			@if(!empty($sale->invoice->sale))
            	        			@foreach($sale->invoice->sale as $v)
            	        					@if($v->ridealong_id==$sale->invoice->user_id)
            	        					<?php $total = $total+$v->ridealong_payout;?>
            	        					@else
            	        					<?php $total = $total+$v->payout;?>
            	        					@endif
            	        				@endforeach
            	        			<h3>Dealer : {{$sale->invoice->user->firstname}} {{$sale->invoice->user->lastname}}</h3>
            	        			<a href="{{URL::to('sales/invoice')}}/?rep={{$sale->invoice->user_id}}"><button class='btn btn-default btn-mini'>View all {{$sale->invoice->user->firstname}}'s Invoices</button></a><br/>
            	        			@if(Setting::find(1)->invoice_tax==1)
                                          <h4>Sub Total : ${{$total}} &nbsp;&nbsp;
            	        			<?php $tax = number_format(floatval($total)*(floatval($tax/100)),2,'.','');?>
                                          Tax : ${{$tax}}</h4>
                                          <h4><span class='label label-warning special' style='color:#000;font-size:20px;padding:10px;'>TOTAL : ${{$total+$tax}}</span></h4>
                                          @else
                                          <h4><span class='label label-warning special' style='color:#000;font-size:20px;padding:10px;'>TOTAL : ${{$total}}</span></h4>
                                          @endif
                                          <h4>Date : {{$sale->invoice->date_issued}}</h4>
            	        			<h5>Invoice No : {{$sale->invoice->invoice_no}} </h5>
            	        			@if($sale->invoice->status=="paid")
            	        				<?php $paid = "success special blackText";?>
            	        			@else
            	        				<?php $paid = "important special blackText ";?>
            	        			@endif
            	        			<h5>Status : <span class='label label-{{$paid}}'>{{ucfirst($sale->invoice->status)}}</span>  @if(!empty($sale->invoice->cheque_no)) &nbsp;&nbsp;|&nbsp;&nbsp; Payment # : {{$sale->invoice->cheque_no}} @endif
            	        			<br/><span  style='color:yellow;font-size:12px;'><br/>You can adjust each sales commission, by clicking on it below</span>
            	        			<div class='well infoWindow'>
            	        				<table class='table table-condensed'>
            	        					<tr>
            	        						<th>Sale</th>
            	        						<th>Date</th>
            	        						<th>Type</th>
            	        						<th>Commission</th>
            	        					</tr>

            	        				@foreach($sale->invoice->sale as $v)
            	        						<tr>
	            	        						<td>{{$v->id}}</td>
	            	        						<td>{{date('M-d',strtotime($v->date))}}</td>
	            	        						<td>{{ucfirst($v->typeofsale)}}</td>
	            	        						@if($v->ridealong_id==$sale->invoice->user_id)
	            	        						<td><span class='edit tooltwo' title='Click to edit Ridealong payout' id='ridealong_payout|{{$v->id}}'>{{ucfirst($v->ridealong_payout)}}</span></td>
	            	        						@else 
	            	        						<td><span class='edit tooltwo' title='Click to edit Commission payout on this sale' id='payout|{{$v->id}}'>{{ucfirst($v->payout)}}</span></td>
	            	        						@endif
	            	        					</tr>
            	        				@endforeach
            	        				</table>
            	        				<br/>
            	        				<a href='{{URL::to("sales/viewinvoice/")}}{{$sale->invoice->id}}' class='btn btn-primary btn-small'><i class='cus-doc-pdf'></i>&nbsp;&nbsp;View / Print Invoice</a>
            	        				
            	        				<button class='btn btn-danger btn-small ' onclick="$('.infoHover').hide(100);"><i class='cus-cancel'></i>&nbsp;Close</button>
            	        			@endif
            	        			</div>
            	        			@endif
                                          <script>
                                          $(document).ready(function(){
                                                $('.edit').editable('{{URL::to("sales/edit")}}',{
                                                      submit:'OK',
                                                      indicator : 'Saving...',
                                                      width:'100px',
                                                      placeholder:".................."
                                                });
                                          });

                                          $('.tooltwo').tooltipster();

                                          </script>