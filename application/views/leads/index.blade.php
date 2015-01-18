@layout('layouts/main')
@section('content')
<?php
$settings = Setting::find(1);
function stringFilter($string){
	$string= stripslashes($string);
	$string = str_replace(' ' ,'-',$string); 
	$string =str_replace('/','',$string);
	$string = str_replace('.','',$string);
	return  $string;
}
;?>
<script>
	function showUploadForm(){
		$("#leadbatchupload")[0].reset();
		$('#leadbatch').toggle(400);
	}
</script>

<style>

.countcolor-0 {
	background:#eee!important;
	font-weight:bolder;
	color:#006600;
	
}
.countcolor-1{
	color:#000;
	background:#999999!important;
}

.countcolor-2{
	background:#636363!important;
}
.countcolor-3{
	background:#454545!important;
}

.countcolor-4{
	background:#222222!important;
}
.countcolor-5{
	background:#141414!important;
}




.activelead { }
.unassignleads {cursor:pointer;}
.inactivelead {display:none;}
#assignleads {display:none;}
#bookerleads{display:none;}
.leadrow{cursor:pointer;}
#release{display:none;}
.sendleads{cursor:pointer;border:3px solid #1f1f1f;padding:6px;font-size:14px;border-radius:7px;}
.sendleads:hover{background: #9dd53a;
background: -moz-linear-gradient(top,  #9dd53a 0%, #a1d54f 50%, #80c217 51%, #7cbc0a 100%);
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#9dd53a), color-stop(50%,#a1d54f), color-stop(51%,#80c217), color-stop(100%,#7cbc0a)); 
background: -webkit-linear-gradient(top,  #9dd53a 0%,#a1d54f 50%,#80c217 51%,#7cbc0a 100%);
background: -o-linear-gradient(top,  #9dd53a 0%,#a1d54f 50%,#80c217 51%,#7cbc0a 100%); 
background: -ms-linear-gradient(top,  #9dd53a 0%,#a1d54f 50%,#80c217 51%,#7cbc0a 100%); 
background: linear-gradient(to bottom,  #9dd53a 0%,#a1d54f 50%,#80c217 51%,#7cbc0a 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#9dd53a', endColorstr='#7cbc0a',GradientType=0 ); 
color:#000;}

.surveyLeads:hover {
	background:blue!important;
}
td select{width:65%!important;margin-right:10px;}
.unreleased{background: #1e5799; /* Old browsers */
background: -moz-linear-gradient(top,  #1e5799 0%, #2989d8 50%, #207cca 51%, #7db9e8 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#1e5799), color-stop(50%,#2989d8), color-stop(51%,#207cca), color-stop(100%,#7db9e8)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #1e5799 0%,#2989d8 50%,#207cca 51%,#7db9e8 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #1e5799 0%,#2989d8 50%,#207cca 51%,#7db9e8 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #1e5799 0%,#2989d8 50%,#207cca 51%,#7db9e8 100%); /* IE10+ */
background: linear-gradient(to bottom,  #1e5799 0%,#2989d8 50%,#207cca 51%,#7db9e8 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#1e5799', endColorstr='#7db9e8',GradientType=0 ); /* IE6-9 */
color:#fff!important;font-size:13px;border:1px solid #1f1f1f;}

.unreleased:hover {
background: #b7deed; /* Old browsers */
background: -moz-linear-gradient(top,  #b7deed 0%, #71ceef 50%, #21b4e2 51%, #b7deed 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#b7deed), color-stop(50%,#71ceef), color-stop(51%,#21b4e2), color-stop(100%,#b7deed)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #b7deed 0%,#71ceef 50%,#21b4e2 51%,#b7deed 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #b7deed 0%,#71ceef 50%,#21b4e2 51%,#b7deed 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #b7deed 0%,#71ceef 50%,#21b4e2 51%,#b7deed 100%); /* IE10+ */
background: linear-gradient(to bottom,  #b7deed 0%,#71ceef 50%,#21b4e2 51%,#b7deed 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#b7deed', endColorstr='#b7deed',GradientType=0 ); /* IE6-9 */
color:#000!important;cursor:pointer;}
.leadTable {display:none;}
.leadtable {margin-top:10px;border:1px solid #bbb;}
.leadtable th{font-size:11px;text-align:center;background:#eee;color:#000!important;border:1px solid #bbb;}
.leadtable td {border:1px solid #bbb;padding:7px;}
.leadMessage{display:none;}

#xlsSortable {
	list-style:none;
	padding:15px;
	border:1px solid #ddd;
	float:left;
	margin-left:-10px;
	width:100%;
}
#xlsSortable li {
	float:left;
	cursor:pointer;
	font-size:13px;
	margin-left:5px;
	font-weight:bolder;
	padding:5px;
	background:#ddd;
	text-align:center;
	border:1px solid #aaa;
	border-radius:5px;

}

#xlsColumnChoices {
	list-style:none;
	padding:15px;
	border:1px solid #ddd;
	float:left;
	width:100%;
	margin-left:-10px;
}
#xlsColumnChoices li {
	float:left;
	cursor:pointer;
	margin-left:5px;
	padding:2px;
	font-size:13px;
	background:#1f1f1f;
    color:#fff;
	text-align:center;
	border:1px solid #aaa;
	border-radius:5px;
}
</style>

<div class="row-fluid darkerPaperBack" style="padding-top:10px;padding-bottom:500px;">
	
	<div class="row-fluid" id="leadbatch" style="display:none;" >
	    <article class="span12">
			<div class="jarviswidget medShadow black " data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false">
				<header>
					<h2>UPLOAD BATCH OF LEADS</h2>                           
				</header>
				<div>
					<div class="inner-spacer" style="padding:10px;"> 
						<form class="form-horizontal themed" enctype="multipart/form-data" id="leadbatchupload" method="post"  action="{{URL::to('lead/batchload/preview')}}">
							<fieldset>
							<input type="hidden" id="xlsColumnOrder" name="xlsColumnOrder" value=""/>
							
							<div class="row-fluid">
								<h5 style='color:red;margin-left:10px;'>XLS Files should optimally be no more than 350 lines. Please Break up your files, if you are loading lots of leads.<br/>
							</h5>
							@if($settings->shortcode=="foxv" || $settings->shortcode=="cyclo" || $settings->shortcode=="mdhealth" || $settings->shortcode=="mdhealth2" || $settings->shortcode=="ribmount" || $settings->shortcode=="pureair"  || $settings->shortcode=="triad")	
							<?php $hideform = "hide";?>
							@else
							<?php $hideform = "";?>
							@endif	
							<div class="control-group {{$hideform}}" >
									<label class="control-label"> Select the Researcher</label>
									<select id="researcher" name="researcher">
										<option value=""></option>
										@foreach($researchers as $val)
										<option value="{{$val->id}}">{{$val->firstname}} {{$val->lastname}}</option>
										@endforeach
									</select>
							</div>


								<div class="animated fadeInUp control-group cityUpload" >
									<label class="control-label ">Select a City for these Leads</label>
									<div class="controls">
										
										<?php $cities = City::where('status','=','active')->order_by('cityname')->get();?>
										
										<select name="leadcity" id="leadcity" >
											<option value=""></option>
											@foreach($cities as $c)
											<option value="{{$c->cityname}}">{{$c->cityname}}</option>
											@endforeach
										</select>

									</div>
									<div class="controls">
										<span class="redText">
											@if($settings->shortcode!="foxv" && $settings->shortcode!="mdhealth" && $settings->shortcode!="cyclo" && $settings->shortcode=="mdhealth2" && $settings->shortcode!="ribmount" && $settings->shortcode!="pureair" && $settings->shortcode!="triad")
											If you leave this empty, the system will organize the leads by QUADRANTS. If no Quadrant is found, it will go under 'No Assigned City'
											@else
											If you leave the city option empty, the system will create the cities automatically based on whats in the City column in the XLS file.<br/>  If the City doesn't exist in the system. It will be automatically created.<br/>
											@endif
										
										</span>
									</div>
									
								</div>

								
								<div class="control-group {{$hideform}}"  >
									<label class="control-label ">Select the Date the Survey Was Done On</label>
									<div class="controls">
                                    <div class="input-append date" id="datepicker-js" data-date="{{date('Y-m-d')}}" data-date-format="yyyy-mm-dd">                                 
                                     <input class="datepicker-input" size="16" id="survey_date" name="survey_date" type="text" value="{{date('Y-m-d')}}" placeholder="Select a date" />                                  
                                     <span class="add-on"><i class="cus-calendar-2"></i></span>                              
                                 	</div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label " for="csvfile">File input</label>
									<p>Please input only an .xls file</p>
									<div class="controls">
										<input class="file" id="csvfile" name="csvfile" type="file" />
									</div>
								</div>
								<div class="control-group">
									<div class="span12">
								<h4><span class='smallText redText'>You don't need to do anything here, if you haven't changed the format of your XLS files</span></h4>
								<h4 style="margin-left:20px;">The Order Of Your XLS Columns <br/>
									<span class='smallText'>(if you want to skip a column use the 'Skip / Empty' column placeholder)</span>
									<br/>
									
								</h4>
								<div class="span11">
									
									
									<ul id="xlsSortable" >
  										<img src="{{URL::to('img/loaders/misc/66.gif')}}">
									</ul>
									
								</div>

								<div class="span11">
									<h4>Column Choices... <span class='smallText'>(click to activate the desired column)</span></h4>
									<ul id="xlsColumnChoices">
										<li class="ui-state-default xlsColumnChoice" data-id="CustomerName">First / Full Name</li>
  										<li class="ui-state-default xlsColumnChoice" data-id="OptionalLastName">Last Name</li>
  										<li class="ui-state-default xlsColumnChoice" data-id="spouse_name">Spouse Name</li>
  										<li class="ui-state-default xlsColumnChoice" data-id="cust_num">Phone Number</li>
  										<li class="ui-state-default xlsColumnChoice" data-id="address">Address</li>
  										<li class="ui-state-default xlsColumnChoice" data-id="city">City</li>
  										<li class="ui-state-default xlsColumnChoice" data-id="province">State / Province</li>
  										<li class="ui-state-default xlsColumnChoice" data-id="postalcode">Zip / Postal Code</li>
  										<li class="ui-state-default xlsColumnChoice" data-id="smoke">Smoke</li>
  										<li class="ui-state-default xlsColumnChoice" data-id="pets">Pets</li>
  										<li class="ui-state-default xlsColumnChoice" data-id="asthma">Asthma</li>
  										<li class="ui-state-default xlsColumnChoice" data-id="married">Marital Status</li>
  										<li class="ui-state-default xlsColumnChoice" data-id="sex">Gender</li>
  										<li class="ui-state-default xlsColumnChoice" data-id="rentown">Rent / Own</li>
  										<li class="ui-state-default xlsColumnChoice" data-id="yrs">Years</li>
  										<li class="ui-state-default xlsColumnChoice" data-id="fullpart">Full / Part Time</li>
  										<li class="ui-state-default xlsColumnChoice" data-id="jobyrs">Job Yrs</li>
  										<li class="ui-state-default xlsColumnChoice" data-id="income">Income</li>
  										<li class="ui-state-default xlsColumnChoice" data-id="age_range">Age Range</li>
  										<li class="ui-state-default xlsColumnChoice" data-id="job">Occupation</li>
  										<li class="ui-state-default xlsColumnChoice" data-id="lat">Latitude</li>
  										<li class="ui-state-default xlsColumnChoice" data-id="lng">Longitude</li>
  										<li class="ui-state-default xlsColumnChoice" data-id="notes">Notes</li>
  										<li class="ui-state-default xlsColumnChoice" data-id="skipempty-0">Skip / Empty</li>
  										<li class="ui-state-default xlsColumnChoice" data-id="skipempty-1">Skip / Empty</li>
  										<li class="ui-state-default xlsColumnChoice" data-id="skipempty-2">Skip / Empty</li>
  										<li class="ui-state-default xlsColumnChoice" data-id="skipempty-3">Skip / Empty</li>
  										<li class="ui-state-default xlsColumnChoice" data-id="skipempty-4">Skip / Empty</li>
  										<li class="ui-state-default xlsColumnChoice" data-id="skipempty-5">Skip / Empty</li>
  										<li class="ui-state-default xlsColumnChoice" data-id="skipempty-6">Skip / Empty</li>
									</ul>
									<span class='smallText'><b>DRAG</b> to re-order<br/>
										<b>Right Click</b> to Remove a Column<br/>
										<b>Left-Click</b> Black Columns, to add them to your columns
									</span>
								</div>
							</div>

								</div>
								
								<div class="form-actions">
									<button class="btn medium btn-purps uploadButton tooltwo blackText" title="Upload your file for previewing" ><i class='cus-doc-excel-csv'></i><i class='cus-eye'></i>&nbsp;PREVIEW</button>&nbsp;
									<a href="#" class="btn medium btn-danger" id="enable-select-demo" onclick="$('#leadbatch').fadeOut(200);">
										CANCEL
									</a>
								</div>
							</fieldset>
						</form>
					</div>
				</div>
			</div>
		</article>
	</div>


	<div class="span9">
        <h1 id="page-header" style="color:#000">
           	<img src='{{URL::to("images/clozer-cup.png")}}' style='margin-right:-10px;'>&nbsp;Lead Management
        </h1>
        <div class="pull-right" style="margin-top:-48px;">
           	@if(Auth::user()->user_type=="manager")
           	<button class="btn btn-small btn-inverse btn-large right-button sortleads  tooltwo" title="IMPORTANT |  Only sort up to twice a day, for maximum lead efficiency. Once in the morning, and once in the afternoon" id="sortleads" style="padding:10px;margin-right:-1px;">
	            <div class='resortBut' ><i class="cus-arrow-redo"></i>&nbsp;&nbsp; RE-SORT ALL LEADS<br>{{$lastsort->message}}</div>
      	        <img class='loadanimation' src='{{URL::to('img/loaders/misc/126.gif')}}'>
	        </button>
	        @endif
            <br/>
			<button class="btn btn-default btn-mini right-button" style="margin-top:20px;" onclick="$('.noneavailable').toggle();$('.inactivelead').toggle();">
                  SHOW ALL CITIES
            </button>
		</div>

        @if(Auth::user()->user_type=="manager")
            <button class="btn btn-purps leadManager  bigbut tooltwo" title="Click to view the main Lead screen">
            	<i class="cus-telephone"></i>&nbsp;LEAD MANAGER
            </button>
            
            <button class="btn btn-warning blackText recallManager  bigbut tooltwo" title="Click to view any Recalls in the system">
           		<span class='badge badge-info special'>{{Lead::where('status','=','Recall')->count()}}</span>&nbsp;RECALL MANAGER
            </button>
            <button class="btn btn-primary referralManager  bigbut tooltwo" title="Click to view any Recalls in the system">
           		<span class='badge badge-info special'>{{Lead::where('leadtype','=','Referral')->count()}}</span>&nbsp;REFERRAL MANAGER
            </button>
            <button class="btn btn-success blackText duplicateManager  bigbut tooltwo" title="Click to view all the Duplicates in the system">
           		&nbsp;DUPLICATE MANAGER
            </button>
            <br/>
            <button style="margin-top:10px;" class="btn btn-default eventManager  bigbut tooltwo" title="Click to view Events/Tradshows in the system">
           		<i class='cus-house'></i>&nbsp;EVENT MANAGER
            </button>
            <button class="btn btn-inverse scratchManager  bigbut tooltwo" title="Click to view Scratch Card Mailouts" style="margin-top:10px;">
                <i class='cus-ticket'></i>&nbsp;SCRATCH CARD MANAGER
            </button>

            <a href="{{URL::to('lead/unassignlead/all')}}">
             	<button class="btn btn-danger unassignleads  bigbut tooltwo" title="Click to unnassign all leads currently assigned to bookers" style="margin-top:10px;">
             		<i class="cus-cancel"></i>&nbsp;UN-ASSIGN ALL
             	</button>
            </a>
        @endif
		<br/>
        @if(Auth::user()->user_type!="agent")
            <a href="javascript:void(0)" onclick="showUploadForm();" title="">
                <button class="btn btn-small btn-inverse" style="margin-top:20px;">
                	<i class="cus-page-excel"></i>&nbsp;UPLOAD .XLS BATCH
                </button>
            </a>
            <br/><br/>
        @endif

      	<div class="row-fluid" style="margin-top:15px;">
            <div class="alert adjusted leadMessage animated fadeInUp"></div>
        </div>
        <br/>
        @if(Session::has('organize'))
            <div class="alert adjusted alert-error animated fadeInUp">
            	<i class="cus-cross-octagon"></i> ORGANIZE FAILED : Exchange Numbers 
            	<span class="label label-info special">{{Session::get('organize')}}</span> do not have a CITY associated.  Please add CITY EXCHANGE before organizing leads.
            </div>
        @elseif(Session::has('batchfail'))
            <div class="alert adjusted alert-error animated fadeInUp">
            	<i class="cus-cross-octagon"></i> {{Session::get('batchfail')}}
            </div>
        @elseif(Session::has('nocity'))
        	<div class="alert adjusted alert-error animated fadeInUp">
             	<i class="cus-cross-octagon"></i> {{Session::get('nocity')}}
            </div>
        @elseif(Session::has('nocolumns'))
        	<div class="alert adjusted alert-error animated fadeInUp">
             	<i class="cus-cross-octagon"></i> {{Session::get('nocolumns')}}
            </div>
        @elseif(Session::has('nofile'))
        	<div class="alert adjusted alert-error animated fadeInUp">
             	<i class="cus-cross-octagon"></i> {{Session::get('nofile')}}
            </div>
        @endif
        
        <div class="row-fluid animated fadeInUp well" id="availableLeads" style="margin-top:-5px;" >
            
            <div class="row-fluid">
        		<div style="width:10%;float:left;">
					Batch Size <br/>
					<input type="text" id="blocksize" name="blocksize" value="{{$settings->default_batch}}" class="lead-release" />
        		</div>
		
        		
	
        		<div class="tooltwo" style="float:left; width:13%;margin-left:-20px;" title="Assign Only Leads that have never been called before">
					Never Called 
            		<div class="double">
            			<input type="checkbox" name="nevercalled_true" id="nevercalled_true" style="margin-top:-0px;"> 
            		</div>
        		</div>
        		<div class="span2 tooltwo" style="margin-left:-20px;" title="Assign leads from oldest to newest. (Still ordered by call amount)">
					Older Leads First
            		<div class="double">
            			<input type="checkbox" name="reverse_leads" id="reverse_leads" style="margin-top:-0px;"> 
            		</div>
        		</div>
        		<div class="span2 tooltwo" style="margin-left:-20px;" title="Assign leads based on Marital Status.  Only works if your surveys contain Marital Status data">
					JOB FILTER
					<select id="jobfilter" name="jobfilter"  class="filterdropdown" style="width:80%;" >
						<option value="false" >All</option>
						<option value="working">Working</option>
						<option value="FT">Full Time Only</option>
						<option value="PT">Part Time Only</option>
						<option value="R">Retired</option>
					</select>
        		</div>
        		<div class="span2 tooltwo" style="margin-left:-20px;" title="Assign leads based on Marital Status.  Only works if your surveys contain Marital Status data">
					MARITAL STATUS
					<select id="maritalstatusfilter" name="maritalstatusfilter" class="filterdropdown"  style="width:80%;" >
						<option value="false" >All</option>
						<option value="married">Married</option>
						<option value="single">Single</option>
						<option value="commonlaw">Common Law</option>
						<option value="widowed">Widowed</option>
					</select>
        		</div>
        		<div class="span2 tooltwo" style="margin-left:-20px;" title="Assign leads based on gender.  Only works if your surveys contain Gender related data">
					GENDER FILTER
					<select id="sexfilter" name="sexfilter" class="filterdropdown"  style="width:80%;" >
						<option value="false">Both Genders / All</option>
						<option value="male">Male</option>
						<option value="female">Female</option>
					</select>
        		</div>

        		
        		<?php $has_age = Lead::where('age_range','!=','')->count();?>
        		<div class="span2 tooltwo" style="margin-left:-20px;" title="Assign leads based on age range.  Only works if your surveys contain age related data">
					<?php $hd="display:none;";?>
					@if($has_age>0)
						AGE FILTER
						<?php $hd="";?>
					@endif
					<select id="agefilter" name="agefilter" class="filterdropdown" style="width:80%;{{$hd}}" >
						<option value="all">All Ages</option>
						<option value="21-35">21-35</option>
						<option value="36-50">36-50</option>
						<option value="51-75">51-75</option>
						<option value="75-85">75-85</option>
					</select>
        		</div>
			
        		<div class="span2"></div>
        			
        		<div class="span2 pull-right" style="margin-right:0px;">
        		  Show Rebooks
        		  <div class="double">
            			<input type="checkbox" name="show_rebooks" id="show_rebooks" style="margin-top:-0px;" @if($settings->show_rebooks==1) checked="checked" @endif> 
            		</div><br/>
            	Show Unreleased
        		  <div class="double">
            			<input type="checkbox" name="show_unreleased" id="show_unreleased" style="margin-top:-0px;" @if($settings->show_unreleased==1) checked="checked" @endif> 
            		</div>
            	</div>
            <div class="span12">
            		<div class="span4">

            		Organization Options<br/>
            		<select class="organizeType" >
            			@if($settings->leads_cities=1) 
            				<option value="city" >Organized By City (default)</option>
            			@endif
            			@if($settings->leads_areas=1) 
            				<option value="area"  >Organized By Area</option>
            			@endif
            			<option value="both">Both CITY and AREA</option>
            		</select>
            	</div>
            	
            	</div>
            </div>


      		@if($settings->leads_areas==1)
      		<div class="leadTable animated fadeInUp" id="area-Leads" style="margin-bottom:50px;">
      		<h3>LEADS ORGANIZED BY <span class='blackText'>AREA</span> </h3>
      		@if(empty($arealeads))
      		<div class="span11 well" style="margin-bottom:50px;">
      		<h4>You currently have no active Areas/Counties</h4>
      		Go to the city page to create areas, and assign cities into those areas.<Br/>
      		<a href='{{URL::to("cities")}}'><button class="btn btn-small">GO TO CITY PAGE</button></a>
      		</div>
      		@else
      		<table  class="table leadtable table-responsive smallShadow"  >
                    	<thead>
                    	<tr align="center">
    					<th>CITY</th>
    					@if($settings->lead_survey==1)
							<th>FRESH</th>
						@endif
							<th>AVAIL</th>
						@if($settings->lead_secondtier==1)
							<th>2ND &nbsp;TIER</th>
						@endif
						@if($settings->lead_door==1)
							<th>DOOR</th>
						@endif
						@if($settings->lead_paper==1)
							<th>PAPER</th>
						@endif
						@if($settings->lead_ballot==1)
							<th>BALLOT</th>
						@endif
						@if($settings->lead_finalnotice==1)
							<th>NOTICE</th>
						@endif
						@if($settings->lead_homeshow==1)
							<th>HOMESHOW</th>
						@endif
						@if($settings->lead_referral==1)
							<th>REFERRAL</th>
						@endif
						<th class='rebookColumn' colspan="6"> 
            				<input type="checkbox" class='tooltwo' title='Check this if you want to assign all rebooks at once to a booker.  Then pick any rebook box, and assign.  They will all be assigned' name="assign_all" id="assign_all" style="margin-top:-0px;"> Assign All At Once &nbsp;&nbsp;&nbsp;&nbsp;| &nbsp;&nbsp;&nbsp;  REBOOKS</th>
						<th>Assigned</th>
						<?php $colspan = 0;
						if($settings->lead_paper==1){$colspan++;}
						if($settings->lead_door==1){$colspan++;}
						if($settings->lead_secondtier==1){$colspan++;}
						if($settings->lead_homeshow==1){$colspan++;}
						if($settings->lead_ballot==1){$colspan++;}
						;?>
						<th class="unreleasedColumn" colspan="{{$colspan}}">UNRELEASED</th>
						@if($settings->show_deleted==1)
							<th>OLD / DELETED</th>
						@endif
						
      				</tr>
					<tr>
						<th></th>
						@if($settings->lead_survey==1)
						<th></th>
						@endif
						<th></th>
						@if($settings->lead_secondtier==1)
						<th></th>
						@endif
						@if($settings->lead_door==1)
						<th></th>
						@endif
						@if($settings->lead_paper==1)
						<th></th>
						@endif
						@if($settings->lead_ballot==1)
						<th></th>
						@endif
						@if($settings->lead_finalnotice==1)
						<th></th>
						@endif
						@if($settings->lead_homeshow==1)
						<th></th>
						@endif
						@if($settings->lead_referral==1)
						<th></th>
						@endif
						<th class='rebookColumn'>NA</th>
						<th class='rebookColumn'>10:30</th>
						<th class='rebookColumn'>1:30</th>
						<th class='rebookColumn'>3:30</th>
						<th class='rebookColumn'>6:30</th>
						<th class='rebookColumn'>8:30</th>
						<th></th>
						@if($settings->lead_secondtier==1)
						<th class="unreleasedColumn">2ND Tier</th>
						@endif
						@if($settings->lead_paper==1)
						<th class="unreleasedColumn">Paper</th>
						@endif
						@if($settings->lead_door==1)
						<th class="unreleasedColumn">Door</th>
						@endif
						@if($settings->lead_ballot==1)
						<th class="unreleasedColumn">Ballot</th>
						@endif
						@if($settings->lead_homeshow==1)
						<th class="unreleasedColumn">Homeshow</th>
						@endif
						@if($settings->show_deleted==1)
						<th></th>
						@endif
						
	                </tr>
                	</thead>
                    <tbody>
                    @if(!empty($arealeads))
                        @foreach($arealeads as $val)
                        	<?php $area = City::find($val->area_id);?>
                        	@if(in_array(str_replace(array(",","-"," ","  ","."),"-",strtolower($area->cityname)), $activeareas)) 
                        		<?php $stat="activelead";?>
                        	@else
                        		<?php $stat="inactivelead";?>
                        	@endif

                        	@if($val->city=="No Assigned City")
                        		<?php $stat="activelead";?>
                        	@endif
                            <tr class=" {{$stat}}">
                                <td>
                                    <?php $hoverTitle="Cities in Area | ";?>
                                    @if(!empty($area->subCity))
                                    	@foreach($area->subCity as $v)
                                    		<?php $hoverTitle.=$v->cityname.",";?>
                                    	@endforeach
                                    @endif
                                    <strong>
                                    	<a href='{{URL::to("cities")}}' target=_blank><span class="tooltwo" style='color:#000;font-size:17px; ' title="{{$hoverTitle}}">{{strtoupper($area->cityname)}}</span></a>
                                    </strong>
                     			</td>
								@if($settings->lead_survey==1)
								<td>
									<center>
									@if($val->survey>0)
										<span class="select"></span><span class="tooltwo badge badge-info sendleads surveyLeads {{stringFilter($area->cityname)}}-survey" title='Click to assign Fresh leads for surveying' data-type="survey" data-city="{{$area->cityname}}" id="" >{{$val->survey}}</span>
									@endif
									@if($settings->show_released==1)
										@if($val->surveyreleased>0)<br/><br/>
										<span class='badge smallbadge releaseBreak badge-inverse special tooltwo' title='{{$val->surveyreleased}} Survey Leads have been released in the last 3 days - CLICK TO VIEW 7 DAY BREAKDOWN' style='color:lime;' data-type='survey' data-city='{{$area->cityname}}'>{{$val->surveyreleased}}</span>
										@endif
									@endif
									</center>
								</td>
								@endif
								<td>
									@if($val->avail>0)
										<center>
											<span class="label label-success special" style="font-size:15px;color:#fff;padding:6px;border:1px solid #1f1f1f;">{{$val->avail}}</span>
										</center>
									@endif
								</td>
								@if($settings->lead_secondtier==1)
								<td>
									<center>
									@if($val->secondtier>0)
										<span class="select"></span><span class="tooltwo badge badge-inverse countcolor-{{$val->ac_secondtier}} sendleads {{stringFilter($area->cityname)}}-secondtier" title='Click to assign leads to booker - {{$val->uncalled_secondtier}} Leads Never Assigned' data-type="secondtier" data-city="{{$area->cityname}}" id="" >{{$val->secondtier}}</span>
									@endif
									@if($settings->show_released==1)
										@if($val->secondtierreleased>0)<br/><br/>
										<span class='badge smallbadge releaseBreak badge-inverse special tooltwo' title='{{$val->secondtierreleased}} Door Reggie Leads have been released in the last 3 days - CLICK TO VIEW 7 DAY BREAKDOWN' style='color:lime;' data-type='secondtier' data-city='{{$area->cityname}}'>{{$val->secondtierreleased}}</span>
										@endif
									@endif
									</center>
								</td>
								@endif
									@if($settings->lead_door==1)
									<td>
										<center>
										@if($val->door>0)
											<span class="select"></span><span class="tooltwo badge badge-inverse countcolor-{{$val->ac_door}} sendleads {{stringFilter($area->cityname)}}-door" title='Click to assign leads to booker - {{$val->uncalled_door}} Leads Never Assigned ' data-type="door" data-city="{{$area->cityname}}" id="" >{{$val->door}}</span>
										@endif
										@if($settings->show_released==1)
											@if($val->doorreleased>0)<br/><br/>
											<span class='badge smallbadge releaseBreak badge-inverse special tooltwo' title='{{$val->doorreleased}} Door Reggie Leads have been released in the last 3 days - CLICK TO VIEW 7 DAY BREAKDOWN' style='color:lime;' data-type='door' data-city='{{$area->cityname}}'>{{$val->doorreleased}}</span>
											@endif
										@endif
										</center>
									</td>
									@endif
									@if($settings->lead_paper==1)
									<td>
										<center>
										@if($val->paper>0)
											<span class="select"></span><span class="tooltwo badge badge-inverse countcolor-{{$val->ac_paper}} sendleads {{stringFilter($area->cityname)}}-paper" data-type="paper" title='Click to assign leads to booker - {{$val->uncalled_paper}} Leads Never Assigned' data-city="{{$area->cityname}}" id="" >{{$val->paper}}</span>
										@endif
										@if($settings->show_released==1)
											@if($val->paperreleased>0)<br/><br/>
											<span class='badge smallbadge releaseBreak badge-inverse special tooltwo'  title='{{$val->paperreleased}} Manilla/Paper Leads have been released in the last 3 days - CLICK TO VIEW 7 DAY BREAKDOWN' style='color:lime;' data-type='paper' data-city='{{$area->cityname}}'>{{$val->paperreleased}}</span>
											@endif
										@endif
										</center>
									</td>
									@endif
									@if($settings->lead_ballot==1)
									<td>
										@if($val->ballot>0)
											<center>
												<span class="select"></span><span class="tooltwo badge badge-inverse sendleads {{stringFilter($area->cityname)}}-ballot" title='Click to assign leads to booker' data-type="ballot" data-city="{{$area->cityname}}" id="" >{{$val->ballot}}</span>
											</center>
										@endif
									</td>
									@endif
									@if($settings->lead_finalnotice==1)
									<td>
										@if($val->final>0)
											<center>
												<span class="select"></span><span class="tooltwo badge badge-inverse sendleads {{stringFilter($area->cityname)}}-finalnotice" title='Click to assign leads to booker' data-type="finalnotice" data-city="{{$area->cityname}}" id="" >{{$val->final}}</span>
											</center>
										@endif
									</td>
									@endif
									@if($settings->lead_homeshow==1)
									<td>
										@if($val->homeshow>0)
											<center>
												<span class="select"></span><span class="tooltwo badge badge-inverse sendleads {{stringFilter($area->cityname)}}-homeshow" title='Click to assign leads to booker' data-type="homeshow" data-city="{{$area->cityname}}" id="" >{{$val->homeshow}}</span>
											</center>
										@endif
									</td>
									@endif
									@if($settings->lead_referral==1)
									<td>
										@if($val->referral>0)
											<center>
												<span class="select"></span><span class="tooltwo badge badge-inverse sendleads {{stringFilter($area->cityname)}}-referral"  title='Click to assign leads to booker' data-type="referral" data-city="{{$area->cityname}}" id="" >{{$val->referral}}</span>
											</center>
										@endif
									</td>
									@endif
									<td class="rebookColumn">
										@if($val->rebook>0)
											<center>
												<span class="select"></span><span class="tooltwo badge badge-inverse sendleads rebookCol {{stringFilter($area->cityname)}}-rebook-no"  title='Click to assign leads to booker' data-type="rebook" data-starttime="00:00:00" data-endtime="00:00:00"  data-all="false" data-city="{{$area->cityname}}"  id="">{{$val->rebook}}</span>
											</center>
										@endif
									</td>
									<td class="rebookColumn">
										@if($val->rebookone>0)
											<center>
												<span class="select"></span><span class="tooltwo badge badge-inverse sendleads rebookCol {{stringFilter($area->cityname)}}-rebook-one"  title='Click to assign leads to booker' data-type="rebook" data-starttime="10:00:00" data-endtime="11:30:00" data-all="false" data-city="{{$area->cityname}}"  id="">{{$val->rebookone}}</span>
											</center>
										@endif
									</td>
									<td class="rebookColumn">
										@if($val->rebooktwo>0)
											<center>
												<span class="select"></span><span class="tooltwo badge badge-inverse sendleads rebookCol {{stringFilter($area->cityname)}}-rebook-two"   title='Click to assign leads to booker' data-type="rebook" data-starttime="11:30:01" data-endtime="14:45:00" data-all="false" data-city="{{$area->cityname}}"  id="">{{$val->rebooktwo}}</span>
											</center>
										@endif
									</td>
									<td class="rebookColumn">
										@if($val->rebookthree>0)
											<center>
												<span class="select"></span><span class="tooltwo badge badge-inverse sendleads rebookCol {{stringFilter($area->cityname)}}-rebook-three"  title='Click to assign leads to booker' data-type="rebook" data-starttime="14:45:01" data-endtime="16:00:00" data-all="false" data-city="{{$area->cityname}}"  id="">{{$val->rebookthree}}</span>
											</center>
										@endif
									</td>
									<td class="rebookColumn">
										@if($val->rebookfour>0)
											<center>
												<span class="select"></span><span class="tooltwo badge badge-inverse sendleads rebookCol {{stringFilter($area->cityname)}}-rebook-four"  title='Click to assign leads to booker' data-type="rebook" data-starttime="16:00:01" data-endtime="18:30:00" data-all="false" data-city="{{$area->cityname}}"  id="">{{$val->rebookfour}}</span>
											</center>
										@endif
									</td>
									<td class="rebookColumn">
										@if($val->rebookfive>0)
											<center>
												<span class="select"></span><span class="tooltwo badge badge-inverse sendleads rebookCol" title='Click to assign leads to booker' data-type="rebook" data-all="false" data-starttime="18:30:01" data-endtime="21:00:00" data-city="{{$area->cityname}}"  id="{{stringFilter($area->cityname)}}-rebook-four">{{$val->rebookfive}}</span>
											</center>
										@endif
									</td>
									<td >
										@if($val->assigned>0)
										<center>
											<span id="assigned-{{stringFilter($area->cityname)}}" class="badge badge-inverse assignedValue {{$area->cityname}} " data-thecity="{{$area->id}}">{{$val->assigned}}</span>
										</center>
										@else 
										<center>
											<span id="assigned-{{stringFilter($area->cityname)}}" class="tooltwo badge badge-inverse assignedValue {{$area->cityname}}" data-thecity="{{$area->id}}" title='Click here to view details about these leads' style="display:none;"></span>
										</center>
										@endif
										
									</td>
									@if($settings->lead_secondtier==1)
									<td class="unreleasedColumn">
										<center>
										@if($val->secondtierunreleased>0)
											<span class="tooltwo badge badge-important unreleased"  title='Click to Release Leads' data-type="secondtier" data-city="{{$area->cityname}}" >{{$val->secondtierunreleased}}</span>
										@endif<br/>
										</center>
									</td>
									@endif
									@if($settings->lead_paper==1)
									<td class="unreleasedColumn">
										<center>
										@if($val->paperunreleased>0)
											<span class="tooltwo badge badge-important unreleased"  title='Click to Release Leads' data-type="paper" data-city="{{$area->cityname}}" >{{$val->paperunreleased}}</span>
											
										@endif<br/>
										</center>
									</td>
									@endif
									@if($settings->lead_door==1)
									<td class="unreleasedColumn"><center>
										@if($val->doorunreleased>0)
											<span class="tooltwo badge badge-important unreleased" title='Click to Release Leads' data-type="door" data-city="{{$area->cityname}}">{{$val->doorunreleased}}</span>
											
										@endif<br/>
										@if($val->paperreleased>0)

										@endif
										</center>
									</td>
									@endif
									@if($settings->lead_ballot==1)
									<td class="unreleasedColumn">
										<center>
										@if($val->ballotunreleased>0)
											<span class="tooltwo badge badge-important unreleased"  title='Click to Release Leads' data-type="ballot" data-city="{{$area->cityname}}" >{{$val->ballotunreleased}}</span>
										@endif<br/>
										</center>
									</td>
									@endif
									@if($settings->lead_homeshow==1)
									<td class="unreleasedColumn">
										<center>
										@if($val->homeshowunreleased>0)
											<span class="tooltwo badge badge-important unreleased"  title='Click to Release Leads' data-type="homeshow" data-city="{{$area->cityname}}" >{{$val->homeshowunreleased}}</span>
										@endif<br/>
										</center>
									</td>
									@endif
									@if($settings->show_deleted==1)
									<td>
										@if($val->deleted>0)
										<center><span class='releaseDeleted badge badge-important special blackText tooltwo' data-type="DELETED" data-city="{{$area->cityname}}" title='Click to re-release some old deleted leads for {{$area->cityname}}, you can view these leads by going to ACTIONS-View Deleted'>{{$val->deleted}}</span></center> 
										@endif
									</td>
									@endif
								
							</tr>
                        @endforeach
                    @endif
                    </tbody>    
                </table>
                @endif
            </div>
            @endif
                              	@if($settings->leads_cities==1)
                              	<div class="leadTable animated fadeInUp" id="city-Leads">
                              		<h3>LEADS ORGANIZED BY <span class='blackText'>CITY</span></h3>
                               <table class="table leadtable table-responsive"  >
                               <thead>
                               <tr align="center">
    								<th>CITY</th>
    								@if($settings->lead_survey==1)
									<th>FRESH</th>
									@endif
									<th>AVAIL</th>
									@if($settings->lead_secondtier==1)
									<th>2ND &nbsp;TIER</th>
									@endif
									@if($settings->lead_door==1)
									<th>DOOR</th>
									@endif
									@if($settings->lead_paper==1)
									<th>PAPER</th>
									@endif
									@if($settings->lead_ballot==1)
									<th>BALLOT</th>
									@endif
									@if($settings->lead_finalnotice==1)
									<th>NOTICE</th>
									@endif
									@if($settings->lead_homeshow==1)
									<th>HOMESHOW</th>
									@endif
									@if($settings->lead_referral==1)
									<th>REFERRAL</th>
									@endif
									<th class='rebookColumn' colspan="6"> 
            							<input type="checkbox" class='tooltwo' title='Check this if you want to assign all rebooks at once to a booker.  Then pick any rebook box, and assign.  They will all be assigned' name="assign_all" id="assign_all" style="margin-top:-0px;"> Assign All At Once &nbsp;&nbsp;&nbsp;&nbsp;| &nbsp;&nbsp;&nbsp;  REBOOKS</th>
									<th>Assigned</th>
									<?php $colspan = 0;
									if($settings->lead_paper==1){$colspan++;}
									if($settings->lead_door==1){$colspan++;}
									if($settings->lead_secondtier==1){$colspan++;};
									if($settings->lead_homeshow==1){$colspan++;};
									if($settings->lead_ballot==1){$colspan++;};
									?>
									<th colspan="{{$colspan}}" class="unreleasedColumn">UNRELEASED</th>
									
									
									@if($settings->show_deleted==1)<th>OLD / DELETED</th>@endif
									<th>ACTIONS</th>
      							</tr>
								<tr>
									<th></th>
									@if($settings->lead_survey==1)
									<th></th>
									@endif
									<th></th>
									@if($settings->lead_secondtier==1)
									<th></th>
									@endif
									@if($settings->lead_door==1)
									<th></th>
									@endif
									@if($settings->lead_paper==1)
									<th></th>
									@endif
									@if($settings->lead_ballot==1)
									<th></th>
									@endif
									@if($settings->lead_finalnotice==1)
									<th></th>
									@endif
									@if($settings->lead_homeshow==1)
									<th></th>
									@endif
									@if($settings->lead_referral==1)
									<th></th>
									@endif
									<th class='rebookColumn'>N/A</th>
									<th class='rebookColumn'>10:30</th>
									<th class='rebookColumn'>1:30</th>
									<th class='rebookColumn'>3:30</th>
									<th class='rebookColumn'>6:30</th>
									<th class='rebookColumn'>8:30</th>
									<th></th>
									@if($settings->lead_secondtier==1)
									<th class="unreleasedColumn">2ND Tier</th>
									@endif

									@if($settings->lead_paper==1)
									<th class="unreleasedColumn">Paper</th>
									@endif
									
									@if($settings->lead_door==1)
									<th class="unreleasedColumn">Door</th>
									@endif

									@if($settings->lead_ballot==1)
									<th class="unreleasedColumn">Ballot</th>
									@endif

									@if($settings->lead_homeshow==1)
									<th class="unreleasedColumn">Homeshow</th>
									@endif
								
									@if($settings->show_deleted==1)<th></th>@endif
									<th></th>
	                                          </tr>
                                          </thead>
                                          <tbody>
                                          @if(!empty($cityleads))
                                                @foreach($cityleads as $val)
                                                @if (in_array(str_replace(array(",","-"," ","  ","."),"-",strtolower($val->city)), $activecities)) 
                                                <?php $stat="activelead";?>
                                                @else
                                                <?php $stat="inactivelead";?>
                                                @endif
                                                @if($val->city=="No Assigned City")
                                                <?php $stat="activelead";?>
                                                @endif
                                                <tr class=" {{$stat}}">
                                                     	<td><strong><a href='{{URL::to("cities")}}' target=_blank><span style='color:#000;font-size:17px;'>{{strtoupper($val->city)}}</span></a></strong>
                                                     		<br/>
									<?php $ra = City::where('cityname','=',$val->city)->first(array('id','rightaway'));
									
									?>
									@if(!empty($ra))
									 <span class="small " style="color:#333;">RIGHT AWAY NEEDED | <span class="badge badge-info special tooltwo editRightaway" title="Click to set how many rightaways you need for this city" style="cursor:pointer;" id="rightaway|{{$ra->attributes['id']}}" >{{$ra->attributes['rightaway']}}</span></span>
									 @endif
                                                     	@if($val->city=="No Assigned City")
									<A href="{{URL::to('cities/sortleads')}}">
										<button class="tooltwo btn btn-small btn-default applyQuadrants" title='Apply Quadrants to uploaded numbers that have no cities'>
											<i class="cus-house"></i>&nbsp;Apply Quadrants
										</button>
									</a>
									@endif
									<br/>
                                        <span class='small'><span class='blackText'>{{$val->totaldoor}}</span> Door | 
                                        <span class='blackText'>{{$val->totalpaper}}</span> Manilla | 
                                        <span class='blackText'>{{$val->totalother}}</span> Other</span>
                                    </td>
									@if($settings->lead_survey==1)
									<td><center>
										@if($val->survey>0)
											<span class="select"></span><span class="tooltwo badge badge-info sendleads surveyLeads {{stringFilter($val->city)}}-survey" title='Click to assign Fresh leads for surveying' data-type="survey" data-city="{{$val->city}}" id="" >{{$val->survey}}</span>
										@endif
										@if($settings->show_released==1)
										@if($val->surveyreleased>0)<br/><br/>
										<span class='badge smallbadge releaseBreak badge-inverse special tooltwo' title='{{$val->surveyreleased}} Survey Leads have been released in the last 3 days - CLICK TO VIEW 7 DAY BREAKDOWN' style='color:lime;' data-type='survey' data-city='{{$val->city}}'>{{$val->surveyreleased}}</span>
										@endif
										@endif
										</center>
									</td>
									@endif
									<td>
										@if($val->avail>0)
											<center><span class="label label-success special" style="font-size:15px;color:#fff;padding:6px;border:1px solid #1f1f1f;">{{$val->avail}}</span>
											</center>
										@endif
									</td>
									@if($settings->lead_secondtier==1)
									<td><center>
										@if($val->secondtier>0)
											<span class="select"></span><span class="tooltwo badge badge-inverse countcolor-{{$val->ac_secondtier}} sendleads {{stringFilter($val->city)}}-secondtier" title='Click to assign leads to booker - {{$val->uncalled_secondtier}} Leads Never Assigned' data-type="secondtier" data-city="{{$val->city}}" id="" >{{$val->secondtier}}</span>
										@endif
										@if($settings->show_released==1)
										@if($val->secondtierreleased>0)<br/><br/>
										<span class='badge smallbadge releaseBreak badge-inverse special tooltwo' title='{{$val->secondtierreleased}} Door Reggie Leads have been released in the last 3 days - CLICK TO VIEW 7 DAY BREAKDOWN' style='color:lime;' data-type='secondtier' data-city='{{$val->city}}'>{{$val->secondtierreleased}}</span>
										@endif
										@endif
										</center>
									</td>



									@endif
									@if($settings->lead_door==1)
									<td><center>
									
										@if($val->door>0)
											<span class="select"></span><span class="tooltwo badge badge-inverse countcolor-{{$val->ac_door}} sendleads {{stringFilter($val->city)}}-door" title='Click to assign leads to booker - {{$val->uncalled_door}} Leads Never Assigned' data-type="door" data-city="{{$val->city}}" id="" >{{$val->door}}</span>
										@endif
										@if($settings->show_released==1)
										@if($val->doorreleased>0)<br/><br/>
										<span class='badge smallbadge releaseBreak badge-inverse special tooltwo' title='{{$val->doorreleased}} Door Reggie Leads have been released in the last 3 days - CLICK TO VIEW 7 DAY BREAKDOWN' style='color:lime;' data-type='door' data-city='{{$val->city}}'>{{$val->doorreleased}}</span>
										@endif
										@endif
										</center>
									</td>
									@endif
									@if($settings->lead_paper==1)
									<td><center>
									
										@if($val->paper>0)
											<span class="select"></span><span class="tooltwo badge badge-inverse countcolor-{{$val->ac_paper}} sendleads {{stringFilter($val->city)}}-paper" data-type="paper" title='Click to assign leads to booker - {{$val->uncalled_paper}} Leads Never Assigned' data-city="{{$val->city}}" id="" >{{$val->paper}}</span>
										@endif
										@if($settings->show_released==1)
										@if($val->paperreleased>0)<br/><br/>
										<span class='badge smallbadge releaseBreak badge-inverse special tooltwo'  title='{{$val->paperreleased}} Manilla/Paper Leads have been released in the last 3 days - CLICK TO VIEW 7 DAY BREAKDOWN' style='color:lime;' data-type='paper' data-city='{{$val->city}}'>{{$val->paperreleased}}</span>
										@endif
										@endif
										</center>
									</td>
									@endif
									@if($settings->lead_ballot==1)
									<td>
										@if($val->ballot>0)
											<center>
												<span class="select"></span><span class="tooltwo badge badge-inverse sendleads   {{stringFilter($val->city)}}-ballot" title='Click to assign leads to booker' data-type="ballot" data-city="{{$val->city}}" id="" >{{$val->ballot}}</span>
											</center>
										@endif
									</td>
									@endif
									@if($settings->lead_finalnotice==1)
									<td>
										@if($val->final>0)
											<center>
												<span class="select"></span><span class="tooltwo badge badge-inverse sendleads {{stringFilter($val->city)}}-finalnotice" title='Click to assign leads to booker' data-type="finalnotice" data-city="{{$val->city}}" id="" >{{$val->final}}</span>
											</center>
										@endif
									</td>
									@endif
									@if($settings->lead_homeshow==1)
									<td>
										@if($val->homeshow>0)
											<center>
												<span class="select"></span><span class="tooltwo badge badge-inverse sendleads {{stringFilter($val->city)}}-homeshow" title='Click to assign leads to booker' data-type="homeshow" data-city="{{$val->city}}" id="" >{{$val->homeshow}}</span>
											</center>
										@endif
									</td>
									@endif
									@if($settings->lead_referral==1)
									<td>
										@if($val->referral>0)
											<center>
												<span class="select"></span><span class="tooltwo badge badge-inverse sendleads {{stringFilter($val->city)}}-referral"  title='Click to assign leads to booker' data-type="referral" data-city="{{$val->city}}" id="" >{{$val->referral}}</span>
											</center>
										@endif
									</td>
									@endif
									<td class="rebookColumn">
										@if($val->rebook>0)
											<center>
												<span class="select"></span><span class="tooltwo badge badge-inverse sendleads rebookCol {{stringFilter($val->city)}}-rebook-no"  title='Click to assign leads to booker' data-type="rebook" data-starttime="00:00:00" data-endtime="00:00:00"  data-all="false" data-city="{{$val->city}}"  id="">{{$val->rebook}}</span>
											</center>
										@endif
									</td>
									<td class="rebookColumn">
										@if($val->rebookone>0)
											<center>
												<span class="select"></span><span class="tooltwo badge badge-inverse sendleads rebookCol {{stringFilter($val->city)}}-rebook-one"  title='Click to assign leads to booker' data-type="rebook" data-starttime="10:00:00" data-endtime="11:30:00" data-all="false" data-city="{{$val->city}}"  id="">{{$val->rebookone}}</span>
											</center>
										@endif
									</td>
									<td class="rebookColumn">
										@if($val->rebooktwo>0)
											<center>
												<span class="select"></span><span class="tooltwo badge badge-inverse sendleads rebookCol {{stringFilter($val->city)}}-rebook-two"   title='Click to assign leads to booker' data-type="rebook" data-starttime="11:30:01" data-endtime="14:45:00" data-all="false" data-city="{{$val->city}}"  id="">{{$val->rebooktwo}}</span>
											</center>
										@endif
									</td>
									<td class="rebookColumn">
										@if($val->rebookthree>0)
											<center>
												<span class="select"></span><span class="tooltwo badge badge-inverse sendleads rebookCol {{stringFilter($val->city)}}-rebook-three"  title='Click to assign leads to booker' data-type="rebook" data-starttime="14:45:01" data-endtime="16:00:00" data-all="false" data-city="{{$val->city}}"  id="">{{$val->rebookthree}}</span>
											</center>
										@endif
									</td>
									<td class="rebookColumn">
										@if($val->rebookfour>0)
											<center>
												<span class="select"></span><span class="tooltwo badge badge-inverse sendleads rebookCol {{stringFilter($val->city)}}-rebook-four"  title='Click to assign leads to booker' data-type="rebook" data-starttime="16:00:01" data-endtime="18:30:00" data-all="false" data-city="{{$val->city}}"  id="">{{$val->rebookfour}}</span>
											</center>
										@endif
									</td>
									<td class="rebookColumn">
										@if($val->rebookfive>0)
											<center>
												<span class="select"></span><span class="tooltwo badge badge-inverse sendleads rebookCol" title='Click to assign leads to booker' data-type="rebook" data-all="false" data-starttime="18:30:01" data-endtime="21:00:00" data-city="{{$val->city}}"  id="{{stringFilter($val->city)}}-rebook-four">{{$val->rebookfive}}</span>
											</center>
										@endif
									</td>
									<td>
										@if($val->assigned>0)
										<center>
											<span id="assigned-{{stringFilter($val->city)}}" class="badge badge-inverse assignedValue {{$val->city}} " data-thecity="{{$val->city}}">{{$val->assigned}}</span>
										</center>
										@else 
										<center>
											<span id="assigned-{{stringFilter($val->city)}}" class="tooltwo badge badge-inverse assignedValue {{$val->city}}" data-thecity="{{$val->city}}" title='Click here to view details about these leads' style="display:none;"></span>
										</center>
										@endif
										
									</td>
									@if($settings->lead_secondtier==1)
									<td class="unreleasedColumn">
										<center>
										@if($val->secondtierunreleased>0)
											<span class="tooltwo badge badge-important unreleased"  title='Click to Release Leads' data-type="secondtier" data-city="{{$val->city}}" >{{$val->secondtierunreleased}}</span>
										@endif<br/>
										</center>
									</td>
									@endif
									@if($settings->lead_paper==1)
									<td class="unreleasedColumn">
										<center>
										@if($val->paperunreleased>0)
											<span class="tooltwo badge badge-important unreleased"  title='Click to Release Leads' data-type="paper" data-city="{{$val->city}}" >{{$val->paperunreleased}}</span>
											
										@endif<br/>
										
										</center>
									</td>
									@endif
									@if($settings->lead_door==1)
									<td class="unreleasedColumn"><center>
										@if($val->doorunreleased>0)
											<span class="tooltwo badge badge-important unreleased" title='Click to Release Leads' data-type="door" data-city="{{$val->city}}">{{$val->doorunreleased}}</span>
											
										@endif<br/>
										@if($val->paperreleased>0)

										@endif
										</center>
									</td>
									@endif
									@if($settings->lead_ballot==1)
									<td class="unreleasedColumn">
										<center>
										@if($val->ballotunreleased>0)
											<span class="tooltwo badge badge-important unreleased"  title='Click to Release Leads' data-type="ballot" data-city="{{$val->city}}" >{{$val->ballotunreleased}}</span>
										@endif<br/>
										</center>
									</td>
									@endif
									@if($settings->lead_homeshow==1)
									<td class="unreleasedColumn">
										<center>
										@if($val->homeshowunreleased>0)
											<span class="tooltwo badge badge-important unreleased"  title='Click to Release Leads' data-type="homeshow" data-city="{{$val->city}}" >{{$val->homeshowunreleased}}</span>
										@endif<br/>
										</center>
									</td>
									@endif
									@if($settings->show_deleted==1)
									<td>
										@if($val->deleted>0)
										<center><span class='releaseDeleted badge badge-important special blackText tooltwo' data-type="DELETED" data-city="{{$val->city}}" title='Click to re-release some old deleted leads for {{$val->city}}, you can view these leads by going to ACTIONS-View Deleted'>{{$val->deleted}}</span></center> 
										@endif
										

									</td>
									@endif
									<td>
										
										
										<div class="btn-group" style="margin-left:5px;">
										<button class="btn btn-mini btn-default">
											<i class="cus-doc-pdf"></i> Actions
										</button>
										<button class="btn btn-mini btn-primary dropdown-toggle" data-toggle="dropdown">
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu">
										<!--<li>
											<a href="javascript:void(0);"><i class="cus-doc-excel-table"></i> Download to Excel</a>
										</li>-->
										@if($val->avail!=0 )
										<li class="tooltwo viewLeads" data-skip="0" data-take="10" data-type="NEW" data-city="{{$val->city}}" title="All available leads in {{$val->city}}">
											<a href='#'><i class="cus-eye"></i> View Available</a>
										</li>
										@endif
										@if($val->city=="" || $val->city=="No Assigned City")
										<li class="tooltwo viewLeads" data-skip="0" data-take="10" data-type="ALL" data-city="{{$val->city}}" title="All leads in {{$val->city}}">
											<a href='#'><i class="cus-eye"></i> View These Leads</a>
										</li>
										@endif

										@if($val->assigned!=0)
										<li class="tooltwo viewLeads" data-skip="0" data-take="10" data-type="ASSIGNED" data-city="{{$val->city}}" title="Click to View All Assigned leads for {{$val->city}}">
											<a href='#'><i class="cus-eye"></i> View Assigned</a>
										</li>
										@endif
										@if(($val->paperunreleased!=0)||($val->doorunreleased))
										<li class="tooltwo viewLeads" data-skip="0" data-take="10" data-type="INACTIVE" data-city="{{$val->city}}" title="Click to view Unreleased leads for {{$val->city}}">
											<a href='#'><i class="cus-eye"></i> View Unreleased</a>
										</li>
										@endif

										@if($val->deleted!=0)
										<li class="tooltwo viewLeads" data-skip="0" data-take="10" data-type="DELETED" data-city="{{$val->city}}" title="Click to view Deleted leads for {{$val->city}}">
											<a href='#'><i class="cus-eye"></i> View Deleted Leads</a>
										</li>
										@endif


										@if(($val->paper>0)&&($val->city!="No Assigned City"))
										<li class="tooltwo" title="View a daily breakdown of Manilla uploads for {{$val->city}}">
											<a href="{{URL::to('reports/dataentry/')}}?cityname={{$val->city}}&startdate={{date('Y-m-d',strtotime('-90 Day'));}}&enddate={{date('Y-m-d')}}"><i class="cus-page-white-stack"></i> Manilla Breakdown</a>
										</li>
										@endif
										@if(($val->nothomes>0))
										<li class="sortleads tooltwo" data-city="{{$val->city}}" data-type="all" title='Click to sort only {{$val->city}} leads!'>
											<A href="javascript:void(0);"><i class="cus-arrow-redo"></i> Sort ALL From {{$val->city}}</a>
										</li>
										@endif
										@if(($val->paper_tosort>0))
										<li class="sortleads tooltwo" data-city="{{$val->city}}" data-type="paper" title='Click to sort only Manilla/Upload Leads in {{$val->city}}'>
											<A href="javascript:void(0);"><i class="cus-arrow-redo"></i> Sort Only Manilla/Upload Leads in {{$val->city}}</a>
										</li>
										@endif
										@if(($val->door_tosort>0))
										<li class="sortleads tooltwo" data-city="{{$val->city}}" data-type="door" title='Click to sort only Manilla/Upload Leads in {{$val->city}}'>
											<A href="javascript:void(0);"><i class="cus-arrow-redo"></i> Sort Only Door Reggie Leads in {{$val->city}}</a>
										</li>
										@endif
										@if(($val->homeshow_tosort>0))
										<li class="sortleads tooltwo" data-city="{{$val->city}}" data-type="homeshow" title='Click to sort only Manilla/Upload Leads in {{$val->city}}'>
											<A href="javascript:void(0);"><i class="cus-arrow-redo"></i> Sort Only HomeShow Leads in {{$val->city}}</a>
										</li>
										@endif
										@if(($val->survey_tosort>0))
										<li class="sortleads tooltwo" data-city="{{$val->city}}" data-type="survey" title='Click to sort only Manilla/Upload Leads in {{$val->city}}'>
											<A href="javascript:void(0);"><i class="cus-arrow-redo"></i> Sort Only Fresh Survey Leads in {{$val->city}}</a>
										</li>
										@endif
										@if(($val->secondtier_tosort>0))
										<li class="sortleads tooltwo" data-city="{{$val->city}}" data-type="secondtier" title='Click to sort only Manilla/Upload Leads in {{$val->city}}'>
											<A href="javascript:void(0);"><i class="cus-arrow-redo"></i> Sort Only SecondTier Leads in {{$val->city}}</a>
										</li>
										@endif
										@if($val->rebooks_tosort>0)
										<li class="sortleads tooltwo" data-city="{{$val->city}}" data-type="rebooks" title='Click to sort only the Rebook leads!'>
											<A href="javascript:void(0);"><i class="cus-arrow-redo"></i> Sort REBOOKS From This City</a>
										</li>
										@endif
										</ul>
										<br/>
										<button class='btn btn-default btn-mini viewStats' data-city="{{$val->city}}" style='margin-top:6px;'>STATS</button>
									</div>
									</td>
								</tr>
                                                @endforeach
                                          @endif
                                          </tbody>    
                                    </table>
                              </div>
                              @endif
                  </div>
                  <br/><br/>
                  @if($deleted!=0)
                  <span class='label label-info special'>{{$deleted}} </span> Leads were deleted recently, for being called too many times.<br/>
                  @endif
                  @if($undeleted!=0)
                  <span class='label label-info special'>{{$undeleted}} </span> Leads were un-deleted recently<br/>
                  @endif
                  @if($sur_deleted!=0)
                  <span class='label label-info special'>{{$sur_deleted}} </span>Un-Surveyed Leads were deleted recently, for being called too many times.<br/>
                  @endif
                  @if($sur_undeleted!=0)
                  <span class='label label-info special'>{{$sur_undeleted}} </span> Un-Surveyed Leads were un-deleted recently<br/>
                  @endif
                  @if($rent_deleted!=0)
                  <span class='label label-info special'>{{$rent_deleted}} </span>Renters Were Removed from the Lead Pool.<br/>
                  @endif
                  @if($rent_undeleted!=0)
                  <span class='label label-info special'>{{$rent_undeleted}} </span> Renters were added into lead pool<br/>
                  @endif

                  <div class="row-fluid well animated fadeInUp" id="leadsAssigned" style="margin-top:-55px;" >
                  	
			</div>


	</div>


	<div class="span2" style="padding-top:19px;padding-left:40px;">
		<button class="btn btn-primary btn-large viewBookers">SEE LEADS ASSIGNED TO BOOKERS</button>
		<div class='leadStats' style='color:#000;'>
			@include('plugins.bookerstats')
		</div>
		<?php $active=0;$p=0;$ass=0;$nh2=0;?>
			 	@foreach($assigned_today as $val2)
			 	<?php if($val2->status=="DNC"){$p++;};
			 	if($val2->status=="ASSIGNED"){$ass++;}
			 	if($val2->status=="NI"){$p++;};
			 	if($val2->status=="INVALID"){$p++;}
			 	if($val2->status=="NQ"){$p++;};
			 	if($val2->status=="APP"){$p++;};
			 	if($val2->status=="WrongNumber"){$p++;};
			 	if($val2->status=="Recall"){$p++;};
			 	if($val2->status=="NH"){$nh2++;$p++;};?>
			 	@endforeach
		<div style="float:left;width:90%;margin-top:-10px;margin-left:10px;font-size:12px;margin-bottom:30px;">
                        <center><h5>TODAYS STATS</h5>
                        <table class="table-condensed sidetable " >
                            <thead style="color:#000!important">
                                <th>ASSIGNED</th>
                                <th>CONTACTED</th>
                                <th>NH</th>
                            </thead>
                            <tbody class=''>
                               <tr>
                               	<td><center><span class="totalAssigned label label-info special assignedLeads">{{$ass}}</span></center></td>
                               	<td><center><span class='totalContact label label-warning blackText special'></span></center></td>
                               	<td><center><span class="totalNotHome label label-inverse special" ></span></center></td>
                               	
                               </tr>
                            </tbody>
                        </table>
                        </center>
                        </div>
                        <div class="clearfix" style="margin-top:20px;"></div>
		@include('layouts.chat')
	</div>
</div>


    <?php $arr=array();
	foreach($bookers as $val){
    	$arr[$val->firstname."|".$val->id] = $val->firstname." ".$val->lastname;
    };?>

	<form id="releaseleads" style="display:none" method="post" action="{{URL::to('lead/releaseleads')}}">
  		<input type="text" id="releasetime" name="releasetime" />
  		<input type="text" id="releaseleadtype" name="releaseleadtype" />
  		<input type="text" id="releaseblocksize" name="releaseblocksize" />
  		<input type="text" id="citytorelease" name="citytorelease" />
	</form>


<?php $t = json_encode(explode(',',Setting::find(1)->xls_columns));?>

<script>
$(document).ready(function(){


/****LEAD UPLOAD STUFF******/
/**** SORTABLE TABLE LIST STUFF****/

	// Apply sortable to XLS List // 
	$( "#xlsSortable" ).sortable({
    	update: function( event, ui ) {
    		storeColumns();
    	}
	});
	$( "#xlsSortable" ).disableSelection();


	// Apply previously chosen column choices from database
	applyColumns();
	function applyColumns(){
		var columnOrder = {{$t}};
		var chosenColumns = [];
		$.each(columnOrder,function(i,val){
			var f = $('.xlsColumnChoice[data-id="'+val+'"]');
			f.removeClass('xlsColumnChoice').addClass('xlsColumnItem');
			chosenColumns.push(f);
		});
		$('#xlsSortable').html("").append(chosenColumns);
		$('#xlsSortable').sortable('refresh');
	}

	// Store any new change to column list in database
    function storeColumns(){
    	var columnStore = [];
		$('.xlsColumnItem').each(function(i,val){
			var d = $(this).data('id');
			columnStore.push(d);
		});
		$.getJSON("{{URL::to('settings/xlscolumns')}}",{columns:columnStore},function(data){
			if(data!="failed"){
				toastr.success("Saved Column Order to Settings");
			} else {
				toastr.error("Failed to save column settings");
			}
			console.log(data);
		});
    }

	$(document).on('click','.xlsColumnChoice',function(){
	    var t = $(this);
	    t.removeClass('xlsColumnChoice').addClass('xlsColumnItem');
	    $('#xlsSortable').append(t);
	    $('#xlsSortable').sortable('refresh');
	    storeColumns();

	});
	
	$(document).on('mousedown','.xlsColumnItem',function(e) {
	    if (e.which === 3) {
	        var t = $(this);
	        t.removeClass('xlsColumnItem').addClass('xlsColumnChoice');
	        $('#xlsColumnChoices').append(t);
	        storeColumns();
	    }
	});

	$( document ).on("contextmenu", function(e) {e.preventDefault();});

/***** TABLE STUFF*******/

$('.uploadButton').click(function(e){
	e.preventDefault();
	var xlsColumns = [];
	$('.xlsColumnItem').each(function(i,val){
		var d = $(this).data('id');
		xlsColumns.push(d);
	});
	
	$('#xlsColumnOrder').val(xlsColumns);
	
		$('.ajax-heading').html('Uploading Excel File...');
		$('.ajaxWait').show();
		setTimeout(function(){
			$('#leadbatchupload').submit();
			$('.ajaxWait').hide();
		},700);
});



// ** END LEAD UPLOAD STUFF ***//
var rebooks=0;
if($('#show_rebooks').is(':checked')){
	$('.rebookColumn').show();
} else {
	$('.rebookColumn').hide();
}
var unreleased=0;
if($('#show_unreleased').is(':checked')){
	$('.unreleasedColumn').show();
} else {
	$('.unreleasedColumn').hide();
}


if(localStorage){
	if(localStorage){
        if(!!localStorage.getItem("areaType")){
            applyTable(localStorage.getItem("areaType"));
        } else {
        	applyTable("city");
        }
    } else {
    	applyTable("city");
    	}
}

function applyTable(type){
	$('.organizeType').val(type);
	if(type=="both"){

		$('.leadTable').show();
	} else {
		$('.leadTable').hide();
		$('#'+type+'-Leads').show();
	}
}

$('.organizeType').change(function(){
	var type = $(this).val();
	if(localStorage){
		localStorage.setItem("areaType",type);
	}
	applyTable(type);
	
});

$('#show_rebooks').click(function(){
	if($(this).is(':checked')){
		var rbval=1;
		$('.rebookColumn').show();
	} else {
		var rbval=0;
		$('.rebookColumn').hide();
	}
	saveSetting('show_rebooks',rbval);
	
});

$('#show_unreleased').click(function(){
	if($(this).is(':checked')){
		var unreleasedval=1;
		$('.unreleasedColumn').show();
	} else {
		var unreleasedval=0;
		$('.unreleasedColumn').hide();
	}
	saveSetting('show_unreleased',unreleasedval);
});

function saveSetting(col,val){
	$.getJSON("{{URL::to('system/edit')}}",{field:col,value:val},function(data){
        if(data=="success"){
            toastr.success("Settings Saved!");
        } else {
            toastr.error("Failed to Save!");
        }
    });
}

$('#assign_all').click(function(){
	if($(this).attr('checked')){
		$('.rebookCol').each(function(i,val){
			var id = $(this).attr('data-all').replace('false','true');
			$(this).attr('data-all',id);
		});
	}  else {
		$('.rebookCol').each(function(i,val){
			var id = $(this).attr('data-all').replace('true','false');
			$(this).attr('data-all',id);
		});
	}
	populateLeadBox();
});

$('.viewStats').click(function(){
	var city = $(this).data('city');
	url='{{URL::to("lead/stats/")}}';
	$('.infoHover').hide();
	$('.invoiceInfoHover').css('width','700px').css('margin-left','-360px').addClass('animated fadeInUp').load(url,{city:city}).show();
});

$(document).on('click','.releaseBreak',function(){
	var type=$(this).data('type');
	var city = $(this).data('city');
	if(city.length>0){
		url='{{URL::to("lead/showreleased/")}}';
	 	$('.infoHover').hide();
	 	$('.invoiceInfoHover').css('width','700px').css('margin-left','-160px').addClass('animated fadeInUp').load(url,{city:city}).show();
	}
});

//GENERIC FUNCTIONS--------------
function stringFilter(str){
	if(isNaN(str)){
		//replace spaces with dashes
		str = str.replace(/\s+/g, '-');
		//replace slashes with spaces
		str = str.replace(/\//g, '');	
		//replace periods with spaces
		str = str.replace(/\./g,'');
	}
	
	return str;
}
//----------------------------

$('.editRightaway').editable('{{URL::to("cities/edit")}}',{
 	indicator : 'Saving...',
    tooltip   : 'Click to edit...',
    submit  : 'OK',
    width:'40',
    height:'25'
});

function getNumbers(){
	var nh=0;var cnt=0;var ass=0;
	$('.nothomes').each(function(i,val){
		nh = nh+parseInt($(this).html());
	});
	$('.contacts').each(function(i,val){
		cnt = cnt+parseInt($(this).html());
	});
	$('.totalAssigned').html($('#allAssignedLeads').val());
	$('.totalContact').html(parseInt(cnt)-parseInt(nh));
	$('.totalNotHome').html(nh);
}
	getNumbers();

var refreshId = setInterval(replaceCounts, 15200);

$.ajaxSetup({ cache: false });

function replaceCounts(){
	$('.leadStats').load('{{URL::to("stats/getbookingstats")}}');
    getNumbers();
}

$(document).on('click','.viewLeads', function(){
	var city = $(this).data('city');
	var type = $(this).data('type');
	var srch = $(this).data('search');
	var skip = $(this).data('skip');
	var take = $(this).data('take');
	window.scrollTo(0,0);
	$('.availableLeads').hide();
	if(skip==0){
		$('#leadViewer').html("<center><img src='{{URL::to('img/loaders/misc/100.gif')}}'></center>");
	} 
		$('#leadViewer').show()
	$('#leadViewer').load('{{URL::to('lead/getleads')}}',{city:city,type:type,skip:skip,take:take});
});

var click=0;




$(document).on('click','.deleteDuplicate',function(){
    var id=$(this).data('id');
    var button = $(this);
    var td = $(this).closest('td');
    var url = "{{URL::to('lead/delete/')}}"+id;
    $.getJSON(url,{duplicate:true}, function(data) {
    	console.log(data);
        if(data=="sale"){
            toastr.error('Lead cannot be deleted', 'Lead has a SALE attached');
        } else if(data=="app"){
            toastr.error('Lead cannot be deleted', 'Lead has an APPOINTMENT attached');
        } else if(data=="calls"){
        	$('#lead-'+id).hide(200);
            toastr.success('Lead was SOFT deleted', 'Lead has calls attached, so it was only quarantined.  Not fully removed.');
        } else if(data=="duplicate") {
        	button.hide();
        	td.append("QUARANTINED");
            toastr.success('Lead Sucessfully Removed', 'Lead Deleted and Put Into Duplicate Bin');
        } else {
        	button.hide();
        	td.append("QUARANTINED");
            toastr.success('Lead Sucessfully Removed', 'Lead Deleted');
        }
    });
});

function loadManager(url){
	$('.infoHover').hide();
	$('#leadsAssigned').html("").html("<center><img src='{{URL::to("img/loaders/misc/300.gif")}}'></center>");
	$('#availableLeads').hide();
	$('#leadsAssigned').show();	
	$('#leadsAssigned').load(url);
}
$(document).on('click','.viewBookers',function(){
	loadManager("{{URL::to('lead/getassigned')}}");
});

$('.recallManager').click(function(){
	loadManager("{{URL::to('lead/recalls')}}");
});
$('.referralManager').click(function(){
	loadManager("{{URL::to('lead/referrals')}}");
});
$(document).on('click','.duplicateManager',function(){
	loadManager("{{URL::to('lead/duplicates')}}");
});

$(document).on('click','.duplicateQuarantined',function(){
	loadManager("{{URL::to('lead/duplicates/quarantine')}}");
});

$('.eventManager').click(function(){
	loadManager("{{URL::to('lead/events')}}");
});


$('.scratchManager').click(function(){
	loadManager("{{URL::to('lead/scratch')}}");
});

$('.leadManager').click(function(){
	$('#availableLeads').show();
	$('#leadsAssigned').hide();	
});

$('.unreleased').click(function(){
city=$(this).data('city');
type=$(this).data('type');
block = $("input[name='blocksize']").val();
days = prompt("You are about to release "+block+" "+type.toUpperCase()+" leads from "+city.toUpperCase()+" \n\n PLEASE ENTER THE AMOUNT OF DAYS TO SKIP...");

if(days==""){
	alert('Please Enter a Value');
} else if(days===null){ return false;}
else {
$('#releasetime').val(days);
$('#releaseleadtype').val(type);
$('#releaseblocksize').val(block);
$('#citytorelease').val(city);
$('#releaseleads').submit();
}
});

$('.releaseDeleted').click(function(){
	city=$(this).data('city');
	type=$(this).data('type');
	amount = prompt("You are about to release "+type.toUpperCase()+" leads from "+city.toUpperCase()+" \n\n PLEASE ENTER AN AMOUNT OF LEADS TO RELEASE! \n\n THIS WILL RESET THE CALL COUNTER FOR THE LEADS, AND RELEASE THE OLDEST OF THE BATCH FIRST");
	
	if(amount==""){
		alert('Please Enter a Value');
	} else if(amount===null){ return false;}
	else {
		$('.ajax-heading').html("Releasing Deleted Leads...");
		$('.ajaxWait').show();
		$('#releasetime').val("");
		$('#releaseleadtype').val(type);
		$('#releaseblocksize').val(amount);
		$('#citytorelease').val(city);
		$('#releaseleads').submit();
	}
});

function populateLeadBox(){
	$('.sendleads').each(function(v,val){
		var size = $("input[name='blocksize']").val();
		var reverse = $('#reverse_leads').is(':checked');
		var never_called = $('#nevercalled_true').is(':checked');
		var age_filter = $('#agefilter').find("option:selected").val();
		var job_filter = $('#jobfilter').find("option:selected").val();
		var sex_filter = $('#sexfilter').find("option:selected").val();
		var marital_filter = $('#maritalstatusfilter').find("option:selected").val();
		
		var type=$(this).data('type');
		var city=$(this).data('city');
		var start = $(this).data('starttime');
		var end = $(this).data('endtime');
		var all = $(this).attr('data-all');
		if(start){
			var v = size+"|"+type+"|"+city+"|"+all+"|"+start+"-"+end+"|false|false|false|false";
		} else {
			var v = size+"|"+type+"|"+city+"|"+never_called+"|"+reverse+"|"+job_filter+"|"+age_filter+"|"+sex_filter+"|"+marital_filter;
		}
		$(this).attr('id',v);
	});
}

populateLeadBox();


$('input#nevercalled_true').click(function(){
	populateLeadBox();
});
$('input#reverse_leads').click(function(){
	populateLeadBox();
});

$("input[name='blocksize']").blur(function(){
	populateLeadBox();
});

$(".filterdropdown").change(function(){
	populateLeadBox();
});


$('.sendleads').editable('{{URL::to("lead/assignleads")}}',{
	data : '<?php echo  json_encode($arr);?>',
	type:'select',
	submit:'OK',
	cssclass: 'checkbookSelect select',
    	indicator : '<img src="https://s3.amazonaws.com/salesdash/loaders/56.gif">',
    	width:'40',
    	callback: function(value, settings){
    	
    	var d = JSON.parse(value);
    	$(this).html(d.count);
    	setTimeout(replaceCounts,500);


   	if(d.msg=="allrebooks"){
   		location.reload();
   	} else {
   		toastr.success(d.msg,"LEADS ASSIGNED");
   	}
   	if(d.cnt==0){
   		$('.leadMessage').removeClass('alert-success').addClass('alert-error');
   	} else {
   		$('.leadMessage').removeClass('alert-error').addClass('alert-success');
   	}
   	$('.leadMessage').html(d.msg).show();
    }
});

$(document).on('click','.assignedValue',function(){
	var city = $(this).data('thecity');
	console.log(city);	
	if(city.length>0){
		url='{{URL::to("lead/getassignedinfo/")}}';
	 	$('.infoHover').hide();
	 	$('.invoiceInfoHover').css('width','400px').addClass('animated fadeInUp').load(url,{city:city}).show();
	}
});

$(document).on('click','.backToLeads',function(){
	$('#leadViewer').hide();
	$('.availableLeads').show();	
});

$('.release').click(function(){
	$('#release').toggle(300);
});

$('.deletelead').click(function(){
    var id=$(this).data('id');
    if(confirm("Are you sure you want to delete this lead?")){
        var url = "lead/delete/"+id;
            $.getJSON(url, function(data) {
             $('#agentrow-'+id).hide();
            });
    }
});

$('.applyQuadrants').click(function(){
	$('.ajax-heading').html('Applying Quadrants...');
	$('.ajaxWait').show();	
});

$(document).on('click','.unassignleads',function(){
	$('.ajax-heading').html('Unnassigning Leads...');
	$('.ajaxWait').show();	
});



$('.sortleads').click(function(){
	var city = $(this).data('city');
	var type = $(this).data('type');
	
	if(city){
		var data={citytosort:city,sorttype:type};
	} else {
		var data = {};
	}
	var t = confirm("Are you sure you want to sort?");
	if(t){
		$('.sorting-anim').show();
		$('.ajaxWait').show();
		$('.loadanimation').show();
		$('.resortBut').html("");
		$('.ajax-heading').html('Sorting Leads...');
		setTimeout(function(){
			$.getJSON('../lead/sortleads',data,function(data){
				if(data){
					$('.ajaxWait').hide();
					$('.ajax-heading').html('');
					$('.loadanimation').hide();
					$('.resortBut').html("<i class='cus-arrow-redo'></i>&nbsp;&nbsp;RE-SORT ALL LEADS<br><font color='yellow'>"+data+"</font>");
					location.reload(true);
				} else {
					toastr.error("Lead sort failed","SORT FAILED!");
				}
			});
		},1000);
	}

});






});
</script>
@endsection