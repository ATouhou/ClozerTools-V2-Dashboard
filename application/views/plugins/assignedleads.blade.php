
@if(!empty($assigned))
                    <div class="jarviswidget black" data-widget-editbutton="false" data-widget-deletebutton="false"
                                    	data-widget-fullscreenbutton="false"  >
					<header>
						<h2>Leads Assigned to Bookers</h2>                           
					</header>
					<div>
						<div class="inner-spacer widget-content-padding"> 
							<ul id="myTab" class="nav nav-tabs default-tabs">
								@foreach($assname as $val)
								<li class="bookertabs" >
									<a href="#{{$val}}" class="bookerTabs" data-toggle="tab">{{User::find($val)->fullName()}}</a>
								</li>
								@endforeach
							</ul>
							
							<div id="myTabContent" class="tab-content">
								@foreach($assname as $val)

								<div class="tab-pane fade " id="{{$val}}">
									<header>
									<h5>ASSIGNED ON : 
										<span class="label label-inverse">{{$date}}</span> | ASSIGNED TO : <span class="labellabel-inverse">{{User::find($val)->firstname}} {{User::find($val)->lastname}}
										</span>
									</h5> 
											                      
                                       			<a href="{{URL::to('lead/unassignlead/')}}{{$val}}">
                                       				<button class="btn btn-danger unassignleads" style="float:right;margin-bottom:20px;margin-top:-30px;">
                                       					<i class="cus-cancel"></i>&nbsp;UNASSIGN LEADS
                                       				</button>
                                       			</a>
                                       			<a href="{{URL::to('users/profile/')}}{{$val}}">
                                       				<button class="btn btn-primary" style="float:right;margin-right:20px;margin-bottom:20px;margin-top:-30px;">
                                       					<i class="cus-eye"></i>&nbsp;VIEW USER PROFILE
                                       				</button>
                                       			</a>    
                                       			</header>

                                       			<br><br>
                                       			
                                       			<table class="table table-bordered responsive" >
                                                    <thead>
                                                    <tr align="center">
    												<th>Date</th>
    												<th>Entry Date</th>           	                                    
													<th class="span2">Customer<br />Phone Number</th>
													<th>Customer<br />Name</th>
													<th>City</th>
													<th>Lead Type</th>
													<th>Call Time</th>
													<th>Length of Call</th>
													<th>Last Call</th>
													<th>Status</th>  
	                                                </tr>
                                                    </thead>
                                                    <tbody id="bookerleaddata">
                                                     				@foreach($assigned as $k=>$val2)
												@if($val2->booker_id==$val)
												<?php if($val2->status=="APP"){$shadow="shadowtable";$color="#000";} else {$shadow="";$color="black";}
														if($val2->status=="APP"){$label="success";$msg = "DEMO BOOKED!";}
														elseif($val2->status=="SOLD"){$label="success";$msg = " $$ SOLD $$";}
	           												elseif($val2->status=="ASSIGNED"){$label="info";$msg = "ASSIGNED TO CALL";} 
            												elseif($val2->status=="NH") {$label="inverse";$msg = "NOT HOME";} 
            												elseif($val2->status=="DNC") {$label="important";$msg = "DO NOT CALL!";}
            												elseif($val2->status=="NI") {$label="important";$msg = "NOT INTERESTED";}
           													elseif($val2->status=="NID") {$label="important special blackText";$msg = "NOT INTERESTED IN DRAW";}
           													elseif($val2->status=="Recall") {$label="warning blackText";$msg = "RECALL";} 
           													elseif($val2->status=="NQ") {$label="important";$msg = "NOT QUALIFIED";} 
           													elseif($val2->status=="INVALID"){$label="inverse redText";$msg="INVALID / RENTER";}
           													elseif($val2->status=="WrongNumber"){$label="warning";$msg="Wrong Number";} 
           													else{$label="";$msg="";}
           													if($val2->leadtype=="survey"){$val2->leadtype="Un-Surveyed";}
           													if($val2->leadtype=="paper"){$val2->leadtype="Paper/Upload";} 
           													if($val2->leadtype=="door"){$val2->leadtype="Door Reggie";}
           													if($val2->leadtype=="other"){$val2->leadtype="Scratch Card";} 
           											?>
           											<tr id='{{$val2->cust_num}}' class="{{$shadow}} {{$val2->status}} leadrow" style='color:{{$color}}'>
													<td>{{date('M-d', strtotime($val2->assign_date))}}</td>
													<td>{{date('M-d',strtotime($val2->entry_date))}}</td>
													<td class="span2">{{$val2->cust_num}}</td>
													<td>{{$val2->cust_name}}</td>
													<td><center>{{$val2->city}}</center></td>
													<td><center>{{ucfirst($val2->leadtype)}}</center></td>
													<?php $callcount = $val2->assign_count;//Lead::find($val2->id)->calls()->count();?>
													@if($callcount>0)
													<?php $last = $val2->last_call();
													
													if(!empty($val2->call_length)){
														if($val2->call_length!="00:00:00"){
															if($val2->call_length<="00:00:06"){
																$lab = "important special";
															} else if(($val2->call_length>="00:00:07")&&($val2->call_length<="00:00:10")) {
																$lab =  "warning special blackText";
															} else {
																$lab = "success special blackText";
															}
															$diff = "<center><span class='label label-".$lab."'>".$val2->call_length."</span></center>";
														}
													} else {
														if(isset($assigned[$k+1])){	
															$prev = $assigned[$k+1]->call_date;
															$diff = Call::timeBetween($val2->call_date,$prev);
														} else {
															$diff = "<span class='label label-important'>Error</span>";
														}
													}
      											     ?>
													<td>
														<center>
															@if(isset($last) && !empty($last))
															@if(($last->caller_id==$val2->booker_id)&&($last->created_at>=date('Y-m-d')))
															<span class='label label-warning blackText  '>
																{{date('h:i:s a',strtotime($val2->call_date))}}
															</span>
															@else
															<span class='label label-inverse special '>
																Hasn't Called
															</span>
															@endif
															@endif
														</center>
													</td>
													<td>@if(isset($last) && !empty($last))
														@if(($last->caller_id==$val2->booker_id)&&($last->created_at>=date('Y-m-d')))
														{{$diff}} 
														@endif
														@endif
													</td>
													<td>@if(isset($last) && !empty($last))
													Last Called by <b>{{$last->caller_name}}</b> on <b>{{date('M-d h:i a', strtotime($last->created_at))}}</b>&nbsp;&nbsp;&nbsp; 
													<span class='badge badge-inverse tooltwo' title="This lead has been assigned/called {{$callcount}} times">{{$callcount}}</span>&nbsp;&nbsp;Result : <b>{{$last->result}}</b>
													@endif
													</td>
													@else
													<td>
														<center>
															<span class='label label-inverse'>Hasn't Called</span>
														</center>
													</td>
													<td></td>
													<td>This lead has never been previously contacted</b></td>
													@endif
													<td>
														<center>
															<span class='label label-{{$label}} special boxshadow'>{{$msg}}</span>
														</center>
													</td>
												</tr>
												@endif
												@endforeach
                                                    			</tbody>
                                               		</table>
								</div>
								@endforeach
							</div>
						</div>
					</div>
				</div>
				@else
				<h4>There are currently no leads assigned to any bookers</h4>
				@endif
				<script>
					$(document).ready(function(){
						$('.bookerTabs').first().trigger('click');
					});
				</script>