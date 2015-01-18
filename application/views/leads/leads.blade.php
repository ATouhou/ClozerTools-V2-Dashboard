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
</style>
      
<div id="main" role="main" class="container-fluid">
    <div class="contained">
    	<!-- aside start -->
    	<aside> 
        	@render('layouts.managernav')
        	@render('sidewidgets.leftside')
        </aside>
        <!-- aside end -->
                
        <!-- main content -->
        <div id="page-content" >
            <!-- page header -->
            <h1 id="page-header">Your Assigned Leads</h1>   
				<div class="fluid-container">
                  				
                    <div id="start">
                        <ul>
                             <li>
                                <a href="{{URL::to('lead/newlead')}}" title="">
                                    <img src="{{URL::to_asset('img/start-icons/add-user.png')}}" alt="">
                                    <span>Enter New Lead</span>
                                </a>
                            </li>
                            <li>@if(!empty($blockstats))
                               	<label>{{$blockstats->block_size-$blockstats->completed}}</label>
                                @endif
                                <a href="javascript:void(0)" onclick="showLeads();" title="">
                                    <img src="{{URL::to_asset('img/start-icons/mass.png')}}" alt="">
                                    <span>ASSIGNED LEADS</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)" onclick="showStats();" title="">
                                    <img src="{{URL::to_asset('img/start-icons/stats.png')}}" alt="">
                                    <span>Todays Stats</span>
                                </a>
                            </li>

						</ul>
					</div>                      
                    <!-- end start icons -->
                    
                    <!-- widget grid -->
                    <section id="widget-grid" class="">

                        <div class="row-fluid" id="stats2">
                       		<!-- article -->	
							<article class="span12">
								<!-- new widget -->
								<div class="jarviswidget">
									<header>
									    <h2>Your Latest Stats</h2>                           
									</header>
									<!-- wrap div -->
									<div>
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


									       
									        <div class="inner-spacer"> 
									        <!-- content goes here -->
												
												@if(!empty($stats))

												<div class="span5" style="margin-left:40px;margin-top:40px;">
													<h3>Todays Stats :<h2>
															<span class="label label-success special" style="color:#1f1f1f;">{{$stats['pie']['app']}} Demos Booked</span>
															<span class="label label-warning special" style="color:#1f1f1f;">{{$stats['pie']['recall']}} To Recall</span>
															<span class="label label-important special">{{$stats['pie']['dnc']}} DNC's </span>
															<span class="label label-important">{{$stats['pie']['ni']}} Not Interested</span>
															<span class="label label-inverse">{{$stats['pie']['nh']}} Not Home</span>
															
															
																<hr>
															
															<h4>Completed Calls : <span class="shadow " style="color:#1f1f1f;">{{$stats['complete']}}</span></h4>
															<h4>Demos Booked : <span class="shadow" style="color:#1f1f1f;">{{$stats['booked']}}</span></h4>
															
															
															<br><br><h1 class="shadow">{{$stats['closeratio']}}%</h1><h2> Close Ratio</h1>
															
														</div>
												

												@endif

												<div class="span5" id="pie-chart">
												</div>
										    </div>
										    <!-- end content-->
									    </div>
									    <!-- end wrap div -->
									</div>
									<!-- end widget -->
								</article>
								<!-- end article-->





                        	</div>





                        	<div class="row-fluid">

                        		<article class="span12">
									<!-- new widget -->
									<div class="jarviswidget leadpanel" id="widget-id-1">
									    <header>
									        <h2>Your Lead List</h2>                           
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
            
									        <div class="inner-spacer widget-content-padding"> 
									        <!-- content -->	
												<ul id="myTab" class="nav nav-tabs default-tabs">
													<li class="active">
														<a href="#s1" data-toggle="tab">Next Lead to Call</a>
													</li>
													@if(!empty($myleads))
													<li>
														<a href="#s2" id="viewleadlist" data-id="{{$myleads[0]->block_id}}" data-toggle="tab">View Lead List</a>
													</li>
													@endif
													<li>
														<a href="#s3" data-toggle="tab">Recall List</a>
													</li>
													
												</ul>
												<div id="myTabContent" class="tab-content">
													<div class="tab-pane fade in active" id="s1">
														@if(!empty($singlelead))
														<div class="span7" style="margin-left:40px;">
															<h2>{{$singlelead->cust_name}} from {{$singlelead->city}}</h2>
															<span class="label label-inverse">Survey done by: {{$singlelead->researchername}}</span>
															<span class="label label-info">Completed on : {{date('M-d', strtotime($singlelead->created_at))}}</span>
															<?php $calls = Lead::find($singlelead->id)->calls;?>
															@if(!empty($calls))
															@foreach($calls as $val)<br />
															<span class="label label-success">Called on : {{date('M-d H:i:s', strtotime($val->created_at))}}</span>
															@endforeach
															@endif
															<br><br><h1 class="shadow">{{$singlelead->cust_num}}</h1>
															<button class="btn btn-success btn-large calllead" data-num="{{$singlelead->cust_num}}" style="margin-bottom:40px;">CALL THIS CUSTOMER</button>
														</div>
														@else 
														<h3>You currently don't have any leads assigned to you...</h3>
														<button class="btn btn-success sendleadalert">Let your manager know</button>
														@endif
													</div>

													<div class="tab-pane fade" id="s2">
														<table class="table table-bordered responsive" style="color:#000;" >
                                                    		<thead>
                                                    		    <tr align="center">
    																<th>Date Entered:</th>                  	      
																	<th>Customer<br />Phone Number</th>
																	<th>Customer<br />Name</th>
																	<th>City</th>
																	<th>Calls</th>
																	<th>Status</th>   
																	<th></th>
	                                                		        </tr>
                                                    		</thead>
                                                    		<tbody id="leadtable">
                                                    		
                                                    		</tbody>
                                                		</table>
													</div>


												<div class="tab-pane fade" id="s3">
												<article class="span12">
												<table class="table table-bordered responsive">
													<thead>
														<tr>
															<th>Date Entered:</th>                  	                                    
																	<th>Customer<br />Phone Number</th>
																	<th>Customer<br />Name</th>
																	<th>City</th>
																	<th>Married</th>
																	<th>Rent/Own</th>   
																	<th>FT/PT</th>
																	<th>Status</th>  
																	<th></th>
														</tr>
													</thead>
													<tbody>
															@if(!empty($recalls))
                                                     		@foreach($recalls as $val)
                                                     			<tr id="agentrow-{{$val->id}}">
                                                     				<td>{{date('M-d', strtotime($val->created_at))}}</td>
                                                     				<td class="span2">{{$val->cust_num}}</td>
													 				<td class="span4">{{$val->cust_name}}</td>
													 				<td>{{$val->city}}</td>
													 				<td>{{ucfirst($val->married)}}</td>
													 				<td>{{ucfirst($val->rentown)}}</td>
													 				<td>{{$val->fullpart}}</td>
													 				<td>{{$val->status}}</td>
																	<td class="span2">
                                                        			<a class="btn btn-warning" href="{{URL::to('lead/myleads/')}}{{$val->id}}"><i class="cus-telephone"></i>&nbsp;RECALL</a>
                                                   					</td></tr>
                                                     		@endforeach
                                                     		@endif
													</tbody>
												</table>
												</div>
												<div class="tab-pane fade" id="s4">
												</div>
												</div>
									        </div>
									    </div>
									</div>
								</article>
							</div>
						</div>
                        </section>
                        <!-- end widget grid -->
                    </div>    
                    <aside class="right">
                    @render('layouts.chat')
                    </aside>  
            </div>
                <!-- end main content -->
            </div>
                   
        </div><!--end fluid-container-->
        <div class="push"></div>
    </div>
    <!-- end .height wrapper -->
    
@include('plugins.bookingscript')

<script>
$(document).ready(function(){
$('#leadmenu').addClass('expanded');


$('input#phone').blur(function(){
var value = $(this).val();
phone= value.replace(/[^0-9]/g, '');

$.get( "../lead/checknum/"+value, function( data ) {
if(data){
 toastr.error('Please try again, make sure you are typing it correctly...', 'Number already exists in system!');
} else {
if(phone.length != 10) { 
 toastr.warning('Please enter a vlid phone number', 'Not a valid 10 digit number!!');
} else {
 toastr.success('You can continue entering Lead information', 'Number is Valid!');
}
}
});
});

$('.deleteagent').click(function(){
    var id=$(this).data('id');
    if(confirm("Are you sure you want to delete this agent?")){
        var url = "users/delete/"+id;
            $.getJSON(url, function(data) {
             $('#agentrow-'+id).hide();
            });
    }
});

$('.enternewlead').click(function(){
$('#enternew_modal').modal({backdrop: 'static'});
});

$('.calllead').click(function(){
	var num = $(this).data('num');
$('#booking_modal').modal({backdrop: 'static'});
toastr.success('Get Ready...', 'Calling '+num);
});

$('#viewleadlist').click(function(){
var id = $(this).data('id');
var url = "{{URL::to('lead/bookerleads/')}}"+id;
$("#leadtable").load(url);
});


$('.sendleadalert').click(function(){
toastr.success('You have requested some leads', 'Lead Request Send');
});


var url = "{{URL::to('stats/agentstats')}}";
$.ajax({
  dataType: "html",
  url: url,
  success: function(data){

   var dat = JSON.parse(data);

   var piedata =  dat;
  
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'pie-chart',
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: true,
                width: 550,
                    height: 550,
                    margin:[0,120,0,140]
            },
            title: {
                text: ''
            },
            tooltip: {
        	    pointFormat: '{series.name}: <b>{point.percentage}%</b>',
            	percentageDecimals: 1
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    percentageDecimals: 1,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
                        formatter: function() {
                            return '<b>'+ this.point.name +'</b>: '+ this.percentage.toFixed(2) +' %';
                        }
                    }
                }
            },
            series: [{
                type: 'pie',
                name: 'Marketing Stats Today',
                data: piedata
            }]
        });

}

});



});
</script>

@endsection