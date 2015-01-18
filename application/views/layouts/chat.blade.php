<!---CHAT MESSAGE SYSTEM-->
		  	<!--<h4>Online Users</h4>
			
					<?php $chatsystem = User::where('logged','!=','0')->where('id','!=',Auth::user()->id)->get();
						  $mymsgs = User::find(Auth::user()->id)->recmessages()->where('status','=','unseen')->get();?>
						@if(empty($chatsystem))
						<h5>No Agents are Online</h5>
						@elseif(!empty($chatsystem))
							<ul class="users-online">
								
								@foreach($chatsystem as $val)
								<li class="first">
									<a href="{{URL::to('chat/assigntab')}}/{{$val->id}}" title="">
										@if(!empty($val->avatar))
		            		            <img src="{{URL::to_asset('images/')}}{{$val->avatar}}" alt="">
		            		            @endif
		            		            <span class="user-name">
		            		                <strong>
		            		                	{{$val->firstname}} {{$val->lastname}} <span><?php $msgs = User::find($val->id)->sentmessages()
		            		                	->where('receiver_id','=',Auth::user()->id)
		            		                	->where('status','=','unseen')
		            		                	->get();?>
		            		                	@if(!empty($msgs))
		            		                	<span class="badge badge-info" style="margin-left:10px;color:#fff;">{{count($msgs)}}</span>
		            		                	@endif
		            		                </strong>
		            		                <b>{{ucfirst($val->user_type)}}</b>
		            		            </span>
		            		            <i class="online"></i>
		            		        </a>
								</li>
								@endforeach
							</ul>
							@endif
							@if(!empty($mymsgs))
	 		 				<div class="alert adjusted" style="margin-top:20px;">
		            			<strong><i class="cus-comment"></i>You have {{count($mymsgs)}} new messages</strong>
		     				</div>
		     				@endif
		     				
		           
	              	<!--END CHAT MESSAGE SYSTEM-->

	              	
     				<div class="sysalerts"></div>