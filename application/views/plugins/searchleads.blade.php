<style>
  .editable {background:#FFFFCC;}
  .filter {margin-right:15px;}
</style>
<?php $take = 10;
$bookers = User::activeUsers('agent','json');
$reps = User::activeUsers('salesrep','json');
$cities = City::allCities('json');

?>

<button class='btn btn-primary btn-large backToScreen right-button' style='margin-top:0px;padding:10px;margin-bottom:10px;'><i class='cus-cancel'></i>&nbsp;&nbsp;CLOSE</button> 

<div class="row-fluid pagination" style="margin-top:20px;">
            	Results Pages : 
            	@for($i=0;$i<$page;$i++)
            	<?php if($i>120){ $class='hide';} else {$class='';};
            	if(($salecount!=0)&&($salecount/10>$i)){
            		$c = "btn-primary";
            	} else {
            		$c = "";
            	}
            	if($pagenum==$i){$c = "btn-danger";};
            	?>
            	<button class="{{$class}} btn btn-default {{$c}} btn-mini paginateLeads" style="margin-bottom:10px;" {{$databuttons}} data-skip="{{$i*$take}}" data-take="{{$take}}"><strong>{{$i+1}}</strong></button>
            	@endfor
            </div>
            <h4 style="margin-top:20px;">
              Lead Results {{$ltitle}}
             
            </h4>
            @if(count($leads)==0)
            <center><img class="animated fadeInUp" src="{{URL::to_asset('images/noresults.jpg')}}" width=600px></center>
            @else
             
       	<div class="row-fluid">
       		@if($page>120)
            	<button class="btn btn-danger btn-mini" style="margin-bottom:10px;" onclick="$('.paginateLeads').toggle();" ><strong>REVEAL ALL PAGINATION ({{intVal($cnt/$take)}} Buttons)</strong></button>
            	@endif
       	</div>        

             <div class='row-fluid' ><h4 style="color:#000;"><span class='editable'>FIELDS THIS COLOR</span> are editable!</h4></div>
            
            <div class="row-fluid " >

		@if(!empty($leads))
            <article class="span12">
		<table class="table table-bordered responsive table-condensed" id="dtable2">
                  <thead style="font-size:12px;">
                    <tr align="center">
    				            <th>Entry / Upload Date</th>
                        <th>Survey Date</th>
    				            <th>Entered By</th>
				                <th style='width:7%;'>Customer<br />Phone Number</th>
				                <th>Customer<br />Name</th>
                        <th>Address</th>
				                <th>City</th>
                        <th>Leadtype</th> 
                        <th>APP HISTORY</th>
                        <th>Booker Name</th>
                        <th>Sales Rep</th>
                        @if(Auth::user()->call_details==0)
				                  <th>Called</th>
				                @endif
				                <th>Notes</th>
				                <th>STATUS</th>
                        <th>Actions</th> 
                    </tr>
                  </thead>
                  <tbody id="bookerleaddata">
                  <?php if(Setting::find(1)->search_411==1){$search=1;} else {$search=0;};?>
                  @foreach($leads as $val2)
                 
                  		<?php 
                  		$label="";$msg="";
                  		if($val2->status=="APP"){$shadow="shadowtable";$color="#000";} else {$shadow="";$color="black";}
					if($val2->status=="APP"){$label="success blackText";$msg = "DEMO BOOKED!";}
					if($val2->result=="DNS"){$label="important special";$msg = "DID NOT SELL";}
					else if($val2->result=="INC"){$label="inverse ";$msg = "INCOMPLETE";}
					else if($val2->status=="INVALID"){$label="inverse special redText";$msg = "INVALID / RENTER";}
					
					         if(($val2->status=="APP")&&($val2->result=="NQ")){$label="important special";$msg = "NOT QUALIFIED";}
					         elseif($val2->status=="SOLD"){$label="warning blackText SOLD";$msg = " $$ SOLD $$";}
	                 elseif($val2->status=="ASSIGNED"){$label="inverse greenText";$msg = "ASSIGNED TO BOOKER";} 
                    elseif($val2->status=="NH") {$label="inverse";$msg = "NOT HOME";} 
                    elseif($val2->status=="DNC") {$label="inverse redText";$msg = "DO NOT CALL!";}
                    elseif($val2->status=="NI") {$label="important blackText";$msg = "NOT INTERESTED";}
                    elseif($val2->status=="Recall") {$label="warning blackText";$msg = "RECALL";} 
                    elseif($val2->status=="NQ") {$label="important blackText";$msg = "NOT QUALIFIED";} 
                    elseif($val2->status=="WrongNumber"){$label="warning blackText";$msg="WRONG #";}
                    elseif($val2->status=="NID"){$label="important special blackText";$msg="NOT INTERESTED IN DRAW";}
                    elseif($val2->status=="INACTIVE"){$label="special blackText";$msg="UNRELEASED";}
                    elseif($val2->status=="DELETED" && $val2->assign_count==99999){$label="important special ";$msg="DUPLICATE LEAD / QUARANTINED";}
                    elseif($val2->status=="DELETED"){$label="important special blackText";$msg="DELETED / OLD";}
                    elseif($val2->status=="NEW"){$label="info";$msg="AVAILABLE";}
                    elseif($val2->status=="RB"){$label="inverse";$msg="TO BE SORTED / RB";}

                                    if($val2->leadtype=="rebook"){$icon2="cus-arrow-redo"; } else {$icon2="";}
                                    if($val2->original_leadtype=="door"){$icon="cus-door";$val2->original_leadtype="Door Survey";} 
                                    else if($val2->original_leadtype=="paper"){$icon="cus-script";$val2->original_leadtype="Manilla Survey";} 
                                    else if($val2->original_leadtype=="survey"){$icon="cus-new";$val2->original_leadtype="Fresh Un-Surveyed Lead";} 
                                    else if($val2->original_leadtype=="ballot"){$icon="cus-inbox";$val2->original_leadtype="Ballot Box";} 
                                    else if($val2->original_leadtype=="other"){$icon="cus-zone-money";$val2->original_leadtype="Scratch Card";} 
                                    else if($val2->original_leadtype=="homeshow"){
                                      $icon="cus-house";$val2->original_leadtype="Home Show ";  if($val2->event){ $val2->original_leadtype.=" - ".$val2->event->event_name;};

                                    } 
                                    else if($val2->original_leadtype=="referral"){$icon="cus-user";$val2->original_leadtype="Referral";} 
                                    else if($val2->original_leadtype=="personal"){$icon="cus-user";$val2->original_leadtype="Personal Lead";} 
                                    else if($val2->original_leadtype=="coldcall"){$icon="cus-telephone";$val2->original_leadtype="Cold Call";} 
                                    else if($val2->original_leadtype=="doorknock"){$icon="cus-door";$val2->original_leadtype="Door Knock";} 
                                    else if($val2->original_leadtype=="secondtier"){$icon="cus-script";$val2->original_leadtype="Second Tier Survey";} 
                                    else {$icon="";	};
                                    $hoverTitle="";
                                    
                                    	if(!empty($val2->referrer)){
                                    		$hoverTitle = "Referred By : ".$val2->referrer->cust_name. " | ".$val2->referrer->cust_num;
                                    	} else {
                                    		$hoverTitle=ucfirst($val2->original_leadtype);
                                    	};?>
                                     
           				<tr id='agentrow-{{$val2->id}}' class="{{$shadow}} {{$val2->status}} {{$val2->leadtype}} leadrow" style='color:{{$color}}'>
						<td>{{date('M-d Y', strtotime($val2->entry_date))}}</td>
            				<td>
            				  @if($val2->birth_date!='0000-00-00')
            				    {{date('M-d', strtotime($val2->birth_date))}}
            				  @else
            				  N/A
            				  @endif
            				</td>
						<td><span class='' >{{$val2->researcher_name}}</span> 
							@if(!empty($val2->manilla_researcher))  <br><span class='label'> {{$val2->manilla_user()}}</span> @endif  </td>
						<td class="editable">
							
							<a href="{{Setting::find(1)->fouroneone_url}}{{$val2->cust_num}}" target=_blank><img src='{{URL::to('images/411-icon.png')}}' class="tooltwo" title="Click to search on 411 / Whitepages" width=20px height=20px border=0 style="float:left;"></a>&nbsp;&nbsp;
													
							<span class="leadEditDropdown small " title="Click to edit the phone number" id="cust_num|{{$val2->id}}">{{$val2->cust_num}}</span>
						</td>
						<td class="editable">
                      				
                        			<span class="leadEditDropdown label label-inverse " title="Click to edit the customer name" id="cust_name|{{$val2->id}}" >{{$val2->cust_name}}</span>
                        			@if($val2->spouse_name)
                         				& <span class="leadEditDropdown label label-inverse " title="Click to edit the spouse name" id="spouse_name|{{$val2->id}}" >{{$val2->spouse_name}}</span>
                        			@endif
                    				
                  			</td>
                    			<td class="editable">
                    				@if(!empty($val2->address))<i class='cus-world viewTheAddress' data-address="{{$val2->address}}" data-lat="{{$val2->lat}}" data-lng="{{$val2->lng}}"></i>&nbsp;&nbsp;@endif

                    				<span class="leadEditDropdown small "  title="Click to edit the address" id="address|{{$val2->id}}">{{$val2->address}}</span>
                    			</td>
                    			<td class="editable">
                    				<span class="changecity  " title="Click to edit the city" id="city|{{$val2->id}}" >{{$val2->city}}</span>
                    			</td>
						<td>
                      				<center>
                        				<span class='tooltwo' title="{{$hoverTitle}} " style="color:#000;"><i class='{{$icon}}'></i></span>
                        				@if($val2->original_leadtype=='Referral')
                        					@if(!empty($val2->referrer))
                        					<br/>
                        					<a href='{{URL::to("lead/newlead/")}}{{$val2->referrer->cust_num}}'>
                        					<span style='font-size:7px;'>
                        					Ref By : 
                        					{{$val2->referrer->cust_name}}
                        					</span>
                        					</a>
                        					@endif
                        				@endif
                        				
                      				</center>
                    			</td>
                    			<td>
                    				@if(!empty($icon2)) 
                      				<i class='tooltwo {{$icon2}}' title="This lead has been Rebooked at least once"></i> <span class='small'>{{$val2->result}} </span> 
                      				@endif
                      				
                      				@if(!empty($val2->appointments))
                      				<center><span class='badge badge-important special viewAppHistory tooltwo' title='Click to view this leads Appointment History' data-id={{$val2->id}}>{{count($val2->appointments)}}</span></center>
                      				<div class='appHistory-{{$val2->id}} expandInfo animated fadeInUp hide'>
                      					@foreach($val2->appointments as $v)
                      					<?php if($v->status=="DNS"){$res = 'important special blackText';} else if($v->status=="INC"){$res = 'warning special blackText';} else if($v->status=="CXL"){$res = 'important blackText';} else if(($v->status=="RB-TF")||($v->status=="RB-OF")){$res = 'info special';} elseif($v->status=="SOLD") {$res="warning special blackText";} else {$res="";};?>

                      						<A href='{{URL::to('appointment/')}}?date={{date('Y-m-d',strtotime($v->app_date))}}&appid={{$v->id}}' target=_blank>
                      							<span class='label label-inverse leadSearchAppts' >
                      								<span class='label label-{{$res}}'>
                      							{{$v->status}}
                      						
                      						</span>&nbsp;&nbsp;Appointment : {{date('M-d',strtotime($v->app_date))}} {{date('h:i a',strtotime($v->app_time))}} 
                      						
                      						@if(!empty($v->rep_name))<br/><br/>
                      						@if($v->rep->level!=99)
                      						<img src='{{URL::to('images/')}}level{{$v->rep->level}}.png' class='rep-level-image'>
                      						@endif
                      						<img src='{{$v->rep->avatar_link()}}' class='rep-level-image'>
                      						@if(($v->status!="RB-TF")&&($v->status!="RB-OF")&&($v->status!="DISP")&&($v->status!="NA"))
                      						
                      							DEMO DONE BY : <font color=yellow>{{$v->rep_name}}</font>
                      							@else
                      							<br/>
                      							DISP TO : <font color=yellow>{{$v->rep_name}}</font>
                      							@endif
                      							<br/>
                      							<span class='small'>
                      							@if((!empty($v->in))&&($v->in!='00:00:00'))
                      							In : {{date('H:i',strtotime($v->in))}} &nbsp;&nbsp;@endif 
                      							@if((!empty($v->out))&&($v->out!='00:00:00'))
                      							Out : {{date('H:i',strtotime($v->out))}} @endif
                      							</span><br/>

                      							@if(($v->status=="SOLD")&&(!empty($v->systemsale)))
                      							<img src='{{URL::to('images/')}}{{$v->systemsale}}.png' class="system-img">
                      							@endif
                      							
                      						@endif
                      						<div class='booker-footer'>Booked on {{date('M-d',strtotime($v->booked_at))}}  by <span>{{$v->booked_by}}</span>
                      							<!--<br/>
                      							Assigned <span>{{$val2->assign_count}}</span> times-->
                      						</div>
                      					</span></a><br/>
                      					@endforeach
                      				</div>
                      				@endif
                    			</td>
                    			<td><span class='small'>{{$val2->booker_name}}</span></td> 
                    			<td>@if(!empty($val2->rep_name))
                    				<span class='small label label-inverse @if($val2->sale) label-success special @endif'> {{$val2->rep_name}}  </span>
                    				@endif
                    			</td> 
                    			@if(Auth::user()->call_details==0)
                    
                    			@if(!empty($val2->calls))
						<td>
							<center>
								<span class='badge badge-info special viewCalls tooltwo' data-id='{{$val2->id}}' title="Click to see all calls made">{{$val2->assign_count}} TIMES</span>
								
							</center><br/>
							<div class='callCount-{{$val2->id}} expandInfo animated fadeInUp' style='display:none;padding:10px;'>
								@foreach($val2->calls as $v)
										<span class='label label-info small ' style='font-size:10px;margin-top:4px;'>Called By : {{$v->caller_name}} on {{date('M-d',strtotime($v->created_at))}} at {{date('H:i a',strtotime($v->created_at))}} | Result : {{$v->result}}</span><br/>
								@endforeach
							</div>
						</td>
						@else 

						<?php $dupcalls = $val2->dupcalls();?>
						@if(!empty($dupcalls))
						<td>
							<center>
								<span class='label label-inverse viewCalls boxshadow' data-id='{{$val2->id}}' title="Click to see all calls made">No Contact</span><br/>
								<span style='font-size:9px;'>Has a Duplicate Lead called {{count($dupcalls)}} Times</span>
								<br/>
								<div class='callCount-{{$val2->id}} expandInfo animated fadeInUp' style='display:none;padding:10px;'>
								@foreach($dupcalls as $v)
										<span class='label label-info small ' style='font-size:10px;margin-top:4px;'>LEAD ID: {{$v->lead_id}} |  Called By : {{$v->caller_name}} on {{date('M-d',strtotime($v->created_at))}} at {{date('H:i a',strtotime($v->created_at))}} | Result : {{$v->result}}</span><br/>
								@endforeach
								</div>
							</center>

						</td>
						@else
						<td>
							<center>
								<span class='label label-inverse boxshadow'>No Contact</span>
							</center>

						</td>

						@endif
						@endif

						
						@endif
						<td>
							@if($val2->notes) <span class="badge badge-warning blackText animated shake special tooltwo deleteNotes noteBubble-{{$val2->id}} " data-id="{{$val2->id}}" title="{{$val2->notes}}  |  Click to delete notes">N</span> @endif
						</td>
						<td>
							<center>
								<div class='status-change-{{$val2->id}}'>
									<span class='label label-{{$label}} special' id="statusButton-{{$val2->id}}" >{{$msg}}<br/>
									@if(Auth::user()->user_type=="manager")
                    							@if($val2->status=="INACTIVE") <button class='btn btn-mini releaseSingleLead' data-id="{{$val2->id}}">RELEASE LEAD</button> @endif
									  	@if($val2->status=="NEW") <button class='btn btn-mini assignSingleLead' id="{{$val2->id}}"> ASSIGN LEAD </button> @endif
									  	@if($val2->status=="DELETED" && $val2->assign_count!=99999) <button class='btn btn-mini reactivateLead tooltwo' title='Click to reset call counter, and release this lead' data-id="{{$val2->id}}">RE-ACTIVATE LEAD</button> @endif
									@endif
								</span>
								</div>
							</center>
						</td>
                    			<td>
                    				<center>
                            @if($val2->assign_count!=99999)
                              @if(Auth::user()->block_recall_search==1 && $val2->status=="Recall")
                              Cannot alter a Recall
                              @else
                              <!--
                              @if($val2->original_leadtype!='Fresh Un-Surveyed Lead' && $val2->status!='INACTIVE')
                    					<button class="btn btn-default btn-mini processLeadFromSearch" data-status="{{$val2->status}}" data-id="{{$val2->id}}"><i class='cus-pencil'></i>PROCESS</button>
                              @endif-->
                              @if($val2->status!='INACTIVE')
                      					<a href="{{URL::to('lead/newlead')}}/{{$val2->cust_num}}"><button class="btn btn-primary btn-mini"><i class='cus-pencil'></i>View </button></a>
                                @endif
                      					&nbsp;&nbsp;<button class="btn btn-danger btn-mini deletelead" data-id="{{$val2->id}}">X</button>
                      				</center> 
                               @endif
                            @endif
                    			</td>
                  		</tr>					
                      @endforeach
                		</tbody>
                	</table>
		</article>
		@endif
		</div>
	</div>
	@endif

<script>
$(document).ready(function(){

$('.releaseSingleLead').click(function(){
	var id = $(this).data('id');
	$.get('{{URL::to('lead/releasesingle/')}}'+id,function(data){
		if(data){
			$('#statusButton-'+id).removeClass('label label').addClass('label label-info').html("AVAILABLE<br/><button class='btn btn-mini assignSingleLead' id='"+id+"'>ASSIGN LEAD</button>");
			toastr.success('Lead succesfully released into pool','LEAD RELEASED');
			$('.assignSingleLead').editable('{{URL::to("lead/assignsingle")}}',{
  				data : '<?php echo $bookers;?>',
  				type:'select',
  				submit:'OK',
     			 	indicator : '<img src="https://s3.amazonaws.com/salesdash/loaders/56.gif">',
     			 	width:'40',
      			callback: function(value, settings){
  				console.log(value);
      			var d = JSON.parse(value); 
      			$('#statusButton-'+d).removeClass('label label-info').addClass('label label-inverse greenText').html("<font color=lime>ASSIGNED TO BOOKER</font>");
				toastr.success('Lead succesfully assigned','LEAD ASSIGNED');
    			}
			});
		}
	});
});

$('.reactivateLead').click(function(){
	var id = $(this).data('id');
	$.get('{{URL::to('lead/reactivate/')}}'+id,function(data){
		if(data){
			$('#statusButton-'+id).removeClass('label label').addClass('label label-info').html("AVAILABLE<br/><button class='btn btn-mini assignSingleLead' id='"+id+"'>ASSIGN LEAD</button>");
			toastr.success('Lead succesfully released into pool','LEAD RELEASED');
			$('.assignSingleLead').editable('{{URL::to("lead/assignsingle")}}',{
  				data : '<?php echo $bookers;?>',
  				type:'select',
  				submit:'OK',
     			 	indicator : '<img src="https://s3.amazonaws.com/salesdash/loaders/56.gif">',
     			 	width:'40',
      			callback: function(value, settings){
  				console.log(value);
      			var d = JSON.parse(value); 
      			$('#statusButton-'+d).removeClass('label label-info').addClass('label label-inverse greenText').html("<font color=lime>ASSIGNED TO BOOKER</font>");
				toastr.success('Lead succesfully assigned','LEAD ASSIGNED');
    			}
			});
		}
	});
});


$('.assignSingleLead').editable('{{URL::to("lead/assignsingle")}}',{
  data : '<?php echo $bookers;?>',
  type:'select',
  submit:'OK',
      indicator : '<img src="https://s3.amazonaws.com/salesdash/loaders/56.gif">',
      width:'40',
      callback: function(value, settings){
      	var d = JSON.parse(value);
      	$(this).html("");
      	$('#statusButton-'+d).removeClass('label label-info').addClass('label label-inverse greenText').html("<font color=lime>ASSIGNED TO BOOKER</font>");
		toastr.success('Lead succesfully assigned','LEAD ASSIGNED');
     }
});

$('.changecity').editable('{{URL::to("lead/edit")}}',{
  data : '<?php echo $cities;?>',
  type:'select',
  submit:'OK',
      indicator : '<img src="https://s3.amazonaws.com/salesdash/loaders/56.gif">',
      width:'40',
      callback: function(value, settings){

    }
});

$('.leadEditDropdown').editable('{{URL::to("lead/edit")}}',{
    indicator : 'Saving...',
         height: 30,
         width:200,
     submit  : 'OK'
});


$('.filter').click(function(){
  var leadtype = $(this).data('type');
  if(leadtype=='all'){
    $('.leadrow').show();
  } else {
$('.leadrow').hide();
$('.'+leadtype).show();}
});

$('.deleteNotes').click(function(){
	var th = $(this);
	var id = th.data('id');
	
	var theid = "notes|"+id;
	var thevalue = "";
	var t = confirm("Are you sure you want to delete these notes");
	if(t){
		$.post("{{URL::to('lead/edit')}}",{id:theid, value:thevalue},function(data){
				th.hide();
				toastr.success("Notes deleted successfully");
		});
	}
});


$('.release').click(function(){
$('#release').toggle(300);
});

$('.deletelead').click(function(){
    var id=$(this).data('id');
    if(confirm("Are you sure you want to delete this lead?")){
        var url = "{{URL::to('lead/delete/')}}"+id;
            $.getJSON(url, function(data) {
            	if(data=="sale"){
            		toastr.error('Lead cannot be deleted', 'Lead has a SALE attached');
            	} else if(data=="app"){
            		toastr.error('Lead cannot be deleted', 'Lead has an APPOINTMENT attached');
            	} else {
            		$('#agentrow-'+id).hide(200);
             		toastr.success('Lead Sucessfully Removed', 'Lead Deleted');
            	}
            });
    }
});

$('.leadEditDropdown').tooltipster({
        fixedWidth: 20
      });

$('.tooltwo').tooltipster({
        fixedWidth: 20
      });

});
</script>
