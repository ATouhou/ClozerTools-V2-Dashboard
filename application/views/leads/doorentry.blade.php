@layout('layouts/main')
@section('content')

<script>



function showUploadForm(){
$('#leadbatch').toggle(400);
$('#assignleads').hide();
$('#managertable').hide();
}

function showAssignLeads(){
$('#leadbatch').hide();
$('#assignleads').toggle(400);
$('#managertable').hide();
}

$(document).ready(function(){

$('.assignLead').click(function(){
var city = $(this).data('city');
$('span.cityname').html(city.toUpperCase());
$('input#city').val(city);
$('#assignleads').toggle(400);
});

$('.enternew').click(function(){
$('#enternew').toggle(200);
/*
	var num = $(this).data('num');
$('#enternew_modal').modal({backdrop: 'static', height: '1000'});*/

});






});
</script>

<style>
#addnewagent {display:none;}
#leadbatch {display:none;}
#enternew{display:none;}
#assignleads {display:none;}
#bookerleads{display:none;}
</style>
      
<div id="main" role="main" class="container-fluid">
    <div class="contained">
        <aside> 
            <!-- aside item: Mini profile -->
            @render('layouts.managernav')
              
        </aside>
        <!-- aside end -->
               <!-- main content -->
                <div id="page-content" >

                    <!-- page header -->
                    <h1 id="page-header">Enter New Lead</h1>   
                    <div class="fluid-container">
                        <!-- widget grid -->
                       <section id="widget-grid" class="">
						 <div class="row-fluid">
                                <article class="span8" id="addnewlead" >
								@if($errors->has())
								<b>We encountered the following errors:</b>
								<ul>
								@foreach($errors->all() as $message)
									<li>{{ $message }}</li>
								@endforeach
								</ul>
								@endif
							
						

								<form class="form-horizontal themed" id="payform" method="post" action="{{URL::to('lead/addnewdoor')}}">

                                        <fieldset>
                                            <h4>Pick City</h4>
                                            <div class="control-group @if($errors->has('city')) error @endif ">
											@if($errors->has('city'))<span class="label label-important special">City is Required!</span>@endif
                                                <select id="city" name="city" class="span12">
													            	<option value=""></option>
													            	@if(!empty($cities))
													            	@foreach($cities as $val)
													            	<option value="{{$val->cityname}}" 
																	@if(Session::get('leadcity')==$val->cityname) selected='selected' @endif   >
																	{{$val->cityname}} </option>
													            	@endforeach
													                @endif
												</select>
                                            </div>
                                        </fieldset>
										
                                        <br>
                                        <fieldset style="margin-top:35px;">
                                        <h4>User Information</h4>
											<div class="control-group @if($errors->has('phone')) error @endif ">
												<label class="control-label">@if($errors->has('phone'))<span class="label label-important special">Phone Number is Required!</span>@else <b>Phone Number</b>@endif</label>
                                                <input type="text" class="span12"  id="phone" name="phone" value="{{Input::old('phone')}}" />
											</div>
											
											<div class="control-group @if($errors->has('address')) error @endif">
												<label class="control-label">@if($errors->has('address'))<span class="label label-important special">Address is Required!</span>@else <b>Address</b>@endif</label>
                                                <input type="text" class="span12"  id="address" name="address"  value="{{Input::old('address')}}" />
												</div>
												
												<div class="control-group @if($errors->has('custname')) error @endif">
												<label class="control-label">@if($errors->has('custname'))<span class="label label-important special">Customer Name is Required!</span>@else <b>Customer Name</b>@endif</label>
												<input type="text" class="span12"  id="custname" name="custname"  value="{{Input::old('custname')}}" />
												</div>
												
												<div class="control-group">
													<label class="control-label">Survey Date</label>
															<div class="controls">
																<div class="input-append date" id="datepicker-js" data-date="{{date('d-m-Y')}}" data-date-format="dd-mm-yyyy">
																	<input class="datepicker-input" size="16" type="text" value=@if(Session::get('leaddate')) "{{Session::get('leaddate')}}" @else "{{date('Y-m-d')}}" @endif placeholder="Select a date" name="surveydate" id="surveydate"/>
																	<span class="add-on"><i class="cus-calendar-2"></i></span>
																</div>
															</div>
												<br>
												<label class="control-label">Marital Status</label>
												<div class="controls">
													<select class="span6" name="married">
													<option value="married">Married</option>
													<option value="single">Single</option>
													<option value="commonlaw">Common Law</option>
													<option value="widows">Common Law</option>
												</select>
												</div>
								
												
												<br>
												<label class="control-label">Notes</label>
												<div class="controls">
												<textarea class="span12"  id="notes" name="notes"  value="{{Input::old('notes')}}" ></textarea>
												</div>
												
												 </div>
                                        </fieldset>  
										<br>
									 <button title="" class="btn btn-primary btn-large processbutton" style="margin-top:40px;margin-bottom:100px; ">PROCESS LEAD</button>
                                     
                                    </form>
                                    <hr style="border:1px dashed #ddd">
                                </article>
         
						</div>

                        </section>
                        <!-- end widget grid -->
                    </div>    
                    <aside class="right">
                    	
                    @render('layouts.chat')
                    <div class="divider"></div>
                      <h2 class="shadow">Pick a Date to Analyze</h2>
            <div id="filterdate" class="shadow" style="background:#1f1f1f;border-radius:12px"></div>
                    </aside>  
            </div>
                <!-- end main content -->
            </div>
        </div><!--end fluid-container-->
        <div class="push"></div>
    </div>
    <!-- end .height wrapper -->
    

@include('plugins.enternewlead')

<script>
$(document).ready(function(){


     

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

});
</script>

@endsection