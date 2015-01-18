
<script>
function addDashes(f) {
    var r = /(\D+)/g,
        npa = '',
        nxx = '',
        last4 = '';
    f.value = f.value.replace(r, '');
    npa = f.value.substr(0, 3);
    nxx = f.value.substr(3, 3);
    last4 = f.value.substr(6, 4);
    f.value = npa + '-' + nxx + '-' + last4;
}
</script>

<div class="my-profile" style="margin-bottom:30px;">
        <a class="my-profile-pic">
            <img class='tooltwo uploadAvatar medShadow' data-id='{{Auth::user()->id}}' title='Click here to upload new Avatar' src="{{Auth::user()->avatar_link()}}" width=80px alt="">
        </a>
        <span style="font-size:18px;">
            Welcome <strong>{{ucfirst(Auth::user()->firstname)}}</strong>
        </span>
        <br/>
        <span>
            <a href="javascript:void(0);" class="logout-js" data-rel="{{URL::to('users/logout')}}">LOGOUT</a>
        </span>

</div>
<div id="digiclock-left" style="color:#fff;" style="margin-top:-20px;"></div>


<div class="clearfix"></div>

<div class="divider"></div>
<div class="sidebar-nav-fixed">
                        <ul class="menu" id="accordion-menu-js">
                            <li class="current">
                                <a href="javascript:void(0)"><i class="icon-off"></i>Dashboard </a>
                                <ul>@if(Auth::user()->user_type=="agent")
                                     <li id="dashboardmenu" >
                                        <a href="{{URL::to('dashboard/agent')}}">Dashboard</a>
                                    </li>
                                    <li id="dashboardmenu" >
                                        <a href="{{URL::to('users/profile/')}}{{Auth::user()->id}}">Profile</a>
                                    </li>
                                    @else
                                    <li id="dashboardmenu" >
                                        <a href="{{URL::to('dashboard')}}">Dashboard</a>
                                    </li>
                                    @endif
                                    <!--<li>
                                        <a href="{{URL::to('dashboard/profile')}}">My Profile</a>
                                    </li>-->
                                    <li>
                                        <a href="javascript:void(0);" class="logout-js" data-rel="{{URL::to('users/logout')}}">Logout</a>
                                    </li>
                                </ul>
                            </li>
                            @if(Auth::user()->user_type=="manager")
                             <li class="" data-step="1" data-intro="This shows your numbers for the Week, including Put On Demos, Units Sold, DNS, and Closing Average" data-position="right">
                                <a href="{{URL::to('lead')}}"><i class="cus-telephone"></i>&nbsp;LEADS</a>
									<ul>
									    <li id="leadmenu">
                                            <a href="{{URL::to('lead')}}"  >Lead Manager</a>
                                        </li>
                                    </ul>
							</li>
                            @endif
                            @if(Auth::user()->user_type=="agent")
                            <li class="">
                                <a href="{{URL::to('dashboard')}}"><i class="cus-telephone"></i>&nbsp;LEADS<span class="badge">{{Auth::user()->leads()->where('status','=','ASSIGNED')->count()}}</span></a>
                               
                            </li>
                            @endif
							@if(Auth::user()->user_type=="doorrep")
                            <li class="">
                                <a href="{{URL::to('dashboard')}}"><i class="cus-telephone"></i>&nbsp;&nbsp;LEAD MANAGER</a>
							</li>
                             <li class="">
                                <a href="{{URL::to('dashboard/reports/door')}}" class="wrongnums"><i class="cus-blog"></i>&nbsp;&nbsp;REPORTS</a>
                                 <ul>
                                    <li id="reportsmenu">
                                        <a href="{{URL::to('dashboard/reports/door')}}">Custom Reports</a>
                                    </li> 
                                   
                                </ul>
                            </li>
                            <li class="">
                                <a href="{{URL::to('dashboard/invoices/door')}}" ><i class="cus-blog"></i>&nbsp;&nbsp;INVOICES</a>
                                 
                            </li>
                             <li class="">
                                <a href="{{URL::to('dashboard/reports/reggiehistory')}}"><i class="cus-world"></i>&nbsp;&nbsp;REGGIE HISTORY</a>
                            </li>
							@endif

                            @if(Auth::user()->user_type=="agent")
                            <li class="">
                                <a href="{{URL::to('agent/schedule')}}"><i class="cus-application-view-icons"></i>&nbsp;&nbsp;SCHEDULE<span class="badge">{{Auth::user()->shifts()}} Shifts</span></a>
                            </li>
                            @elseif(Auth::user()->user_type=="manager")
                               <li class="">
                                <a href="javascript::void(0)"><i class="cus-clock"></i>&nbsp;&nbsp;APPOINTMENTS</a>
                                <ul>
                                    <li id="appointmentsmenu">
                                        <a href="{{URL::to('appointment')}}"  >Todays Appointments</a>
                                    </li>
                                    @if(Setting::find(1)->needed==1)    
                                    <li >
                                        <a href="{{URL::to('appointment/needed')}}"  >Needed Times by City</a>
                                    </li>
                                    @endif
                                </ul>
                            </li>
                            @endif

                            @if(Auth::user()->user_type=="salesrep")
                            <li class="">
                                <a href="{{URL::to('sales/invoice')}}">
                                    <i class="cus-tag-blue"></i>&nbsp;&nbsp;SALES / INVOICES
                                </a>
                           </li>
                           @if(Auth::user()->crewtype()=="crewmanager")
                            <li class="">
                                <a href="{{URL::to('crew/manage')}}">
                                    <i class="cus-user"></i>&nbsp;&nbsp;MANAGE CREW 
                                </a>
                           </li>
                           @endif

                            @elseif(Auth::user()->user_type=="manager")
                             <li class="">
                                <a href="{{URL::to('reports/sales')}}">
                                    <i class="cus-tag-blue"></i>&nbsp;&nbsp;SALES
                                </a>
                               
                            </li>
                            @endif
                        

                             @if(Auth::user()->user_type=="manager")
                              <li class="">
                                <a href="javascript:void(0)"><i class="cus-chart-bar"></i>&nbsp;&nbsp;REPORTS</a>
                                <ul>    
                                    <li id="reports" >
                                        <a href="{{URL::to('reports/marketing')}}" >Marketing Report</a>
                                    </li>
                                    <li>
                                        <a href="{{URL::to('reports/door')}}" >Door Reggie Report</a>
                                    </li>
                                    <li>
                                        <a href="{{URL::to('reports/sales')}}" >Sales Report</a>
                                    </li>
                                    <li>
                                        <a href="{{URL::to('reports/invoice')}}" >Invoice Report</a>
                                    </li>
                                </ul>
                            </li>
                             <li class="">
                                <a href="{{URL::to('agent')}}"><i class="cus-user-business"></i>&nbsp;&nbsp;USERS / EMPLOYEES</a>
                                <ul>
                                    <li id="agentmenu">
                                        <a href="{{URL::to('hiring')}}" >Hiring / Interviews</a>
                                    </li>
                                    <li id="agentmenu">
                                        <a href="{{URL::to('employee')}}" >Employee Management</a>
                                    </li>
                                     <li>
                                        <a href="{{URL::to('agent/schedule')}}" >Marketing Schedule</a>
                                    </li>
                                    
                                </ul>
                            </li>
                              <li class="">
                                <a href=""><i class="cus-world"></i>&nbsp;&nbsp;CITIES / CREW</a>
                                <ul>
                                     <li id="citymenu">
                                        <a href="{{URL::to('cities')}}" >Cities</a>
                                    </li>
                                    <li id="citymenu">
                                        <a href="{{URL::to('crew/manage')}}" >Crews</a>
                                    </li>
                                    <li id="citymenu">
                                        <a href="{{URL::to('appointment/needed')}}" >Appointments Needed</a>
                                    </li>
                                </ul>
                            </li>
                             <li class="">
                                <a href="{{URL::to('inventory')}}"><i class="cus-delivery"></i>&nbsp;&nbsp;INVENTORY</a>
                           
                            </li>
                            <li class="">
                                <a href="{{URL::to('util/gift')}}"><i class="cus-ipod"></i>&nbsp;&nbsp;GIFTS</a>
                                <ul>
                                    
                                     <li id="giftmenu">
                                        <a href="{{URL::to('util/gifts')}}" >Manage Gifts </a>
                                    </li>
                                    <li id="giftmenu">
                                        <a href="{{URL::to('util/giftstock')}}" >Gift Tracker / Stock</a>
                                    </li>
                                    <li id="giftmenu">
                                        <a href="{{URL::to('util/giftcities')}}" >Apply Gifts to Leadtype</a>
                                    </li>
                                     <!--<li id="giftmenu">
                                        <a href="{{URL::to('reports/sales')}}" >Gift Report</a>
                                    </li>-->
                                </ul>

                            </li>
                           
                            <!--<li class="">
                                <a href="javascript::void();"><i class="cus-trophy"></i>&nbsp;&nbsp;GOALS</a>
                            </li>-->
                              <li class="">
                                    <a href=""><i class="cus-script"></i>&nbsp;&nbsp;SCRIPTS</a>
                                <ul>
                                    <li id="scriptmenu">
                                        <a href="{{URL::to('scripts/booker')}}" >Bookers Scripts</a>
                                    </li>
                                    <li id="scriptmenu">
                                        <a href="{{URL::to('scripts/objections')}}" >Objection Scripts</a>
                                    </li>
                                </ul>
                            </li>
                            
                             <li class="">
                                <a href="{{URL::to('items')}}"><i class="cus-package"></i>&nbsp;&nbsp;STOCK ITEMS</a>
                                <ul>
                                    
                                     <li id="itemmenu">
                                        <a href="{{URL::to('items')}}" >Item Manager </a>
                                    </li>
                                    <li id="itemmenu">
                                        <a href="{{URL::to('items/submitorder')}}" >Submit Order for Items</a>
                                    </li>
                                    <li id="itemmenu">
                                        <a href="{{URL::to('items/orders')}}" >View Orders</a>
                                    </li>
                                </ul>
                            </li>
                            @if(Auth::user()->super_user==1)
                            <li class="">
                                <a href="{{URL::to('expense')}}"><i class="cus-money"></i>&nbsp;&nbsp;OFFICE EXPENSES</a>
                                <ul>
                                     <li id="expensemenu">
                                        <a href="{{URL::to('expense')}}" > Expense Manager </a>
                                    </li>
                                    <!--
                                    <li id="expensemenu">
                                        <a href="{{URL::to('expense/reports')}}" > Expense Reports </a>
                                    </li>-->
                                </ul>
                            </li>
                            @endif
                            <li class="">
                                <a href="{{URL::to('util/filemanager')}}"><i class="cus-drawer"></i>&nbsp;&nbsp;FILE MANAGER</a>
                            </li>
                            
                            <li class="">
                                <a href="{{URL::to('agent')}}"><i class="cus-calculator"></i>&nbsp;&nbsp;UTILITIES</a>
                                <ul>
                                    <li id="utilmenu">
                                        <a href="{{URL::to('util/task')}}" >Task Manager</a>
                                    </li>
                                    <li id="utilmenu">
                                        <a href="{{URL::to('util/filemanager')}}" >File Manager</a>
                                    </li>
                                </ul>
                            </li>


                            @if(Auth::user()->view_settings==1)
                            <li class="">
                                <a href=""><i class="cus-exclamation"></i>&nbsp;&nbsp;SYSTEM / INVOICING</a>
                                 <ul>
                                    <li id="systemmenu">
                                        <a href="{{URL::to('chat/systemmessage')}}" >System Wide Messages</a>
                                    </li>
                                     <li id="systemmenu">
                                        <a href="{{URL::to('system/settings')}}">System Settings</a>
                                    </li>
                                    
                                    <li id="systemmenu">
                                        <a href="{{URL::to('system/invoice')}}" >Invoicing / Payments</a>
                                    </li>
                                </ul>
                            </li>
                            @endif

                           @endif
                           <!--<li class="">
                                <a href="{{URL::to('util/bug')}}"><i class="cus-bug"></i>&nbsp;&nbsp;BUGS / SUGGESTIONS</a>
                                <ul>
                                    <li id="bugmenu">
                                        <a href="{{URL::to('util/bug')}}/bug" >Report a bug</a>
                                    </li>
                                     <li id="bugmenu">
                                        <a href="{{URL::to('util/bug')}}/suggestion" >Make a Suggestion</a>
                                    </li>
                                    
                                    <li id="bugmenu">
                                        <a href="{{URL::to('util/updatelog')}}" >Review Log</a>
                                    </li>
                                     
                                </ul>


                            </li>-->
                        </ul>
                    </div>
                    <div class="divider"></div>
