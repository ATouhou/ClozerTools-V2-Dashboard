@layout('layouts/main')
@section('content')

<div id="main" role="main" class="container-fluid">
    <div class="contained">
        <!-- aside -->  
        <aside> 
            @render('layouts.managernav')
        </aside>
        <!-- aside end -->
                	
			<!-- main content -->
			<div id="page-content">
				<!-- page header -->
				<h1 id="page-header">Messages</h1>	
					
					<div class="fluid-container">
                    	
						<!-- widget grid -->
						<section id="widget-grid" class="">
							<!-- row-fluid -->
							<div class="row-fluid" id="selectagents">
								<article class="span12">
									<form class="form-horizontal themed" id="leadbatchupload" method="post" >
										<fieldset>
											<div class="control-group">
												<label class="control-label" for="select01"> Select an Agent for Chat</label>
												<div class="controls">
													<select id="chattoagent" name="chattoagent" class="span12 with-search">
													    <option value=""></option>
													    @foreach($agents as $val)
													    <option value="{{$val->id}}">{{$val->firstname}} {{$val->lastname}}</option>
													    @endforeach
													</select>
												</div>
											</div>
										</fieldset>
									</form>
								</article>
							</div>


							<div class="row-fluid">
								<article class="span12">
									<!-- new widget -->
									<div class="jarviswidget"  data-widget-editbutton="false" data-widget-deletebutton="false"
                                    data-widget-fullscreenbutton="false">
									    <header>
									        <h2>Chat Interface</h2>                           
									    </header>
									    <!-- widget div-->
									    <div>
									    	<div class="inner-spacer chat-widget widget-content-padding"> 
									        	<!-- chat tabs -->
												<ul id="myChat" class="nav nav-tabs chat-tabs">
									            @if(!empty($tabs))
									            @foreach($tabs as $val)
									              <?php $user = User::find($val);?>
									              <?php if(Session::get('chat-tab')==$val){$class="getmessages active";} else {$class="getmessages";};?>
													<li class="{{$class}}" id="chat-{{$val}}" data-id="{{$val}}" data-user="{{Auth::user()->id}}">
									              	<button class="btn btn-mini pull-right chatclose chat-close-btn" data-id="{{$val}}"><i class="icon-remove"></i></button>
									              	<a  href="#{{$val}}" data-toggle="tab" >
														@if($user->logged=="1")
									              		<i class="online"></i>
									              		@else
														<i class="away"></i>
									              		@endif{{$user->firstname}}  {{$user->lastname}}</a>
									              	</li>
									              @endforeach
									              @endif
									            </ul>
									            <!-- end chat tabs -->
									            
									            <!-- chat box -->
									         	<div id="myChatTab" class="tab-content chat-content">
									            @if(!empty($tabs))
									            @foreach($tabs as $val)
									            <?php if(Session::get('chat-tab')==$val){$class="messagebox active";} else {$class="messagebox";};?>
													<div class="tab-pane fade in {{$class}} " data-id="{{$val}}" id="{{$val}}">
													 	<div id="chatview-{{$val}}" class="chat-messages">
													 	</div>
													
													<div class="row-fluid chat-box">
									            	
									            	<textarea name="enter-message" rows="3" cols="1" placeholder="Enter your message..." id="chatboxtext-{{$val}}"></textarea>
													<div class="row-fluid">
		                                                <div class="span6 type-effect" style="display:none"><img src="img/loaders/misc/16-2.gif" alt=""> You are typing...</div>
		                                                <div class="span6 chat-box-buttons pull-right">
		                                                	<input type="submit" name="chat-box-textarea" class="btn medium btn-danger pull-right sendmessage" value="Send" data-receiver="{{$val}}" >
		                                                    <a href="javascript:void(0);" title="" class="pull-right"></a>
		                                                </div>
		                                            </div>

									            </div>
									              	<!-- end chat messages -->
									               </div>
									            @endforeach
									            @endif
									            </div>
									            <!-- end chat box -->
									           
											
									        </div>
									        <!-- end content -->	
									        
									    </div>
									    <!-- end widget div -->
									</div>
									<!-- end widget -->
									
								</article>
							</div>
							<!-- end row-fluid -->
						</section>
						<!-- end widget grid -->
					</div>		
				</div>
				<!-- end main content -->
				<!-- aside right on high res -->
				<aside class="right">
		    		@render('layouts.chat')
		    		<div class="divider"></div>
				</aside>
				<!-- end aside right -->
			</div>
	    </div><!--/.fluid-container-->
		<div class="push"></div>
	</div>
	<!-- end .height-wrapper -->	


	<!-- footer -->
	@endsection
