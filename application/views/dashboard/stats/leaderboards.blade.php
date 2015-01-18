@if(isset($fullscreen))
		<?php $well = "";?>
		@else
		<?php $well="well";?>
		@endif

<div class="row-fluid " style="margin-top:20px;">
	<div class="row-fluid">
		@if(isset($fullscreen))
		<?php $hide = "hide";?>
		@else
		<?php $hide="";?>
		@endif
		<div class="{{$hide}} span12">
			<button class='btn btn-default btn-mini btn-inverse filterCompany ' data-id='all'>ALL COMPANIES</button>
			<?php if(!isset($companies)){$companies = Company::get();}; if(!isset($settings)) {$settings=Setting::find(1);}?>
			@foreach($companies as $c)
			<?php if($c->shortcode==$settings->shortcode){
			     $cnt = $c->contest_totals;
			     $cnt_left = $c->contest_left;
			 };?>
			<button class="btn btn-default btn-mini filterCompany" data-id="{{$c->shortcode}}" >{{str_replace("Systems","",str_replace("Supply","",$c->company_name))}}</button>
			@endforeach
			<button class='btn btn-default pull-right btn-mini tooltwo  refreshRegional' title='Refresh the Leaderboards | Only refresh once or twice a day to avoid long loading times. ' data-type='set'>Refresh </button>
		</div>
	</div>
	<div class="{{$hide}} row-fluid" style="margin-bottom:20px;">
		<div class="span12" style="padding-top:16px;">
		<button class='btn btn-default  tooltwo  switchBoard' data-type='office' title='See Leaders by Office Totals' >DISTRIBUTOR LEADERS </button>
		&nbsp;<button class='btn btn-inverse  tooltwo  switchBoard' data-type='dealer' title='See Leaders by Dealer' >DEALER LEADERS</button>
		</div>
	</div>
	

	<div class='leaderList animated fadeInUp' id="dealer-leaders">
	<div class="row-fluid">

		<div class="span4 well">
			@if($settings->podium==1)
			<div class="podium " data-list="regional-unitList">
				<div class="avatar1 ">
            	          
            	      </div>
            	      <div class="avatar2 animated fadeInDown">
            	        
            	      </div>
            	      <div class="avatar3 ">
            	           
            	      </div>
            	      <div class="podiumhead" style="margin-left:90px">UNITS SOLD</div>
			</div>
			@endif
			<ul class='leaderBoardList regional-unitList'>
				<center>
				<img src='{{URL::to("img/loaders/misc/100.gif")}}'>
			    	</center>
			</ul>
		</div>
		<div class="span4 well">
			@if($settings->podium==1)
			<div class="podium " data-list="regional-saleList">
				<div class="avatar1 ">
            	         
            	      </div>
            	      <div class="avatar2 animated fadeInDown">
            	       
            	      </div>
            	      <div class="avatar3 ">
            	           
            	      </div>
            	      <div class="podiumhead" style="margin-left:90px">SALES MADE</div>
			</div>
			@endif
			<ul class='leaderBoardList regional-saleList'>
					<center>
					<img src='{{URL::to("img/loaders/misc/100.gif")}}'>
				    	</center>
			</ul>
		</div>
		<div class="span4 well">
			@if($settings->podium==1)
			<div class="podium " data-list="regional-putonList">
				<div class="avatar1 ">
            	          
            	      </div>
            	      <div class="avatar2 animated fadeInDown">
            	        
            	      </div>
            	      <div class="avatar3 ">
            	           
            	      </div>
            	      <div class="podiumhead" style="margin-left:90px">PUT ON DEMOS</div>
			</div>
			@endif
			<ul class='leaderBoardList regional-putonList'>
					<center>
					<img src='{{URL::to("img/loaders/misc/100.gif")}}'>
				    	</center>
			</ul>
		</div>
	</div>
	</div>
	<div class='leaderList animated fadeInUp ' id="office-leaders" style="display:none;">
	<div class="row-fluid">
	
		<div class="span4 well">
			@if($settings->podium==1)
			<div class="podium " data-list="office-unitList">
				<div class="avatar1 ">
            	          
            	      </div>
            	      <div class="avatar2 animated fadeInDown ">
            	        
            	      </div>
            	      <div class="avatar3 ">
            	           
            	      </div>
            	      <div class="podiumhead" style="margin-left:90px">UNITS SOLD</div>
			</div>
			@endif
			<ul class='leaderBoardList office-unitList'>
				<center>
				<img src='{{URL::to("img/loaders/misc/100.gif")}}'>
			    	</center>
			</ul>
		</div>
		<div class="span4 well">
			@if($settings->podium==1)
			<div class="podium " data-list="office-saleList">
				<div class="avatar1 ">
            	          
            	      </div>
            	      <div class="avatar2 animated fadeInDown ">
            	        
            	      </div>
            	      <div class="avatar3 ">
            	           
            	      </div>
            	      <div class="podiumhead" style="margin-left:90px">SALES MADE</div>
			</div>
			@endif
			<ul class='leaderBoardList office-saleList'>
					<center>
					<img src='{{URL::to("img/loaders/misc/100.gif")}}'>
				    	</center>
			</ul>
		</div>
		<div class="span4 well">
			@if($settings->podium==1)
			<div class="podium " data-list="office-putonList">
				<div class="avatar1 ">
            	          
            	      </div>
            	      <div class="avatar2 animated fadeInDown ">
            	        
            	      </div>
            	      <div class="avatar3 ">
            	           
            	      </div>
            	      <div class="podiumhead" style="margin-left:90px">PUT ON DEMOS</div>
			</div>
			@endif
			<ul class='leaderBoardList office-putonList'>
					<center>
					<img src='{{URL::to("img/loaders/misc/100.gif")}}'>
				    	</center>
			</ul>
		</div>
	</div>
	</div>
</div>
<script>

$(document).ready(function(){

	/*if(localStorage && localStorage.getItem("regionalData")){
    	applyRegionalData("localstorage");
       		} else {
    	getRegionalData();
    }*/

	$('.switchBoard').click(function(){
		var type=$(this).data('type');
		$('.switchBoard').removeClass('btn-inverse');
		$(this).addClass('btn-inverse');
		$('.leaderList').hide();
		$('.repProfileList').hide();
		$('#'+type+'-leaders').show();
		applyPodiums();
	});

	//SORTING AND FILTERING FUNCTIONS
	function sortList(listName,dataName,listLength){
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
			$(this).find('span.bigCount').html(cnt);
			$(this).find('span.'+listName.replace('regional-','').replace('office-','')+'-data').show();
			if(cnt>listLength){
				$(this).hide();
			}
		});

	}

	function filterList(theList, listLength){
		var cnt=0;
		$(theList).find('li').filter(':visible').each(function(i,val){
			cnt++;
			if(cnt>listLength){
				$(this).hide();
			} else {
				$(this).find('span.bigCount').html(cnt);
				$(this).show();
			}
		});
		
	}

	function applyPodiums(){
		var site = "{{URL::to('')}}";
		$('.podium').each(function(i,val){
			var theClass = $(this).data("list");
			var theCount=0;
			var thisPodium = $(this);
			thisPodium.find('div.avatar1').html("");
			thisPodium.find('div.avatar2').html("");
			thisPodium.find('div.avatar3').html("");
			$('ul.'+theClass+' li:visible').each(function(index){
				var type=$(this).data('type');
				var avatar="";
				if(index==0 || index==1 || index==2){
					if(type=="office"){
						var name="";
						avatar = site+"images/badge-"+$(this).data('icon')+".jpg";
					} else {
						avatar=$(this).data('avatar');
						if(avatar.search("images/avatar.jpg") != -1) {
   							avatar = site+"images/avatar.jpg";
						} 
						var name=$(this).data('name')+"<br>";
					}

					if(index==0){
						thisPodium.find('div.avatar2').html(name+"<img class='animated slideInDown' src='"+avatar+"'>");
					}
					if(index==1){
						thisPodium.find('div.avatar1').html(name+"<img class='animated fadeInUp' src='"+avatar+"'>");
					}
					if(index==2){
						thisPodium.find('div.avatar3').html(name+"<img class='animated fadeInUp' src='"+avatar+"'>");
					}
				}
			});
		});
	}

	$(document).on('click','.darkList-small',function(){
		var id = $(this).data('id');
		var type=$(this).data('type');
		$('.repProfileList').hide();
		$(this).find('div.repProfileList').show();
	});

	$('.filterCompany').click(function(){

		var id= $(this).data('id');
		$('.filterCompany').removeClass('btn-inverse');
		$(this).addClass('btn-inverse')
		if(id=="all"){
			$('.darkList-small').show();
			filterList('.regional-saleList',10);
			filterList('.regional-unitList',10);
			filterList('.regional-putonList',10);
			filterList('.office-saleList',10);
			filterList('.office-unitList',10);
			filterList('.office-putonList',10);
		} else {
			$('.darkList-small').hide();
			$('.'+id).show();
			filterList('.regional-saleList',10);
			filterList('.regional-unitList',10);
			filterList('.regional-putonList',10);
			filterList('.office-saleList',10);
			filterList('.office-unitList',10);
			filterList('.office-putonList',10);
		}
		setTimeout(applyPodiums,600);
	});

	var regionalToggle=0;

	$('.viewleaderBoards').click(function(){
		$('#teslaContestTable').hide();
        	$('.revupCONTEST').hide();
        	$('.leaderBoardMain').toggle(200);
           setTimeout(function(){
           	if(regionalToggle==0){
       		if(localStorage && localStorage.getItem("regionalData")){
       			applyRegionalData("localstorage");
       		} else {
       			getRegionalData();
       		}
       		regionalToggle=1;
       		setTimeout(applyPodiums,900);
    		}
        },500);
    });

	$('.refreshRegional').click(function(){
		var img = "{{URL::to_asset('img/loaders/misc/100.gif')}}";
		$('.leaderBoardList').html("<center><img src='"+img+"'></center>");
		allReps=[];
		regionalToggle=0;
		localStorage.removeItem("regionalData");
		setTimeout(function(){
			getRegionalData();
		},500);
	});

	//Global variables
	var allReps = [];

	// Get regional data from all servers
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
			var theURL = val;
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
							'dns':val.appointment['DNS'],
							'inc':val.appointment['INC'],
							'avatar':val.avatar,
							'points':val.system_points,
							'bronze':val.bronze_points,
							'silver':val.silver_points,
							'gold':val.gold_points,
							'units':val.totgrossunits,
							'sales':val.grosssales,
							'company':val.company,
							'icon':val.shortcode,
							'site_url':theURL
						});
					});
      		      }
      		});
		});

		setTimeout(applyRegionalData,2000);
	}

	function applyRegionalData(type){
		var site = "{{URL::to()}}";
		if(type=="localstorage"){
			allReps = JSON.parse(localStorage.getItem("regionalData"));
		}
		var cnt=0;
		var unitBody="";var saleBody="";var putonBody="";var closeBody="";
		var officeUnitBody="";var officeSaleBody=""; var officePutonBody="";
		     	$.each(allReps,function(i,val){
     				if(val.name!="totals"){
     					var nm = val.name.split(" ");
     					var comp = val.company.replace("Systems","");
     					cnt++;cl="";
     					if(val.close!=0 && val.close!=undefined && val.close!=null){close=val.close;} else {close=0;};
     					html="";
     					html+= "<li style='float:left;' class='"+val.icon+" "+cl+" darkList-small smallShadow' data-name='"+val.name+"' data-avatar='"+val.avatar+"' data-id='"+val.rep_id+"' data-type='dealer' data-close="+val.close+" data-demos="+val.puton/100+" data-sales="+val.sales/100+" data-units="+val.units/100+">";
     					html+="<span style=''>"+nm[0]+"</span>";
     					html+="<div style='margin-top:0px;float:left;margin-right:10px;'><span class='bigCount'></span></div>";
     					html+="<div style='float:right;'>";
     					html+="<span class='hide tooltwo pull-right badge bronzeCoins unitList-data'>"+val.units+" Units </span>";
     					html+="<span class='hide tooltwo pull-right badge silverCoins blackText saleList-data'>"+val.sales+" Sales </span>";
     					html+="<span class='hide tooltwo pull-right badge badge-inverse closeList-data' >"+val.close+" % </span>";
     					html+="<span class='hide tooltwo pull-right badge badge-warning blackText putonList-data' >"+val.puton+"</span>";
     					html+="<img class='leaderBoardLogo' src='"+site+"images/logo-"+val.icon+".png' ></div>";
     					html+="<div class='well repProfileList animated fadeInUp' id='repprofile-"+val.rep_id+"'  >";

     					html+="<div class='span3 animated fadeInUp' >";
						html+="<img src='"+val.avatar+"' class='smallShadow repProfileAvatar'></div><div class='span9'><h4 style='margin-bottom:-4px;'>"+val.name+"</h4>";
						html+="<img src='"+site+"img/badges/points.png' class='' style='width:35px;margin-right:2px;margin-top:5px;margin-bottom:8px;'>";
						html+="&nbsp;&nbsp;<span class=' tooltwo badge badge-inverse' title=''>"+val.points+" Points </span><br/>";
						html+="</div>";
						html+="<div class='span12'>"
						
						html+="<img src='"+site+"img/badges/bronzecoins.png' class='' style='width:18px;margin-left:2px;margin-top:5px;margin-bottom:8px;'>";
						html+="<span class=' tooltwo badge bronzeCoins' title='For Every UNIT Sold | 1 BRONZE'>"+val.bronze+"</span>&nbsp;&nbsp;";
						html+="<img src='"+site+"img/badges/silvercoins.png' class='' style='width:18px;margin-left:2px;margin-top:5px;margin-bottom:8px;'>";
						html+="<span class=' tooltwo badge silverCoins blackText' title='For every SALE made | 1 SILVER '>"+val.silver+"</span>&nbsp;&nbsp;";
						html+="<img src='"+site+"img/badges/goldcoins.png' class='' style='width:18px;margin-left:2px;margin-top:5px;margin-bottom:8px;'>";
						html+="<span class=' tooltwo badge goldCoins blackText' title='For every SUPER, MEGA or NOVA sold | 1 GOLD '>"+val.gold+"</span>&nbsp;&nbsp;";
						html+="</div>";
						
						html+="<div class='span12' style='margin-bottom:20px;'>This Month : <br/>DNS : "+val.dns+"&nbsp; &nbsp; | INC : "+val.inc+" &nbsp;&nbsp;| SOLD : "+val.sales+" <br/>";
						html+="<div class='span5' style='margin-top:25px;margin-bottom:50px;'><span style='color:#bbb;font-size:42px;'>"+val.units+"</span><br/>UNITS</div>";
						html+="<div class='span5' style='margin-top:25px;margin-bottom:50px;'><span style='color:#bbb;font-size:42px;'>"+parseInt(close).toFixed(0)+" <span style='margin-left:-10px;font-size:25px;'>%</span></span><br/>CLOSE %</div><br/>";
						//html+="<button class='btn btn-default viewProfile ' data-id='"+val.rep_id+"' data-site='"+val.site_url+"' >VIEW PROFILE</button>";

						html+="</div>";
     					
     					html+="</div>";


     					html+="</li>"; 
     					if(val.units!=0){
     						unitBody+=html;
     					}
     					if(val.sales!=0){
     						saleBody+=html;
     					}
     					
     					if(val.puton!=0){
     						putonBody+=html;
     					}
     				} else {
     					var cl="";
     					var comp = val.company.replace("Systems","");
     					if(val.close!=0 && val.close!=undefined && val.close!=null){close=val.close;} else {close=0;};
     					html2="";
     					html2+= "<li class='"+val.icon+" "+cl+" darkList-small smallShadow' data-name='"+comp+"' data-avatar='logo-"+val.icon+".png' data-id='' data-icon='"+val.icon+"' data-type='office' data-demos="+val.puton/100+" data-sales="+val.sales/100+" data-units="+val.units/100+">";
     					html2+="<span style='font-size:13px;'>"+comp+"</span>";
     					html2+="<div style='margin-top:0px;float:left;margin-right:10px;'><span class='bigCount'></span></div>";
     					html2+="<div style='float:right;'>";
     					html2+="<span class='hide tooltwo pull-right badge bronzeCoins unitList-data'>"+val.units+" Units </span>";
     					html2+="<span class='hide tooltwo pull-right badge silverCoins blackText saleList-data'>"+val.sales+" Sales </span>";
     					html2+="<span class='hide tooltwo pull-right badge badge-warning blackText putonList-data' ><span class='badge badge-inverse'>Close : "+parseInt(close).toFixed(0)+"%</span>&nbsp;&nbsp;&nbsp;&nbsp;"+val.puton+"</span>";
     					html2+="</div>";
     					html2+="</li>"; 
     					if(val.units!=0){
     						officeUnitBody+=html2;
     					}
     					if(val.sales!=0){
     						officeSaleBody+=html2;
     					}
     					if(val.puton!=0){
     						officePutonBody+=html2;
     					}
     				}
			});
		$('.regional-unitList').html("").append(unitBody);
		$('.regional-saleList').html("").append(saleBody);
		$('.regional-putonList').html("").append(putonBody);
		$('.office-unitList').html("").append(officeUnitBody);
		$('.office-saleList').html("").append(officeSaleBody);
		$('.office-putonList').html("").append(officePutonBody);
		sortList('regional-unitList','data-units',10); 
		sortList('regional-saleList','data-sales',10);
		sortList('regional-putonList','data-demos',10);
		sortList('office-unitList','data-units',10); 
		sortList('office-saleList','data-sales',10);
		sortList('office-putonList','data-demos',10);
		if(type!="localstorage"){
			localStorage.setItem("regionalData",JSON.stringify(allReps));
		}
		setTimeout(function(){$('.tooltwo').tooltipster();},500);
	}

});
</script>
