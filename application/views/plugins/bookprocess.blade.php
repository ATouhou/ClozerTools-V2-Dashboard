

<div class="row-fluid">
	<h2>{{strtoupper($lead->cust_name)}} @if(!empty($lead->spouse_name)) & {{strtoupper($lead->spouse_name)}}@endif @ {{$lead->cust_num}}</h2>

<div class="span6">
<?php if($lead->original_leadtype=="door"){$icon="cus-door";$lead->original_leadtype="Door Survey";} 
elseif($lead->original_leadtype=="paper"){$icon="cus-script";$lead->original_leadtype="Manilla Survey";} 
elseif($lead->original_leadtype=="secondtier"){$icon="cus-script";$lead->original_leadtype="Second Tier Survey";} 
else if($lead->original_leadtype=="ballot"){$icon="cus-inbox";$lead->original_leadtype="Ballot Box";} else if($lead->original_leadtype=="other"){$icon="cus-zone-money";$lead->original_leadtype="Scratch Card";} 
	else if($lead->original_leadtype=="homeshow"){$icon="cus-house";$lead->original_leadtype="Home Show";} 
	else if($lead->original_leadtype=="referral"){$icon="cus-user";$lead->original_leadtype="Referral";} else {$icon="";};?>
                                    	
<?php $lastcall = Call::where('lead_id','=',$lead->id)->order_by('created_at','ASC')->first();?>
@if(!empty($lastcall))
Last Called By : <span class='label label-info special'> {{$lastcall->booker->firstname}} {{$lastcall->booker->lastname}} </span> 
&nbsp;&nbsp; Leadtype: <i class='{{$icon}} tooltwo' title='{{$lead->original_leadtype}}'></i>&nbsp; 
@endif
Entered By : <span class='label label-info special'> {{$lead->researcher_name}} </span>



            	        			@if(($lead->bump_count>=1)||($lead->leadtype=="rebook"))<i class='cus-arrow-redo tooltwo' title="This lead was bumped or rebooked {{$lead->bump_count}} times"></i> @endif 
            	        			@if(Auth::user()->call_details==0)
            	        			<br/>
            	        			Called : <span class='label label-info special'> {{count($lead->calls)}} Times </span><br/>
            	        			<br/>
            	        			@endif
                           			<?php $dns=0;?>
            	        			@if(!empty($lead->appointments))
            	        			<h5>Appointment History</h5>
            	        			
                      					@foreach($lead->appointments as $v)
                      					<?php if($v->status=="DNS"){$dns=1;}else if($v->status=="SOLD"){$dns=2;};?>
                      					<div style="width:70%;background:#ccc;padding:8px;margin-bottom:5px;">
                      						<?php if($v->status=="DNS"){$res = 'important special blackText';} 
                      						else if($v->status=="INC"){$res = 'warning special blackText';} 
                      						else if($v->status=="CXL"){$res = 'important blackText';} 
                      						else if(($v->status=="RB-TF")||($v->status=="RB-OF")){$res = 'info special';} 
                      						elseif($v->status=="SOLD") {$res="warning special blackText";} else {$res="";};?>
                      						<span class='label label-{{$res}}'>
                      							{{$v->status}}
                      						</span> &nbsp;&nbsp;{{date('M-d',strtotime($v->app_date))}} {{date('h:i a',strtotime($v->app_time))}} 
                      						 | <font color=black>{{$v->booked_by}}</font>
                      						<button class='pull-right btn btn-default btn-mini'>VIEW</button>
                      						@if(!empty($v->rep_name))  &nbsp;&nbsp;|&nbsp;&nbsp; <font color=black>{{$v->rep_name}}</font>  @endif
                      						
                      					</span><br/>
                      					</div>
                      					@endforeach
                      				
                      				@endif

<br/><br/>

@if($dns==0)
<h4>Update this leads Status</h4>
<form id="book-process-form">

						<div class="control-group">
							<label class="control-label">PICK A STATUS</label>
                             @if($errors->has('status')) <span class="label label-important special">{{$errors->first('status')}}</span> @endif
                             <input type="hidden" id="leadid" name="leadid" value="{{$lead->id}}">
                             <input type="hidden" id="leadid" name="json_form" value="true">
								<div class="controls">
									<div class="btn-group" data-toggle="buttons-radio">
										
										<button type="button" class="btn btn-small process @if((isset($lead->status))&&($lead->status=="NH")) active @endif" data-status="NH"><i class="cus-house"></i>&nbsp;NH</button>
										<button type="button" class="btn btn-small process @if((isset($lead->status))&&($lead->status=="NI")) active @endif" data-status="NI"><i class="cus-cross"></i>&nbsp;NI</button>
										<button type="button" class="btn btn-small process RCBUT @if((isset($lead->status))&&($lead->status=="Recall")) active @endif" data-status="Recall"><i class="cus-arrow-redo"></i>&nbsp;RECALL</button>
										<button type="button" class="btn btn-small process @if((isset($lead->status))&&($lead->status=="WrongNumber")) active @endif" data-status="WrongNumber"><i class="cus-disconnect"></i>&nbsp;WRONG NUM</button>
			                            <button type="button" class="btn btn-small process @if((isset($lead->status))&&($lead->status=="DNC")) active @endif" data-status="DNC"><i class="cus-delete"></i>&nbsp;DNC</button>
			                            <button type="button" class="btn btn-small process @if((isset($lead->status))&&($lead->status=="NQ")) active @endif" data-status="NQ"><i class="cus-delete"></i>&nbsp;NQ</button>
			                            <button type="button" class="btn btn-small process APPBUT @if((isset($lead->status))&&($lead->status=="APP")) active @endif " data-status="APP"><i class="cus-clock"></i>&nbsp;APP</button>
                                        <input type="hidden" id="status" name="status" value="donotchange" />
			                        </div>
								</div>
						</div>

					<div class="bookdemo" style="display:none;margin-top:30px;">
						
				
						<div class="control-group" >
							<label class="control-label">Date for Appointment</label>
								<div class="controls">
								 
										<input class="datepicker-input" size="16" id="appdate" name="appdate" type="text" value="{{date('Y-m-d')}}" />
										
									
								</div><br/>
                            <label class="control-label">Pick an Appointment Time</label>
                            <input id="booktimepicker" name="booktimepicker" type="text"  placeholder="Select Time..." style="width:10%;"  />
						</div>
						
					</div>
					<div class="controls" id="recallbox" style="margin-top:8px;display:none"><br/>
						Date for Recall<br/>
						
							<input class="datepicker-input" size="16" id="recalldate" name="recalldate" type="text" value="{{date('Y-m-d')}}"  />
						
					</div>
				</form>
				@endif
</div>




<div class="span5" style="margin-top:-40px;">
	&nbsp;<button class='btn btn-mini revealScript' data-id="booking">BOOKING SCRIPT</button>
	&nbsp;<button class='btn btn-mini revealScript' data-id="confirmation">CONFIRMATION SCRIPT</button>
	&nbsp;<button class='btn btn-mini revealScript' data-id="homeshow">HOMESHOW SCRIPT</button><br/>
	&nbsp;<button class='btn btn-mini revealScript' style="margin-top:10px;" data-id="finalnotice">FINAL NOTICE</button>
	&nbsp;<button class='btn btn-mini revealScript' style="margin-top:10px;" data-id="rebook">REBOOK SCRIPT</button><br/><br/>
<div class="script well animated fadeInUp hide" id="script-booking" style="display:block;height:300px;overflow:scroll">
		{{$script['booking']}}
	</div>
	<div class="script well animated fadeInUp hide" id="script-rebook" style="height:280px;overflow:scroll">
		{{$script['rebook']}}
	</div>
	<div class="script well animated fadeInUp hide" id="script-homeshow" style="height:280px;overflow:scroll">
		{{$script['homeshow']}}
	</div>
	<div class="script well animated fadeInUp hide" id="script-confirmation" style="height:280px;overflow:scroll">
		{{$script['confirmation']}}
	</div>
	<div class="script well animated fadeInUp hide" id="script-finalnotice" style="height:280px;overflow:scroll">
		{{$script['finalnotice']}}
	</div>
</div>

<script>
$(document).ready(function(){


    $("#booktimepicker").timePicker({
    startTime: "10:00", // Using string. Can take string or Date object.
  endTime: new Date(0, 0, 0, 23, 30, 0), // Using Date object here.
  show24Hours: false,
  step: 15});



$('.process').click(function(){
var sts = $(this).data('status');
$('input#status').val(sts);
$('.bookdemo').hide();
$('#recallbox').hide();
});

$('.APPBUT').click(function(){
$('.bookdemo').toggle(300);
});


$('.RCBUT').click(function(){
$('#recallbox').toggle(300);
});





});
    
</script>