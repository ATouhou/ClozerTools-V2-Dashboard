<div class="fluid-container">
      		
					<div id="cityImage">
						<img src='{{URL::to("img/loaders/misc/100.gif")}}'>
					</div>
					<div id="cityData" style="margin-top:-55px;">
					<h1 style='color:#000;'>{{$city->cityname}}</h1>
					@if($city->getCityStat("Number of persons ")!=0)
					Population : <br/><br/>
					<span style='font-size:60px;color:#bbb;font-weight:bolder;'>{{$city->getCityStat("Number of persons ")}}</span><br/><br/>
					@if(isset($stats["Median total income, both sexes (dollars)"]))
							<div style="width:33%;float:left;margin-top:-10px;margin-bottom:8px;">
							<b>Average Income</b><br/><br/>
							<span style='font-size:45px;color:#ccc;font-weight:bolder;margin-top:-10px;'>${{number_format($stats["Median total income, both sexes (dollars)"]->value,0,'.',',')}}</span><br/>
							
							</div>
						@endif
						@if(!empty($stats))
						<table class='table table-responsive table-condensed'  style="font-size:16px;">
							@if(isset($stats["Average age of People (years)"]))
							<tr><td>Average Age of People</td><td>{{$stats["Average age of People (years)"]->value}} yrs</td></tr>
							@endif
							@if(isset($stats["Percentage of People, married"]))
							<tr><td>Percentage Married &nbsp;<span class='smallStat'>{{$stats["Percentage of People, married"]->people}}</span></td><td> {{$stats["Percentage of People, married"]->value}} %</td></tr>
							@endif
							@if(isset($stats["Total income $50,000 and over"]))
							<tr><td>Income over $50K &nbsp;<span class='smallStat'>{{$stats["Total income $50,000 and over"]->people}}</span></td><td>{{$stats["Total income $50,000 and over"]->value}} %</td></tr>
							@endif
							@if(isset($stats["Total income $75,000 and over"]))
							<tr><td>Income over $75K &nbsp;<span class='smallStat'>{{$stats["Total income $75,000 and over"]->people}}</span></td><td>{{$stats["Total income $75,000 and over"]->value}} %</td></tr>
							@endif
							<!--@if(isset($stats["Total income $100,000 and over"]))
							<tr><td>Income over $100K &nbsp;<span class='smallStat'>{{$stats["Total income $100,000 and over"]->people}}</span></td><td>{{$stats["Total income $100,000 and over"]->value}} %</td></tr>
							@endif
							@if(isset($stats["Percentage of persons in apartments"]))
							<tr><td>Percentage In Apartments / Rentals &nbsp;<span class='smallStat'>{{$stats["Percentage of persons in apartments"]->people}}</span></td><td>{{$stats["Percentage of persons in apartments"]->value}} %</td></tr>
							@endif-->
						</table>
						@endif
					@else
					No Government Data Available
					@endif
					</div>

					<div style="width:100%;float:left;height:150px;padding-bottom:5px;margin-bottom:20px;border-bottom:1px solid #ccc;" >
						@if(!empty($stats))
						<br/>
							@if(isset($stats["Percentage of persons aged 0 to 24 years"]))
							<div class='ageImage animated rollIn'>
								<img src='{{URL::to("img/age-young.png")}}'><br/>
								<div class='ageStat medShadow'><b>{{$stats["Percentage of persons aged 0 to 24 years"]->value}} %</b></div>
							</div>
							@endif
							@if(isset($stats["Percentage of persons aged 25 to 44 years"]))
							<div class='ageImage animated rollIn'>
								<img src='{{URL::to("img/age-youngmid.png")}}'><br/>
								<div class='ageStat medShadow'><b>{{$stats["Percentage of persons aged 25 to 44 years"]->value}} %</b></div>
							</div>
							@endif
							@if(isset($stats["Percentage of persons aged 45 to 64 years"]))
							<div class='ageImage animated rollIn'>
								<img src='{{URL::to("img/age-middle.png")}}'><br/>
								<div class='ageStat medShadow'><b>{{$stats["Percentage of persons aged 45 to 64 years"]->value}} %</b></div>
							</div>
							@endif
							@if(isset($stats["Percentage of persons aged 65 years and over"]))
							<div class='ageImage animated rollIn'>
								<img src='{{URL::to("img/age-old.png")}}'><br/>
								<div class='ageStat medShadow'><b>{{$stats["Percentage of persons aged 65 years and over"]->value}} %</b></div>
							</div>
							@endif

					@endif
					</div>
					<?php $totalLeads = 0;$totalContact = 0;
						$totalSOLD=0;$totalDNS=0;$totalUncontact=0;$lt="";
						$totalBooked=0;$arr=array();?>
					@if(!empty($cityStats))
						<?php
						
						foreach($cityStats as $st){
							$totalLeads+= $st->cnt;
							$totalBooked+=$st->booked;
							$totalSOLD+= $st->sold;
							$totalDNS+= $st->dns;
							$totalContact+= $st->contact;
							$totalUncontact+= $st->uncontact;
							if($st->original_leadtype=="door"){
								$lt = "Door Reggie";
							} 
							if($st->original_leadtype=="paper"){
								$lt = "Manilla / Paper";
							} 
							if($st->original_leadtype=="other"){
								$lt = "Scratch Card";
							} 
							if($st->original_leadtype=="survey"){
								$lt = "Fresh Survey";
							} 
							if($st->original_leadtype=="ballot"){
								$lt = "Ballot Box";
							} 
							if($st->original_leadtype=="personal"){
								$lt = "Personal Lead";
							} 
							if($st->original_leadtype=="referral"){
								$lt = "Referral Lead";
							} 
							if($st->original_leadtype==""){
								$lt = $st->leadtype;
							} 
							if($st->original_leadtype!=""){
								$arr[$lt] = $st;
							}
							
						};
						if($totalBooked!=0){
							$totalBOOKPER = number_format(($totalBooked/$totalContact)*100,1,'.','')."%";
						} else {
							$totalBOOKPER = 0;
						};
						if($totalSOLD!=0 && $totalDNS!=0){
							$close = $totalSOLD/($totalSOLD+$totalDNS);
							$totalCLOSE = number_format($close*100,1,'.','')."%";
						} else {
							$totalCLOSE= 0;
						};
						?>
					@endif
					<div style="width:100%;float:left;padding-left:30px;margin-top:10px;margin-bottom:20px;">
						
						<div style="width:20%;float:left;">
							<span style='font-size:55px;color:#99FF99;font-weight:bolder;'>{{$totalSOLD}}</span> <br/>
							<b>Sales</b>
						</div>
						<div style="width:20%;float:left;">
							<span style='font-size:55px;color:#FF6666;font-weight:bolder;'>{{$totalDNS}}</span> <br/>
							<b>DNS</b>
						</div>
						<div style="width:25%;float:left;">
							<span style='font-size:45px;color:#ccc;font-weight:bolder;'>{{$totalCLOSE}}</span> <br/>
							<b>Close %</b>
						</div>
						<div style="width:25%;float:left;">
							<span style='font-size:45px;color:#ccc;font-weight:bolder;'>{{$totalBOOKPER}}</span> <br/>
							<b>Book %</b>
						</div>

					</div>


					<div style="width:90%;float:left;padding-left:30px;">
						
						<button class='btn btn-default btn-mini viewLeadtypes' style="margin-top:-17px;">LEADTYPE BREAKDOWN</button>
						<br/>
					
						<table id="totalStats" class='cityStatTable table table-responsive table-condensed' style="margin-right:10px;font-size:16px;">
							<tr>
								<td>Leads In System</td>
								<td> {{$totalLeads}}</td>
							</tr>
							<tr>
								<td>Uncontacted Leads</td>
								<td>  {{$totalUncontact}}</td>
							</tr>
							<tr>
								<td>Contacted Leads</td>
								<td> {{$totalContact}}</td>
							</tr>
							
							<tr>
								<td>Scratch Card Mailouts</td>
								<?php $sc = $city->scratchCards();?>
								<td> Qty : {{$sc['qty']}} - Cost : ${{$sc['cost']}} </td>
							</tr>
						</table>


						
					</div>
					<div  style="width:90%;float:left;padding-left:30px;">
						<table id="breakdownStats" class='cityStatTable table table-responsive table-condensed' style="display:none;margin-right:10px;font-size:16px;">
							<tr>
								<th>Leadtype</th>
								<th>Contact</th>
								<th>Un-Contacted</th>
								<th>Booked</th>
								<th>NI</th>
								<th>SOLD</th>
								<th>DNS</th>
							</tr>
							@foreach($arr as $k=>$st)
							<tr>
								<td>{{$k}}</td>
								<td>{{$st->contact}}</td>
								<td>{{$st->uncontact}}</td>
								<td>{{$st->booked}}</td>
								<td>{{$st->ni}}</td>
								<td>{{$st->sold}}</td>
								<td>{{$st->dns}}</td>
							</tr>
							@endforeach
							
							
						</table>


						
					</div>
					

                </div>    
          <?php $city = explode(",",$city->cityname);
          if(isset($city[1])){
          	$city = $city[0].",".$city[1];
          } else {
          	$city = $city[0].",".Setting::find(1)->province;
          }
          ?>

<script>

$(document).ready(function(){

	var leadTypeToggle=0;
	$('.viewLeadtypes').click(function(){
		if(leadTypeToggle==0){
			$(this).html("VIEW TOTAL STATS");
			
			$('#totalStats').hide();
			$('#breakdownStats').show();
			leadTypeToggle=1;
		} else {
			$(this).html("VIEW LEADTYPE BREAKDOWN");
			leadTypeToggle=0;
			$('#totalStats').show();
			$('#breakdownStats').hide();
			
		}
		
	});

	var citysearch = "{{$city}}";
	
	var imgURL = '{{URL::to("img/loaders/misc/100.gif")}}';
	$('#cityImage').html('<img src='+imgURL+'>');
	$.ajax({
    url: "https://ajax.googleapis.com/ajax/services/search/images?v=1.0&q="+citysearch+"&callback=?",
    dataType: "jsonp",
    	success: function(data) {
    		console.log(data);
    	    for (var i = 0; i < 1; i++) {
    	        $('#cityImage').html('<img class="cityImage medShadow" src="' + data.responseData.results[i].url + '" width=280px>' + '<br>');
    	    }
    	}
	});
});

</script>



