<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>ClozerTools CRM</title>
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
	
	<!-- iOS web-app metas -->
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
	<!-- Startup image for web apps -->
	<link rel="apple-touch-startup-image" href="{{URL::to_asset('img/splash/ipad-landscape.jpg')}}" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
	<link rel="apple-touch-startup-image" href="{{URL::to_asset('img/splash/ipad-portrait.jpg')}}" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
	<link rel="apple-touch-startup-image" href="{{URL::to_asset('img/splash/iphone.jpg')}}" media="screen and (max-device-width: 320px)">
	<link rel="stylesheet" href="{{URL::to_asset('css/animate.css')}}">
<style>
body {background:url('{{URL::to_asset("images/login-backdrop.jpg")}}');
-webkit-background-size: cover;
-moz-background-size: cover;
-o-background-size: cover;
background-size: cover;
font-family:Arial, sans-serif}
.container {width:100%;float:left;margin-top:40px;}
.container img {margin:auto;}
.container input {width:90%;
max-width:290px;
margin-top:10px;
height:40px;}
.full {width:100%;float:left;}
</style>
</head>
<body>
	<div class="container">
		<center>
			<img class="animated fadeInDown" src="{{URL::to_asset('images/')}}clozer-logo.png" style="width:45%;margin-top:-28px;">
		<header>
			<h1 style='font-size:38px;color:#aaa;font-weight:bolder;' class='animated fadeInUp'>Enter Credentials</h1>
			<h2 style='color:#6e6e6e;'>ClozerTools CRM<br/>
				
			</h2>
		</header>

		@if(Session::has('status_error'))
			<div class="alert adjusted alert-info">
				<strong>{{Session::get('status_error')}}</strong>
			</div>
		@endif
		<div id="caps_lock" class="animated shake  alert adjusted alert-info" style="display:none;color:red;font-size:30px;">
				<strong>CAPS LOCK IS ON</strong>
			</div>
            <form class="form-signin" method="post" action='{{URL::to('login/run')}}'>
				<div class="full">
					<input type="text" autofocus="autofocus" name="username" id="username" placeholder="Username" >
				</div>
				<div class="full">
					<input type="password"  name="password" id="password" placeholder="Password" >
				</div>
				 <div class="full">
					<input class="btn btn-primary" style="color:#aaa;cursor:pointer;width:90%;font-weight:bolder;height:75px;font-size:46px;margin-top:30px" type="submit" value="LOGIN">
				</div>
            </form>
            <br/><br/>
            <div style="margin-top:260px;">
            <span class='animated fadeInUp'>This site works best on  <A href="https://www.google.com/intl/en/chrome/browser/">Google Chrome</a><br><br></span>
            <a href="https://www.google.com/intl/en/chrome/browser/">
            	<img class="animated rollIn" src="{{URL::to_asset('images/chrome.png')}}" width=68px border=0></a><br/><br/><br/><br/><br/>
            	<span style="color:red;font-weight:bolder;font-size:14px;">
            	If your screen appears all squished when you're logged in...just adjust your zoom level. (+/-)<br/>
            	By holding (CTRL + mouse scrollwheel) or hitting (CTRL-) to zoom out and stretch the screen.</span><br/><br/><br/>
            	<span style="font-size:12px;">
            	<strong>90%</strong> is the recommended zoom level for this site.
            	<Br/>Though if you have a smaller/squarer screen you might want to try 70%-80%</span>
        </div>
		</center>
	  
	</div>
	<script>
	$(document).ready(function(){

		function capLock(e) {
    	kc = e.keyCode ? e.keyCode : e.which;
    	sk = e.shiftKey ? e.shiftKey : ((kc == 16) ? true : false);
    	if (((kc >= 65 && kc <= 90) && !sk) || ((kc >= 97 && kc <= 122) && sk)) {
    		 	$('#caps_lock').show();
    		}else {
    			$('#caps_lock').hide();
    		}
    	
		}

		$('#password').on('keypress', function (e) {
		    capLock(e)
		});
		$('#username').on('keypress', function (e) {
		    capLock(e)
		});



	});
	</script>
</body>
</html>