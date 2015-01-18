@layout('layouts/main')
@section('content')

<script>
function showLeads(){
$('.leadpanel').fadeIn(400);
$('#stats2').hide();
}

function showStats(){
$('.leadpanel').hide();
$('#stats2').fadeIn(300);
}
</script>

<style>
#leads {display:none;}
#stats2 {display:none;}
.themap{width:100%;float:left;}
</style>
      
<div id="main" role="main" class="container-fluid">
    <div class="contained">
    	<!-- aside start -->
    	<aside> 
        	@render('layouts.managernav')
        		<div id="map" class="shadowBOX" style="100%;height:450px;"></div>
	    </aside>
        <!-- aside end -->
        <!-- main content -->
        <div id="page-content">
            <!-- page header -->
            <h1 id="page-header">ENTER NEW LEADS<button class="btn btn-default viewmap" style="float:right;margin-right:10px;margin-top:10px;"><i class="cus-map"></i>&nbsp;VIEW MAP OF WEEK</button>
            	<button class="btn btn-default" onclick="$('#wrongnums2').toggle(300);" style="float:right;margin-right:10px;margin-top:10px;"><span style="float:left;color:#fff;"class="badge badge-important special">{{count($wrongnums)}}</span>&nbsp;FIX WRONG NUMBERS</button>
            </h1> 
    			<div class="fluid-container">
					 <div class="row-fluid well" style="margin-top:10px;">
                            <div class="largestats end ">
                                <span class="bignum2 BOOK">{{Count($myleads)}}</span><br/>
                                <h5>COMPLETED</h5>
                            </div>
              
                            <div class="largestats end">
                                <span class="bignum2 SOLD">${{Count($myleads)*3}}</span><br/>
                                <h5>Estimated Earnings for Week</h5>
                            </div>
                    </div>

                    <div class="themap" style="display:none"><h5>Your Door Reggies for Week of {{date('M-d')}}</h5>
					<div id="map2" style="width:100%;height:300px;margin-bottom:20px;border:1px solid #1f1f1f;"></div>
					</div>
					

                    <div class="row-fluid well" id="wrongnums2" style="display:none;" >
                     				@if(!empty($wrongnums))
							
								@foreach($wrongnums as $val)
								<div id="confirmalert-{{$val->id}}" class="alert adjusted alert-warning animated bounce">
								    <span class="large" style="margin-left:-5px;margin-right:20px;">&nbsp;<i class='cus-telephone'></i>&nbsp;{{$val->cust_num}}</span><strong> PLEASE FIX! &nbsp; </strong>
								    &nbsp;&nbsp;Name : <span class="label label-inverse">{{$val->cust_name}}</span>
     						        &nbsp;&nbsp;Survey Date : <span class="label label-info special">{{date('D-d', strtotime($val->entry_date))}}</span>
								    &nbsp;&nbsp;Address:&nbsp;&nbsp;<span class="label label-inverse">{{$val->address}}</span></h5>
								    <button class="btn btn-mini btn-primary rectify" data-id="confirm-{{$val->id}}" style="float:right;">FIX THIS NUMBER</button>
								    <div class="confirminfo" id="confirm-{{$val->id}}" style="display:none;height:200px;">
								        <div class="row-fluid">
								        <div class="span8">
								        	<span class="label label-success">Customer has been called {{count($val->calls)}} times</span><br/>
								        	<h5>Address:&nbsp;&nbsp;<span class="label label-inverse">{{$val->address}}</span></h5>
								        	<br/>
								        	<div class="span5">
								        		Search address on : <br/>
								        		<button style="padding:10px;">
								        			<a href="http://www.canada411.ca/search/?stype=si&what=&where={{urlencode($val->address)}}" target=_blank>
								        				<img src="{{URL::to('images/411.png')}}" border=0 width=150px style="margin-left:0px;margin-top:5px;" />
								        			</a>
								    			</button>
								    		</div>
								    		<div class="span5">
								        		Reverse Search Number : <br/>
								        		<button style="padding:10px;">
								        		<a href="http://www.canada411.ca/search/?stype=re&what={{$val->cust_num}}" target=_blank>
								        			<img src="{{URL::to('images/411-icon.png')}}" border=0 width=22px style="margin-left:0px;margin-top:5px;" />
								        			<strong>{{$val->cust_num}}</strong>
								        		</a>
								    			</button>
								        	</div>
								        </div>
								        <div class="span4" style="margin-top:28px;margin-left:-60px;">
								        	<label for="fixnum">ENTER PHONE NUMBER</label>
								        	<input type="text" class="wrongnum" name="fixnum" id="fixnum" value="{{$val->cust_num}}" />
								        	<br/>
								        	<button class="btn btn-primary savenum" data-oldnum="{{$val->cust_num}}" data-id="{{$val->id}}">SAVE</button>&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-danger 								deletenum" data-id="{{$val->id}}">DELETE</button><br/><br/>
								        	<span class="small">Please DELETE the lead if you cannot rectify the wrong number.<br>
								        	You will not be paid for leads that can't be corrected</span><br/>
								        </div>
								    </div>
								    </div>
								</div>
								@endforeach
							@endif
                     </div>



					
					 <div class="row-fluid" style="margin-top:30px;margin-bottom:40px;">
                            <div class="span12">
                               
                                <table class="table apptable" >
                                    <thead>
                                        <tr style="background:#1f1f1f;color:#fff;">
                                            <th style="padding-right:40px;"><span class="small">Survey Date</th>
                                            <th style="width:100px;">Number</th>
                                            <th style="width:60px;">Name</th>
                                            <th style="width:60px;">Spouse</th>
                                            <th style="width:80px">Marital Status</th>
                                            <th style="width:245px">Address</th>
                                            <th>Notes</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <form id="addnewsurvey" method="post" action="{{URL::to('lead/addnewdoor')}}">
                                    		<h4>Pick City</h4>
											@if($errors->has('city'))<span class="label label-important special">City is Required!</span><br/>@endif
                                            <select id="city" name="city" class="span3" style="background:#FFFF99">
												<option value=""></option>
												@if(!empty($cities))
													@foreach($cities as $val)
													<option value="{{$val->cityname}}" 
													@if(Session::get('leadcity')==$val->cityname) selected='selected' @endif   >
														{{$val->cityname}} </option>
													@endforeach
													@endif
										    </select>
                                    <tbody>	
                                    	<tr style="background:#FFFFE0">
                                        <td><b>Survey Date</b><br/>
											<div class="input-append date" id="datepicker-js" data-date="{{date('d-m-Y')}}" data-date-format="dd-mm-yyyy">
												<input class="datepicker-input" size="11" type="text" style="float:left;width:78px;" value=@if(Session::get('leaddate')) "{{Session::get('leaddate')}}" @else "{{date('Y-m-d')}}" @endif placeholder="Select a date" name="surveydate" id="surveydate"/>
												<span class="add-on"><i class="cus-calendar-2"></i></span>
											</div>
										</td>
                                        <td >
                                        	@if($errors->has('phone'))<span class="label label-important special">Phone Number is Required!</span>@else <b>Phone #</b>@endif</label>
                                        	<input type="text" class="span12"  id="phone" name="phone" value="{{Input::old('phone')}}" onKeyup="addDashes(this)"  />
                                        </td>
                                        <td >
                                        	@if($errors->has('custname'))<span class="label label-important special">Customer Name is Required!</span>@else <b>Name</b>@endif</label>
											<input type="text" class="span12"  id="custname" name="custname"  value="{{Input::old('custname')}}" />
										</td>
										<td>
											<b>Spouse</b>
											<input type="text" class="span12"  id="spousename" name="spousename"  value="{{Input::old('custname')}}" />
										</td>
                                        <td><b>Marital Status</b>
                                        	<select class="span12" name="married" id="married">
												<option value="married">Married</option>
												<option value="single">Single</option>
												<option value="commonlaw">Common Law</option>
												<option value="widowed">Widow</option>
											</select>
										</td>
										<td>
											@if($errors->has('address'))<span class="label label-important special">Address is Required!</span>@else <b>Address</b>@endif</label>
                                            <input type="text" class="span12 addressDropdown"  id="address" name="address"  value="{{Input::old('address')}}" />
										</td>

                                        <td ><textarea class="span12"  id="notes" name="notes"  value="{{Input::old('notes')}}" ></textarea></td>
                                        <td><center><button class='btn btn-primary btn-large'><i class="cus-accept"></i>&nbsp;SAVE</button></center></td>
                                        </tr>
                                    	</form>
                                        @foreach($myleads as $val)
                                        <?php if($val->status=="APP"){$shadow="shadowtable";$color="#000";} else {$shadow="";$color="black";}
                                                            if($val->status=="APP"){$label="success";$msg = "DEMO BOOKED!";}
                                                            elseif($val->status=="INACTIVE"){$label="inverse";$msg="UNRELEASED";}
                                                            elseif($val->status=="NEW"){$label="info";$msg="IN POOL";}
                                                            elseif($val->status=="SOLD"){$label="success special";$msg = " $$ SOLD $$";}
                                                            elseif($val->status=="ASSIGNED"){$label="info";$msg = "ASSIGNED TO CALL";} 
                                                            elseif($val->status=="NH") {$label="inverse";$msg = "NOT HOME";} 
                                                            elseif($val->status=="DNC") {$label="important special";$msg = "DO NOT CALL!";}
                                                            elseif($val->status=="NI") {$label="important";$msg = "NOT INTERESTED";}
                                                            elseif($val->status=="Recall") {$label="warning";$msg = "RECALL";} elseif($val->status=="NQ") {$label="important special";$msg = "NOT QUALIFIED";} elseif($val->status=="WrongNumber"){$label="warning special boxshadow";$msg="Wrong Number";} else{$label="";$msg="";} ?>
                                        <tr id="leadrow-{{$val->id}}">
                                        <td>
                                       	<div class="input-append date changeDate" id="datepicker-js" data-id="entry_date|{{$val->id}}" data-date="{{date('d-m-Y',strtotime($val->entry_date))}}" data-date-format="dd-mm-yyyy">
								<input class="datepicker-input" size="11" type="text" style="float:left;width:78px;" value="{{date('d-m-Y',strtotime($val->entry_date))}}" placeholder="Select a date" name="surveydate" id="surveydate"/>
								<span class="add-on"><i class="cus-calendar-2"></i></span>
							</div>
                                        

                                        </td>
                                        <td @if(($val->status=='INACTIVE')||($val->status=='WrongNumber')) class="edit" id="cust_num|{{$val->id}}" @endif>{{$val->cust_num}}</td>
                                        <td @if(($val->status=='INACTIVE')||($val->status=='WrongNumber')) class="edit" id="cust_name|{{$val->id}}" @endif>{{$val->cust_name}}</td>
                                        <td @if(($val->status=='INACTIVE')||($val->status=='WrongNumber')) class="edit" id="spouse_name|{{$val->id}}" @endif>{{$val->spouse_name}}</td>
                                        <td>{{ucfirst($val->married)}}</td>
                                        <td @if(($val->status=='INACTIVE')||($val->status=='WrongNumber')) class="edit" id="address|{{$val->id}}" @endif>{{$val->address}}</td>
                                        <td @if(($val->status=='INACTIVE')||($val->status=='WrongNumber')) class="edit" id="notes|{{$val->id}}" @endif>{{$val->notes}}</td>
                                        <td><center><span class='label label-{{$label}} '>{{$msg}}</span><br/></center>
                                        	@if($val->status=="INACTIVE")
											<button class="btn btn-danger btn-mini deletenum" data-id="{{$val->id}}">X</button>
											@endif
										</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                     
                   
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
<script src="{{URL::to_asset('js/include/gmap3.min.js')}}"></script>
<script src="{{URL::to_asset('js/editable.js')}}"></script>

<script>
	var options = {componentRestrictions: {country: "ca"}};

        var autocomplete = new google.maps.places.Autocomplete($(".addressDropdown")[0], options);
        google.maps.event.addListener(autocomplete, 'place_changed', function() {

    	var place = autocomplete.getPlace();

      address = '';
      if (place.address_components) {
       address += place.address_components[0].short_name;
       address += " "+place.address_components[1].short_name;
       address += " ,"+" "+place.address_components[2].short_name;
      }
});
</script>
<script>
$(document).ready(function(){
$('#leadmenu').addClass('expanded');

$('.changeDate').change(function(){
      var t = $(this).data('id');
      var val = $(this).find('input').val();
      $.get('../lead/edit',{id:t,value:val}, function(data){
      	toastr.success('Date updated succesfully!', 'DATE UPDATED');
      });
});

$('.viewmap').click(function(){
$('.themap').toggle();
var url = '../dashboard/getmap/1';
$.getJSON(url, function(data) {
 console.log(data);
$("#map2").gmap3({
  marker:{
    values: data.map,
    options:{
     draggable:false,
    },
    events:{
      mouseover: function(marker, event, context){
        var map = $(this).gmap3("get"),
          infowindow = $(this).gmap3({get:{name:"infowindow"}});
        if (infowindow){
          infowindow.open(map, marker);
          infowindow.setContent(context.data);
        } else {
          $(this).gmap3({
            infowindow:{
              anchor:marker, 
              options:{content: context.data}
            }
          });
        }
      },
      mouseout: function(){
        var infowindow = $(this).gmap3({get:{name:"infowindow"}});
        if (infowindow){
          infowindow.close();
        }
      },
    }
  },
  map:{
    options:{
      zoom: 12,
       center: new google.maps.LatLng(data.leads[0].lat,data.leads[0].lng),
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        mapTypeControl: true,
        mapTypeControlOptions: {
         mapTypeIds: [google.maps.MapTypeId.ROADMAP, google.maps.MapTypeId.HYBRID],
          style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
        },
        navigationControl: true,
        scrollwheel: true,
        streetViewControl: true
     }
  }


});
});
});


$('.rectify').click(function(){
$('.confirminfo').hide();
$('#'+$(this).data('id')).toggle(200);
});

$('.edit').editable('{{URL::to("lead/edit")}}',{
 indicator : 'Saving...',
         tooltip   : 'Click to edit...',
		 submit  : 'OK'
});

$('input#phone').blur(function(){
var value = $(this).val();

if(value.length!=0){
	$.get( "../lead/checknum/"+value, function( data ) {
		if(data){
 		toastr.error('Please try again, make sure you are typing it correctly...', 'Number already exists in system!');
		} else {
		if(value.length != 12) { 
 		toastr.warning('Please enter a valid phone number', 'Not a valid 10 digit number!!');
		} else {
 		toastr.success('You can continue entering Lead information', 'Number is Valid!');
		}}
	});
}
});

$('#address').blur(function(){
var city = $('#city').val();
var address = $(this).val();
if(address.length>0){
	address = address+","+city;
} else {address = city;}
getmap(address);
});

getmap("Victoria");

function getmap(add){
$("#map").gmap3({
	clear: {
		name: ["marker"]
	},
	marker: {
		address:add, options:{icon: "/img/demo-icon.png"}
	},
    map:{
      options:{
        zoom:12,
        mapTypeId: google.maps.MapTypeId.TERRAIN,
        mapTypeControl: true,
        navigationControl: true,
        scrollwheel: true,
        streetViewControl: true
      }
    },
    autofit:{}
  });
}

$('.savenum').click(function(){
	var id = $(this).data('id');
	var fixnum = $('#fixnum').val();
	var oldnum = $(this).data('oldnum');
	if(fixnum==oldnum){
		toastr.error('Thats the same number as before, please enter a new number, or delete the lead.', 'Same Number');
	return false;
	} else {

	if(fixnum.length!=0){
	$.get( "../lead/checknum/"+fixnum, function( data ) {
		if(data){
 		toastr.error('Please try again, make sure you are typing it correctly...', 'Number already exists in system!');
		} else {
		if(fixnum.length != 12) { 
 		toastr.warning('Please enter a valid phone number', 'Not a valid 10 digit number!!');
		} else {
		var url = "../lead/fixnum";
		$.get(url,{id:id,phone:fixnum}, function(data){
		$('#confirmalert-'+id).hide(600);
		toastr.success('New number entered into system', 'Succesully Submitted New Number');
		});
		}}
	});
	}}
});

$('.deletenum').click(function(){
	var id = $(this).data('id');
	var url="../lead/delete/"+id;

	var l = confirm("Are you sure you want to delete this lead?");
	if(l){
	$.getJSON(url,function(data){
		$('#leadrow-'+id).hide(600);
		toastr.success('Lead successfully deleted', 'LEAD REMOVES!');
	});}
});

$('.wrongnums').click(function(){
$('#viewwrongnumbers').trigger('click');
});

});
</script>
@endsection