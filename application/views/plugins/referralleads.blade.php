
@if(!empty($referrals))
                    <div class="jarviswidget black" data-widget-editbutton="false" data-widget-deletebutton="false"
                                    	data-widget-fullscreenbutton="false"  >
					<header>
						<h2>Leads Refferred By Specialists</h2>                           
					</header>
					<div>
						<div class="inner-spacer widget-content-padding"> 
							<ul id="myTab" class="nav nav-tabs default-tabs">
								@foreach($refname as $val)
								<li class="referraltabs" >
									<a href="#{{$val}}" class="referralTabs" data-toggle="tab">{{User::find($val)->fullName()}}</a>
								</li>
								@endforeach
							</ul>
							
							<div id="myTabContent" class="tab-content">
								@foreach($refname as $val)
								<?php $u = User::find($val);?>

								<div class="tab-pane fade " id="{{$val}}">
									<header></header>
                                       			<br><br>
                                       			<table class="table table-bordered responsive" >
                                                    <thead>
                                                    <tr align="center">
    												<th style="width:7%;">Entry Date</th>           	                                    
													<th class="span2">Customer<br />Phone Number</th>
													<th>Customer<br />Name</th>
													<th>City</th>
													<th>Lead Type</th>
													<th>Status</th>  
	                                                        		</tr>
                                                    			</thead>
                                                    			<tbody id="bookerleaddata">
                                                    			<?php $arr=array();?>
                                                     				@foreach($referrals as $k=>$val2)
												@if($val2->researcher_id==$val)
												@if($u)
											
												<?php if($val2->status=="APP"){$shadow="shadowtable";$color="#000";} else {$shadow="";$color="black";}
														if($val2->status=="APP"){
															if($val2->result =="SOLD"){
																$label="warning blacText";$msg = "SOLD!";
															}else if($val2->result=="DNS"){
																$label="important";$msg = "DNS";
															} else if($val2->result=="INC"){
																$label="inverse ";$msg ="INC";
															} else {
																$label="success";$msg = "DEMO BOOKED!";
															}
														}
														elseif($val2->status=="SOLD"){$label="warning blackText";$msg = " $$ SOLD $$";}
	           												elseif($val2->status=="ASSIGNED"){$label="info";$msg = "ASSIGNED TO CALL";} 
            												elseif($val2->status=="NH") {$label="inverse";$msg = "NOT HOME";} 
            												elseif($val2->status=="DNC") {$label="important";$msg = "DO NOT CALL!";}
            												elseif($val2->status=="NI") {$label="important";$msg = "NOT INTERESTED";}
            												elseif($val2->status=="NID") {$label="important special blackText";$msg = "NOT INTERESTED IN DRAW";}
           													elseif($val2->status=="Recall") {$label="warning blackText";$msg = "RECALL";} 
           													elseif($val2->status=="NQ") {$label="important";$msg = "NOT QUALIFIED";} 
           													elseif($val2->status=="INVALID"){$label="inverse redText";$msg="INVALID / RENTER";}
           													elseif($val2->status=="WrongNumber"){$label="warning";$msg="Wrong Number";} 
           													elseif($val2->status=="NEW"){$label="";$msg="STILL TO CONTACT";} 
           													else{$label="";$msg=$val2->status;}
           													if($val2->leadtype=="survey"){$val2->leadtype="Un-Surveyed";}
           													if($val2->leadtype=="paper"){$val2->leadtype="Paper/Upload";} 
           													if($val2->leadtype=="door"){$val2->leadtype="Door Reggie";}
           													if($val2->leadtype=="other"){$val2->leadtype="Scratch Card";} 
           													if($val2->status=="NEW" && $val2->leadtype=="rebook"){$label="";$msg="REBOOK APP";} 
           											?>
           											<tr id='{{$val2->cust_num}}' class="{{$shadow}} {{$val2->status}} leadrow" style='color:{{$color}}'>
													<td>{{date('M-d',strtotime($val2->entry_date))}}</td>
													<td class="span2">{{$val2->cust_num}}</td>
													<td>{{$val2->cust_name}}</td>
													<td><center>{{$val2->city}}</center></td>
													<td><center>{{ucfirst($val2->leadtype)}}</center></td>
													<td>
														<center>
															<span class='label label-{{$label}} special boxshadow'>{{$msg}}</span>
														</center>
													</td>
												</tr>
												@endif
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
				<h4>There are currently no referral leads in the system</h4>
				@endif
				<script>
					$(document).ready(function(){
						$('.referralTabs').first().trigger('click');
					});
				</script>