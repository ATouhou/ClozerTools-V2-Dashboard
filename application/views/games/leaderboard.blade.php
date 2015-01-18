<?php if(!isset($stats)){$stats['month']=Stats::saleStats("MONTH","","");};?>

<button class='btn btn-default btn-inverse btn-small switchLeader' data-type='local'>THIS OFFICE LEADERS</button>
<button class='btn btn-default btn-small tooltwo showRegional switchLeader' data-type='regional' title='This shows regional leaderboard, but only from o ffices that are signed up with this marketing system'>REGIONAL LEADERS</button>
<button class='btn btn-default btn-mini pull-right refreshRegional' data-type='set'>Refresh </button>

<div class="leaderBoards" id="localLeaders">
<div class="row-fluid">
	<div class="span12">
	<h3 style="margin-left:22px;">Top Units Sold (Month)</h3> 
		<ul class='leaderBoardList unitList'>
		<?php $cnt=0;?>
		@foreach($stats['month'] as $k=>$st)
			@if($k!="totals")
			<?php $cnt++;?>
			<?php $user = User::find($k);?>
			@if($user)
			@if($cnt<=10)
			<?php if($cnt<=3){$cl = "";} else {$cl="hide";};?>
			@if($st['totgrossunits']!=0)
			<li class="{{$cl}} viewRepInfo smallShadow" data-id="{{$k}}" data-units="{{$st['totgrossunits']/100}}"> 
				<div style='margin-top:0px;float:left;'>
					<span class='bigCount unitList'></span>
				</div>
				@if($cnt!=10)
				&nbsp;&nbsp;&nbsp;
				@endif
				&nbsp;<b>{{$user->truncName()}}</b>
				<div style='float:right;margin-top:-4px;'>
		
			 <img src='{{URL::to("img/badges/")}}bronzecoins.png' style='width:20px;margin-left:5px;margin-top:5px;margin-bottom:8px;'>
			  <span class='tooltwo badge bronzeCoins ' title='{{$st["totgrossunits"]}} Bronze Coins'>{{$st['totgrossunits']}} UNITS </span>
		
			</div>
		    </li>
		    @endif
		    	@endif
			@endif
			@endif
		@endforeach
	</ul>
	</div>
</div>
<div class="row-fluid">
	<div class="span12">
	<h3 style="margin-left:22px;">Top Sales (Month)</h3> 
	<ul class='leaderBoardList saleList'>
		<?php $cnt=0;?>
		@foreach($stats['month'] as $k=>$st)
			@if($k!="totals")
			<?php $cnt++;?>
			<?php $user = User::find($k);?>
			@if($user)
			@if($cnt<=10)
			<?php if($cnt<=3){$cl = "";} else {$cl="hide";};?>
			@if($st['netsales']!=0)
			<li class="{{$cl}} smallShadow" data-sales="{{$st['grosssales']/100}}">
				<div style='margin-top:0px;float:left;'>
				<span class='bigCount saleList'></span>
				</div>
				@if($cnt!=10)
				&nbsp;&nbsp;&nbsp;
				@endif
				&nbsp;<b>{{$user->truncName()}}</b>
				<div style='float:right;margin-top:-4px;'>
		    	 
			  <img src='{{URL::to("img/badges/")}}silvercoins.png' style='width:20px;margin-left:5px;margin-top:5px;margin-bottom:8px;'>
			  <span class='tooltwo badge silverCoins blackText' title='{{$st["grosssales"]}} Silver Coins'>{{$st['grosssales']}} SALES</span>
			</div>
		    </li>
		    @endif
		    @endif
			@endif
			@endif
		@endforeach
	</ul>
	</div>
</div>
		
<div class="row-fluid">
	<div class="span12">
	<h3 style="margin-left:22px;">Top Close % (Month)</h3> 
	<ul class='leaderBoardList closePercentList'>
		<?php $cnt=0;?>
		@foreach($stats['month'] as $k=>$st)
			@if($k!="totals")
			<?php $cnt++;?>
			<?php $user = User::find($k);?>
			@if($user)
			@if($cnt<=10)
			<?php if($cnt<=3){$cl = "";} else {$cl="hide";};?>
			@if($st['appointment']['CLOSE']!=0)
			<li class="{{$cl}} smallShadow" data-close="{{$st['appointment']['CLOSE']}}">
				<div style='margin-top:0px;float:left;'>
				<span class='bigCount closePercentList'></span>
				</div>
				@if($cnt!=10)
				&nbsp;&nbsp;&nbsp;
				@endif
				&nbsp;<b>{{$user->truncName()}}</b>
				<div style='float:right;margin-top:-4px;'>
		    	 <img src='{{URL::to("img/badges/")}}points.png' style='width:18px;margin-left:2px;margin-top:5px;margin-bottom:8px;'>
                    <span class='tooltwo badge badge-inverse' title=' '>{{number_format($st['appointment']['CLOSE'],0,'.','')}}% </span>
                    <!--
			 <img src='{{URL::to("img/badges/")}}goldcoins.png' style='width:20px;margin-left:5px;margin-top:5px;margin-bottom:8px;'>
			  <span class='tooltwo badge goldCoins blackText' title='{{$user->gold_points}} Gold Coins'>{{$user->gold_points}} </span>
			  <img src='{{URL::to("img/badges/")}}silvercoins.png' style='width:20px;margin-left:5px;margin-top:5px;margin-bottom:8px;'>
			  <span class='tooltwo badge silverCoins blackText' title='{{$user->silver_points}} Silver Coins'>{{$user->silver_points}} </span>
			-->
			</div>
		    </li>
		    @endif
		    	@endif
			@endif
			@endif
		@endforeach
	</ul>
	</div>
</div>
</div>


<div class='leaderBoards' id="regionalLeaders" style="display:none;">
<div class="row-fluid">
	<div class="span12">
	<h3 style="margin-left:22px;">Top Units Sold (Month)</h3> 
		<ul class='leaderBoardList regional-unitList'>
			<center>
			<img src='{{URL::to("img/loaders/misc/100.gif")}}'>
		    	</center>
		</ul>
	</div>
</div>

<div class="row-fluid">
	<div class="span12">
	<h3 style="margin-left:22px;">Top Sales (Month)</h3> 
	<ul class='leaderBoardList regional-saleList'>
			<center>
			<img src='{{URL::to("img/loaders/misc/100.gif")}}'>
		    	</center>
	</ul>
	</div>
</div>
		
<div class="row-fluid">
	<div class="span12">
	<h3 style="margin-left:22px;">Top Close % (Month)</h3> 
	<ul class='leaderBoardList regional-closeList'>
		
			<center>
			<img src='{{URL::to("img/loaders/misc/100.gif")}}'>
		    	</center>
		    
	</ul>
	</div>
</div>	
</div>
<script>
$(document).ready(function(){
	var regionalToggle=0;

	$('.refreshRegional').click(function(){
		var img = "{{URL::to_asset('img/loaders/misc/100.gif')}}";
		$('.regional-unitList').html("<center><img src='"+img+"'></center>");
		$('.regional-saleList').html("<center><img src='"+img+"'></center>");
		$('.regional-closeList').html("<center><img src='"+img+"'></center>");
		allReps=[];
		regionalToggle=0;
		localStorage.removeItem("regionalData");
		setTimeout(function(){
			$('.showRegional').trigger('click');
		},500);
	});

	function sortList(listName,dataName){
		var $people = $('ul.'+listName),
		$peopleli = $people.children('li');
		$peopleli.sort(function(a,b){
		var an = a.getAttribute(dataName),
			bn = b.getAttribute(dataName);
			if(an < bn) {
				return 1;
			}
			if(an > bn) {
				return -1;
			}
			return 0;
		});
		$peopleli.detach().appendTo($people);
		var cnt=0;
		$peopleli.each(function(i,val){
			cnt++;
			$(this).find('span.'+listName).html(cnt);
			if(cnt>5){
				$(this).hide();
			}
		});
	}
	sortList('closePercentList','data-close');
	sortList('unitList','data-units');
	sortList('saleList','data-sales');


	$('.switchLeader').click(function(){
       	var type=$(this).data('type');
       	$('.switchLeader').removeClass('btn-inverse');
       	$(this).addClass('btn-inverse');
       	$('.leaderBoards').hide();
       	$('#'+type+'Leaders').show();
       	if(type=="regional"){
       		if(regionalToggle==0){
       			if(localStorage && localStorage.getItem("regionalData")){
       				applyRegionalData("localstorage");
       			} else {
       				getRegionalData();
       			}
       			regionalToggle=1;
       		}
       		
       	}
    	})
	var site = "{{URL::to()}}";
	var allReps = [];
	function getRegionalData(){
		
		var ap = "/presentation/monthlystats";
		var urls=[
			"http://sales-dash.aws.af.cm",
			"http://atlasair.aws.af.cm",
			"http://breatheezhomes.aws.af.cm",
			"http://puretek.aws.af.cm",
			"http://purusair.aws.af.cm",
			"http://qualityair.aws.af.cm",
			"http://quality-air.aws.af.cm",
			"http://foxvalleyair.aws.af.cm",
			"http://cyclonicfiltration.aws.af.cm",
			"http://ribmountain.aws.af.cm",
			"http://avaerosair.aws.af.cm",
			"http://mdhealthsystems.aws.af.cm",
			"http://mdhealth2.aws.af.cm",
			"http://pureair.aws.af.cm",
			"http://coastalaire.aws.af.cm",
			"http://healthtek.aws.af.cm",
			"http://triadair.aws.af.cm"
		]
		$.each(urls,function(i,val){
			$.ajax({
      		      url: val+ap,
      		      async: false,
      		      success: function(data) {
      		          	$.each(data,function(i,val){
						allReps.push({
							'name':val.name,
							'rep_id':val.rep_id,
							'close':val.appointment['CLOSE'],
							'puton':val.appointment['PUTON'],
							'points':val.system_points,
							'bronze':val.bronze_points,
							'silver':val.silver_points,
							'gold':val.gold_points,
							'units':val.totgrossunits,
							'sales':val.grosssales,
							'company':val.company,
							'icon':val.shortcode
						});
					});
      		      }
      		});
		});

		setTimeout(applyRegionalData,2000);
	}

	function applyRegionalData(type){
		if(type=="localstorage"){
			allReps = JSON.parse(localStorage.getItem("regionalData"));
		}
		var html="";var cnt=0;
		var html2=""; var html3="";
		     	$.each(allReps,function(i,val){
     				if(val.name!="totals"){
     					cnt++;cl="";
     					html+= "<li class='"+cl+" darkList  smallShadow' data-id='"+val.rep_id+"' data-units="+val.units/100+">";
     					html2+="<li class='"+cl+" darkList  smallShadow' data-id='"+val.rep_id+"' data-sales="+val.sales/100+">";
     					html3+="<li class='"+cl+" darkList smallShadow' data-id='"+val.rep_id+"' data-close="+val.close+">";
     					
     					html+="<div style='margin-top:0px;float:left;margin-right:10px;'><span class='bigCount regional-unitList'></span></div>";
     					html2+="<div style='margin-top:0px;float:left;margin-right:10px;'><span class='bigCount regional-saleList'></span></div>";
     					html3+="<div style='margin-top:0px;float:left;margin-right:10px;'><span class='bigCount regional-closeList'></span></div>";
     					
     					html+="<b>"+val.name+"</b> | "+val.company+" &nbsp; <img src='"+site+"images/logo-"+val.icon+".png' style='width:67px'>";
     					html2+="<b>"+val.name+"</b> | "+val.company+" &nbsp; <img src='"+site+"images/logo-"+val.icon+".png' style='width:67px'>";
     					html3+="<b>"+val.name+"</b> | "+val.company+" &nbsp; <img src='"+site+"images/logo-"+val.icon+".png' style='width:67px'>";

     					html+="<div style='float:right;margin-top:-4px;'>";
     					html2+="<div style='float:right;margin-top:-4px;'>";
     					html3+="<div style='float:right;margin-top:-4px;'>";
     					//html+="<img src='' style='width:20px;margin-left:5px;margin-top:5px;margin-bottom:8px;'>";
     					html+="<span class='tooltwo badge bronzeCoins ' title=' Bronze Coins'>"+val.units+" Units </span></div>";
     					html2+="<span class='tooltwo badge silverCoins blackText' title=' Silver Coins'>"+val.sales+" Sales </span></div>";
     					html3+="<span class='tooltwo badge badge-inverse ' title=' Bronze Coins'>"+val.close+"% </span></div>";
     					html+="</li>"; html2+="</li>"; html3+="</li>"; 
     				}
			});
		$('.regional-unitList').html("").append(html);
		$('.regional-saleList').html("").append(html2);
		$('.regional-closeList').html("").append(html3);
		sortList('regional-closeList','data-close');
		sortList('regional-unitList','data-units'); 
		sortList('regional-saleList','data-sales');
		localStorage.setItem("regionalData",JSON.stringify(allReps));
	}
});
</script>
