<style>
.overlayTitle {
	position:absolute;
	background:white;
	padding:20px;
	margin-left:10px;
	margin-top:-880px;
}

</style>
<div id="largeFill">




	<div id="largeMap" style="height:1000px;width:100%;"></div>
	<div class="overlayTitle medShadow">
	<h3>Recent Sales for All Offices</h3>
	</div>

</div>



<script>
$(document).ready(function(){

	if(localStorage.getItem("regionalSalesMapData")){
		initiateMap();
	} else {
		getSaleMapData();
	}

	function getSaleMapData(){
		$.getJSON("{{URL::to('presentation/salemap')}}",function(data){
			localStorage.setItem("regionalSalesMapData",data);

			setTimeout(initiateMap,1000);
		});
	}

	function initiateMap(){
		if(localStorage.getItem("regionalSalesMapData")){
			var data = localStorage.getItem("regionalSalesMapData");
			var theCenterOfMap = new google.maps.LatLng(47.1667,-100.1667);
			$("#largeMap").gmap3({
				map:{
					options:{
					  zoom: 5, 
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
									url='';
									$('.infoHover').hide();
						 			$('.'+type+'InfoHover').addClass('animated fadeInUp').load(url+id).show();
					      		}
					    		}
					  	}
					});
			$('#largeMap').gmap3('get').setCenter(theCenterOfMap);
		}
	}
	
	function applySaleMapData(){
	
	
	
	
	}

	

	





});

</script>