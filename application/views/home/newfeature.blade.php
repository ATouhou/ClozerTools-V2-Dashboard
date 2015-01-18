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
		  <img class='slide 1 animated fadeInUp' src="{{URL::to_asset('features/slide-5.jpg')}}"  >
	<!--LEAD STUFF-->
      <img class='slide 2 animated fadeInUp' src="{{URL::to_asset('features/slide-1.jpg')}}"  >
      <img class='slide 3 animated fadeInUp' src="{{URL::to_asset('features/slide-2.jpg')}}"  >
      <img class='slide 4 animated fadeInUp' src="{{URL::to_asset('features/slide-3.jpg')}}"  >
      <img class='slide 5 animated fadeInUp' src="{{URL::to_asset('features/slide-4.jpg')}}"  >

    
</div>
<div class="but" id="next"><img src='{{URL::to_asset('slideshow/next.png')}}'></div>

</div>
<div style='float:left;width:100%;padding:40px;font-size:16px;'>
<h4>Change Log</h4>
<ul>
<li>Added all lead info to booking script.  For manillas it now display Job, Smoking, pets, Asthma, Fulltime Part Time etc</li>
<li>Implemented Ajax editing from the booking script, so every field updates as the user type, meaning less data to process when they click process. (only status changes)</li>
<li>Added GREEN row highlight, when check funded on sales report. </li>
<li>Add ORIGINAL PAPERWORK checkbox</li>
<li>Added pagination to lead viewing, for less server strain, and also browser strain. Buttons navigate between pages of leads</li>
<li>Replaced the lead search functionality with the same lead viewing table, for coherence across site.</li>
<li>Added ability to click to appointment, when viewing the lead</li>
<li>Edit in Place added to lead viewing table</li>
<li>Added STACK counter, to leads, to know how far you are through a batch</li>
<li>Added stats to lead page</li>
<li>Added VIEW AVAILABLE, VIEW UNRELEASED, VIEW ASSIGNED to lead screen, to view breakdown of each city</li>
<li>Implemented ajax searching, instead of full HTTP request</li>
<li>Fixed error on APPOINTMENTS NEEDED, on booking script.  The window now comes up ABOVE the script</li>
</ul>
<ul>
<li>Ability to change status from CANCELLED back to something else, from the sales report</li>
</ul>
<ul>
<li>Added Ride-Along to Appointments</li>
<li>Added checkbox option for TEXTING (to turn it on or off)</li>
<li>If Ride-along did the demo, ability to mark him/her as the SELLER, when clicking SOLD from appointments</li>
</ul>
<ul>
<li>Added INVOICE section for Dealers to submit Invoices/Payforms</li>
<li>Ability to Mark Invoices as PAID</li>
<li>Ability to filter Invoices by date/dealer</li>
</ul>
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