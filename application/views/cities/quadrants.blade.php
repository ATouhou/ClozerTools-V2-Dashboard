@layout('layouts/main')
@section('content')
<?php $settings = Setting::find(1);?>



<div id="main" role="main" class="container-fluid">
@if($settings->shortcode!="mdhealth" && $settings->shortcode!="mdhealth2" && $settings->shortcode!="ribmount" && $settings->shortcode!="cyclo" && $settings->shortcode!="triad" && $settings->shortcode!="starcity" && $settings->shortcode!="foxv" && $settings->shortcode!="pureair")
    @render("plugins.overlay")
@endif

    <div class="contained">
        <aside> 
            @render('layouts.managernav')
        </aside>
                
        <!-- main content -->
        <div id="page-content">
            <h1 id="page-header"><img src='{{URL::to("images/clozer-cup.png")}}' style='margin-right:-10px;'>&nbsp;City & Area Management 
            <button class="pull-right btn btn-primary toggleActive">TOGGLE INACTIVE CITIES</button>

           <!--<button class="pull-right btn btn-danger mergeCities" style="margin-right:5px;">MERGE CITIES</button>-->&nbsp;&nbsp;
            <button class="pull-right btn btn-default bordBut addCity" style="margin-right:5px;" onclick="$('#addcity').toggle(200);"><i class='cus-add'></i>&nbsp;&nbsp;ADD NEW </button>
            </h1>   
            
            @if(Session::has('merge'))
            <div class="alert adjusted animated fadeInUp">
                {{Session::get('merge')}}
            </div>
            @endif
            <div class="row-fluid" id="mergeCity" style="display:none;">
                <article class="span12">
                    <!-- new widget -->
                    <div class="jarviswidget medShadow black" data-widget-editbutton="false" data-widget-deletebutton="false"
                    data-widget-fullscreenbutton="false" >
                        <header>
                            <h2>MERGE CITIES</h2>                           
                        </header>
                        <!-- wrap div -->
                        <div>
                            <div class="inner-spacer" style="padding:20px;"> 
                                 <form class="" id="mergeCityForm" action="{{URL::to('cities/merge')}}" method="post"> 
                                <h4>Host City to Merge Leads Into</h4>
                                <br/>
                                <select name="hostCity" id="hostCity">
                                    @foreach($cities as $v)
                                    <option value="{{$v->cityname}}">{{$v->cityname}}</option>
                                    @endforeach
                                </select>
                                <br/><br/>
                               Check the Cities you want to Merge with the Chosen City<br/><br/>
                                <div class='row-fluid'>
                                    <div class='span8'>
                                    @foreach($cities as $v)
                                    <div class='span3' id="citycheck-{{$v->id}}">
                                        <input type="checkbox" class='mergeCityChecks' value="{{$v->cityname}}" name="mergeCities[]" /> &nbsp;{{$v->cityname}} 
                                    </div>
                                    @endforeach
                                    </div>
                                </form>
                                    <div class="span4 pull-right">
                                        <h5>WARNING : MERGE CANNOT BE UNDONE!</h5>
                                        <button class='btn btn-large btn-default tooltwo mergeTheLeads' title="This action will change the city on all leads to the chosen Host City.">MERGE!</button>
                                    </div>
                            </div>
                            </div>
                           
                        </div>
                    </div>
                </article>
            </div>
            <div class="row-fluid" style="margin-top:-20px;">

            <article class="span4 well" id="addcity" style="display:none;">
                <h4>Add a New City / Area</h4>
                 <form class="form-horizontal themed" id="newcity" method="post" style="margin-left:15px;" action="{{URL::to('cities/addnew')}}">
                    <label>Type :
                    <select name="city_type" id="city_type" style="width:50%;">
                        <option value="city">City</option>
                        <option value="area">Area / County</option>
                    </select>
                    </label>
                    <label>
                        Area / City Name :<br/></label>
                        <input type="text" class="span8"  id="cityname" name="cityname" />
                 
                    <br/>
                    <button title="" class="btn btn-primary" style="margin-top:10px;margin-top:20px;margin-bottom:20px">ADD NEW <span class='typeDescriptor'>CITY</span></button>
                </form>
            </article>
            <br/>
                <div class="row-fluid span12" style="margin-bottom:20px;">
                    <button class='btn btn-default switchArea cityButton' data-type='city'>VIEW CITIES</button>
                    <button class='btn btn-default switchArea areaButton' data-type='area'>VIEW AREAS</button>
                </div>
            </div>
            <div class="row-fluid">
                @if($errors->has('cityname'))
                    <div class="alert adjusted alert-warning">
                      <button class="close" data-dismiss="alert">×</button>
                      <i class="cus-cross-octagon"></i>
                      <strong>Error!</strong> {{$errors->first('cityname')}}
                    </div>
                @endif                
            </div>

            <span class="redText">You do not have to enter quadrants for cities.  
            As long as when you upload leads,  You seperate your file uploads by city. (File must only contain leads from one city)</span>
            @if($msg>0)
            <h4>{{$msg}} Cities Were Created Automatically From leads</h4>
            @endif 
                <div class="fluid-container">
                        <!-- widget grid -->
                        @if(Session::has("quadrantmsg"))
                        <div class="alert adjusted alert-info">
                        <button class="close" data-dismiss="alert">×</button>
                        <i class="cus-exclamation"></i>
                        <strong>{{Session::get("quadrantmsg")}}</strong>
                        </div>
                        @endif


                        <section id="widget-grid" class="">
                        	<div class="row-fluid tableView" id="table-city" >
                            <article class="span12">
                                    <!-- new widget -->
                                    <div class="jarviswidget medShadow black" data-widget-editbutton="false" data-widget-deletebutton="false"
                                    data-widget-fullscreenbutton="false" >
                                        <header>
                                            <h2>CITIES IN SYSTEM</h2>                           
                                        </header>
                                        <!-- wrap div -->
                                        <div>
										
										@if($errors->has('exchangecode'))
										<div class="alert adjusted alert-warning">
										<button class="close" data-dismiss="alert">×</button>
										<i class="cus-cross-octagon"></i>
										<strong>Error!</strong> The Exchange Code you entered isn't a valid 6-Digit Number!!
										</div>
										@endif
										
										@if(Session::get('numberexists'))
										<div class="alert adjusted alert-warning">
										<button class="close" data-dismiss="alert">×</button>
										<i class="cus-cross-octagon"></i>
										<strong>Error!</strong> The Exchange Code you entered is already in the system!
										</div>
										@endif

                                            <div class="inner-spacer"> 
                                                <table class="table table-striped table-bordered responsive"  >
                                                    <thead>
                                                        <tr align="center">
                                                            <th>Active / Inactive</th>  
    														<th>City / Area Name</th>
                                                            <th>Timezone Offset</th>
                                                            <th colspan=4>Gifts</th>
                                                            <th>Script Batch</th> 
                                                            @if($settings->shortcode!="foxv" && $settings->shortcode!="mdhealth2"  && $settings->shortcode!="ribmount"  && $settings->shortcode!="cyclo" && $settings->shortcode!="triad" && $settings->shortcode!="starcity" && $settings->shortcode!="mdhealth" && $settings->shortcode!="pureair")	<th>Exchange Blocks</th>
                                                            @endif                                    
															<th>Options</th>
														</tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($cities as $val)
                                                    <?php if($val->status=="active"){$cl=""; $class="";} else {$class="hide-cityrow";$cl="display:none";};?>
                                                    <tr id="cityrow-{{$val->id}}" class="{{$class}}" style="{{$cl}}">
                                                        <td class="span2">Check for ACTIVE<br/><input type="checkbox" class="activate" id="status|{{$val->id}}" name="activate" @if($val->status=='active') checked='checked' @endif /> </td>
                                                     	<td class="span3"><span class="label label-inverse " style="font-size:14px;" id="cityname|{{$val->id}}">{{$val->cityname}}</span>
                                                        <br/>
                                                        @if($settings->shortcode!="foxv" && $settings->shortcode!="mdhealth2" && $settings->shortcode!="ribmount" && $settings->shortcode!="cyclo" && $settings->shortcode!="triad" && $settings->shortcode!="starcity"  && $settings->shortcode!="mdhealth" && $settings->shortcode!="pureair")
                                                           <button class='btn btn-default btn-small viewCity' data-id='{{$val->id}}' data-cityname="{{str_replace(","," ",$val->cityname)}}" data-province="{{Setting::find(1)->province}}">CITY STATS</button>
                                                        @endif
                                                        </td>
                                                        <td>
                                                            <select style="width:100%" class="timezone" id="time_offset|{{$val->id}}">
                                                                
                                                                @for($i=-12; $i<12; $i++)
                                                                <?php $a = ""; $k="";if($i>0){$k="+";$a = "Ahead";} else if($i<0){$a="Behind";};?>
                                                                <option value='{{$i}}' @if($val->time_offset==$i) selected='selected'  @endif>
                                                                    @if($i==0)
                                                                    No Offset 
                                                                    @else
                                                                    {{$k}}{{$i}} Hours {{$a}}
                                                                    @endif
                                                                </option>
                                                                @endfor
                                                            </select>
                                                        </td>
                                                        <td class="span2">
                                                            <select style="width:100%" class="gift" id="gift_one|{{$val->id}}">
                                                                <option value=''></option>
                                                                @foreach($gifts as $val2)
                                                                <option value='{{$val2->id}}' @if($val2->id==$val->gift_one) selected='selected'  @endif>{{$val2->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td class="span2">
                                                            <select style="width:100%" class="gift" id="gift_two|{{$val->id}}">
                                                                <option value=''></option>
                                                                @foreach($gifts as $val2)
                                                                <option value='{{$val2->id}}' @if($val2->id==$val->gift_two) selected='selected'  @endif>{{$val2->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td class="span2">
                                                            <select style="width:100%" class="gift" id="gift_three|{{$val->id}}">
                                                                <option value=''></option>
                                                                @foreach($gifts as $val2)
                                                                <option value='{{$val2->id}}' @if($val2->id==$val->gift_three) selected='selected'  @endif>{{$val2->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td class="span2">
                                                            <select style="width:100%" class="gift" id="gift_four|{{$val->id}}">
                                                                <option value=''></option>
                                                                @foreach($gifts as $val2)
                                                                <option value='{{$val2->id}}' @if($val2->id==$val->gift_four) selected='selected'  @endif>{{$val2->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td class="span2">
                                                            <select style="width:100%" class="scriptbatch" id="script_batch|{{$val->id}}">
                                                                @foreach($scripts as $val2)
                                                                <option value='{{$val2->id}}' @if($val2->id==$val->script_batch) selected='selected'  @endif>{{$val2->title}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>


                                                        @if($settings->shortcode!="foxv" && $settings->shortcode!="mdhealth2" && $settings->shortcode!="ribmount" && $settings->shortcode!="cyclo" && $settings->shortcode!="triad" && $settings->shortcode!="starcity" && $settings->shortcode!="mdhealth" && $settings->shortcode!="pureair" && $settings->shortcode!="coastal")
													 	<td>
                                                            <button class='btn btn-default btn-small viewQuadrants' data-id="{{$val->id}}">VIEW QUADRANTS</button>
                                                            <div class='quadrants quad-{{$val->id}}' style='display:none'>

     													    @foreach($val->relationships as $q)
															@foreach($q as $v)
																<button style="margin-top:6px;" class='btn btn-inverse btn-small deleteQuadrant tooltwo' title="Click to remove this quadrant" id="quadblock-{{$v->attributes['id']}}" data-id="{{$v->attributes['id']}}">{{$v->attributes['exchange']}}</button>  &nbsp;
															@endforeach															
														    @endforeach
                                                        </div>
														</td>
                                                        @endif
                                                        
														<td class="span2">
                                                        <!--<button class="btn btn-warning blackText btn-mini uploadLeads" data-city="{{$val->cityname}}" data-city_id="{{$val->id}}">UPLOAD LEADS&nbsp;</button>-->
                                                        @if($settings->shortcode!="foxv" && $settings->shortcode!="mdhealth2" && $settings->shortcode!="ribmount" && $settings->shortcode!="cyclo"  && $settings->shortcode!="triad" && $settings->shortcode!="starcity" && $settings->shortcode!="mdhealth" && $settings->shortcode!="pureair" && $settings->shortcode!="coastal")
                                                        <button style="margin-top:4px;" class="btn btn-primary btn-mini addQuadrant" data-city="{{$val->cityname}}" data-city_id="{{$val->id}}">ADD QUADRANTS&nbsp;</button>
                                                        @endif
														<button style="margin-top:4px;" class="btn btn-danger btn-mini deleteCity"  data-city_id="{{$val->id}}">DELETE CITY&nbsp;</button></td>
                                                            
                                                   	</tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- end content-->
                                        </div>
                                        <!-- end wrap div -->
                                    </div>
                                    <!-- end widget -->
                                </article>
                        </div>

                        <div class="row-fluid tableView" id="table-area" style="display:none;">
                            <article class="span12">
                                    <!-- new widget -->
                                    <div class="jarviswidget medShadow black" data-widget-editbutton="false" data-widget-deletebutton="false"
                                    data-widget-fullscreenbutton="false" >
                                        <header>
                                            <h2>AREAS IN SYSTEM</h2>                           
                                        </header>
                                        <!-- wrap div -->
                                        <div>
                             
                                            <div class="inner-spacer"> 
                                                <table class="table table-striped table-bordered responsive"  >
                                                    <thead>
                                                        <tr align="center">
                                                            <th>Active / Inactive</th>  
                                                            <th>Area / County Name</th>
                                                            <th>Cities Assigned to Area</th> 
                                                            <th>Options</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($areas as $val)
                                                    <?php if($val->status=="active"){$cl=""; $class="";} else {$class="hide-cityrow";$cl="display:none";};?>
                                                    <tr id="cityrow-{{$val->id}}" class="{{$class}}" style="{{$cl}}">
                                                        <td class="span2">Check for ACTIVE<br/><input type="checkbox" class="activate" id="status|{{$val->id}}" name="activate" @if($val->status=='active') checked='checked' @endif /> </td>
                                                        <td class="span3"><span class="edit-areaname label label-inverse tooltwo" style="font-size:14px;" id="cityname|{{$val->id}}" title="Click to change City Name">
                                                        {{$val->cityname}}</span>
                                                        </td>
                                                        <td>
                                                            @if(!empty($val->subCity))
                                                                @foreach($val->subCity as $v)
                                                                <button class='btn tooltwo btn-small btn-default removeSubCity' title="Click to remove this city from the area" style='margin-top:5px;' data-cityid="{{$v->id}}" data-areaid="{{$val->id}}">{{$v->cityname}} | <span class='badge tooltwo badge-warning blackText special' title='Lead Count for this City'>{{Lead::where('city','=',$v->cityname)->where('area_id','=',$val->id)->count()}}</span></button>
                                                                @endforeach
                                                            @endif
                                                        </td>
                                                       
                                                        <td class="span6">
                                                             <button class="btn btn-default btn-small  addCitiestoArea" data-areaname="{{$val->cityname}}" data-area="{{$val->id}}"><i class='cus-add'></i>&nbsp;&nbsp;ADD CITIES&nbsp;</button>
                                                       
                                                       &nbsp;&nbsp;&nbsp;
                                                        <button class="btn btn-danger btn-small deleteCity"  data-city_id="{{$val->id}}">DELETE AREA&nbsp;</button></td>
                                                            
                                                    </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- end content-->
                                        </div>
                                        <!-- end wrap div -->
                                    </div>
                                    <!-- end widget -->
                                </article>
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

    </div>
</div>
<script src="{{URL::to_asset('js/editable.js')}}"></script>
<script>
$(document).ready(function(){
$('#citymenu').addClass('expanded');

$('#city_type').change(function(){
    var type = $(this).val();
    localStorage.setItem("areaType",type);
    filterType();
});

$('.removeSubCity').click(function(){
    var city_id = $(this).data('cityid');
    var area_id = $(this).data('areaid');
    var thisButton = $(this);
    var t = confirm("Are you sure you want to remove this city from area??");
    if(t){
        $.getJSON("{{URL::to('cities/removesubcity')}}",{area:area_id,city:city_id},function(data){
            if(data!="failed"){
                thisButton.remove();
                toastr.success('City removed from area succesfully | '+data+ ' Leads were affected by this change');
            }
        });
    }
});


$('.switchArea').click(function(){
    var type=$(this).data('type');
    $('.switchArea').removeClass('btn-inverse');
    localStorage.setItem("areaType",type);
    $(this).addClass('btn-inverse');
   filterType();
});

function filterType(){
    $('.tableView').hide();
    if(localStorage){
        if(!!localStorage.getItem("areaType")){
            if(localStorage.getItem("areaType")!="both"){
                $('.typeDescriptor').html(localStorage.getItem("areaType").toUpperCase());
                $('#city_type').val(localStorage.getItem("areaType"));
                $('#table-'+localStorage.getItem("areaType")).show();
            } else {
                $('.typeDescriptor').html("CITY");
                $('#table-city').show();
            }
            
        }
    } else {
         $('.typeDescriptor').html("CITY");
        $('#table-city').show();
    }
}
filterType();
$('.mergeCities').click(function(){
    $('#mergeCity').toggle(400);
});

$('.mergeTheLeads').click(function(e){
    e.preventDefault();
    var cnt=0;
    $('.mergeCityChecks').each(function(i,val){
        if($(this).is(':checked')){
            cnt++;
        }
    });
    if(cnt==0){
        toastr.error("You must select at least one city to merge!");
        return false;
    } else {
        $('#mergeCityForm').submit();
    }
});

$('.viewQuadrants').click(function(){
    var id = $(this).data('id');
    $('.quadrants').hide();
    $('.quad-'+id).show();
});

$('.edit').editable('{{URL::to("cities/edit")}}',{
    indicator : 'Saving...',
    tooltip   : 'Click to edit City Name',
    submit  : 'OK',
    placeholder: '....',
    width     : '100',
    height    : '25',
    callback: function(value,settings){
        console.log(value);
    }
});

$('#citylist').tagsInput({
   'height':'90px',
   'width':'420px',
   'defaultText':'Enter Cities',
});

$('.save-cities').click(function(){
    toastr.success('City List has been Updated', 'SUCCESS!');
});

$('.uploadLeads').click(function(){
    var city = $(this).data('city');
    $('.loadCityName').html(city);
    $('#leadUploadCity').val(city);
    $('#uploadLeadsModal').modal({backdrop: 'static'});
});

$('.addQuadrant').click(function(){
    var city = $(this).data('city');
    var city_id = $(this).data('city_id');
    $('#city_id').val(city_id);
    $('.loadCityName').html(city);
    $('#add_modal_exchange').modal({backdrop: 'static'});
});

$('.addCitiestoArea').click(function(){
    var areaname = $(this).data('areaname');
    var area_id = $(this).data('area');
    $('#area_id_num').val(area_id);
    $('.loadCityName').html(areaname);
    $.getJSON("{{URL::to('cities/loadcitiesforarea')}}/"+area_id,function(data){
        if(data!="failed"){
            var html="";
            $.each(data,function(i,val){
                console.log(val);
                var v = val.attributes;
                html+="<div class='span2'><input type='checkbox' name='citytoarea[]' class='cityToAreaCheckbox' value='"+v.id+"'> "+v.cityname+"</div>";
            });
            $('.loadCityList').html(html);
        }
    });
    
    $('#addcity_modal_exchange').modal({backdrop: 'static'});
});

$('.deleteCity').click(function(){
var city_id = $(this).data('city_id');
  if(confirm("Are you sure you want to delete this city?")){
        var url = "{{URL::to('cities/delete')}}/"+city_id;
            $.getJSON(url, function(data) {
             $('#cityrow-'+city_id).hide();
			 $('#citycheck-'+city_id).hide();
             toastr.success('City/Area has been Deleted', 'SUCCESS!');
            });
    }
});

$('.deleteQuadrant').click(function(){
var quad_id = $(this).data('id');
var block = $(this).html();
  if(confirm("Delete Exchange Block  "+block+"?")){
  var url = "../quadrant/delete/"+quad_id;
            $.getJSON(url, function(data) {
               $('#quadblock-'+quad_id).hide();
			 toastr.success('Exchange Block '+block+' has been Deleted', 'SUCCESS!');
            });
    }

});

$('.activate').change(function(){
var stat = $(this).attr('id');
var url = '../cities/edit';
if ($(this).is(':checked')) {
    var val = 'active';} 
    else {
        var val = 'retired';
    }
$.get(url, {id: stat, value: val}, function(data) {
            toastr.success('City status changed succesfully', 'SUCCESS!');
            });

});


$('.gift').change(function(){
        var stat = $(this).attr('id');
        var url = '../cities/edit';
        var val = $(this).val();
        $.get(url, {id: stat, value: val}, function(data) {
            toastr.success('Gift updated succesfully', 'SUCCESS!');
        });
});

$('.timezone').change(function(){
        var stat = $(this).attr('id');
        console.log(stat);
        var url = '../cities/edit';
        var val = $(this).val();
        console.log(val);
        $.get(url, {id: stat, value: val}, function(data) {
            console.log(data);
            toastr.success('Timezone Offset updated succesfully', 'SUCCESS!');
        });
});

$('.scriptbatch').change(function(){
        var stat = $(this).attr('id');
        var url = '../cities/edit';
        var val = $(this).val();
        $.get(url, {id: stat, value: val}, function(data) {
            toastr.success('Script Batch updated succesfully', 'SUCCESS!');
        });
});

});
</script>
@endsection