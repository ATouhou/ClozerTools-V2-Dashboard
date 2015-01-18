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
                <h1 id="page-header">Your Profile</h1>   
					<div class="fluid-container">
                     	
                        <!-- widget grid -->
                        <section id="widget-grid" >

                        	<div class="row-fluid" id="assignleads">
                        		<!-- article -->	
								<article class="span12">
									<!-- new widget -->
									<div class="jarviswidget" id="widget-id-1">
									    <header>
									        <h2>Accordion default with icon</h2>                   
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
															<a class="accordion-toggle active" data-toggle="collapse" data-parent="#accordion1" href="#collapse1">
																<i class="icon-plus-sign"></i> Your Avatar </a>
														</div>
														<div id="collapse1" class="accordion-body in collapse" style="height: auto; ">
															<div class="accordion-inner">
																<h4>DO NOT UPLOAD AVATER YET! NOT WORKING....will break!</h4>
															<div style="float:left;height:300px;">
																@if(!empty(Auth::user()->avatar))
																<img src="{{URL::to_asset('uploads/avatars/')}}{{Auth::user()->avatar}}"  width=200px>
																@else
																<img src="{{URL::to_asset('img/')}}default-avatar.gif">
																@endif<br>
																	<a class="btn btn-success" onclick="$('#upload_modal_avatar').modal({backdrop: 'static'});" style="margin-top:20px;">Upload New Avatar</a>
															</div>
															
															</div>
														</div>
													</div>
													<div class="accordion-group">
														<div class="accordion-heading">
															<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapse2">
																<i class="icon-plus-sign"></i> Your Information</a>
														</div>
														<div id="collapse2" class="accordion-body collapse" style="height: 0px; ">
															<div class="accordion-inner">
																</div>
														</div>
													</div>
													<div class="accordion-group">
														<div class="accordion-heading">
															<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapse3">
																<i class="icon-plus-sign"></i> Your Weekly / Monthly Goals </a>
														</div>
														<div id="collapse3" class="accordion-body collapse" style="height: 0px; ">
															<div class="accordion-inner">
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
                <!-- date picker -->
                    <div id="datepicker"></div>
                  
                    <!-- end date picker -->
                </aside>
                <!-- end aside right -->
            </div>
        </div><!--end fluid-container-->
        <div class="push"></div>
    </div>
    <!-- end .height wrapper -->
    
<script>
$(document).ready(function(){
$('#dashboardmenu').addClass('expanded');
});
</script>
@endsection

















