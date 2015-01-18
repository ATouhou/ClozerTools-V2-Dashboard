<Style>
.modal {
  position: fixed;
  top: 10px;
  right: 0;
  bottom: 100%;
  left: 1000px;
  margin: 0px;
  width: 100%;
  height: 85%;
}
.modal-body {
  max-height: 100%;
}
.modal.fade.in {
  top: 0;
}

</style>

<div class="modal large hide fade" id="enternew_modal" style="">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h2 style="color:#fff;">ENTER NEW PAPER SURVEY</h2>
	</div>
	<div class="modal-body" style="overflow:none">
		<div class="span8">
			<form id="leadinfo" action="{{URL::to('lead/enternew')}}" method="post">
				<h4>Researcher</h4>
				<select name="researcher">
                   		<option value="" ></option>
                   		@foreach($res as $val)
                   		<option value="{{$val->id}}">{{$val->lastname}}, {{$val->firstname}} </option>
                   		@endforeach
                   	</select>

				<h4>Lead Details</h4>
				<input type="hidden" name="leadid" id="leadid" value="">
				<label class="control-label" for="prefix">Prefix : </label>
					<select name="prefix">
                   		<option value="" ></option>
                   		<option value="Mr." >Mr.</option>
                   		<option value="Mrs." >Mrs.</option>
                   	</select>
 				<label class="control-label" for="prefix">First Name :</label>
                <input name="firstname" type="text" size="40" value=""></input>
                <label class="control-label" for="prefix">Last Name :</label>
				<input name="lastname" type="text" size="40" value=""></input>
				<h4>Customer Number</h4>
					<label class="control-label" for="prefix">Phone Number : </label>
                	<input name="phonenumber" type="text" size="40" value=""></input>

                <h4>Questions</h4>
					<label class="control-label" for="prefix">Do You Smoke? </label>
                	<input name="question[]" class="checkbox" type="checkbox" value="smoke"></input>
                	<label class="control-label" for="prefix">Do You Have Asthma? </label>
                	<input name="question[]" class="checkbox" type="checkbox" value="asthma"></input>
                	<label class="control-label" for="prefix">Do You Own Pets? </label>
                	<input name="question[]" class="checkbox" type="checkbox" value="pets"></input>
                	<label class="control-label" for="prefix">Do You Own Pets? </label>
                	<select name="rentown">
                   		<option value="" ></option>
                   		<option value="R" >Rent</option>
                   		<option value="O" >Own</option>
                   	</select>
                   	<select name="married">
                   		<option value="" ></option>
                   		<option value="married" >Married</option>
                   		<option value="single" >Single</option>
                   		<option value="commonlaw" >Common Law</option>
                   	</select>
                   	<select name="yrs">
                   		<option value="" ></option>
                   		<option value="1 Year" >1 Year</option>
                   		<option value="2 Years" >2 Years</option>
                   		<option value="3 Years" >3 Years</option>
                   		<option value="4 Years" >4 Years</option>
                   		<option value="5+ Years" >5+ Years</option>
                   		<option value="10+ Years" >10+ Years</option>
                   	</select>




				<h4>Customer Number</h4>
					<div id="info" style="margin-bottom:40px;">
						<div class="control-group">
							<label class="control-label" for="address">Address</label>
								<div class="controls">
									<input type="text" class="span5" name="address" id="address" value="" />
								</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="suitenum">Suite #</label>
								<div class="controls">
									<input type="text" class="span5" name="suitenum" id="suitenum" value=""/>
								</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="city">City</label>
								<div class="controls">
									<input type="text" class="span5" name="city" id="city" value="" />
								</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="postalcode">Postal Code</label>
								<div class="controls">
									<input type="text" class="span5" name="postalcode" id="postalcode" value=""/>
								</div>
						</div>
					</div>	
					
					<h4>Collect Customer info</h4>
					
				        
						<div id="info" style="margin-bottom:40px;">
							<div class="control-group">
								<div class="controls">
									<select id="marriagestatus" name="marriagestatus" class="span2">
										<option value="married">Married</option>
										<option value="commonlaw">Common Law</option>
										<option value="single">Single</option> 
								    </select>
								</div>
							</div>

							<div class="control-group">
								<label class="control-label" for="name">First Name : </label>
									<div class="controls">
										<input type="text" class="span5" name="name" id="name" value="" />
									</div>
							</div>

							<div class="control-group">
								<label class="control-label" for="spousename">Spouse Name : </label>
									<div class="controls">
										<input type="text" class="span5" name="spousename" id="spousename" value="" />
									</div>
							</div>

							<div class="control-group">
									<label class="control-label" for="select01">What gift would you like?</label>
									<div class="controls">
										<select id="gift" name="gift" class="span2 with-search">
											<option value="slapchop">Slap Chop</option>
											<option value="snuggie">Snuggie</option>
											<option value="vacation">Vacation</option>
								        </select>
									</div>
							</div>
						</div>	

						<h4>Book a Demo (if customer agrees)</h4>
						<div class="control-group" >
							<label class="control-label">Appointment Date</label>
								<div class="controls">
								    <div class="input-append date" id="datepicker-js" data-date="{{date('Y-m-d')}}" data-date-format="yyyy-mm-dd">
										<input class="datepicker-input" size="16" id="appdate" name="appdate" type="text" value="{{date('Y-m-d')}}" placeholder="Select a date" />
										<span class="add-on"><i class="cus-calendar-2"></i></span>
									</div>
								</div>
						</div>
						<div class="control-group" id="timepicker-demo" style="margin-bottom:40px;">
							<label class="control-label">Pick an Appointment Time</label>
								<div class="controls">
									<div class="input-append bootstrap-timepicker-component">
										<input id="booktimepicker" name="booktimepicker" type="text" class="timepicker-input" value="05:30 PM" />
										<span class="add-on"><i class="cus-clock"></i></span>
									</div>
								</div>
						</div>

						<h4>What was the result of this call?</h4>
						<div class="control-group">
							<label class="control-label">PICK A STATUS</label>
								<div class="controls">
									<div class="btn-group" data-toggle="buttons-radio">
										<button type="button" class="btn btn-small process " data-status="APP"><i class="cus-clock"></i>&nbsp;APP</button>
										<button type="button" class="btn btn-small process" data-status="NH"><i class="cus-house"></i>&nbsp;NH</button>
										<button type="button" class="btn btn-small process" data-status="NI"><i class="cus-cross"></i>&nbsp;NI</button>
										
										<button type="button" class="btn btn-small process active" data-status="Recall"><i class="cus-arrow-redo"></i>&nbsp;RECALL</button>
			                            <button type="button" class="btn btn-small process" data-status="DNC"><i class="cus-delete"></i>&nbsp;DNC</button>
			                        </div>
								</div>
								<input type="hidden" name="status" id="status" value="Recall" />
						</div>

		   <button class="btn btn-primary btn-large" style="margin-top:40px;"><i class="icon-ok icon-white"></i>&nbsp; PROCESS APP</button>
	</form></div></div>
	</div>
</div>
<script>
$(document).ready(function(){
$('.process').click(function(){
var sts = $(this).data('status');
$('input#status').val(sts);
});
});
</script>



