@layout('layouts/main')
@section('content')

<script>
function showUploadForm(){
$('#leadbatch').toggle(400);
}
</script>
<style>
#addnewagent {display:none;}
#leadbatch {display:none;}
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
td select{width:65%!important;margin-right:10px;}
.noneavailable{display:none;}

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

.rebookCol{
background:#ddd;
color:#000!important;
border:1px solid #1f1f1f!important;
}

.rebookBol:hover{

}

.leadtable {margin-top:10px;border:1px solid #bbb;}
.leadtable th{font-size:11px;text-align:center;background:#eee;color:#000!important;border:1px solid #bbb;}
.leadtable td {border:1px solid #bbb;padding:7px;}

.leadMessage{display:none;}

.assignleadsAnim{
	position:fixed;
	width:220px;
	height:160px;
	background:white;
	border:4px solid #1f1f1f;
	z-index:50000;
	margin-left:420px;
	margin-top:150px;
	padding:40px;
	-webkit-box-shadow: 13px 13px 27px 0px rgba(50, 50, 46, 0.99);
-moz-box-shadow:    13px 13px 27px 0px rgba(50, 50, 46, 0.99);
box-shadow:         13px 13px 27px 0px rgba(50, 50, 46, 0.99);
display:none;
}

#inTurnFadingTextG{
width:300px;
}

.inTurnFadingTextG{
color:#000000;
font-family:Arial;
font-size:30px;
text-decoration:none;
font-weight:bold;
font-style:normal;
float:left;
-moz-animation-name:bounce_inTurnFadingTextG;
-moz-animation-duration:0.42s;
-moz-animation-iteration-count:infinite;
-moz-animation-direction:linear;
-webkit-animation-name:bounce_inTurnFadingTextG;
-webkit-animation-duration:0.42s;
-webkit-animation-iteration-count:infinite;
-webkit-animation-direction:linear;
-ms-animation-name:bounce_inTurnFadingTextG;
-ms-animation-duration:0.42s;
-ms-animation-iteration-count:infinite;
-ms-animation-direction:linear;
-o-animation-name:bounce_inTurnFadingTextG;
-o-animation-duration:0.42s;
-o-animation-iteration-count:infinite;
-o-animation-direction:linear;
animation-name:bounce_inTurnFadingTextG;
animation-duration:0.42s;
animation-iteration-count:infinite;
animation-direction:linear;
}

#inTurnFadingTextG_1{
-moz-animation-delay:0.08s;
-webkit-animation-delay:0.08s;
-ms-animation-delay:0.08s;
-o-animation-delay:0.08s;
animation-delay:0.08s;
}

#inTurnFadingTextG_2{
-moz-animation-delay:0.1s;
-webkit-animation-delay:0.1s;
-ms-animation-delay:0.1s;
-o-animation-delay:0.1s;
animation-delay:0.1s;
}

#inTurnFadingTextG_3{
-moz-animation-delay:0.12s;
-webkit-animation-delay:0.12s;
-ms-animation-delay:0.12s;
-o-animation-delay:0.12s;
animation-delay:0.12s;
}

#inTurnFadingTextG_4{
-moz-animation-delay:0.14s;
-webkit-animation-delay:0.14s;
-ms-animation-delay:0.14s;
-o-animation-delay:0.14s;
animation-delay:0.14s;
}

#inTurnFadingTextG_5{
-moz-animation-delay:0.16s;
-webkit-animation-delay:0.16s;
-ms-animation-delay:0.16s;
-o-animation-delay:0.16s;
animation-delay:0.16s;
}

#inTurnFadingTextG_6{
-moz-animation-delay:0.18s;
-webkit-animation-delay:0.18s;
-ms-animation-delay:0.18s;
-o-animation-delay:0.18s;
animation-delay:0.18s;
}

#inTurnFadingTextG_7{
-moz-animation-delay:0.2s;
-webkit-animation-delay:0.2s;
-ms-animation-delay:0.2s;
-o-animation-delay:0.2s;
animation-delay:0.2s;
}

#inTurnFadingTextG_8{
-moz-animation-delay:0.22s;
-webkit-animation-delay:0.22s;
-ms-animation-delay:0.22s;
-o-animation-delay:0.22s;
animation-delay:0.22s;
}

#inTurnFadingTextG_9{
-moz-animation-delay:0.24s;
-webkit-animation-delay:0.24s;
-ms-animation-delay:0.24s;
-o-animation-delay:0.24s;
animation-delay:0.24s;
}

#inTurnFadingTextG_10{
-moz-animation-delay:0.26s;
-webkit-animation-delay:0.26s;
-ms-animation-delay:0.26s;
-o-animation-delay:0.26s;
animation-delay:0.26s;
}

#inTurnFadingTextG_11{
-moz-animation-delay:0.28s;
-webkit-animation-delay:0.28s;
-ms-animation-delay:0.28s;
-o-animation-delay:0.28s;
animation-delay:0.28s;
}

#inTurnFadingTextG_12{
-moz-animation-delay:0.3s;
-webkit-animation-delay:0.3s;
-ms-animation-delay:0.3s;
-o-animation-delay:0.3s;
animation-delay:0.3s;
}

#inTurnFadingTextG_13{
-moz-animation-delay:0.32s;
-webkit-animation-delay:0.32s;
-ms-animation-delay:0.32s;
-o-animation-delay:0.32s;
animation-delay:0.32s;
}

#inTurnFadingTextG_14{
-moz-animation-delay:0.34s;
-webkit-animation-delay:0.34s;
-ms-animation-delay:0.34s;
-o-animation-delay:0.34s;
animation-delay:0.34s;
}

#inTurnFadingTextG_15{
-moz-animation-delay:0.36s;
-webkit-animation-delay:0.36s;
-ms-animation-delay:0.36s;
-o-animation-delay:0.36s;
animation-delay:0.36s;
}

#inTurnFadingTextG_16{
-moz-animation-delay:0.38s;
-webkit-animation-delay:0.38s;
-ms-animation-delay:0.38s;
-o-animation-delay:0.38s;
animation-delay:0.38s;
}

#inTurnFadingTextG_17{
-moz-animation-delay:0.4s;
-webkit-animation-delay:0.4s;
-ms-animation-delay:0.4s;
-o-animation-delay:0.4s;
animation-delay:0.4s;
}

@-moz-keyframes bounce_inTurnFadingTextG{
0%{
color:#000000;
}

100%{
color:#FFFFFF;
}

}

@-webkit-keyframes bounce_inTurnFadingTextG{
0%{
color:#000000;
}

100%{
color:#FFFFFF;
}

}

@-ms-keyframes bounce_inTurnFadingTextG{
0%{
color:#000000;
}

100%{
color:#FFFFFF;
}

}

@-o-keyframes bounce_inTurnFadingTextG{
0%{
color:#000000;
}

100%{
color:#FFFFFF;
}

}

@keyframes bounce_inTurnFadingTextG{
0%{
color:#000000;
}

100%{
color:#FFFFFF;
}

}

</style>
<style>
#outer-barG{
height:58px;
width:200px;
border:3px solid #000000;
overflow:hidden;
background-color:#FFFFFF}

.bar-lineG{
background-color:#000000;
float:left;
width:29px;
height:189px;
margin-right:37px;
margin-top:-43px;
-moz-transform:rotate(45deg);
-webkit-transform:rotate(45deg);
-ms-transform:rotate(45deg);
-o-transform:rotate(45deg);
transform:rotate(45deg);
}

.bar-animationG{
margin-left:263px;
width:263px;
-moz-animation-name:bar-animationG;
-moz-animation-duration:0.75s;
-moz-animation-iteration-count:infinite;
-moz-animation-direction:linear;
-webkit-animation-name:bar-animationG;
-webkit-animation-duration:0.75s;
-webkit-animation-iteration-count:infinite;
-webkit-animation-direction:linear;
-ms-animation-name:bar-animationG;
-ms-animation-duration:0.75s;
-ms-animation-iteration-count:infinite;
-ms-animation-direction:linear;
-o-animation-name:bar-animationG;
-o-animation-duration:0.75s;
-o-animation-iteration-count:infinite;
-o-animation-direction:linear;
animation-name:bar-animationG;
animation-duration:0.75s;
animation-iteration-count:infinite;
animation-direction:linear;
}

#front-barG{
}

@-moz-keyframes bar-animationG{
0%{
margin-left:243px;
margin-top:-29px}

100%{
margin-left:-200px;
margin-top:-29px}

}

@-webkit-keyframes bar-animationG{
0%{
margin-left:243px;
margin-top:-29px}

100%{
margin-left:-200px;
margin-top:-29px}

}

@-ms-keyframes bar-animationG{
0%{
margin-left:243px;
margin-top:-29px}

100%{
margin-left:-200px;
margin-top:-29px}

}

@-o-keyframes bar-animationG{
0%{
margin-left:243px;
margin-top:-29px}

100%{
margin-left:-200px;
margin-top:-29px}

}

@keyframes bar-animationG{
0%{
margin-left:243px;
margin-top:-29px}

100%{
margin-left:-200px;
margin-top:-29px}

}

</style>

<div class="assignleadsAnim animated bounceInDown" id="sorting_modal" >
	<center>
<div class="unassign-anim" style="display:none;">
<div id="inTurnFadingTextG">
<div id="inTurnFadingTextG_1" class="inTurnFadingTextG">
U</div>
<div id="inTurnFadingTextG_2" class="inTurnFadingTextG">
n</div>
<div id="inTurnFadingTextG_3" class="inTurnFadingTextG">
a</div>
<div id="inTurnFadingTextG_4" class="inTurnFadingTextG">
s</div>
<div id="inTurnFadingTextG_5" class="inTurnFadingTextG">
s</div>
<div id="inTurnFadingTextG_6" class="inTurnFadingTextG">
i</div>
<div id="inTurnFadingTextG_7" class="inTurnFadingTextG">
g</div>
<div id="inTurnFadingTextG_8" class="inTurnFadingTextG">
n
</div>
<div id="inTurnFadingTextG_9" class="inTurnFadingTextG">
i</div>
<div id="inTurnFadingTextG_10" class="inTurnFadingTextG">
n</div>
<div id="inTurnFadingTextG_11" class="inTurnFadingTextG">
g</div>
<div id="inTurnFadingTextG_12" class="inTurnFadingTextG">
&nbsp;</div>
<div id="inTurnFadingTextG_13" class="inTurnFadingTextG">
.</div>
<div id="inTurnFadingTextG_14" class="inTurnFadingTextG">
.</div>
<div id="inTurnFadingTextG_15" class="inTurnFadingTextG">
.</div>

</div>

</div>


<div class="sorting-anim" style="display:none;">
<div id="inTurnFadingTextG">
<div id="inTurnFadingTextG_1" class="inTurnFadingTextG">
S</div>
<div id="inTurnFadingTextG_2" class="inTurnFadingTextG">
o</div>
<div id="inTurnFadingTextG_3" class="inTurnFadingTextG">
r</div>
<div id="inTurnFadingTextG_4" class="inTurnFadingTextG">
t</div>
<div id="inTurnFadingTextG_5" class="inTurnFadingTextG">
i</div>
<div id="inTurnFadingTextG_6" class="inTurnFadingTextG">
n</div>
<div id="inTurnFadingTextG_7" class="inTurnFadingTextG">
g</div>
<div id="inTurnFadingTextG_8" class="inTurnFadingTextG">
&nbsp;
</div>
<div id="inTurnFadingTextG_9" class="inTurnFadingTextG">
L</div>
<div id="inTurnFadingTextG_10" class="inTurnFadingTextG">
e</div>
<div id="inTurnFadingTextG_11" class="inTurnFadingTextG">
a</div>
<div id="inTurnFadingTextG_12" class="inTurnFadingTextG">
d</div>
<div id="inTurnFadingTextG_13" class="inTurnFadingTextG">
s</div>
<div id="inTurnFadingTextG_14" class="inTurnFadingTextG">
.</div>
<div id="inTurnFadingTextG_15" class="inTurnFadingTextG">
.</div>
<div id="inTurnFadingTextG_16" class="inTurnFadingTextG">
.</div>
<div id="inTurnFadingTextG_17" class="inTurnFadingTextG">
.</div>
</div> 

</div>

<br/><br/>
<div id="outer-barG">
<div id="front-barG" class="bar-animationG">
<div id="barG_1" class="bar-lineG">
</div>
<div id="barG_2" class="bar-lineG">
</div>
<div id="barG_3" class="bar-lineG">
</div>
</div>
</div> 
</center>
</div>



<div id="main" role="main" class="container-fluid">
    	<div class="contained">
        	<aside> 
            	@render('layouts.managernav')
        	</aside>
            <div id="page-content" style="padding-bottom:50px;">
                  <h1 id="page-header">Lead Management
                  		<button class="btn btn-small btn-primary btn-large sortleads animated rollIn" id="sortleads" style="float:right;margin-top:10px;margin-right:10px;">
                  			<i class="cus-arrow-redo"></i>&nbsp;&nbsp; RE-SORT ALL LEADS<br>{{$lastsort->message}}
                  		</button>
                  </h1>
                   <div class="fluid-container">
                        <a href="javascript:void(0)" onclick="showUploadForm();" title="">
                            <button class="btn btn-small btn-inverse"><i class="cus-page-excel"></i>&nbsp;UPLOAD .XLS BATCH</button>
                        </a>&nbsp;&nbsp;
                
                        <a href="{{URL::to('lead/unassignlead/all')}}">
                            <button class="btn btn-small btn-danger unassignleads"><i class="cus-cancel"></i>&nbsp;UN-ASSIGN ALL</button>
                        </a>&nbsp;&nbsp;
              		<br/><br/>

              		<div class="row-fluid">
  					
              			<div class="alert adjusted alert-info leadMessage">
                        		
                        	</div>

              		</div>

                        <section id="widget-grid" class="">
	                      	<div class="row-fluid" id="leadbatch">
                        		<article class="span12">
							<div class="jarviswidget black " data-widget-editbutton="false" data-widget-deletebutton="false"
                                    data-widget-fullscreenbutton="false">
								<header>
									<h2>UPLOAD BATCH OF LEADS</h2>                           
								</header>
								<div>
									<div class="inner-spacer"> 
									      <!-- content goes here -->
										<form class="form-horizontal themed" enctype="multipart/form-data" id="leadbatchupload" method="post" action="{{URL::to('lead/batchload')}}">
											<fieldset>
												<div class="control-group">
													<label class="control-label" for="csvfile">File input</label>
													<p>Please input only a .csv file</p>
													<div class="controls">
														<input class="file" id="csvfile" name="csvfile" type="file" />
													</div>
												</div>
												<div class="form-actions">
													<input type="submit" value="UPLOAD" class="btn medium btn-success" ></input>
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

                        	@if(Session::has('organize'))
                        		<div class="alert adjusted alert-error animated fadeInUp">
                        			<i class="cus-cross-octagon"></i> ORGANIZE FAILED : Exchange Numbers 
                        			<span class="label label-info special">{{Session::get('organize')}}</span> do not have a CITY associated.  Please add CITY EXCHANGE before organizing leads.
                        		</div>
                        	@elseif(Session::has('batchfail'))
                        		<div class="alert adjusted alert-error animated fadeInUp">
                        			<i class="cus-cross-octagon"></i> BATCH UPLOAD FAILED: The numbers are already in the system, or the file format is incorrect.  Please try again!
                        		</div>
                        	@endif
                        	<div class="row-fluid well" id="availableLeads">
                        		<div class="row-fluid">
                        			<span class="label label-inverse">LEADS TO ASSIGN OR RELEASE</span> &nbsp;&nbsp;<input type="text" id="blocksize" name="blocksize"  value="40" style="background:yellow;width:2%;margin-top:10px;font-size:14px;font-weight:bold;line-height:10px;" />
                        			<span class="label label-info" style="margin-left:20px;">ASSIGN ONLY 'RETIRED' PEOPLE</span> &nbsp;&nbsp;<input type="checkbox" name="retired_true" id="retired_true" style="margin-top:-0px;"> 

                        			<button class="btn btn-default btn-mini" style="float:right;margin-top:20px;" onclick="$('.noneavailable').toggle(600);">
                        				SHOW ALL CITIES
                        			</button>
                        			 
                        			<button class="btn btn-primary btn-mini showstats" style="float:right;margin-top:20px;margin-right:10px;">
                        				SHOW STATS
                        			</button>
                        		<br/>
                                    <h5>Click on Lead Bubbles To Assign Or Release Leads</h5>  
                        		</div>
                        		<div class="row-fluid well" id="stats" style="display:none;">
                        			<div class="span6">
                        				<div id="container" style="min-width: 100%; height: 400px; margin: 0 auto"></div>
                        			</div>
                        			<div class="span6">
                        				<div id="container2" style="min-width: 100%; height: 400px; margin: 0 auto"></div>
                        			</div>
                        		</div>
                                    <table class="table leadtable"  >
                                          <thead>
                                                <tr align="center">
    									<th>CITY</th>
									<th>AVAILABLE</th>
									<th>DOOR</th>
									<th>PAPER</th>
									<th>BALLOT</th>
									<th>HOMESHOW</th>
									<th>OTHER</th>
									<th colspan="6">REBOOKS</th>
									<th>Assigned</th>
									<th colspan="2">UNRELEASED</th>
									<th>SORT CITY</th>
									
									
								</tr>
								<tr>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th>No Time</th>
									<th>10:30</th>
									<th>1:30</th>
									<th>3:30</th>
									<th>6:30</th>
									<th>8:30</th>
									<th></th>
									<th>Paper</th>
									<th>Door</th>
									<th></th>
									
	                                          </tr>
                                          </thead>
                                          <tbody>
                                          <?php $avail=0;$door=0;$paper=0;$ballot=0;$homeshow=0;$other=0;$assign=0;$ni=0;$nq=0;$dnc=0;$unrelease=0;$rebook=0;?>

                                          @if(!empty($cityleads))
                                                @foreach($cityleads as $val)
                                                <?php $avail = $avail+$val->avail;$door=$door+$val->door;$paper=$paper+$val->paper;
                                                $ballot=$ballot+$val->ballot;$homeshow=$homeshow+$val->homeshow;$other=$other+$val->other;
                                                 $rebook=$rebook+$val->rebook;$assign=$assign+$val->assigned;$unrelease=$unrelease+$val->paperunreleased+$val->doorunreleased;$ni=$ni+$val->ni;$nq=$nq+$val->nq;$dnc=$val->dnc+$dnc;?>
                                                <?php if(($val->avail!=0)||($val->paperunreleased!=0)||($val->doorunreleased!=0)){$theclass="";}else {$theclass="noneavailable";};?>
                                                <tr class="{{$theclass}}">
                                                     	<td><strong><span class="small">{{strtoupper($val->city)}}</span></strong><br/>
                                                     	@if($val->avail!=0)
									<A href="{{URL::to('lead/getleads')}}?city={{$val->city}}&type=all">
										<button class="tooltwo btn btn-mini btn-default" title='Click to view all these leads (may take a while to load)'>
											<i class="cus-house"></i>&nbsp;View Leads
										</button>
									</a>
									@if(($val->paper>0)&&($val->city!="No Assigned City"))
									<A href="{{URL::to('reports/dataentry/')}}?cityname={{$val->city}}&startdate={{date('Y-m-d',strtotime('-90 Day'));}}&enddate={{date('Y-m-d')}}">
										<button class="tooltwo btn btn-mini btn-primary" title='Click to see a daily breakdown, of uploads by Manilla'>
											<i class="cus-house"></i>&nbsp;MANILLA BREAKDOWN
										</button>
									</a>@endif
									@endif
                                                     	@if($val->city=="No Assigned City")
									<A href="{{URL::to('cities/sortleads')}}">
										<button class="tooltwo btn btn-small btn-default" title='Apply Quadrants to uploaded numbers that have no cities'>
											<i class="cus-house"></i>&nbsp;Apply Quadrants
										</button>
									</a>
									@endif
                                                     	</td>
									<td>
										@if($val->avail>0)
											<center><span class="label label-success special" style="font-size:15px;color:#fff;padding:6px;border:1px solid #1f1f1f;">{{$val->avail}}</span>
											</center>
										@endif
									</td>
									<td>
										@if($val->door>0)
											<center><span class="select"></span><span class="tooltwo badge badge-inverse sendleads" title='Click to assign leads to booker' data-type="door" data-city="{{$val->city}}" id="" >{{$val->door}}</span>
											</center>
										@endif
									</td>
									<td>
										@if($val->paper>0)
											<center><span class="select"></span><span class="tooltwo badge badge-inverse sendleads" data-type="paper" title='Click to assign leads to booker' data-city="{{$val->city}}" id="" >{{$val->paper}}</span>
											</center>
										@endif
									</td>
									<td>
										@if($val->ballot>0)
											<center><span class="select"></span><span class="tooltwo badge badge-inverse sendleads" title='Click to assign leads to booker' data-type="ballot" data-city="{{$val->city}}" id="" >{{$val->ballot}}</span>
											</center>
										@endif
									</td>
									<td>
										@if($val->homeshow>0)
											<center><span class="select"></span><span class="tooltwo badge badge-inverse sendleads" title='Click to assign leads to booker' data-type="homeshow" data-city="{{$val->city}}" id="" >{{$val->homeshow}}</span>
											</center>
										@endif
									</td>
									<td>
										@if($val->other>0)
											<center><span class="select"></span><span class="tooltwo badge badge-inverse sendleads"  title='Click to assign leads to booker' data-type="other" data-city="{{$val->city}}" id="" >{{$val->other}}</span>
											</center>
										@endif
									</td>
									<td>
										@if($val->rebook>0)
											<center><span class="select"></span><span class="tooltwo badge badge-inverse sendleads rebookCol"  title='Click to assign leads to booker' data-type="rebook" data-starttime="00:00:00" data-endtime="00:00:00" data-city="{{$val->city}}"  id="">{{$val->rebook}}</span>
											</center>
										@endif
									</td>
									<td>
										@if($val->rebookone>0)
											<center><span class="select"></span><span class="tooltwo badge badge-inverse sendleads rebookCol"  title='Click to assign leads to booker' data-type="rebook" data-starttime="10:00:00" data-endtime="11:30:00" data-city="{{$val->city}}"  id="">{{$val->rebookone}}</span>
											</center>
										@endif
									</td>
									<td>
										@if($val->rebooktwo>0)
											<center><span class="select"></span><span class="tooltwo badge badge-inverse sendleads rebookCol"  title='Click to assign leads to booker' data-type="rebook" data-starttime="11:30:01" data-endtime="14:45:00" data-city="{{$val->city}}"  id="">{{$val->rebooktwo}}</span>
											</center>
										@endif
									</td>
									<td>
										@if($val->rebookthree>0)
											<center><span class="select"></span><span class="tooltwo badge badge-inverse sendleads rebookCol"  title='Click to assign leads to booker' data-type="rebook" data-starttime="14:45:01" data-endtime="16:00:00" data-city="{{$val->city}}"  id="">{{$val->rebookthree}}</span>
											</center>
										@endif
									</td>
									<td>
										@if($val->rebookfour>0)
											<center><span class="select"></span><span class="tooltwo badge badge-inverse sendleads rebookCol"  title='Click to assign leads to booker' data-type="rebook" data-starttime="16:00:01" data-endtime="18:30:00" data-city="{{$val->city}}"  id="">{{$val->rebookfour}}</span>
											</center>
										@endif
									</td>
									<td>
										@if($val->rebookfive>0)
											<center><span class="select"></span><span class="tooltwo badge badge-inverse sendleads rebookCol" title='Click to assign leads to booker' data-type="rebook" data-starttime="18:30:01" data-endtime="21:00:00" data-city="{{$val->city}}"  id="">{{$val->rebookfive}}</span>
											</center>
										@endif
									</td>
									<td>
										@if($val->assigned>0)
										<center><span id="{{$val->city}}" class="badge badge-inverse assignedValue " style="color:#000;background:yellow;border:1px solid #1f1f1f;font-size:15px">{{$val->assigned}}</span>
										</center>
										@else 
										<center><span id="{{$val->city}}" class="tooltwo badge badge-inverse assignedValue {{$val->city}}"  title='These are all currently assigned leads from this city' style="color:#000;background:yellow;border:1px solid #1f1f1f;font-size:15px;display:none"></span>
										</center>
										@endif
										
									</td>
									<td>
										@if($val->paperunreleased>0)
											<center><span class="tooltwo badge badge-important unreleased"  title='Click to Release Leads' data-type="paper" data-city="{{$val->city}}" >{{$val->paperunreleased}}</span>
											</center>
										@endif
									</td>
									<td>
										@if($val->doorunreleased>0)
											<center><span class="tooltwo badge badge-important unreleased" title='Click to Release Leads' data-type="door" data-city="{{$val->city}}">{{$val->doorunreleased}}</span>
											</center>
										@endif
									</td>
									<td>
										
											<center>
												
											<button class="tooltwo btn btn-mini btn-primary sortleads" data-city="{{$val->city}}" title='Click to sort only this city!'>
											<i class="cus-house"></i>&nbsp;SORT CITY
											</button>
											
											</center>
									</td>
								</tr>
                                                @endforeach
                                          @endif
                                          </tbody>    
                                    </table>
                                           
                        </div>
                       	<div class="row-fluid">
					@if(!empty($assigned))
                        	<article class="span12">
						<div class="jarviswidget black" data-widget-editbutton="false" data-widget-deletebutton="false"
                                    data-widget-fullscreenbutton="false"  >
						<header>
							<h2>Leads Assigned to Bookers</h2>                           
						</header>
						<div>
							<div class="inner-spacer widget-content-padding"> 
								<ul id="myTab" class="nav nav-tabs default-tabs">
									@foreach($assname as $val)
										<li class="bookertabs" >
											<a href="#{{$val}}" data-toggle="tab">{{User::find($val)->firstname}} {{User::find($val)->lastname}}</a>
										</li>
									@endforeach
								</ul>
								<div id="myTabContent" class="tab-content">
									@foreach($assname as $val)
									<div class="tab-pane fade " id="{{$val}}">
										<header>
											<h5>ASSIGNED ON : <span class="label label-inverse">{{$date}}</span> | ASSIGNED TO : <span class="labellabel-inverse">{{User::find($val)->firstname}} {{User::find($val)->lastname}}</span>
											</h5> 
											                      
                                       				  	<a href="{{URL::to('lead/unassignlead/')}}{{$val}}">
                                       				  		<button class="btn btn-danger unassignleads" style="float:right;margin-bottom:20px;margin-top:-30px;">
                                       				  			<i class="cus-cancel"></i>&nbsp;UNASSIGN LEADS
                                       				  		</button>
                                       				  	</a>
                                       				  	<a href="{{URL::to('users/profile/')}}{{$val}}">
                                       				  		<button class="btn btn-primary" style="float:right;margin-right:20px;margin-bottom:20px;margin-top:-30px;">
                                       				  			<i class="cus-eye"></i>&nbsp;VIEW USER PROFILE
                                       				  		</button>
                                       				  	</a>    
                                       				</header>
                                       				<br><br>
                                       				<table class="table table-bordered responsive" >
                                                    			<thead>
                                                        			<tr align="center">
    													<th>Date</th>           	                                    
													<th class="span2">Customer<br />Phone Number</th>
													<th>Customer<br />Name</th>
													<th>City</th>
													<th>CALLED</th>
													<th>Last Contact</th>
													<th>Status</th>  
	                                                        		</tr>
                                                    			</thead>
                                                    			<tbody id="bookerleaddata">
                                                     				@foreach($assigned as $val2)
												@if($val2->booker_id==$val)
												<?php if($val2->status=="APP"){$shadow="shadowtable";$color="#000";} else {$shadow="";$color="black";}
														if($val2->status=="APP"){$label="success";$msg = "DEMO BOOKED!";}
														elseif($val2->status=="SOLD"){$label="success";$msg = " $$ SOLD $$";}
	           												elseif($val2->status=="ASSIGNED"){$label="info";$msg = "ASSIGNED TO CALL";} 
            												elseif($val2->status=="NH") {$label="inverse";$msg = "NOT HOME";} 
            												elseif($val2->status=="DNC") {$label="important";$msg = "DO NOT CALL!";}
            												elseif($val2->status=="NI") {$label="important";$msg = "NOT INTERESTED";}
           													elseif($val2->status=="Recall") {$label="warning";$msg = "RECALL";} 
           													elseif($val2->status=="NQ") {$label="important";$msg = "NOT QUALIFIED";} 
           													elseif($val2->status=="WrongNumber"){$label="warning";$msg="Wrong Number";} 
           													else{$label="";$msg="";} ?>
           											<tr id='{{$val2->cust_num}}' class="{{$shadow}} {{$val2->status}} leadrow" style='color:{{$color}}'>
													<td>{{date('M-d', strtotime($val2->assign_date))}}</td>
													<td class="span2">{{$val2->cust_num}}</td>
													<td>{{$val2->cust_name}}</td>
													<td>{{$val2->city}}</td>
													<?php $callcount = Lead::find($val2->id)->calls()->count();?>
													@if($callcount>0)
													<?php $last = Lead::find($val2->id)->calls()->order_by('created_at','DESC')->first();?>
													<td>
														<center>
															<span class='label label-success boxshadow'>CALLED {{$callcount}} TIMES</span>
														</center>
													</td>
													<td>Called on <b>{{date('M-d h:i a', strtotime($last->created_at))}}</b> by <b>{{$last->caller_name}}</b> &nbsp;<span class="label label-inverse">Result :  {{$last->result}}</span>
													</td>
													@else
													<td>
														<center>
															<span class='label label-inverse'>Not Called</span>
														</center>
													</td>
													<td>Have not contacted this lead yet</b></td>
													@endif
													<td>
														<center>
															<span class='label label-{{$label}} special boxshadow'>{{$msg}}</span>
														</center>
													</td>
												</tr>
												@endif
												@endforeach
                                                    			</tbody>
                                                		</table>
									</div>
									@endforeach
								</div>
							</div>
						</div>
					</article>
					@endif
				</div>
			</div>
            </section>
                        <!-- end widget grid -->
      </div>    
      <aside class="right">
            @render('layouts.chat')
                  <h2 class="shadow">Pick a Date to Analyze</h2>
            		<div id="filterdate" class="shadow" style="background:#1f1f1f;border-radius:12px"></div>
      </aside>  
            
</div>
                <!-- end main content -->
            </div>
                   
        </div><!--end fluid-container-->
        <div class="push"></div>
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

@include('plugins.enternewlead')
<script src="{{URL::to_asset('js/editable.js')}}"></script>
<script src="{{URL::to_asset('js/highcharts.js')}}"></script>
<script>
$(document).ready(function(){


$('#leadmenu').addClass('expanded');
$('.showstats').click(function(){
    	$('#stats').toggle();
$(function () {
    	   	// Radialize the colors
		Highcharts.setOptions({
     			colors: ['#00CC66', '#009933', '#669999', '#000000', '#FF0000', '#993366', '#FFCC00']
    		});
	
        	$('#container').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: 'LEAD BREAKDOWN',
                 style:{color: '#3E576F',
				fontSize: '20px'}
            },
            tooltip: {
        	    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
                        formatter: function() {
                            return '<b>'+ this.point.name +'</b>: '+ this.percentage.toFixed(2) +' %';
                        }
                    }
                }
            },
            series: [{
                type: 'pie',
                name: 'Lead Percentage',
                data: [
                    ['DOOR', {{$door}}],
                    ['PAPER', {{$paper}}],
                    ['REBOOKS', {{$rebook}}],
                    ['NI', {{$ni}}],
                    ['DNC', {{$dnc}}],
                    ['NQ', {{$nq}}],
                    ['ASSIGNED',{{$assign}}]
                ]
            }]
        });
    });

@if(!empty($bookper))
<?php if(!isset($bookper['door']->demos)){$doordemos=0;} else {$doordemos=$bookper['door']->demos;};
if(!isset($bookper['paper']->demos)){$paperdemos=0;} else {$paperdemos=$bookper['paper']->demos;};
if(!isset($bookper['rebook']->demos)){$rebookdemos=0;} else {$rebookdemos=$bookper['rebook']->demos;};
?>

$(function () {
    	
    	// Radialize the colors
		Highcharts.setOptions({
     colors: ['#00CC66', '#009933', '#669999', '#000000', '#FF0000', '#993366', '#FFCC00']
    });
		
		// Build the chart
        $('#container2').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: 'DEMOS HELD BY LEAD TYPE',
                style:{color: '#3E576F',
				fontSize: '20px'}
            },
            tooltip: {
        	    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },

            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
                        formatter: function() {
                            return '<b>'+ this.point.name +'</b>: '+ this.percentage.toFixed(2) +' %';
                        }
                    }
                }
            },
            series: [{
                type: 'pie',
                name: 'Lead Percentage',
                data: [
                    ['DOOR',   {{$doordemos}}],
                    ['PAPER',       {{$paperdemos}}],
                    ['REBOOKS',    {{$rebookdemos}}],
                  
                ]
            }]
        });
    });
@endif
    
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

function populateLeadBox(){
	$('.sendleads').each(function(v,val){
	var size = $("input[name='blocksize']").val();
	var retired = $('#retired_true').is(':checked');
	var type=$(this).data('type');
	var city=$(this).data('city');
	var start = $(this).data('starttime');
	var end = $(this).data('endtime');
	if(start){
		var v = start+"-"+end+"|"+size+"|"+type+"|"+city;
	} else {var v = retired+"|"+size+"|"+type+"|"+city;}
	$(this).attr('id',v);
}	);
}

populateLeadBox();

$('input#retired_true').click(function(){
	populateLeadBox();
});

$("input[name='blocksize']").blur(function(){
	populateLeadBox();
});


$('.sendleads').editable('{{URL::to("lead/assignleads")}}',{
	data : '<?php echo  json_encode($arr);?>',
	type:'select',
	submit:'OK',
    	indicator : '<img src="https://s3.amazonaws.com/salesdash/loaders/56.gif">',
    	width:'40',
    	callback: function(value, settings){
    	
var myarr = value.split("|");
var city = myarr[1];
var count = myarr[2];
var message = myarr[3];

    	$('.leadMessage').hide().addClass('animated fadeInUp');
    	$('.leadMessage').html("<i class='cus-telephone'></i>&nbsp; "+message).show();
    	toastr.success(message,'Leads Assigned...');
$('#'+city).html(parseInt(count)).show();
$('.sendleads').each(function(v, val){
	var x =$(this).html().split("|");
	$(this).html(x[0]);
});
    		//window.location.reload(true);
    	}
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

$('.unassignleads').click(function(){
	$('.sorting-anim').hide();
	$('.unassign-anim').show();
	$('.assignleadsAnim').show();
	
});

$('.sortleads').click(function(){
var city = $(this).data('city');
$('.sorting-anim').show();
$('.unassign-anim').hide();
$('.assignleadsAnim').show();
if(city){
	var data={city:city};
} else {
	var data = {};
}

setTimeout(function(){
	$.getJSON('../lead/sortleads',data,function(data){
	if(data){
	$('.assignleadsAnim').hide();
	
	$('#sortleads').html("<i class='cus-arrow-redo'></i>&nbsp;&nbsp;RE-SORT ALL LEADS<br><font color='yellow'>"+data+"</font>");
	location.reload();
} else {
	toastr.error("Lead sort failed","SORT FAILED!");
}
});
},1000);
});

});
</script>
@endsection