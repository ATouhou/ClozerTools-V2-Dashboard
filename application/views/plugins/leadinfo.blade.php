
            	        			
                      				<div class='border-bot'>
            	        			<h3>{{$lead->cust_name}} @if(!empty($lead->spouse_name)) & {{$lead->spouse_name}} @endif </h3>
            	        			<h4>{{$lead->cust_num}}</h4>
            	        			<h5><span class="theLeadNum">{{$lead->address}}</span></h5>
            	        			<br/>
            	        			<?php 
                              if($lead->original_leadtype=="door"){$icon="cus-door";$lead->original_leadtype="Door Survey";} 
                              elseif($lead->original_leadtype=="paper"){$icon="cus-script";$lead->original_leadtype="Manilla Survey";} 
                              elseif($lead->original_leadtype=="secondtier"){$icon="cus-script";$lead->original_leadtype="Second Tier Survey";} 
                              else if($lead->original_leadtype=="ballot"){$icon="cus-inbox";$lead->original_leadtype="Ballot Box";} 
                              else if($lead->original_leadtype=="other"){$icon="cus-zone-money";$lead->original_leadtype="Scratch Card";} 
                              else if($lead->original_leadtype=="homeshow"){$icon="cus-house";$lead->original_leadtype="Home Show";} 
                              else if($lead->original_leadtype=="referral"){$icon="cus-user";$lead->original_leadtype="Referral";} 
                               else if($lead->original_leadtype=="personal"){$icon="cus-user";$lead->original_leadtype="Personal";} 
                              else {$icon="";};?>
                              
                              <?php $lastcall = Call::where('lead_id','=',$lead->id)->order_by('created_at','ASC')->first();?>
                              @if(!empty($lastcall))
                              	Last Called By : <span class='label label-info special'> {{$lastcall->booker->firstname}} {{$lastcall->booker->lastname}} </span> &nbsp;&nbsp; Leadtype: <i class='{{$icon}} tooltwo' title='{{$lead->original_leadtype}}'></i>&nbsp; {{ucfirst($lead->original_leadtype)}}
            	        			@endif
                            <br/>
                            <br>Entered By : <span class='label label-info special'> {{$lead->researcher_name}} </span>



            	        			@if(($lead->bump_count>=1)||($lead->leadtype=="rebook"))<i class='cus-arrow-redo tooltwo' title="This lead was bumped or rebooked {{$lead->bump_count}} times"></i> @endif 
            	        			<br/><br/>
            	        			Called : <span class='label label-info special'> {{count($lead->calls)}} Times </span><br/>
            	        			<br/>
                            <font color=yellow>Booker Notes :</font> <br>
                            @if(empty($lead->notes))  No Notes Entered... @else  {{$lead->notes}}   @endif
                            <br/>
            	        			</div>
            	
                                    	

            	        	
            	        			<div >
            	        			<h5>Appointment History</h5>
                      					@foreach($lead->appointments as $v)
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
                                @if($v->status=="SOLD")
                                <a href="{{URL::to('reports/sales')}}?startdate={{$v->app_date}}&enddate={{$v->app_date}}" target=_blank class="btn btn-default">VIEW SALE # {{$v->sale_id}}</a>
                                @endif
                      					@endforeach
                      				</div>
                      				
                      				</div>
                      				
                              <button class='btn btn-danger btn-small ' style='margin-top:10px;margin-bottom:20px;' onclick="$('.infoHover').hide(100);"><i class='cus-cancel'></i>&nbsp;Close</button>&nbsp;&nbsp;
                              
                              <button class='btn btn-primary btn-small viewTheLeadButton' data-num="{{$lead->cust_num}}" style='margin-top:10px;margin-bottom:20px;'><i class='cus-eye'></i>&nbsp;View Lead</button>  
