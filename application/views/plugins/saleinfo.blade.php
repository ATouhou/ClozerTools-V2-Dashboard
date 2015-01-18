
            	        			<img src='{{URL::to('images/')}}{{$sale->typeofsale}}.png' class="system-img" style="margin-top:15px;margin-right:15px;">
                      				<div class='border-bot'>
            	        			<h3>{{$sale->lead->cust_name}} @if(!empty($sale->lead->spouse_name)) & {{$sale->lead->spouse_name}} @endif </h3>
            	        			<h4>{{$sale->lead->cust_num}}</h4>
            	        			<h5>{{$sale->lead->address}}</h5>
            	        			<br/>
            	        			<?php 
                                    	if($sale->lead->original_leadtype=="door"){$icon="cus-door";$sale->lead->original_leadtype="Door Survey";}
                                      else if($sale->lead->original_leadtype=="paper"){$icon="cus-script";$sale->lead->original_leadtype="Manilla Survey";} 
                                      else if($sale->lead->original_leadtype=="secondtier"){$icon="cus-script";$sale->lead->original_leadtype="Second Tier Survey";} 
                                      else if($sale->lead->original_leadtype=="ballot"){$icon="cus-inbox";$sale->lead->original_leadtype="Ballot Box";} 
                                      else if($sale->lead->original_leadtype=="other"){$icon="cus-zone-money";$sale->lead->original_leadtype="Scratch Card";} 
                                      else if($sale->lead->original_leadtype=="referral"){$icon="cus-user";$sale->lead->original_leadtype="Referral";} 
                                      else {$icon="";};?>
                                    	
                                    	
                                    	@if(!empty($sale->appointment->booked_by))
                                    		Booked By : <span class='label label-info special'> {{$sale->appointment->booked_by}}</span> &nbsp;&nbsp; Leadtype: <i class='{{$icon}} tooltwo' title='{{$sale->lead->original_leadtype}}'></i>&nbsp; 
            	        			@endif

            	        			@if(($sale->lead->bump_count>=1)||($sale->lead->leadtype=="rebook"))<i class='cus-arrow-redo tooltwo' title="This lead was bumped or rebooked {{$sale->lead->bump_count}} times"></i> @endif 
            	        			<br/><br/>
            	        			Called : <span class='label label-info special'> {{count($sale->lead->calls)}} Times </span><br/>
            	        			<br/>
            	        			</div>

            	        			@if(!empty($sale->lead->appointments))
            	        			<div class='border-bot'>
            	        			<h5>Appointment History</h5>
                      					@foreach($sale->lead->appointments as $v)
                      						<?php if($v->status=="DNS"){$res = 'important special blackText';} 
                      						else if($v->status=="INC"){$res = 'warning special blackText';} 
                      						else if($v->status=="CXL"){$res = 'important blackText';} 
                      						else if(($v->status=="RB-TF")||($v->status=="RB-OF")){$res = 'info special';} 
                      						elseif($v->status=="SOLD") {$res="warning special blackText";} else {$res="";};?>
                      						<span class='label label-{{$res}}'>
                      							{{$v->status}}
                      						</span> &nbsp;&nbsp;{{date('M-d',strtotime($v->app_date))}} {{date('h:i a',strtotime($v->app_time))}} 
                      						@if(!empty($v->rep_name))  &nbsp;&nbsp;|&nbsp;&nbsp; <font color=yellow>{{$v->rep_name}}</font>  @endif
                      						<div class='booker-footer'>Booked on {{date('M-d',strtotime($v->booked_at))}}  by <span>{{$v->booked_by}}</span>
                      						</div>
                      					</span><br/>
                      					@endforeach
                      				</div>
                      				<button class='btn btn-danger btn-small ' style='margin-top:10px;margin-bottom:20px;' onclick="$('.infoHover').hide(100);"><i class='cus-cancel'></i>&nbsp;Close</button>
                      				</div>
                      				@endif
