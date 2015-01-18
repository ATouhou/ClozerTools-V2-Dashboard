<ul class='animated fadeInUp regional-saleList list leaderlist SALES' >
     
</ul>
<ul class='animated fadeInUp regional-unitList list leaderlist UNITS'  style='display:none;' >
     
</ul>



<ul class='animated fadeInUp regional-closeList list leaderlist CLOSE' style='display:none;' >
     
</ul>













<script>
$(document).ready(function(){
		$('.switchLeaders').click(function(e){
		var type = $(this).html();
		$('.leaderlist').hide();
		$('.'+type).show(200);
	});

	var regionalToggle=0;
	if(regionalToggle==0){
       	if(localStorage && localStorage.getItem("regionalData")){
       		applyRegionalData("localstorage");
       	} else {
       		getRegionalData();
       	}
       	regionalToggle=1;
       }

	$('.refreshRegional').click(function(){
		var img = "{{URL::to_asset('img/loaders/misc/100.gif')}}";
		$('.regional-unitList').html("<center><img src='"+img+"'></center>");
		$('.regional-saleList').html("<center><img src='"+img+"'></center>");
		$('.regional-closeList').html("<center><img src='"+img+"'></center>");
		allReps=[];
		regionalToggle=0;
		localStorage.removeItem("regionalData");
		getRegionalData();
	});

	
	
    


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
		var salesSort = [];
		var unitSort = [];
		var closeSort = [];
		$.each(allReps,function(i,val){
			if(val.name!="totals"){
				if(val.sales!=0){
					salesSort.push(val);
				}
				if(val.units!=0){
					unitSort.push(val);
				}
				if(val.close!=0){
					closeSort.push(val);
				}
			}
		});
		var sort_by = function(field, reverse, primer){
		   var key = primer ? 
		       function(x) {return primer(x[field])} : 
		       function(x) {return x[field]};
		
		   reverse = [-1, 1][+!!reverse];
		
		   return function (a, b) {
		       return a = key(a), b = key(b), reverse * ((a > b) - (b > a));
		     } 
		}

		salesSort.sort(sort_by('sales',false,parseInt));
		unitSort.sort(sort_by('units',false,parseInt));
		closeSort.sort(sort_by('close',false,parseInt));

		$.each(unitSort,function(i,val){
			if(i<11){
				console.log(val.units);
				html+="<div  class='leader-mobile regional-units' data-id='"+val.rep_id+"' data-units="+val.units/100+">";
     				html+="<b style='font-size:14px;' class=''>"+val.name+"</b><br/>";
     				html+="<span style='font-size:10px;'> "+val.company+" </span><br/><br/>";
     				html+="<img src='"+val.avatar+"' class='avatarRound'><div style='float:left;margin-left:15px;'><span class='tooltwo badge bronzeCoins '>"+val.units+" Units </span><br/></div>";
     				html+="</div>";
     			}
		});

		$.each(salesSort,function(i,val){
			if(i<11){
				console.log(val.sales);
				html2+="<div  class='leader-mobile regional-sales' data-id='"+val.rep_id+"' data-sales="+val.sales/100+">";
     				html2+="<b style='font-size:14px;' class=''>"+val.name+"</b><br/>";
     				html2+="<span style='font-size:10px;'> "+val.company+" </span><br/><br/>";
     				html2+="<img src='"+val.avatar+"' class='avatarRound'><div style='float:left;margin-left:15px;'><span class='tooltwo badge silverCoins blackText' >"+val.sales+" Sales </span><br/>	</div>";
     				html2+="</div>";
			}
			
		});
		$.each(closeSort,function(i,val){
			console.log(val.close);
			if(i<11){
				html3+="<div  class='leader-mobile regional-close' data-id='"+val.rep_id+"' data-close="+val.close/100+">";
     				html3+="<b style='font-size:14px;' class=''>"+val.name+"</b><br/>";
     				html3+="<span style='font-size:10px;'> "+val.company+" </span><br/><br/>";
     				html3+="<img src='"+val.avatar+"' class='avatarRound'><div style='float:left;margin-left:15px;'><span class='tooltwo badge badge-inverse ' >"+parseFloat(val.close).toFixed(2)+" % </span><br/></div>"	;
     				html3+="</div>";
     			}
		});
		 html+="<div style='height:200px;'></div>";html2+="<div style='height:200px;'></div>";html3+="<div style='height:200px;'></div>";
		$('.regional-unitList').html("").append(html);
		$('.regional-saleList').html("").append(html2);
		$('.regional-closeList').html("").append(html3);
		
		
		localStorage.setItem("regionalData",JSON.stringify(allReps));
	}
});
</script>