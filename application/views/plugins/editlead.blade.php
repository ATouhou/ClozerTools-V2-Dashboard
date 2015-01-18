

<?php $res = User::where('user_type','=','doorrep')->or_where('user_type','=','agent')->order_by('user_type')->order_by('firstname')->where('level','!=',99)->get();
$cities = City::where('status','!=','leadtype')->get();?>

<div class="modal hide fade newLeadModal" id="lead_edit_modal" >
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h3><span class='title'>Enter New Lead</span></h3>
	</div>

	<div id="newLeadForm" style="padding-top:10px;padding-left:20px;">

		 <form id="newlead" method="post" action="" >

		 	<div class='row-fluid' style='width:80%;padding-bottom:10px;margin-bottom:10px;border-bottom:1px solid #ddd;'>
                  	<div class="span3">
                  		<label>Customer Number</label>
                  	      <input type="text" name="newlead-custnum" id="newlead-custnum" />
                  	     
                  	</div>
                  	<div class="span3">
                   		<label for="select01">Lead Type</label>
					<select id="newlead-leadtype" name="newlead-leadtype" style="z-index:50000">
						<option value="door"> Door</option>
						<option value="paper" >Paper / Manilla</option>
						<option value="other" >Scratch / Other</option>
						<option value="homeshow" >Home Show</option>
						<option value="ballot" >Ballot Box</option>
						<option value="referral" >Referral</option>
					</select>
				</div>
				<div class="span3">
				 	<label>Researcher </label>
					<select id="newlead-researcher" name="newlead-researcher" >
						<option value=""></option>
						@foreach($res as $val)
						<?php if($val->user_type=="agent"){$type="Booker";} else {$type="Door Reggier";};?> 
						<option value="{{$val->id}}">{{$val->firstname}} {{$val->lastname}}  &nbsp;&nbsp;&nbsp;&nbsp;|  {{$type}}</option>
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
						<input type="text" name="newlead-address" id="newlead-address" />
                  		      <label>City</label>
                  		      <select name="newlead-city" id="newlead-city">
                  		            <option value=""></option>
                  		                  @foreach($cities as $val)
                  		                        <option value="{{$val->cityname}}">{{$val->cityname}}</option>
                  		                  @endforeach
                  		      </select>
                  		</div>

					<div class="control-group" style="margin-top:50px;">
						<label class="control-label">PICK A STATUS</label>
                        	      <div class="controls">
							<div class="btn-group" data-toggle="buttons-radio">
								<button type="button" class="btn btn-small newlead-process active" data-status="NEW">
									<i class="cus-add"></i>&nbsp;NEW
								</button>
								<button type="button" class="btn btn-small newlead-process" data-status="NH">
									<i class="cus-house"></i>&nbsp;NH
								</button>
								<button type="button" class="btn btn-small newlead-process" data-status="NI">
									<i class="cus-cross"></i>&nbsp;NI
								</button>
								<button type="button" class="btn btn-small newlead-process RCBUT" data-status="Recall">
									<i class="cus-arrow-redo"></i>&nbsp;RECALL
								</button>
								<button type="button" class="btn btn-small newlead-process" data-status="WrongNumber">
									<i class="cus-disconnect"></i>&nbsp;WRONG NUM
								</button>
			      	                  <button type="button" class="btn btn-small newlead-process" data-status="DNC">
			      	                  	<i class="cus-delete"></i>&nbsp;DNC
			      	                  </button>
			      	                  <button type="button" class="btn btn-small newlead-process " data-status="NQ">
			      	                  	<i class="cus-delete"></i>&nbsp;NQ
			      	                  </button>
			      	                  <button type="button" class="btn btn-small newlead-process APPBUT " data-status="APP">
			      	                  	<i class="cus-clock"></i>&nbsp;APP
			      	                  </button>
                        	                	<input type="hidden" id="status" name="status" value="NEW" />
			      	            </div>
						</div>
					</div>
					<div class="bookdemo" >
						<div class="control-group" >
							<label class="control-label">Appointment Date</label>
								<div class="controls">
								    <div class="input-append date" id="datepicker-js" data-date="{{date('Y-m-d')}}" data-date-format="yyyy-mm-dd">
										<input class="datepicker-input" size="16" id="appdate" name="appdate" type="text" value="{{date('Y-m-d')}}" placeholder="Select a date" />
										<span class="add-on"><i class="cus-calendar-2"></i></span>
									</div>
								</div><br/>
                            		<label class="control-label">Pick an Appointment Time</label>
                            		<input id="booktimepicker" name="booktimepicker" type="text"  placeholder="Select Time..." style="width:10%;"  />
						</div>
					</div>
            		</div>
	            	<div class="span4">
                  		<div id="newlead-map" style="background:black;height:300px;width:100%;"></div>
            		</div>
            	</div>
                
						
				

					

					<div class="controls" id="recallbox" style="margin-top:8px;display:none"><br/>
						Select a Date for Recalling this Customer<br/>
						<div class="input-append date" id="datepicker-js" data-date="{{date('Y-m-d')}}" data-date-format="yyyy-mm-dd">
							<input class="datepicker-input" size="16" id="recalldate" name="recalldate" type="text" value="{{date('Y-m-d')}}" placeholder="Select a date" />
							<span class="add-on"><i class="cus-calendar-2"></i></span>
						</div>
					</div>

					<button class="btn btn-primary btn-large savelead" @if(isset($l['id'])) data-id="{{$l['id']}}" @else data-id="new" @endif  style="margin-top:40px;margin-bottom:40px;"><i class="icon-ok icon-white"></i>&nbsp; SAVE LEAD</button>
					</form>




	</div>
	<div class="modal-footer">
		<a href="#" class="btn btn-danger" data-dismiss="modal">Close</a>
		<button class='btn btn-primary saveLeadEdit'>SAVE</button>
	</div>
</div>



<script>
$(document).ready(function(){
$('.process').click(function(){
var sts = $(this).data('status');
$('input#status').val(sts);
});
$('.newLeadModal').modal({backdrop:'static'});
});
</script>



