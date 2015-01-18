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
                <div id="page-content" >
            
                
                    <!-- page header -->
                    <h1 id="page-header"><img src='{{URL::to("images/clozer-cup.png")}}' style='margin-right:-10px;margin-top:-20px;'>&nbsp;System Wide Alerts</h1>   

                
                    
                    <div class="fluid-container">
                        
                     
                       
                        <!-- widget grid -->
                        <section id="widget-grid" class="">
                        
                        	<div class="row-fluid " id="assignleads">
                       

                        		<!-- article -->	
								<article class="span12 ">
									

								<!-- new widget -->
									<div class="jarviswidget medShadow" id="widget-id-1">
									    <header>
									        <h2>System Messages</h2>                           
									    </header>
									    
									    <!-- widget div-->
									    <div>
									    	<!-- widget edit box -->
									        <div class="jarviswidget-editbox">
									            <div>
									                <label>Title:</label>
									                <input type="text" />
									            </div>
									            <div>
									                <label>Styles:</label>
									                <span data-widget-setstyle="purple" class="purple-btn"></span>
									                <span data-widget-setstyle="navyblue" class="navyblue-btn"></span>
									                <span data-widget-setstyle="green" class="green-btn"></span>
									                <span data-widget-setstyle="yellow" class="yellow-btn"></span>
									                <span data-widget-setstyle="orange" class="orange-btn"></span>
									                <span data-widget-setstyle="pink" class="pink-btn"></span>
									                <span data-widget-setstyle="red" class="red-btn"></span>
									                <span data-widget-setstyle="darkgrey" class="darkgrey-btn"></span>
									                <span data-widget-setstyle="black" class="black-btn"></span>
									            </div>
									        </div>
									        <!-- end widget edit box -->
            
									        <div class="inner-spacer"> 
									        <!-- content -->	
												<div class="accordion" id="accordion1">
													<div class="accordion-group">
														<div class="accordion-heading">
															<a class="accordion-toggle " data-toggle="collapse" data-parent="#accordion1" href="#collapse1">
																<i class="icon-plus-sign"></i> Alerts for Everyone</a>
														</div>
														<div id="collapse1" class="accordion-body in collapse" style="height: auto; ">
															<div class="accordion-inner">

																<!--DISPLAY MESSAGES HERE WITH EDIT DEL-->



	                                        				    <div class="control-group">
                                            				    	<label class="control-label" for="input01"><b>Enter New Message to Everyone</b></label>
                                            				    	<div class="controls">
                                            				    	    <textarea type="text" rows=4 class="span12"  id="all-sysmsg" name="all-sysmsg" >{{$allalert[2]->message}}</textarea>
                                            				    		<a class="btn btn-primary btn-success savemessage" data-id="{{$allalert[2]->id}}" data-type="all">SAVE MESSAGE</a>
                                            				    	</div>
                                            					</div>
															</div>
														</div>
													</div>
													<div class="accordion-group">
														<div class="accordion-heading">
															<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapse2">
															<i class="icon-plus-sign"></i>
															 Alerts for Specialists</a>
														</div>
														
														<div id="collapse2" class="accordion-body collapse" style="height: 0px; ">
															<div class="accordion-inner">
																	<!--DISPLAY MESSAGES HERE WITH EDIT DEL-->



	                                        				    <div class="control-group">
                                            				    	<label class="control-label" for="input01"><b>Enter New Message to Specialists</b></label>
                                            				    	<div class="controls">
                                            				    	    <textarea type="text" rows=4 class="span12"  id="spec-sysmsg" name="spec-sysmsg" >{{$allalert[1]->message}}</textarea>
                                            				    		<a class="btn btn-primary btn-success savemessage" data-id="{{$allalert[1]->id}}" data-type="spec">SAVE MESSAGE</a>
                                            				    	</div>
                                            					</div>
															</div>
														</div>
													</div>
													<div class="accordion-group">
														<div class="accordion-heading">
															<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapse3">
																<i class="icon-plus-sign"></i> Alerts for Bookers </a>
														</div>
														<div id="collapse3" class="accordion-body collapse" style="height: 0px; ">
															<div class="accordion-inner">
															
																<!--DISPLAY MESSAGES HERE WITH EDIT DEL-->



	                                        				    <div class="control-group">
                                            				    	<label class="control-label" for="input01"><b>Enter New Message for Bookers</b></label>
                                            				    	<div class="controls">
                                            				    	    <textarea type="text" rows=4 class="span12"  id="book-sysmsg" name="book-sysmsg" >{{$allalert[0]->message}}</textarea>
                                            				    		<a class="btn btn-primary btn-success savemessage" data-id="{{$allalert[0]->id}}" data-type="book">SAVE MESSAGE</a>
                                            				    	</div>
                                            					</div>

															</div>
														</div>
													</div>
												</div>
											<!-- end content -->	
									        </div>
									        
									    </div>
									    <!-- end widget div -->
									</div>
									<!-- end widget -->


								</article>
								<!-- end article-->





                        	</div>


                  
                        
                            
                            
                            
                           
                            
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
        </div><!--end fluid-container-->
        <div class="push"></div>
    </div>
    <!-- end .height wrapper -->
<script>
$(document).ready(function(){
$('#systemmenu').addClass('expanded');

$('.savemessage').click(function(){
	var type = $(this).data('type');
	var id = $(this).data('id');
	var msg = $('#'+type+'-sysmsg').val();
		$.post("savealert", { msg_id: id, message: msg}).done(function(){
			toastr.success(msg, 'Message Saved');
		});
});
});
</script>
@endsection

















