@layout('layouts/main')
@section('content')
      <style>
      .leadrow{cursor:pointer;}
      .edit {cursor:pointer;}
      </style>
<div class="modal hide fade" id="recruit_modal">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h3>Recruits Under <span class='recruiterName'></span></h3>
  </div>
  <div class="modal-body">
    <div id="recruit-body">
    

    </div>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn closeRecruits" data-dismiss="modal">Close</a>
  </div>
</div>      


<div class="modal hide fade" id="createUser_modal">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h3>Create New User</h3>
	</div>
	<div class="modal-body">
		<form method="POST" action="{{ URL::to('users/createfromemployee') }}" id="create_user_form" enctype="multipart/form-data">
			 <input type="hidden" name="user-id"  class='user-id' id="user-id" /><br>
		<label for="photo">Username</label>
	      <input type="text" name="user-name" id="user-name" /><br>
	      <label for="photo">Password</label>
	      <input type="text" name="user-pwd" id="user-pwd" /><br>
	    </form>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal">Cancel</a>
    	<button type="button" onclick="$('#create_user_form').submit();" class="btn btn-primary">Create User</a>
	</div>
</div>

<div class="modal hide fade" id="resetpassword_modal">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h3>New Password</h3>
	</div>
	<div class="modal-body">
		<form method="POST" action="{{ URL::to('users/newlogin') }}" id="newpass_form" enctype="multipart/form-data">
		<input type="hidden" name="user-id" class='user-id' id="user-id" /><br>
	      <label for="photo">Set New Password</label>
	      <input type="password" name="newpass" id="newpass" /><br>
	    </form>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal">Cancel</a>
    	<button type="button" onclick="$('#newpass_form').submit();" class="btn btn-primary">Update Password</a>
	</div>
</div>
<div class="modal hide fade" id="quit_modal">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h3>Terminate User</h3>
	</div>
	<div class="modal-body">
		<form method="POST" action="{{ URL::to('users/quit') }}" id="quit_form" enctype="multipart/form-data">
			 <input type="hidden" name="user-id" class='user-id' id="user-id" /><br>
		<label for="photo">Pick Reason for Termination </label>
	      <select name="status" id="status" />
	      <option value="quit">Quit</option>
	        <option value="fired">Fired</option>
	          <option value="layedoff">Layed Off</option>
	    </select>
	</select>
	    </form>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal">Cancel</a>
    	<button type="button" onclick="$('#quit_form').submit();" class="btn btn-primary">Terminate</a>
	</div>
</div>


<div class="modal hide fade" id="newapplicant_modal" style="margin-left:-600px;margin-top:-100px;width:800px;z-index:50000">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h3>New Employee</h3>
  </div>
  <div class="modal-body">
    <form method="POST" action="{{ URL::to('employee/newapplicant')}}" id="new_applicant_form" enctype="multipart/form-data">
      <input type="hidden" name="type" id="type" value="employee" />
      <div class="span4">
         Applied For : <br/>
            <select name="position" id="position">
            <option value="agent" >Marketing</option> 
           <option value="salesrep" >Sales</option> 
            <option value="doorrep" >Door Reggier</option> 
            <option value="manager" >Manager</option> 
           
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










<div id="main" role="main" class="container-fluid">
    <div class="contained">
    	<!-- LEFT SIDE WIDGETS & MENU -->
    	<aside> 
        	@render('layouts.managernav')
       </aside>
        <!-- END WIDGETS -->
                
        <!-- MAIN CONTENT -->

        <div id="page-content" >
            <h1 id="page-header"><img src='{{URL::to("images/clozer-cup.png")}}' style='margin-right:-10px;'>&nbsp;Employee Manager 
              <div style='float:right;'>
              <button class=' btn btn-primary newApplicant'>NEW EMPLOYEE</button>
              &nbsp;<button class='btn btn-default filter' data-type='employee'>CURRENT EMPLOYEES</button>
              &nbsp;<button class='btn btn-default filter' data-type='previous'>PREVIOUSLY EMPLOYED</button>
              </div>
            </h1>
           
			<div class="fluid-container">
                
                <!-- widget grid -->
                <section id="widget-grid" class="">
               
                	
                		

				<?php
				$manager="";$agent="";$salesrep="";$doorrep="";$researcher="";
				foreach($employees as $val){
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
                                                    }elseif($val->user_type=="researcher"){
                                                    	$label2 = "inverse";$position="Manilla Researcher";
                                                    }elseif($val->user_type=="salesrep"){
                                                    	$label2 = "success";$position="Dealer Contractor";
                                                    }elseif($val->user_type=="doorrep"){
                                                    	$label2 = "inverse";$position="Door Reggier";
                                                    }elseif($val->user_type=="manager"){
                                                    	$label2 = "success special";$position="Manager";
                                                    } else {$label2 = "inverse";$position="None Chosen";};
          if($val->id!=58){
            $html.="<tr id='emp-".$val->id."' class='contact' data-id='".$val->id."' style='color:#000'>";
          $html.="<td><img src='".$val->avatar_link()."' class='tooltwo uploadAvatar avatar' title='Click to upload new avatar for this user' data-id='".$val->id."' style='width:30px' ></td><td><span class='edit' id='firstname|".$val->id."'>".$val->firstname."</span></td>";
          $html.="<td><span class='edit' id='lastname|".$val->id."'>".$val->lastname."</span></td>";
          if(empty($val->username)) {$html.="<td><span class='btn btn-success btn-mini createUser' data-id='".$val->id."' style='color:black;'  >CREATE</span></td>";} else {
          $html.="<td><span class='edit' id='username|".$val->id."'>".$val->username."</span></td>";}
          $html.="<td><center><span class='edit' id='sinnum|".$val->id."'>".$val->sinnum."</span></center></td>";
           $html.="<td><center><span class='edit' id='cell_no|".$val->id."'>".$val->cell_no."</span></center></td>";
                                              
                              if(($val->user_type=='salesrep')||($val->user_type=='manager')){
                                $html.="<td><center><span class='edit' id='level|".$val->id."'>".$val->level."</span></center></td>";
                              }
                              if($val->user_type=='salesrep'){
                                $html.="<td>";
                                if(!empty($val->recruitedby)){
                                 $html.="<span style='color:#6e6e6e;font-size:10px;'>Recruited By : ".$val->recruitedby->fullName()."</span><br/>"; 
                                }
                                if(!empty($val->recruits)){
                                 $html.="Hsa ".count($val->recruits)." Recruits";
                                  $html.="<br/><button class='btn btn-default btn-mini viewRecruits' data-name='".$val->fullName()."' data-id='".$val->id."'>SEE / EDIT RECRUITS</button></td>";
                                } else {
                                   $html.="<button class='btn btn-default btn-mini viewRecruits' data-name='".$val->fullName()."' data-id='".$val->id."'>ADD RECRUITS</button></td>";
                                }
                               
                              }


                              if($val->user_type=="manager" && Auth::user()->super_user==1 ){
                                if($val->view_commission==1){$check='checked="checked"';} else {$check="";};
                                 $html.="<td><center><input type='checkbox' data-msg='View Commission' name='' ".$check." class='checkbox-click tooltwo' title='Click to enable ability to view commission data for this user.'  id='view_commission|".$val->id."' ></center></td>";
                                 if($val->view_invoices==1){$check='checked="checked"';} else {$check="";};
                                 $html.="<td><center><input type='checkbox' data-msg='View Invoices' name='' ".$check." class='checkbox-click tooltwo' title='Click to enable ability to view invoices for this user.'  id='view_invoices|".$val->id."' ></center></td>";
                                 if($val->view_settings==1){$check='checked="checked"';} else {$check="";};
                                 $html.="<td><center><input type='checkbox' data-msg='View System Settings' name='' ".$check." class='checkbox-click tooltwo' title='Click to enable ability to alter system settings'  id='view_settings|".$val->id."' ></center></td>";
                              }


                              if($val->user_type=="agent"){
                                $html.="<td><center><span class='edit' id='payrate|".$val->id."'>".$val->payrate."</span></center></td>";
                                 if($val->assign_leads==1){$check='checked="checked"';} else {$check="";};
                                 $html.="<td><center><input type='checkbox' data-msg='Manager Functions' name='' ".$check." class='checkbox-click tooltwo' title='Click to enable some manager functions for this user. (Leads Assign, Appointment board etc)'  id='assign_leads|".$val->id."' ></center></td>";
                                if($val->three_day==1){$check='checked="checked"';} else {$check="";};
                                $html.="<td><center><input type='checkbox' data-msg='Three Day Rule' name='' ".$check." class='checkbox-click tooltwo' title='Click to disable/enable ability to book past three days'  id='three_day|".$val->id."' ></center></td>";

                                if($val->call_details==1){$check='checked="checked"';} else {$check="";};
                                $html.="<td><center><input type='checkbox' data-msg='Call Details' name='block-call-details' ".$check." class='checkbox-click tooltwo' title='Click to block call details for this user' id='call_details|".$val->id."' ></center></td>";
                                if($val->call_info==1){$check='checked="checked"';} else {$check="";};
                                $html.="<td><center><input type='checkbox' data-msg='Call Info' name='block-call-info' ".$check." class='checkbox-click' id='call_info|".$val->id."' ></center></td>";
                                if($val->dnc_button==1){$check='checked="checked"';} else {$check="";};
                                $html.="<td><center><input type='checkbox' name='dnc_button' ".$check." data-msg='DNC-Button' class='checkbox-click tooltwo' title='Click to hide the DNC button from user'  id='dnc_button|".$val->id."' ></center></td>";
                                if($val->block_recall_search==1){$check='checked="checked"';} else {$check="";};
                                $html.="<td><center><input type='checkbox' name='block_recall_search' ".$check." data-msg='Recall Search' class='checkbox-click tooltwo' title='Click to disable Recall / Pending Searches'  id='block_recall_search|".$val->id."' ></center></td>";
                                
                                if(Setting::find(1)->browser_calls==1){
                                  if($val->auto_dial==1){$check='checked="checked"';} else {$check="";};
                                $html.="<td><center><input type='checkbox' name='auto-dialer' ".$check." data-msg='Auto Dialer' class='checkbox-click' id='auto_dial|".$val->id."' ></center></td>";
                                }
                                
                              }
                              $html.="<td><center><button class='btn btn-danger btn-mini delEmployeeUser' data-id='".$val->id."' style='margin-top:5px;'>TERMINATE</button>&nbsp;&nbsp;";
                              if(($val->username=='')&&($val->password=='')){
                                $html.="<button class='btn btn-success btn-mini createUser' data-id='".$val->id."' style='color:#fff;margin-top:5px;'>CREATE ACCOUNT</button>";} else{
                                  $html.="<button class='btn btn-default btn-mini oldPassword' data-id='".$val->id."' style='color:#000;margin-top:5px;'>SET PASSWORD</button>";}
                              $html.="</center></td></tr>";

          if($val->user_type=="manager"){
            $manager.=$html;
          } else if($val->user_type=="agent"){
            $agent.=$html;
          }else if($val->user_type=="salesrep"){
            $salesrep.=$html;
          }else if($val->user_type=="doorrep"){
            $doorrep.=$html;
          }else if($val->user_type=="researcher"){
            $researcher.=$html;
          }
          }                                       
					
				}

        
        ;?>                                                  

				<div id="employee" class="span12 jarviswidget userTable black" data-widget-editbutton="false" data-widget-deletebutton="false"
                                    data-widget-fullscreenbutton="false" >
                                        <header>
                                            <h2>CURRENT EMPLOYEES</h2>                           
                                        </header>
                                        <!-- widget div-->
                                        <div>
                                            <div class="inner-spacer widget-content-padding"> 
                                            <!-- content -->    
                                                <ul id="myTab" class="nav nav-tabs default-tabs">
                                                    <li class="bookertabs " >
                                                        <a class="aTab manager firstTab" data-type='manager' href="#managerstab" data-toggle="tab"><i class="cus-user-business"></i>&nbsp;Managers</a>
                                                    </li>

                                                    <li class="bookertabs" >
                                                        <a class='aTab agents' data-type='agents' href="#agents" data-toggle="tab"><i class="cus-user-female"></i>&nbsp;Agents</a>
                                                    </li>

                                                    <li class="bookertabs" >
                                                        <a class='aTab salesrep' data-type='salesrep' href="#salesrep" data-toggle="tab"><i class="cus-briefcase"></i>&nbsp;Sales Rep</a>
                                                    </li>

                                                    <li class="bookertabs" >
                                                        <a class='aTab doorrep' data-type='doorrep' href="#doorrep" data-toggle="tab"><i class="cus-door-in"></i>&nbsp;Door Rep</a>
                                                    </li>
                                                     <li class="bookertabs" >
                                                        <a class='aTab researcher' data-type='researcher' href="#researcher" data-toggle="tab"><i class="cus-telephone"></i>&nbsp;Researcher</a>
                                                    </li>
                                                </ul>
                                                
                                                <div id="myTabContent" class="tab-content">
                                                    <div class="tab-pane fade " id="managerstab">
                                                        <table class="table table-striped table-bordered responsive" >
                                                            <thead>
                                                    <tr>
                                                        <th>Avatar</th>	
                        	                              <th>First Name</th>
                        	                              <th>Last Name</th>
                                                        <th>Username</th>
                        	                              <th>SIN# / Dealer Code</th>
                        	                              <th>Cell / Phone</th>
                        	                              <th>Pure Op Level</th>
                                                        @if(Auth::user()->super_user==1)
                                                        <th>View Commission</th>
                                                        <th>View Invoices</th>
                                                        <th>System Settings</th>
                                                        @endif
                        	                              <th>Actions</th>
                        	                        	</tr>
                                                            </thead>
                                                            <tbody>
                                                                {{$manager}}
                                                            </tbody>
                                                        </table>
                                                    </div>



                                                    <div class="tab-pane fade " id="agents">
                                                        <table class="table table-striped table-bordered responsive" >
                                                            <thead>
                                                                <tr>
                                                        <th>Avatar</th> 	
                        	                              <th>First Name</th>
                        	                              <th>Last Name</th>
                                                        <th>Username</th>
                        	                              <th>Sin #</th>
                        	                              
                        	                              <th>Cell / Phone</th>
                        	                              
                                                        <th>Payrate</th>
                                                        <th>Manager Functions</th>
                                                        <th>3 Day Rule</th>
                        	                              <th>Hide Call Details</th>
                        	                              <th>Hide Lead Info</th>
                                                        <th>Hide DNC Button</th>
                                                        <th>Block Recall Search</th>
                        	                              @if(Setting::find(1)->browser_calls==1)
                        	                              <th>Auto Dialer</th>
                        	                              @endif
                        	                              
                        	                              <th>Actions</th>
                        	                        	</tr>
                                                            </thead>
                                                            <tbody>
                                                      	{{$agent}}
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <div class="tab-pane fade " id="doorrep">
                                                        <table class="table table-striped table-bordered responsive" >
                                                            <thead>
                                                     <tr>
                                                        <th>Avatar</th> 	
                        	                              <th>First Name</th>
                        	                              <th>Last Name</th>
                                                        <th>Username</th>
                        	                              <th>SIN#</th>
                        	                              <th>Cell / Phone</th>
                        	                              <th>Actions</th>
                        	                        	</tr>
                                                            </thead>
                                                            <tbody>
                                                               {{$doorrep}}
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <div class="tab-pane fade  " id="salesrep">
                                                        <table class="table table-striped table-bordered responsive" >
                                                            <thead>
                                                    <tr>
                                                        <th>Avatar</th> 	
                        	                              <th>First Name</th>
                        	                              <th>Last Name</th>
                                                        <th>Username</th>
                        	                              <th>SIN# / Dealer Code</th>
                        	                              <th>Cell / Phone</th>
                        	                              <th>Pure Op Level</th>
                                                        <th>Recruited By</th>
                        	                              <th>Actions</th>
                        	                       		</tr>
                                                            </thead>
                                                            <tbody>
                                                              {{$salesrep}}
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                     <div class="tab-pane fade  " id="researcher">
                                                        <table class="table table-striped table-bordered responsive" >
                                                            <thead>
                                                                <tr>	
                                                        <th>Avatar</th> 
                        	                              <th>First Name</th>
                        	                              <th>Last Name</th>
                                                        <th>Username</th>
                        	                              <th>SIN#</th>
                        	                              <th>Cell / Phone</th>
                        	                              <th>Actions</th>
                        	                       		</tr>
                                                            </thead>
                                                            <tbody>
                                                              {{$researcher}}
                                                            </tbody>
                                                        </table>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    </div>

                		
                         <div id="previous" style='display:none;' class="span12 jarviswidget userTable black" data-widget-editbutton="false" data-widget-deletebutton="false"
                                    data-widget-fullscreenbutton="false" style='display:none;' >
                        <header>
                              <h2>PREVIOUS EMPLOYEES</h2>                           
                        </header>
                        <!-- wrap div -->
                        	<div>
                        	      <div class="inner-spacer"> 
                        	            <table class="table table-bordered responsive">
                        	                  <thead>
                        	                        <tr>	<th>Applied</th>
                        	                              <th>First Name</th>
                        	                              <th>Last Name</th>
                        	                              <th>SIN#</th>
                        	                              <th>Sex</th>
                        	                              <th>Birthday</th>
                        	                              <th>Address</th>
                        	                              <th>Cell Phone</th>
                        	                              <th>Status</th>
                        	                              <th>Position</th>
                        	                              <th>Actions</th>
                        	                        </tr>
                        	                  </thead>
                        	                  <tbody>

                                                @foreach($prevemp as $val)
                                                <?php if($val->type=="applicant"){
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
                                                    }elseif($val->user_type=="researcher"){
                                                    	$label2 = "inverse";$position="Manilla Researcher";
                                                    }elseif($val->user_type=="salesrep"){
                                                    	$label2 = "success";$position="Dealer Contractor";
                                                    }elseif($val->user_type=="doorrep"){
                                                    	$label2 = "warning";$position="Door Reggier";
                                                    }elseif($val->user_type=="manager"){
                                                    	$label2 = "info";$position="Managerial";
                                                    } else {$label2 = "inverse";$position="None Chosen";};
                                                    ?>
                                                      <tr id="emp-{{$val->id}}" class="contact" data-id="{{$val->id}}" style="color:#000">	<td>{{$val->applied_on}}</td>
                                                            <td><center>
                                                            	<span class='edit' id='firstname|{{$val->id}}'>{{$val->firstname}}</span>
                                                            	</center></td>
                                                            <td><center>
                                                            	<span class='edit' id='lastname|{{$val->id}}'>{{$val->lastname}}</span>
                                                            	</center>
                                                            </td>
                                                             <td><center><span class='edit' id='sinnum|{{$val->id}}'>{{$val->sinnum}}</span></center></td>
                                                            <td><center>
                                                            	
                                                            		{{$val->sex}}
                                                            	
                                                            	</center>
                                                            </td>
                                                              <td><center>
                                                            	
                                                            		{{$val->birthdate}}
                                                            	
                                                            	</center>
                                                            </td>

                                                            <td><center>
                                                            	<span class='edit' id='address|{{$val->id}}'>{{$val->address}}</span>
                                                            	</center>
                                                            </td>
                                                          
                                                            <td><center>
                                                            	<span class='edit' id='cell_no|{{$val->id}}'>{{$val->cell_no}}</span>
                                                            	</center>
                                                            </td>
                                                           
                                                          
                                                            <td><center><span class="label label-{{$label}}">{{$type}}</span></center></td>
                                                            <td><center><span class="label label-{{$label2}}">{{$position}}</span></center></td>
                                                            <td><center>
                                                              @if($val->username!='')
                                                              <a href='{{URL::to('users/activate/')}}{{$val->id}}'><button class='btn btn-mini btn-default' style='margin-top:10px;'>RE-ACTIVATE</button></a>
                                                              @else
                                                              @if($val->user_id==0)
                                                              <button class='btn btn-warning btn-mini createUser' data-id='{{$val->id}}' style='color:#000;margin-top:5px;'>NEW LOGIN</button>
                                                              @else 
                                                              <a href="{{URL::to('users/profile/')}}{{$val->user_id}}"><button class='btn btn-warning btn-mini createUser' data-id='{{$val->id}}' style='color:#000;'>VIEW PROFILE</button></a>
                                                              @endif
                                                              @endif
                                                            	</center>
                                                            </td>
                                                       </tr>
                                                @endforeach
                                          	</tbody>
                                    	</table>
                              	</div>
                                            <!-- end content-->
                        	</div>
                                        <!-- end wrap div -->
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
	$('#agentmenu').addClass('expanded');

  $('.aTab').click(function(){
    if(localStorage){
      localStorage.setItem("tabClicked",$(this).data('type'));
    }
  });

  if(localStorage){
    if(localStorage.getItem("tabClicked")!=undefined){
      $('.aTab.'+localStorage.getItem("tabClicked")).trigger('click');
    } else {
      $('.firstTab').trigger('click');
    }
  } else {
    $('.firstTab').trigger('click');
  }



	$('.filter').click(function(data){
		var type = $(this).data('type');
		$('.userTable').hide();
		$('#'+type).fadeIn(200);
	});

  $('.viewRecruits').click(function(){
    var id = $(this).data('id');
    var name = $(this).data('name');
    $('.recruiterName').html(name);
    $('#recruit-body').load("{{URL::to('users/loadrecruits')}}/"+id);
    $('#recruit_modal').modal({backdrop: 'static'});
  });

  $('.closeRecruits').click(function(){
    $('.ajax-heading').html("Refreshing recruits...")
    $('.ajaxWait').show();
    location.reload();
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

$('.createUser').click(function(){
	$('.user-id').val($(this).data('id'));
$('#createUser_modal').modal({backdrop: 'static'});
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



$('.delEmployeeUser').click(function(){
	$('.user-id').val($(this).data('id'));
   $('#quit_modal').modal({backdrop: 'static'});
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



        $("#booktimepicker").timePicker({
    startTime: "10:00", // Using string. Can take string or Date object.
  endTime: new Date(0, 0, 0, 23, 30, 0), // Using Date object here.
  show24Hours: false,
  step: 15});


$('.process').click(function(){
var sts = $(this).data('status');
$('input#status').val(sts);
$('.bookdemo').hide();
$('#recallbox').hide();
});

$('.APPBUT').click(function(){
$('.bookdemo').toggle(300);
});


$('.RCBUT').click(function(){
$('#recallbox').toggle(300);
});



    $('.leadrow').click(function(){
        var id = $(this).data('id');
        var url = "{{URL::to('appointment')}}?date="+id;
        window.location.replace(url);
    });
});
</script>
@if(Session::has('changed'))
<script>
$(document).ready(function(){
	toastr.success("Password successfully changed!", "PASSWORD CHANGED!");	
});
</script>
@endif
@endsection