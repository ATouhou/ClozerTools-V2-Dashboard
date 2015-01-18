<style>
.edit {cursor:pointer;}
.edit-house {cursor:pointer;}
.edit-fullpart {cursor:pointer;}
.timer {font-size:24px;color:yellow;}
.process.active {
	background:green!important;color:white!important;
}
</style>

@if(!empty($singlelead))
<?php 	
		$city = $singlelead->city;
		$checkCity = City::where('cityname','=',$city)->first();
		if($checkCity){
			$script = Script::where('type','=','survey')->where('batch_id','=',$checkCity->script_batch)->first();
			$scriptnow = Script::where('type','=','bookrightnow')->where('batch_id','=',$checkCity->script_batch)->first();
		} else {
			$script = Script::where('type','=','survey')->first();
			$scriptnow = Script::where('type','=','bookrightnow')->first();
		}

		function getScript($theInputScript, $lead){
				if(empty($lead->address)){$address="No Address On File....ENTER ONE ABOVE";} else {$address = $lead->address.", ".$lead->city;}
				$s = str_replace("[[NAME]]","<strong><span class='scriptval-booker_name'>".Auth::user()->firstname."</span></strong>",$theInputScript);
				$s = str_replace("[[CUSTNAME]]","<strong><span class='scriptval-cust_name'>".$lead->cust_name."</span></strong>",$s);
				$s = str_replace("[[SPOUSENAME]]","<strong><span class='scriptval-spouse_name'>".$lead->spouse_name."</span></strong>",$s);
				$s = str_replace("[[ADDRESS]]","<span class='label label-info special'><span class='scriptval-address'>".$address."</span></span><br><br>",$s);
				return $s;
			}
			
			print_r($script->script);
			$script1 = getScript($script->script,$singlelead);
			$script2 = getScript($scriptnow->script,$singlelead);

			$g = "";$c=0;
		?>
<div class="modal full-screen fade" id="booking_modal" >
	<div class="modal-header">
		<button class="btn btn-danger btn-large" class="close" onclick="$('.vacationList').hide();" data-dismiss="modal" style="float:right">&times;</button>
		<div class="row-fluid">
			<div class="span4" style="margin-bottom:10px;">
				<h2 style="color:#fff;">Calling {{$singlelead->cust_name}} <br/>@ <span id="lead_num"> {{$singlelead->cust_num}}</span></h2>
				<h3 style="margin-left:20px;">Lead Type : UN-SURVEYED LEAD &nbsp;&nbsp;&nbsp;&nbsp;<i class='cus-script tooltwo' title='{{$singlelead->original_leadtype}}'></i> 
					<br/>
					@if($singlelead->app_offset!=0)
					<?php
					$time = strtotime(date('H:i:s'));
					if($singlelead->app_offset>0){
						$t_o = str_replace("-","+",$singlelead->app_offset)." Hours";
                        	} else {
                        		$t_o = "-".$singlelead->app_offset." Hours";
                        	}
                        	$offset_time = strtotime($t_o, $time);?>
					<br/>
					
					<span style='font-size:21px;'>Time in {{$singlelead->city}} is : <span style='color:lime'>{{date('g:i a',$offset_time)}}</span></span>
					@endif
					
					@if(Auth::user()->auto_dial==1)
					<div class="span12">
						<div id="log"></div><br/>
						<div class='timer'></div>
						<br/>
						<button class='callLead btn btn-success blackText' >CALL </button>&nbsp;
						<button class='hangupCall btn btn-danger' >HANGUP </button> &nbsp;<button class='notHomeCall btn btn-warning blackText'>HANGUP / NH - NEXT LEAD</button>
					</div>
					@endif
			</div>

			<div class="span7" style="color:#fff;font-size:10px;background:#1f1f1f;padding:10px;margin-top:5px;border-radius:8px;">
				<div class="span12">
					<span style="font-size:12px;color:yellow;">Please Click in the Address Box and select the proper address from GOOGLE.  This will allow proper mapping of addresses in the system</span>
				</div>
				<input type="hidden" name="thecity" id="thecity" value="{{$singlelead->city}}" />
				
				<div class="span3">
					<h5>Customer Name</h5>
					<form id="leadinfo" action="{{URL::to('lead/processsurvey')}}" method="post">
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
					<input type="text" class="span12 leadInput scriptvalue" data-type="Customer Name" name="name" id="cust_name|{{$singlelead->id}}" value="{{$singlelead->cust_name}}" />
					<br />
					Marital Status&nbsp;
					<select id="married|{{$singlelead->id}}" name="marriagestatus" class="span12 leadInput" data-type="Marital Status">
						<option value="married" @if($singlelead->married=="married") selected='selected' @endif>Married</option>
						<option value="commonlaw" @if($singlelead->married=="commonlaw") selected='selected' @endif>Common Law</option>
						<option value="single" @if($singlelead->married=="single") selected='selected' @endif>Single</option> 
						<option value="widowed" @if($singlelead->married=="widowed") selected='selected' @endif>Widowed</option>
					</select>
					Spouse&nbsp;(if married)&nbsp;<br/>
					<input type="text" class="span12 leadInput scriptvalue" data-type="Spouse Name" name="spousename" id="spouse_name|{{$singlelead->id}}" value="{{$singlelead->spouse_name}}" /></h5>
				</div>
				<div class="span5" >
				<br/>
				Street Address
					<input type="hidden" name="hiddenAddress" id="getTheHiddenAddress" value=""/>
					<input type="text" class="span12 theStreet leadAddress scriptvalue" data-city="{{$singlelead->city}}" data-type="Address" name="address" id="address|{{$singlelead->id}}" value="{{$singlelead->address}}" />
					<br/>
					City<br/>
					<select id="city|{{$singlelead->id}}" name="city" class="span12 leadInput cityChange " data-type="City">
						@foreach($cities as $val)
							<option value="{{$val->cityname}}" @if($val->cityname==$singlelead->city) selected="selected" @endif>{{$val->cityname}}</option>
						@endforeach
					</select><br>
				Rent / Own&nbsp;
					<select id="rentown|{{$singlelead->id}}" name="rentown" class="span12 leadInput" data-type="Marital Status">
						<option value=""></option>
						<option value="R" @if($singlelead->rentown=="R") selected='selected' @endif>Rent</option>
						<option value="O" @if($singlelead->rentown=="O") selected='selected' @endif>Own</option>
					</select>
				
				</div>
				<div class="span2">
				<br/>
						Job : 
						<input type="text"  class="span12" name="job" value="{{$singlelead->job}}" / >
						Years at Job : 
						<input type="text" class="span12" name="jobyrs" value="{{$singlelead->jobyrs}}" / >
						Full Time / Part Time&nbsp;
							<select id="fullpart" name="fullpart" class="span12" data-type="Marital Status">
								<option value="FT" @if($singlelead->fullpart=="FT") selected='selected' @endif>Full Time</option>
								<option value="PT" @if($singlelead->fullpart=="PT") selected='selected' @endif>Part Time</option>
								<option value="R" @if($singlelead->fullpart=="R") selected='selected' @endif>Retired</option>
							</select>
				</div>
					<div class="span12">
					<div class="span3">
						Smoke : <input type="checkbox" data-id="smoke|{{$singlelead->id}}" name="smoke" > &nbsp;
						Pets : <input type="checkbox" data-id="pets|{{$singlelead->id}}" name="pets"> &nbsp;
						Asthma : <input type="checkbox" data-id="asthma|{{$singlelead->id}}" name="asthma" ><br/>
						Has Air Purifier : <input type="checkbox" name="air_purifier" data-id="air_purifier|{{$singlelead->id}}" ><br/>
					</div>
					<div class="span2">
						Age Range&nbsp;<br/>
							<select id="age_range" name="age_range" class="span8" data-type="Age Range">
								<option value=""></option>
								<option value="21-35" @if($singlelead->age_range=="21-35") selected='selected' @endif>21-35</option>
								<option value="36-50" @if($singlelead->age_range=="36-50") selected='selected' @endif>36-50</option>
								<option value="51-75" @if($singlelead->age_range=="51-75") selected='selected' @endif>51-75</option>
								<option value="75-85" @if($singlelead->age_range=="75-85") selected='selected' @endif>75-85</option>
							</select>
					</div>
					<div class="span2">
					Sex&nbsp;<br/>
					<select id="sex" name="sex" class="span10" data-type="Sex">
						<option value="" @if($singlelead->sex=="") selected='selected' @endif></option>
						<option value="male" @if($singlelead->sex=="male") selected='selected' @endif>Male</option>
						<option value="female" @if($singlelead->sex=="female") selected='selected' @endif>Female</option> 
					</select>
					</div>

					<div class="span4">
						Notes : &nbsp;<br/>
						<textarea cols=4 name="notes" id="notes">{{$singlelead->notes}}</textarea>
					</div>
					</div>
				<div class="span12">
					<h5>Update Lead Status<br/><span style='color:yellow;font-size:10px;'>Make sure to hit SURVEY COMPLETE if they actually finished the survey</span></h5>
					<div class="controls">
						<div class="btn-group" data-toggle="buttons-radio">
							<button type="button" class="btn btn-small process" data-status="APP"><i class="cus-clock"></i>&nbsp;BOOK APPOINTMENT</button>
							<button type="button" class="btn btn-small process" data-status="INACTIVE"><i class="cus-accept"></i>&nbsp;SURVEY COMPLETE</button>
							<button type="button" class="btn btn-small process active notHomeButton" data-status="NH"><i class="cus-house"></i>&nbsp;NH</button>
							<button type="button" class="btn btn-small process" data-status="NID"><i class="cus-cross"></i>&nbsp;NID</button>
							<button type="button" class="btn btn-small process" data-status="NI"><i class="cus-cross"></i>&nbsp;NOT INTERESTED</button>
							<button type="button" class="btn btn-small process" data-status="NQ"><i class="cus-delete"></i>&nbsp;NQ</button>
							<button type="button" class="btn btn-small WrongNumbutton process" data-status="WrongNumber"><i class="cus-exclamation-octagon-fram"></i>&nbsp;WRONG #</button>
							@if(Auth::user()->dnc_button==0)
			                <button type="button" class="btn btn-small process" data-status="DNC"><i class="cus-delete"></i>&nbsp;DNC</button>
			                @endif
			            </div>
					</div>
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
							<span style='font-size:13px;'>Select the appointment time normally.<br/>
								The system will automatically adjust it to display correctly on the appointment board in local time.</span>
							<br/>
							<span style='color:red'>If the offset is incorrect, please alert your manager</span>
							@endif
						</div>
						</div>

							Date<br/>
						<div class="input-append date" id="datepicker-nobook" data-date="{{date('Y-m-d')}}" data-date-format="yyyy-mm-dd">
							<input class="datepicker-input" size="16" id="appdate" name="appdate" type="text" value="{{date('Y-m-d')}}" placeholder="Select a date" />
							<input id="actualdate" type="hidden" value="{{date('Y-m-d')}}" />
							<span class="add-on"><i class="cus-calendar-2"></i></span>
						</div>
					</div>
					<div class="span8">
					<button class="processApp btn btn-primary btn-large" style="margin-left:-23px;margin-top:20px;margin-bottom:10px;"><i class="icon-ok icon-white"></i>&nbsp; PROCESS LEAD</button>


					</div>
				</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal-body" style="overflow:none">
    	@if(Auth::user()->call_details==0)
    	<div class='span3'>
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
		
	</div>
	@endif
    <div class="span8" style="background:white;border-radius:5px;color :#000;border:1px solid #6e6e6e;padding:30px;padding-bottom:200px;margin-bottom:40px;">
    		<div id="surveyScript" class="aScript">
    		<h4>{{$script->title}}</h4><br>
			<p >Hi, can I please speak to <strong><span class='scriptval-name'>{{$singlelead->cust_name}}</span>?</strong></p>
			{{$script1}}
			</div>
			<div id="bookRightNow" class="aScript" style="display:none;">
			<h4>{{$scriptnow->title}}</h4><br>
			{{$script2}}
			</div>
	</div>
	<div class="span4 shadowBOX" style="border: 2px solid #1f1f1f;">
		<div id="map" style="height:400px;"></div>
	</div>
	<div class="span12" style="height:200px;">
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
	

	$('.processApp').click(function(e){
		e.preventDefault();
		$(this).attr('disabled','disabled').html("<img src='{{URL::to('img/loaders/misc/56.gif')}}'>&nbsp;&nbsp; PROCESSING...");
		$('#leadinfo').submit();
	});

	$('.leadAddress').blur(function(){
		setTimeout(function(){
			val=$('#getTheHiddenAddress').val();
			getmap(val);
			}, 700);
	});
	

$('.scriptvalue').blur(function(){
var val = $(this).val();
var id = $(this).attr('id').split("|");
$('.scriptval-'+id[0]).html(val);
});

$('.process').click(function(){
	$('.aScript').hide();
	
	var sts = $(this).data('status');
	if(sts=="APP"){
		$('.appointmentbook').show();
		$('#bookRightNow').show();
	} else {
		$('.appointmentbook').hide();
		$('#surveyScript').show()
	}
	$('input#status').val(sts);
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


