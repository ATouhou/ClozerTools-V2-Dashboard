@layout('layouts/main')
@section('content')
<?php $set = Setting::find(1);?>
<style>
.bigdate {
	background: #aebcbf; /* Old browsers */
background: -moz-linear-gradient(top,  #aebcbf 0%, #6e7774 50%, #0a0e0a 51%, #0a0809 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#aebcbf), color-stop(50%,#6e7774), color-stop(51%,#0a0e0a), color-stop(100%,#0a0809)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #aebcbf 0%,#6e7774 50%,#0a0e0a 51%,#0a0809 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #aebcbf 0%,#6e7774 50%,#0a0e0a 51%,#0a0809 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #aebcbf 0%,#6e7774 50%,#0a0e0a 51%,#0a0809 100%); /* IE10+ */
background: linear-gradient(to bottom,  #aebcbf 0%,#6e7774 50%,#0a0e0a 51%,#0a0809 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#aebcbf', endColorstr='#0a0809',GradientType=0 ); /* IE6-9 */
}

.highlight {
	background: #f1e767; /* Old browsers */
background: -moz-linear-gradient(top,  #f1e767 0%, #feb645 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#f1e767), color-stop(100%,#feb645)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #f1e767 0%,#feb645 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #f1e767 0%,#feb645 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #f1e767 0%,#feb645 100%); /* IE10+ */
background: linear-gradient(to bottom,  #f1e767 0%,#feb645 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f1e767', endColorstr='#feb645',GradientType=0 ); /* IE6-9 */
}
</style>
<?php if($set->map_settings=="leftside"){
	$right = "38%";
	$left = "59%";
} else if($set->map_settings=="rightside"){
	$right = "59%";
	$left = "38%";
} else {
	$right = "100%";
	$left = "100%";
};
if(Auth::user()->user_type=="manager"){
	$top = "125px";
} else {
	$top = "90px";
}

?>
    		
     
<style>
#leftmap {
	float:left;border:4px solid #1f1f1f;
	background:white;height:1150px;
	width:{{$left}};
	margin-top:{{$top}};
	z-index:50000;
	border-bottom:6px solid #1f1f1f;
}
#rightmap {
	background:white;
	z-index:50000;
	float:left;
	border:4px solid #1f1f1f;
	border-bottom:6px solid #1f1f1f;
  	width:{{$right}};
  	margin-top:{{$top}};
  	height:1150px;
}
#dispatchFromMap {

	width:250px;
	padding:20px;
	z-index:60000;
	margin-left:35px;
	float:left;
	margin-top:-1110px;
	position:relative;
	background:white;
	border-radius:3px;
	border:1px solid #ccc;

}

.textRep {cursor:pointer;}
.allReps{display:none;}
.dnshighlight {background:#FFFF99;}
.allReps {width:100%;float:left;margin-top:10px;}
</style>


<?php if(isset($_GET['appid'])) {$app = $_GET['appid'];} else {$app=array();};
if(isset($_GET['app_city'])){$city = $_GET['app_city'];} else {$city="all";};
?>

<div class="modal hide fade" id="salestext_modal" style="width:58%;margin-left:-650px;margin-top:-45px;">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h3> Send a Sales Text to <span id='rep-text-heading'></span></h3>
	</div>
	<div class="modal-body" >
			<input type="hidden" id="reptext-id" value="">
			<h4 style='margin-top:-10px;'>Enter Your Message</h4>
			<textarea style='width:40%;float:left;' rows=3 name="text-message" id="text-message"></textarea>
			
			<input type="text" style="width:30%;margin-left:20px;float:left;" name="url-sms-image" id="url-sms-image" value="" placeholder="Copy/Paste an optional URL to an Image Here" ><br/><br/>
                  
			<div class="allReps">
			@if(!empty($reps))
			<div class="span2" style="width:20%;float:left;">
			<fieldset>
			<label><strong>Dealers</strong>&nbsp;&nbsp;<input type="checkbox" class='btn btn-mini checkAll' value="checkall"> <span class='small'>Check All</span></label>
			
			@foreach($reps as $v)
			<input class='rep-text text-dealers' type='checkbox' name='reps[]' id='reps[]' @if($v->texting==1) checked='checked' @endif value='{{$v->id}}'> {{$v->firstname}} {{$v->lastname}}<br/>
			@endforeach
			</fieldset>
			</div>
			@endif


			@if(!empty($bookers))
			<div class="span2" style="width:20%;float:left;">
			<fieldset>
			<label><strong>Bookers</strong>&nbsp;&nbsp;<input type="checkbox" class='btn btn-mini checkAll' value="checkall"> <span class='small'>Check All</span></label>
			@foreach($bookers as $v)
			<input  class='rep-text text-bookers' type='checkbox' name='reps[]' id='reps[]' @if($v->texting==1) checked='checked' @endif value='{{$v->id}}'> {{$v->firstname}} {{$v->lastname}}<br/>
			@endforeach
			</fieldset>
			</div>
			@endif

			@if(!empty($door))
			<div class="span2" style="width:20%;float:left;">
			<fieldset>
			<label><strong>Reggiers</strong>&nbsp;&nbsp;<input type="checkbox" class='btn btn-mini checkAll' value="checkall"> <span class='small'>Check All</span></label>
			@foreach($door as $v)
			<input class='rep-text text-reggiers' type='checkbox' name='reps[]' id='reps[]' @if($v->texting==1) checked='checked' @endif value='{{$v->id}}'> {{$v->firstname}} {{$v->lastname}}<br/>
			@endforeach
			</fieldset>
			</div>
			@endif

			
			<div class="span2" style="width:20%;float:left;">
			@if(!empty($text))
			<label><strong>Managers / Other</strong></label>
			@foreach($text as $v)
			<input class='rep-text' type='checkbox' name='reps[]' id='reps[]' @if($v->texting==1) checked='checked' @endif value='{{$v->id}}'> {{$v->firstname}} {{$v->lastname}}<br/>
			@endforeach
			@endif			
		  	</div>
		</div>

	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal">Cancel</a>
    	<button type="button"  class="btn btn-primary sendText">SEND TEXT!</a>
	</div>
</div>


<div class="modal hide fade" id="dealercallout_modal" style="width:58%;margin-left:-700px;margin-top:-45px;">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h3> Fill in Closing Callout Information<span id='rep-text-heading'></span></h3>
	</div>
	<div class="modal-body" id="closingCallout" >
			
	</div>
	<div class="modal-footer">
		<a href="#" class="btn btn-primary" data-dismiss="modal">CLOSE</a>
    	
	</div>
</div>

<div class="modal hide fade" id="dnscallback_modal" style="width:80%;margin-left:-700px;margin-top:25px;">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h3> DNS Callbacks for {{$date}}<span id='rep-text-heading'></span></h3>
	</div>
	<div class="modal-body" id="dnsCallbackBody" >
			<table class="table table-condensed table-bordered">
				<thead>
					<tr>  
						<th>Phone</th>
						<th>Address</th>
						<th>Booked By</th>
						<th>Dealer</th>
						<th>EST Time in Appt</th>
						<th>Called Back</th>
						<th style="width:30%;">Callback Notes</th>
					</tr>
				</thead>
				<tbody>
					<?php $dnscount=0;$callbackcount=0;?>
					@foreach($appts as $a)
					@if($a->status=="DNS" )
					<?php if($a->has_callback==0){
						$check = ""; $dnscount++;
					} else {
						$check ="checked = 'checked'"; $callbackcount++;
					};?>
					<tr id="dnscallback-{{$a->id}}" class="dnscallbackRow">  
						<td><b>{{$a->lead->cust_num}}</b></td>
						<td><span style="font-size:10px;">{{$a->lead->address}}</span></td>
						<td>{{$a->booked_by}}</td>
						<td>{{$a->rep_name}}</td>
						<td>  <center>
							@if(number_format(floatval($a->diff),2)!='0.00') 
							{{number_format(floatval($a->diff),2)}} / hr
							@endif
							</center>
						</td>
						<td>
							<center>
							<input type="checkbox" name="callback" id="has_callback-{{$a->id}}" class="markAppt tooltwo"  data-theid='{{$a->id}}' title='Click to mark that you have done a DNS callback on this appointment' data-id='has_callback|{{$a->id}}' data-themsg="DNS callback acknowledged" {{$check}} > 
							</center>
						</td>
						<td class="edit" id="callback_notes|{{$a->id}}" title="Click to edit...">@if(!empty($a->callback_notes)) {{$a->callback_notes}} @endif</td>
					</tr>
					@endif
					@endforeach
				</tbody>
			</table>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn btn-primary" data-dismiss="modal">CLOSE</a>
    	
	</div>
</div>

<div class="demoTable" >
	<table class="table table-condensed apptable">
		<tr>	
			<th style="width:10%;">Time</th>
			<th style="width:16%;">Name</th>
			<th>Number</th>
			<th>Address</th>
			<th style="width:20%;">Sales Rep</th>
			<th>Status</th>
		</tr>
		<tbody>
                        @if(!empty($app))
				<?php $highlight = "background:yellow;";?>
				@else 
				<?php $highlight = "";?>
				@endif
                        @if(!empty($appts))
                        <?php $count = count($appts);?>
                        @foreach($appts as $val)
                        <?php 
                        $time = strtotime($val->app_time);
                        $slot="";
                        
                		
                		if(($time>=strtotime($slots[0]['s']))&&($time<=strtotime($slots[0]['f']))){$slot=$slots[0]['selector'];}
				if(($time>=strtotime($slots[1]['s']))&&($time<=strtotime($slots[1]['f']))){$slot=$slots[1]['selector'];}
				if(($time>=strtotime($slots[2]['s']))&&($time<=strtotime($slots[2]['f']))){$slot=$slots[2]['selector'];} 
				if(($time>=strtotime($slots[3]['s']))&&($time<=strtotime($slots[3]['f']))){$slot=$slots[3]['selector'];} 
				if(($time>=strtotime($slots[4]['s']))&&($time<=strtotime($slots[4]['f']))){$slot=$slots[4]['selector'];}  
				$rb="";
					 if($val->status=="DISP"){$label="inverse";$class="";}
                            elseif($val->status=="CONF"){$label = "success";$class="CONF";}
                            elseif($val->status=="SOLD"){$label="warning special black"; $class="";} 
                            elseif($val->status=="CXL"){$label="important";$class="CXL";}
                            elseif($val->status=="NQ"){$label="important special";$class="";}
                            elseif($val->status=="DNS"){$label="important special";$class="";}
                            elseif($val->status=="INC"){$label="warning";$class="";}
                            elseif(($val->status=="RB-TF")||($val->status=="RB-OF")){$label="info special";$class="RB-TF";$rb="isRebook";}
                            elseif($val->status=="NA"){$label="warning black";$class="NA";} elseif($val->status=="BUMP") {$label="bump";$class="";} else {$label="success special"; $class="";}
                            $type="";
                            if($val->lead->original_leadtype=="door"){$type="DR";} 
                            else if($val->lead->original_leadtype=="paper"){$type="MA";} 
                            else if($val->lead->original_leadtype=="other"){$type="SC";} 
                            else if($val->lead->original_leadtype=="homeshow"){$type="HS";}
                            else if($val->lead->original_leadtype=="ballot"){$type="BB";}  
                            else if($val->lead->original_leadtype=="referral"){$type="REF";}
                            else if($val->lead->original_leadtype=="rebook"){$type="RB";}
                            else if($val->lead->original_leadtype=="personal"){$type="P";} 
                            else if($val->lead->original_leadtype=="coldcall"){$type="CC";} 
                            else if($val->lead->original_leadtype=="doorknock"){$type="DK";} 
                             else if($val->lead->original_leadtype=="secondtier"){$type="ST";} 
                            
                            
                            if($val->status=="SOLD"){$animation = "animated swing bignum3";}else {$animation="";};?>
                        <tr class="{{$rb}} maprow datarow {{$val->status}} {{$val->app_time}} {{$slot}} leadid-{{$val->lead_id}}" id="{{$val->id}}" data-idlink="{{$val->lead_id}}" data-status="{{$val->status}}" style="color:#000;@if($app==$val->id){{$highlight}}@endif" >
      				
                            <td>
                                <center>
                                @if($val->confirmed!=1)
                                    <b>{{date('g:i a', strtotime($val->app_time))}}</b>
                                @else
                                    <span class="label label-success"><b>{{date('g:i a', strtotime($val->app_time))}}</b></span>
                                @endif
                                </center>
                            </td>
                            
                           
                            <td>
                                    <span class="revealDetails tooltwo"  style="font-size:10px;" title="Click to view more info..." data-type="lead" data-id="{{$val->lead->id}}">
                                    @if(!empty($val->lead->spouse_name))
                                        {{ucfirst($val->lead->cust_name)}} and {{ucfirst($val->lead->spouse_name)}}
                                    @else
                                        {{ucfirst($val->lead->cust_name)}}
                                    @endif
                              	</span>	
                              	
                            </td>

                            <td class="span2">
                                    <span style="font-size:9px;">&nbsp;{{$val->lead->cust_num}}</span>
                            </td>

                            <td class="span4">
                                <span class="viewLargeMap tooltwo"  style="font-size:10px;" title="Click to view this address on a map" style="cursor:pointer;" data-repid="{{$val->rep_id}}" data-rideid="{{$val->ridealong_id}}" data-time="{{date('g:i a', strtotime($val->app_time))}}" data-address="{{$val->lead->address}}" data-lat="{{$val->lead->lat}}" data-lng="{{$val->lead->lng}}" data-name="{{$val->lead->cust_name}}" data-spouse="{{$val->lead->spouse_name}}" data-num="{{$val->lead->cust_num}}" data-book="{{$val->lead->booked_by}}" data-id="{{$val->id}}"><button class='btn btn-default btn-mini' style='border:1px solid #3e3e3e;'>{{$val->lead->address}}</button></span>
                            </td>
                            <td>

                            @if((!empty($val->lead->rep))&&(!empty($val->rep_id)))
                            
                            @if(($val->ridealong_id!=0)&&(!empty($val->ridealong)))
                            <img src='{{URL::to('img/ride-along.png')}}' width=22px height=22px>
                            <span class="badge badge-important special tooltwo" style="padding:2px;font-size:9px;" title='Has Ride Along : {{$val->ridealong->firstname}} {{$val->ridealong->lastname}}'>RA</span>
                            @endif

                            <?php $u = User::find($val->rep_id);?>
                            @if(($u)&&(!empty($u->cell_no)))
                            @if($set->texting)
                             <img class='salesText tooltwo' title="Click to send this dealer an SMS text message" data-username='{{$u->firstname}} {{$u->lastname}} @ {{$u->cell_no}}' data-type="{{$u->id}}" src='{{URL::to('images/text-rep.png')}}' width=22px height=22px>

                             @endif
                             @endif
                                <span class='editsalesrep' style="font-size:10px;" id="rep_id|{{$val->id}}">{{strtoupper($val->lead->rep_name)}}</span>&nbsp;&nbsp;
                            @endif
                            </td>
                            <td>
                                <center>
                                    <span class="{{$animation}} label label-{{$label}} status-{{$val->id}}">{{$val->status}}</span>
                                </center>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
	</table>  		
</div>

<div id="leadview">
	<div class="backtodash" >
  		<button class="btn btn-danger btn-large animated fadeInUp " style="border:1px solid #1f1f1f; padding:30px;" onclick="$('.demoTable').fadeOut(200);$('#leadview').fadeOut(200);$('.infoHover').fadeOut(200);" >
  			<i class="cus-cancel"></i>&nbsp;&nbsp;BACK TO APPOINTMENT BOARD
	  	</button>
  	</div>
    	<div class="largeMap">

    		@if($set->map_settings=="leftside")
    		<div id="rightmap" class="animated slideInLeft"></div><div id="leftmap" class="animated slideInRight" class="gmap3"></div>
    		@elseif($set->map_settings=="rightside")
    		<div id="leftmap" class="animated slideInLeft" class="gmap3"></div><div id="rightmap" class="animated slideInRight"></div>
    		@elseif($set->map_settings=="onlystreet")
    		<div id="rightmap"  class="animated fadeInUp" style="display:none;"></div><div id="leftmap"  class="animated fadeInUp"></div>
    		@elseif($set->map_settings=="onlymap")
    		<div id="rightmap" class="animated fadeInUp"></div>
    		@endif
    		@if(Auth::user()->user_type=="manager")
    		<div id="dispatchFromMap" class="medShadow animated slideInLeft">

    			<form id="dispatchtorepFromMap" action="{{URL::to('appointment/dispatch')}}" method="post">
                        	<h4 id="processheadFromMap"></h4>
                        	<br/>
                        	<div class="span3">
                        	    	<label><i class='cus-user'></i>&nbsp;&nbsp;Select a Rep</label>
                        	        <input type="hidden" name="dispid" id="dispidFromMap" value=""/>
                        	        <select class="dispatch" name="rep" id="repFromMap" >
                        	            <option value=""></option>
                        	            @if(!empty($reps))
                        	            @foreach($reps as $val2)
                        	            @if($val2->working==1)
                        	          	<?php if($val2->hasMachines()==true){$d = "true"; $t="";} else {$d="false";$t="| No Machines";};?>
                        	            <option value="{{$val2->id}}" data-machine="{{$d}}">{{$val2->firstname}} {{$val2->lastname}} </option>
                        	            @endif
                        	            @endforeach
                        	            @endif
                        	        </select>
                        	</div>

                        	<div class='span3'>       
                        	        <label><i class='cus-car'></i>&nbsp;&nbsp;Ride-Along</label>
                        	        <select class="dispatch" name="ridealong" id="ridealongFromMap" >
                        	            <option value=""></option>
                        	             @if(!empty($reps))
                        	            @foreach($reps as $val2)
                        	            @if($val2->working==1)
                        	            <option value="{{$val2->id}}">{{$val2->firstname}} {{$val2->lastname}}</option>
                        	            @endif
                        	            @endforeach
                        	            @endif
                        	        </select>
                        	</div>
                        	<div class='span3' style='margin-top:14px;'> 
                        		<input class='tooltwo' title='Check this box, to dispatch as a RIGHT AWAY to the rep, instead of the set appointment time' type="checkbox" name="rightaway" id="rightawayFromMap" /><span class='small'>&nbsp&nbsp;Right Away</span><br/>
                        	 	<input class='tooltwo' title='Check this box, to send the rep a text with this demos information' type="checkbox" name="sendtext" id="sendtextFromMap" @if($set->texting==1)checked="checked" @endif /> <span class='small'>Send Text to Dealer/s</span>
                        	</div>
                        	<div class='row-fluid span9'>
                        		<div style='float:left;margin-left:-15px;margin-top:30px;'>
                        		<label>Optional message to send </label>
                        		<input style="width:80%;" type='text' name='textRepNote' id='textRepNoteFromMap' />
                        	</div>
                        	</div>
                        	<div class='span3' style='margin-top:14px;'> 
                        		<button class="btn btn-small btn-primary " style="margin-top:10px;" data-id="" />
                        	      	<i class="cus-arrow-left"></i>&nbsp;&nbsp;DISPATCH
                        		</button>
                        	</div>
                        
                  		</form>
    		</div>
    		@endif
    	</div>
</div>

<div id="main"  class="container-fluid hide-these-when-searching deskBack " style="min-height:1200px;padding:18px;padding-top:30px;padding-bottom:500px;">

@if($set->shortcode!="mdhealth" && $set->shortcode!="cyclo" && $set->shortcode!="triad" && $set->shortcode!="starcity" && $set->shortcode!="foxv" && $set->shortcode!="mdhealth" && $set->shortcode!="ribmount" && $set->shortcode!="pureair")
@render("plugins.overlay2")
@endif
	<div class="topBar subtle-shadow">
		<div class='row-fluid' id="pageheader" data-date="{{$datepass}}">
        	
        	<div class="span2">
        		<form id="filterApps" method="get" action="">
        		<label> Appointment City : </label>
        		<?php $cities = City::activeCities();?>
        		<select name="app_city" id="app_city" style="width:50%;">
        			<option value="all">All</option>
        		@if(!empty($cities))
        		@foreach($cities as $val)
        		<option value="{{$val->cityname}}" 
        			@if((isset($_GET['app_city']))&&($_GET['app_city']==$val->cityname)) 
        			selected = 'selected' 
        			@endif>{{$val->cityname}}</option>
        		@endforeach
        		@endif
        		</select>
        		
        	</div>
        	<div class="span1">
        	<div class="input-append date" style="margin-left:-120px;float:left;" id="datepicker-js" data-date="{{date('Y-m-d')}}" data-date-format="yyyy-mm-dd">
        		<label>Appointment Date : </label>
     			<input class="datepicker-input changedate" size="16" id="appdate" name="appdate" type="text" 
     			@if(isset($datepass))
     			value="{{date('Y-m-d',strtotime($datepass))}}" 
     			@endif
     			placeholder="Select a date" />
  			<span class="add-on"><i class="cus-calendar-2"></i></span>	
  		</div>
  		</div>
  		<div class="span1" style="margin-top:0px;margin-left:-10px;">
        		
        		<?php $c =  City::where('cityname','=',$city)->first(array('rightaway','id'));
        		
        		?>
        		@if(!empty($c))
        		<?php $c=$c->attributes;?>
        		<span class='small'>Right Away's </span><br/>
        		<center>
        		<span class="badge badge-info special rightawayedit" style="padding:8px;font-size:18px;margin-left:-50px;cursor:pointer;" id="rightaway|{{$c['id']}}" >{{$c['rightaway']}}</span></center>
        		
        		@endif
        	</div>
  		

        	</form>
        		
        	<div class='span4' style='margin-top:5px;margin-left:10px;'>
        		<div class='row-fluid' style='padding-left:110px;'>
        			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style='font-size:12px;'>Combine Slots</span> <input class="tooltwo" title="Check to allow filtering of multiple time slots at once" type="checkbox" name="combineFilter" id="combineFilter">
        			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='{{URL::to("system/settings")}}' style='font-size:12px;'>Click to Edit Slot Times / Names</a>
        		</div>
        		<div class='row-fluid'>
        		<!--<button class="btn btn-small btn-default filterTime tooltwo slotbutton-rebooks" title="Click to view all rebooks for {{$date}}" data-slot="rebooks" data-start="rebooks" data-end="rebooks">
            		Rebooks
            	</button>-->
        		<button class="btn btn-small btn-default btn-inverse filterTime tooltwo slotbutton-all" title="Click to view all appointments for {{$date}}" data-slot="all" data-start="all" data-end="all">
            		All
            	</button> &nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;
            	@foreach($slots as $s)
            	<button class="btn btn-small btn-default filterTime tooltwo slotbutton-{{$s['selector']}}" title="Click to view the appointments that fall under {{$s['name']}}" data-slot="{{$s['selector']}}" data-start="{{$s['s']}}" data-end="{{$s['f']}}">
            		{{$s['name']}}
            	</button>
            	@endforeach
	           	
            	
      		</div>
         	</div>
         	<div style="float:left;margin-top:21px;margin-left:-50px;">
      			<input type="checkbox" class="myinput large showavailable " name="available" id="available" />
			&nbsp;&nbsp;&nbsp;View Available Only
      		</div>
            <div style="margin-top:15px;float:right;margin-right:50px;">
            	<div class='btn btn-default dealerStatus-toggle tooltwo' data-switch='0' title="View status of all dealers" >
            	    		<i class='cus-grid'></i>&nbsp;&nbsp;SHOW DAYS
            		</div>
            	@if(Auth::user()->user_type=="manager")
            		@if($set->texting)
            	 	<div class='btn btn-purps salesText tooltwo' data-type='all' title="Send a mass text to all chosen employees" >
            	    		<i class='cus-transmit'></i>&nbsp;&nbsp;SALES TEXT
            		</div>
            		@endif
            		
            	
        		<div class="btn-group">
				<button class="btn btn-yells blackText dropdown-toggle" data-toggle="dropdown">
					<i class="cus-world"></i> View on Map <span class="caret"></span>
				</button>
				<ul class="dropdown-menu">
					<li>
						<a href="javascript:void(0);" class="viewDemoMap" data-slot="all" data-start="all" data-end="all"><i class="cus-world"></i> All Demos</a>
					</li>
					@foreach($slots as $s)
            			<li>
						<a href="javascript:void(0);"  class="viewDemoMap" data-slot="{{$s['selector']}}" data-start="{{$s['s']}}" data-end="{{$s['f']}}"><i class="cus-clock"></i> {{$s['name']}}</a>
					</li>
            			@endforeach
				</ul>
			</div>
			@endif

            </div>
        	</div>
        	<div class='topDateBar date-BAR subtle-shadow' style='display:none;'>
        		<div style='margin:auto;width:100%;float:left;'>
        		<?php $num = cal_days_in_month(CAL_GREGORIAN, 5, 1979) ; 
        		$date =  date('1-m-Y',strtotime('this month'));
        		$c=-1;?>

        		@for($i=1;$i<=31;$i++)
        		<?php $c++;?>
        		<a href="{{URL::to('appointment/')}}?app_city={{$city}}&appdate={{date('Y-m-d', strtotime($date. ' + '.$c.' days'));}}">
        			<button class='btn btn-mini @if($datepass==date('Y-m-d',strtotime($date. ' + '.$c.' days'))) btn-inverse  @else btn-default @endif btn-default'>
        				<span class='small' style='font-weight:normal;font-size:9px;' >{{date('D d',strtotime($date. ' + '.$c.' days'))}}</span>
        			</button>
        		</a>
        		@endfor
        		</div>
            </div>
            <div class='topDateBar dealer-BAR subtle-shadow'  >
        		<div class='dealer-StatusBar' style='width:79%;float:left;margin-left:-10px;'>
        		</div>
        		
        		<div class="dnsCallback" style="width:9%;float:right">
        			@if($dnscount!=0 || $callbackcount!=0)
        			<button class="btn btn-inverse btn-mini dnsCallbackButton">DNS CALLBACKS &nbsp;&nbsp; 
        				@if(!empty($dnscount))<span class='tooltwo smallbadge badge badge-important special' title="Uncalled DNS's" >{{$dnscount}}</span>@endif
        				@if(!empty($callbackcount))<span class='tooltwo smallbadge badge badge-success special' title="DNS's that have been called back">{{$callbackcount}}</span>@endif
        			</button>
        			@endif
        		</div>
           </div>
 </div>

    <div id="processsale" class="shadowBOX" style="margin-top:125px;"></div>

    <div class="processBOX subtle-shadow"  >
    		<div class="bump">
            <form method="post" action="{{URL::to('appointment/bumptime')}}">
            <label>BUMP FOR TODAY</label>
                  <input class="dispatch" name="bumptoday" id="bumptoday" style="z-index:100051!important" placeholder="Select Time...">
                  <input type="hidden" name="theid" id="theid" value="" />
                  <button class="btn btn-small tooltwo bumpTodayDispatch" title='Select a time to BUMP appointment, this will show on all marketers screens, until bumped' style="margin-top:10px;">
                        BUMP APPOINTMENT
                  </button>
            </form>
            </div>

                <article class="row-fluid" >
                        
                    <div class="span6">
                        <form id="processform" method="post" action="{{URL::to('appointment/process')}}">
                            <h4 style="margin-top:-20px;">
                               <span id="processhead">Process an Appointment</span><br/><br/><b>Tel : <span id="custnum" style="color:#1f1f1f"></span></b></h4>
                            <span class="label label-inverse">Address :</span>&nbsp;&nbsp; <span class="address"></span>
                            <br />
                            <span class="label label-inverse">Gift :</span>&nbsp;&nbsp;<span class="thegift"></span><br/>
                            <span class="label label-inverse">Spouse :</span>&nbsp;&nbsp;<span class="thespouse"></span>
                            <label class="control-label" for="input01"><b>Enter Notes</b></label>
                                <input type="hidden" id="idnum" name="idnum" value="" />
                                <textarea rows=4 cols=9 name="notes" id="notes"></textarea>
                            <label class="control-label"><strong>CHOOSE A NEW STATUS</strong></label>
                                <div class="btn-group" data-toggle="buttons-radio">
                                    <?php if (Auth::user()->user_type!="manager"){
                                        $size = "small";} else {$size="mini";};?>
                                    <button type="button" class="btn btn-{{$size}} process Rebook tooltwo" title='REBOOK - Their Fault' data-status="RB-TF">
                                        <i class="cus-book-previous"></i>&nbsp;RB-TF
                                    </button>
                                    <button type="button" class="btn btn-{{$size}} process Rebook tooltwo" title='REBOOK - Our Fault' data-status="RB-OF">
                                        <i class="cus-book-previous"></i>&nbsp;RB-OF
                                    </button>
                                    <button type="button" class="btn btn-{{$size}} process tooltwo" title='Cancelled' data-status="CXL">
                                        <i class="cus-delete"></i>&nbsp;CXL
                                    </button>
                                    <button type="button" class="btn btn-{{$size}} process tooltwo" title='Not Available'  data-status="NA">
                                        <i class="cus-telephone"></i>&nbsp;NA
                                    </button>
                                    <button type="button" class="btn btn-{{$size}} process  tooltwo" title='Confirmed' data-status="CONF">
                                        <i class="cus-accept"></i>&nbsp;CONFIRM
                                    </button>
                                    @if(Auth::user()->user_type=="manager")
                                    <button type="button" class="btn btn-{{$size}} process tooltwo" title='Not Qualified' data-status="NQ">
                                        <i class="cus-cross"></i>&nbsp;NQ
                                    </button>
                                    <button type="button" class="btn btn-{{$size}} process tooltwo" title='Incomplete' data-status="INC">
                                        <i class="cus-plug"></i>&nbsp;INC
                                    </button>
                                     <button type="button" class="btn btn-{{$size}} process tooltwo" title='Did Not Sell' data-status="DNS">
                                        <i class="cus-plug"></i>&nbsp;DNS
                                    </button>
                                    
                                    @endif
                                </div>                                                    
                                <div class=" dateandtime" style="margin-top:15px;display:none">
                                    <span class="small">Leave notes if no time is chosen. So we know what to do with the rebook in the future.<br/></span>
                                    <label for="time">Pick New Rebook Time </label>
                                    <i class="cus-clock"></i>&nbsp;<input id="booktimepicker" name="booktimepicker" placeholder="Select Time..." type="text" style="width:16%;"  />                             
                                    
                                    <label for="time">Pick New Appt. Date</label>                               
                                    <div class="input-append date" id="datepicker-js" data-date="{{date('Y-m-d')}}" data-date-format="yyyy-mm-dd">                                 
                                     <input class="datepicker-input" size="16" id="appdate" name="appdate" type="text" value="{{date('Y-m-d')}}" placeholder="Select a date" />                                  
                                     <span class="add-on"><i class="cus-calendar-2"></i></span>                              
                                 	</div>
                                 	<!--<label for="time">Pick a Callback Time </label>
                                    <i class="cus-clock"></i>&nbsp;<input id="callbacktime" name="callbacktime" placeholder="Select Time..." type="text" style="width:16%;"  />  -->                                       
                             	
                             	</div>
                                    

                                <input type="hidden" name="result" id="result" value="" />
                                <div class="row-fluid" style="margin-top:40px;">
                                    <button class="btn btn-primary " id="savebutton" style="display:none">
                                        <i class="cus-accept"></i>&nbsp;&nbsp;SAVE</button>
                                        <a href="javascript:void();" class="btn btn-danger closeProcess "><i class="cus-cross"></i>&nbsp;&nbsp;CLOSE</a>
                                </div>
                        </form>
                        <div class="row-fluid referralInfo" style="margin-top:100px;font-size:18px;" >
                        
                        	
                        
                        </div>
                    </div>


                    <div class="span6" style="height:390px;margin-top:-20px;">
                        <div id="map2" style="width:100%;border:1px solid #1f1f1f;
                            @if(Auth::user()->user_type!="manager")
                            height:360px;
                            @else
                            height:250px;
                            @endif
                            margin-bottom:10px;">
                        </div>
                            
                        @if(Auth::user()->user_type=="manager")
                        <h5 >Dispatch to Sales Rep</h5>
                        <div class='row-fluid processRow'>
                        
                        	<form id="dispatchtorep" action="{{URL::to('appointment/dispatch')}}" method="post">
                        	<div class="span3">
                        	    	 <label><i class='cus-user'></i>&nbsp;&nbsp;Select a Rep</label>
                        	        <input type="hidden" name="dispid" id="dispid" value=""/>
                        	        <select class="dispatch" name="rep" id="rep" >
                        	            <option value=""></option>
                        	            @if(!empty($reps))
                        	            @foreach($reps as $val2)
                        	            @if($val2->working==1)
                        	          	<?php if($val2->hasMachines()==true){$d = "true"; $t="";} else {$d="false";$t="| No Machines";};?>
                        	            <option value="{{$val2->id}}" data-machine="{{$d}}">{{$val2->firstname}} {{$val2->lastname}} </option>
                        	            @endif
                        	            @endforeach
                        	            @endif
                        	        </select>
                        	</div>

                        	<div class='span3'>       
                        	        <label><i class='cus-car'></i>&nbsp;&nbsp;Ride-Along</label>
                        	        <select class="dispatch" name="ridealong" id="ridealong" >
                        	            <option value=""></option>
                        	             @if(!empty($reps))
                        	            @foreach($reps as $val2)
                        	            @if($val2->working==1)
                        	            <option value="{{$val2->id}}">{{$val2->firstname}} {{$val2->lastname}}</option>
                        	            @endif
                        	            @endforeach
                        	            @endif
                        	        </select>
                        	</div>
                        	<div class='span3' style='margin-top:14px;'> 
                        		<input class='tooltwo' title='Check this box, to dispatch as a RIGHT AWAY to the rep, instead of the set appointment time' type="checkbox" name="rightaway" id="rightaway" /><span class='small'>&nbsp&nbsp;Right Away</span><br/>
                        	 	<input class='tooltwo' title='Check this box, to send the rep a text with this demos information' type="checkbox" name="sendtext" id="sendtext" @if($set->texting==1)checked="checked" @endif /> <span class='small'>Send Text to Dealer/s</span>
                        	</div> 
                        	<div class='span3' style='margin-top:14px;'> 
                        		<button class="btn btn-small btn-primary repdispatch" style="margin-top:10px;" data-id="" />
                        	      	<i class="cus-arrow-left"></i>&nbsp;&nbsp;DISPATCH
                        		</button>
                        	</div>
                        	<div class='row-fluid span9'>
                        		<div style='float:left;margin-left:-15px;'>
                        		<label>Optional message to send with demo text</label>
                        		<input style="width:120%;" type='text' name='textRepNote' id='textRepNote' />
                        	</div>
                        	</div>
                  		</form>
                  </div>
                  <div class='clearfix'></div>
                  <h5>Send a Booker a Demo to Bump</h5>
                  <div class='row-fluid'>
                                
                        <div class="span3" >
                           <label><i class='cus-telephone'></i>&nbsp;&nbsp;Select a Booker</label>
                                <select class="dispatch" name="dispatchbump" id="dispatchbump" style="width:70%">
                                    <option value=""></option>
                                    @if(!empty($bookers))
                                    @foreach($bookers as $val2)
                                    <option value="{{$val2->id}}">{{$val2->firstname}} {{$val2->lastname}}</option>
                                    @endforeach
                                    @endif
                                </select>
                        </div>
                        <div class='span3'>
                        	  <label><i class='cus-script'></i>&nbsp;&nbsp;Optional Note</label>
                        	<input class='tooltwo' title='Enter an optional note for the booker to see. IE Bump time, Bump day, etc' style='width:80%;' type="text" name="bumpnotes" id="bumpnotes">
                        </div>
                        <div class='span4'>
                        	<button class="btn btn-default bumpdispatch tooltwo" style="margin-top:23px;margin-left:10px;"  title='Select a Booker to send an appointment to BUMP'>
                                    <i class='cus-arrow-merge'></i>&nbsp;&nbsp;SEND BUMP
                              </button>
                        </div>
                  </div>
                 
 			@endif
                  </div>
            </article>

</div>
   
    <div class="fluid-container" style="margin-top:120px;color:#fff;">
    	 @if(Auth::user()->user_type=="manager")
    	<div class="row-fluid">
    	Filter By Crew : <button class='btn btn-default btn-small filterCrew' data-id='all'>ALL </button>
    	@foreach($roadcrews as $r)
    	<button class='btn btn-default btn-small filterCrew' data-id='{{$r->id}}'>{{$r->crew_name}}</button>
    	@endforeach
    	&nbsp;&nbsp;&nbsp;<a style='color:#ddd;' href='{{URL::to("crew/manage")}}' target=_blank >Click To Create / View Crews</a>
    	</div>
    	<div class="row-fluid theCrew" style="display:none;margin-top:10px;">
    		Dealers in Crew :
    	@foreach($roadcrews as $r)
    		<?php $dealers = $r->members();?>
    		@foreach($dealers as $d)
    		  <span class='crewid-{{$r->id}} crewDealers label label-inverse' style='display:none;'> {{User::find($d->user_id)->fullname()}}</span>
	    	@endforeach
    	@endforeach
    	</div>


    	<div class="row-fluid" style="margin-top:-30px;">
    	<div class="pull-right" style="width:40%;">
    		<div class="span3">
    	<a href="{{URL::to('appointment/backup?appdate=')}}{{$datepass}}">
    		<button class="btn btn-default btn-small" >SAVE HARDCOPY </button></a>
    		</div>
    		<div class="span3">
    		<label>&nbsp; Show Lead Score <input type="checkbox" class="myinput large tooltwo show_lead_scoring" title="Click to show Lead Quality Score based on special algorithm" name="show_scores" id="show_lead_score|1" @if($set->show_lead_score==1) checked="checked" @endif ></label><br/>
    		</div>
    		<div class="span3">
    		<label>&nbsp; Show Extra Details <input type="checkbox" class="myinput large tooltwo show_lead_details" title="Click to show extra details about the leads (Smoke, Pets, Asthma)" name="show_info" id="show_lead_info|1" @if($set->show_lead_info==1) checked="checked" @endif ></label><br/>
    		</div>
    		<div class="span3">
    		<label>&nbsp; Sort NA's into rebooks <input type="checkbox" class="myinput large tooltwo sort_noanswer_check" title="Click to include all NA's left on board into the lead sort, they will become rebooks" name="sort_noanswer" id="sort_noanswer|1" @if($set->sort_noanswer==1) checked="checked" @endif ></label>
    		</div>
    	</div>
    	</div>
    	
    	@endif
        
    	@if(Auth::user()->user_type=="salesrep")
    	@if(empty($appts))
    	<h3>You Have No Appointments Dispatched to You Yet</h3>
    	@else
    	<h3>Your Appointments Today</h3>
    	@endif
    	@endif

    	@if($set->show_lead_info==1)
        <?php $cla="";?>
   			@else
       	 <?php $cla="hidden";?>
    		@endif
            <div class="row-fluid" id="appointments" style="margin-top:18px;" >
            	@if($set->led_ticker == 5)
            	<div class="row-fluid" style="margin-bottom:18px;">
				<canvas style="margin-left:-30px;" class="system-message-ticker"></canvas>
            	</div>
            	@endif
            	<div class="row" id="appointmentRefresh">
    				
        		</div>
            
                <table class="table apptable medShadow lightPaperBack"  id="dtable2">
                    <thead>
                        <tr>
                            <th style="width:1%"></th>
                            <th style="display:none;">SORT</th>
                            <th style="width:4%;"><center>TIME</center></th>
                            @if(Auth::user()->user_type=="agent")
                            <th style="width:4%">STATUS</th>
                             @endif
                            <th style="width:10%;">NAME</th>
                            
                            <th style="width:7%;">NUMBER</th>
                            <th style="width:19%;">ADDRESS</th>
                            <th style="width:6%;" >CITY</th>
                            <th class="tooltwo lead_info {{$cla}}" title="SMOKE">S</th>
            				<th class="tooltwo lead_info {{$cla}} " title="PETS">P</th>
            				<th class="tooltwo lead_info {{$cla}}" title="ASTHMA">A</th>
            				<th class="tooltwo lead_info {{$cla}}" title="RENT / OWN">R/O</th>
            				<th class="tooltwo lead_info {{$cla}}" title="JOB">Job</th>
            				<th class="tooltwo lead_info {{$cla}}" title="FULL TIME / PART TIME">Full/Part</th>
            				<th class="tooltwo lead_info {{$cla}}" title="MARITAL STATUS">Marital</th>
                            <th>Type</th>
                            <th class="tooltwo lead_scores " title="This shows a Lead Quality score out of 100, based on chosen criteria" style="width:4%;" >SCORE </th>
                            <th>Booker</th>
                            <th style="width:4%">Booked</th>
                            <th style="width:4%;">Gift</th>
                            @if(Auth::user()->user_type=="manager")
                            <th style="width:2%;">In</th>
                            <th style="width:2%;">Out</th>
                            <th style="width:12%;">SALES REP</th>
                            <th style="width:4%;">STATUS</th>
                            @endif
                            <th style="width:8%;"></th>
                        </tr>
                    </thead>
                    
                    <tbody>
                @if(!empty($app))
				<?php $highlight = "background:yellow;";?>
				@else 
				<?php $highlight = "";?>
				@endif
				<?php $confirms = array();$dispatches = array();?>
                        @if(!empty($appts))
                        <?php $count = count($appts);?>
                        @foreach($appts as $val)
                        
                        <?php 
                        // Store time, id, and name into array only if time is not past
                        $time_minus = date('H:i:s',strtotime("-55 minutes", strtotime($val->app_time)));
                        $time_plus = date('H:i:s',strtotime($val->app_time));
                        if(date('H:i:s')>=$time_minus && date('H:i:s')<=$time_plus){
                          if($val->status=="APP"){
                          	 $confirms[$val->app_time][] = array("time"=>$val->app_time,"appid"=>$val->id,"leadid"=>$val->lead_id,"custname"=>$val->lead->cust_name);
                          }
                       	}
                       	$time_minus = date('H:i:s',strtotime("-4 minutes", strtotime($val->app_time)));
                        $time_plus = date('H:i:s',strtotime($val->app_time));
                       	if(date('H:i:s')>=$time_minus && date('H:i:s')<=$time_plus){
                          if($val->status=="APP" || $val->status=="CONF" || $val->status=="NA"){
                          	 $dispatches[$val->app_time][] = array("time"=>$val->app_time,"appid"=>$val->id,"leadid"=>$val->lead_id,"custname"=>$val->lead->cust_name);
                          }
                       	}
                        ;?>



                        <?php 
                        $time = strtotime($val->app_time);
                        if($val->lead->app_offset!=0){
                        	if($val->lead->app_offset>0){
                        		$t_o = "-".$val->lead->app_offset." Hours";
                        	} else {
                        	
                        		$t_o = str_replace("-","+",$val->lead->app_offset)." Hours";
                        	}
                        	$offset_time = strtotime($t_o, $time);
                        } else {
                        	$offset_time = 0;
                        }
                        
                        $slot="";$crew="nocrew";

                        if(array_key_exists($val->lead->city,$crewcities)){
                        	$crew = "crewid-".$crewcities[$val->lead->city];
                        }
                        $rb="";
                        if($offset_time!=0){
                        	if(($offset_time>=strtotime($slots[0]['s']))&&($offset_time<=strtotime($slots[0]['f']))){$slot=$slots[0]['selector'];}
					if(($offset_time>=strtotime($slots[1]['s']))&&($offset_time<=strtotime($slots[1]['f']))){$slot=$slots[1]['selector'];}
					if(($offset_time>=strtotime($slots[2]['s']))&&($offset_time<=strtotime($slots[2]['f']))){$slot=$slots[2]['selector'];} 
					if(($offset_time>=strtotime($slots[3]['s']))&&($offset_time<=strtotime($slots[3]['f']))){$slot=$slots[3]['selector'];} 
					if(($offset_time>=strtotime($slots[4]['s']))&&($offset_time<=strtotime($slots[4]['f']))){$slot=$slots[4]['selector'];}  
                        } else {
                        	if(($time>=strtotime($slots[0]['s']))&&($time<=strtotime($slots[0]['f']))){$slot=$slots[0]['selector'];}
					if(($time>=strtotime($slots[1]['s']))&&($time<=strtotime($slots[1]['f']))){$slot=$slots[1]['selector'];}
					if(($time>=strtotime($slots[2]['s']))&&($time<=strtotime($slots[2]['f']))){$slot=$slots[2]['selector'];} 
					if(($time>=strtotime($slots[3]['s']))&&($time<=strtotime($slots[3]['f']))){$slot=$slots[3]['selector'];} 
					if(($time>=strtotime($slots[4]['s']))&&($time<=strtotime($slots[4]['f']))){$slot=$slots[4]['selector'];}  
                        }

				    if($val->status=="DISP"){$label="inverse";$class="";}
                            elseif($val->status=="CONF"){$label = "success";$class="CONF";}
                            elseif($val->status=="SOLD"){$label="warning special black"; $class="";} 
                            elseif($val->status=="CXL"){$label="important";$class="CXL";}
                            elseif($val->status=="NQ"){$label="important special";$class="";}
                            elseif($val->status=="DNS"){$label="important special";$class="";}
                            elseif($val->status=="INC"){$label="warning";$class="";}
                            elseif(($val->status=="RB-TF")||($val->status=="RB-OF")){$label="info special";$class="RB-TF";$rb="isRebook";}
                            elseif($val->status=="NA"){$label="warning black";$class="NA";} elseif($val->status=="BUMP") {$label="bump";$class="";} else {$label="success special"; $class="";}
                            $type="";
                            if($val->lead->original_leadtype=="door"){$type="cus-door";$thetype="Door Reggie";} 
                            else if($val->lead->original_leadtype=="paper"){$type="cus-script";$thetype="Upload/Manilla Survey";} 
                            else if($val->lead->original_leadtype=="survey"){$type="cus-new";$thetype="Fresh Survey";} 
                            else if($val->lead->original_leadtype=="other"){$type="cus-zone-money"; $thetype="Scratch Card";} 
                            else if($val->lead->original_leadtype=="homeshow"){$type="cus-house";$thetype="Home Show";} 
                            else if($val->lead->original_leadtype=="ballot"){$type="cus-ticket";$thetype="Ballot Box";} 
                            else if($val->lead->original_leadtype=="referral"){$type="cus-user";$thetype="Referral";} 
                            else if($val->lead->original_leadtype=="personal"){$type="cus-user";$thetype="Personal Lead";} 
                            else if($val->lead->original_leadtype=="coldcall"){$type="cus-telephone";$thetype="Cold Call";} 
                            else if($val->lead->original_leadtype=="doorknock"){$type="cus-door";$thetype="Door Knock";} 
                            else if($val->lead->original_leadtype=="secondtier"){$type="cus-script";$thetype="Second Tier Survey";} 
                            else {$type="";$thetype="";}
                            
                            if($val->status=="SOLD"){$animation = "animated swing bignum3";}else {$animation="";};
                            if($val->lead->app_date!=$datepass) {$sts="moved";} else {$sts=$val->status;};

                            if($offset_time!=0){
                            	$at = date('H:i:s',$offset_time);
                            } else {
                            	$at = $val->app_time;
                            }
                            ?>
                        <tr class="@if((!empty($app))&&($val->id!=$app)) hide @endif datarow {{$sts}} {{$rb}} {{$at}} {{$slot}} {{$crew}}" id="{{$val->id}}" data-idlink="{{$val->lead_id}}" data-status="{{$val->status}}" style="color:#000;@if($app==$val->id){{$highlight}}@endif  " >
                            <td>
                            	<center>
                            	@if(Auth::user()->user_type=="manager")
                            	@if($val->status!="SOLD")
                            	<a class='tooltwo btn btn-mini btn-inverse delApp' data-type='nosale' style='padding-bottom:1px' title='CLICK TO DELETE APPOINTMENT - CANNOT UNDO!' href="{{URL::to('appointment/delete/')}}{{$val->id}}">{{$count}}</a>
                            	@else
                            	<a class='tooltwo btn btn-mini btn-danger delApp' data-type='hassale' style='padding-bottom:1px' title='CLICK TO DELETE APPOINTMENT - THIS APPOINTMENT HAS A SALE ATTACHED TO IT!' href="{{URL::to('appointment/delete/')}}{{$val->id}}">{{$count}}</a>
                            	@endif
                            	
                            	@else 
                            	{{$count}}
                            	@endif
                            	</center>
                            </td>
                            <?php $count--;?>
                            <td style="display:none;">
                            	 @if($offset_time!=0)
                            	 {{date('g:i a',$offset_time)}}
                            	 @else
                            	 {{date('g:i a', strtotime($val->app_time))}}
                            	 @endif
                            </td>
                            <td>
                                <center>
                                @if($offset_time!=0)
                                <span title='This is the offset / local time of this appointment' class='tooltwo'><b>{{date('g:i a',$offset_time)}}</b></span><br/>
                                <span title='This is the actual appointment time' class='label blackText tooltwo'>{{date('g:i a', strtotime($val->app_time))}}</span>
                                @else
                                @if($val->confirmed!=1)
                                    <b>{{date('g:i a', strtotime($val->app_time))}}</b>
                                @else
                                    <span class="label label-success"><b>{{date('g:i a', strtotime($val->app_time))}}</b></span>
                                @endif
                                @endif
                                </center>
                            </td>
                            @if(Auth::user()->user_type=="agent")
                            <td>
                                <center>
                                    <span class="{{$animation}} label label-{{$label}} status-{{$val->id}}">{{strtoupper($val->status)}}</span>
                                </center>
                            </td>
                            @endif
                            
                            <td> 
                                    <span class="revealDetails tooltwo" style="font-size:12px;" title="Click to view more info..." data-type="lead" data-id="{{$val->lead->id}}">
                                    	<b>
                                    @if(!empty($val->lead->spouse_name))
                                        {{strtoupper($val->lead->cust_name)}} and {{strtoupper($val->lead->spouse_name)}}
                                    @else
                                        {{strtoupper($val->lead->cust_name)}}
                                    @endif
                              	</b>
                              	</span>
                              	@if($val->lead->bump_count!=0)
                                <span class="label label-important round special tooltwo" title="Been bumped {{$val->lead->bump_count}} Times">{{$val->lead->bump_count}}</span>@endif	
                              	@if(!empty($val->lead->notes)) <span class="label label-info round special tooltwo" title="{{$val->lead->notes}}">N</span> @endif 
                              	
                            </td>
                          
                            <td class="span2">

                                <a href='{{$set->fouroneone_url}}{{$val->lead->cust_num}}' title='Click to search number on 411 / White Pages'  class='tooltwo' target=_blank>
                                    <img src='{{URL::to('images/411-icon.png')}}' width=14px>
                                    <span style="font-size:13px;font-weight:bolder;">&nbsp;{{$val->lead->cust_num}}</span>
                                </a>
                            </td>
                            <td class="span4">
                                <span class="viewLargeMap tooltwo"  style="font-size:10px;" title="Click to view this address on a map" style="cursor:pointer;" data-repid="{{$val->rep_id}}" data-rideid="{{$val->ridealong_id}}" data-time="{{date('g:i a', strtotime($val->app_time))}}" data-address="{{$val->lead->address}}" data-lat="{{$val->lead->lat}}" data-lng="{{$val->lead->lng}}" data-name="{{ucfirst($val->lead->cust_name)}}" data-spouse="{{$val->lead->spouse_name}}" data-num="{{$val->lead->cust_num}}" data-book="{{$val->lead->booked_by}}" data-id="{{$val->id}}"><button class='btn btn-default btn-mini ' style='text-align:left;border:1px solid #ccc;border-radius:4px;width:100%;padding:9px;font-size:13px;font-weight:bolder;line-height:18px;'>{{strtoupper($val->lead->address)}}</button></span>
                                </td>
                            <td style="font-size:10px;">
                            	<?php $city  =City::where('cityname','=',$val->lead->city)->first();
                            	if($city){
                            		$city_id = $city->attributes['id'];$cityname=$city->cityname;
                            	} else {
                            		$city_id=0;$cityname=$val->lead->city;
                            	};?>
                                <span class='viewCity' style="font-size:12px;font-weight:bold;" style="cursor:pointer;" data-id='{{$city_id}}' data-cityname="{{$cityname}}">{{strtoupper($val->lead->city)}}</span>
                            </td>
                            <td class="lead_info {{$cla}}"><center>{{$val->lead->smoke}}</center></td>
                            <td class="lead_info {{$cla}}"><center>{{$val->lead->pets}}</center></td>
                            <td class="lead_info {{$cla}}"><center>{{$val->lead->asthma}}</center></td>
                            <td class="lead_info {{$cla}}"><center>
                            @if($val->lead->rentown=="O")
                            Own
                            @else
                            Rent
                            @endif
                            </center></td>
                            <td class="lead_info {{$cla}}"><center>{{strtoupper($val->lead->job)}}</center></td>
                            <td class="lead_info {{$cla}}"><center>{{$val->lead->fullpart}}</center></td>
                            <td class="lead_info {{$cla}}"><center>{{strtoupper($val->lead->married)}}</center></td>
                            <td>
                            	<center>
                            	<i class='{{$type}} tooltwo' title='{{$thetype}}<?php if(($thetype=="Door Reggie")||($thetype=="Referral")) { ;?> - {{$val->lead->researcher_name}}<?php };?>'></i> @if($val->lead->leadtype=="rebook") &nbsp;<i class='cus-arrow-redo tooltwo' title='This lead has been rebooked!'></i>&nbsp; @endif
                            	</center>
                            </td>
                              <td class=" lead_scores">
                            	<?php $score = $val->lead->leadScore();
                            	$lab = "";
                            	if($score>70){
                            		$lab = "green";
                            	} else if($score>40 && $score<70){
                            		$lab = "grey";
                            	} else if($score<40){
                            		$lab = "red";
                            	};?>
                            		<a href='{{URL::to("system/settings")}}' target=_blank><div class="leadScore tooltwo" title="This leads Quality Index is : {{$score}} out of 100  (click to view LQ settings)"  data-value="{{$score}}" data-id="{{$val->lead_id}}" id="leadScore-{{$val->lead_id}}" style="width:68px;height:48px;">
                            		</div></a>
                            </td>
                            @if(Auth::user()->user_type=="manager")
                            <?php $u = User::find($val->booker_id);
                            if($u){$hold= $u->hold();} else {$hold="N/A";};?>
                            <td class="span2">
                            	@if(empty($val->booked_by))<span class='label label-important special'> @else &nbsp;<span class='label label-inverse special'> @endif
                                <span class="editbooker tooltwo" style='cursor:pointer;' title="Click to change the Booker" id="booked_by|{{$val->id}}">{{strtoupper($val->booked_by)}}</span></span>
                                <br/>
                                <span style='font-size:10px;'>Hold % : {{$hold}}</span> 
                            </td>
                            @else
                            <td class="span2">
                                {{strtoupper($val->booked_by)}}
                            </td>
                            @endif
                            <td class="span2" style="font-size:11px;">{{date('M-d g:i a',strtotime($val->booked_at))}}</td>
                            <td><span style="font-size:9px;">{{strtoupper($val->lead->gift)}}</span></td>
                            @if(Auth::user()->user_type=="manager")
                            <td class="edit" id="in|{{$val->id}}">@if($val->in!='00:00:00'){{date('h:i',strtotime($val->in))}}@endif</td>
                            <td class="edit" id="out|{{$val->id}}">@if($val->out!='00:00:00'){{date('h:i',strtotime($val->out))}}@endif</td>
                            <td id="lead-{{$val->id}}"> 

                            	
                            @if((!empty($val->lead->rep))&&(!empty($val->rep_id)))
                            @if(($val->ridealong_id!=0)&&(!empty($val->ridealong)))
                            <img src='{{URL::to('img/ride-along.png')}}'>
                            <span class="badge badge-important special tooltwo" title='Has Ride Along : {{$val->ridealong->firstname}} {{$val->ridealong->lastname}}'>RA</span>
                            @endif

                            <?php $u = User::find($val->rep_id);
                            $limit = 10;//TODO GET FROM SETTINGS
                            $stats = $u->demostats($limit);
                            $statlabel = "";
                            $daysSince = $u->daysSince();
                            if($u){$statlabel.="DAYS SINCE LAST SALE :" .$daysSince['sales']. "&nbsp;&nbsp;&nbsp ||&nbsp;&nbsp;&nbsp Last ".$limit." Dems : SOLD : ".$stats->sold." | DNS : ".$stats->dns." | INC : ".$stats->inc." | RB's : ".$stats->rbs. " | CXL : ".$stats->cxl; } 
                            else {$statlabel.="N/A";};
                            ?>
                            @if(!empty($val->vacuum))
                            <img class='dealerCallout coimg-{{$val->id}} tooltwo animated fadeInUp' title="Click to enter Callout Information" data-id="{{$val->id}}" src='{{URL::to('images/callout-done.png')}}' width=24px height=24px>
                            @else
                              <img class='dealerCallout coimg-{{$val->id}} tooltwo animated fadeInUp' title="Click to enter Callout Information" data-id="{{$val->id}}" src='{{URL::to('images/callout.png')}}' width=24px height=24px>
                            @endif
                            @if(($u)&&(!empty($u->cell_no)))
                            	@if($set->texting)
                             	<img class='salesText tooltwo' title="Click to send this dealer an SMS text message" data-username='{{$u->firstname}} {{$u->lastname}} @ {{$u->cell_no}}' data-type="{{$u->id}}" src='{{URL::to('images/text-rep.png')}}' width=18px height=18px>
                             	@endif
                            @endif



                            @if($val->lead->result=="SOLD")
                            	@if(!empty($val->sale))
                            	
                            	<span title="{{$statlabel}}" class="editsalesrep tooltwo label label-warning special black bignum3" id="rep_id|{{$val->id}}">	{{strtoupper($val->sale->sold_by)}}   </span>  
                            	@endif
                                
                            @elseif($val->lead->result=="DNS")
                                <span title="{{$statlabel}}" class="editsalesrep tooltwo label label-important special bignum3" id="rep_id|{{$val->id}}">	{{strtoupper($val->lead->rep_name)}}   </span> 
                            @elseif($val->lead->result=="DISP")
                                <span title="{{$statlabel}}" class="editsalesrep tooltwo label label-inverse special bignum3" id="rep_id|{{$val->id}}">	{{strtoupper($val->lead->rep_name)}} </span> 
                                <a href="{{URL::to('appointment/return/')}}{{$val->id}}"><br/>Sent:{{date('h:i a', strtotime($val->dispatch_time))}}  <button class="btn btn-mini">Undispatch</button></a>
                            @else
                                <span title="{{$statlabel}}" class='editsalesrep tooltwo' id="rep_id|{{$val->id}}">{{strtoupper($val->lead->rep_name)}}</span>&nbsp;&nbsp;
                            @endif
                            @endif
                            </td>
                            <td>
                                <center>
                                    <span class="{{$animation}} @if($val->status=='DNS') dnsCallbackButton tooltwo @endif label label-{{$label}} status-{{$val->id}}" title="Click to show DNS callbacks" data-id="{{$val->id}}">{{$val->status}}</span>
                                </center>
                            </td>
                            @endif
                            <td>
                                @if($val->lead->app_date!=$datepass)
                                    <span class="label label-info">Moved To {{date('D d',strtotime($val->lead->app_date))}}</span>
                                @else 
                                    
                                        <button class="btn btn-mini btn-primary processappt @if(!empty($val->lead->notes)) tooltwo @endif" title="{{$val->lead->notes}}" data-repid="{{$val->rep_id}}"  data-rideid="{{$val->ridealong_id}}" data-spouse="{{$val->lead->spouse_name}}" data-num="{{$val->lead->cust_num}}" data-address="{{$val->lead->address}}" data-status="{{$val->status}}" data-gift="{{$val->lead->gift}}" data-name="{{$val->lead->cust_name}}" data-time="{{$val->app_time}}" data-id="{{$val->id}}" data-isreferral="{{$val->lead->referral_id}}" data-leadid="{{$val->lead->id}}" data-notes="{{$val->lead->notes}}">
                                            Process
                                        </button>
                                @endif


                                @if(Auth::user()->user_type=="manager")
                                 @if($val->lead->app_date==$datepass)
                                &nbsp;&nbsp;<span class='small'>WD : </span> <input type="checkbox" id="written-{{$val->id}}" data-theid='{{$val->id}}' class='markAppt tooltwo ' title='Click to check off as written down' data-id='written_down|{{$val->id}}' data-themsg="You have marked this appointment as written down"  @if($val->written_down==1) checked='checked' @endif>
                                @endif

                                @if(($val->status=="DISP")||($val->status=="SOLD")||($val->status=="INC")||($val->status=="DNS"))
                                <div class="repbuttons">
                                	@if($val->status!="SOLD")
                                    <button class="btn btn-mini btn-success dispbuttons soldbutton" style="color:#000;font-weight:bolder" data-id="{{$val->id}}">
                                        SOLD
                                    </button>
                                    @endif
                                    @if($val->status!="DNS")
                                    <a href="{{URL::to('appointment/dns/')}}{{$val->id}}-DNS">
                                        <button class="btn btn-mini btn-danger dispbuttons dnsbutton">
                                            DNS
                                        </button>
                                    </a>
                                    @endif
                                    @if($val->status!="INC")
                                        <a href="{{URL::to('appointment/dns/')}}{{$val->id}}-INC">
                                        	<button class="btn btn-mini btn-warning dispbuttons dnsbutton" style='color:#000;'>
                                        		INC
                                        	</button>
                                    	</a>
                                    @endif
                                </div>
                                @endif
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table> 
                
            </div>
    </div>
</div>
<div class="push"></div>
<script src="{{URL::to_asset('js/timepicker.js')}}"></script>
<script src="{{URL::to_asset('js/editable.js')}}"></script>

<script src="{{URL::to_asset('js/include/justgage.min.js')}}"></script>
<script>
$(document).ready(function(){
	function justGage(gval, element){
		var g = new JustGage({
	  	  id: element,
	  	  value: gval,
	  	  showMinMax: false,
	  	  title: "Lead Quality",
	  	  label: "",
	  	  labelFontColor: '#fff',
	  	  valueFontColor: '#000',
    		  levelColorsGradient: true,
    		  showInnerShadow : true,
    		  shadowSize:10,
    		  levelColors: ['#990000','#FF6600','#00FF00'],
	  	});
	}

$('.leadScore').each(function(i,val){
	var theVal = $(this).data('value');
	var theId = $(this).data('id');
	justGage(theVal, 'leadScore-'+theId);
});
});
</script>

@if($set->led_ticker==5)
 <script src="{{URL::to_asset('js/ledticker/jquery.leddisplay.js')}}"></script>
    <script>
    $(document).ready(function(){
    	function initTicker(data){
    		$('.system-message-ticker').html("").html(data);
    		var options = {
			horizontalPixelsCount: 380,
			verticalPixelsCount: 6,
			pixelSize: 6,
			disabledPixelColor: '#3e3e3e',
			enabledPixelColor: 'orange',
			pathToPixelImage: 'pixel.png',
			stepDelay: 26,
			// only for canvas
			backgroundColor: '#202020',

			// only for canvas
			pixelRatio: 0.7,
			runImmidiatly: true
			};
			$('.system-message-ticker').leddisplay($.extend(options, {pixelSize:6}));
    	}
    	//secret : 4a24313bc0982dfb1fcf
    	//key: b3171a17e2d40caedd56
    	//appid: 96002
    	if(localStorage){
    		if(localStorage.getItem("companyWideMessage")){
    			var data = localStorage.getItem("companyWideMessage");
    			initTicker(data);
    		} 
    	}
    	var pusher = new Pusher('b3171a17e2d40caedd56');
    	var channel = pusher.subscribe('ct-channel');
    	channel.bind('my-event', function(data) {
    		if(localStorage){
    			localStorage.setItem("companyWideMessage",data.message);
    		}
    		initTicker(data.message);
	});
    });
    </script>
@endif


@if(!empty($app))

<script>
$(document).ready(function(){

$('tr#'+{{$app}}).show().css('background','yellow');
});
</script>
@endif
<?php
$bookers = User::activeUsers('agent','json');
$reps = User::activeUsers('salesrep','json');

?>

@if($set->confirms==1)
<script>
$(document).ready(function(){
	function timeNow() {
  		var d = new Date(),
  		    h = (d.getHours()<10?'0':'') + d.getHours(),
  		    m = (d.getMinutes()<10?'0':'') + d.getMinutes();
  		    s = '00';
  		    return h + ':' + m + ':' + s;
	}
	var confirms = {{json_encode($confirms)}};
	var dispatches = {{json_encode($dispatches)}};

	function getAlerts(){
		var t = timeNow();
		$.each(confirms,function(i,val){
			var msg="";
			var time = i.split(":");
			if((time[0]-1)<10){
				var front = "0"+(time[0]-1);
			} else {
				var front = time[0]-1;
			}
			var calc_time = front+":"+time[1]+":"+time[2];
			if(t>calc_time && t<i){
				msg+= "( "+val.length+" ) Appts @ "+i+" needs to be confirmed";
				$.each(val, function(j,k){
					msg+= "| "+k.custname+" | ";
				});
				toastr.info(msg,{ timeOut: 14500 });
				/* $.jGrowl(msg+" <br>YOU MUST ASSIGN LEADS BEFORE THIS MESSAGE GOES AWAY!", { 
                    header: 'LEADS REQUESTED', 
                    speed: 4000,
                    theme: 'with-icon',
                    position: 'myposition', //this is default position
                    easing: 'easeOutBack',
                    
                }); */
			}
		});
		$.each(dispatches,function(i,val){
			var msg2="";
			var time = i.split(":");
			if((time[1]-5)<10){
				var mid = "0"+(time[1]-5);
			} else {
				var mid = time[0]-5;
			}
			var calc_time = time[0]+":"+mid+":"+time[2];
			if(t>calc_time && t<i){
				msg2+= "( "+val.length+" ) Appts @ "+i+" has not been dispatched yet";
				$.each(val, function(j,k){
					msg2+= "| "+k.custname+" | ";
				});
				toastr.info(msg2,{ timeOut: 14500 });
			}
		});
	}
	setTimeout(getAlerts,5000);
	setInterval(getAlerts,66000);
});
</script>
@endif


<script>
$(document).ready(function(){

	$('body').css('height','900px');
	
	setInterval(function(){
		$('#appointmentRefresh').load("{{URL::to('appointment/refresh')}}");
	},10000);

	$(document).on('click','.refreshPage',function(){
		$('.ajax-heading').html("Reloading Board...");
		$('.ajaxWait').show();
		$.getJSON("{{URL::to('mobile/acknowledge')}}",function(data){
			if(data=="success"){
				location.reload();
			} else {

			}
		});

		
	});

	$('body').css('background','white');

	 		$('#app_city').change(function(){
        			$('#filterApps').submit();
        		});

        		$('.changedate').change(function(e){
				$('#filterApps').submit();
			});

   	$('.closeProcess').click(function(){
   		$('.processBOX').removeClass('animated slideInLeft').addClass('animated slideOutLeft');$('#savebutton').hide();
   	});

   	$('.dealerStatus-toggle').click(function(){
   		$('.topDateBar').hide();
   		if($(this).data('switch')==0){
   			$(this).data('switch','1');
   			$(this).html("<i class='cus-user'></i>&nbsp;&nbsp;SHOW DEALERS");
   			$('.date-BAR').show();
   		} else {
   			$(this).data('switch','0');
   			$(this).html("<i class='cus-grid'></i>&nbsp;&nbsp;SHOW DAYS");
   			$('.dealer-BAR').show();
   		}
   	});


$(document).on('click','.filterCrew',function(){
	var id = $(this).attr('data-id');
	$('.filterCrew').removeClass('btn-inverse');
	$(this).addClass('btn-inverse');
	$('.crewDealers').hide();

	if(id=="all"){
		$('.datarow').show();
		$('.theCrew').hide();
	} else {
		$('.theCrew').show();
		$('.datarow').hide();
		$('.crewid-'+id).show();
	}
});

if($('.show_lead_scoring').is(':checked')){
	$('.lead_scores').removeClass('hidden');
} else {
	$('.lead_scores').addClass('hidden');
};

$(document).on('click','.show_lead_details',function(){
    if($(this).is(':checked')){
        var val=1;
    } else {
        var val=0;
    }
    $.post('{{URL::to("settings/edit")}}',{field:'show_lead_info',value: val},function(data){
        if(data!="failed"){
            
            if(val==1){
            	var type="Shown";
                $('.lead_info').removeClass('hidden');
            } else {
            	var type = "Hidden";
                $('.lead_info').addClass('hidden');
            }
            toastr.success("Extra Lead Info "+type,"SAVED SETTING");
        }
    });
});

$(document).on('click','.show_lead_scoring',function(){
    if($(this).is(':checked')){
        var val=1;
    } else {
        var val=0;
    }
    $.post('{{URL::to("settings/edit")}}',{field:'show_lead_score',value: val},function(data){
        if(data!="failed"){
            if(val==1){
            	var type="revealed";
                $('.lead_scores').removeClass('hidden');
            } else {
            	var type = "hidden";
                $('.lead_scores').addClass('hidden');
            }
            toastr.success("Lead Quality Score has been "+type,"SAVED SETTING");
        }
    });
});

$(document).on('click','.sort_noanswer_check',function(){
    if($(this).is(':checked')){
        var val=1;
    } else {
        var val=0;
    }
    $.post('{{URL::to("settings/edit")}}',{field:'sort_noanswer',value: val},function(data){
        if(data!="failed"){
            if(val==1){
            	var type="Included";
            } else {
            	var type = "Excluded";
            }
            toastr.success("NA's "+type+" in lead sort","SAVED SETTING");
        }
    });
});

$(document).on('click','.markAppt',function(){
		var id = $(this).data('id');
		var therow = $(this).data('theid');
		var msg = $(this).data('themsg');

		t = $(this);
		if($(this).is(":checked")){
			var value=1;
		} else {
			var value=0;
		}
		
		$.get('{{URL::to("appointment/edit")}}',{id:id,value:value},function(data){
		if(data) {
			if(value==1){
				toastr.success(msg,'APPOINTMENT UPDATED!');
			} else {
				toastr.success('','APPOINTMENT UPDATED!');
			
			}
		};
		});

	});




function highlightRow(id){
var marker2 = $("#leftmap").gmap3({
    get: {
        name:"marker",
        id: id
      }
});
return marker2;
}


function getMap(start,end,slot,date,city){
	window.scrollTo(0,0);

	$.getJSON('{{URL::to("appointment/viewdemomap")}}',{start:start,end:end,date:date,city:city},function(data){
			if(data=="nodata"){
				toastr.error("No data to show!","NO APPOINTMENTS FOR THIS SLOT!");
			} else {
				$('.demoTable').addClass('animated slideInLeft');
				$('.filterTime').removeClass('btn-inverse');
      			$('.filterTime').removeClass('btn-inverse');
      			$('.slotbutton-'+slot).addClass('btn-inverse');
      			$('.apptable').hide();
      			
      			$('.datarow').hide();
      			if(slot=="all"){
      				$('tr').show();
      			} else {
      				$('.'+slot).show();
      			}
      			$('.apptable').show();
      			$('.demoTable').show();
				$('#leftmap').gmap3('destroy');
				$('#leftmap').css('background','white').html("<img src='{{URL::to('img/loaders/misc/300.gif')}}' style='margin-left:800px;margin-top:300px;'>");
				var theCenterOfMap = new google.maps.LatLng({{$set->lat}},{{$set->lng}});

				setTimeout(function(){
					$("#leftmap").gmap3({
					  	map:{
					    		options:{
					      		zoom: 8, 
					      		mapTypeId: google.maps.MapTypeId.SATELLITE, 
					      		streetViewControl: true, 
					      		center: theCenterOfMap
					    		}
					  	},
					  	marker:{
							values:data,
							options:{
					      		draggable: false
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
					        			$('.maprow').removeClass('highlight');
					        			$('.leadid-'+context.id).addClass('highlight');
					      		},
					     		 	mouseout: function(){
					        			var infowindow = $(this).gmap3({get:{name:"infowindow"}});
					        			if (infowindow){
					          				infowindow.close();
					        			}
					      		},click:function(marker,event,context){
					      			id = context.id;
									type = "invoice";
									url='{{URL::to("lead/leadinfo/")}}';
									$('.infoHover').hide();
						 			$('.'+type+'InfoHover').addClass('animated fadeInUp').load(url+id).show();
					      		}
					    		}
					  	},autofit:{}
					});
				},450);
				$('#leadview').show();
			}
		});
$('#leftmap').gmap3('get').setCenter(theCenterOfMap);

}

$('.delApp').click(function(e){
	e.preventDefault();
	var link = $(this).attr('href');
	var type = $(this).data('type');
	if(type=="hassale"){
		var t = confirm("THIS APPOINTMENT HAS A SALE ATTACHED!  If you delete it, the sale will be deleted as well! Are you Sure???");
	} else {
		var t = confirm("Are you sure you want to delete this appointment??");
	}
	if(t){
		location.replace(link);
	} 
});
	
$('.rightawayedit').editable('{{URL::to("cities/edit")}}',{
 	   indicator : 'Saving...',
         tooltip   : 'Click to edit...',
         submit  : 'OK',
         width:'40',
         height:'15'
});

	$('.viewDemoMap').click(function(){
		var start = $(this).data('start');
		var end = $(this).data('end');
		var slot = $(this).data('slot');
		var date = $('#pageheader').data('date');
		var city = $('#app_city').val();
		getMap(start,end,slot,date,city);
	});





	$('.viewDemoMap').click(function(){
		var start = $(this).data('start');
		var end = $(this).data('end');
		var slot = $(this).data('slot');
		var date = $('#pageheader').data('date');
		var city = $('#app_city').val();
		getMap(start,end,slot,date,city);
	});

$('.repdispatch').click(function(e){
	e.preventDefault();
	var sel = $('select#rep').find('option:selected');
    var extra = sel.data('machine');

      @if($set->need_machine==1)
	if(extra==false){
		 alert("You Need to Assign Equipment to this Rep, before being able to dispatch an appointment to them");    
	} else {
		$('.ajax-heading').html("Dispatching Appointment...")
		$('.ajaxWait').show();
		$('#dispatchtorep').submit();
	}
	@else
		$('.ajax-heading').html("Dispatching Appointment...")
		$('.ajaxWait').show();
		$('#dispatchtorep').submit();
	@endif
});

$('.repdispatchFromMap').click(function(e){
	e.preventDefault();
	var sel = $('select#repFromMap').find('option:selected');
	console.log(sel);
    var extra = sel.data('machine');

/*      @if($set->need_machine==1)
	if(extra==false){
		 alert("You Need to Assign Equipment to this Rep, before being able to dispatch an appointment to them");    
	} else {
		$('.ajax-heading').html("Dispatching Appointment...")
		$('.ajaxWait').show();
		$('#dispatchtorepFromMap').submit();
	}
	@else
		$('.ajax-heading').html("Dispatching Appointment...")
		$('.ajaxWait').show();
		$('#dispatchtorepFromMap').submit();
	@endif*/
});


@if($set->need_machine==1)
$('select#rep').change(function(){
       var selected = $(this).find('option:selected');
       var extra = selected.data('machine');
       if(extra==false){
       	   alert("You Need to Assign Equipment to this Rep, before being able to dispatch an appointment to them");    
       }
 });
@endif

	$('.checkAll').on('click', function () {
        	$(this).closest('fieldset').find(':checkbox').prop('checked', this.checked);
    	});



$('.salesText').click(function(){
	$('#reptext-id').val("");
	$('#text-message').val("");
	var type = $(this).data('type');
	var username = $(this).data('username');
	if(type=="all"){	
		$('.allReps').show();
		$('#rep-text-heading').html('Selected Reps');
	} else {
		$('.allReps').hide();
		$('#reptext-id').val(type);
		$('#rep-text-heading').html(username);
	}
	$('#salestext_modal').modal({backdrop: 'static'});
});


$('.dealerCallout').click(function(){
	var id=$(this).data('id');
	$('#dealercallout_modal').modal({backdrop: 'static'});
	$('#closingCallout').load("{{URL::to('appointment/callout/')}}"+id);
});

$('.dnsCallbackButton').click(function(){	
	var id = $(this).data('id');
	$('.dnscallbackRow').removeClass('dnshighlight');
	if(id){
		$('#dnscallback-'+id).addClass('dnshighlight');
	}
	$('#dnscallback_modal').modal({backdrop: 'static'});
	
});


$('.sendText').click(function(){
	var msg = $('#text-message').val();
	$('#side-map').html("");
	var img = $('#url-sms-image').val();
	
	$('#side-map').html("<div style='margin-left:20px;'><h4>Results of SMS Send :</h4><span class 'small'>"+msg+"</span><br/><br/></div>");
	if((msg!="")&&(msg.length>6)){
		
		if($('#reptext-id').val().length>0){
			sendaText(msg,$('#reptext-id').val(),true,img);
			$('#salestext_modal').modal('hide');
		} else {
			var c=0;
			$('.rep-text').each(function(i,val){
				if($(this).is(':checked')){
					sendaText(msg,$(this).val(),false,img);
					c=1;
				}
			});
			if(c==1){
			setTimeout(function(){
				$('#sideMap').show(400);
			},800);
			$('#salestext_modal').modal('hide');
			} else {
				alert('You didnt select any reps to send to!! Please try again');
			}
		}
	} else {
		alert('You forgot to enter a message....\nOr your message is less than 10 characters long.\n\n Please enter proper message before sending text');
	}
	});

function sendaText(msg,id,toast,img){
	$.getJSON('{{URL::to("util/sendtext")}}',{msg:msg,id:id,image:img},function(data){
		if(data.status==="success"){
			if(toast==true){ toastr.success(data.msg, data.msg2);}
			$('#side-map').append("<span class='label label-success leftMessage' ><span class='label label-success special'>SUCCESS</span> : "+data.msg+"</span>");
		} else if(data.status==="failed") {
			
			if(toast==true){ toastr.error(data.msg, data.msg2);}
			$('#side-map').append("<span class='label label-important leftMessage'><span class='label label-important special'>FAILED</span> : "+data.msg+"</span>");
		}
	});
}


$('.rep-text').change(function(){
	var id = $(this).val();
	var chk; var str;
	if($(this).is(':checked')){
		chk=1;
		str="Added user to texting list";
	} else {
		chk=0;
		str="Removed user from texting list";
	}
	$.getJSON('../users/enabletext/'+id,{chk:chk},function(data){

		if(data=="success") toastr.success(str,"Settings Saved");
	});
});

$('.edit').editable('../appointment/edit',{
 indicator : 'Saving...',
         tooltip   : 'Click to edit...',
         submit  : 'OK',
         placeholder: '....',
         width     : '100',
      	 height    : '25',
      	 callback : function(value, settings) {
    	    $('.infoHover').hide();
			$('.repstatus-allReps').load('{{URL::to("appointment/dealerstatus")}}');
    	}
});

$('.editbooker').editable('../appointment/edit',{
		data : '{{$bookers}}',
		type:'select',
		submit:'OK',
    	indicator : 'Saving...',
	});


$('.editsalesrep').editable('../appointment/edit',{
		data : '{{$reps}}',
		type:'select',
		submit:'OK',
    	indicator : 'Saving...'
    	
	});




$("#timein, #timeout, #booktimepicker, #callbacktime, #bumptoday").timePicker({
  startTime: "10:00", 
  endTime: new Date(0, 0, 0, 23, 30, 0), 
  show24Hours: false,
  step: 15});
   
        $('#dtable2').dataTable({
            // define table layout
            "sDom" : "<'row-fluid dt-header'<'span6'f><'span6 hidden-phone'T>r>t<'row-fluid dt-footer'<'span6 visible-desktop'i><'span6'p>>",
            // add paging 
            "sPaginationType" : "bootstrap",
            "oLanguage" : {
                "sLengthMenu" : "Showing: 25",
                "sSearch": "" 
            },
            "aaSorting": [[1,'desc']],
            "aLengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "All"]],
            "iDisplayLength":500,
            "oTableTools": {
            "aButtons": [
                
                "print",
               
            ]
        }
        }); 


$('.timepick').change(function(){
var id = $(this).data('id');
var value = $(this).val();
var url = "{{URL::to('appointment/edit')}}";
 $.ajax({
        type: "POST",
        url: url,
        data: {id:id,value:value},
            success: function(data) {
            toastr.success('Appointment IN/OUT value has been updated successfully!', 'SUCCESSFUL UPDATE');
            }
    }); 
});


$('.soldbutton').click(function(){
	var id=$(this).data('id');
	$('#processsale').show().addClass('animated slideInLeft');
	$('#processsale').load("../appointment/getsaleinfo/"+id);
});



$('.processappt').click(function(){
	var lead_id = $(this).data('leadid');
	var is_referral = $(this).data('isreferral');
	$('.referralInfo').hide();
	if(is_referral!=0){
		$.getJSON("{{URL::to('lead/getreferral/')}}"+lead_id,function(data){
		var html="";
		if(data!="failed"){
			var lead = data.lead;
			html+="<a href='{{URL::to('lead/newlead/')}}"+lead.cust_num+"' target=_blank>"+lead.cust_name+"<br>Phone : "+lead.cust_num+"<br/>Address : "+lead.address+"<br/><button class='btn btn-default btn-mini'>VIEW LEAD</button></a><br/>";
			var sale = data.sale;
			var app = data.app;
			console.log(app);
			if(sale.typeofsale!=undefined){
				html+="<br/>Sold :"+sale.date+" | "+sale.typeofsale+" | Price : $"+sale.price;
			}
			if(app.callout_notes!=undefined){
				html+="<br/>Call Out Notes :<br/>"+app.callout_notes;
			}
			$('.referralInfo').html("<h4>Referred By :</h4>"+html).show();
		} 
		});
	}
	
var time = $(this).data('time');
var address= $(this).data('address');
var num = $(this).data('num');
var notes = $(this).data('notes');
var spouse = $(this).data('spouse');
var gift = $(this).data('gift');
var id=$(this).data('id');
var name =  $(this).data('name');
var status = $(this).data('status');
var repid=$(this).data('repid');
var rideid=$(this).data('rideid');
$('#rep option[value="'+repid+'"]').attr('selected', 'selected');
$('#ridealong option[value="'+rideid+'"]').attr('selected', 'selected');
$('.processBOX').hide().removeClass('animated slideOutLeft');
$('#processhead').html("Update "+name+"'s Appointment for "+time+"");
$('#idnum').val(id);
$('#dispid').val(id);
$('#theid').val(id);
$('#custnum').html(num);
$('span.thegift').html(gift);
$('span.thespouse').html(spouse);
$('span.address').html(address);
$('#result').val(status);
$('#notes').val(notes);
$('.processBOX').show().addClass('animated slideInLeft');
$("#map2").gmap3({
    	getlatlng: {
        address: address,
        callback: function(result){
            if(result) {
                var i = 0;
                $.each(result[0].geometry.location, function(index, value) {
                    if(i == 0) { lat = value; }
                    if(i == 1) { lng = value; }
                    i++;
                });
                $("#map2").gmap3({
                   	marker: {
                        address: address,
                        options: {
                            draggable: false,
                            icon:new google.maps.MarkerImage("../img/pure-op.png"),
                            optimized: false,
                            animation: google.maps.Animation.DROP
                        }
                    },
                    map:{
                        options:{
                            center:new google.maps.LatLng(lat, lng),
                            zoom: 13
                        }
                    },
                   
                });

            }
        }
    }
});
});

$('#notes').focus(function(){
	if($('#bumptoday').val().length<=0){
		$('#savebutton').show(500);

	} else {
		$('#savebutton').hide(500);
	}
});

$('#bumptoday').focus(function(){
		$('#savebutton').hide(500);
});

$('.process').click(function(){
	$('#savebutton').show(500);
	var stat = $(this).data('status');
	$('#result').val(stat);
	$('.dateandtime').hide();
	if($(this).hasClass('Rebook')){
	$('.dateandtime').show(200);
	}
});

$(document).on('click','.viewLargeMap',function(){
	window.scrollTo(0,0);
	var status = $(this).data('status');
	var lat = $(this).data('lat');
	var lng = $(this).data('lng');
	var name = $(this).data('name');
	var time = $(this).data('time');
	var address = $(this).data('address');
	var id = $(this).data('id');
	var repid = $(this).data('repid');
	var rideid = $(this).data('rideid');

	if(repid==0 && rideid==0){
		$('#dispatchFromMap').show();
	} else {
		$('#dispatchFromMap').hide();
	}
	
	$('#repFromMap option[value="'+repid+'"]').attr('selected', 'selected');
	$('#ridealongFromMap option[value="'+rideid+'"]').attr('selected', 'selected');
	$('#processheadFromMap').html("Dispatch "+name+"'s Appointment<br/> "+time+"");
	$('#dispidFromMap').val(id);
	

	$('#leadview').show(200);
	$('#leftmap').gmap3('destroy');
	$('#rightmap').gmap3('destroy');
	$('#rightmap').css('background','white').html("<center><img src='{{URL::to_asset('img/loaders/misc/66.gif')}}' style='width:70px;margin-top:400px;'><br><br><br/><span style='color:#3e3e3e;'>Loading Google Map ...</span></center>");
	$('#leftmap').css('background','white').html("<center><img src='{{URL::to_asset('img/loaders/misc/66.gif')}}' style='width:70px;margin-top:400px;'><br><br><br/><span style='color:#3e3e3e;'>Loading Street View ...</span></center>");
	setTimeout(function(){
		$("#rightmap").gmap3({
    		getlatlng: {
        		address: address,
        		callback: function(result){
            		if(result) {
                		var i = 0;
                		$.each(result[0].geometry.location, function(index, value) {
                 		  if(i == 0) { lat = value; }
                 		  if(i == 1) { lng = value; }
                 		  i++;
           			});
           	
                			$("#rightmap").gmap3({
                 			 	marker: {
                 			      address: address,
                 			      	options: {
                 			      	    draggable: false,
                 			      	    icon:new google.maps.MarkerImage("{{URL::to('img/pure-op.png')}}"),
                 			      	    optimized: false,
                 			      	    animation: google.maps.Animation.DROP
                 			      	}
                 			  	},
                 			 	map:{
                 			      	options:{
                 			      		zoom: 17, 
								mapTypeId: google.maps.MapTypeId.{{$set->default_map}}, 
								streetViewControl: true, 
                 			            	center:new google.maps.LatLng(lat, lng),
                 			      	}
                 			  	},
                 			  	streetviewpanorama:{
							options:{
							 	container: $('#leftmap'),
							 	opts:{
							   		position: new google.maps.LatLng(lat, lng),
							   		pov: {
							     			heading: 33,
							     			pitch: 1,
							     			zoom:-3 
							   		}
							 	}
							}
						},
                			});
            		}
        		}
    		}
		});
	},300);
});



$('.repstatus-allReps').load('{{URL::to("appointment/dealerstatus")}}');
		
$('body').on('click','.bumpTodayDispatch',function(e){
	e.preventDefault();
	var id = $('#theid').val();
	var time = $('#bumptoday').val();
	var notes = $('#notes').val();
	var url = "{{URL::to('appointment/bumptime')}}";
	$.post(url,{bumptoday:time,theid:id,notes:notes},function(data){
		if(data=="success"){
			location.reload();
		} else {
			toastr.error("FAILED TO SAVE! Contact System Administrator");
		}
	});
});

$('body').on('click','.bumpdispatch', function(){
	var id = $('#idnum').val();
    var rep=$('#dispatchbump').val();
    var notes = $('#bumpnotes').val();

    var url = "{{URL::to('appointment/bump')}}";
    if(rep.length>0){
        $.ajax({
        type: "POST",
        url: url,
        data: {id:id,rep:rep,notes:notes},
            success: function(data) {
            var d = JSON.parse(data);
            $('.status-'+id).removeClass().addClass('label label-bump').html(d.status);
            $('td#lead-'+id).parent().addClass(d.status);

            $('.processBOX').removeClass('slideInLeft').addClass('slideOutLeft');
            toastr.success('BUMP NOTIFICATION SENT TO BOOKER', '');
            }
    }); 
    } else {toastr.warning('You must select a rep to dispatch to!', 'Dispatch Failed!');}
});


function showavailable(){
    $('.moved').hide();
    $('.CXL').hide();
    $('.RB-TF').hide();
    $('.RB-OF').hide();
    $('.SOLD').hide();
    $('.INC').hide();
    $('.NQ').hide();
    $('.DNS').hide();
}

function showall(){
    $('.moved').show();
    $('.CXL').show();
    $('.RB-TF').show();
    $('.RB-OF').show();
    $('.SOLD').show();
    $('.INC').show();
    $('.NQ').show();
    $('.DNS').show();
}

function checkAvail(){
	if($('.showavailable').is(':checked')){
		return true;
	} else {
		return false;
	}
}

function filterAPP(type){
	$('.apptable').hide();
    $('.datarow').hide();
		$('.filterTime').each(function(i,val){
			
		if($(this).hasClass('btn-inverse')){
			slot = $(this).data('slot');
			start = $(this).data('start');
			end = $(this).data('end');
			date = $('#pageheader').data('date');
			city = $('#app_city').val();

      		if(slot=="all"){
      			$('tr').show();
      			if(checkAvail()==true){
      				showavailable();
      			} else {
      				showall();
      			};
      		} else if(slot=="rebooks"){
      			$('tr.isRebook').show();

      		} else {
      			if(checkAvail()==true){
      				$('.'+slot).show();
      				showavailable();
      			} else {
      				$('.'+slot).show();
      			};
      		}
      		$('.apptable').addClass('animated fadeInUp').show();
		}
	});
		if($("#leftmap").is(":visible")){
			getMap(start,end,slot,date,city);
		};
}

$('.showavailable').click(function(){
	filterAPP();
});

$('.filterTime').click(function(){
	var slot = $(this).data('slot');
	if($('#combineFilter').is(':checked')){
		if(slot=="all"){
			$('.filterTime').removeClass('btn-inverse');
			$(this).addClass('btn-inverse');
		} else {
			$('.slotbutton-all').removeClass('btn-inverse');
			if($(this).hasClass('btn-inverse')){
				$(this).removeClass('btn-inverse');
			} else {
				$(this).addClass('btn-inverse');
			}
		}
	} else {
		$('.filterTime').removeClass('btn-inverse');
		$(this).addClass('btn-inverse');
	}
	
	
    filterAPP();
});




});
</script>
@endsection