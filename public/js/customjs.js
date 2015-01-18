	/*         
	     __                   .__        
	    |__|____ __________  _|__| ______
	    |  \__  \\_  __ \  \/ /  |/  ___/
	    |  |/ __ \|  | \/\   /|  |\___ \ 
	/\__|  (____  /__|    \_/ |__/____  >
	\______|    \/                    \/ 
	
	Copyright 2013 - Jarvis : Smart Admin Template version 1.9.4
	
	 * This is part of an item on wrapbootstrap.com
	 * https://wrapbootstrap.com/user/myorange
	 * ==================================

	
	   Table of Contents
	   ---------------------------------------------------------------
	   
		- Activate popovers
		- Right/left Side Bars
		- Turn On RTL Menu
		- Collapse Menu
		- Set Vars
		- On Page Load
		- isMobile
		- Responsive nav 
		- Widgets Desktop
		- widgets Mobile
		- Reset widgets script
		- Calendar
		- JarvisGuage
		- Flot charts
		- Sparklines setup
		- Progress bar
		- Toastr setup
		- Functions for idevice
		- All button functions
		- Logout
		- Slimscroll
		- Easypie
		- Randomize easy pie
		- Chat message
		- Bootbox
		- Enable Select2
		- Setup_datepicker_demo
		- Setup_masked_input
		- Setup_masked_input
		- Setup_timepicker
		- Setup_uislider
		- Validation_setup_demo
		- Setup_wizard_demo
		- Setup checkedin tables
		- Activate_bt_accordion_hack
		- Setup ios button demo
		- Window.resize functions
		- Window.load functions
	   
	*/

	/* ---------------------------------------------------------------------- */
	/*	Set Vars
	/* ---------------------------------------------------------------------- */
	
	/* COLLAPSE MENU 
	   Description: Sets up the option for collapsing the left 
	   hand pane (this is still under construction) 
	*/
	$.collapse_menu = false;  
	
	/* SHOW RIGHT SIDE BAR 
	   Description: Disable the right side bar from displaying 
	*/
	$.right_bar = true;       
	
	/* SHOW LEFT SIDE BAR 
	   Description: By disabling the left side bar you will also 
	   disables the responsive menu 
	*/
	$.left_bar = true;        
	
	/* RTL MENU 
	   Description: Relocates menu from left to right
	*/
	$.rtl = false;			  
	
	/* FIXED BARS
	   Makes the left and right hand asides fixed position.
	   Only the content will scroll 
	*/
	$.fixed_bars = false;			  

	/* TABBED MENU
	   Description: Hides the left bar and shows the main 
	   menu in tabbed format
	*/
	$.tabbed_menu = false;			

	/* DEMO CHAT TYPE EFFECT
	   Used with chatbox demo 
	*/
	$.istying = $('textarea#chat-box-textarea');
	
	/* chart colors default */
	var $chrt_border_color = "#efefef";
	var $chrt_grid_color = "#DDD"
	var $chrt_main = "#E24913";			/* red       */
	var $chrt_second = "#4b99cb";		/* blue      */
	var $chrt_third = "#FF9F01";		/* orange    */
	var $chrt_fourth = "#87BA17";		/* green     */
	var $chrt_fifth = "#BD362F";		/* dark red  */
	var $chrt_mono = "#000";
	
	//turn this on if your browser supports audio
	
	/*var $pop_sound = new Audio("sounds/sound-pop-clear.mp3"); // buffers automatically when created
	var $smallbox = new Audio("sounds/smallbox.mp3"); // buffers automatically when created
	var $messagebox = new Audio("sounds/messagebox.mp3"); // buffers automatically when created
	var $bigbox = new Audio("sounds/bigbox.mp3"); // buffers automatically when created*/
	

	/* ---------------------------------------------------------------------- */
	/*	On Page Load
	/* ---------------------------------------------------------------------- */
	
	$(document).ready( function() {   
		
		/* activate popovers */
		setup_popovers();

		/* Convert main menu to tabbed menu  */
		run_tabbed_menu();

		/* Makes the left and right hand asides fixed position. Only the content will scroll  */
		run_fixed_bar();
		
		/* right and left side bar hidden/show states */
		run_side_bar();
		
		/* switch menu */
		turn_on_rtl_menu();
		
		/* setup collapse menu */
		collapse_menu();
		
	    /* navigation for mobile - it is recommended that you only execute this if mobile is true */
	    setup_responsive_nav();
		
		/* draw flot charts */
		setup_flots();
		
		/* draw calendar */
		setup_calendar();
		
		/* find #second-menu-js and apply accordion menu function */
		setup_accordion_menu();
		
		/* setup toastr responsive alerts */
		setup_toastr();
		
		/* slimscroll */
		setup_slimscroll();

		/* expand search input on focus */
		execute_idevice_functions();	
		
		/* detect if mobile */
		isMobile() 
		
		/* all buttons */
		setup_all_buttons()
        
        /* draw easy pie */
  		setup_easypie();
		
		/* activate sparklines */
		setup_sparklines();
		
		/* progress bar animate */
		progressbar_animate();
		
		
		
		/* start justguage */
		setup_jarvisGuage();
		
		/* start chatbox */
		setup_chatbox_demo();
		
		/* start bootbox */
		setup_bootbox_demo();
		
		/* datepicker for forms */
		setup_datepicker_demo();
		
		/* colorpicker for forms */
		setup_colorpicker_demo();
		
		/* setup_timepicker */
		setup_timepicker();
		
		
		
		/* setup_uislider */
		setup_uislider();
		
		/* validation_setup_demo */
		validation_setup_demo();
		
		/* wizard demo */
		setup_wizard_demo();	
		
		/* tables with checked in checkboxes */
		setup_checkedin_tables_demo();
		
		/* custom form elements */
		setup_custom_form_elements();

	}); 

	/* end on page load */
	
	/* ---------------------------------------------------------------------- */
	/*	isMobile
	/* ---------------------------------------------------------------------- */
	
	/** NOTE: Notice we have seperated funtion calls based on user platform. 
	 		  This significantly cuts down on memory usage and prolongs a healthy 
	 		  user experience. 
	**/
		
	function isMobile() {
		/* so far this is covering most hand held devices */
		var ismobile = (/iphone|ipad|ipod|android|blackberry|mini|windows\sce|palm/i.test(navigator.userAgent.toLowerCase()));	
	    if(!ismobile){
		    //console.log("NOT mobile version - message from config.js");
		    
		    /* widgets for desktop */
		    setup_widgets_desktop();
		    
			/* inline datepicker - appears on aside (right) */
			$('#datepicker').datepicker();
			
		} else {
			//console.log("IS mobile version - message from config.js");
			
			/* widgets for desktop */
			setup_widgets_mobile();
		}
	}
	
	/* end isMobile */

	/* ---------------------------------------------------------------------- */
	/*	Popovers
	/* ---------------------------------------------------------------------- */
	
	function setup_popovers(){
		
		if ($('.popover-js').length){
			/* popovers */
			$('.popover-js').popover();
		}
		
	}
	
	

	/* ---------------------------------------------------------------------- */
	/*	Tabbed Menu
	/* ---------------------------------------------------------------------- */
	
	function run_tabbed_menu(){
		
		if ($.tabbed_menu == true) {
			$('html').addClass('tabbed-menu');
		}
		
	}
	
	/* end Tabbed Menu */

	/* ---------------------------------------------------------------------- */
	/*	Fixed Bar
	/* ---------------------------------------------------------------------- */
	
	function run_fixed_bar(){
		
		if ($.fixed_bars == true) {
			$('html').addClass('fixed-bars');
		}
		
	}
	
	/* end Fixed Bar */

	/* ---------------------------------------------------------------------- */
	/*	Right Side Bar
	/* ---------------------------------------------------------------------- */
	
	function run_side_bar(){
		
		if ($.right_bar == false) {
			$('html').addClass('no-right-bar');
		}
		
		if ($.left_bar == false) {
			$('html').addClass('no-left-bar');
		}
		
	}
	
	/* end Right Side Bar */

	/* ---------------------------------------------------------------------- */
	/*	Turn On RTL Menu
	/* ---------------------------------------------------------------------- */
	
	function turn_on_rtl_menu(){
		
		if ($.rtl == true) {
			$('aside').css('float','right');
			$('aside.right').css('right','auto');
			$('#page-content').css('margin-left','249px') // this should be a class
		}
		
	}
	
	/* end Turn On RTL Menu */

	/* ---------------------------------------------------------------------- */
	/*	Collapse Menu
	/* ---------------------------------------------------------------------- */
	
	function collapse_menu(){
		
		if ($.collapse_menu == true) {
			$('#page-header').prepend('<a class="btn btn-navbar" id="response-btn"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </a>')
		}
		
	}
	
	/* end Collapse Menu */
	
	/* ---------------------------------------------------------------------- */
	/*	Responsive nav 
	/* ---------------------------------------------------------------------- */
	
	function setup_responsive_nav() {
		
		/* build responsive menu in dropdown select */		
		selectnav('accordion-menu-js', {
		  label: 'Quick Menu ',
		  nested: true,
		  indent: '-'
		});
		
	}
	
	/* end responsive nav */
	
	/* ---------------------------------------------------------------------- */
	/*	Widgets Desktop
	/* ---------------------------------------------------------------------- */	
	
	function setup_widgets_desktop() {
		
		if ($('#widget-grid').length){
			
			$('#widget-grid').jarvisWidgets({	
							
				grid: 'article',
				widgets: '.jarviswidget',
				localStorage: true,
				deleteSettingsKey: '#deletesettingskey-options',
				settingsKeyLabel: 'Reset settings?',
				deletePositionKey: '#deletepositionkey-options',
				positionKeyLabel: 'Reset position?',
				sortable: true,
				buttonsHidden: false,
				toggleButton: true,
				toggleClass: 'min-10 | plus-10',
				toggleSpeed: 200,
				onToggle: function(){},
				deleteButton: true,
				deleteClass: 'trashcan-10',
				deleteSpeed: 200,
				onDelete: function(){},
				editButton: true,
				editPlaceholder: '.jarviswidget-editbox',
				editClass: 'pencil-10 | edit-clicked',
				editSpeed: 200,
				onEdit: function(){},
				fullscreenButton: true,
				fullscreenClass: 'fullscreen-10 | normalscreen-10',	
				fullscreenDiff: 3,		
				onFullscreen: function(){},
				customButton: false,
				customClass: 'folder-10 | next-10',
				customStart: function(){ alert('Hello you, this is a custom button...') },
				customEnd: function(){ alert('bye, till next time...') },
				buttonOrder: '%refresh% %delete% %custom% %edit% %fullscreen% %toggle%',
				opacity: 1.0,
				dragHandle: '> header',
				placeholderClass: 'jarviswidget-placeholder',
				indicator: true,
				indicatorTime: 600,
				ajax: true,
				timestampPlaceholder:'.jarviswidget-timestamp',
				timestampFormat: 'Last update: %m%/%d%/%y% %h%:%i%:%s%',
			    refreshButton: true,
			    refreshButtonClass: 'refresh-10',
				labelError:'Sorry but there was a error:',
				labelUpdated: 'Last Update:',
				labelRefresh: 'Refresh',
				labelDelete: 'Delete widget:',
				afterLoad: function(){},
				rtl: false
				
			});
			
		} // end if
		
	}
	
	/* end widgets desktop */

	/* ---------------------------------------------------------------------- */
	/*	Widgets Mobile
	/* ---------------------------------------------------------------------- */
	
	function setup_widgets_mobile() {	
		
		if ($('#widget-grid').length){
			
			$('#widget-grid').jarvisWidgets({	
							
				grid: 'article',
				widgets: '.jarviswidget',
				localStorage: true,
				deleteSettingsKey: '#deletesettingskey-options',
				settingsKeyLabel: 'Reset settings?',
				deletePositionKey: '#deletepositionkey-options',
				positionKeyLabel: 'Reset position?',
				sortable: false, // sorting disabled for mobile
				buttonsHidden: false,
				toggleButton: true,
				toggleClass: 'min-10 | plus-10',
				toggleSpeed: 200,
				onToggle: function(){},
				deleteButton: false,
				deleteClass: 'trashcan-10',
				deleteSpeed: 200,
				onDelete: function(){},
				editButton: true,
				editPlaceholder: '.jarviswidget-editbox',
				editClass: 'pencil-10 | edit-clicked',
				editSpeed: 200,
				onEdit: function(){},
				fullscreenButton: false,
				fullscreenClass: 'fullscreen-10 | normalscreen-10',	
				fullscreenDiff: 3,		
				onFullscreen: function(){},
				customButton: false, // custom button disabled for mobile
				customClass: 'folder-10 | next-10',
				customStart: function(){ alert('Hello you, this is a custom button...') },
				customEnd: function(){ alert('bye, till next time...') },
				buttonOrder: '%refresh% %delete% %custom% %edit% %fullscreen% %toggle%',
				opacity: 1.0,
				dragHandle: '> header',
				placeholderClass: 'jarviswidget-placeholder',
				indicator: true,
				indicatorTime: 600,
				ajax: true,
				timestampPlaceholder:'.jarviswidget-timestamp',
				timestampFormat: 'Last update: %m%/%d%/%y% %h%:%i%:%s%',
			    refreshButton: true,
			    refreshButtonClass: 'refresh-10',
				labelError:'Sorry but there was a error:',
				labelUpdated: 'Last Update:',
				labelRefresh: 'Refresh',
				labelDelete: 'Delete widget:',
				afterLoad: function(){},
				rtl: false
				
			});
			
		}// end if
		
	}
		
	/* end widgets Mobile */

	/* ---------------------------------------------------------------------- */
	/*	Reset widgets script
	/* ---------------------------------------------------------------------- */
		
	function resetWidget() {
			
		var cls = confirm("Would you like to RESET all your saved widgets and clear LocalStorage?");
		if(cls && localStorage){
			localStorage.clear();
			//alert('Local storage has been cleared! Refreshing page...');
			location.reload();
		}

	}
	
	/* end reset widgets script */

	/* ---------------------------------------------------------------------- */
	/*	set up accordion menu
	/* ---------------------------------------------------------------------- */	
	
	function setup_accordion_menu () {
		
		$("#accordion-menu-js").ctAccordion();	
	}
	
	/* end setup accordion menu */

	/* ---------------------------------------------------------------------- */
	/*	Calendar
	/* ---------------------------------------------------------------------- */

	function setup_calendar() {
		
		if ($("#calendar").length) {
			var date = new Date();
			var d = date.getDate();
			var m = date.getMonth();
			var y = date.getFullYear();
			
			var calendar = $('#calendar').fullCalendar({
				header: {
					left: 'title', //,today
					center: 'prev, next, today',
					right: 'month, agendaWeek, agenDay' //month, agendaDay, 
				},
				selectable: true,
				selectHelper: true,
				select: function(start, end, allDay) {
					var title = prompt('Event Title:');
					if (title) {
						calendar.fullCalendar('renderEvent',
							{
								title: title,
								start: start,
								end: end,
								allDay: allDay
							},
							true // make the event "stick"
						);
					}
					calendar.fullCalendar('unselect');
				},
				
				editable: true,
				events: [
					{
						title: 'All Day Event',
						start: new Date(y, m, 1)
					},
					{
						title: 'Long Event',
						start: new Date(y, m, d-5),
						end: new Date(y, m, d-2)
					},
					{
						id: 999,
						title: 'Repeating Event',
						start: new Date(y, m, d-3, 16, 0),
						allDay: false
					},
					{
						id: 999,
						title: 'Repeating Event',
						start: new Date(y, m, d+4, 16, 0),
						allDay: false
					},
					{
						title: 'Meeting',
						start: new Date(y, m, d, 10, 30),
						allDay: false
					},
					{
						title: 'Lunch',
						start: new Date(y, m, d, 12, 0),
						end: new Date(y, m, d, 14, 0),
						allDay: false
					},
					{
						title: 'Birthday Party',
						start: new Date(y, m, d+1, 19, 0),
						end: new Date(y, m, d+1, 22, 30),
						allDay: false
					},
					{
						title: 'Click for Google',
						start: new Date(y, m, 28),
						end: new Date(y, m, 29),
						url: 'http://google.com/'
					}
				]
			});

		};
		
		/* hide default buttons */
		$('.fc-header-right, .fc-header-center').hide();

	}
	
	/* end calendar */

	/* ---------------------------------------------------------------------- */
	/*	JarvisGuage
	/* ---------------------------------------------------------------------- */	
	
	function setup_jarvisGuage() {
	
		if ($('#gague-chart').length) {
			var g1, g2, g3, g4, g5, g6;
			
			window.onload = function() {
				var g1 = new JustGage({
					id : "g1",
					value : 100,
					min : 0,
					max : 100,
					title : "Custom Width",
					label : "",
					//valueFontColor : "#ed1c24",
					gaugeWidthScale : 0.2
				});
	
				var g2 = new JustGage({
					id : "g2",
					value : getRandomInt(0, 100),
					min : 0,
					max : 100,
					title : "Custom Shadow",
					label : "",
					shadowOpacity : 1,
					shadowSize : 0,
					shadowVerticalOffset : 10
				});
	
				var g3 = new JustGage({
					id : "g3",
					value : getRandomInt(0, 100),
					min : 0,
					max : 100,
					title : "Custom Colors",
					label : "",
					levelColors : ["#00fff6", "#ff00fc", $chrt_third]
				});
	
				var g4 = new JustGage({
					id : "g4",
					value : getRandomInt(0, 100),
					min : 0,
					max : 100,
					title : "Hide Labels",
					showMinMax : false
				});
	
				var g5 = new JustGage({
					id : "g5",
					value : getRandomInt(0, 100),
					min : 0,
					max : 100,
					title : "Animation Type",
					label : "",
					startAnimationTime : 2000,
					startAnimationType : ">",
					refreshAnimationTime : 1000,
					refreshAnimationType : "bounce"
				});
	
				var g6 = new JustGage({
					id : "g6",
					value : getRandomInt(0, 100),
					min : 0,
					max : 100,
					title : "Minimal",
					label : "",
					showMinMax : false,
					levelColors : [$chrt_second],
					showInnerShadow : false,
					startAnimationTime : 1,
					startAnimationType : "linear",
					refreshAnimationTime : 1,
					refreshAnimationType : "linear"
				});
	
				
			};
		} // end if

	}

    /* end JarvisGague */  

	/* ---------------------------------------------------------------------- */
	/*	Flot charts
	/* ---------------------------------------------------------------------- */	
	
	function setup_flots() {
		
		/* sales chart */
		if ($("#bar-chart").length) {
		
		
var url = "http://advancedairadmin.com/user/getTeamSales";
$.ajax({
  dataType: "html",
  url: url,
  success: function(data){
  	var data1 = eval(data);
 		var ds = new Array();
	
			ds.push({
				data : data1,
				bars : {
					show : true,
					barWidth : 0.4,
					order : 1,
				}
			});
			//Display graph
			$.plot($("#bar-chart"), ds, {
				colors : [$chrt_second, $chrt_fourth, "#666", "#BBB"],
				grid : {
					show : true,
					hoverable : true,
					clickable : true,
					tickColor : $chrt_border_color,
					borderWidth : 0,
					borderColor : $chrt_border_color,
				},
				legend : true,
				
	
			});
}
});
		}
		
}

	/* ---------------------------------------------------------------------- */
	/*	Sparklines setup
	/* ---------------------------------------------------------------------- */	
	
	function setup_sparklines(){
		
		if ($('.mystats').length){
			$('#balance').sparkline([11,8,40,40,18,40,33,15,42,25,10,20], {
				type : 'bar',
				barColor : $chrt_main,
				height : '30px',
				barWidth : "5px",
				barSpacing : "2px",
				zeroAxis : "false"
			});
			$('#clicks').sparkline([3,8,31,23,15,18,12,22,33,14,32,20], {
				type : 'bar',
				barColor : $chrt_second,
				height : '30px',
				barWidth : "5px",
				barSpacing : "2px",
				zeroAxis : "false"
			});
			$('#subscribe').sparkline([1,8,20,12,19,18,43,27,14,22,10,18], {
				type : 'bar',
				barColor : $chrt_third,
				height : '30px',
				barWidth : "5px",
				barSpacing : "2px",
				zeroAxis : "false"
			});
			$('#support').sparkline([18,17,22,19,23,18,22,24,17,20,16,17], {
				type : 'bar',
				barColor : $chrt_fourth,
				height : '30px',
				barWidth : "5px",
				barSpacing : "2px",
				zeroAxis : "false"
			});
		} // end if
	}

	/* end sparklines */

	/* ---------------------------------------------------------------------- */
	/*	Progress bar
	/* ---------------------------------------------------------------------- */	

	function progressbar_animate(){
		$('.progress .bar.filled-text').progressbar({
	        display_text: 1,
	        transition_delay: 1000,
	    });
		
		$('.slim .bar').progressbar({
			 transition_delay: 300
		});
		
		$('.delay .bar').progressbar({
			display_text: 1,
	        transition_delay: 2000
	    });
		
		$('.value .bar').progressbar({
			display_text: 1,
	        use_percentage: false,
	        transition_delay: 1000
	    });
		
		$('.progress .bar.centered-text').progressbar({
	        display_text: 2,
	    });
		
		$('.progress .no-text').progressbar();
	}
	
	/* end progress bar */
	
	/* ---------------------------------------------------------------------- */
	/*	Toastr setup
	/* ---------------------------------------------------------------------- */	
	
	function setup_toastr() {
	
		toastr.options = {
			tapToDismiss : true,
			toastClass : 'toast',
			containerId : 'toast-container',
			debug : false,
			fadeIn : 250,
			fadeOut : 200,
			extendedTimeOut : 10000,
			iconClasses : {
				error : 'toast-error',
				info : 'toast-info',
				success : 'toast-success',
				warning : 'toast-warning'
			},
			iconClass : 'toast-info',
			positionClass : 'toast-bottom-right',
			timeOut : 10500, // Set timeOut to 0 to make it sticky
			titleClass : 'toast-title',
			messageClass : 'toast-message'
		};
		
	}

	/* end toastr */

	/* ---------------------------------------------------------------------- */
	/*	Functions for idevice
	/* ---------------------------------------------------------------------- */	
	
	function execute_idevice_functions() {
		
		/* Function Detect iDevice 
		   Documentation: http://ivaynberg.github.com/select2/	*/
		if((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i))) {
				
			/*	Initialize Hide iDevice Address bar */
			window.addEventListener("load",function() {			  
			  setTimeout(function(){
			    window.scrollTo(0, 1);  // Hide the address bar to increase user experience!
			  }, 0);
			});			
			/*end hide address*/
				  	
		} else {
			// do nothing
		 	return false;
		}
		/* end if */
	}
	
	/* end functions for idevice*/
	
	
	/* ---------------------------------------------------------------------- */
	/*	All button functions
	/* ---------------------------------------------------------------------- */	
	
	function setup_all_buttons() {
		
		/* buttons */		
		$("#refresh-js").click(function() {
		  toastr.warning('Please try again later', 'Database offline. No data available!');
		  return false; 
				
		});
		
		$("#save-notes-btn-js").click(function() {
			toastr.success('Message have been saved to notes', 'Saved');
			return false; 
		});
		
		$("#post-btn-js").click(function() {
			toastr.error('Database is currently offline', 'Error');
			return false; 
		});
		
		/* end buttons */
		
		/* theme switcher */
		
		$('#theme-switcher ul#theme-links-js li a').bind('click',
			function(e) {
				$("#switch-theme-js").attr("href", "css/themes/"+$(this).data('rel')+".css");
				return false;
			}
		);
		
		/* end theme switcher */
		
		/* stop inbox tool bar dropdown from closing when clicked on a link */
		
		$('#theme-switcher ul.mailbox li a').bind('click',
			function(e) {
				return false;
			}
		);
		
		/* end inbox tool bar adjustment*/
		
		/* calendar buttons */

		$('div#calendar-buttons #btn-prev').click(function(){
		    $('.fc-button-prev').click();
		    return false;
		});
		
		$('div#calendar-buttons #btn-next').click(function(){
		    $('.fc-button-next').click();
		    return false; 
		});

		$('div#calendar-buttons #btn-today').click(function(){
		    $('.fc-button-today').click();
		    return false; 
		});
		
		$('div#calendar-buttons #btn-month').click(function(){
		    $('#calendar').fullCalendar('changeView', 'month');
		});
		
		$('div#calendar-buttons #btn-agenda').click(function(){
		    $('#calendar').fullCalendar('changeView', 'agendaWeek');
		});
		
		$('div#calendar-buttons #btn-day').click(function(){
		   $('#calendar').fullCalendar('changeView', 'agendaDay');
		});
		
		/* end calendar buttons */
		
		/* inbox buttons */
		
		$('ul#mailbox-js > li > a').click(function(){
			show_inbox_menu_header();
		});
		
		$('#inbox-menu-header-js a.slashc-sliding-menu-home').click(function(){
			hide_inbox_menu_header();
		});
		
		/* end inbox buttons */
		
		/* logout button click */
		
		$('.logout-js').click(function(){
		   $('body').addClass('logout');
		   setTimeout(logout,400)
		   return false; 
		});
		
		/* end logout button click */
		
		/* reset widget */
		$('a#reset-widget').click(function(){
			resetWidget();
			return false;
		});
		
		/* loading state button */
	
		$('#fat-btn').click(function() {
			var btn = $(this)
			btn.button('loading')
			setTimeout(function() {
				btn.button('reset')
			}, 3000)
		})
		
	}
	
	/* end all button functions */

	/* ---------------------------------------------------------------------- */
	/*	Logout
	/* ---------------------------------------------------------------------- */

	function logout(){
		
		var linky = $('.logout-js').data('rel');
		window.location.href = linky;
		
	}

	/* end logout */

	/* ---------------------------------------------------------------------- */
	/*	sound effects
	/* ---------------------------------------------------------------------- */
		
	function popsound() {
	  	//$pop_sound.play();
	  	$('embed').remove();
	    $('body').append('<embed src="sounds/sound-pop-clear.mp3" autostart="true" hidden="true" loop="false">');
	}
	
	function play_sound_message_box(){
		//$messagebox.play(); //turn this on if your browser supports audio
	}

	function play_sound_big_box(){
		//$bigbox.play(); //turn this on if your browser supports audio
	}
	
	function play_sound_small_box(){
		//$smallbox.play(); //turn this on if your browser supports audio
	}
           
    /* sound effect */

	/* ---------------------------------------------------------------------- */
	/*	Slimscroll
	/* ---------------------------------------------------------------------- */	
	
	function setup_slimscroll(){
		
		/* mini inbox dropdown */
		$('ul#mailbox-slimscroll-js').slimScroll({
			height: '277px',
			width: '240px',
			disableFadeOut: true,
			distance: 3,
			size: 7
		});
		
		/* chat message box */
		$('div.chat-messages').slimScroll({
			height: '370px',
			disableFadeOut: true,
			railVisible:true, 
			distance: 3,
			size: 7
		});
		
		if ($('#inbox-menu-js').length){
			
			//$('h1#inbox-menu-header-js').slideUp(2200, 'easeOutSine');
			$('#inbox-menu-js').slimScroll({
			height: '518px',
			width: '249',
			disableFadeOut: true,
			distance: 3,
			size: 7
			});
			hide_inbox_menu_header()
			
			$('#inbox-loading-panel-js').slimScroll({
			height: '518px',
			width: 'auto',
			disableFadeOut: true,
			distance: 5,
			size: 7
			});
			
			
		}// end if
		
	}
	
	function hide_inbox_menu_header() {
		$('#inbox-menu-header-js').animate({"top" : "-42px"}, 250);
		$('#mailbox-js').animate({"top" : "-42px"}, 250);
	}
	
	function show_inbox_menu_header() {
		$('#inbox-menu-header-js').animate({"top" : "0px"}, 250);
		$('#mailbox-js').animate({"top" : "0px"}, 250);
	}
	
	/* end slimscroll */

	/* ---------------------------------------------------------------------- */
	/*	Easypie
	/* ---------------------------------------------------------------------- */	
	
	function setup_easypie(){

       /* lighter version */
		if ($('.percentage').length) { 
			$.percentage_easy_pie = $('.percentage');	
			$.percentage_easy_pie.easyPieChart({
				animate: 2000,
				trackColor:	"#515151",
				scaleColor:	"#515151",
				lineCap: 'butt',
				lineWidth: 20,
				barColor: function(percent) {
				    percent /= 100;
				    return "rgb(" + Math.round(255 * (1-percent)) + ", " + Math.round(255 * percent) + ", 0)";
				},
				size: 88
			});
			
		}// end if	
        
	}
	
	/* end easypie */
	
	/* ---------------------------------------------------------------------- */
	/*	Randomize easy pie
	/* ---------------------------------------------------------------------- */		
	
	function easypie_randomize(){
		
		var items = $.percentage_easy_pie;
	    for (var i = 0; i < items.length; i++) {
	        //do stuff
	        var newValue = Math.round(100*Math.random());
	        $(this).data('easyPieChart').update(newValue);
	        $('span', this).text(newValue);
	    } 
		//console.log(items.length);
	
	}

	/* end randomize */    	
	
	
	
	/* ---------------------------------------------------------------------- */
	/*	Chat message
	/* ---------------------------------------------------------------------- */
	
	function setup_chatbox_demo() {
		
		/* message id */
		var id = 0;
		
		$.istying.focus(function() {
			//$('.type-effect').show();
		});
	
		$.istying.blur(function() {
			//$('.type-effect').hide();
		});
	
		/* on button press */
		$('#send-msg-js').click(function() {
			var msg_input = $.istying.val();
			if (msg_input.length) {
				var msg_input = $.istying.val();
				id++;
				$('.tab-pane.active > div > .chat-messages').prepend('<p id="message-dynamic-' + id + '" class="message-box you"><img src="img/avatar/avatar_0.jpg" alt=""><span class="message"><strong>Me</strong><span class="message-time">by Victoria at 14:25pm, 4th Jan 2013</span><span class="message-text">' + msg_input + '</span></span></p>')
				$('.tab-pane.active > div > .chat-messages #message-dynamic-' + id).hide().fadeIn(750);
				//console.log(msg_input.trim() + id);
				$.istying.val('');
				play_sound_small_box();
			}
			return false; 
	
		});
	
		/* on key press enter */
		$.istying.on('keyup', function(e) {
			
			if (e.keyCode == 13) {
				var msg_input = $.istying.val();
				if (msg_input.length) {
					var msg_input = $.istying.val();
					id++;
					$('.tab-pane.active > div > .chat-messages').prepend('<p id="message-dynamic-' + id + '" class="message-box you"><img src="img/avatar/avatar_0.jpg" alt=""><span class="message"><strong>Me</strong><span class="message-time">by Victoria at 14:25pm, 4th Jan 2013</span><span class="message-text">' + msg_input + '</span></span></p>')
					$('.tab-pane.active > div > .chat-messages #message-dynamic-' + id).hide().fadeIn(750);
					//console.log(msg_input.trim() + id);
					$.istying.val('');
					play_sound_small_box();
				}
			}// end if
		});
	
	}
	
	/* end chat message */
	
	 

	/* ---------------------------------------------------------------------- */
	/*	Enable Select2
	/* ---------------------------------------------------------------------- */
	
	function setup_custom_form_elements() {
		if ($('.themed').length) {
			$(".themed input[type='radio'], .themed input[type='checkbox'], .themed input[type='file'].file, .themed textarea").uniform();
			$(".themed select.with-search").select2();
			
			/* some demo buttons for select 2 */
	
			$("#disable-select-demo").click(function() {
				$("#select-demo-js select").select2("disable");
			});
			
			$("#enable-select-demo").click(function() {
				$("#select-demo-js select.with-search").select2();
			}); 

		}// end if
	}
	
	/* end select2 */

	/* ---------------------------------------------------------------------- */
	/*	Setup_datepicker_demo
	/* ---------------------------------------------------------------------- */	
	
	function setup_datepicker_demo() {
		if ($('#datepicker-js').length){
			$('#datepicker-js, #datepicker-js-2').datepicker()
		}// end if
	}	
	
	/* end setup_datepicker_demo */
	
	/* ---------------------------------------------------------------------- */
	/*	Setup_colorpicker_demo
	/* ---------------------------------------------------------------------- */	
	
	function setup_colorpicker_demo() {
		if ($('#colorpicker-js').length){
			$('#colorpicker-js, #colorpicker-js-2, #colorpicker-js-3').colorpicker()
		}// end if
	}	
	
	/* end setup_datepicker_demo */
	
/* ---------------------------------------------------------------------- */
	/*	Setup_timepicker
	/* ---------------------------------------------------------------------- */	
	
	//documentation: http://jdewit.github.com/bootstrap-timepicker/index.html
	
	function setup_timepicker() {
		if ($('#timepicker-demo').length) {
			
			/* default */
			$('#timepicker1').timepicker();
			
			/* in model */
            $('#timepicker2').timepicker({
                minuteStep: 1,
                template: 'modal',
                showSeconds: true,
                showMeridian: false
            });
		}
	}
	
	

	/* ---------------------------------------------------------------------- */
	/*	Setup_uislider
	/* ---------------------------------------------------------------------- */	
	
	//reference: https://groups.google.com/forum/?fromgroups=#!topic/twitter-bootstrap-stackoverflow/ko8GIGczZ54

	function setup_uislider() {
		if ($('#uislider-demo').length) {	

			$("#slider-range").slider({
			    range: true,
			    min: 100,
			    max: 500,
			    values: [176, 329],
			    slide: function(event, ui) {
			        $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
			
			        $('#slider-range .ui-slider-handle:first').html('<div class="tooltip top slider-tip"><div class="tooltip-arrow"></div><div class="tooltip-inner">' + ui.values[0] + '</div></div>');
			        $('#slider-range .ui-slider-handle:last').html('<div class="tooltip top slider-tip"><div class="tooltip-arrow"></div><div class="tooltip-inner">' + ui.values[1] + '</div></div>');
			    }
			});
			$("#amount").val("$" + $("#slider-range").slider("values", 0) + " - $" + $("#slider-range").slider("values", 1));

				
			$( "#slider-range-min" ).slider({
		            range: "min",
		            value: 461,
		            min: 100,
		            max: 900,
		            slide: function( event, ui ) {
		                $( "#amount2" ).val( "$" + ui.value );
		                $('#slider-range-min .ui-slider-handle:first').html('<div class="tooltip top slider-tip"><div class="tooltip-arrow"></div><div class="tooltip-inner">' + ui.value + '</div></div>');
		            }
		        });
		    $("#amount2").val( "$" + $( "#slider-range-min" ).slider("value"));
			
			
			$( "#slider-range-max" ).slider({
		            range: "max",
		            min: 100,
		            max: 999,
		            value: 507,
		            slide: function( event, ui ) {
		                $( "#amount3" ).val( "$" + ui.value );
		                $('#slider-range-max .ui-slider-handle:first').html('<div class="tooltip top slider-tip"><div class="tooltip-arrow"></div><div class="tooltip-inner">' + ui.value + '</div></div>');
		            }
		        });
		    $("#amount3" ).val( "$" + $( "#slider-range-max" ).slider( "value" ));
		    
			$("#slider-range-step").slider({
			    range: true,
			    min: 100,
			    max: 999,
			    step:100,
			    values: [250, 850],
			    slide: function(event, ui) {
			        $("#amount4").val("$" + ui.values[0] + " - $" + ui.values[1]);
			
			        $('#slider-range-step .ui-slider-handle:first').html('<div class="tooltip top slider-tip"><div class="tooltip-arrow"></div><div class="tooltip-inner">' + ui.values[0] + '</div></div>');
			        $('#slider-range-step .ui-slider-handle:last').html('<div class="tooltip top slider-tip"><div class="tooltip-arrow"></div><div class="tooltip-inner">' + ui.values[1] + '</div></div>');
			    }
			});
			$("#amount4").val("$" + $("#slider-range-step").slider("values", 0) + " - $" + $("#slider-range-step").slider("values", 1));
			
		}
	}
	
	/* end setup_uislider */

	/* ---------------------------------------------------------------------- */
	/*	Validation_setup_demo
	/* ---------------------------------------------------------------------- */
	
	//documentation: http://docs.jquery.com/Plugins/Validation/

	function validation_setup_demo() {
		if ($('#validate-demo-js').length) {
			$("#validate-demo-js").validate({
				rules : {
					simple : "required",
					minString : {
						required : true,
						minlength : 3
					},
					maxString : {
						required : true,
						maxlength : 5
					},
					minNumber : {
						required : true,
						min : 3
					},
					maxNumber : {
						required : true,
						max : 5
					},
					rangeValue : {
						required : true,
						range : [5, 10]
					},
					emailValidation : {
						required : true,
						email : true
					},
					urlValidation : {
						required : true,
						url : true
					},
					dateValidation : {
						required : true,
						date : true
					},
					noStrings : {
						required : true,
						digits : true
					},
					password : {
						required : true,
						minlength : 5
					},
					passwordRepeat : {
						required : true,
						minlength : 5,
						equalTo : "#password"
					},
					topic : {
						required : "#newsletter:checked",
						minlength : 2
					},
					agree : "required"
				}, // end rules
				highlight : function(label) {
					$(label).closest('.control-group').removeClass('success');
					$(label).closest('.control-group').addClass('error');
				},
				success : function(label) {
					label.text('').addClass('valid').closest('.control-group').addClass('success');
				}
			});
		}// end if

	} 
	
	/* end validation_setup_demo */

	/* ---------------------------------------------------------------------- */
	/*	Setup_wizard_demo
	/* ---------------------------------------------------------------------- */	
	
	function setup_wizard_demo() {
		if ($('#wizard_name').length) {
			$('#wizard_name').bootstrapWizard({
				'tabClass' : 'nav',
				'debug' : false,
				onShow : function(tab, navigation, index) {
					//console.log('onShow');
				},
				onNext : function(tab, navigation, index) {
					//console.log('onNext');
					if (index == 1) {
						// Make sure we entered the name
						if (!$('#name').val()) {
							//alert('You must enter your name');
							$('#name').focus();
							$('#name').closest('.control-group').removeClass('success');
							$('#name').closest('.control-group').addClass('error');
							return false;
						}
						if (!$('#lname').val()) {
							//alert('You must enter your last name');
							$('#lname').focus();
							$('#lname').closest('.control-group').removeClass('success');
							$('#lname').closest('.control-group').addClass('error');
							return false;
						}
					}
					$.jGrowl("Its nice to finally meet you! Please remember <b>"+$('#name').val()+",</b> this is only a demo. Not all the functions will work. For full documentation please see the link on top of the page", { 
						header: 'Hey there ' + $('#name').val()+'!', 
						sticky: true,
						theme: 'with-icon',
						easing: 'easeOutBack',
						animateOpen: { 
							height: "show"
						},
						animateClose: { 
							opacity: 'hide' 
						}
					});	
					// Set the name for the next tab
					//$('#inverse-tab3').html('Hello, ' + $('#name').val());
	
				},
				onPrevious : function(tab, navigation, index) {
					//console.log('onPrevious');
				},
				onLast : function(tab, navigation, index) {
					//console.log('onLast');
				},
				onTabClick : function(tab, navigation, index) {
					//console.log('onTabClick');
					alert('on tab click disabled');
					return false;
				},
				onTabShow : function(tab, navigation, index) {
					//console.log('onTabShow');
					var $total = navigation.find('li').length;
					var $current = index + 1;
					var $percent = ($current / $total) * 100;
					$('#wizard_name').find('.bar').css({
						width : $percent + '%'
					});
				}
			});
		}// end if
	
	}
	
	/* end setup_wizard_demo */

	/* ---------------------------------------------------------------------- */
	/*	Setup checkedin tables
	/* ---------------------------------------------------------------------- */
	
	function setup_checkedin_tables_demo() {
		
		if ($("table.checked-in").length){
		 	$("td input[type='checkbox']").click(function(){
		        if ($(this).is(':checked')){
		              $(this).parent().addClass("highlighted");
		              $(this).parent().siblings().addClass("highlighted");
		        } else if($(this).parent().is(".highlighted")) {
		             $(this).parent().removeClass("highlighted");
		             $(this).parent().siblings().removeClass("highlighted");
		        }
		    });
		}// end if
		
	}
	
	/* end checkedin tables */
	
	/* ---------------------------------------------------------------------- */
	/*	Activate_bt_accordion_hack
	/* ---------------------------------------------------------------------- */	
		
	$(function() {
		
		// credit: http://stackoverflow.com/questions/10918801/twitter-bootstrap-adding-a-class-to-the-open-accordion-title
	    $('.accordion').on('show', function (e) {
	         $(e.target).prev('.accordion-heading').find('.accordion-toggle').addClass('active');
	    });
	    
	    $('.accordion').on('hide', function (e) {
	        $(this).find('.accordion-toggle').not($(e.target)).removeClass('active');
	    });
	        
	});

	/* end activate_bt_accordion_hack */
	
	/* ---------------------------------------------------------------------- */
	/*	Window.resize functions
	/* ---------------------------------------------------------------------- */	
		
	$(window).resize(function(){


	});
	
	/* end window.resize functions */
	
	/* ---------------------------------------------------------------------- */
	/*	Window.load functions
	/* ---------------------------------------------------------------------- */	
	
	$(window).load(function(){


	});
	
	/* end window.load functions */
