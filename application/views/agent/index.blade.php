@layout('layouts/main')
@section('content')
<script>
function showAddForm(){
$('#agentlist').hide();
$('#addnewagent').fadeIn(500);
window.location.hash = 'addagent';
}

function showAgents(){
$('#agentlist').fadeIn();
$('#addnewagent').hide();
window.location.hash = 'viewagents';
}
</script>
<style>
#addnewagent {display:none;}
</style>
      
<div id="main" role="main" class="container-fluid">
    <div class="contained">
        <aside> 
            @render('layouts.managernav')
        </aside>
               
        <!-- main content -->
        <div id="page-content">
            <h1 id="page-header">Agent Management</h1>   
                <div class="fluid-container">
                    <!-- start icons -->
                        <div id="start">
                            <ul>
                                <li>
                                    <a href="javascript:void(0)" onclick="showAddForm();" title="">
                                        <img src="{{URL::to_asset('img/start-icons/add-user.png')}}" alt="">
                                        <span>ADD NEW USER</span>
                                    </a>
                                </li>
                                <li>
                                    
                                    <a href="javascript:void(0)" onclick="showAgents();" title="">
                                        <img src="{{URL::to_asset('img/start-icons/add-user.png')}}" alt="">
                                        <span>VIEW AGENTS</span>
                                    </a>
                                </li>
                            </ul>
                        </div>                      
                        <!-- end start icons -->

                        @if(($errors->has('username'))||($errors->has('password')))
                        <div class="alert adjusted alert-warning">
                            <button class="close" data-dismiss="alert">×</button>
                            <i class="cus-exclamation-octagon-fram"></i>
                            <strong> WARNING : </strong> 
                        The username you are trying has already been taken, or you did not enter a password
                        </div>
                        @endif

                        <!-- widget grid -->
                        <section id="widget-grid" class="">
                            <div class="row-fluid" id="agentlist">
                                <article class="span12">
                                    <!-- new widget -->
                                    <div class="jarviswidget black" data-widget-editbutton="false" data-widget-deletebutton="false"
                                    data-widget-fullscreenbutton="false"  >
                                        <header>
                                            <h2>LIST OF USERS</h2>                           
                                        </header>
                                        <!-- widget div-->
                                        <div>
                                            <div class="inner-spacer widget-content-padding"> 
                                            <!-- content -->    
                                                <ul id="myTab" class="nav nav-tabs default-tabs">
                                                    <li class="bookertabs " >
                                                        <a href="#managerstab" data-toggle="tab"><i class="cus-user-business"></i>&nbsp;Managers</a>
                                                    </li>

                                                    <li class="bookertabs" >
                                                        <a href="#agents" data-toggle="tab"><i class="cus-user-female"></i>&nbsp;Agents</a>
                                                    </li>

                                                    <li class="bookertabs" >
                                                        <a href="#salesrep" data-toggle="tab"><i class="cus-briefcase"></i>&nbsp;Sales Rep</a>
                                                    </li>

                                                    <li class="bookertabs" >
                                                        <a href="#doorrep" data-toggle="tab"><i class="cus-ticket"></i>&nbsp;Door Rep</a>
                                                    </li>
                                                     <li class="bookertabs" >
                                                        <a href="#unactive" data-toggle="tab"><i class="cus-stop"></i>&nbsp;Unactive Accounts</a>
                                                    </li>
                                                </ul>
                                                
                                                <div id="myTabContent" class="tab-content">
                                                    <div class="tab-pane fade " id="managerstab">
                                                        <table class="table table-striped table-bordered responsive" >
                                                            <thead>
                                                                <tr>
                                                                    <th>First Name</th>
                                                                    <th>Last Name</th>
                                                                    <th>Username</th>
																	<th>Phone No.</th>
                                                                    <th>E-mail</th>
                                                                    <th>Delete</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($manager as $val)
                                                                <tr id="agentrow-{{$val->id}}">
                                                                    <td class="edit" id="firstname|{{$val->id}}">{{$val->firstname}}</td>
                                                                    <td class="edit" id="lastname|{{$val->id}}">{{$val->lastname}}</td>
                                                                    <td class="edit" id="username|{{$val->id}}">{{$val->username}}</td>
																	<td class="edit" id="cell_no|{{$val->id}}" style="text-align:center">{{$val->cell_no}}</td>
                                                                    <td class="edit" id="email|{{$val->id}}">{{$val->email}}</td>
                                                                    <td><center><button class="btn btn-danger btn-mini deleteagent " data-id="{{$val->id}}"><i class="icon-trash"></i></button></center></td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <div class="tab-pane fade " id="agents">
                                                        <table class="table table-striped table-bordered responsive" >
                                                            <thead>
                                                                <tr>
                                                                    <th>First Name</th>
                                                                    <th>Last Name</th>
                                                                    <th>Username</th>
																	<th>Phone No.</th>
                                                                    <th>E-Mail</th>
                                                                    <th>Start</th>
                                                                    <th>Terminate</th>
                                                                    <th>Delete</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($agent as $val)
                                                                <tr id="agentrow-{{$val->id}}">
                                                                    <td class="edit" id="firstname|{{$val->id}}">{{$val->firstname}}</td>
                                                                    <td class="edit" id="lastname|{{$val->id}}">{{$val->lastname}}</td>
                                                                    <td class="edit" id="username|{{$val->id}}">{{$val->username}}</td>
                                                                    <td class="edit" id="cell_no|{{$val->id}}" style="text-align:center">{{$val->cell_no}}</td>
                                                                    <td class="edit" id="email|{{$val->id}}">{{$val->email}}</td>
                                                                    <td class="edit" id="startdate|{{$val->id}}">{{$val->startdate}}</td>
                                                                    <td class="edit" id="enddate|{{$val->id}}">{{$val->enddate}}</td>
                                                                    <td>
                                                                        <center>
                                                                            <a href="{{URL::to('users/profile/')}}{{$val->id}}">
                                                                                <button class="btn btn-primary btn-mini ">
                                                                                    <i class="icon-user"></i> Profile
                                                                                </button>
                                                                            </a>
                                                                            <button class="btn btn-danger btn-mini deleteagent " data-id="{{$val->id}}"><i class="icon-trash"></i>
                                                                            </button>
                                                                        </center>
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <div class="tab-pane fade " id="doorrep">
                                                        <table class="table table-striped table-bordered responsive" >
                                                            <thead>
                                                                <tr>
                                                                    <th>First Name</th>
                                                                    <th>Last Name</th>
                                                                    <th>Username</th>
																	<th>Phone No.</th>
                                                                    <th>E-Mail</th>
                                                                    <th>Delete</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($doorrep as $val)
                                                                 <tr id="agentrow-{{$val->id}}">
                                                                    <td class="edit" id="firstname|{{$val->id}}">{{$val->firstname}}</td>
                                                                    <td class="edit" id="lastname|{{$val->id}}">{{$val->lastname}}</td>
                                                                    <td class="edit" id="username|{{$val->id}}">{{$val->username}}</td>
                                                                    <td class="edit" id="cell_no|{{$val->id}}" style="text-align:center">{{$val->cell_no}}</td>
                                                                    <td class="edit" id="email|{{$val->id}}">{{$val->email}}</td>
                                                                    <td><center><button class="btn btn-danger btn-mini deleteagent " data-id="{{$val->id}}"><i class="icon-trash"></i></button></center></td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <div class="tab-pane fade  " id="salesrep">
                                                        <table class="table table-striped table-bordered responsive" >
                                                            <thead>
                                                                <tr>
                                                                    <th>First Name</th>
                                                                    <th>Last Name</th>
                                                                    <th>Username</th>
																	<th>Phone No.</th>
                                                                    <th>E-Mail</th>
                                                                    <th>Pure Opportunity Level</th>
                                                                    <th>Delete</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($salesrep as $val)
                                                                 <tr id="agentrow-{{$val->id}}">
                                                                    <td class="edit" id="firstname|{{$val->id}}">{{$val->firstname}}</td>
                                                                    <td class="edit" id="lastname|{{$val->id}}">{{$val->lastname}}</td>
                                                                    <td class="edit" id="username|{{$val->id}}">{{$val->username}}</td>
                                                                    <td class="edit" id="cell_no|{{$val->id}}" style="text-align:center">{{$val->cell_no}}</td>
                                                                    <td class="edit" id="email|{{$val->id}}">{{$val->email}}</td>
                                                                    <td class="edit" id="level|{{$val->id}}">{{$val->level}}</td>
                                                                    <td><center><button class="btn btn-danger btn-mini deleteagent " data-id="{{$val->id}}"><i class="icon-trash"></i></button></center></td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <div class="tab-pane fade " id="unactive">
                                                        <table class="table table-striped table-bordered responsive" >
                                                            <thead>
                                                                <tr>
                                                                    <th>First Name</th>
                                                                    <th>Last Name</th>
                                                                    <th>Username</th>
                                                                    <th>Phone No.</th>
                                                                    <th>E-mail</th>
                                                                    <th>Delete</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($unactive as $val)
                                                                <tr id="agentrow-{{$val->id}}">
                                                                    <td>{{$val->firstname}}</td>
                                                                    <td>{{$val->lastname}}</td>
                                                                    <td>{{$val->username}}</td>
                                                                    <td>{{$val->cell_no}}</td>
                                                                    <td>{{$val->email}}</td>
                                                                    <td><center><a href="{{URL::to('users/activate/')}}{{$val->id}}"><button class="btn btn-success activate"><i class="icon-succes"></i>ACTIVATE</button></a></center></td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </div>

                            <div class="row-fluid">
                                <article class="span8" id="addnewagent" >
                                    <h2>Add a New Agent</h2>
                                    <hr style="border:1px dashed #ddd">
                                    <form class="form-horizontal themed" id="payform" method="post" action="{{URL::to('users/create')}}">

                                        <fieldset >
                                            <h4>Role of User</h4>
                                            <div class="control-group">
                                                <select id="typeofuser" name="typeofuser" class="span8">
                                                     <option value='manager'>MANAGER</option>
                                                     <option value='agent'>AGENT</option>
                                                     <option value='researcher'>RESEARCHER</option>
                                                     <option value='salesrep'>SALES REP</option>
                                                     <option value='doorrep'>DOOR REP</option>
                                                </select>
                                            </div>
                                        </fieldset>
                                        <br>
                                        <fieldset style="margin-top:35px;">
                                        <h4>User Information</h4>
                                            <div class="control-group">
                                                <label class="control-label"><b>First Name</b></label>
                                                <div class="controls">
                                                    <input type="text" class="span12"  id="firstname" name="firstname" />
                                                </div>
                                            </div>
 
                                            <div class="control-group">
                                                <label class="control-label" >Last Name</label>
                                                <div class="controls">
                                                    <input type="text" class="span12"  id="lastname" name="lastname" />
                                                </div>
                                            </div>
											
											<div class="control-group">
                                                <label class="control-label" >Email <i>(optional)</i></label>
                                                <div class="controls">
                                                    <input type="text" class="span12"  id="email" name="email" />
                                                </div>
                                            </div>
											
											<div class="control-group">
                                                <label class="control-label">Cell / Phone <i>(optional)</i></label>
                                                <div class="controls">
                                                    <input type="text" class="span12"  id="cellno" name="cellno" />
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label" >Username</label>
                                                <div class="controls">
                                                    <input type="text" class="span12"  id="username" name="username" />
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label">Password</label>
                                                <div class="controls">
                                                    <input type="text" class="span12"  id="password" name="password" />
                                                </div>
                                            </div>
                                        </fieldset>  

                                        
                                        
                                        <hr style="border:1px dashed #ddd">

                                        <button title="" class="btn btn-primary btn-large" style="margin-left:30px;margin-top:10px;margin-bottom:250px">ADD NEW AGENT</button>
                                    </form>
                                    <hr style="border:1px dashed #ddd">
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
        </aside>
    </div>
</div>
<script src="{{URL::to_asset('js/editable.js')}}"></script>
<script>
$(document).ready(function(){
$('#agentmenu').addClass('expanded');

$('.edit').editable('{{URL::to("users/edit")}}',{
 indicator : 'Saving...',
         tooltip   : 'Click to edit...',
         submit  : 'OK',
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
});
</script>
@endsection