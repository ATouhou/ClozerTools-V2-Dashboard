							

            	        			<h5>Un-completed Appointments for <font color=yellow>{{$therep}}</font></h5>
                      					@foreach($apps as $v)
                      					<div style='padding-bottom:25px;border-bottom:1px solid #3e3e3e;width:90%;'>
                      						<?php if($v->status=="DNS"){$res = 'important special blackText';} 
                      						else if($v->status=="INC"){$res = 'warning special blackText';} 
                      						else if($v->status=="CXL"){$res = 'important blackText';} 
                      						else if(($v->status=="RB-TF")||($v->status=="RB-OF")){$res = 'info special';} 
                      						elseif($v->status=="SOLD") {$res="warning special blackText";} else {$res="";};?>
                      						<span class='label label-{{$res}}'>
                      							{{$v->status}}
                      						</span> &nbsp;&nbsp;{{date('M-d',strtotime($v->app_date))}} {{date('h:i a',strtotime($v->app_time))}} 
                      						&nbsp;&nbsp;&nbsp;<a href='{{URL::to("appointment")}}?appdate={{$v->app_date}}&appid={{$v->id}}' target=_blank><button class='btn btn-mini btn-primary'>View APP</button></a><br/>
                      						<div class='booker-footer'>Booked on {{date('M-d',strtotime($v->booked_at))}}  by <span>{{$v->booked_by}}</span>
                      						</div>
                      					</span>
                      					</div>
                      					@endforeach
                      		
                              <button class='btn btn-danger btn-small ' style='margin-top:10px;margin-bottom:20px;' onclick="$('.infoHover').hide(100);"><i class='cus-cancel'></i>&nbsp;Close</button>&nbsp;&nbsp;
                              