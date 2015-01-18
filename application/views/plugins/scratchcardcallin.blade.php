
<style>
.modal{
    z-index: 2;   
}
.modal-backdrop{
    z-index: 1;        
}​
</style>
<?php 
 $scratchscript = Script::where('type','=','scratch')->first();
 $finalscript = Script::where('type','=','finalnotice')->first();
$s = City::where('cityname','=','scratch')->first();
$fgifts = Gift::get();
$scratchgifts = array($s->attributes['gift_one'],$s->attributes['gift_two'],$s->attributes['gift_three'],$s->attributes['gift_four']);
$res = User::where('level','!=',99)->where('user_type','!=','manager')->order_by('firstname')->get();
$events = Eventshow::get();
$cities = City::where('status','!=','leadtype')->order_by('cityname','ASC')->get();
$settings = Setting::find(1);?>
<div class="modal hide fade scratchCardModal" id="scratch_card_modal" style="width:1080px;margin-left:-680px;">
	<div class="modal-header">
		<h3><span class='title'>Enter New Scratch Card / Call In (You Cannot Exit This Window Unless You Enter Info)</span></h3>
	</div>
	<div class="modal-body">
		<form id="newScratchEntry" method="post" action="" >
			<div class="row-fluid">
			<div class="span3">
                  	<label>Customer Number <b>(with dashes!!)</b></label>
                  	      <input type="text" class="animated shake" name="newscratch-custnum" maxlength=12 id="newscratch-custnum" onKeyup="addDashes(this)"  />
                  	
                  	<label>Customer Name</label>
                  		<input type="text" name="newscratch-name" id="newscratch-name" />
                  	<label>Address</label>
						<input type="text" class="scratchAddress" name="newscratch-address" id="newscratch-address" />
				<label>City</label>
                  		<select name="newscratch-city" id="newscratch-city">
                  		      <option value=""></option>
                  		      @foreach($cities as $val)
                  		      <option value="{{$val->cityname}}">{{$val->cityname}}</option>
                  		      @endforeach
                  		</select>
                  	<label>Marital Status</label>
            		<select name="newscratch-married" id="married">
					<option value="married">Married</option>
					<option value="single">Single</option>
					<option value="commonlaw">Common Law</option>
					<option value="widowed">Widow</option>
				</select>
                  	<label>Spouse Name</label>
                  		<input type="text" name="newscratch-spouse" id="newscratch-spouse"  />  
                  </div> 
                  <div class="span3">
                  	<label for="select01">Lead Type</label>
					<select id="newscratch-leadtype" name="newscratch-leadtype" style="z-index:50000">
						<option value="other" >Scratch Card</option>
						<option value="finalnotice">Final Delivery Notice</option>
					</select><br/>
					<div id="newscratch-researcher" style="display:none;">
					<label>Researcher / Referrer </label>
					<select  name="newscratch-researcher" >
						<option value=""></option>
						@foreach($res as $val)
						<option class="researchers researcher-{{$val->user_type}}" value="{{$val->id}}|{{$val->firstname}}|{{$val->lastname}}">{{$val->firstname}} {{$val->lastname}}</option>
						@endforeach
					</select><br/>
					<span class='small'>Optional : Defaults to yourself, if not chosen</span>
					</div>
					<label>Notes</label>
						<textarea name="newscratch-notes" id="newscratch-notes"></textarea>
						<label class="control-label">PICK A STATUS</label>
                        	      <div class="controls" id="status-controls">
							<div class="btn-group" data-toggle="buttons-radio">
								<button type="button" class="btn btn-small newscratch-process APPBUT " data-status="APP">
			      	                  	<i class="cus-clock"></i>&nbsp;APP
			      	                  </button>
			      	                  <button type="button" class="btn btn-small newscratch-process APPBUT" data-status="Recall">
			      	                  	<i class="cus-arrow-redo"></i>&nbsp;Recall
			      	                  </button>
								<button type="button" class="btn btn-small newscratch-process" data-status="NI">
									<i class="cus-cross"></i>&nbsp;NI
								</button>
			      	                  <button type="button" class="btn btn-small newscratch-process " data-status="NQ">
			      	                  	<i class="cus-delete"></i>&nbsp;NQ
			      	                  </button>
                        	            <input type="hidden" id="newscratch-status" name="newscratch-status" value="" />
			      	            </div>
						</div>
				
				<div class="control-group dateForms" id="scratch-appointmentBook" style="display:none;">
							<label class="control-label">Appointment Date</label>
								<div class="controls">
								    <div class="input-append date" id="datepicker-js" data-date="{{date('Y-m-d')}}" data-date-format="yyyy-mm-dd">
										<input class="datepicker-input" size="16" id="newscratch-appdate" name="newscratch-appdate" type="text" value="{{date('Y-m-d')}}" placeholder="Select a date" />
										<span class="add-on"><i class="cus-calendar-2"></i></span>
									</div>
								</div>
                            		<label class="control-label">Pick an Appointment Time</label>
                            		<input id="newscratch-booktimepicker" name="newscratch-booktimepicker" type="text"  placeholder="Select Time..." style="width:80%;"/>
                            		<label for="select01">Chosen Gift</label>
					<select name="newscratch-gift" id="gift" >
						<option value=""></option>
						<?php 
						$c=0;$g="";?>
						@foreach($fgifts as $val)
						<option value="{{$val->name}}">{{$val->name}}</option>
						@endforeach
					</select>
					</div>
					<div class="control-group dateForms" id="scratch-recallDate" style="display:none;">
							<label class="control-label">Recall Date</label>
								<div class="controls">
								    <div class="input-append date" id="datepicker-js" data-date="{{date('Y-m-d')}}" data-date-format="yyyy-mm-dd">
										<input class="datepicker-input" size="16" id="newscratch-recalldate" name="newscratch-recalldate" type="text" value="{{date('Y-m-d')}}" placeholder="Select a date" />
										<span class="add-on"><i class="cus-calendar-2"></i></span>
									</div>
								</div>
                            		
					</div>
			</div>
                  <div class="span5">
                  	<h5>Optional Data</h5>
					<div class="span5">
						<label>Sex / Gender</label>
                  		      <select name="newscratch-sex" id="newscratch-sex" style="width:75%;">
                  		            <option value=""></option>
                  		            <option value="male">Male</option>
                  		            <option value="female">Female</option>
                  		      </select>
                  		<label>Age Range</label>
                  		      <select name="newscratch-agerange" id="newscratch-agerange" style="width:75%;">
                  		            <option value=""></option>
									<option value="21-35">21-35</option>
									<option value="36-50">36-50</option>
									<option value="51-75">51-75</option>
									<option value="75-85">75-85</option>
                  		      </select>
						
                  		 	<label>Occupation</label>
                  		      <input type="text" name="newscratch-job" id="newscratch-job" style="width:75%;" /> 
                  		</div>
                  		<div class="span3">
                  			 <label>House Type</label>
                  		      <select name="newscratch-homestead" id="newscratch-homestead" style="width:75%;">
                  		            <option value=""></option>
                  		            <option value="house">House</option>
                  		            <option value="condominium">Condominium</option>
                  		            <option value="apartment">Apartment</option>
                  		            <option value="townhouse">Townhouse</option>
                  		            <option value="detached">Detached / Mobile Home</option>
                  		            <option value="bungalow">Bungalow</option>
                  		      </select><br/>
                  		      Rent&nbsp;<input type="checkbox" name="newscratch-rentown[]" value='rent' /><br/>
                  		      Own&nbsp;<input type="checkbox" name="newscratch-rentown[]"  value='own' /><br/>	 
                  		</div>
                  		<div class="span3">
                  			 Full-Time&nbsp;<input type="checkbox" name="newscratch-fullpart[]" value='FT' /><br/>
                  		      Part Time&nbsp;<input type="checkbox" name="newscratch-fullpart[]"  value='PT' /><br/>
                  		      Retired &nbsp;<input type="checkbox" name="newscratch-fullpart[]"  value='R' /><br/><br/>

                  		</div>
                  	<div class="span12">		
                  	@if(!empty($scratchscript))
				<div class="animated fadeInUp well callinScript script-scratch">
					<?php $script = $scratchscript;
					$s = str_replace("[[NAME]]","<strong><span class='scriptval-bookername'>".Auth::user()->firstname."</span></strong>",$script->script);
					$s = str_replace("[[CUSTNAME]]","<strong><span class='scriptval-custname'>Customer Name</span></strong>",$s);
					$s = str_replace("[[SPOUSENAME]]","<strong><span class='scriptval-spousename'>Spouse Name</span></strong>",$s);
					$s = str_replace("[[ADDRESS]]","<span class='label label-info special'><span class='scriptval-address'>Address</span></span><br><br>",$s);
					$s = str_replace("[[CHOSEN-GIFT]]","<span class='label label-info special'><span class='scriptval-gift'>Gift</span></span><br><br>",$s);
					$s = str_replace("[[GIFTS]]",$g,$s);?>
					{{$s}}
				</div>
				@endif
			
				@if(!empty($finalscript))
				<div class="animated fadeInUp well callinScript script-finalnotice" style="display:none;">
					<?php $script = $finalscript;
					$s = str_replace("[[NAME]]","<strong><span class='scriptval-bookername'>".Auth::user()->firstname."</span></strong>",$script->script);
					$s = str_replace("[[CUSTNAME]]","<strong><span class='scriptval-custname'>Customer Name</span></strong>",$s);
					$s = str_replace("[[SPOUSENAME]]","<strong><span class='scriptval-spousename'>Spouse Name</span></strong>",$s);
					$s = str_replace("[[ADDRESS]]","<span class='label label-info special'><span class='scriptval-address'>Address</span></span><br><br>",$s);
					$s = str_replace("[[CHOSEN-GIFT]]","<span class='label label-info special'><span class='scriptval-gift'>Gift</span></span><br><br>",$s);
					$s = str_replace("[[GIFTS]]",$g,$s);?>
					{{$s}}
				</div>
				@endif
				</div>
				
                 	</div>
                 </div>
		</form>
	</div>
	<div class="modal-footer">
		<button class='btn btn-primary saveNewScratchLead'>SAVE</button>&nbsp;&nbsp;&nbsp;
	</div>
</div>

<script>
$(document).ready(function(){
	//Detect leadtype change for script switch
	$('#newscratch-leadtype').on('change',function(e){
		var type = $(this).val();
		$('.callinScript').hide();
		if(type=="other"){
			$('.script-scratch').show();
			$('#newscratch-researcher').hide();
		} else if(type=="finalnotice"){
			$('.script-finalnotice').show();
			$('#newscratch-researcher').show();
		}
	});

	// Time picker for booking appointments
	$("#newscratch-booktimepicker").timePicker({
	  startTime: "10:00", 
	  endTime: new Date(0, 0, 0, 23, 30, 0), 
	  show24Hours: false,
	  step: 15});
	//Re-order time picker to display above modal
	$('#newscratch-booktimepicker').css('z-index','50000');

	$('.newscratch-process').click(function(){
		var sts = $(this).data('status');
		$('.optional').show();
		$('input#newscratch-status').val(sts);
		if($(this).hasClass('APPBUT')){
			$('.dateForms').hide();
			if($(this).data('status')=="APP"){
				$('#scratch-appointmentBook').show(200);
			} else {
				$('#scratch-recallDate').show(200);
			}
		} else {
			$('.dateForms').hide();
		}
	});

	$('.saveNewScratchLead').click(function(e){
		e.preventDefault();
		var button = $(this);
			var form = $('#newScratchEntry').serialize();
			$.getJSON("{{URL::to('lead/addnewscratch')}}",form,function(data){
				if(data=="alreadyexists"){
					toastr.error("Number already exists in system!! And you have not allowed duplicates","NUMBER EXISTS, DUPLICATES NOT ALLOWED!");
				} else if(data=="nocity"){
					toastr.error("Please Enter a City for this lead!");
				} else if(data=="noname"){
					toastr.error("Please Enter the Customers Name!");
				} else if(data=="nonum"){
					toastr.error("Please Enter a Valid phone number for this lead!");
				} else if(data=="notvalidnum"){
					toastr.error("Please Enter a Valid phone number for this lead!","INVALID PHONE NUMBER - TOO SHORT");
				} else if(data=="cannotbook") {
					toastr.error("You cannot book a lead this far in advance!","BOOKING TOO FAR AHEAD");
				} else if(data=="needtime") {
					toastr.error("You need to select a time for this appointment!","APPOINTMENT TIME NEEDED");
				}else {
					button.prop('disabled',true).html("<img src='{{URL::to('img/loaders/misc/56.gif')}}'>&nbsp;&nbsp; PROCESSING...");
					$('.newScratchModal').modal('hide');
					window.location.reload();
				}
			});
	});

	$('#newscratch-custnum').on('blur', function(e) {
 		var value = $(this).val();
		if(value.length!=0){
			$.get( "{{URL::to('lead/checkscratchnum/')}}"+value, function( data ) {
				if(data){
 					toastr.error('<a href="../../lead/newlead/'+value+'">Click Here to View This Lead</a>...', 'Number already exists in system!');
 					setTimeout(function(){
 						$('#lead_edit_modal').modal('hide');
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

});
</script>
