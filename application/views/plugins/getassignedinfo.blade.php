
                      			<div>
            	        			<h3>{{$city}} </h3>
            	        			<h4><font color=yellow>{{$total}}</font> Leads assigned from {{$city}}</h4>
            	        			<br/>
                            @foreach($assigned as $val)
                              <?php 
                                  if($val->original_leadtype=="door"){$icon="cus-door";$val->original_leadtype="Door Survey";} 
                                  elseif($val->original_leadtype=="paper"){$icon="cus-script";$val->original_leadtype="Manilla Survey";} 
                                  elseif($val->original_leadtype=="secondtier"){$icon="cus-script";$val->original_leadtype="Second Tier Survey";} 
                                  else if($val->original_leadtype=="ballot"){$icon="cus-inbox";$val->original_leadtype="Ballot Box";} 
                                  else if($val->original_leadtype=="other"){$icon="cus-zone-money";$val->original_leadtype="Scratch Card";} 
                                  else if($val->original_leadtype=="referral"){$icon="cus-user";$val->original_leadtype="Referral";} 
                                  else if($val->original_leadtype=="survey"){$icon="cus-script";$val->original_leadtype="Un-Surveyed/Fresh";} else {$icon="";};?>

                                   <span class='badge badge-inverse assignedValue2'>{{$val->cnt}}</span> Leads assigned to 
                                  @if(!empty($val->booker_name))  <font color=yellow>{{$val->booker_name}}</font><br/>
                                  <span class='smallText'>TYPE : &nbsp;<i class='{{$icon}}'></i>&nbsp;&nbsp;{{$val->original_leadtype}}
                                  </span><br/>@endif 
                                 
                                  <div class='booker-footer' style='color:#ddd;padding-bottom:10px;border-bottom:1px solid #bbb'>
                                     Assigned at :{{date('H:i a',strtotime($val->assign_time))}} &nbsp;&nbsp;
                                     <a href='{{URL::to("lead/unassignlead/")}}{{$val->booker_id}}'><button class='btn btn-danger btn-mini pull-right unassignleads' style='margin-right:20px;margin-top:-10px;'>Un-assign</button></a> 
                                  </div>
                                </span><br/>
                            @endforeach
                     	        			
            	        			</div>
            	
                     
                      			
                              <button class='btn btn-danger btn-small ' style='margin-top:10px;margin-bottom:20px;' onclick="$('.infoHover').hide(100);"><i class='cus-cancel'></i>&nbsp;Close</button>&nbsp;&nbsp;
                               <button class='btn btn-primary btn-small viewBookers' data-id='{{$val->booker_id}}' style='margin-top:10px;margin-bottom:20px;'><i class='cus-eye'></i>&nbsp;View Leads</button>  
