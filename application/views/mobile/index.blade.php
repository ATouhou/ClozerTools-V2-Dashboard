@layout('mobile/layout')
@section('content')
                <div title='Home Screen' id="main" class="panel" selected="true" data-load="loadedPanel" data-unload="unloadedPanel" data-tab="navbar_home">
                    <h2 >Welcome {{ucfirst(Auth::user()->firstname)}}</h2>
                    
                    <ul class="list">
                        <li class='red'>
                            <a href="#demos" id='aflink' class='icon home big'>APPOINTMENTS </a>
                        </li>
                        <li>
                            <a href="#leadmanager" class='icon phone big' >LEAD Manager</a>
                        </li>
                        <li>
                            <a href="#sales" class='icon tag big' >Sales Manager</a>
                        </li>
                        
                       
                        <li>
                            <a href="#reports" class='icon graph big'>Reports</a>
                        </li>
                        
                    </ul>
                    
                    <div class="dashboardstats">
                    <br/><br/><br/>
                    @if(!empty($stats))
                    <h4 style="margin-left:10px;">APPOINTMENT SUMMARY</h4>
                    	<div class="largestats">
                    		<div class="bignum2 BOOK">{{$stats[0]->total}}</div><br/>
                    		APP
                    	</div>
                    	<div class="largestats">
                    		<div class="bignum2 PUTON">{{$stats[0]->dispatched}}</div><br/>
                    		DISP
                    	</div>
                    	<div class="largestats">
                    		<div class="bignum2 PUTON">{{$stats[0]->puton}}</div><br/>
                    		PUTON
                    	</div>
                    	<div class="largestats">
                    		<div class="bignum2 SOLD">{{$stats[0]->sold}}</div><br/>
                    		SOLD
                    	</div>
                    	<div class="largestats">
                    		<div class="bignum2 DNS2">{{$stats[0]->dns}}</div><br/>
                    		DNS
                    	</div>
                    </div>
                    @endif
                    
                    
                </div>
               
                <div title="Demos" id="demos" class="panel"  data-header="apptheader">
                    <!-- <header><span>This is an inline header in a panel.  Below is an inline footer</span></header>-->
                    <script>
                    	function getRepMenu(theid){
                    		$('#theid').val(theid);
                    	}
                    </script>
                  <h2>Appointments for {{date('D M-d')}}</h2>
                    <ul class="list">
                     	@foreach($appts as $v)
                     		<li id="{{$v->id}}" class="{{$v->status}}" style="border-bottom:2px solid #1f1f1f;" onclick='getRepMenu({{$v->id}})'>
                     		<a href="#repmenu" data-id="{{$v->id}}">
                     			<span class="label label-time">{{date('h:i a', strtotime($v->app_time))}}</span>
                     			<span class="label label-name">{{$v->lead->cust_name}}</span>
                     			<span class="label label-number">{{$v->lead->cust_num}}</span>
                     			<br/><br/>
                     			<span style="font-size:12px;color:#000"><b>{{$v->lead->address}}</b></span><br/><br/>
                     			Dispatched To : <span id="rep-{{$v->id}}" class="label label-dispatch">{{$v->rep_name}}</span>
                     			<span id="status-{{$v->id}}" class="status">{{$v->status}}</span>
                     			</a>
                     		</li>
                     	@endforeach
                    </ul>
                   
                </div>
                
                <div title="Lead Manager" id="leadmanager" class="panel">
                    <!-- <header><span>This is an inline header in a panel.  Below is an inline footer</span></header>-->
                    <script>
                    	function getAssignLeads(thecity, avail){
                    		$('#assigncity').val(thecity);
                    		
                    		$('.assignHead').html("Assign "+thecity+" Leads");
                    		$('.assignAvail').html("Avail : "+$('#avail-'+thecity).html());
                    	}
                    </script>
                  <h2 >Available Leads to Assign</h2>
                    <ul class="list">
                     	@foreach($cities as $v)
                     		@if($v->avail>0)
                     		<li id="" class="" style="font-size:10px;border-bottom:2px solid #1f1f1f;" onclick="getAssignLeads('{{$v->city}}')">
                     		<a href="#assignleads" data-city="">
                     			<span class="label" style="font-sie:9px!important">{{strtoupper($v->city)}}</span>
                     			<span id="avail-{{$v->city}}" class="label label-avail" style="float:right;">{{$v->avail}}</span>
                     			<span id="ma-{{$v->city}}" class="label label-lead manilla ">MA-{{$v->paper}}</span><span id="door-{{$v->city}}" class="label label-lead door">DR-{{$v->door}}</span>
                     			
                     			</a>
                     		</li>
                     		@endif
                     	@endforeach
                    </ul>
                    <br/><br/><br/><br/><br/>
                    <div class="message">
                    	{{Alert::find(8)->message}}
                    </div><br/><br/>
                    <button class="btn large danger unassignall">UNASSIGN ALL LEADS</button>
                   
                </div>
                
                <div title="Assign Leads to Booker" id="assignleads" class="panel">
                <br/><br/>
                <h5><span class='label label-avail assignHead' style="margin-left:-0px;padding:5px;ont-size:15px;float:left;">Assign Nanaimo Leads
                
                </span>&nbsp;&nbsp; <span id="available" class='label label-number assignAvail'></span></h1><br/><br/>
                		<form id="assignleads" name="assignleads" method="post">
               		 <input type="hidden" name="assigncity" id="assigncity" value=""/>
                	<span class='label label-dispatch'>Choose a Marketer</span><br/><br/>
                	<select class="assignleads" name="assigntobooker" id="assigntobooker" >
                	<option value=""></option>
                		@foreach($bookers as $val)
                		<option value="{{$val->id}}">{{$val->firstname}} {{$val->lastname}}</option>
                		@endforeach
                	</select>
                	
                	<br/><br/><hr><br/><br/>
                	<span class='label label-dispatch'>Choose a Leadtype</span><br/><br/>
                		<select class='af-ui-forms assignleads' name="leadtype" id="leadtype" >
              		<option value=""></option>
                		<option value="paper">Manilla</option>
                		<option value="door">Door Reggies</option>
                		<option value="rebook">Rebooks</option>
                		
                	</select><br/><br/><br/>
               
                <!-- <button class="btn large assignLeads" >Assign Leads</button>-->
                	</form>
               	
                </div>
                  <!-- af> af Selector -->
                <div title="Sales Manager" id="sales" class="panel splashscreen" style="padding-left:0px">	
               		 <div style="text-align:center;width:100%;color:white;font-size:40px">SALES | Coming Soon</div>
                </div>
                <!-- af> af length() -->
                <div title="Reports Manager" id="reports" class="panel" style="padding-left:0px">
                    <ul class="list">
                    <li class="divider">Marketing</li>
                    <li>
                    	 <a href="#marketstats" class='icon graph big' onclick="$('.getmarket').trigger('click');">Marketing Averages</a>
                    </li>
                    <li>
                    	<a href="#marketreport" class='icon database big' onclick="$('.getmarketreport').trigger('click');">Marketing Reports</a>
                    </li>
                    <li>
                    	<a href="#doorstats" class='icon key big' onclick="$('.getmap').trigger('click');">Door Reggies</a>
                    </li>
                    
                    <li class="divider">Sales</li>
                    <li>Sales Rep Stats</li>
                    <li>Sales Report</li>
                    <li class="divider"></li>
                    
                    </ul>
                </div>
                
               
                <!-- af> af find() -->
                <div title="Agent Manager" id="agent" class="panel splashscreen" style="padding-left:0px" >
                
                </div>
                
                <div title="Marketing Averages" id="marketstats" class="panel"><br/>
                	 <h3>Marketing Team Averages</h3><br/>
                	 <button class="btn getmarket" data-id="DATE">DAILY</button>
                	 <button class="btn getmarket" data-id="WEEK">WEEKLY</button>
                	 <button class="btn getmarket" data-id="MONTH">MONTHLY</button><br/>
                	 <br/>
                	<div class="marketingstats">
                		
                	</div>
                
                </div>
                
                <div title="Marketing Report" id="marketreport" class="panel">
                	<h3> Marketing Report for <span class='dateperiod'>Custom</span></h3><br/>
                	 <button class="btn getmarketreport" data-id="DATE">DAILY</button>
                	 <button class="btn getmarketreport" data-id="WEEK">WEEKLY</button>
                	 <button class="btn getmarketreport" data-id="MONTH">MONTHLY</button><br/>
                	 <div class="marketreports">
                	 
                	 </div>
                	<table>
                		
                	</table>
                		
                		
                	
                </div>
                
               
                <div id="repmenu" class="panel">
                <br/><br/>
               
                   <form id="updateappt" name="updateappt" method="post">
                <input type="hidden" name="theid" id="theid" value=""/>
                	<span class='label label-dispatch'>Dispatch to Rep</span><br/><br/>
                	<select class='processDemo' name="dispatchtorep" id="dispatchtorep" >
                	<option value=""></option>
                		@foreach($reps as $val)
                		<option value="{{$val->id}}">{{$val->firstname}} {{$val->lastname}}</option>
                		@endforeach
                	</select>
                	
                	<br/><br/><hr><br/><br/>
                	<span class='label label-number'>Send BUMP to Marketer</span><br/><br/>
                		<select class='af-ui-forms processDemo' name="dispatchtobooker" id="dispatchtobooker" >
                		<option value=""></option>
                		@foreach($bookers as $val)
                		<option value="{{$val->id}}">{{$val->firstname}} {{$val->lastname}}</option>
                		@endforeach
                	</select>
                	
                	<br/><br/>
                	<hr><br/><br/>
                	<span class='label label-number'>UPDATE STATUS</span><br/><br/>
                	<select class="processDemo" name="status" id="status" >
                	<option value=""></option>
                		<option value="APP">APP</option>
                		<option value="DNS">DNS</option>
                		<option value="SOLD">SOLD</option>
                		<option value="CXL">CXL</option>
                		<option value="RB">RB</option>
                		<option value="NQ">NQ</option>
                	</select><br/><br/><br/><br/><br/>
                 
                	</form>
                	   <script>
                	   $(document).ready(function(){



                	   	$('.processDemo').change(function(e){
                	   		e.preventDefault();
                	   		  $.ajax({
                                url: '../appointment/dispatch',
                                data: $('#updateappt').serialize(),
                                success: function (data) {
                                	var d = JSON.parse(data);
                                	$('#status').val("tesd");
                                	$('#dispatchtobooker').val("Test");
                                	$('#dispatchtorep').val("Test");
                                	$('#'+d.attributes.id).removeClass('DNS APP CXL DISP SOLD').addClass(d.attributes.status);
						$('#status-'+d.attributes.id).html(d.attributes.status);
						$('#rep-'+d.attributes.id).html(d.attributes.rep_name);
						$('#backButton').trigger('click');
                                }
                            });
                	   	});

					$('.assignleads').change(function(e){
                	   		e.preventDefault();
                	   		
                	   		var l = $('#leadtype').val();
                	   		var b = $('#assigntobooker').val();
                	   		var c = $('#assigncity').val();
                	   		if(l.length!=0){
                	   			
                	   			$.ajax({
                                	url: '../lead/assignleads',
                                	data: {leadtype:l,booker:b, city:c},
                                		success: function (data) {
                                			var d = JSON.parse(data);
                                			console.log(d);
                                			if(d.data[0].avail>0){
                                				$('#leadtype').val("");
                                				$('#assigntobooker').val("");
                                				$('#assigncity').val("");
                                				$('#ma-'+d.data[0].city).html("MA : "+d.data[0].paper);
                                				$('#door-'+d.data[0].city).html("DR : "+d.data[0].door);
                                				$('#avail-'+d.data[0].city).html(d.data[0].avail);
                                				$('.message').html(d.message);
                                				$('#backButton').trigger('click');
                                			} else {
                                				alert('No City Selected or No Leads to Assign!');
                                			}

                 					}
                	   			});




                	   		} else {
                	   			return false;
                	   		}
                	   		});
                	   });
                    </script>
                </div>
                	
                	
                	
                	
              
            </div>
          
            
            <div id="navbar" style='margin: 0;float:left;'>
                <a href="#demos" class='icon location'>DEMOS<span class='af-badge lr'>{{count($appts)}}</span></a><a href="#leadmanager" class="icon phone">LEADS</a>
                <a href="#sales" class="icon tag">SALES</a>
                <a href="#reports" class="icon graph">REPORTS</a>
            </div>
        
          
              <header id="apptheader">
                <a id="backButton" onclick="$.ui.goBack()" class='button'>Home</a>
                	<h1>Appointment Board</h1>

            </header>
            <header id="testheader">
                <a id="backButton" onclick="$.ui.goBack()" class='button'>Home</a>
                	<h1>Custom Header</h1>
            </header>
          
            <nav>
                <ul class="list">
                    <li class="divider" class="icon home">Demos</li>
                    <li>
                        <a href="#demos">Todays Demos</a>
                    </li>
                 <li class="divider">Leads</li>
                    <li>
                        <a href="#leadmanager">Lead Manager</a>
                    </li>
                    <li>
                        <a href="#marketstats" id="getmarketstats">Marketing Averages</a>
                    </li>
                     <li class="divider">Sales</li>
                    <li>
                        <a href="#sales">Sales Manager</a>
                    </li>
                     
                     <li>
                        <a href="#reports">Reports</a>
                    </li>
                    <li class="divider">System Messages</li>
                   <li style="height:400px">
                   	<div class="sysalerts">
                   	
                   		@foreach($alerts as $b)
                   		<div class='sysalert'>{{$b->message}}</div>
                   		@endforeach
                   		
                   	</div>
                   </li>
                
                </ul>
            </nav>
            <nav id="menu_AppFramework">
                <ul class="list">
                    
                </ul>
            </nav>
    
     
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
<script src="{{URL::to_asset('js/include/gmap3.min.js')}}"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&amp;language=en"></script>
<script src="{{URL::to_asset('js/include/guage.min.js')}}"></script>
<script>
$(document).ready(function(){

	$('#getmarketstats').click(function(){
    		getBarChart("DATE");
	});

	$('.getmarket').click(function(){
		var t = $(this).data('id');
		getBarChart(t);
	});

	$('.getmarketreport').click(function(){
		var t = $(this).data('id');
		getMarketReport(t);
	});

function getMarketReport(time){
	$.ajax({
            url: '../reports/marketing',
            data: {period:time},
            success: function (data) {
               	var d = JSON.parse(data);
               	console.log(d);
               	var html="";
               	$.each(d.paperanddoor, function(i,val){
               		html+="<div class='largestats bignum PUTON'>Test</div>";
               	});
               


               	$.each(d.appdetails, function(i,val){
               		console.log(val.salestats.booked_by);
               	});


               	$('.marketreports').html("").append(html);

            }	
      });
}


function getBarChart(time){
    	$.get('../users/marketingavg/'+time, function(data){
        	var data = JSON.parse(data);
      	var html="";
      	if(time=="DATE"){time="DAY";}
      	$.each(data.values, function(i,val){
      		html+="<li><span class='label label-dispatch' style='font-size:13px;'>"+val.caller_id+"</span><span class='label label-avail-stats'> "+parseInt(val.avgapp)+"</span><span class='label label-ni'>NI : "+parseInt(val.avgni)+"</span>";
      		if(val.avgdnc>=1){ html+="<span class='label label-dnc'>DNC : "+parseInt(val.avgdnc)+"</span>";}
      		html +="&nbsp;&nbsp;<br/><br/><span class='label label-time' style='font-size:10px;'> "+(parseInt(val.avgapp)/(parseInt(val.avgni)+parseInt(val.avgapp))*100).toFixed(2)+"%</span><span class='label label-name' style='font-size:10px;float:right'>Averages "+parseInt(val.avgcalls)+" Calls a "+time+"</span> </li>";
      	});
       	$('.marketingstats').html("").append("<ul class='list'>"+html+"</ul>");
    	});
}






});




</script>
@endsection