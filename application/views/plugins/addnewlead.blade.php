
<style>
.modal{
    z-index: 2;   
}
.modal-backdrop{
    z-index: 1;        
}​
</style>
<?php $res = User::where('level','!=',99)->where('user_type','!=','manager')->order_by('firstname')->get();
$events = Eventshow::get();
$cities = City::where('status','!=','leadtype')->order_by('cityname','ASC')->get();
$settings = Setting::find(1);?>
<div class="modal hide fade newLeadModal" id="lead_edit_modal" >
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h3><span class='title'>Enter New Lead</span></h3>
	</div>

	<div id="newLeadForm" style="padding-top:10px;padding-left:20px;">

		 <form id="newLeadEntry" method="post" action="" >

		 	<div class='row-fluid' style='width:80%;padding-bottom:10px;margin-bottom:10px;border-bottom:1px solid #ddd;'>
                  	<div class="span3">
                  		<label>Customer Number <b>(with dashes!!)</b></label>
                  	      <input type="text" name="newlead-custnum" maxlength=12 id="newlead-custnum" onKeyup="addDashes(this)"  />
                  	</div>
                 <div class="span3">
                   		<label for="select01">Lead Type</label>
					<select id="newlead-leadtype" name="newlead-leadtype" style="z-index:50000">
						<option value=""></option>
						@if($settings->lead_survey==1)<option value="survey" >Fresh Survey / Un-Surveyed</option>@endif
						@if($settings->lead_secondtier==1)<option value="secondtier" >Second Tier Survey</option>@endif
						@if($settings->lead_door==1)<option value="door"> Door Reggie Survey</option>@endif
						@if($settings->lead_paper==1)<option value="paper" >Manilla / XLS Upload</option>@endif
						@if($settings->lead_homeshow==1)<option value="homeshow" >Home Show</option>@endif
						@if($settings->lead_ballot==1)<option value="ballot" >Ballot Box</option>@endif
						@if($settings->lead_referral==1)<option value="referral" >Referral</option>@endif
						@if($settings->lead_personal==1)<option value="personal" >Personal Lead</option>@endif
						@if($settings->lead_coldcall==1)<option value="coldcall" >Cold Call</option>@endif
						@if($settings->lead_doorknock==1)<option value="doorknock" >Door Knock</option>@endif
						@if($settings->lead_scratch==1)<option value="other" >Scratch Card</option>@endif
						@if($settings->lead_train==1)<option value="training" >Training Lead</option>@endif
						@if($settings->lead_instant==1)<option value="instantset" >Instant Set</option>@endif
						
						<option value="rebook" >Rebook</option>
					</select>
				</div>
				<div class="span3 findReferralLead" style="display:none;">
				 	<label>Search for the Lead/Cust Who Referred (Press Enter to Search) </label>
					<div class="controls">
					   <input size="16" id="newlead-findlead" name="newlead-referrallead" type="text" value="" placeholder="Search for a lead..(NUM or NAME)." />
						<input type="hidden" id="newlead-referralHidden" name="newlead-referralleadHidden" value="" />
					</div>
					<div id="leadResultBox">
						<ul class='leadResults'>
							

						</ul>
					</div>
				</div>
				<div class="span3 homeshowBox" style="display:none;">
				<label>Homeshow / Event</label>
					<select id="newlead-eventid" name="newlead-eventid" >
						<option value="0">None</option>
						@foreach($events as $val)
						<option value="{{$val->id}}">{{$val->event_name}}</option>
						@endforeach
					</select><br/>
				</div>
				<div class="span3 entryDateBox" style="display:none;">
				 	<label>Date Survey was Done </label>
								<div class="controls">
								    <div class="input-append date" id="datepicker-js" data-date="{{date('Y-m-d')}}" data-date-format="yyyy-mm-dd">
										<input class="datepicker-input" size="16" id="newlead-entrydate" name="newlead-entrydate" type="text" value="{{date('Y-m-d')}}" placeholder="Select a date" />
										<span class="add-on"><i class="cus-calendar-2"></i></span>
									</div>
								</div>
				</div>
				<div class="span3">
				 	<label>Researcher / Referrer </label>
					<select id="newlead-researcher" name="newlead-researcher" >
						<option value=""></option>
						@foreach($res as $val)
						<option class="researchers researcher-{{$val->user_type}}" value="{{$val->id}}|{{$val->firstname}}|{{$val->lastname}}">{{$val->firstname}} {{$val->lastname}}</option>
						@endforeach
					</select><br/>
					<span class='small'>Optional : Defaults to yourself, if not chosen</span>
				</div>
			</div>

			<div class='row-fluid'>
				<div class='span7'>
                  		<div class="span5">
                  		 	<label>Customer Name</label>
                  		      <input type="text" name="newlead-name" id="newlead-name" /> 
                  		      <label>Spouse Name</label>
                  		      <input type="text" name="newlead-spouse" id="newlead-spouse"  />  
                  		</div>
	
                  		<div class="span7">
						<label>Address</label>
						<input type="text" class="addressDropdown new-leadAddress" name="newlead-address" id="newlead-address" />
                  		      <label>City</label>
                  		      <select name="newlead-city" id="newlead-city">
                  		            <option value=""></option>
                  		                  @foreach($cities as $val)
                  		                        <option value="{{$val->cityname}}">{{$val->cityname}}</option>
                  		                  @endforeach
                  		      </select>
                  		      
                  		      <label>House Type (Optional)</label>
                  		      <select name="newlead-homestead" id="newlead-homestead">
                  		            <option value=""></option>
                  		            <option value="house">House</option>
                  		            <option value="condominium">Condominium</option>
                  		            <option value="apartment">Apartment</option>
                  		            <option value="townhouse">Townhouse</option>
                  		            <option value="detached">Detached / Mobile Home</option>
                  		            <option value="bungalow">Bungalow</option>
                  		      </select>
                  		</div>

					<div class='span8' style='margin-top:25px;margin-left:-3px;'>
						<label>Notes</label>
						<textarea name="newlead-notes" id="newlead-notes"></textarea>
						<label class="control-label">PICK A STATUS</label>
                        	      <div class="controls">
							<div class="btn-group" data-toggle="buttons-radio">
								<button type="button" class="btn btn-small newlead-process active" data-status="NEW">
									<i class="cus-add"></i>&nbsp;NEW
								</button>
								 <button type="button" class="btn btn-small newlead-process APPBUT " data-status="APP">
			      	                  	<i class="cus-clock"></i>&nbsp;APP
			      	                  </button>
			      	                  <button type="button" class="btn btn-small newlead-process APPBUT" data-status="Recall">
			      	                  	<i class="cus-arrow-redo"></i>&nbsp;Recall
			      	                  </button>
								<button type="button" class="btn btn-small newlead-process" data-status="NI">
									<i class="cus-cross"></i>&nbsp;NI
								</button>
								
			      	                  <button type="button" class="btn btn-small newlead-process" data-status="DNC">
			      	                  	<i class="cus-delete"></i>&nbsp;DNC
			      	                  </button>
			      	                  <button type="button" class="btn btn-small newlead-process " data-status="NQ">
			      	                  	<i class="cus-delete"></i>&nbsp;NQ
			      	                  </button>
			      	                 
                        	                	<input type="hidden" id="newlead-status" name="newlead-status" value="NEW" />
			      	            </div>
						</div>
					</div>
					
            		</div>
	            	<div class="span4">

	            		<div class="span5 optional" style="margin-bottom:20px;" >
	            			<h5>Optional Data</h5>
	            			<label>Sex / Gender</label>
                  		      <select name="newlead-sex" id="newlead-sex" style="width:75%;">
                  		            <option value=""></option>
                  		            <option value="male">Male</option>
                  		            <option value="female">Female</option>
                  		      </select>
                  			<label>Age Range</label>
                  		      <select name="newlead-agerange" id="newlead-agerange" style="width:75%;">
                  		            <option value=""></option>
									<option value="21-35">21-35</option>
									<option value="36-50">36-50</option>
									<option value="51-75">51-75</option>
									<option value="75-85">75-85</option>
                  		      </select>
                  		 	
                  		      <label>Marital Status</label>
                  		      
                  		      <select name="newlead-marital" id="newlead-marital" style="width:75%;">
                  		            <option value="single">Single</option>
                  		            <option value="married">Married</option>
                  		            <option value="commonlaw">Commonlaw</option>
                  		            <option value="widowed">Widowed</option>
                  		      </select><br/>
                  		      <label>Occupation</label>
                  		      <input type="text" name="newlead-job" id="newlead-job" /> <br/>
                  		      <br/>
                  		      
                  		      Full-Time&nbsp;<input type="checkbox" name="newlead-fullpart[]" value='FT' /><br/>
                  		      Part Time&nbsp;<input type="checkbox" name="newlead-fullpart[]"  value='PT' /><br/>
                  		      Retired &nbsp;<input type="checkbox" name="newlead-fullpart[]"  value='R' /><br/><br/>
                  		      Rent&nbsp;<input type="checkbox" name="newlead-rentown[]" value='rent' /><br/>
                  		      Own&nbsp;<input type="checkbox" name="newlead-rentown[]"  value='own' /><br/>
                  		</div>



	            		<div class="control-group dateForms" id="appointmentBook" style="display:none;">
							<label class="control-label">Appointment Date</label>
								<div class="controls">
								    <div class="input-append date" id="datepicker-js" data-date="{{date('Y-m-d')}}" data-date-format="yyyy-mm-dd">
										<input class="datepicker-input" size="16" id="newlead-appdate" name="newlead-appdate" type="text" value="{{date('Y-m-d')}}" placeholder="Select a date" />
										<span class="add-on"><i class="cus-calendar-2"></i></span>
									</div>
								</div>
                            		<label class="control-label">Pick an Appointment Time</label>
                            		<input id="newlead-booktimepicker" name="newlead-booktimepicker" type="text"  placeholder="Select Time..." style="width:20%;"/>
                            		<label>Choose Gift</label>
						<select id="newlead-gift" name="newlead-gift" >
							<option value=""></option>
							<?php $gifts = Gift::get();?>
							@if(!empty($gifts))
							@foreach($gifts as $val)
							<option value="{{$val->name}}">{{$val->name}}</option>
							@endforeach
							@endif
						</select>
					</div>
					<div class="control-group dateForms" id="recallDate" style="display:none;">
							<label class="control-label">Recall Date</label>
								<div class="controls">
								    <div class="input-append date" id="datepicker-js" data-date="{{date('Y-m-d')}}" data-date-format="yyyy-mm-dd">
										<input class="datepicker-input" size="16" id="newlead-recalldate" name="newlead-recalldate" type="text" value="{{date('Y-m-d')}}" placeholder="Select a date" />
										<span class="add-on"><i class="cus-calendar-2"></i></span>
									</div>
								</div>
                            		
					</div></form>
                  		<div id="newlead-map" style="height:175px;width:100%;margin-top:10px;margin-bottom:20px;"></div>
            		</div>
            	</div>
		
	</div>


	<div class="modal-footer">
		<button class='btn btn-warning btn-large nextLead blackText' style="float:left;margin-left:450px;">NEXT ENTRY</button>
		<a href="#" class="btn btn-danger closeNewLead" data-dismiss="modal">Close</a>
		<button class='btn btn-primary saveNewLead'>SAVE</button>&nbsp;&nbsp;&nbsp;
		
	</div>
</div>

<script>
$(document).ready(function(){
$('.closeNewLead').click(function(){
	$('#newLeadEntry')[0].reset();
	$('.findReferralLead').hide();
	$('.entryDateBox').hide();
	$('.homeshowBox').hide();
});

$('#newlead-findlead').keyup(function(e){

	if(e.which == 13 || e.which ==32 || e.which==9)
    		{
    			var val = $(this).val();
    			$.getJSON("{{URL::to('lead/ajaxleadsearch')}}",{searchterm:val},function(data){
    				var html="";
    				if(data){
    					$.each(data,function(i,val){
    						html+="<li class='getLeadFromSearch' data-id='"+val.id+"' data-name='"+val.cust_name+"' >#"+val.id+" | "+val.cust_name+" | "+val.cust_num+" | "+val.address+" | "+val.status+"</li>";
    					});
    					$('#leadResultBox').show();
    					$('.leadResults').html("<img src='{{URL::to_asset('img/loaders/misc/66.gif')}}'>");
    					if(html==""){
    						html = "<h4>No Leads Match Search....</h4>"
    						$('.leadResults').html("").append(html);
    					} else {
    						$('.leadResults').html("").append("<h5>Click to choose who referred this lead/entry</h5>"+html);
    					}
    					
    				}
    			});
    		}
});

$(document).on('click','.getLeadFromSearch',function(){
	var id = $(this).attr('data-id');
	var name = $(this).attr('data-name');
	
	$('#newlead-referralHidden').val(id);
	$('#newlead-findlead').val(name+" - Lead # "+id);
	$('#leadResultBox').hide();
});

$("#newlead-booktimepicker").timePicker({
  startTime: "10:00", 
  endTime: new Date(0, 0, 0, 23, 30, 0), 
  show24Hours: false,
  step: 15});

$('#newlead-notes').keypress(function(e){
	if(e.which == 13){//Enter key pressed
      	$('.nextLead').click();// $('#searchButton').click();//Trigger search button click event
      	$('#newlead-custnum').focus();
	}
});

$('#newlead-booktimepicker').css('z-index','50000');

$('.newlead-process').click(function(){
	var sts = $(this).data('status');
	$('.optional').show();
	$('input#newlead-status').val(sts);
	if($(this).hasClass('APPBUT')){
	$('.dateForms').hide();
	if($(this).data('status')=="APP"){
		$('.optional').hide();
	$('#appointmentBook').show(200);
		} else {
	$('.optional').hide();
	$('#recallDate').show(200);
	}
       	$('#newlead-map').hide();
	} else {
		$('.dateForms').hide();
		$('#newlead-map').show(200);
	}
});

$('.saveNewLead').click(function(e){
	e.preventDefault();
	var form = $('#newLeadEntry').serialize();
	$.getJSON("{{URL::to('lead/addnewlead')}}",form,function(data){
		if(data=="alreadyexists"){
			toastr.error("Number already exists in system!! And you have not allowed duplicates","NUMBER EXISTS, DUPLICATES NOT ALLOWED!");
		} else if(data=="nocity"){
			toastr.error("Please Enter a City for this lead!");
		} else if(data=="noname"){
			toastr.error("Please Enter the Customers Name!");
		} else if(data=="nonum"){
			toastr.error("Please Enter a Valid phone number for this lead!");
		} else if(data=="cannotbook") {
			toastr.error("You cannot book a lead this far in advance!","BOOKING TOO FAR AHEAD");
		} else {
			sendNumToSearch(data.cust_num);
			$('.newLeadModal').modal('hide');
			$('#newLeadEntry').trigger("reset");
			$('.entryDateBox').hide();
			$('.homeshowBox').hide();
			$('.findReferralLead').hide();
		}
	});
});


	$('#newlead-leadtype').on('change',function(e){
		var type = $(this).val();
		$('.researchers').hide();
		if(type=="door"){
			$('.researcher-doorrep').show();
			$('.researcher-salesrep').show();
		} else if(type=="paper"){
			$('.researcher-researcher').show();
		} else if(type=="other"){
			$('.researcher-agent').show();
		} else if(type=="personal"){
			$('.researcher-salesrep').show();
		} else if(type=="coldcall"){
			$('.researcher-agent').show();
		} else if(type=="doorknock"){
			$('.researcher-salesrep').show();
		} else {
			$('.researchers').show();
		}

		if(type=="door" || type=="ballot" || type=="homeshow" || type=="doorknock" || type=="coldcall"){
			$('.entryDateBox').show(200);
		} else {
			$('.entryDateBox').hide(200);
		}
		if(type=="homeshow"){
			$('.homeshowBox').show(200);
		} else {
			$('.homeshowBox').hide(200);
		}
		if(type=="referral"){
			$('.findReferralLead').show(200);
		} else {
			$('.findReferralLead').hide(200);
		}
	});

	
	

	$('#newlead-custnum').on('blur', function(e) {
 		var value = $(this).val();

		if(value.length!=0){
			$.get( "{{URL::to('lead/checkscratchnum/')}}"+value, function( data ) {
				if(data){
 					toastr.error('<a href="../../lead/newlead/'+value+'">Click Here to View This Lead</a>...', 'Number already exists in system!');
 					setTimeout(function(){
 						$('#lead_edit_modal').modal('hide');
 						sendNumToSearch(value);
 					},500)
 					
				} else {
					if(value.length != 12) { 
 						toastr.warning('Please enter a valid phone number', 'Not a valid 10 digit number!!');
					} else {
					toastr.success('You can continue entering Lead information', 'Number is Valid!');
					}
				}
			});
		}
	});



function sendNumToSearch(num){
		var e = $.Event("keyup");
   		e.which = 13;
		$('.leadSearch').val(num).focus().trigger(e);
		setTimeout(function(){
			toastr.success("Searching Number "+ num ,"Searching Number in Database");
		},400)
		
	}


$('.nextLead').click(function(e){
var sel = $("#newlead-leadtype").val();
var cit = $('#newlead-city').val();
var dat = $('#newlead-entrydate').val();
e.preventDefault();
	var form = $('#newLeadEntry').serialize();
	$.getJSON("{{URL::to('lead/addnewlead')}}",form,function(data){
		if(data=="alreadyexists"){
			toastr.error("Number already exists in system!!","NUMBER EXISTS!");
		} else if(data=="nocity"){
			toastr.error("Please Enter a City for this lead!");
		} else if(data=="noname"){
			toastr.error("Please Enter the Customers Name!");
		} else if(data=="nonum"){
			toastr.error("Please Enter a Valid phone number for this lead!");
		} else {
			toastr.success("Lead successfully entered");
			$('#newLeadForm').find('form')[0].reset();
			$('#newlead-leadtype').val(sel);
			$('#newlead-entrydate').val(dat);
			$('#newlead-city').val(cit);
			$('.entryDateBox').hide();
			$('.homeshowBox').hide();
			$('.findReferralLead').hide();
		}
	});
});
});
</script>
