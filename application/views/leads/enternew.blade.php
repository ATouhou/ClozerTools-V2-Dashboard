@layout('layouts/main')
@section('content')
<?php $currBook="";$origBook="";?>
      <style>
      .leadrow{cursor:pointer;}
      </style>
      <?php $set = Setting::find(1);?>
<div id="main" role="main" class="container-fluid">
    <div class="contained">
    	<!-- LEFT SIDE WIDGETS & MENU -->
    	<aside> 
        	@render('layouts.managernav')
       </aside>
        <!-- END WIDGETS -->
                
        <!-- MAIN CONTENT -->
        <div id="page-content" >
            <h1 id="page-header">@if(!empty($thelead)) Lead Edit : {{$thelead->attributes['cust_num']}} @else New Lead / Find Lead @endif</h1>
            @if(empty($thelead))
            <div class="span12" style="margin-bottom:70px;">
            	<form id="checknum" method="post" action="{{URL::to('lead/newlead')}}">
					@if(!empty($notvalid))
					<span class="label label-important special">Phone Number is not a vlid 10-DIGIT number!&nbsp;&nbsp;(dashes are required)</span>
					@endif
            		<label for="phonecheck">Enter Phone Number</label>
          			<input type="text" name="phonecheck" id="phonecheck" onKeyup="addDashes(this)" style="font-size:20px;height:35px;width:200px;"/>
            		<button class="btn btn-primary loadlead" style="margin-top:-8px;height:35px;">LOAD / CHECK</button>
            	</form>
       		</div>
       		@endif
			<div class="fluid-container">
                
                <!-- widget grid -->
                <section id="widget-grid" class="">

                	@if(!empty($thelead))
               
                	<?php $l = $thelead->attributes;?>
                    <?php if($l['leadtype']=="survey"){$surveyTitle="Fresh Un-Surveyed";} else {
                        $surveyTitle=ucfirst($l['leadtype']). " Survey";
                    };
                     if(!empty($l['id'])){$lead = Lead::find($l['id']);}

                     if(!empty($l['booker_name'])){$origBook = $l['booker_name'];} else {$origBook = "N/A";};
                     $currBook = Auth::user()->fullName();
                     ?>

                	<h3>
                		@if(isset($l['cust_name'])){{$surveyTitle}} | Entry Date : {{$l['entry_date']}} 
                		@if($l['birth_date']!='0000-00-00') | Survey Date : {{$l['birth_date']}} @endif 
                		@else New Lead Entry @endif
                		@if(!empty($lead->referrer)) 
								<?php $ref = $lead->referrer;?>
								
								<span style='float:left;width:100%;font-size:14px;margin-bottom:40px;'>Referred By : <a href='{{URL::to("lead/newlead/")}}{{$ref->cust_num}}'>{{$ref->cust_name}} | | {{$ref->address}} | {{$ref->cust_num}} | {{$ref->status}}</a></span>
								
								@endif
                	</h3>
                    <br/>
                    @if($lead->event)
                    <h4 style="margin-top:-25px;"> Homeshow/Event : {{$lead->event->event_name}}</h4><br/>
                    @endif
                                  @if($l['leadtype']=='survey')
                        &nbsp;<button class='btn btn-small revealScript' data-id="survey">SURVEY SCRIPT</button><br/>
                    @else
                        &nbsp;<button class='btn btn-small revealScript' data-id="booking">BOOKING SCRIPT</button>
    &nbsp;<button class='btn btn-small revealScript' data-id="confirmation">CONFIRMATION SCRIPT</button>
    &nbsp;<button class='btn btn-small revealScript' data-id="homeshow">HOMESHOW SCRIPT</button>
    &nbsp;<button class='btn btn-small revealScript' data-id="finalnotice">FINAL NOTICE</button>
    &nbsp;<button class='btn btn-small revealScript' data-id="rebook">REBOOK SCRIPT</button><br/><br/>
                    @endif
                	

                	<br/>
                	<div class="row-fluid">
                        <div id="script-survey" class="script span6 animated fadeInUp well hide" >
                            {{$thescript['survey']}}
                        </div>
                		<div id="script-booking" class="script span6 animated fadeInUp well hide" >
                			{{$thescript['booking']}}
                		</div>
                		<div id="script-confirmation" class="script span6 animated fadeInUp well hide">
                			{{$thescript['confirmation']}}
                		</div>
                		<div id="script-finalnotice" class="script span6 animated fadeInUp well hide">
                			{{$thescript['finalnotice']}}
                		</div>
                		<div id="script-homeshow" class="script span6 animated fadeInUp well hide">
                			{{$thescript['homeshow']}}
                		</div>
                		<div id="script-rebook" class="script span6 animated fadeInUp well hide">
                			{{$thescript['rebook']}}
                		</div>
                	</div>
                	<div class="row-fluid">
                		<h2>	@if(isset($l['cust_name'])) {{$l['cust_name']}} @endif 
                			@if(!empty($l['spouse_name'])) & {{$l['spouse_name']}} @endif </h2>
                		<h4 style="margin-left:16px;">{{$l['address']}}</h4>
                	</div>
                	@if(Auth::user()->call_details==0)
                	@if(!empty($calls))
                	<br/><br/>
                	<span class='label label-success boxshadow'>CALLED THIS CUSTOMER {{count($calls)}} TIMES</span>
                	<br><br>
                	@endif
                	@endif

                	<div class="row-fluid" id="appointments" style="margin-top:20px;">
                		@if(Auth::user()->call_details==0) 
                                
                	
                                <div class="span3 jarviswidget black" data-widget-editbutton="false" data-widget-deletebutton="false"
                                    data-widget-fullscreenbutton="false" >
                                    <header>
                                        <h2>CALL HISTORY</h2>                           
                                    </header>
                                        <!-- wrap div -->
                                        <div>
                                            <div class="inner-spacer">
                                            	@if(!empty($calls)) 
                                                <table class="table table-bordered responsive" >
                                                    <thead>
                                                        <tr>
                                                            <th>CALL DATE</th>
                                                            <th>CALLED BY</th>
                                                            <th>RESULT</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    
                                                    @foreach($calls as $val)
                                                     <?php if($val->result=="APP"){$label = "success";} else if(($val->result=="NI")||($val->result=="DNC")){$label="important";} else if($val->result=="NH"){$label="inverse";} else {$label="info";};?>

                                                        <tr id="{{$val->cust_num}}" class="{{$val->result}} " style="color:#000">
                                                            <td><center><b>{{date('M-d h:i a', strtotime($val->created_at))}}</b></center></td>
                                                            <td><center>{{User::find($val->caller_id)->firstname}} {{User::find($val->caller_id)->lastname}}</center></td>
                                                            <td><center><span class="label label-{{$label}}">{{$val->result}}</span></center></td>
                                                          
                                                        </tr>
                                                    @endforeach
                                             
                                                    </tbody>
                                                </table>
                                                @else
                                                <center>
                                                <h4>No Calls Made</h4>
                                          	</center>
                                          	@endif
                                            </div>
                                            <!-- end content-->
                                        </div>
                                        <!-- end wrap div -->
                                </div>
                	@endif
                		
                                <div class="span4 jarviswidget black" data-widget-editbutton="false" data-widget-deletebutton="false"
                                    data-widget-fullscreenbutton="false" >
                                    <header>
                                        <h2>APPOINTMENT HISTORY</h2>                           
                                    </header>
                                        <!-- wrap div -->
                                        <div>
                                            <div class="inner-spacer"> 
                                            	@if(!empty($lead->appointments))
                                                <table class="table table-bordered responsive" >
                                                    <thead>
                                                        <tr>
                                                            <th>APP TIME</th>
                                                            <th>APP DATE</th>
                                                            <th>BOOKER</th>
                                                            <th>BOOKED AT</th>
                                                            <th>STATUS</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    
                                                    @foreach($lead->appointments as $val)
                                                     <?php if($val->status=="DISP"){$label="inverse";} 
                                                            elseif($val->status=="SOLD") {$label="success special";} 
                                                            elseif($val->status=="CXL") {$label="inverse special";}
                                                            elseif($val->status=="NQ") {$label="important special";}
                                                              elseif($val->status=="DNS") {$label="important special";}
                                                            elseif($val->status=="INC") {$label="warning";}
                                                            elseif(($val->status=="RB-TF")||($val->status=="RB-OF")){$label="info special";}
                                                            else {$label="";}?>

                                                        <tr id="{{$val->cust_num}}" class="{{$val->status}} leadrow" data-id="{{$val->app_date}}" style="color:#000">
                                                            <td><center><b>{{date('h:i', strtotime($val->app_time))}}</b></center></td>
                                                            <td><center>{{date("M-d", strtotime($val->app_date))}}</center></td>
                                             
                                                            <td><center>{{$val->booked_by}}</center></td>
                                                            <td><center><b>{{date("M-d | h:i a", strtotime($val->booked_at))}}</b></center></td>
                                          
                                                            <td><center><span class="label label-{{$label}}">{{$val->status}}</span></center></td>
                                                          
                                                        </tr>
                                                    @endforeach
                                             
                                                    </tbody>
                                                </table>
                                                @else
                                                <center>
                                                <h4>No Appointments For Lead</h4>
                                          	</center>
                                          	@endif
                                            </div>
                                            <!-- end content-->
                                        </div>
                                        <!-- end wrap div -->
                                </div>
                                	
                                <div class="span5 jarviswidget black" data-widget-editbutton="false" data-widget-deletebutton="false"
                                    data-widget-fullscreenbutton="false" >
                                    <header>
                                        <h2>REFERRALS FROM THIS CUSTOMER / LEAD</h2>                           
                                    </header>
                                        <!-- wrap div -->
                                        <div>
                                            <div class="inner-spacer"> 
                                            	  <?php $referrals = $lead->referrals;?>
                               			@if(!empty($referrals))
                                                <table class="table table-bordered responsive" >
                                                    <thead>
                                                        <tr>
                                                            
                                                            <th>NAME</th>
                                                            
                                                            <th>ADDRESS</th>
                                                            <th>NUMBER</th>
                                                            <th>ENTERED</th>
                                                            <th>STATUS</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    
                                                    @foreach($referrals as $val)
                                                     <?php if($val->status=="DISP"){$label="inverse";} 
                                                            elseif($val->status=="SOLD") {$label="success special";} 
                                                            elseif($val->status=="CXL") {$label="inverse special";}
                                                            elseif($val->status=="NQ") {$label="important special";}
                                                              elseif($val->status=="DNS") {$label="important special";}
                                                            elseif($val->status=="INC") {$label="warning";}
                                                            elseif(($val->status=="RB-TF")||($val->status=="RB-OF")){$label="info special";}
                                                            else {$label="";}?>

                                                        <tr id="{{$val->cust_num}}" class="{{$val->status}} leadrow2" data-id="{{$val->cust_num}}" style="color:#000">
                                                        	
                                                            <td><center><b>{{$val->cust_name}}</b></center></td>
                                                            <td style="font-size:10px;">@if(!empty($val->address))<center>{{$val->address}}</center>@endif</td>
                                                            <td><center>{{$val->cust_num}}</center></td>
                                                            <td><center><b>{{date("M-d ", strtotime($val->entry_date))}}</b></center></td>
                                          		
                                                            <td><center><span class="label label-{{$label}}">{{$val->status}}</span></center></td>
                                                          
                                                        </tr>
                                                    @endforeach
                                             
                                                    </tbody>
                                                </table>
                                                @else
                                                <center>
                                                <h4>No Referrals On File </h4>
                                          	</center>
                                                @endif
                                            </div>
                                            <!-- end content-->
                                        </div>
                                        <!-- end wrap div -->
                                </div>
                                	

                               
                        </div>

                	
                		<div class="row-fluid" id="leadmanager" style="margin-top:20px;">
                                <div class="jarviswidget black" data-widget-editbutton="false" data-widget-deletebutton="false"
                                    data-widget-fullscreenbutton="false" >
                                    <header>
                                        <h2>Lead Manager</h2>                           
                                    </header>
                                        <!-- wrap div -->
                                        <div>
                                            <div class="inner-spacer"> 
                                                <form id=
                                                "update" method="post" action="{{URL::to('lead/updatelead')}}">
                                                <input type="hidden" name="id" id="id" @if(!empty($thelead->id)) value="{{$thelead->id}}" @else value="new" @endif>
                                                <table class="table table-bordered responsive" >
                                                    <thead>
                                                        <tr>
                                                            <th>Phone Number</th>
                                                            <th>Customer Info</th>
                                                            <th>Address</th>
    													</tr>
                                                    </thead>
                                                    <tbody>
                                                    	<tr>
                                        					<td>
                                        						<input type="text" name="custnum" id="custnum" @if(!empty($l['cust_num'])) value="{{$l['cust_num']}}" @elseif(!empty(Input::old('custnum'))) value="{{Input::old('custnum')}}" @endif />
                                        					</td>
                                        					<td>Customer Name<br />
                                                                @if($errors->has('name')) <span class="label label-important special">{{$errors->first('name')}}</span><br /> @endif
                                        						<input type="text" name="name" id="name" @if(!empty($l['cust_name'])) value="{{$l['cust_name']}}" @elseif(!empty(Input::old('name'))) value="{{Input::old('name')}}" @endif /><br />
                                                                Spouse's Name<br />
                                                                <input type="text" name="spouse" id="spouse" @if(!empty($l['spouse_name'])) value="{{$l['spouse_name']}}" @elseif(!empty(Input::old('spouse'))) value="{{Input::old('spouse')}}" @endif />
                                        					</td>
                                        					<td>Address<br />
                                                                @if($errors->has('address')) <span class="label label-important special">{{$errors->first('address')}}</span><br /> @endif
                                        						<input type="text" class="addressDropdown span10" name="address" id="address" @if(!empty($l['address'])) value="{{$l['address']}}" @elseif(!empty(Input::old('address'))) value="{{Input::old('address')}}" @endif /><br />
                                                                City<br />
                                                                  @if($errors->has('city')) <span class="label label-important special">{{$errors->first('city')}}</span><br /> @endif
                                                                <select name="city" id="city">
                                                                <option value=""></option>
                                                                @foreach($cities as $val)
                                                                <option value="{{$val->cityname}}" @if((isset($l['city'])&&($val->cityname==$l['city']))) selected="selected" @endif>{{$val->cityname}}
                                                                </option>
                                                                @endforeach
                                                            </select><br/>
                                                            House Type (Optional)<br/>
                                                    <select name="homestead" id="homestead">
                                                          <option value=""></option>
                                                          <option value="house" @if($l['homestead_type'] == 'house') selected='selected' @endif>House</option>
                                                          <option value="condominium"  @if($l['homestead_type'] == 'condominium') selected='selected' @endif>Condominium</option>
                                                          <option value="apartment"  @if($l['homestead_type'] == 'apartment') selected='selected' @endif>Apartment</option>
                                                          <option value="townhouse"  @if($l['homestead_type'] == 'townhouse') selected='selected' @endif>Townhouse</option>
                                                          <option value="detached"  @if($l['homestead_type'] == 'detached') selected='selected' @endif>Detached / Mobile Home</option>
                                                          <option value="bungalow"  @if($l['homestead_type'] == 'bungalow') selected='selected' @endif>Bungalow</option>
                                                    </select>
                                        					</td>
	                             						</tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- end content-->
                                        </div>
                                        <!-- end wrap div -->
                                </div>
                        </div>

                        <div class="control-group">
                            <label for="select01">GENDER / SEX</label>
                                <div class="controls">
                                <select id="sex" name="sex" class="span2">
                                     <option value="" @if((isset($l['sex'])&&($l['sex']==""))) selected="selected" @endif></option>
                                    <option value="male" @if((isset($l['sex'])&&($l['sex']=="male"))) selected="selected" @endif>Male</option>
                                    <option value="female" @if((isset($l['sex'])&&($l['sex']=="female"))) selected="selected" @endif>Female</option>
                                   
                                </select>
							<label for="select01">MARITAL STATUS</label>
								<div class="controls">
								<select id="married" name="married" class="span2">
									<option value="married" @if((isset($l['married'])&&($l['married']=="married"))) selected="selected" @endif>Married</option>
									<option value="single" @if((isset($l['married'])&&($l['married']=="single"))) selected="selected" @endif>Single</option>
									<option value="commonlaw" @if((isset($l['married'])&&($l['married']=="commonlaw"))) selected="selected" @endif>Common Law</option>
									<option value="widowed" @if((isset($l['married'])&&($l['married']=="widowed"))) selected="selected" @endif>Widow</option>
								</select>

							<label for="select01">Lead Type</label>
								<select id="leadtype" name="leadtype" class="span2">
                                    @if($set->lead_survey==1)
                                    <option value="survey" @if((isset($l['original_leadtype'])&&($l['original_leadtype']=="survey"))) selected="selected" @endif>Fresh Un-Surveyed</option>
									@endif
                                    @if($set->lead_secondtier==1)
                                    <option value="secondtier" @if((isset($l['original_leadtype'])&&($l['original_leadtype']=="secondtier"))) selected="selected" @endif>Second Tier Survey</option>
                                    @endif
                                    @if($set->lead_door==1)
                                    <option value="door" @if((isset($l['original_leadtype'])&&($l['original_leadtype']=="door"))) selected="selected" @endif>Door</option>
									@endif
                                    @if($set->lead_paper==1)
                                    <option value="paper" @if((isset($l['original_leadtype'])&&($l['original_leadtype']=="paper"))) selected="selected" @endif>Paper / Manilla</option>
									@endif
                                    @if($set->lead_scratch==1)
                                    <option value="other" @if((isset($l['original_leadtype'])&&($l['original_leadtype']=="other"))) selected="selected" @endif>Scratch / Other</option>
									@endif
                                    @if($set->lead_homeshow==1)
                                    <option value="homeshow" @if((isset($l['original_leadtype'])&&($l['original_leadtype']=="homeshow"))) selected="selected" @endif>Home Show</option>
									@endif
                                    @if($set->lead_ballot==1)
                                    <option value="ballot" @if((isset($l['original_leadtype'])&&($l['original_leadtype']=="ballot"))) selected="selected" @endif>Ballot Box</option>
									@endif
                                    <option value="referral" @if((isset($l['original_leadtype'])&&($l['original_leadtype']=="referral"))) selected="selected" @endif>Referral</option>
                                    <option value="coldcall" @if((isset($l['original_leadtype'])&&($l['original_leadtype']=="coldcall"))) selected="selected" @endif>Cold Call</option>
                                    <option value="rebook" @if((isset($l['leadtype'])&&($l['leadtype']=="rebook"))) selected="selected" @endif>Rebook</option>
                                    @if($set->lead_instant==1)
                                    <option value="instant" @if((isset($l['original_leadtype'])&&($l['original_leadtype']=="instantset"))) selected="selected" @endif>Instant Set</option>
                                    @endif
                                    @if($set->lead_train==1)
                                    <option value="train" @if((isset($l['original_leadtype'])&&($l['original_leadtype']=="training"))) selected="selected" @endif>Training Lead</option>
                                    @endif

								</select><br/>
								@if((isset($l['leadtype']))&&($l['leadtype']=="rebook")) 
								<span class='small'>Original Leadtype before rebook : {{ucfirst($l['original_leadtype'])}} 
								</span>
								@endif
								@if((isset($l['leadtype']))&&($l['leadtype']=="referral")) 
								<?php $ref = Lead::find($l['referral_id']);?>
								@if($ref)
								<span class='small'>Referred By : <a href='{{URL::to("lead/newlead/")}}{{$ref->cust_num}}'>{{$ref->cust_name}} | {{$ref->id}} | {{$ref->address}} | {{$ref->status}}</a></span>
								@endif
								@endif
								</div>
								<br/>
								Gift : <br/>
								<?php $gifts = Gift::get();?>
								<select name="gift" id="gift" class="span2">
									<option value=""></option>
      							@foreach($gifts as $val)
									<option <?php if(isset($l['gift'])){ if((strtolower($val->name)==$l['gift'])||($val->name==$l['gift'])) {; echo "selected='selected'";};}?> value='{{$val->name}}'>{{$val->name}}</option>
								@endforeach
								</select>
							
								<label for="notes">Notes : </label>
								<textarea name="notes" id="notes" rows="4" class="span5" >@if(isset($l['notes'])) {{$l['notes']}}@endif</textarea>
						</div>
						 
						<br>


                        <br>
						<h4>Update this leads Status...  (Click APP to book appointment and choose Gift)</h4>
						<div class="control-group">
							<label class="control-label">PICK A STATUS</label>
                             @if($errors->has('status')) <span class="label label-important special">{{$errors->first('status')}}</span> @endif
								<div class="controls">
									<div class="btn-group" data-toggle="buttons-radio">
										<button type="button" class="btn btn-small process @if((isset($l['status']))&&($l['status']=="NEW")) active @endif" data-status="NEW"><i class="cus-add"></i>&nbsp;NEW</button>
										<button type="button" class="btn btn-small process @if((isset($l['status']))&&($l['status']=="NH")) active @endif" data-status="NH"><i class="cus-house"></i>&nbsp;NH</button>
										<button type="button" class="btn btn-small process @if((isset($l['status']))&&($l['status']=="NI")) active @endif" data-status="NI"><i class="cus-cross"></i>&nbsp;NI</button>
										<button type="button" class="btn btn-small process RCBUT @if((isset($l['status']))&&($l['status']=="Recall")) active @endif" data-status="Recall"><i class="cus-arrow-redo"></i>&nbsp;RECALL</button>
										<button type="button" class="btn btn-small process @if((isset($l['status']))&&($l['status']=="WrongNumber")) active @endif" data-status="WrongNumber"><i class="cus-disconnect"></i>&nbsp;WRONG NUM</button>
			                            <button type="button" class="btn btn-small process @if((isset($l['status']))&&($l['status']=="DNC")) active @endif" data-status="DNC"><i class="cus-delete"></i>&nbsp;DNC</button>
			                            <button type="button" class="btn btn-small process @if((isset($l['status']))&&($l['status']=="NQ")) active @endif" data-status="NQ"><i class="cus-delete"></i>&nbsp;NQ</button>
			                            <button type="button" class="btn btn-small process APPBUT @if((isset($l['status']))&&($l['status']=="APP")) active @endif " data-status="APP"><i class="cus-clock"></i>&nbsp;APP</button>
                                        <input type="hidden" id="status" name="status" value="donotchange" />
			                        </div>
								</div>
						</div>

					<div class="bookdemo" style="display:none;margin-top:30px;">
						<h4>Book a Demo (if customer agrees)</h4>
				
						<div class="control-group" >
							<label class="control-label">Appointment Date</label>
								<div class="controls">
								    <div class="input-append date" id="datepicker-js" data-date="{{date('Y-m-d')}}" data-date-format="yyyy-mm-dd">
										<input class="datepicker-input" size="16" id="appdate" name="appdate" type="text" value="{{date('Y-m-d')}}" placeholder="Select a date" />
										<span class="add-on"><i class="cus-calendar-2"></i></span>
									</div>
								</div><br/>
                            <label class="control-label">Pick an Appointment Time</label>
                            <input id="booktimepicker7" name="booktimepicker" type="text"  placeholder="Select Time..." style="width:10%;"  />
						</div>
						<input type="hidden" id="hiddenDATE" value="{{date('Y-m-d')}}">
                        <input type="hidden" id="hiddenTIME" value="">

					</div>
					<div class="controls" id="recallbox" style="margin-top:8px;display:none"><br/>
						Select a Date for Recalling this Customer<br/>
						<div class="input-append date" id="datepicker-js" data-date="{{date('Y-m-d')}}" data-date-format="yyyy-mm-dd">
							<input class="datepicker-input" size="16" id="recalldate" name="recalldate" type="text" value="{{date('Y-m-d')}}" placeholder="Select a date" />
							<span class="add-on"><i class="cus-calendar-2"></i></span>
						</div>
					</div>
                    <br/>
                    <input type="hidden" name="bookChange" id="bookChange" value="false" / >
                    <h3>Booker Attached to This Lead : <span class='blackText changeBooker' style='font-size:20px;'>
                        {{$origBook}} 
                    </span></h3>

					<button class="btn btn-primary btn-large savelead" @if(isset($l['id'])) data-id="{{$l['id']}}" @else data-id="new" @endif  style="margin-top:40px;margin-bottom:40px;"><i class="icon-ok icon-white"></i>&nbsp; SAVE LEAD</button>
					</form>

					@endif

                </section>
                <!-- end widget grid -->
            
            </div>    
            
            <!--RIGHT SIDE WIDGETS-->
        <aside class="right">
            @render('layouts.chat')
        </aside>
        <!--END RIGHT SIDE WIDGETS-->

        </div>
        <!-- end main content -->
    </div>
</div><!--end fluid-container-->
<div class="push"></div>
	

<script>
$(document).ready(function(){
	$('#leadmenu').addClass('expanded');

    $('.savelead').click(function(e){
        e.preventDefault();
        var status = $('#status').val();
        var time = $('#hiddenTIME').val();
        var address = $('#address').val();
        var lead_id = $(this).data('id');
        var date = $('#hiddenDATE').val();
       
        if(status!="donotchange"){
            if(status=="APP"){
                if(address==0 || address==""){
                    $('#address').css('background','red');
                    toastr.error("You need to enter an address to book an appointment!!!");
                    return false;
                }
                if(time==0){
                    toastr.error("You need to select a time, in order to book an appointment!");
                    return false;
                }
                var hasNoApp=false;
                $.ajax({
                  async: false,
                  url: "{{URL::to('appointment/check/')}}",
                  dataType: "json",
                  data: {lead_id:lead_id,date:date},
                  success: function(data) {
                    if (data == "success") {     
                        hasNoApp=true;
                    } else {
                        hasNoApp = false;
                    }
                  }
                });
                if(hasNoApp==false){
                    toastr.error("Appointment for this Lead is already booked for today!!");
                    return false;
                } else {
                    toastr.success("Appointment OK to Book");
                    
                }
            }
            $('#update').submit();
        } else {
            $('#update').submit();
        }

    });

  $("#booktimepicker7").timePicker({
  startTime: "10:00", // Using string. Can take string or Date object.
  endTime: new Date(0, 0, 0, 23, 30, 0), // Using Date object here.
  show24Hours: false,
  step: 15});

  $('#booktimepicker7').change(function(){
        var val = $(this).val();
        $('#hiddenTIME').val(val);
    });

   $('#appdate').change(function(){
        var val = $(this).val();
        $('#hiddenDATE').val(val);
    });

var currentBooker = "{{$currBook}}";
var oldBooker = "{{$origBook}}";

$('.process').click(function(){
    var sts = $(this).data('status');
    if(sts=="Recall" || sts=="APP"){
        
        var t = confirm("If the status is changed to RECALL or APP, the booker attached to this lead (if any) will be replaced/updated to You.  If you hit cancel it will keep the current booker");
        if(t){
            $('.changeBooker').removeClass("blackText").addClass("redText").html(currentBooker);
            $('#bookChange').val("true");
        }
    } else {
         $('.changeBooker').removeClass("redText").addClass("blackText").html(oldBooker);
         $('#bookChange').val("false");
    }
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



    $('.leadrow').click(function(){
        var id = $(this).data('id');
        var url = "{{URL::to('appointment')}}?date="+id;
        window.location.replace(url);
    });

    $('.leadrow2').click(function(){
        var num= $(this).data('id');
        var url = "{{URL::to('lead/newlead/')}}"+num;
        window.location.replace(url);
    });
});
</script>
 
@endsection