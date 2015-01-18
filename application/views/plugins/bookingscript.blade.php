<style>
.edit {cursor:pointer;}
.edit-house {cursor:pointer;}
.edit-fullpart {cursor:pointer;}
.timer {font-size:24px;color:yellow;}
</style>

@if(!empty($singlelead))
<?php $obj = Script::where('type','=','objection')->get();?>
<?php  $rightaways = City::where('status','=','active')->get(array('id','cityname','rightaway'));
?>

<div class='vacationList animated fadeInUp '  >

<img onclick="$('.vacationList').hide(300);" src='{{URL::to_asset("images/vacationlist.jpg")}}'>
</div>

@if(!empty($obj))
@foreach($obj as $val)
<div class="objectionBox animated fadeInUp alert span5 {{$val->type}}-{{$val->id}}">
	<h3>{{$val->title}}</h3>
	<br><p>{{$val->script}}</p>
	<br><br>
	<button class="btn btn-primary btn-large closeObjection"><i class="cus-cancel"></i>&nbsp;&nbsp;CLOSE OBJECTION</button>
</div>
@endforeach
@endif

<?php 
			$city = $singlelead->city;
			if($singlelead->leadtype=="rebook"){$type = "rebook";} else if($singlelead->leadtype=="paper" || $singlelead->leadtype=="secondtier"){$type = "booking";} else if($singlelead->leadtype=="door"){$type="door";} 
			else if($singlelead->leadtype=="ballot"){$type="ballot";$city="ballot";} else if($singlelead->leadtype=="homeshow"){$type="homeshow";$city="homeshow";} else if($singlelead->leadtype=="finalnotice"){$type="finalnotice";} 
			else if($singlelead->leadtype=="referral"){$type="referral";}else {$type="booking";};?>
			<?php if($singlelead->leadtype=="rebook"){
				$appdate = Appointment::where('lead_id','=',$singlelead->id)->order_by('app_date','DESC')->first();
			};
			 if($singlelead->original_leadtype=="door"){$icon="cus-door";$singlelead->original_leadtype="Door Survey";} 
			 elseif($singlelead->original_leadtype=="paper"){$icon="cus-script";$singlelead->original_leadtype="Manilla Survey";} 
			 elseif($singlelead->original_leadtype=="secondtier"){$icon="cus-script";$singlelead->original_leadtype="Second Tier Survey";} 
			 else if($singlelead->original_leadtype=="homeshow"){$icon="cus-house";$singlelead->original_leadtype="Homeshow";} else if($singlelead->original_leadtype=="ballot"){$icon="cus-inbox";$singlelead->original_leadtype="Ballot Box";} else if($singlelead->original_leadtype=="other"){$icon="cus-zone-money";$singlelead->original_leadtype="Scratch Card";} else {$icon="";};
			
			$gifts = City::where('cityname','=',$city)->first();
			if(!empty($gifts)){
				$script = Script::where('type','=',$type)->where('batch_id','=',$gifts->script_batch)->first();
			 	$arr = array($gifts->gift_one,$gifts->gift_two,$gifts->gift_three,$gifts->gift_four);
			 } else {
			 	$script = Script::where('type','=',$type)->first();
			 	$arr = array();
			 }
			 
			if(empty($singlelead->address)){$address="No Address On File....ENTER ONE ABOVE";} else {$address = $singlelead->address.", ".$singlelead->city;}
			$s = str_replace("[[NAME]]","<strong><span class='scriptval-booker_name'>".Auth::user()->firstname."</span></strong>",$script->script);
			$s = str_replace("[[CUSTNAME]]","<strong><span class='scriptval-cust_name'>".$singlelead->cust_name."</span></strong>",$s);
			$s = str_replace("[[SPOUSENAME]]","<strong><span class='scriptval-spouse_name'>".$singlelead->spouse_name."</span></strong>",$s);
			$s = str_replace("[[ADDRESS]]","<span class='label label-info special'><span class='scriptval-address'>".$address."</span></span><br><br>",$s);
			$s = str_replace("[[CHOSEN-GIFT]]","<span class='label label-info special'><span class='scriptval-gift'>".$singlelead->gift."</span></span><br><br>",$s);
			$g = "";$c=0;
			
			foreach($arr as $val){
				$c++;
				
				switch ($c) {
    				case 1:
        				$t="first";
        				break;
   				case 2:
       				$t="second";
        				break;
    				case 3:
        				$t="third";
        				break;
        			case 4:
        				$t="fourth";
        				break;
				}
				 
				$thegift = Gift::find($val);
				if($thegift){
				$g.="The ".$t." option is the <strong> ".$thegift->name."</strong> <br/><br/>".$thegift->desc."<br/><br/> OR<br/><br/>";}
				
			}
			$g = substr_replace($g ,"",-16);

			$s = str_replace("[[GIFTS]]",$g,$s);
			if(($singlelead->leadtype=="rebook")&&(!empty($appdate))){$s = str_replace("[[APPDATE]]","<span class='label label-info'>".date('D d M', strtotime($appdate->app_date))."</span>",$s);}
		?>




<div class="modal full-screen fade" id="booking_modal" style="display:none;" >
	<div class="modal-header">
		<button class="btn btn-danger btn-large" class="close" onclick="$('.vacationList').hide();" data-dismiss="modal" style="float:right">&times;</button>
		<div class="row-fluid">
			<div class="span4" style="margin-bottom:10px;">
				<h2 style="color:#fff;">Calling {{$singlelead->cust_name}} @ <span id="lead_num"> {{$singlelead->cust_num}}</span></h2>
				<h3 style="margin-left:20px;">Lead Type : 
				
				{{ucfirst($singlelead->leadtype)}} 
				

				&nbsp;&nbsp;&nbsp;&nbsp;
				
				<i class='{{$icon}} tooltwo' title='{{$singlelead->original_leadtype}}'></i>
			 
					@if($singlelead->leadtype=="rebook") <span class='badge badge-info special tooltwo' title='The leads Original Leadtype was {{$singlelead->original_leadtype}}'>OR</span>@endif &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Done By : {{$singlelead->researcher_name}} 
					<br/>Survey Date : @if($singlelead->birth_date!='0000-00-00') {{date('M-d Y', strtotime($singlelead->birth_date))}}    @else {{date('M-d Y', strtotime($singlelead->entry_date))}} @endif  </h3>
					
					@if(Auth::user()->auto_dial==1)
					<div class="span12">
						<div id="log"></div><br/>
						<div class='timer'></div>
						<br/>
						<button class='callLead btn btn-success blackText' >CALL </button>&nbsp;
						<button class='hangupCall btn btn-danger' >HANGUP </button> &nbsp;<button class='notHomeCall btn btn-warning blackText'>HANGUP / NH - NEXT LEAD</button>
					</div>
					@endif
				<div class="span12">
					<h4>Objection Scripts</h4>
					@if(!empty($obj))
						@foreach($obj as $val)
							<button class="objection btn btn-primary btn-mini" style="margin-bottom:8px;" data-type="{{$val->type}}-{{$val->id}}">{{$val->title}}</button>
						@endforeach
					@endif
				</div>

				@if($singlelead->app_offset!=0)
				<div class="row-fluid" style="padding-left:10px;">
					<?php
					$time = strtotime(date('H:i:s'));
					if($singlelead->app_offset>0){
						$t_o = str_replace("-","+",$singlelead->app_offset)." Hours";
                        	} else {
                        		$t_o = "-".$singlelead->app_offset." Hours";
                        	}
                        	$offset_time = strtotime($t_o, $time);?>
					<br/>
					
					<span style='font-size:21px;color:white;'>Time in {{$singlelead->city}} is : <span style='color:lime'>{{date('g:i a',$offset_time)}}</span></span>
				</div>
					@endif

				<div class='span5'><br/>
				@if(Setting::find(1)->shortcode!="coastal")
				<button class='btn btn-default viewVacationList' onclick="$('.vacationList').show();"><i class='cus-map'></i>&nbsp;&nbsp;<b>VIEW VACATION LIST</b></button>
				@endif
				<br/>

				</div>

				@if(Setting::find(1)->needed==1)
				<div class='span6'><br/>
				<button class='btn btn-default viewApptNeeded'><i class='cus-application-view-icons'></i>&nbsp;&nbsp;<b>APPOINTMENT SLOTS NEEDED</b></button>
				</div>
				@endif
			</div>

			<div class="span7" style="color:#fff;font-size:10px;background:#1f1f1f;padding:10px;margin-top:5px;border-radius:8px;">
				<div class="span12">
					<span style="font-size:12px;color:yellow;">Please Click in the Address Box and try to select the proper address from GOOGLE.  This will allow proper mapping of addresses in the system</span>
				</div>
				<div class="span4">
					<h5>Collect Customer Info &nbsp;&nbsp; | &nbsp;&nbsp;Name&nbsp;</h5>
					<form id="leadinfo" action="{{URL::to('lead/processlead')}}" method="post">
						<input type="hidden" name="call_length" id="call_length" value=""/>
						<?php 
						$url="";$url2 = explode("?",$_SERVER['REQUEST_URI']);
						if(isset($_GET['processlead'])){
							$url = $url2[0];
						} else {
							$url = $_SERVER['REQUEST_URI'];
						}
						?>
						
						<input type="hidden" name="fullURL" value="http://{{$_SERVER['HTTP_HOST']}}{{$url}}"/>
					<input type="text" class="span9 leadInput scriptvalue" data-type="Customer Name" name="name" id="cust_name|{{$singlelead->id}}" value="{{$singlelead->cust_name}}" />
					<br />Spouse&nbsp;(if married)&nbsp;<br/>
					<input type="text" class="span9 leadInput scriptvalue" data-type="Spouse Name" name="spousename" id="spouse_name|{{$singlelead->id}}" value="{{$singlelead->spouse_name}}" />
					<br/>
					Street Address
					<input type="hidden" name="hiddenAddress" id="getTheHiddenAddress" value=""/>
					<input type="text" class="span11 theStreet leadAddress scriptvalue" data-city="{{$singlelead->city}}" data-type="Address" name="address" id="address|{{$singlelead->id}}" value="{{$singlelead->address}}" />
					<br/>
					City / Quadrant<br/>
					<select id="city|{{$singlelead->id}}" name="city" class="span9 leadInput cityChange " data-type="City">
						@foreach($cities as $val)
							<option value="{{$val->cityname}}" @if($val->cityname==$singlelead->city) selected="selected" @endif>{{$val->cityname}}</option>
						@endforeach
					</select><br>
					<div class="span3">
					Sex&nbsp;<br/>
					<select id="sex|{{$singlelead->id}}" name="sex" class="span12 leadInput" data-type="Marital Status">
						<option value="" @if($singlelead->sex=="") selected='selected' @endif></option>
						<option value="male" @if($singlelead->sex=="male") selected='selected' @endif>Male</option>
						<option value="female" @if($singlelead->sex=="female") selected='selected' @endif>Female</option> 
					</select>
					</div>

					<div class="span3">
					Marital Status&nbsp;<br/>
					<select id="married|{{$singlelead->id}}" name="marriagestatus" class="span12 leadInput" data-type="Marital Status">
						<option value="married" @if($singlelead->married=="married") selected='selected' @endif>Married</option>
						<option value="commonlaw" @if($singlelead->married=="commonlaw") selected='selected' @endif>Common Law</option>
						<option value="single" @if($singlelead->married=="single") selected='selected' @endif>Single</option> 
						<option value="widowed" @if($singlelead->married=="widowed") selected='selected' @endif>Widowed</option>
					</select>
					</div>
					<div class="span3">
					Select a Gift&nbsp;<br/>
					<select name="gift|{{$singlelead->id}}" id="gift|{{$singlelead->id}}" class="span12 leadInput scriptvalue" data-type="Gift">
						<option value=""></option>
						@foreach($arr as $val)
						<?php $thegift = Gift::find($val);
						if($thegift){;?>
						<option value="{{$thegift->name}}" @if($singlelead->gift==$thegift->name) selected='selected' @endif>{{$thegift->name}}</option><?php };?>
						@endforeach
					</select>
					</div>
				</div>
					<input type="hidden" name="thecity" id="thecity" value="{{$singlelead->city}}" />
				
				<div class="span5" >
					<h5>Book Demo / Change Status</h5>
					<div class="controls">
						<div class="btn-group" data-toggle="buttons-radio">
							<button type="button" class="btn btn-small APPbutton process" data-status="APP"><i class="cus-clock"></i>&nbsp;APP</button>
							<button type="button" class="btn btn-small process active notHomeButton" data-status="NH"><i class="cus-house"></i>&nbsp;NH</button>
							<button type="button" class="btn btn-small RECALLbutton process" data-status="Recall"><i class="cus-arrow-redo"></i>&nbsp;Recall</button>
							<button type="button" class="btn btn-small process" data-status="NI"><i class="cus-cross"></i>&nbsp;NI</button>
							<button type="button" class="btn btn-small NQbutton process" data-status="NQ"><i class="cus-cross"></i>&nbsp;NQ</button>
							<button type="button" class="btn btn-small WrongNumbutton process" data-status="WrongNumber"><i class="cus-exclamation-octagon-fram"></i>&nbsp;WRONG #</button>
							@if(Auth::user()->dnc_button==0)
			                <button type="button" class="btn btn-small process" data-status="DNC"><i class="cus-delete"></i>&nbsp;DNC</button>
			                @endif
			            </div>
					</div>
					<input type="hidden" name="hiddenTIME" id="hiddenTIME" value="0" />
					<input type="hidden" name="status" id="status" value="NH" />
					<input type="hidden" name="leadid" id="leadid" value="{{$singlelead->id}}">
					<div class="controls appointmentbook" style="margin-top:8px;display:none">
							<div style="width:100%;float:left;">
								<div class="span4">
							Appointment Time<br/>
							<input class="booktimepicker2" id="booktimepicker" name="booktimepicker" type="text"  placeholder="Select Time..." style="color:#fff;width:90%;background:#FF6666" />
							</div>
							<div class="span8">
							@if($singlelead->app_offset!=0)
							<?php if($singlelead->app_offset>0){$k="+";$col="lime";} else {$k="";$col="red";};?>
							<br/>
							<span style='font-size:15px;'>
							This city has a time offset of <span style='color:{{$col}};font-size:19px;font-weight:bolder'>{{$k}}{{$singlelead->app_offset}}</span> hours </span><br/>
							<span style='font-size:13px;'>Select the appointment time normally.
								The system will automatically adjust it to display correctly on the appointment board in local time.</span>
							<br/>
							<span style='color:red'>If the offset is incorrect, please alert your manager</span>
							
							@endif
						</div>
						</div>
							<br/>
							Date<br/>
						<div class="input-append date" id="datepicker-nobook" data-date="{{date('Y-m-d')}}" data-date-format="yyyy-mm-dd">
							<input class="datepicker-input" size="16" id="appdate" name="appdate" type="text" value="{{date('Y-m-d')}}" placeholder="Select a date" />
							<input id="actualdate" type="hidden" value="{{date('Y-m-d')}}" />
							<span class="add-on"><i class="cus-calendar-2"></i></span>
						</div>
					</div>
					<div class="controls notqualified" style="margin-top:8px;display:none">
							Select a Reason<br/>
							<select name="nqreason" id="nqreason" class="span5" style="background:yellow;">
								<option value=""></option>
								<option value="renter" @if($singlelead->nqreason=='renter') selected='selected' @endif>Renter</option>
								
								<option value="language" @if($singlelead->nqreason=='language') selected='selected' @endif>Language Barrier</option>
								<option value="tooold" @if($singlelead->nqreason=='tooold') selected='selected' @endif>Too Old</option>
								<option value="demensia" @if($singlelead->nqreason=='demensia') selected='selected' @endif>Has Dementia</option>
								<option value="hasproduct" @if($singlelead->nqreason=='hasproduct') selected='selected' @endif>Owns Our Product</option>
								<option value="seendemo" @if($singlelead->nqreason=='seendemo') selected='selected' @endif>Seen The Demo</option>
							</select>
					</div>
					<div class="controls wrongnumber" style="margin-top:8px;display:none">
							Select a Reason<br/>
							<select name="wrongreason" id="wrongreason" class="span5" style="background:yellow;">
								<option value=""></option>
								
								<option value="notinservice" @if($singlelead->nqreason=='notinservice') selected='selected' @endif>Not In Service</option>
								<option value="didntdosurvey" @if($singlelead->nqreason=='didntdosurvey') selected='selected' @endif>Didn't Do Survey</option>
								
								
							</select>
					</div>
					<div class="controls recalldate" style="margin-top:8px;display:none">
							
							Select a Date for Recalling this Customer<br/>
						<div class="input-append date" id="datepicker-js" data-date="{{date('Y-m-d')}}" data-date-format="yyyy-mm-dd">
							<input class="datepicker-input" size="16" id="recalldate" name="recalldate" type="text" value="{{date('Y-m-d')}}" placeholder="Select a date" />
							<span class="add-on"><i class="cus-calendar-2"></i></span>
						</div>
					</div>
					Notes<br />
					<textarea name="notes" id="notes" rows=4 >{{$singlelead->notes}}</textarea>
					<div class="span8">
					<button class="processApp btn btn-default" style="margin-left:-10px;margin-top:10px;margin-bottom:10px;"><i class="icon-ok icon-white"></i>&nbsp; PROCESS APP</button>
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal-body" style="overflow:none">
    	<div class='span3'>
    		@if(Auth::user()->call_info==0)
    		@if(($singlelead->original_leadtype=="Manilla Survey")||($singlelead->original_leadtype=="Homeshow"))
    		<div class='row-fluid'>

			<div class='span12 well'>
				<h4 style="margin-top:-10px;">Other Info</h4>
				@if(!empty($singlelead->age_range)) Age :  {{$singlelead->age_range}} yrs <br/>@endif 

				Smoke : <input type="checkbox" data-id="smoke|{{$singlelead->id}}" @if($singlelead->smoke=='Y') checked='checked'@endif><Br/>
				Pets : <input type="checkbox" data-id="pets|{{$singlelead->id}}" @if($singlelead->pets=='Y') checked='checked'@endif><Br/>
				Asthma : <input type="checkbox" data-id="asthma|{{$singlelead->id}}" @if($singlelead->asthma=='Y') checked='checked'@endif><br/><br/>

				Rent / Own : @if($singlelead->rentown=="O") <span class=' edit-house label label-info special' id="rentown|{{$singlelead->id}}">O</span> @else <span class='edit-house label label-important special animated shake' id="rentown|{{$singlelead->id}}">R</span> @endif  
				@if(!empty($singlelead->yrs)) <span class='small'> for {{strtolower($singlelead->yrs)}} </span> @endif   <br/><br/>

				Job : <span class='label label-inverse edit' id="job|{{$singlelead->id}}">{{$singlelead->job}}</span> <span class='edit-fullpart label label-success important' id="fullpart|{{$singlelead->id}}">({{$singlelead->fullpart}})</span></br>
				Spouse : <span class='label label-inverse edit' id="spouse_job|{{$singlelead->id}}">{{$singlelead->spouse_job}}</span><span class='label label-success important'>{{$singlelead->spousefullpart}}</span></br>

				Years at Job : <span class='label label-info edit' id="jobyrs|{{$singlelead->id}}">{{$singlelead->jobyrs}}</span> <br/>
				Spouse Yrs at Job: <span class='label label-info edit' id="spousejobyrs|{{$singlelead->id}}">{{$singlelead->spousejobyrs}}</span></br>
			</div>

		</div>
		@endif
		@endif


		<div class='row-fluid'>
			@if(!empty($rightaways))
			<div class='span12 well rightaways'>
				<h4>Right Aways Needed</h4><br/>
				@foreach($rightaways as $val)
				@if($val->rightaway!=0)
				<span class='label label-warning special animated bounce gotone' style='color:#000'>{{$val->cityname}} : </span>&nbsp;&nbsp;
				<span class='badge badge-info special animated slideInLeft' style='font-size:14px;padding:7px;'>{{$val->rightaway}}</span>
      	      	<br/><a href='{{URL::to('cities/gotrightaway/')}}{{$val->id}}'><button class='btn btn-small gotone' style='margin-top:5px;' ><i class='cus-accept'></i>&nbsp;CLICK IF YOU GOT ONE!</button></a><br/><br/>
				@endif
				@endforeach
			</div>
			@endif
		</div>
		@if(Auth::user()->call_details==0)
		<div class='row-fluid'>
    			<div class="span12 well" style="background:white;padding:15px;padding-bottom:20px;">
				<h4>Contact History<button class="btn btn-default btn-mini" onclick="$('.callhistory').toggle(200);" style="float:right">VIEW HISTORY</button></h4>
				<hr>
				<div class="callhistory" style="display:none">
				<?php $calls = $singlelead->calls;?>
					@if(!empty($calls))
					@foreach($calls as $val2)
					<?php $u = User::find($val2->caller_id);?>
					@if(!empty($u))
					Marketer: <span class="label label-inverse">
					{{User::find($val2->caller_id)->firstname}}
					</span> Result:<span class="label label-info special">{{$val2->result}}</span>
					<br/><span class="label label-info">Called On {{date("M-d H:i", strtotime($val2->created_at))}}</span><hr>
					@endif
					@endforeach
					@else
					Have Not Contacted this Customer Yet<hr>
					@endif
				</div>
			</div>
		</div>
		@endif
		@if(!empty($singlelead->referrer))
		<div class='row-fluid'>
			<div class='span12 well rightaways'>
				<h4>Referred By : </h4>
				<a href='{{URL::to("lead/newlead/")}}{{$singlelead->referrer->cust_num}}' target=_blank>{{$singlelead->referrer->cust_name}}<br/>
				{{$singlelead->referrer->cust_num}}<br/>
				{{$singlelead->referrer->address}}</a>
				<br/>
				<?php $app = Appointment::where('lead_id','=',$singlelead->referrer->id)->order_by('app_date','DESC')->take(1)->get();?>
				@if($app && !empty($app[0]->attributes['callback_notes']))
				<br/>
				Referral Notes : <br/>
				{{$app[0]->attributes['callback_notes']}}
				@endif

			</div>
		
		</div>
		@endif

	</div>
    	<div class="span7" style="background:white;border-radius:5px;color :#000;border:1px solid #6e6e6e;padding:30px;padding-bottom:200px;margin-bottom:40px;">
    		<h4>{{$script->title}}</h4><br>
			<p >Hi, can I please speak to <strong><span class='scriptval-name'>{{$singlelead->cust_name}}</span>?</strong></p>
			
			{{$s}}
	</div>
	<div class="span3 shadowBOX" style="border: 2px solid #1f1f1f;">
		<div id="map" style="height:300px;"></div>
	</div>

		
	</div>
</div>
@if(Auth::user()->auto_dial==1)
 <script type="text/javascript"
      src="//static.twilio.com/libs/twiliojs/1.1/twilio.min.js"></script>
      <script type="text/javascript">
 	$(document).ready(function(){


 	function pretty_time_string(num) {
    		return ( num < 10 ? "0" : "" ) + num;
  	}

 	Twilio.Device.setup("<?php echo $twi_token; ?>");
 
      Twilio.Device.ready(function (device) {
        $("#log").html("<span class='label label-success'>Ready to Call....Allow the call to connect to your microphone, ABOVE</span>");
      });

      Twilio.Device.error(function (error) {
        $("#log").html("<span class='label label-danger'>Error Connection</span>");
      });
 
      Twilio.Device.connect(function (conn) {
      	var start = new Date; 
      		myTimer = setInterval(function() {

  var total_seconds = (new Date - start) / 1000;   

  var hours = Math.floor(total_seconds / 3600);
  total_seconds = total_seconds % 3600;

  var minutes = Math.floor(total_seconds / 60);
  total_seconds = total_seconds % 60;

  var seconds = Math.floor(total_seconds);

  hours = pretty_time_string(hours);
  minutes = pretty_time_string(minutes);
  seconds = pretty_time_string(seconds);

  var currentTimeString = hours + ":" + minutes + ":" + seconds;
  		$('#call_length').val(currentTimeString);
  		$('.timer').text(currentTimeString);
		}, 1000);
        $("#log").html("<span class='label label-success special blackText'>Calling this Customer  </span>");
      });
 
      Twilio.Device.disconnect(function (conn) {
       // alert(Twilio.Device.status());
       clearInterval(myTimer);
       hangup();
        $("#log").html("<span class='label label-info special blackText'>Call Ended</span>");
      });

      $('.callLead').click(function(){
      	call();
      });

      $('.hangupCall').click(function(){
      	hangup();
      	clearInterval(myTimer);
      });

      $('.notHomeCall').click(function(){
      	hangup();
      	setTimeout(function(){
      		$('.notHomeButton').trigger('click');
        		$('.processApp').trigger('click');
      	},300);
      });
 
      Twilio.Device.incoming(function (conn) {
        $("#log").text("Incoming connection from " + conn.parameters.From);
        // accept the incoming connection and start two-way audio
        conn.accept();
      });
 
      function call() {
        params = {"PhoneNumber": $("#lead_num").html()};
      	toastr.success("Calling {{$singlelead->cust_name}} @ {{$singlelead->cust_num}}","CALLING.... GET READY!");
        Twilio.Device.connect(params);
      }
 
      function hangup() {
       
        $("#log").html("<span class='label label-info special'>Hungup on Call</span>");
        Twilio.Device.disconnectAll();
      }


        setTimeout(function(){
		call();

	},600);
 	});
    
    </script>
    @else
    <script>
    $(document).ready(function(){

    	function pretty_time_string(num) {
    		return ( num < 10 ? "0" : "" ) + num;
  	}
  	  var start = new Date; 
      		myTimer = setInterval(function() {

  var total_seconds = (new Date - start) / 1000;   

  var hours = Math.floor(total_seconds / 3600);
  total_seconds = total_seconds % 3600;

  var minutes = Math.floor(total_seconds / 60);
  total_seconds = total_seconds % 60;

  var seconds = Math.floor(total_seconds);

  hours = pretty_time_string(hours);
  minutes = pretty_time_string(minutes);
  seconds = pretty_time_string(seconds);

  var currentTimeString = hours + ":" + minutes + ":" + seconds;
  		
  		$('#call_length').val(currentTimeString);
		}, 1000);
    	
    });
  
    </script>
    @endif


<script>
$(document).ready(function(){
	@if(Auth::user()->three_day==0)
	function validateDate(theDate){
		var today = new Date();
			var time = $('#hiddenTIME').val();
			var d = Date.parse(theDate+" "+time);
			if(d < today){
				toastr.error("You cannot book an appointment in the past!","CANNOT PROCESS");
    			return false;
			} else {
				return true;
			}
	}
	@else

	function validateDate(theDate){
			var today = new Date();
			var time = $('#hiddenTIME').val();
			var d = Date.parse(theDate+" "+time);
			if(d < today){
				toastr.error("You cannot book an appointment in the past!","CANNOT PROCESS");
    			return false;
			} else {
				var skip=0;
				if((today.getDay()==5)||(today.getDay()==6)){
					skip=3;
				} else {	
					skip=2;
				}
				var nextWeek = Date.parse(new Date(today.getFullYear(), today.getMonth(), today.getDate() + skip));
				if (nextWeek < Date.parse(theDate)){
					toastr.error("You cannot book an appointment more than that far ahead","CANNOT PROCESS");
    				return false;
				} else {
    				return true;
				}
			}
		}
		@endif

		$('.booktimepicker2').change(function(){
			var val = $(this).val();
			$('#hiddenTIME').val(val);
		});

		function validateAddressandTime(){
			if($('#status').val()=="APP"){
				var time = $('#hiddenTIME').val();
				var address = $('.leadAddress').val();
				if(address==0 || address==""){
					$('.leadAddress').css('background','red');
					toastr.error("You need to enter an address to book an appointment!!!");
					return false;
				}
				if(time==0){
					toastr.error("You need to select a time, in order to book an appointment!");
					return false;
				}

				return true;
			} else {
				return true;
			}
		}

		function checkForApp(id, date){
			var hasNoApp=false;
			$.ajax({
   			  async: false,
   			  url: "{{URL::to('appointment/check/')}}",
   			  dataType: "json",
   			  data: {lead_id:id,date:date},
   			  success: function(data) {
   			  	console.log(data);
   			    if (data == "success") {     
   			      	hasNoApp=true;
   			    } else {
   			    	hasNoApp = false;
   			    }
   			  }
   			});
			return hasNoApp;
			
		}

			$('.processApp').click(function(e){
				e.preventDefault();
				
				var date = $('#actualdate').val();
				var lead_id = $('#leadid').val();
				var status = $('#status').val();
				if(validateDate(date)){
					if(validateAddressandTime()){
						if(status=="APP"){
							$(this).attr('disabled','disabled').html("<img src='{{URL::to('img/loaders/misc/56.gif')}}'>&nbsp;&nbsp; PROCESSING...");
							if(checkForApp(lead_id,date)){
							toastr.success("Appointment is OK to book");
							setTimeout(function(){
								$('#leadinfo').submit();
							},600);
							} else {
								toastr.error("This appointment already exists on Todays Board!","Cannot Book!!");
								return false;
							}
						} else {
							$(this).attr('disabled','disabled').html("<img src='{{URL::to('img/loaders/misc/56.gif')}}'>&nbsp;&nbsp; PROCESSING...");
							$('#leadinfo').submit();
						}
					};	
				}
							
			});


$(".booktimepicker2").timePicker({
  startTime: "09:00", 
  endTime: new Date(0, 0, 0, 23, 30, 0), 
  show24Hours: false,
  step: 15});


$('.edit-fullpart').editable('{{URL::to("lead/edit")}}',{
		data : '{"FT":"FT","PT":"PT","R":"Retired"}',
		type:'select',
		submit:'OK',
    		indicator : 'Saving...',
    		width:50,
    		placeholder:".......",
    		callback : function(value, settings) {
    	      replaceRow($(this).data('id'));
     	}
    	});

$('.edit-house').editable('{{URL::to("lead/edit")}}',{
		data : '{"R":"Rent","O":"Own"}',
		type:'select',
		submit:'OK',
    		indicator : 'Saving...',
    		width:50,
    		placeholder:".......",
    		callback : function(value, settings) {
    	      replaceRow($(this).data('id'));
     	}
    	});


	$('.leadInput').change(function(){
		var id=$(this).attr('id');
		var val=$(this).val();
		var type=$(this).data('type');
		$('#thecity').val(val);
		$.get('{{URL::to("lead/edit")}}',{id:id,value:val},function(data){
			toastr.success('Saved as the new value for '+type,val.toUpperCase());
		});
	});

	$('.leadAddress').blur(function(){
		
		//toastr.success('Address saved!','Address Saved');
		setTimeout(function(){
			val=$('#getTheHiddenAddress').val();
			getmap(val);
			}, 700);
	});
	

	$(':checkbox').click(function(){
		var id = $(this).data('id');
		var therow = $(this).data('theid');

		if($(this).is(":checked")){
			var value=1;
		} else {
			var value=0;
		}
		$.get('{{URL::to("lead/edit")}}',{id:id,value:value},function(data){
		var name = id.split("|");
			if(data==1) {toastr.success(name[0].toUpperCase()+' Succesfully checked!','Saved');} 
			else {
				toastr.success(name[0].toUpperCase()+' Succesfully checked!','Saved');
			}
		});
	});


$('.edit').editable('{{URL::to("lead/edit")}}',{
    indicator : 'Saving...',
         height: 30,
         width:200,
     submit  : 'OK'
});




$('.scriptvalue').blur(function(){
var val = $(this).val();
var id = $(this).attr('id').split("|");
$('.scriptval-'+id[0]).html(val);
});

$('.objection').click(function(){
var type = $(this).data('type');
$('.objectionBox').hide();
$('.'+type).show();
});
$('.closeObjection').click(function(){
$('.objectionBox').hide();
});

$('.process').click(function(){
	var sts = $(this).data('status');
	$('input#status').val(sts);
		if($(this).hasClass('APPbutton')){
			$('.appointmentbook').show(300);
		} else {$('.appointmentbook').hide(200);}

	if($(this).hasClass('RECALLbutton')){
		$('.recalldate').show(300);
	} else {
		$('.recalldate').hide(200);
	}
	if($(this).hasClass('NQbutton')){
		$('.notqualified').show(300);
	} else {
		$('.notqualified').hide(300);
	}
	if($(this).hasClass('WrongNumbutton')){
		$('.wrongnumber').show(300);
	} else {
		$('.wrongnumber').hide(300);
	}
});



function getmap(add){
$("#map").gmap3({
	clear: {
		name: ["marker"]
	},
	marker: {
		address:add, options:{icon: "/img/pure-op.png"}
	},
    map:{
      options:{
        zoom:13,
        mapTypeId: google.maps.MapTypeId.TERRAIN,
        mapTypeControl: true,
        navigationControl: true,
        scrollwheel: true,
        streetViewControl: true
      }
    },
    autofit:{}
  });
}

var address=$('#getTheHiddenAddress').val();
if(address.length!=0){
	getmap(address);
}



});
</script>

@endif


