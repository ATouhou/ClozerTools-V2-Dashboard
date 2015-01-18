@layout('layouts/main')
@section('content')

<script>
function showLeads(){
$('.leadpanel').fadeIn(400);
$('#stats2').hide();
$('#enterlead').hide();
}


function showStats(){
$('.leadpanel').hide();
$('#stats2').fadeIn(300);
$('#enterlead').hide();
}

function showEntryForm(){
$('.leadpanel').hide();
$('#enterlead').fadeIn(200);
}
</script>
<style>
#leads {display:none;}
#stats2 {display:none;}
.callinScript {
	overflow:scroll;
	height:260px!important;
}

.modal{
    z-index: 20;   
}
.modal-backdrop{
    z-index: 10;        
}​
.white {background:white!important;color:#fff!important;}
.apptable td {font-size:110%;}
#scratchcard {position:absolute;
position:fixed;
margin-top:-45px;
margin-left:100px;
z-index:15;
height:630px;
border-radius:10px;
border:1px solid #1f1f1f;
padding:20px;
background:white;
display:none;
}
#scratchcard input {width:60%;}
#scratchcard select {width:40%;}
#scratchcard textarea{width:40%;
}
.sidetable {
   border:1px solid #fff;color:#fff;
}
.sidetable th{color:#fff;}
.sidetable td {
	border:1px solid #fff;color:#ccc;
}



</style>

<link rel="stylesheet" type="text/css" media="screen" href="{{URL::to_asset('slots/')}}css/slot.css" />
<?php $setting = Setting::find(1);?>

                                      	
<div id="main" role="main" class="container-fluid">
    <div class="contained">
    	<!-- aside start -->
    	<aside>
        	@render('layouts.managernav')
        	@if($setting->goals==1)
        		@render('sidewidgets.leftside')
        	@endif
        </aside>
        <!-- aside end -->
                
        <!-- main content -->
        <div id="page-content" >
            <!-- page header -->
            
            <h1 id="page-header"><img src='{{URL::to("images/clozer-cup.png")}}' style='margin-right:-10px;'>&nbsp;Your Assigned Leads <a href="{{URL::to('dashboard/agent')}}">
            	@if($setting->goals==6)
            	<div class="startotal"><div style="font-size:9px;color:#000;width:30px;margin-left:15px;margin-top:14px;line-height:9px;">YOUR GOALS</div></div>
            	@endif
            </a>@if($setting->needed==1)
            	<button class="btn btn-success viewapps" onclick="$('#viewappsneeded').trigger('click');" style="float:right;margin-top:10px;margin-right:30px;">
            		<i class=""></i>&nbsp;&nbsp;VIEW APPOINTMENTS NEEDED
            	</button>
            	@endif
            	<button class="btn btn-default scratchCardCallIn tooltwo" title="Click if a customer is calling in with a Scratch Card - YOU CANNOT EXIT WINDOW UNTIL INFO IS ENTERED!" style="float:right;margin-top:10px;margin-right:30px;">
            		<i class="cus-ticket"></i>&nbsp;&nbsp;SCRATCH CARD CALL IN
            	</button>
            </h1>
            @if(count($buckets)>1)
            @if($bucketset=="")
            <?php $lgsml = "btn-large";?>
            <h2 class='animated fadeInUp' style='margin-top:-20px;color:red;'>You currently have more than 1 Leadtype assigned to you</h2>
            <h4 class="animated fadeInUp">Please choose which leadtype you want to be calling before you can proceed.</h4><br/>
            @else
            <?php $lgsml = "btn-small";?>
            <h4 style='margin-top:-20px;'>You are currently calling {{$bucketset}} Leads</h4>
            @endif

            @if(!empty($buckets))
            @foreach($buckets as $b)
            <?php if($bucketset==strtoupper($b->leadtype)){$chosen="btn-inverse";} else {$chosen="btn-default";};?>
            <a href='{{URL::to("dashboard/agent/leads")}}?bucket={{$b->leadtype}}'>
            	<button class='btn {{$lgsml}} {{$chosen}} chooseLeadtype' data-type='{{$b->leadtype}}'>{{strtoupper($b->leadtype)}}</button>&nbsp;&nbsp;
            </a>
            @endforeach
            @endif
            <br/><br/>
            @endif
				<div class="fluid-container">
                            
                    <!-- end start icons -->

                    
                    <!-- widget grid -->
                    <section id="widget-grid" class="">
                    	@if($setting->games==1)
                    	@if(Session::has('AppBook'))
                    	<h2 class='animated rollIn'>{{Session::get('AppBook')}}</h2>
                    	@endif
                    	@endif
					@render('sidewidgets.confirms')
                        	<div class="row-fluid">
                        		@if($bucketset!="" || count($buckets) <= 1)
	                       		<article class="span12">
	                       				
									<!-- new widget -->
									<div class="jarviswidget black leadpanel" data-widget-deletebutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="false">
									    <header>
									        <h2>Your Lead List</h2>                           
									    </header>
									    
									    <!-- widget div-->
									    <div>
									    	
									        <!-- end widget edit box -->
            
									        <div class="inner-spacer widget-content-padding"> 
									        <!-- content -->	
												<ul id="myTab" class="nav nav-tabs default-tabs">
													<li class="active">
														<a href="#s1" data-toggle="tab">Next Lead to Call</a>
													</li>
												
													<li>
														<a href="#s2" id="viewleadlist" data-toggle="tab">View Lead List</a>
													</li>
													@if(!empty($recalls))
													<li>
														<a href="#s3" id="viewRecalls" class="tooltwo" title="You have some recalls to Call Back today!" data-toggle="tab">
															<span class="label label-success blackText special animated shake">RECALLS</span>
														</a>
													</li>
													@endif
													@if($setting->needed==1)
													<li>
														<a href="#s4" id="viewappsneeded" data-toggle="tab"><span class="label label-inverse">APPOINTMENT SLOTS NEEDED</span></a>
													</li>
													@endif
													@if($setting->games==1)
													<li>
														<a href="#s5" id="viewappsneeded" data-toggle="tab"><span class='badge badge-success special credits'>{{Auth::user()->credits}}</span>&nbsp;&nbsp;SPIN TO WIN CREDITS</a>
													</li>
													@endif
													
												</ul>
												<div id="myTabContent" class="tab-content">
													<div class="tab-pane fade in active" id="s1">
												
														@if(!empty($singlelead))
														<?php 
															if($singlelead->leadtype=="survey"){
																$lt = "Fresh / Un-Surveyed";
															} else {
																$lt = $singlelead->leadtype;
															}
														;?>	
														<div class="span6" style="margin-left:40px;color:#000;">
															<h2>{{$singlelead->cust_name}} from {{$singlelead->city}}</h2>
															<h1 class="shadow"><a href="http://www.canada411.ca/search/?stype=re&what={{$singlelead->cust_num}}" target=_blank><img src="{{URL::to_asset('images/411-icon.png')}}" width=30px>&nbsp;{{$singlelead->cust_num}}</a></h1>
															<br/>
															<button class="btn btn-success btn-large calllead" data-num="{{$singlelead->cust_num}}" style="margin-bottom:40px;">CALL THIS CUSTOMER</button>
															
															<h4>Lead type : {{strtoupper($lt)}}</h4>
															@if($singlelead->leadtype!='survey')
															<span class="label label-inverse">Survey done by:</span>&nbsp;<span class="label label-info">{{strtoupper($singlelead->researcher_name)}}</span>
															<span class="label label-inverse">Completed on : </span>&nbsp;<span class="label label-info">
															@endif
															Uploaded : 
															@if($singlelead->birth_date!='0000-00-00') {{date('D M-d', strtotime($singlelead->birth_date))}}  @else  {{date('D M-d', strtotime($singlelead->created_at))}} @endif
															</span>
															
															@if(Auth::user()->call_details==0)
															@if(!empty($singlelead->calls))
															<br/>
															<button class='btn btn-mini btn-default viewallcalls' style="margin-top:10px;margin-bottom:10px;"><i class="cus-telephone"></i>&nbsp;VIEW ALL CALLS</button><br/>
															<span class="lastcalls">Last 2 Calls</span>
														    @foreach($singlelead->calls as $val)
														    <div class="calllist">
															<span class="label label-inverse">Called on : </span>&nbsp;<span class="label label-success">{{date('D M-d h:i a', strtotime($val->created_at))}} by {{$val->caller_name}}</span>&nbsp;&nbsp; <strong>Result of Call : </strong><span class="label label-inverse">{{$val->result}}</span>
															</div>
															@endforeach
															@endif
															<br><br>
															@endif
														</div>

														<div class="span4" style="margin-top:15px;">
															@if(!empty($singlelead->notes))
															<h4>Customer Notes</h4>
															<div class="shadowBOX" style="padding:20px;">
															{{$singlelead->notes}}
															</div>
															@endif
														</div>
														@else 
													
														<h3>You currently don't have any leads assigned to you...</h3>
														<button class="btn btn-success requestleads">Let your manager know</button>
														@endif
													</div>

													<div class="tab-pane fade" id="s2">
														<table class="table table-bordered responsive" style="color:#000;" >
                                                    		<thead>
                                                    		    <tr align="center">
    																<th style="width:1%;">Date Entered:</th>                  	      
																	<th style="width:10%;" >Customer<br />Phone Number</th>
																	<th style="width:10%;">Customer<br />Name</th>
																	<th style="width:20%;">Address</th>
																	<th>City</th>
																	<th style="width:8%;">Call Time</th>
																	<th>Status</th>
																	@if(!empty($singlelead))
																	@if($singlelead->leadtype!="survey")
																	<th>View</th>
																	@endif
																	@endif
	                                                		        </tr>
                                                    		</thead>
                                                    		<tbody id="leadtable">
                                                    			<h4>You can edit the Address or Status by clicking on it...</h4>
                                                    				
        														@foreach($myleads as $k=>$val)
        														    <?php if($val->status=="APP"){$shadow="shadowtable";$color="#000";} else {$shadow="";$color="black";}
        														    if($val->status=="APP"){$label="success";}
        														    elseif($val->status=="ASSIGNED"){$label="info";} 
        														    elseif($val->status=="NH") {$label="inverse";} 
        														    elseif($val->status=="DNC") {$label="important";}
        														    elseif($val->status=="NI") {$label="important";}
        														    elseif($val->status=="Recall") {$label="warning";} else {$label="";};?>
    															
        														   <tr id='agentrow-{{$val->id}}' class='{{$shadow}} {{$val->status}}' style='color:".$color}}'>
        														    <td>{{date('M-d', strtotime($val->created_at))}}</td>
        														    <td class='span4'><b>{{$val->cust_num}}</b></td>
        														    <td class='span4'>{{$val->cust_name}}</td>
        														    <td><span class="edit" id="address|{{$val->id}}">{{$val->address}}</span></td>
        														     <td><center>{{$val->city}}</center></td>
        														     <td>
        														     	<?php $c = $val->last_call();

        														     	?>
        														     	@if(!empty($c))
        														     
        														     	@if($c->caller_id==$val->booker_id)
        														     	<span class='label label-success special blackText'>
        														     		{{date('h:i:s a',strtotime($c->created_at))}}	
        														     	</span>
        														     	@endif
        														     	@else
        														     	<span class='label label-inverse'>
        														     		Hasn't Called
        														     	</span>
        														     @endif
        														     </td>
        															
        														    <?php if($val->status=="INACTIVE"){$stat = "UNRELEASED / NEW";} else {$stat=$val->status;};?>
        														    @if(!empty($singlelead))
        														    @if($singlelead->leadtype!="survey")
        														    <td><center><span class='editstatus label label-{{$label}} special boxshadow' id="status|{{$val->id}}">{{$stat}}</span></center></td>
        														    @else
        														    <td><center><span class='label label-{{$label}} special boxshadow' id="status|{{$val->id}}">{{$stat}}</span></center></td>
        														    @endif
        														    @else        										    
        														    <td><center><span class='label label-{{$label}} special boxshadow' id="status|{{$val->id}}">{{$stat}}</span></center></td>
        														    @endif
        														    @if(!empty($singlelead))
        														    @if($singlelead->leadtype!="survey")
        														    <td>
        														    @if($val->status!='INACTIVE')
        														    <center><a href="{{URL::to('lead/newlead/')}}{{$val->cust_num}}"><button class="btn btn-default"><i class="cus-telephone"></i>&nbsp;&nbsp;VIEW LEAD</button></a></center>
        														    @endif
        														    </td>
        														    @endif
        														    @endif
        														   </tr>
        														@endforeach
                                                    		</tbody>
                                                		</table>
													</div>
													<div class="tab-pane fade" id="s3">
														<table class="table table-bordered responsive" style="color:#000;" >
                                                    		<thead>
                                                    		    <tr>
                                                    		    	<th style="width:9%;">LAST CALL DATE</th>
                                						<th style="width:7%;">RECALL DATE</th>
                                						<th style="width:14%;">Leadtype</th>
                                						<th style="width:16%;">Num</th>
                                						<th>Name</th>
                                						<th>NOTES</th>
                                						<th style="width:12%;">PROCESS</th>
                            					</tr>
                                                    		</thead>
                                                    		<tbody id="leadtable">
                                                    			@if(!empty($recalls))
        														@foreach($recalls as $val)
                            									<?php if($val->leadtype=="rebook"){$icon2="cus-arrow-redo"; } else {$icon2="";}
                            									        if($val->original_leadtype=="door"){$icon="cus-door";$val->original_leadtype="Door Survey";} 
                            									        elseif($val->original_leadtype=="paper"){$icon="cus-script";$val->original_leadtype="Manilla Survey";} 
                            									        elseif($val->original_leadtype=="secondtier"){$icon="cus-script";$val->original_leadtype="Second Tier Survey";} 
                            									        else if($val->original_leadtype=="ballot"){$icon="cus-inbox";$val->original_leadtype="Ballot Box";} else if($val->original_leadtype=="other"){$icon="cus-zone-money";$val->original_leadtype="Scratch Card";} else if($val->original_leadtype=="referral"){$icon="cus-user";$val->original_leadtype="Referral";} else {$icon="";};
                            									        if($val->recall_date<=date('Y-m-d')){$col = "success";} else {$col="warning";};
                            									        ?>
                            									<tr id="recallLead-{{$val->id}}"><td>{{date('M-d h:i a',strtotime($val->call_date))}}</td>
                            									    <td>
                            									        <span class="badge badge-{{$col}} blackText special">
                            									        {{date('M-d Y',strtotime($val->recall_date))}}
                            									        </span>
                            									    </td>
                            									    <td><i class='{{$icon}}'></i>&nbsp;&nbsp;{{$val->original_leadtype}} @if($val->leadtype=="rebook") <br/><span class="badge badge-info special">Rebook</span> @endif</td>
                            									    <td><span class="searchNum" style="font-size:16px;font-weight:bolder;">{{$val->cust_num}}</span></td>
                            									    <td>{{$val->cust_name}}</td>
                            									    <td id="notes|{{$val->id}}" class="edit">{{$val->notes}}</td>
                            									    <td>
                            									    	@if(date('Y-m-d')>=date('Y-m-d',strtotime($val->recall_date)))
                            									       <center><a href="{{URL::to('dashboard/agent/leads')}}?processlead={{$val->id}}"><button class="btn btn-default"><i class="cus-telephone"></i>&nbsp;&nbsp;PROCESS RECALL</button></a></center>
                            									       @else
                            									       <span class='badge badge-important special'>Not Past Due Date</span>
                            									       @endif
                            									    </td>
                            									</tr>
                            									@endforeach
        														@endif
                                                    		</tbody>
                                                		</table>




													</div>


													<div class="tab-pane fade" id="s4">
			
			<div class="row-fluid" id="appsneeded">
         	<div class="span12" style="padding:30px;"><h4>Appointments Needed By City </h4>
         	<h5><span class="badge badge-important special">Important</span> Try Fill First &nbsp;&nbsp;<span class="badge badge-info special">Halfway</span> Fill Second &nbsp;&nbsp;<span class="badge badge-success special">Almost Full</span> Fill Last &nbsp;&nbsp;
         	</h5>
         	    <div id="appointmentsNeededTable">

         	    </div>
         	</div>
         </div>
												</div>
												<div class="tab-pane fade" id="s5" style="height:250px;">
													<div id="slotMachine">
        												<p id="slotCredits">15</p>
        												<a href="#" id="slotTrigger">spin</a>
        												<div id="wheel1" class="wheel">
        												    <img src="{{URL::to_asset('slots/')}}images/wheel1.gif" alt="" />
        												    <img src="{{URL::to_asset('slots/')}}images/ani.gif" alt="" class="slotSpinAnimation" />
        												</div>
        												<div id="wheel2" class="wheel">
        												    <img src="{{URL::to_asset('slots/')}}images/wheel2.gif" alt="" />
        												    <img src="{{URL::to_asset('slots/')}}images/ani.gif" alt="" class="slotSpinAnimation" />
        												</div>
        												<div id="wheel3" class="wheel">
        												    <img src="{{URL::to_asset('slots/')}}images/wheel3.gif" alt="" />
        												    <img src="{{URL::to_asset('slots/')}}images/ani.gif" alt="" class="slotSpinAnimation" />
        												</div>
        												<img src="{{URL::to_asset('slots/')}}images/over.png" alt="" id="wheelOverlay" />
        												<p id="slotSplash">
        												    <a href="#">start</a>
        														</p>
    												</div>
    												<div class="currentcredits" style="position:absolute;width:280px;margin-left:90px;margin-top:220px;float:left;">
    													<b>SPINS :</b> <span class='bignum spins PUTON' style="padding:7px;">{{Auth::user()->spins}}</span>
    													&nbsp;&nbsp;<b>CREDITS :</b> <span class='bignum credits' style="padding:7px;">{{Auth::user()->credits}}</span>
    												</div>

    												<div class="instructions" style="width:480px;float:right;margin-top:0px;padding-right:15px;">
    													<h3>Instructions</h3>
    													<p>You earn credits for the slot machine, by booking demos.<br/>
    													 Each demo you book earns you one credit, and affords you 3 spins.<br/>
    													 You can only have a maximum of 10 spins at any time.
    													 You can cash in credits at any time for prizes<br/>
    													 You don't have to spin, and can choose to just build up credits by booking demos instead.
    													 <h5>PRIZES</h5>
    													 Booster Juice <span class='label label-info'>60 Credits</span><br/>
    													 $10 Gift Certificate <span class='label label-info'>80 Credits</span><br/>
    													 $20 Extra <span class='label label-info'>100 Credits</span><br/>
    													 Paid Day Off <span class='label label-info'>300 Credits</span><br/>
    													</p>

    												</div>
    											</div>
												</div>
									        </div>
									    </div>
									</div>
								</article>
								@endif
							</div>
                       		 </section>
                        	<div class="row-fluid well" style="margin-bottom:40px;margin-top:30px;">
									
										<div class="row-fluid" style="margin-bottom:5px;">

                                        	<button class="btn btn-default btn-large scratchCardCallIn tooltwo" title="Click if a customer is calling in with a Scratch Card - YOU CANNOT EXIT WINDOW UNTIL INFO IS ENTERED!"><i class="cus-ticket"></i>&nbsp;&nbsp;SCRATCH CARD CALL IN</button><br/>
										</div>
										<br/>
										@if(empty($myscratch))
										<h5>No Scratch Cards Entered Today</h5><br/><br/>
										@else
										<h2>Scratch Cards For Today</h2>
									<table class="table apptable" >
                                    <thead>
                                        <tr style="background:#1f1f1f;color:#fff;">
                                           
                                            <th>Number</th>
                                            <th>Name</th>
                                            <th>Spouse</th>
                                            <th>Marital Status</th>
                                            <th>Address</th>
                                            <th>Notes</th>
                                            <th>RESULT</th>
                                        </tr>
                                    </thead>
                                   
                                        @foreach($myscratch as $val)
                                        <?php if($val->status=="APP"){$shadow="shadowtable";$color="#000";} else {$shadow="";$color="black";}
                                                            if($val->status=="APP"){$label="success";$msg = "DEMO BOOKED!";}
                                                            elseif($val->status=="INACTIVE"){$label="inverse";$msg="UNRELEASED";}
                                                            elseif($val->status=="NEW"){$label="info";$msg="IN POOL";}
                                                            elseif($val->status=="SOLD"){$label="success special";$msg = " $$ SOLD $$";}
                                                            elseif($val->status=="ASSIGNED"){$label="info";$msg = "ASSIGNED TO CALL";} 
                                                            elseif($val->status=="NH") {$label="inverse";$msg = "NOT HOME";} 
                                                            elseif($val->status=="DNC") {$label="important special";$msg = "DO NOT CALL!";}
                                                            elseif($val->status=="NI") {$label="important";$msg = "NOT INTERESTED";}
                                                            elseif($val->status=="Recall") {$label="warning";$msg = "RECALL";} elseif($val->status=="NQ") {$label="important special";$msg = "NOT QUALIFIED";} elseif($val->status=="WrongNumber"){$label="warning special boxshadow";$msg="Wrong Number";} else{$label="";$msg="";} ?>
                                        <tr id="leadrow-{{$val->id}}">
                                        <td ><span class="searchNum">{{$val->cust_num}}</span></td>
                                        <td>{{$val->cust_name}}</td>
                                        <td >{{$val->spouse_name}}</td>
                                        <td>{{ucfirst($val->married)}}</td>
                                        <td >{{$val->address}}</td>
                                        <td >{{$val->notes}}</td>
                                        <td><center><span class='label label-{{$label}} '>{{$msg}}</span><br/></center>
										</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @endif
								</div>


                    </div>    
                    <aside class="right" >
                    @render('layouts.chat')
                    <hr>
                    	<div style='text-align:center; float:left;margin-top:10px;padding-top:15px;padding-bottom:15px;border-top:1px solid #000;border-bottom:1px solid #000;color:#fff;width:100%;'>
                    		<div style='font-size:50px;margin-bottom:20px;margin-top:10px;'>
                    			<center>
                    				<div class='PUTON'   style='color:#1f1f1f;padding-top:20px;border-radius:5px;border:1px solid #1f1f1f;height:40px;width:30%;'>
                    				@if(!empty($callsmade))
                    				{{$callsmade[0]->total}} 
                    				@else
                    				0
                    				@endif
                    				</div>
                    			</center>
                   		 </div>
                   		Calls Made This Hour
                        <div style='font-size:50px;margin-bottom:20px;margin-top:10px;'>
                                <center>
                                    <div class='PUTON'   style='color:#1f1f1f;padding-top:20px;border-radius:5px;border:1px solid #1f1f1f;height:40px;width:70%;'>
                                    <?php 
                                    $booked = Auth::user()->booked(date('Y-m-d'));
                                    $hours = Auth::user()->hoursWorked(date('Y-m-d'));
                                    if($hours>0 && $booked>0){
                                        echo number_format($booked/$hours,2,'.','');
                                    } else {
                                        echo "N/A";

                                    }
                                    ?>
                                    
                                    </div>
                                </center>
                         </div>
                         BPH for Today
              		</div>

              		@include('plugins.bookerstats')


                    </aside>  
            </div>
            </div>
        </div>
        <div class="push"></div>
    </div>
    <!-- end .height wrapper -->

<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&libraries=places&language=en-AU"></script>
@if($bucketset!="" || count($buckets) <= 1)
@if(!empty($singlelead))
	@if($singlelead->leadtype!="survey")
		@include('plugins.bookingscript')
	@else
		@include('plugins.surveyscript')
	@endif
@endif
@endif
<script src="{{URL::to_asset('js/include/gmap3.min.js')}}"></script>



<script type="text/javascript" src="{{URL::to_asset('slots/')}}js/slot.js"></script>
<script src="{{URL::to_asset('js/editable.js')}}"></script>
@if(Auth::user()->three_day==0)
<script>
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
</script>
@else
<script>
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
</script>
@endif


<script>
$(document).ready(function(){
$('#leadmenu').addClass('expanded');


$('.chooseLeadtype').click(function(){
	var type = $(this).data('type');
});

$('#booking_modal').modal({backdrop: 'static'});

$('#viewappsneeded').click(function(){
	$('#appointmentsNeededTable').load("{{URL::to('appointment/needed/json')}}");
});

$('.edit').editable('../../lead/edit',{
        submit:'OK',
        indicator : 'Saving...',
        tooltip: 'CLICK TO EDIT..',
    });
$('.scriptvalue2').on('change',function(){
var val = $(this).val();
var id = $(this).attr('id');
$('.scriptval-'+id).html(val);
});
$('.editstatus').editable('../../lead/edit',{
        data : '{"NQ":"NQ","NI":"NI","NH":"NH","DNC":"DNC","Recall":"Recall"}',
        type:'select',
        submit:'OK',
        indicator : 'Saving...',
        tooltip: 'Edit.....'
});

$('.clicktoconfirm').click(function(){
$('.confirminfo').hide();
$('#'+$(this).data('id')).toggle(200);
});



$('.calllead').click(function(){
var num = $(this).data('num');
$('#booking_modal').modal({backdrop: 'static'});
toastr.success('Get Ready...', 'Calling '+num);
});

$('.requestleads').click(function(){
var url = "../../dashboard/requestleads";
$.get(url, function(data){
toastr.success('You have requested some leads', 'Lead Request Send');
});
});

var length = ($('.calllist').length);
var count=0;
$('.calllist').each(function(i,val){
	count++;
if(count==length-1){
	return false;
}
 $(this).hide();
});


$(".booktimepicker2").timePicker({
  startTime: "10:00", 
  endTime: new Date(0, 0, 0, 23, 30, 0), 
  show24Hours: false,
  step: 15});



$('.checkphone').click(function(){
value = $('#phone').val();

$.get( "../../lead/checkscratchnum/"+value, function( data ) {
	console.log(data);
if(data){
 toastr.error('<a href="../../lead/newlead/'+value+'">Click Here to View This Lead</a>...', 'Number already exists in system!');
} else {
if(value.length != 12) { 
 toastr.warning('Please enter a valid phone number', 'Not a valid 10 digit number!!');
} else {
 toastr.success('You can continue entering Lead information', 'Number is Valid!');

$('#scratchcard').show().addClass('animated fadeInUp');
$('#cust_num').val(value);
}}
});
});

$('.bookappt').click(function(){
var date = $('#apptDate').val();
	if(!validateDate(date)){
     		return false;
	};	

if( document.myForm.city.value == "" )
   {
     toastr.error( "Please provide the City!" );
     document.myForm.city.focus() ;
     return false;
   }



if( document.myForm.custname.value == "" )
   {
     toastr.error( "Please provide a Name!" );
     document.myForm.custname.focus() ;
     return false;
   }
if( document.myForm.address.value == "" )
   {
     toastr.error( "Please provide a valid address" );
     return false;
   }
if( document.myForm.booktimepicker.value == "" )
   {
     toastr.error( "Please provide an appointment time!" );
     return false;
   }

$('#status').val("APP");
$('#myForm').submit();

});


$('.otherstatus').click(function(){
if( document.myForm.cust_num.value == "" )
   {
     toastr.error( "Please provide Phone Number!" );
     document.myForm.cust_num.focus() ;
     return false;
   }
if( document.myForm.city.value == "" )
   {
     toastr.error( "Please provide the City!" );
     document.myForm.city.focus() ;
     return false;
   }

if( document.myForm.custname.value == "" )
   {
     toastr.error( "Please provide a Name!" );
     document.myForm.custname.focus() ;
     return false;
   }
   var status = $(this).data('status');
   console.log(status);
   $('#status').val(status);
   $('#myForm').submit();
});



$('.viewallcalls').click(function(){
$('.lastcalls').toggle();
$('.calllist').toggle();
});
});
</script>


@endsection