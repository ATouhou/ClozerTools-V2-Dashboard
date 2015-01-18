@layout('layouts/main')
@section('content')
<script src="{{URL::to_asset('js/include/guage.min.js')}}"></script>
<script>
function getguageslim(gval, element, max, linecolor, backcolor, guagewidth){
var opts = {
  lines: 22, 
  angle: 0,
  lineWidth: guagewidth, 
  pointer: {
    length: 0.9, 
    strokeWidth: 0.08,
    color: linecolor
  },
  limitMax: 'true',   
  colorStart: '#002906',  
  colorStop: '#00DA41',    
  strokeColor: backcolor,  
  generateGradient: true
};
var target = document.getElementById(element); 
var gauge = new Gauge(target).setOptions(opts); 
gauge.maxValue = max; 
gauge.animationSpeed = 32; 
if(gval>max){
    theValue = max;
} else if(gval==0){
    theValue = 0.01;
} else {
    theValue = gval;
}
gauge.set(theValue); 

}
</script>



         	<div id="pureOpInfoPanel" class="animated fadeInUp row-fluid " style="padding:30px;width:98%;"  >
            <input type="hidden" id="thisSiteURL" value="{{URL::to('presentation/pureop')}}" />

            @if($settings->pureop_stats==1)
         		@if($settings->other_offices==1)
                <div class="span12" style="padding-top:10px;">
                    <div class="pull-right" style="margin-right:50px;">
                    @if($settings->contests==1)
                      <button class=' btn btn-default viewTeslaContest' style="margin-top:-10px;"><img src='{{URL::to("images/teslalogo.png")}}' style="width:30px;">&nbsp;&nbsp;TESLA CONTEST </button>&nbsp;&nbsp;
                      <!--<button class=' btn btn-default viewTeslaContest' style="margin-top:-10px;margin-right:20px;"><img src='{{URL::to("images/teslalogo.png")}}' style="width:30px;">&nbsp;&nbsp;REV-UP CONTEST </button>-->
                      <button class=' btn btn-default viewRevupContest' style="padding:12px;margin-top:-10px;margin-right:20px;"><img src='{{URL::to("images/revup-fordlogo.png")}}' width=50px>&nbsp;&nbsp;REV-UP CONTEST </button>
                     @endif

                     @if($settings->leaderboard==1)
                      <button class="btn btn-default  viewleaderBoards" style="margin-top:-10px;padding:12px;margin-right:20px;"><img src='{{URL::to("images/sales.png")}}' style="width:30px;">&nbsp;&nbsp;LEADERBOARDS</button>
                      @endif
                      </div>
                </div>
                 <div class="row-fluid leaderBoardMain" style="display:none;">
                    @include('dashboard.stats.leaderboards')
                	</div>
                

        		<div class="span12" style="padding-bottom:15px;" >
        			<h4 style="margin-top:5px;margin-bottom:5px;color:#fff;">View Other Offices</h4>
                    <?php $cnt = 0;$cnt_left=0?>
        		      @foreach($companies as $c)
                       <?php if($c->shortcode==$settings->shortcode){
                            $cnt = $c->contest_totals;
                            $cnt_left = $c->contest_left;
                        };?>
        		        <button class="btn btn-default btn-mini loadOffice" data-office="{{$c->web_address}}">{{$c->company_name}}</button>
        		      @endforeach
                </div>
        		@endif
            @if($settings->contests==1)
            <div class="row-fluid revupCONTEST" style="display:none;float:left;margin-top:20px;" >
                <div class="span5">
                	<img class="animated fadeInUp" src="{{URL::to_asset('images/revup-contest.png')}}" style="margin-left:-10px;"><br/>
                	<h4 style='color:#fff;'>&nbsp;Probability of Winning : <span class='revupProbability'></span></h4 style='color:#000;'>
                </div>
                <div class="span3">
                <h4 style="color:#fff;font-size:34px;" ><span class='totalTickets'></span> Tickets Earned for Contest</h4 >
                    <div class="span12 revupTickets">
                    	No Tickets
                    </div>
                <br/>
                </div>
                <div class="span4">
                	<img class="animated slideInRight " src="{{URL::to('images/revup-mustang.png')}}">
                </div>
            </div>
                <?php 
                $randomimg = URL::to('images/')."2015mustangback".rand(1,5).".jpg"; 
                ?> 
                <div class="span8 well revupCONTEST" style="margin-left:-0px;background:url('{{$randomimg}}');background-size:100%;display:none;float:left;margin-top:20px;margin-bottom:80px;">
                
                <div class="span8" style="margin-bottom:50px;">
                <h4 class='revupHeader' style='color:#fff;'>Your Dealers Sales / Tickets Earned</h4>
                    <table class="table table-bordered animated fadeInUp"  style="border:1px solid #1f1f1f;background:white;color:#000;font-size:12px;" >
                        <thead style="">
                            <tr style="background:#eee;">
                                <th style="width:15%;">Dealer</th>
                                <th><center>Month 1 </center></th>
                                <th><center>Month 2 </center></th>
                                <th><center>Month 3 </center></th>
                                <th style="width:20%;"><center>Total Tickets </center></th>
                            </tr>
                        </thead>
                        <tbody id="revupRepTable">
                        	
                        </tbody>
                        </table>
                </div>
                
                <div class="span4" style="margin-bottom:50px;">
                    <h4 style='color:#fff;'>Other Distributors Tickets</h4>
                    <table class="table table-bordered animated fadeInUp"  style="border:1px solid #1f1f1f;background:white;" >
                        <thead style="">
                            <tr style="background:#eee;">
                                <th style="width:75%;">DISTRIBUTOR</th>
                                <th><center>Tickets </center></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($companies as $c)
                        <tr class="companyRow shortcode-{{$c->shortcode}}" data-shortcode="{{$c->shortcode}}" data-site="{{$c->web_address}}">
                            <td ><button class='btn btn-default btn-small viewOtherCompanyRevup' data-name='{{$c->company_name}}' data-site='{{$c->web_address}}' data-shortcode='{{$c->shortcode}}'><b style="color:#000;font-size:15px;">{{$c->company_name}}</b></button>
                            </td>
                            <td class="revupcompany-{{$c->shortcode}}"><center><img src='{{URL::to("img/loaders/misc/66.gif")}}' width=30px></center></td>
                        </tr>
                        @endforeach
                        </tbody>
                        </table>
                      
                </div>

            </div>

            <div class="span3 revupCONTEST" style="display:none;margin-top:15px;">
                     <div class="span11 well revupRules" style="background:white;padding-left:50px;padding-right:35px;">
                        <h4>Rules</h4>
                        <b style='color:#000;font-size:13px;'>How to Get Your Single Outlet’s Name into the Drawing: </b><br/>

                <ul style="padding:10px;">
                    <li> For every Specialist that achieves one <b>(1) calendar month</b> (October, November or December during the Contest period) of <b>10 System</b> Sales or <b>30 Units (net sales)</b>, that Single Outlet will receive one <b>(1) ticket</b> into the drawing. </li><br/>
                    <li> If the same Specialist achieves <b>10 System</b> Sales or <b>30 Units (net sales)</b> for a 2nd month during the contest, the Single Outlet receives two <b>(2)additional tickets</b> into the drawing.  </li><br/>
                    <li>If that same Specialist achieves <b>10 System</b> or <b>30 Units (net sales)</b> again the 3rd month of the contest, the Single Outlet receives three <b>(3) additional tickets</b> into the drawing.</li>
                </ul>
                <i style='font-size:14px;'>Bottom line - if you have a Specialist that qualifies for each of the three months during the contest period, that Specialist alone would earn their Single Outlet a total of six tickets into the drawing!</i><br/><br/>

                <b style='color:#000;'>Five (5) Specialist’s Names Will Be Drawn from All Eligible Ticket Entries at the Conclusion of the Contest:</b><br/>
                <h5 style='color:#000'>The Single Outlet of the Last Name Drawn will be the Grand Prize Winner of the <img src='{{URL::to("images/revup-fordlogo.png")}}' width=50px> Mustang!</h5 style='color:#000'>
                
                </div>

            </div>
            <script>
            $(document).ready(function(){
            	var revup_toggle=0;
			$('.viewRevupContest').click(function(){
				var url = "{{URL::to('presentation/revupcontest')}}";
				$('#teslaContestTable').hide();
                $('.leaderBoardMain').hide();
			      $('.revupCONTEST').toggle(200);
			    	if(revup_toggle==0){
			        	getRevUpContestStats(url);
			        	 $('.companyRow').each(function(i,val){
                        		var site = $(this).data('site')+"/presentation/revupcontest";
                        		var short_code = $(this).data('shortcode');
                        		var th = $(this); var img="";
                        		setTimeout(function(){
                        		$.getJSON(site,function(data){
                        			$('.revupcompany-'+short_code).html("<center><span class='label label-warning totalStat special blackText'>"+data.totaltickets+"</center></span>");
                        		});},1000);
                        	});
			        	revup_toggle=1;
			    	}
			});

			$('.viewOtherCompanyRevup').click(function(){
				var site = $(this).data('site');
				site+="/presentation/revupcontest";
				var name = $(this).data('name');
				$('.revupHeader').html(name + "Sales / Tickets Earned");
				getRevUpContestStats(site);
			});

			function getRevUpContestStats(url){
				var img = "{{URL::to('img/loaders/misc/66.gif')}}";
				var ticket = "{{URL::to('images/pureop-ticket.png')}}";
                var img2 = "{{URL::to('img/loaders/misc/100.gif')}}";
                $('#revupRepTable').html("<tr><td><img src='"+img2+"' style='width:50px;'></td><td><img src='"+img2+"' style='width:50px;'></td><td><img src='"+img2+"' style='width:50px;'></td><td><img src='"+img2+"' style='width:50px;'></td></tr>");
				$.getJSON(url,function(data){
			        	var html="";var totTickets = 0 ;
			        	$.each(data,function(i,val){
			        		if(i!="totaltickets"){
			        			if(val.hasvalues==true){
			        			var repsTickets = 0;
			        			html+="<tr><td><b style='font-size:13px;'>"+val.name+"</b></td>";

                                		if(val.m1tickets>0){ cl = "wonTickets";} else {cl="";};
			        			html+="<td class='"+cl+"'><span class='label label-warning blackText special largeText'>"+(parseInt(val.m1system)+parseInt(val.m1hybrid))+"</span> Systems (Maj/Def)";
			        			
                                		if(val.m1tickets>0){
			        				repsTickets+=parseInt(val.m1tickets);
			        				totTickets+=parseInt(val.m1tickets);
			        			}
			        			html+="</td>";

                                		if(val.m2tickets>0){ cl = "wonTickets";} else {cl="";};
                                		html+="<td class='"+cl+"'><span class='label label-warning blackText special largeText'>"+(parseInt(val.m2system)+parseInt(val.m2hybrid))+"</span> Systems (Maj/Def)";
                                		
                                		if(val.m2tickets>0){
                                		    repsTickets+=parseInt(val.m2tickets);
                                		    totTickets+=parseInt(val.m2tickets);
                                		}
                                		html+="</td>";

                                if(val.m3tickets>0){ cl = "wonTickets";} else {cl="";};
                                html+="<td class='"+cl+"'><span class='label label-warning blackText special largeText'>"+(parseInt(val.m3system)+parseInt(val.m3hybrid))+"</span> Systems (Maj/Def)";
                              
                                if(val.m3tickets>0){
                                    repsTickets+=parseInt(val.m3tickets);
                                    totTickets+=parseInt(val.m3tickets);
                                }
                                html+="</td>";

			        			html+="</td><td>";
			        			if(repsTickets>0){
			        				for(var i=0;i<repsTickets;i++){
			        					html+="<img src='"+ticket+"' style='width:32px;margin-top:-10px;margin-left:-10px;'>";
			        				}
			        			}
			        			html+="</td>";
			        			html+="</tr>";
			        			}
			        		}
			        	});
					var prob = 0;var odds=0;
			        	if(totTickets>0){
			        		$('.revupTickets').html("");
			        		odds = ((1/(totTickets/150))-1).toFixed(1);
			        		prob = ((totTickets/150)*100).toFixed(0);
			        		$('.totalTickets').html(totTickets);
			        		for(var i=0;i<totTickets;i++){
			        			$('.revupTickets').append("<img src='"+ticket+"' style='width:45px;margin-left:-15px;'>");
			        		}
			        	} else {
			        		$('.revupTickets').html("");
			        		$('.totalTickets').html("");
			        	}
			        	$('.revupProbability').html("<span class='label label-warning blackText special '>"+odds+" / 1</span> or <span class='label label-warning blackText special '>"+prob+"%</span>");
			        	$('#revupRepTable').html(html);
			        });
			}

            });
            </script>	

            <div class="row-fluid well" id="teslaContestTable" style="display:none;float:left; margin-top:30px;">
                @if(empty($settings->contest_buffer) || $settings->contest_buffer==0)
                <div class="span12">
                <center>
                <h2> You Haven't Entered Your Current Unit Count for the Tesla Contest</h2>
                <h4>In Order to display and view the contest module, you need to update it with your current unit count</h4>
                <p> Go to the <a href='{{URL::to("system/settings")}}'>settings</a> page to do that</p>
                <br/>
                <a href='{{URL::to("system/settings")}}' class="btn btn-default">GO TO SETTINGS</a>
                </center>
                <br/><br/><br/>
                </div>
                <script>
                $(document).ready(function(){
                	$('.viewTeslaContest').click(function(){
                		$('#teslaContestTable').toggle(200);
                		$('.revupCONTEST').hide();
                        $('.leaderBoardMain').hide();
                	});
                });
                </script>
                @else
               
                <div class="span3 teslaBox well">
                    <img src='{{URL::to("images/tesla.jpg")}}' style="border-radius:12px;border:1px solid #aaa;">
                    <br/><br/>
                    <div class="span12">
                    <center>
                    Your Progress : 
                        <canvas id="teslaguage" data-value="{{$cnt}}" style="width:88%;"></canvas>
                    </center>
                    <br/>
                        <span class="shortcode-{{$settings->shortcode}} " >You have <span class='company-contestunits label label-success bigtext special'></span> contest units</span>
                        <br/><br/>
                        <span class="shortcode-{{$settings->shortcode}} ">You need <span class='company-contestleft label label-info bigtext special'></span> units to win</span><br/>
                        <br/><br/>
                        <center>
                        <img src='{{URL::to("images/teslalogo.png")}}' style="width:99px;">
                        </center>
                        <br/>
                    </div>
                </div>
                <div class="span9">
                	
                    <table class="table table-bordered animated fadeInUp"  style="border:1px solid #1f1f1f;background:white;" >
                        <thead style="">
                            <tr style="background:#eee;">
                                <th style="width:22%;">DISTRIBUTOR</th>
                                <th><center>Month Sales</center></th>
                                <th><center>Month Units</center></th>
                                <th><center>Contest Units</center></th>
                                <th><center>Units Left</center></th>
                                <th style="width:33%;"><center>Contest Progress</center></th>
                            </tr>
                            
                        </thead>
                        <tbody>
                        @foreach($companies as $c)
                        <tr class="companyRow shortcode-{{$c->shortcode}}" data-shortcode="{{$c->shortcode}}" data-site="{{$c->web_address}}">
                            <td ><b style="color:#000;font-size:15px;">{{$c->company_name}}</b>
                            <br/>
                            <button class='btn btn-default btn-mini showTopReps' data-code="{{$c->shortcode}}" >Show Top Reps For Month</button><br/>
                            	<div class='company-topreps topreps-{{$c->shortcode}}' style='padding:9px;'></div>
                            </td>
                            <td valign="middle"><center><span class="label label-inverse special bigbox  company-monthsales"></span></center></td>
                            <td valign="middle"><center><span class="label label-inverse special bigbox  company-monthunits"></span></center></td>
                            <td valign="middle"><center><span class="label label-success special blackText bigbox  company-contestunits "></span></center></td>
                            <td valign="middle"><center><span class="label label-info special bigbox   company-contestleft "></span></center></td>
                            <td><center>
                            		<div class=" progress progOuter-{{$c->shortcode}} " data-type="progress" data-id="22" style="width:90%;">
                                    	<div class="bar filled-text progID-{{$c->shortcode}}" data-percentage="" style="width:0%;"></div>
                                	</div>
                              </center>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                        </table>
                </div>
                <script>
            	$(document).ready(function(){
            		$('.showTopReps').click(function(){
            			var short_code = $(this).data('code');
            			$('.company-topreps').hide();
            			$('.topreps-'+short_code).show();
            		});
            		
            		var teslaguage= $('#teslaguage').data('value');
				getguageslim(teslaguage, 'teslaguage', 12000,'#000','#6e6e6e',0.17);
                		var img = "{{URL::to('img/loaders/misc/66.gif')}}";
                		$('.companyRow span').html("<img src='"+img+"' style='width:11%;'>");
                		var tesla_toggle=0;

                $('.viewTeslaContest').click(function(){

                    if(tesla_toggle==0){
                        $('.companyRow').each(function(i,val){
                        var site = $(this).data('site')+"/presentation/contest";
                        var short_code = $(this).data('shortcode');
                        var th = $(this); var img="";
                        setTimeout(function(){
                        $.getJSON(site,function(data){
                            if(data=="notenabled"){
                                th.find('span').html("Not Enabled");
                            } else {
                            	 var progressClass="";
                            	if(data.contest_totals>0){
                            	 	var progress = (parseInt(data.contest_totals)/parseInt(data.contest_goal))*100;
                            	 } else {
                            	 	progress=0;
                            	 }
                                var dat = data.top_reps.split("+");
                                var reps="";
                                $.each(dat,function(i,val){
                                	var rep_dat = val.split("|");
                                	if(rep_dat[2]=="avatar.jpg"){
                                		var site = $('#thisSiteURL').val();
                                		img = site+"images/avatar.jpg";
                                	} else {
                                		img = rep_dat[2];
                                	}
                                	reps+="<div style='float:left;width:100%;'><img src='"+img+"' style='width:29px;margin-right:6px;border:1px solid #1f1f1f;'>&nbsp;<span class='label label-info bigbox special'>"+rep_dat[1]+" Units</span><br/>"+rep_dat[0]+"</div><br/>";
                                
                                });
                                if(progress<=20){ progressClass="progress-danger";}
                                else if(progress>20 && progress<=35){ progressClass="progress-warning";}
                                else if(progress>35 && progress<=65){progressClass="progress-info";}
                                else if(progress>65 && progress<=85){progressClass="progress-info";} 
                                else {progressClass="progress-success blackText";}
                                $('.progOuter-'+short_code).addClass(progressClass);
                                $('.progID-'+short_code).css('width',progress+'%').html(progress.toFixed(0)+'% ');
                                $('.shortcode-'+short_code+' div.company-topreps').html(reps).hide();
                                $('.shortcode-'+short_code+' span.company-monthnetmaj').html(data.net_maj);
                                $('.shortcode-'+short_code+' span.company-monthnetdef').html(data.net_def);
                                $('.shortcode-'+short_code+' span.company-monthsales').html(data.month_total);
                                $('.shortcode-'+short_code+' span.company-monthunits').html(data.month_units);
                                $('.shortcode-'+short_code+' span.company-contestunits').html(data.contest_totals);
                                $('.shortcode-'+short_code+' span.company-contestleft').html(data.contest_left);
                            }
                        })
                        .fail(function() { th.hide();  });
                        },400);
                        });
                    }
                    $('#teslaContestTable').toggle(200);
                });
            });
            </script>
                @endif
            </div>
            
            @endif

   			<div class="span12 backToList" style="display:none;" >
   				<button class="backToList btn btn-success btn-large" style="margin-left:0px;margin-top:15px;">BACK TO DEALER LIST</button>
   			</div>
   		    <div class="repInfo-charts" >

            </div>



         	<div class="pureOpInfoPanel" >
         		<br/><br/><br/>
         		<center>
         			<img src="{{URL::to('img/loaders/misc/200.gif')}}">
         		</center>
         	</div>
         	</div>
         	@else
         	<br><br>
         	<center>
         	<h4>You do not have the Pure Opportunity Module Enabled</h4>
         	<p> Go to the <a href='{{URL::to("system/settings")}}'>settings</a> page to do that</p>
         	<br/>
         	<a href='{{URL::to("system/settings")}}' class="btn btn-default">GO TO SETTINGS</a>
         	<br/><br/>
         	</center>
         	@endif
         	

    @if($settings->pureop_stats==1)
        
<script>
$(document).ready(function(){
    $('.pureOpInfoPanel').load("{{URL::to('presentation/pureop/')}}?viewMyself=true");
});
</script>
        
    @endif


<script>
$(document).ready(function(){

    $('.loadOffice').click(function(){
        $('.repInfo-charts').hide();
        $('.backToList').hide();
        $('.pureOpInfoPanel').show();
        var src = "{{URL::to_asset('img/loaders/misc/200.gif')}}";
        var site = $('#thisSiteURL').val();
        var office = $(this).attr('data-office')+'/presentation/pureop';
        if(site==office){
                office+="?viewMyself=true";
        }
        $('.loadOffice').removeClass('btn-inverse');
        $('.pureOpInfoPanel').html("<center><img style='margin-left:125px;margin-top:100px;' src="+src+"></center><br/><br/><br/>")
       
        $('.pureOpInfoPanel').load(office);
        $(this).addClass('btn-inverse');


        
});

 $(document).on('click','.viewProfile',function(){
            var id = $(this).data('id');
            var site = $(this).data('site');
            window.location.href = '../users/viewprofile/' + id+'?viewDistributor='+site;
            
        });


});
</script>

@endsection