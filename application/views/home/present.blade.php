<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    
    <title>{{Setting::find(1)->title}}</title>
    <meta name="description" content="">
    <meta name="author" content="">
    

	<meta name="HandheldFriendly" content="True">
	<meta name="MobileOptimized" content="320">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
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
 <link rel="stylesheet" href="{{URL::to_asset('css/animate.css')}}">
  <link rel="stylesheet" href="{{URL::to_asset('css/font-awesome.min.css')}}">
	<!-- iOS web-app metas -->
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">

	<!-- Startup image for web apps -->
	<link rel="apple-touch-startup-image" href="{{URL::to_asset('img/splash/ipad-landscape.jpg')}}" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
	<link rel="apple-touch-startup-image" href="{{URL::to_asset('img/splash/ipad-portrait.jpg')}}" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
	<link rel="apple-touch-startup-image" href="{{URL::to_asset('img/splash/iphone.jpg')}}" media="screen and (max-device-width: 320px)">
<style>
body {background:url('{{URL::to_asset('images/subtle_clouds.jpg')}}');
-webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
font-family:Arial, sans-serif}


</style>
  <style>
  	.container{padding-top:40px;}
  	#slides {margin:auto;
  	float:left;
  	width:65%;
  }
  #slides img {float:left;width:90%;border:1px solid #1f1f1f;}
  .but {float:left;width:80px;height:80px;margin-left:100px;margin-top:320px;margin-right:100px;}
  .but img{width:90%;cursor:pointer;opacity:0.8}
  .but img:hover{opacity:1}
  #next {margin-left:16px;}
  </style>

  
</head>
<body>
	<div class="container" >
		<div class="but" id="prev"><img src='{{URL::to_asset('slideshow/prev.png')}}'></div>
		  <div id="slides">
	<!--LEAD STUFF-->
      <img class='slide 1 animated fadeInUp' src="{{URL::to_asset('slideshow/Lead-manager.jpg')}}"  >
      <img class='slide 2 animated fadeInUp' src="{{URL::to_asset('slideshow/Lead-detail.jpg')}}" >
      <img class='slide 3 animated fadeInUp' src="{{URL::to_asset('slideshow/Lead-breakdown.jpg')}}" >
      <img class='slide 4 animated fadeInUp' src="{{URL::to_asset('slideshow/Lead-assigning.jpg')}}" >
      <img class='slide 5 animated fadeInUp' src="{{URL::to_asset('slideshow/Lead-search.jpg')}}" >

      <!--APPOINTMENT STUFF-->
      <img class='slide 6 animated fadeInUp' src="{{URL::to_asset('slideshow/Appointment-board.jpg')}}" >
      <img class='slide 7 animated fadeInUp' src="{{URL::to_asset('slideshow/Appoint-dispatch.jpg')}}"  >
    	<img class='slide 8 animated fadeInUp' src="{{URL::to_asset('slideshow/Appointment-map.jpg')}}"  >

    	<!--EMPLOYEE MANAGER-->
      <img class='slide 9 animated fadeInUp' src="{{URL::to_asset('slideshow/employee-manager.jpg')}}" >
      <img class='slide 10 animated fadeInUp' src="{{URL::to_asset('slideshow/employee-schedule.jpg')}}" >

      <!--SALES REPORT-->
      <img class='slide 11 animated fadeInUp' src="{{URL::to_asset('slideshow/Sales-reports.jpg')}}" >
      <img class='slide 12 animated fadeInUp' src="{{URL::to_asset('slideshow/paymentcalc.jpg')}}" >
      <img class='slide 13 animated fadeInUp' src="{{URL::to_asset('slideshow/Doorreggie.jpg')}}" >

       <!--SALES REPORT-->
      <img class='slide 14 animated fadeInUp' src="{{URL::to_asset('slideshow/City-manager.jpg')}}" >
      <img class='slide 15 animated fadeInUp' src="{{URL::to_asset('slideshow/Gift-manager.jpg')}}" >

       <!--BOOKER PROFILE-->
      <img class='slide 16 animated fadeInUp' src="{{URL::to_asset('slideshow/Booker-profile.jpg')}}" >
      <img class='slide 17 animated fadeInUp' src="{{URL::to_asset('slideshow/Booker-script.jpg')}}" >




</div>
<div class="but" id="next"><img src='{{URL::to_asset('slideshow/next.png')}}'></div>

</div>

<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script>
	$(document).ready(function(){

	$('.slide').hide();
	$('.1').show();
	var cnt=1;
	$('.but').click(function(){
	var dir = $(this).attr('id');
	var max = $('.slide').length+1;

	if(dir=="next"){
		cnt = cnt+1;
		} else {
		cnt = cnt-1;
	}
	if((cnt<=0)||(cnt>=max)){cnt=1;}
	$('.slide').hide();
	$('.'+cnt).show();
	});
});
</script>
</body>
</html>