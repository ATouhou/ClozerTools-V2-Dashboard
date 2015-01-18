@layout('layouts/main')
@section('content')
      <style>
      .leadrow{cursor:pointer;}
      .edit {cursor:pointer;}

      .fc-event-title {
    color:yellow;
    font-size:13px!important;
}
      </style>

<?php  $row = "<tr><th></th><th>Applied</th><th>First Name</th><th>Last Name</th><th>Sin #</th><th>Cell / Phone</th>";
         $row .="<th>Craigslist</th><th>Newspaper</th><th>Called Back</th><th>Status</th><th>Actions</th></tr>";?>

<div class="modal hide fade" id="newapplicant_modal" style="margin-left:-600px;margin-top:-100px;width:800px;z-index:50000">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h3>New Applicant</h3>
  </div>
  <div class="modal-body">
    <form method="POST" action="{{ URL::to('employee/newapplicant')}}" id="new_applicant_form" enctype="multipart/form-data">
      <input type="hidden" name="type" id="type" value="applicant" />
      <div class="span4">
         Applied For : <br/>
            <select name="position" id="position">
            <option value="agent" >Marketing</option> 
           <option value="salesrep" >Sales</option> 
            <option value="doorrep" >Door Reggier</option> 
           
            </select><br/>
      First Name<br/>
      <input type="text" name="firstname" id="firstname"  />
      <br/>Last Name<br/>
      <input type="text" name="lastname" id="lastname"   />
      <br/>Sex<br/>
      <select name="sex" id="sex">
      <option value="M" >Male</option> 
      <option value="F"  >Female</option> 
      </select><br/>
      <label class="control-label">Birthdate</label>
      <div class="controls">
        <div class="input-append date" id="datepicker-js" data-date="{{date('Y-m-d',strtotime('-20 Years'))}}" data-date-format="yyyy-mm-dd">
            <input class="datepicker-input" size="16" id="birthdate" name="birthdate" type="text" value="{{date('Y-m-d')}}" placeholder="Select a date" />
              <span class="add-on"><i class="cus-calendar-2"></i></span>
        </div>
      </div>
    </div>
              <label class="control-label">Cell Phone</label>
                 <input type="text" name="cell_no" id="cell_no" />

                 <label class="control-label">SIN# Number</label>
                 <input type="text" name="sinnum" id="sinnum" />

                <label class="control-label">Address</label>
                  <input type="text" name="address" id="address" />
                  <label class="control-label">Recruited By</label>
                  <select name='recruitedby' id='recruitedby'>
                    <option value='0'>Not a Recruit</option>
                    
                  @foreach($employees as $val)
                    <option value='{{$val->id}}'>{{$val->fullName()}}</option>
                  @endforeach
                  </select>
      </form>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal">Cancel</a>
      <button type="button" onclick="$('#new_applicant_form').submit();" class="btn btn-primary">SAVE APPLICANT</a>
  </div>
</div>




<div class="modal hide fade" id="interview_modal" style="width:220px;">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h3>Setup Interview </h3>
	</div>
	<div class="modal-body">
		<form method="POST" action="{{ URL::to('hiring/interview') }}" id="interview_form" >
			 <input type="hidden" name="user-id" class='user-id' id="user-id" />
		<label for="photo">Pick a date for interview </label>
	     <div class="controls">
        <div class="input-append date" id="datepicker-js" data-date="{{date('Y-m-d')}}" data-date-format="yyyy-mm-dd">
            <input class="datepicker-input" size="16" id="interview_date" name="interview_date" type="text" value="{{date('Y-m-d')}}" placeholder="Select a date" />
              <span class="add-on"><i class="cus-calendar-2"></i></span>
        </div>
      </div>
      Interview Time<br/>
      <input class="booktimepicker2" id="interview_time" name="interview_time" type="text"  placeholder="Select Time..." style="width:80%;" />
	
	    </form>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal">Cancel</a>
    	<button type="button" onclick="$('#interview_form').submit();" class="btn btn-primary">SAVE</a>
	</div>
</div>








<div id="main" role="main" class="container-fluid">
    <div class="contained">
    	<!-- LEFT SIDE WIDGETS & MENU -->
    	<aside> 
        	@render('layouts.managernav')
       </aside>
        <!-- END WIDGETS -->
                
        <!-- MAIN CONTENT -->

        <div id="page-content" >
            <h1 id="page-header"> <img src='{{URL::to("images/clozer-cup.png")}}' style='margin-right:-10px;margin-top:-20px;'>&nbsp;Hiring / Interview Manager
              <button class='pull-right btn btn-primary newApplicant' style='margin-right:20px;'>NEW APPLICANT</button>
              @if(User::where('type','=','archived')->count()>0)
              <button class='pull-right btn btn-default viewArchive' style='margin-right:20px;'>ARCHIVED APPLICANTS</button>
              @endif
              </h1>
           
			<div class="fluid-container">
        <div class="row-fluid archives" style="margin-bottom:250px;display:none" >
          <button class='btn btn-danger closeArchive'>CLOSE</button><br/><br/>
          <div class='well'>
          <h3>All Archived Applicants</h3>
          <table class="table table-condensed table-bordered" style='margin-bottom:300px;'>
            <tr><th></th><th>Applied</th><th>First Name</th><th>Last Name</th><th>Sin #</th><th>Cell / Phone</th>
            <th>Position</th><th>Actions</th></tr>
            <tbody id="archiveTable">

            </tbody>
          </table>
        </div>
          <br/><br/>
          <div class='well'>
           <h3>All Hired Applicants</h3>

          <table class="table table-condensed table-bordered">
            <tr><th></th><th>Applied</th><th>First Name</th><th>Last Name</th><th>Sin #</th><th>Cell / Phone</th>
            <th>Position</th></tr>
            <tbody id="hiredTable">

            </tbody>
          </table>
        </div>
        </div>
        <div class="row-fluid">
           <div class="span5">
            <h3>Total Applicants This Year : <span class='totalApplicants'>{{$allapps}}</span></h3>
             @if(!empty($stats["month"][0]->tot))
            <h4>Total Interviews This Month : <span class='totalInterviews'>{{$stats["month"][0]->tot}}</span></h4/>
            @endif
            @if(!empty($stats["week"][0]->tot))
            <h4>Total Interviews This Week : <span class='totalInterviews'>{{$stats["week"][0]->tot}}</span></h4/>
            @endif
            @if(!empty($upcoming))
            <br/><br/>
            <h4>Upcoming Interviews :</h3>
              <span class='smallText'>To Remove an Interview, just click on it on the schedule</span><br/><br/>
              <button class='btn btn-mini btn-default filter' data-type='all'>ALL INTERVIEWS</button>
              <button class='btn btn-mini btn-success blackText filter' data-type='salesrep'>SALES </button>
               <button class='btn btn-mini btn-primary filter' data-type='agent'>MARKETING</button>
                <button class='btn btn-mini btn-inverse filter' data-type='doorrep'>REGGIE </button><br/><br/>
              <table class='table table-bordered table-condensed'>
                <tr><th>Date</th><th>Applicant</th><th>Position</th><th>Interview Time</th></tr>
               @foreach($upcoming as $up)
                 <tr class="emp-{{$up->id}} interview {{$up->user_type}}">
                  <?php if($up->user_type=="agent"){$type="Marketing";$label="info special";} else if($up->user_type=="salesrep"){$type="Sales";$label="success special blackText";} else {$type="Door Reggie";$label="inverse";};?>
                  <td>{{date('D-d',strtotime($up->interview_date))}}</td><td>{{$up->firstname}} {{$up->lastname}}</td><td><span class='label label-{{$label}}'>{{$type}}</span></td><td>{{date('h:i a',strtotime($up->interview_time))}}</td><td><button class='btn btn-warning blackText btn-mini hireApplicant' data-id='{{$up->id}}' >HIRE</button></td>
                 </tr>
              @endforeach  
             </table>
            @endif
          </div>
          <div class="span6 medShadow" style="border:1px solid #aaa;background:#ddd;padding:20px;border-radius:6px;margin-bottom:30px;">
                        <div id='calendar2' ></div>
            </div>

            
        </div>
              
                <!-- widget grid -->
                <section id="widget-grid" class="">
               	
                	<div class="row-fluid" id="appointments" style="margin-top:20px;">
                		
                    @if(!empty($errors->messages))
                        <div class='span12'>
                        @foreach($errors->messages as $v)                  
                        <div class="alert adjusted alert-error">
						          <button class="close" data-dismiss="alert">×</button>
						          <i class="cus-exclamation-octagon-fram"></i>
						          <strong>Warning</strong> {{$v[0]}}
					          </div>
			              @endforeach
				            </div>
				            @endif

				<?php
				$manager="";$agent="";$salesrep="";$doorrep="";$researcher="";
				foreach($applicants as $val){
					$html="";
					    if($val->type=="applicant"){
									$label = "inverse";$type="Applied";
                                                    } elseif($val->type=="employee"){
                                                    	$label = "success";$type="Employed / Hired";
                                                    } elseif($val->type=="interview"){
                                                    	$label = "info";$type="Interview Stage";
                                                    } elseif($val->type=="fired"){
                                                    	$label = "important special";$type="Fired";
                                                    } elseif($val->type=="quit"){
                                                    	$label = "inverse special";$type="Quit";
                                                    } elseif($val->type=="layedoff"){
                                                    	$label = "inverse special";$type="Layed Off";
                                                    };
                                                    if($val->user_type=="agent"){
                                                    	$label2 = "info special";$position="Marketing";
                                                    } elseif($val->user_type=="salesrep"){
                                                    	$label2 = "success";$position="Dealer Contractor";
                                                    } elseif($val->user_type=="doorrep"){
                                                    	$label2 = "inverse";$position="Door Reggier";
                                                    } else {$label2 = "inverse";$position="None Chosen";};
                                                    
					$html.="<tr class='emp-".$val->id." contact' data-id='".$val->id."' style='color:#000'><td><button class='btn btn-mini btn-danger deleteApplicant' data-id='".$val->id."'>X</button></td>";
          $html.="<td>".$val->applied_on."</td><td><span class='edit' id='firstname|".$val->id."'>".$val->firstname."</span></td><td><span class='edit' id='lastname|".$val->id."'>".$val->lastname."</span></td>";
          $html.="<td><center><span class='edit' id='sinnum|".$val->id."'>".$val->sinnum."</span></center></td>";
          $html.="<td><center><span class='edit' id='cell_no|".$val->id."'>".$val->cell_no."</span></center></td>";

                                
                                if($val->craigslist_ad==1){$check='checked="checked"';} else {$check="";};
                                $html.="<td><center><input type='checkbox' data-msg='Craigslist' name='' ".$check." class='checkbox-click tooltwo' title='Click to mark that this applicant applied via a craigslist ad'  id='craigslist_ad|".$val->id."' ></center></td>";

                              	if($val->newspaper_ad==1){$check='checked="checked"';} else {$check="";};
                              	$html.="<td><center><input type='checkbox' data-msg='Newspaper Ad' name='newspaper' ".$check." class='checkbox-click tooltwo' title='Click to mark that this applicant applied via a Newspaper Ad' id='newspaper_ad|".$val->id."' ></center></td>";
                              	if($val->called_back==1){$check='checked="checked"';} else {$check="";};
                              	$html.="<td><center><input type='checkbox' data-msg='Called Back' name='called-back' ".$check." class='checkbox-click' id='called_back|".$val->id."' ></center></td>";
                               
                              
                                
                              $html.="<td><center><span class='label label-".$label."'>".$type."</span></center></td><td>";
                              if($val->interview_date=='0000-00-00'){
                                $html.="<button class='btn btn-success btn-mini blackText setupInterview' data-id='".$val->id."' style='margin-top:5px;'>
                                SCHEDULE INTERVIEW</button>";
                              } else {
                                $html.="&nbsp;&nbsp;<button class='btn btn-warning blackText btn-mini hireApplicant' data-id='".$val->id."' style='margin-top:5px;'>
                                HIRE </button>";
                              }
                                
                                $html.="&nbsp;&nbsp;<button class='btn btn-danger btn-mini archiveApplicant' data-id='".$val->id."' style='margin-top:5px;'>
                                ARCHIVE </button>";
                              

                              $html.="</center></td></tr>";

					if($val->user_type=="agent"){
						$agent.=$html;
					}else if($val->user_type=="salesrep"){
						$salesrep.=$html;
					}else if($val->user_type=="doorrep"){
						$doorrep.=$html;
					}
				}
         
        
         
        ;?>                                                  

				<div id="applicants" class="span12 jarviswidget userTable black" data-widget-editbutton="false" data-widget-deletebutton="false"
                                    data-widget-fullscreenbutton="false" >
                                        <header>
                                            <h2>CURRENT APPLICANTS</h2>                           
                                        </header>
                                        <!-- widget div-->
                                        <div>
                                            <div class="inner-spacer widget-content-padding"> 
                                            <!-- content -->    
                                                <ul id="myTab" class="nav nav-tabs default-tabs">
                                                    <li class="bookertabs" >
                                                        <a id="agentTab" href="#agents" data-toggle="tab"><i class="cus-user-female"></i>&nbsp;Agents</a>
                                                    </li>

                                                    <li class="bookertabs" >
                                                        <a href="#salesrep" data-toggle="tab"><i class="cus-briefcase"></i>&nbsp;Sales Rep</a>
                                                    </li>

                                                    <li class="bookertabs" >
                                                        <a href="#doorrep" data-toggle="tab"><i class="cus-door-in"></i>&nbsp;Door Rep</a>
                                                    </li>
                                                </ul>
                                                
                                                <div id="myTabContent" class="tab-content">
                                                 
                                                    <div class="tab-pane fade " id="agents">
                                                        <table class="table table-striped table-bordered responsive" >
                                                            <thead>
                                                                 {{$row}}
                                                            </thead>
                                                            <tbody>
                                                      	{{$agent}}
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <div class="tab-pane fade " id="doorrep">
                                                        <table class="table table-striped table-bordered responsive" >
                                                            <thead>
                                                                  {{$row}}
                                                            </thead>
                                                            <tbody>
                                                               {{$doorrep}}
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <div class="tab-pane fade  " id="salesrep">
                                                        <table class="table table-striped table-bordered responsive" >
                                                            <thead>
                                                            {{$row}}
                                                            </thead>
                                                            <tbody>
                                                              {{$salesrep}}
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                  </div>
                  
                </section>
                <!-- end widget grid -->
            
            </div>    
            
            <!--RIGHT SIDE WIDGETS-->
        <aside class="right">
            @render('layouts.chat')
        </aside>
        <!--END RIGHT SIDE WIDGETS-->

        </div>
        <!-- end main content -->
    </div>
</div><!--end fluid-container-->
<div class="push"></div>
<script src="{{URL::to_asset('js/editable.js')}}"></script>
<script>
$(document).ready(function(){

        $('.viewArchive').click(function(){
          $.getJSON('{{URL::to("hiring/archived")}}',function(data){
            var html="";
            $.each(data.archived,function(i,val){
              var dat = val.attributes;var thetype='';var thelabel='';
              if(dat.user_type=='agent'){thetype='Marketing';thelabel='info special';} else if(dat.user_type=='salesrep'){thetype='Sales'; thelabel='success special blackText';} else {thetype='Door Reggie';thelabel='inverse';};
              html+="<tr><td></td><td>"+dat.applied_on+"</td><td>"+dat.firstname+"</td><td>"+dat.lastname+"</td><td>"+dat.sinnum+"</td><td>"+dat.cell_no+"</td>";
              html+="<td><span class='label label-"+thelabel+"'>"+thetype+"</span></td><td><button class='btn btn-mini btn-success blackText setupInterview' data-id='"+dat.id+"'>SCHEDULE NEW INTERVIEW</button></td></tr>";
            });
            $('.archives').show();
            $('#archiveTable').html(html);
            html = "";
            $.each(data.hired,function(i,val){
              var dat = val.attributes;var thetype='';var thelabel='';
              if(dat.user_type=='agent'){thetype='Marketing';thelabel='info special';} else if(dat.user_type=='salesrep'){thetype='Sales'; thelabel='success special blackText';} else {thetype='Door Reggie';thelabel='inverse';};
              html+="<tr><td></td><td>"+dat.applied_on+"</td><td>"+dat.firstname+"</td><td>"+dat.lastname+"</td><td>"+dat.sinnum+"</td><td>"+dat.cell_no+"</td>";
              html+="<td><span class='label label-"+thelabel+"'>"+thetype+"</span></td></tr>";
            });
            $('.archives').show();
            $('#hiredTable').html(html);
          });
        });


        $('.closeArchive').click(function(){
          $('.archives').hide();
        });

        $(document).on('click','.hireApplicant',function(){
       var id = $(this).attr('data-id');
       var t = confirm("This will create a USER account for this applicant in the Employee Table \n \n After clicking OK, go to USERS/EMPLOYEES -> Employee Management to give this applicant a login");
       if(t){ 
          $.getJSON("{{URL::to('hiring/createuser')}}",{theid:id},function(data){
            $('.emp-'+id).hide();
            console.log(data);
             toastr.success(data+"'s  USER account created!","NEW USER CREATED");
          });
       }
        });


          $('#calendar2').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            events:{
                url:'../hiring/getschedule',
              },
              @if(Auth::user()->user_type=='manager')
            eventClick: function(calEvent, jsEvent, view){
                $(this).css('border-color', 'red').css('border-width','2px');
               var t = confirm("ARE YOU SURE YOU WANT TO DELETE CANCEL THIS INTERVIEW?");
                if(t){
                    $.getJSON('../hiring/cancelinterview/'+calEvent.id, function(data){
                });
                 $(this).remove();
                 toastr.success('This interview has been deleted','INTERVIEW CANCELLED');
                 location.reload();
                } else {
                $(this).css('border-color', 'black').css('border-width','1px');
                return false;
                } 
            }
            @endif
        });
  $(".booktimepicker2").timePicker({
  startTime: "10:00", 
  endTime: new Date(0, 0, 0, 23, 30, 0), 
  show24Hours: false,
  step: 15});


	$('#agentmenu').addClass('expanded');
	$('#agentTab').trigger('click');

	$('.filter').click(function(data){
		var type = $(this).data('type');
    if(type=="all"){
    $('.interview').fadeIn(200);
    } else {
    $('.interview').hide();
    $('.'+type).fadeIn(200);
  }
		
		
	});

$('.newApplicant').click(function(){
  
  $('#cell_no').val('');
  $('#firstname').val('');
  $('#lastname').val('');
  $('#phone_no').val('');
  $('select#status').val('');
  $('select#position').val('')
  $('#address').val('');
  $('#birthdate').val('');
  $('#applydate').val('');
  $('#notes').val('');
  $('#id').val('');

$('#newapplicant_modal').modal({backdrop: 'static'});
});

$('.oldPassword').click(function(){
	$('.user-id').val($(this).data('id'));
$('#resetpassword_modal').modal({backdrop: 'static'});
});

$('.edit').editable('{{URL::to("users/edit")}}',{
 indicator : 'Saving...',
         tooltip   : 'Click to edit...',
         width:'100',
         height:'20',
         submit  : 'OK',
});



$(document).on('click','.deleteApplicant',function(){
    var id=$(this).attr('data-id');
    if(confirm("Are you sure you want to delete this Applicant?")){
        var url = "users/fulldelete/"+id;
            $.getJSON(url, function(data) {
             $('.emp-'+id).hide();
             toastr.success('Applicant Removed Succesfully','REMOVED');
            });
    }
});

$(document).on('click','.archiveApplicant',function(){
    var id=$(this).attr('data-id');
    if(confirm("Are you sure you want to archive this Applicant?")){
        var url = "hiring/fileaway/"+id;
            $.getJSON(url, function(data) {
             $('.emp-'+id).hide();
             toastr.success('Applicant Archived Succesfully','FILED AWAY APPLICANT');
            });
    }
});

$(document).on('click','.setupInterview',function(){
	 $('.user-id').val($(this).attr('data-id'));
   $('#interview_modal').modal({backdrop: 'static'});
});



$('.checkbox-click').click(function(){
  var id = $(this).attr('id');
  var msg = $(this).data('msg');
  if($(this).is(':checked')){

 
    var val = 1;
    if((msg==="DNC-Button")||(msg==="Call Details")||(msg==="Call Info")){
      msg = msg + " hidden from user";
    } else {
      msg = msg + " enabled for selected user";
    }
    
  } else {
    var val = 0;
    if((msg==="DNC-Button")||(msg==="Call Details")||(msg==="Call Info")){
      msg = msg + " shown for user";
    } else {
      msg = msg + " disabled for selected user";
    }
    
  }
  $.get('{{URL::to("users/edit")}}', {id:id,value:val},function(data){
    toastr.success(msg);
  });
});


});
</script>

@endsection