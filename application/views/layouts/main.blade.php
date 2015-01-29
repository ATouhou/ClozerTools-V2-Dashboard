<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="ClozerTools CRM" />
	<meta name="author" content="" />

	<title>Clozer Tools CRM</title>

	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Arimo:400,700,400italic">
	<link rel="stylesheet" href="{{URL::to_asset('assets/')}}css/fonts/linecons/css/linecons.css">
	<link rel="stylesheet" href="{{URL::to_asset('assets/')}}css/fonts/fontawesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="{{URL::to_asset('assets/')}}css/bootstrap.css">
	<link rel="stylesheet" href="{{URL::to_asset('assets/')}}css/xenon-core.css">
	<link rel="stylesheet" href="{{URL::to_asset('assets/')}}css/xenon-forms.css">
	<link rel="stylesheet" href="{{URL::to_asset('assets/')}}css/xenon-components.css">
	<link rel="stylesheet" href="{{URL::to_asset('assets/')}}css/xenon-skins.css">
	<link rel="stylesheet" href="{{URL::to_asset('assets/')}}css/custom.css">
	<link rel="stylesheet" href="{{URL::to_asset('assets/')}}css/cus-icons.css">
	<link rel="stylesheet" href="{{URL::to_asset('assets/')}}css/gridster.css">
	<link rel="stylesheet" href="{{URL::to_asset('css/')}}animate.css">
	<script src="{{URL::to_asset('assets/')}}js/jquery-1.11.1.min.js"></script>
	<script src="{{URL::to_asset('assets/')}}js/toastr/toastr.min.js"></script>
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body class="page-body">

	@include('layouts.modal')

	<!-- SITE STORED VARIABLES -->
	<input type="hidden" id="mainURL" value="{{URL::to()}}"/>

	<div class="settings-pane">
		<a href="#" data-toggle="settings-pane" data-animate="true">
			&times;
		</a>
		<div class="settings-pane-inner">
			<div class="row">
				@include('plugins.userinfo')
				@include('layouts.topmenu')
			</div>
		</div>
	</div>
	
	<div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
			
		<!-- Add "fixed" class to make the sidebar fixed always to the browser viewport. -->
		<!-- Adding class "toggle-others" will keep only one menu item open at a time. -->
		<!-- Adding class "collapsed" collapse sidebar root elements and show only icons. -->
		<div class="sidebar-menu toggle-others fixed">
			<div class="sidebar-menu-inner">
				<header class="logo-env">
					<div class="logo">
						<a href="dashboard-1.html" class="logo-expanded">
							<img src="{{URL::to_asset('assets/')}}images/ct-logo.png" width="140" alt="" />
						</a>
						<a href="dashboard-1.html" class="logo-collapsed">
							<img src="{{URL::to_asset('assets/')}}images/ct-logo-collapsed.png" width="40" alt="" />
						</a>
					</div>
		
					<!-- This will toggle the mobile menu and will be visible only on mobile devices -->
					<div class="mobile-menu-toggle visible-xs">
						<a href="#" data-toggle="user-info-menu">
							<i class="fa-bell-o"></i>
							<span class="badge badge-success">7</span>
						</a>
						<a href="#" data-toggle="mobile-menu">
							<i class="fa-bars"></i>
						</a>
					</div>
		
					<!-- This will open the popup with user profile settings, you can use for any purpose, just be creative -->
					<div class="settings-icon">
						<a href="#" data-toggle="settings-pane" data-animate="true">
							<i class="linecons-cog"></i>
						</a>
					</div>
				</header>
				@include('plugins.usersidepanel')
				@include('layouts.menu')
			</div>
		</div>
		
		<div class="main-content">
			<input type="hidden" name="user_type" id="user_type" value="{{Auth::user()->user_type}}" />
			@include('layouts.topnav')
			<div id="loadingAnimation" style="display:none;float:left;background:#dcccba  ;height:1000px;margin-top:-40px;align:center;width:130%;margin-left:-30px;">
				<img src='{{URL::to("img/loaders/200.gif")}}' style="margin-left:500px;margin-top:300px;width:18%;">
			</div>
			<div id="ajax-loaded-area">
				@yield('content')
			</div>
			@include('layouts.footer')
		</div>
		@include('layouts.chatsystem')
	<!-- Bottom Scripts -->

	<link rel="stylesheet" href="{{URL::to_asset('assets/')}}js/daterangepicker/daterangepicker-bs3.css">
	<link rel="stylesheet" href="{{URL::to_asset('assets/')}}js/select2/select2.css">
	<link rel="stylesheet" href="{{URL::to_asset('assets/')}}js/select2/select2-bootstrap.css">
	<link rel="stylesheet" href="{{URL::to_asset('assets/')}}js/multiselect/css/multi-select.css">
	<link rel="stylesheet" href="{{URL::to_asset('assets/')}}js/icheck/skins/all.css">
	<script src="{{URL::to_asset('assets/')}}js/bootstrap.min.js"></script>
	<script src="{{URL::to_asset('assets/')}}js/TweenMax.min.js"></script>
	<script src="{{URL::to_asset('assets/')}}js/resizeable.js"></script>
	<script src="{{URL::to_asset('assets/')}}js/joinable.js"></script>
	<script src="{{URL::to_asset('assets/')}}js/xenon-api.js"></script>
	<script src="{{URL::to_asset('assets/')}}js/xenon-toggles.js"></script>

	<script src="{{URL::to_asset('assets/')}}js/daterangepicker/daterangepicker.js"></script>
	<script src="{{URL::to_asset('assets/')}}js/datepicker/bootstrap-datepicker.js"></script>
	<script src="{{URL::to_asset('assets/')}}js/timepicker/bootstrap-timepicker.min.js"></script>
	<script src="{{URL::to_asset('assets/')}}js/colorpicker/bootstrap-colorpicker.min.js"></script>
	<script src="{{URL::to_asset('assets/')}}js/select2/select2.min.js"></script>
	<script src="{{URL::to_asset('assets/')}}js/jquery-ui/jquery-ui.min.js"></script>
	<script src="{{URL::to_asset('assets/')}}js/selectboxit/jquery.selectBoxIt.min.js"></script>
	<script src="{{URL::to_asset('assets/')}}js/tagsinput/bootstrap-tagsinput.min.js"></script>
	<script src="{{URL::to_asset('assets/')}}js/typeahead.bundle.js"></script>
	<script src="{{URL::to_asset('assets/')}}js/handlebars.min.js"></script>
	<script src="{{URL::to_asset('assets/')}}js/multiselect/js/jquery.multi-select.js"></script>
	<script src="{{URL::to_asset('assets/')}}js/icheck/icheck.min.js"></script>

	<script src="{{URL::to_asset('assets/')}}js/xenon-widgets.js"></script>
	<link rel="stylesheet" href="{{URL::to_asset('assets/')}}css/fonts/meteocons/css/meteocons.css">
	
	<!-- JavaScripts initializations and stuff -->
	<script src="{{URL::to_asset('assets/')}}js/gridster/gridster.min.js"></script>
	<script src="{{URL::to_asset('assets/')}}js/packery/pack.js"></script>
	<script src="{{URL::to_asset('assets/')}}js/packery/drag.js"></script>

	<script src="{{URL::to_asset('assets/')}}js/devexpress-web-14.1/js/globalize.min.js"></script>
	<script src="{{URL::to_asset('assets/')}}js/devexpress-web-14.1/js/dx.chartjs.js"></script>
	<script src="{{URL::to_asset('assets/')}}js/xenon-custom.js"></script>

	<script src="{{URL::to_asset('assets/')}}js/app.js"></script>


<script type="text/javascript">
	jQuery(document).ready(function($)
	{
		if( ! $.isFunction($.fn.dxChart))
			$(".dx-warning").removeClass('hidden');
	});
</script>
			
<script type="text/javascript">
		if( ! $.isFunction($.fn.dxChart))
			return;
		// Charts
		var xenonPalette = ['#68b828','#7c38bc','#0e62c7','#fcd036','#4fcdfc','#00b19d','#ff6264','#f7aa47'];
		// Resize charts
		$(window).on('xenon.resize', function()
		{
			$("#pageviews-visitors-chart").data("dxChart").render();
			$("#server-uptime-chart").data("dxChart").render();
			$("#realtime-network-stats").data("dxChart").render();
			$('.first-month').data("dxSparkline").render();
			$('.second-month').data("dxSparkline").render();
			$('.third-month').data("dxSparkline").render();
		});
		
	});
</script>


</body>
</html>