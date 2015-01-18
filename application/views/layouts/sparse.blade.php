<!DOCTYPE html>
<html lang="en">
<?php $settings = Setting::find(1);?>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>{{$settings->title}}</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link id="favicon" rel="shortcut icon" type="image/png" href="{{URL::to_asset('img/favicons/')}}favicon-{{$settings->shortcode}}.ico" />
    <!--// OPTIONAL & CONDITIONAL CSS FILES //-->   
    <!-- date picker css -->
    <link rel="stylesheet" href="{{URL::to_asset('css/datepicker.css?v=1')}}">
    <!-- full calander css -->
    <link rel="stylesheet" href="{{URL::to_asset('css/fullcalendar.css?v=1')}}">
    <!-- data tables extended CSS -->
    <link rel="stylesheet" href="{{URL::to_asset('css/TableTools.css?v=1')}}">
    <link rel="stylesheet" href="{{URL::to_asset('js/slick-1.3.11/slick/slick.css')}}">
    <!-- custom/responsive growl messages -->
    <link rel="stylesheet" href="{{URL::to_asset('css/toastr.custom.css?v=1')}}">
    <link rel="stylesheet" href="{{URL::to_asset('css/toastr-responsive.css?v=1')}}">
    <link rel="stylesheet" href="{{URL::to_asset('css/jquery.jgrowl.css?v=1')}}">
     <link rel="stylesheet" type="text/css" href="{{URL::to_asset('css/tooltipster.css')}}" />
    <!-- // DO NOT REMOVE OR CHANGE ORDER OF THE FOLLOWING // -->
    <!-- bootstrap default css (DO NOT REMOVE) -->
    <link rel="stylesheet" href="{{URL::to_asset('css/bootstrap.min.css?v=1')}}">
    <link rel="stylesheet" href="{{URL::to_asset('css/bootstrap-responsive.min.css?v=1')}}">
    <!-- font awsome and custom icons -->
    <link rel="stylesheet" href="{{URL::to_asset('css/font-awesome.min.css?v=1')}}">
    <link rel="stylesheet" href="{{URL::to_asset('css/cus-icons.css?v=1')}}">
    <!-- jarvis widget css -->
    <link rel="stylesheet" href="{{URL::to_asset('css/jarvis-widgets.css?v=1')}}">
    <!-- Data tables, normal tables and responsive tables css -->
    <link rel="stylesheet" href="{{URL::to_asset('css/DT_bootstrap.css?v=1')}}">
    <link rel="stylesheet" href="{{URL::to_asset('css/responsive-tables.css?v=1')}}">
    <!-- used where radio, select and form elements are used -->
    <link rel="stylesheet" href="{{URL::to_asset('css/uniform.default.css?v=1')}}">
    <link rel="stylesheet" href="{{URL::to_asset('css/select2.css?v=1')}}">
    <!-- main theme files -->
    <link rel="stylesheet" href="{{URL::to_asset('css/theme.css?v=1')}}">
    <link rel="stylesheet" href="{{URL::to_asset('css/theme-responsive.css?v=1')}}">
  
    
    <!-- // THEME CSS changed by javascript: the CSS link below will override the rules above // -->
    <!-- For more information, please see the documentation for "THEMES" -->
    <link rel="stylesheet" id="switch-theme-js" href="{{URL::to_asset('css/themes/')}}black.css?v=1">   
    
    <!-- To switch to full width -->
    <link rel="stylesheet" id="switch-width" href="{{URL::to_asset('css/full-width.css?v=1')}}">
 
    <!-- Webfonts -->

    <link rel="stylesheet" href="{{URL::to_asset('css/custom.css')}}">
    <link rel="stylesheet" href="{{URL::to_asset('css/animate.css')}}">

    <!-- All javascripts are located at the bottom except for HTML5 Shim -->
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <script src="js/include/respond.min.js"></script>
    <![endif]-->
    
    <!-- For Modern Browsers -->
    <link rel="shortcut icon" href="{{URL::to_asset('img/favicons/favicon.png')}}">
    <!-- For everything else -->
    <link rel="shortcut icon" href="{{URL::to_asset('img/favicons/favicon.ico')}}">
    <!-- For retina screens -->
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{URL::to_asset('img/favicons/apple-touch-icon-retina.png')}}">
    <!-- For iPad 1-->
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{URL::to_asset('img/favicons/apple-touch-icon-ipad.png')}}">
    <!-- For iPhone 3G, iPod Touch and Android -->
    <link rel="apple-touch-icon-precomposed" href="{{URL::to_asset('img/favicons/apple-touch-icon.png')}}">
    <!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="{{URL::to_asset('js/libs/jquery.min.js')}}"><\/script>')</script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">

    
    <script>window.jQuery.ui || document.write('<script src="{{URL::to_asset('js/libs/jquery.ui.min.js')}}"><\/script>')</script>
    <script src="{{URL::to_asset('js/slick-1.3.11/slick/slick.js')}}"></script>
    <!-- IMPORTANT: Jquery Touch Punch is always placed under Jquery UI -->
    <script src="{{URL::to_asset('js/include/jquery.ui.touch-punch.min.js')}}"></script>
    <script src="{{URL::to_asset('js/include/gmap3.min.js')}}"></script>
    <script src="{{URL::to_asset('js/')}}cookie.js"></script>
    <!-- iOS web-app metas -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <!-- Startup image for web apps -->
    <link rel="apple-touch-startup-image" href="{{URL::to_asset('img/splash/ipad-landscape.jpg')}}" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
    <link rel="apple-touch-startup-image" href="{{URL::to_asset('img/splash/ipad-portrait.jpg')}}" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
    <link rel="apple-touch-startup-image" href="{{URL::to_asset('img/splash/iphone.jpg')}}" media="screen and (max-device-width: 320px)">
      <link rel="stylesheet" href="{{URL::to_asset('css/ajaxwait.css')}}?version=11">
      <script src="{{URL::to('js/select2-3.5.1/select2.min.js')}}"></script>
<link href="{{URL::to('js/select2-3.5.1/select2.css')}}" rel="stylesheet"/>
  </head>


<body>



<div class="height-wrapper deskBack" >
      <!-- header -->
       <header class="header-bar subtle-shadow medShadow" >
      
            <!-- tool bar -->
            <div id="header-toolbar" class="container-fluid" style="height:75px;">
                	<!-- .contained -->
                	<div class="contained" >
                    
                    	<!--LOGO-->
                    	<h1> 
                    	@if(Auth::user()->user_type!="researcher") <a href="{{URL::to('dashboard')}}"> @endif
                    		<img src="{{URL::to_asset('images/')}}clozer-logo-small.png" width=240px>
                    	@if(Auth::user()->user_type!="researcher") </a> @endif
                        
                    	</h1>
                        <h1 style='font-size:24px;margin-top:15px;margin-left:20px;'>Company Stats for {{str_replace(" - Rep Dashboard","",Setting::find(1)->title)}}</h1>
                  </div>
            </div>
      </header>

     @include('plugins.sidemap')
     
     @if((Auth::user()->user_type=="manager")||(isset($header)))
     <div class="clearfix" style="height:75px;"></div>
     @endif
     <div class="row-fluid animated fadeInUp well" id="leadViewer" style="z-index:10000!important;display:none;margin-top:20px;background:#fff"></div>
     <div class="animated fadeInUp shadowBOX infoHover invoiceInfoHover"></div>
     <div class="animated fadeInUp shadowBOX infoHover noScrollHide inventoryInfoHover" ></div>
     <div class="animated fadeInUp shadowBOX infoHover leadInfoHover"></div>
     <div class="animated fadeInUp shadowBOX infoHover progressInfoHover"></div>
      @yield('content')
       @if((Auth::user()->user_type=="manager")||(Auth::user()->user_type=="agent")||(Auth::user()->user_type='doorrep'))
      	@include('plugins.addnewlead')
	   @endif
      <script src="{{URL::to_asset('js/include/selectnav.min.js')}}"></script>
      <script>
 function addDashes(f) {
        var r = /(\D+)/g,
            npa = '',
            nxx = '',
            last4 = '';
        f.value = f.value.replace(r, '');
        npa = f.value.substr(0, 3);
        nxx = f.value.substr(3, 3);
        last4 = f.value.substr(6, 4);
        f.value = npa + '-' + nxx + '-' + last4;
    }
</script>
    <!-- REQUIRED: Datatable components -->
    <script src="{{URL::to_asset('js/include/jquery.accordion.min.js')}}"></script>

    <!-- REQUIRED: Toastr & Jgrowl notifications  -->
    <script src="{{URL::to_asset('js/include/toastr.min.js')}}"></script>
    <script src="{{URL::to_asset('js/include/jquery.jgrowl.min.js')}}"></script>
    
    <!-- REQUIRED: Sleek scroll UI  -->
    <script src="{{URL::to_asset('js/include/slimScroll.min.js')}}"></script>
    
    <!-- REQUIRED: Datatable components -->
    <script src="{{URL::to_asset('js/include/jquery.dataTables.min.js')}}"></script> 
    <script src="{{URL::to_asset('js/include/DT_bootstrap.min.js')}}"></script> 

    <!-- REQUIRED: Form element skin  -->
    <script src="{{URL::to_asset('js/include/jquery.uniform.min.js')}}"></script>

    <script type="text/javascript">
        var ismobile = (/iphone|ipad|ipod|android|blackberry|mini|windows\sce|palm/i.test(navigator.userAgent.toLowerCase()));  
        if(!ismobile){
            /** ONLY EXECUTE THESE CODES IF MOBILE DETECTION IS FALSE **/
            /* REQUIRED: Datatable PDF/Excel output componant */
            document.write('<script src="{{URL::to_asset('js/include/ZeroClipboard.min.js')}}"><\/script>'); 
            document.write('<script src="{{URL::to_asset('js/include/TableTools.min.js')}}"><\/script>'); 
            document.write('<script src="{{URL::to_asset('js/include/select2.min.js')}}"><\/script>');
            document.write('<script src="{{URL::to_asset('js/include/jquery.excanvas.min.js')}}"><\/script>');
            document.write('<script src="{{URL::to_asset('js/include/jquery.placeholder.min.js')}}"><\/script>');
        }else{
             /** ONLY EXECUTE THESE CODES IF MOBILE DETECTION IS TRUE **/
            document.write('<script src="{{URL::to_asset('js/include/selectnav.min.js')}}"><\/script>');
        }
    </script>

    <!-- REQUIRED: iButton -->
    <script src="{{URL::to_asset('js/include/jquery.ibutton.min.js')}}"></script>
    
    <!-- REQUIRED: Justgage animated charts -->
   <script src="{{URL::to_asset('js/include/justgage.min.js')}}"></script>
     <script src="{{URL::to_asset('js/include/raphael.2.1.0.min.js')}}"></script>
    
    <!-- REQUIRED: Animated pie chart -->
    <script src="{{URL::to_asset('js/include/jquery.easy-pie-chart.min.js')}}"></script>
    
     <!-- REQUIRED: Morris Charts -->
    <script src="{{URL::to_asset('js/include/morris.min.js')}}"></script> 
    

    <!-- REQUIRED: Functional Widgets -->
    <script src="{{URL::to_asset('js/include/jarvis.widget.min.js')}}"></script>
    <script src="{{URL::to_asset('js/include/mobiledevices.min.js')}}"></script>
    <!-- DISABLED (only needed for IE7 <script src="{{URL::to_asset('js/include/json2.js')}}"></script> -->
    
    <!-- REQUIRED: Full Calendar -->
    <script src="{{URL::to_asset('js/include/jquery.fullcalendar.min.js')}}"></script>        

    <!-- REQUIRED: Form validation plugin -->
   <script src="{{URL::to_asset('js/include/jquery.validate.min.js')}}"></script>
    
    <!-- REQUIRED: Progress bar animation -->
    <script src="{{URL::to_asset('js/include/bootstrap-progressbar.min.js')}}"></script>
    <!-- REQUIRED: Bootstrap Date Picker -->
    <script src="{{URL::to_asset('js/include/bootstrap-datepicker.min.js')}}"></script>
    <!-- REQUIRED: Bootstrap Time Picker -->
    <script src="{{URL::to_asset('js/include/bootstrap-timepicker.min.js')}}"></script>
    
    <!-- REQUIRED: Bootstrap Prompt -->
    <script src="{{URL::to_asset('js/include/bootbox.min.js')}}"></script>
    
    <!-- REQUIRED: Bootstrap engine -->
    <script src="{{URL::to_asset('js/include/bootstrap.min.js')}}"></script>
 
    <!-- DO NOT REMOVE: Theme Config file -->
    <script src="{{URL::to_asset('js/config.js')}}"></script>

	<link rel="stylesheet" href="{{URL::to_asset('js/bootstrap-tagmanager.css')}}">
	<script src="{{URL::to_asset('js/bootstrap-tagmanager.js')}}"></script> 
	<script src="{{URL::to_asset('js/timepicker.js')}}"></script>
	<script src="{{URL::to_asset('js/jquery.tooltipster.min.js')}}"></script>

	<script src="{{URL::to_asset('js/editable.js')}}"></script>
	
@if($settings->shortcode=='foxv' || $settings->shortcode=='cyclo' || $settings->shortcode=='mdhealth' || $settings->shortcode=='mdhealth2' || $settings->shortcode=='ribmount' || $settings->shortcode=='pureair'  || $settings->shortcode=='triad')
<?php $country="us";?>
@else
<?php $country="ca";?>
@endif
    	<!-- end scripts -->
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&libraries=places&language=en-AU"></script>
 <script>

         var options = {
  componentRestrictions: {country: '<?php echo $country;?>'}
 };

            var autocomplete = new google.maps.places.Autocomplete($(".addressDropdown")[0], options);

            google.maps.event.addListener(autocomplete, 'place_changed', function() {
                var place = autocomplete.getPlace();
                console.log(place.address_components);

              address = '';
      if (place.address_components) {
       address += place.address_components[0].short_name;
       address += " "+place.address_components[1].short_name;
       address += " ,"+" "+place.address_components[2].short_name;
      }



            });
        </script>
        @if(Auth::user()->user_type=="agent")
         <script>
         var options = {
            componentRestrictions: {country: '<?php echo $country;?>'}
        };

            var autocomplete4 = new google.maps.places.Autocomplete($(".scratchAddress")[0], options);

            google.maps.event.addListener(autocomplete4, 'place_changed', function() {
                var place = autocomplete4.getPlace();
                console.log(place.address_components);

              address = '';
      if (place.address_components) {
       address += place.address_components[0].short_name;
       address += " "+place.address_components[1].short_name;
       address += " ,"+" "+place.address_components[2].short_name;
      }



            });
        </script>
        <script>
         var options = {
  componentRestrictions: {country: '<?php echo $country;?>'}
 };

            var autocomplete2 = new google.maps.places.Autocomplete($(".leadAddress")[0], options);


            google.maps.event.addListener(autocomplete2, 'place_changed', function() {
                var place = autocomplete2.getPlace();
                

              address = '';
      if (place.address_components) {

       address += place.address_components[0].short_name;
       address += " "+place.address_components[1].short_name;
       address += " ,"+" "+place.address_components[2].short_name;
       console.log(address);
       $('#getTheHiddenAddress').val(address);
      }



            });
        </script>
        @endif

	<script>
	$(document).ready(function(){

		var roadAtlasStyles = [
			  {
			      "featureType": "road.highway",
			      "elementType": "geometry",
			      "stylers": [
			        { "saturation": -100 },
			        { "lightness": -8 },
			        { "gamma": 1.18 }
			      ]
			  }, {
			      "featureType": "road.arterial",
			      "elementType": "geometry",
			      "stylers": [
			        { "saturation": -100 },
			        { "gamma": 1 },
			        { "lightness": -24 }
			      ]
			  }, {
			      "featureType": "poi",
			      "elementType": "geometry",
			      "stylers": [
			        { "saturation": -100 }
			      ]
			  }, {
			      "featureType": "administrative",
			      "stylers": [
			        { "saturation": -100 }
			      ]
			  }, {
			      "featureType": "transit",
			      "stylers": [
			        { "saturation": -100 }
			      ]
			  }, {
			      "featureType": "water",
			      "elementType": "geometry.fill",
			      "stylers": [
			        { "saturation": -100 }
			      ]
			  }, {
			      "featureType": "road",
			      "stylers": [
			        { "saturation": -100 }
			      ]
			  }, {
			      "featureType": "administrative",
			      "stylers": [
			        { "saturation": -100 }
			      ]
			  }, {
			      "featureType": "landscape",
			      "stylers": [
			        { "saturation": -100 }
			      ]
			  }, {
			      "featureType": "poi",
			      "stylers": [
			        { "saturation": -100 }
			      ]
			  }, {
			  }
            ]


	    	window.onscroll = function (e) {  
            var theDiv = $('.infoHover');
            	theDiv.each(function(i,val){
            	    if(!$(this).hasClass('noScrollHide')){
            	         $(this).hide();
            	    }
            	});
	    	} 

	    	$('.viewCity').click(function(){
		    	var id = $(this).data('id');
		    	$('#fullPanel').fadeIn(500);
		    	$('.cityData').load("{{URL::to('cities/profile/')}}"+id);
		    	var name = $(this).data('cityname');
			    var url = '../reports/door/map';
    			$('.cityMap').gmap3({
			   clear: {
			     name:["marker"]
			   }
			});
			var province = $(this).data('province');
			$.getJSON(url,{cityname:name,plainicons:true},function(data){
				console.log(data);
				$('.cityMap').show();
				if(data.empty==true){
					$(".cityMap").gmap3(
					  { 	
					  	marker:{
					  		name:"marker",
      						address: name
    						},
					  	map:{
					      options:{
	
					        zoom:12,
					        mapTypeId: google.maps.MapTypeId.HYBRID,
					        mapTypeControlOptions: {
					           mapTypeIds: [google.maps.MapTypeId.HYBRID, "style1"]
					        }
					      }
					    },
					    styledmaptype:{
					      id: "style1",
					      options:{
					        name: "Style 1"
					      },
					      styles: roadAtlasStyles
					    },autofit:{}
					  }
					);
					
				} else {

					$(".cityMap").gmap3({
					  marker:{
					    values: data.map,
					    options:{
					     draggable:false,
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
					      },
					      mouseout: function(){
					        var infowindow = $(this).gmap3({get:{name:"infowindow"}});
					        if (infowindow){
					          infowindow.close();
					        }
					      },
					    }
					  },
					  map:{
					    options:{
					      zoom: 11,
					        center: new google.maps.LatLng(data.latlng[0],data.latlng[1]),
					        mapTypeId: google.maps.MapTypeId.HYBRID,
					        mapTypeControl: true,
					        mapTypeControlOptions: {
					        	mapTypeIds: [google.maps.MapTypeId.HYBRID, "style1"]
					        },
					        navigationControl: true,
					        scrollwheel: true,
					        streetViewControl: true
					     }
					  },styledmaptype:{
				      id: "style1",
				      options:{
				        name: "Style 1"
				      },
				      styles: roadAtlasStyles
				    }
				  
					});	
				}
				setTimeout(function(){
					var map = $(".cityMap").gmap3("get");
					map.setZoom(12);
				},1000);
			}); 
		});

$(document).on('click','.viewRepInfo',function(){
    <?php if(Auth::user()->id!=58){;?>
        alert('Function not available yet!')

        <?php } else {;?>
            var id = $(this).data('id');
    var site = $('#thisSiteURL').val();
    var link = $('#otherSiteURL').val();
    var payload="";

    if(site!=link){
            payload= "?viewDistributor=true";
        }
    link+="users/viewprofile/"+id+payload;
    window.location = link;
    
<?php };?>


});
		
		$('.closeSidePanel').click(function(){
		    $('#fullPanel').hide();
		    $('.cityMap').gmap3('destroy').remove();
		    $('#rightPanel').append("<div class='cityMap' style='height:1200px;width:100%;'> </div>");
		});
		
		
		$('.toggleActive').click(function(){
		    $('.hide-cityrow').toggle();
		});
		
	$('#bookProcessForm').click(function(){
		var form = $('#book-process-form').serialize();
		$.getJSON("{{URL::to('lead/processlead')}}",form,function(data){
            if(data=="alreadyexists"){
                toastr.error("Cannot book appointment, it is already on Todays Board!");
                return false;
            } else {
                var d = data.attributes;
                console.log(d.status);
                var html="";
                if(d.status=="NI"){
                    html = "<span class='label label-important special blackText'>NOT INTERESTED</span>";
                } else if(d.status=="NH"){
                    html = "<span class='label label-info special'>NOT HOME</span>";
                } else if(d.status=="APP"){
                html = "<span class='label label-success special blackText'>DEMO BOOKED</span>";        
                    }
                    else if(d.status=="WrongNumber"){
                        html = "<span class='label label-warning special blackText'>WRONG #</span>";    
                    }
                    else if(d.status=="Recall"){
                        html = "<span class='label label-warning special blackText'>Recall</span>"; 
                    }
                    else if(d.status=="DNC"){
                        html = "<span class='label label-important special '>DO NOT CALL</span>";   
                    }
                    else if(d.status=="NQ"){
                        html = "<span class='label label-important special blackText '>NOT QUALIFIED</span>";   
                    }
                $('.status-change-'+d.id).html(html);
                $('#book-process_modal').modal('hide');
            }
			
		});
	});
    
    $(document).on('click','.oneTouchReports',function(e){
        e.preventDefault();
        $('.ajax-heading').html("Downloading ALL Reports...");
        $('.ajaxWait').show();
        var start = $(this).data('start');
        var end = $(this).data('end');
        
       setTimeout(function(){download(start, end, "{{URL::to('')}}/reports/generateExcelSale")},500);
       setTimeout(function(){download(start, end, "{{URL::to('')}}/reports/generateExcelDealer")},1500);
       setTimeout(function(){download(start, end, "{{URL::to('')}}/reports/generateExcelManilla")},2500);
       setTimeout(function(){download(start, end, "{{URL::to('')}}/reports/generateExcelMarketing")},3500);
       setTimeout(function(){download(0, 0, "{{URL::to('')}}/reports/generateHealthmor")},4500);
       setTimeout(function(){download(0, 0, "{{URL::to('')}}/reports/monthlyReport")},5500);
       
           setTimeout(function(){
             $('.ajaxWait').hide();
           },7000);
    });

    var download = function() {
       for(var i=0; i<arguments.length; i++) {
        if(i==0){
            var start = arguments[i];
        }
        if(i==1){
            var end = arguments[i];
        }
        if(i>1){
         var iframe = $('<iframe style="visibility: collapse;"></iframe>');
         $('body').append(iframe);
         var content = iframe[0].contentDocument;
         var form = '<form action="' + arguments[i] + '" method="GET">';
         if(end!=0){
            form+='<input type="hidden" name="enddate" value="'+end+'">';
         } 
         if(start!=0){
            form+='<input type="hidden" name="startdate" value="'+start+'">';
         }
         form+='</form>';
         content.write(form);
         $('form', content).submit();
         setTimeout((function(iframe) {
           return function() { 
             iframe.remove(); 
           }
         })(iframe), 1500);
        }
       }
     }      

	$(document).on('click','.revealDetails',function(){
	id = $(this).data('id');
	type = $(this).data('type');
	if(type=="sales"){url='{{URL::to("sales/saleinfo/")}}';type="lead";}
	else if(type=="invoice"){url='{{URL::to("sales/invoiceinfo/")}}';} 
	else if(type=="progress"){url='{{URL::to("sales/progress/")}}';} 
	else if(type=="lead"){url='{{URL::to("lead/leadinfo/")}}';}
	else if(type=="machines"){url='{{URL::to("sales/getmachinelist/")}}'; type="lead";}
	else if(type=="dispatched"){url='{{URL::to("appointment/stilldispatched/")}}'; type="progress"}
      if(type=="progress-side"){url='{{URL::to("sales/progress/")}}';type="invoice";}
	 $('.infoHover').hide();
	 $('.'+type+'InfoHover').addClass('animated fadeInUp').load(url+id).show();
	});

	$(document).on('click','.viewCalls',function(){
		var id = $(this).data('id');
		$('.expandInfo').hide();
		$('.callCount-'+id).toggle();
	});

	$(document).on('click','.viewAppHistory',function(){
		var id = $(this).data('id');
		$('.expandInfo').hide();
		$('.appHistory-'+id).show();
	});

	$(document).on('click','.searchNum',function(data){
		var num = $(this).html();
		sendNumberToSearch(num);
		
	});

	$(document).on('click','.viewTheLeadButton',function(){
            $('.infoHover').hide(100);
            var num = $(this).data('num');
            sendNumberToSearch(num);
      });

	function sendNumberToSearch(num){
		var e = $.Event("keyup");
   		e.which = 13;
		$('.leadSearch').val(num).focus().trigger(e);
		toastr.success("Searching Number "+ num ,"Searching Number in Database");
	}

	$(document).on('click','.processLeadFromSearch',function(){
		var id = $(this).data('id');
		var status = $(this).data('status');
		if((status=="DELETED")||(status=="SOLD")||(status=="DNS")||(status=="INACTIVE")){
			var msg = "You cannot process "+status+" leads.  ";
			if(status=="DELETED"){
				msg+=" \n Please reactivate!";
			}

			toastr.error(msg);
			return false;

		}
		$('.infoHover').hide();
		$('.modal').hide();
		$('.book-process').load('{{URL::to("lead/bookprocess/")}}'+id);
		$('#book-process_modal').modal({backdrop:'static'});
		$('#payment_calc_modal').modal('hide');
		$('#contacts_modal').modal('hide');


	});

	$(document).on('click','.viewTheAddress',function(){
		var lat = $(this).data('lat');
		var lng = $(this).data('lng');
		var address = $(this).data('address');
		$('#sideMap').show(200);
		$('#side-map').html("");
		setTimeout(function(){
		$("#side-map").gmap3({
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
                $("#side-map").gmap3({
                   	marker: {
                        address: address,
                        options: {
                            draggable: false,
                            icon:new google.maps.MarkerImage("{{URL::to('img/app-app.png')}}"),
                            optimized: false,
                            animation: google.maps.Animation.DROP
                        }
                    },
                    map:{
                        options:{
                            center:new google.maps.LatLng(lat, lng),
                            zoom: 16
                        }
                    }
                });

            }
        }
    	}
	});
},500);
});

	$('#side-map-close').click(function(){
		$('#sideMap').hide(400)
	});

	$(document).on('click','.revealScript',function(){
	var id= $(this).data('id');
	$('.script').hide();
	$('#script-'+id).show();
	});

	$('.paymentCalc').click(function(){
		$('.infoHover').hide();
		$('.modal').hide();
		$('#payment_calc_modal').modal({backdrop:'static'});
		$('#contacts_modal').modal('hide');
		$('#repstatus_modal').modal('hide');
	});

	$('.dealerStatus').click(function(){
		$('.infoHover').hide();
		$('.modal').hide();
		$('.repstatus-allReps').load('{{URL::to("appointment/dealerstatus")}}');
		$('#repstatus_modal').modal({backdrop:'static'});
		$('#payment_calc_modal').modal('hide');
		$('#contacts_modal').modal('hide');
	});

	$('.showContacts').click(function(){
		$('.infoHover').hide();
		$('.modal').hide();
		$('.contacts-body').load('{{URL::to("users/contactbook")}}');
		$('#contacts_modal').modal({backdrop:'static'});
		$('#payment_calc_modal').modal('hide');
		$('#repstatus_modal').modal('hide');
	});

  		$('.tooltwo').tooltipster({
   			fixedWidth: 20
   		});

		$(document).on('click','.uploadAvatar',function(){
			$('#avatarID').val($(this).data('id'));
			$('#upload_modal_avatar').modal({backdrop: 'static'});
		});

		$(document).on('click','.switchSaleType',function(){


        $('.switchSaleType').removeClass('btn-primary');
        	$(this).addClass('btn-primary');
        	$('.bigSTATS').hide();
        	$('.saleColumn').hide();
        
        	var type=$(this).data('type');
        	if(type=="NET"){
        	    $('.1-pickup').hide();
        	} else {
        	    $('.tinyProduct').show();
        	    $('.littleProduct').show();
        	}
        	
        	$('.column-'+type).show();
        	$('#counter-'+type).fadeIn(500)
	});
		

		$('.viewApptNeeded').click(function(){
			$('.infoHover').hide();
			$('#needed_modal').modal({backdrop: 'static'});
			setTimeout(function(){
				$('#apptsNeededModal').load('{{URL::to('appointment/needed/json')}}');
			},400);
		});
		

    		$(".sysalerts").load("{{URL::to('chat/alertsystem')}}");
    		
    		var refreshId = setInterval(function() {
    		    $(".sysalerts").load("{{URL::to('chat/alertsystem')}}");
    		}, 25000);

    		$.ajaxSetup({ cache: false });

    		$('.sysmsgclose').live('click',function(){
    			var id = $(this).data('id');
    			$.post("{{URL::to('chat/delalert')}}", { alert_id: id}).done(function(data) {
      			var dat = JSON.parse(data);
    				if(dat.type=="success"){ 
    					toastr.success('', dat.msg);} else if(dat.type=="warning"){
    					toastr.warning('',dat.msg);}
   				});
    		});
		
		$('.LeadManager').click(function(){
			$('.ajax-heading').html("Loading Leads...");
			$('.ajaxWait').show();
		});

		$('.uploadFileButton').click(function(){
			$('.ajax-heading').html("Uploading File...");
			$('.ajaxWait').show();
		});

		$('.generateReport').click(function(){
			$('.ajax-heading').html("Generating Report...");
			$('.ajaxWait').show();
		});


		$(".leadSearch").keyup(function(e) {
		if(e.which == 13)
    			{
        			var val = $(this).val();
        			$('.hide-these-when-searching').hide();
				$('#leadViewer').show().html("<center><img src='{{URL::to('img/loaders/misc/100.gif')}}'></center>");
				$('#leadViewer').load('{{URL::to('lead/search')}}',{searchleads:val,skip:0,take:15});
				window.scrollTo(0,0)
    			}
		});

		$(document).on('click','.paginateLeads',function(){
			var script = $(this).data('script');
			var srch = $(this).data('search');
			var skip = $(this).data('skip');
			var take = $(this).data('take');
			var city = $(this).data('city');
			var type = $(this).data('type');
			window.scrollTo(0,0);
			if(script=="search"){
				$('#leadViewer').load('{{URL::to('lead/')}}'+script,{searchleads:srch,skip:skip,take:take});
			} else {
				$('#leadViewer').load('{{URL::to('lead/')}}'+script,{city:city,type:type,skip:skip,take:take});
			}
			
		});

		$(document).on('click','.backToScreen',function(){
			$('#leadViewer').hide(200);
			$('.hide-these-when-searching').show();
		});

		$('.addNewLead').click(function(){	
			$('#lead_edit_modal').modal({backdrop: 'static'});
		});


		$('body').on('click','.uploadDoc',function(){
			var id = $(this).data('id');
			var lid = $(this).data('lid');
			$('.infoHover').hide();
			$('#theID').val(id);
			$('#leadID').val(lid);
			$('#upload_doc').modal({backdrop: 'static'});
		});

$('body').on('click','.viewDoc',function(){
var id = $(this).data('id');
var name = $(this).data('name');
var type = $(this).data('type');
$('.infoHover').hide();
	$.getJSON('{{URL::to("sales")}}/viewdocs/'+id,function(data){
		html = "";
		$('.sale_id').html("#"+id+" - "+name+" ( Purchased : "+type+")");
			$.each(data,function(i,val){
				var d = val.attributes;
				html+="<div class='span1 imagebox' id='doc-"+d.id+"'>";
				ext = d.uri.split('.').pop();
				if(ext=="pdf"){
					img="pdf.png";
				} else if(ext=="jpg") {
					img = "jpeg.png";
				} else {
					img="file.png";
				}
				html+="<img src='{{URL::to('images/')}}"+img+"' width=80px /><br/><span class='small'>"+d.filename+"</span>";
				html+="<br/><a class='btn btn-primary btn-mini' href='https://s3.amazonaws.com/salesdash/"+d.uri+"' target=_blank>&nbsp;VIEW</a>&nbsp;&nbsp;<div class='btn btn-danger btn-mini delImage' data-id='"+d.id+"'>X</div></div>";
			});
		$('#viewfiles_doc').modal({backdrop: 'static'});
		$('#viewfiles_body').html(html);
	});
	
});


$('body').on('click','.delImage',function(data){
var t = confirm('Are you sure you want to delete this file???');
	if(t){
		var id = $(this).data('id');
		$.get('{{URL::to("sales")}}/delDocument/'+id, function(data){
				if(data=="success"){
					$('#doc-'+id).remove();
					toastr.success('File Removed','DELETE SUCCESFUL');
				} else if(data=="notauth") {
					toastr.warning('You cannot delete a file you didnt upload','ERROR!');
				} else if(data=="failed") {
					toastr.error('Deleting file failed!','FAILED TO REMOVE FILE');
				}
			if($('#viewfiles_body').children().size()==0){
				$('#viewfiles_doc').modal('hide');}
		});
	}
});

	});
	</script> 
	@if(Auth::user()->user_type=="manager")
	<script>
$(document).ready(function(){
	$(document).on('click','.repstatus-dealers',function(){
		var id = $(this).attr('id');
		var t = $(this);
			if($(this).is(":checked")){
				var value=1;
			} else {
				var value=0;
			}
		$.get('{{URL::to("users/edit")}}',{id:id,value:value},function(data){
			if(data==1){
				toastr.success('Activated Rep','REP IS WORKING');
				$('.repstatus-allReps').load('{{URL::to("appointment/dealerstatus")}}');
			} else {
				$('.repstatus-allReps').load('{{URL::to("appointment/dealerstatus")}}');
			}
			
		});
	});

	$(document).on('click','.addUserNote',function(){
	var userid = $(this).data('userid');
	$('#userid_note').val(userid);
	$('#userNote').val("");
		$('#user-note-modal').modal({backdrop:'static'});
		$('#book-process_modal').modal('hide');
		$('#payment_calc_modal').modal('hide');
		$('#contacts_modal').modal('hide');
	});

	$(document).on('click','.deleteUserNote',function(){
		var id = $(this).data('id');
		var t = confirm("Are you sure you want to delete this note?");
		if(t){
			$.get("{{URL::to('users/deletenote/')}}"+id,function(data){
				console.log(data);
				$('#userNoteRow-'+id).remove();
			});
		}
		
	});

	$(document).on('click','#submitUserNote',function(){
		$('#user-note-modal').modal('hide');
		var user = $('#userid_note').val();
		var note = $('#userNote').val();
		var url = "{{URL::to('users/addnewnote')}}";
		$.getJSON(url,{thenote: note, userid: user},function(data){
		if(data=="failed"){
	
			} else {
			$('.user-note-table').append('<tr><td>'+data.attributes.sender_id+'</td><td>'+data.attributes.body+'</td><td>'+data.attributes.created_at+'</td><td><button class="btn btn-danger btn-mini">X</button></td></tr>');
		}
		});
	});

});
</script>
@endif
	@if($settings->support==1)
	<script type='text/javascript'>(function () { var done = false; var script = document.createElement('script'); script.async = true; script.type = 'text/javascript'; script.src = 'https://www.purechat.com/VisitorWidget/WidgetScript'; document.getElementsByTagName('HEAD').item(0).appendChild(script); script.onreadystatechange = script.onload = function (e) { if (!done && (!this.readyState || this.readyState == 'loaded' || this.readyState == 'complete')) { var w = new PCWidget({ c: 'db669ff5-c168-4dbd-8eae-0862202b0f81', f: true }); done = true; } }; })();</script>
	
    @endif

    @if(Auth::user()->user_type=="manager")
    <?php $invoice = Invoice::order_by('start_date','DESC')->first();
    if($invoice){
        $date = strtotime($invoice->start_date);
        $date = strtotime("+3 day", $date);
        if($invoice->status=="unpaid" && (date('Y-m-d')>date('Y-m-d',$date))){;?>
        <script>
        $(document).ready(function(){
            toastr.error("You have not paid for use of the system this month. Please remember that payment is due on the first of every month","SYSTEM PAYMENT DUE");
        });
        </script>
        <?php 
        }
    }
    ;?>
    @endif


	</body>
</html>
