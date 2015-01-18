<?php $setting = Setting::find(1);?>
<!DOCTYPE html>
<!--HTML5 doctype-->
<html>

    <head>
        <script>
        (function() {
    if ("-ms-user-select" in document.documentElement.style && navigator.userAgent.match(/IEMobile\/10\.0/)) {
        var msViewportStyle = document.createElement("style");
        msViewportStyle.appendChild(
            document.createTextNode("@-ms-viewport{width:auto!important}")
        );
        document.getElementsByTagName("head")[0].appendChild(msViewportStyle);
    }
})();

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

        <title>{{$setting->title}}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
        <meta http-equiv="Content-type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0">
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <link rel="stylesheet" type="text/css" href="{{URL::to_asset('mobile/')}}css/icons.css" />    
 
       <!--   
     <link rel="stylesheet" type="text/css" href="{{URL::to_asset('mobile/')}}css/af.ui.css" title="default" />
  -->
      <link rel="stylesheet" type="text/css" href="{{URL::to_asset('mobile/')}}css/main.css"  />
      <link rel="stylesheet" type="text/css" href="{{URL::to_asset('mobile/')}}css/appframework.css"  />
      <link rel="stylesheet" type="text/css" href="{{URL::to_asset('mobile/')}}css/lists.css"  />
      <link rel="stylesheet" type="text/css" href="{{URL::to_asset('mobile/')}}css/forms.css"  />
      <link rel="stylesheet" type="text/css" href="{{URL::to_asset('mobile/')}}css/buttons.css"  />        
      <link rel="stylesheet" type="text/css" href="{{URL::to_asset('mobile/')}}css/badges.css"  />        
      <link rel="stylesheet" type="text/css" href="{{URL::to_asset('mobile/')}}css/grid.css"  />
      <link rel="stylesheet" type="text/css" href="{{URL::to_asset('mobile/')}}css/android.css"  />
      <link rel="stylesheet" type="text/css" href="{{URL::to_asset('mobile/')}}css/win8.css"  />
      <link rel="stylesheet" type="text/css" href="{{URL::to_asset('mobile/')}}css/bb.css"  />
      <link rel="stylesheet" type="text/css" href="{{URL::to_asset('mobile/')}}css/ios.css"  />
      <link rel="stylesheet" type="text/css" href="{{URL::to_asset('mobile/')}}css/ios7.css"  />
      <link rel="stylesheet" type="text/css" href="{{URL::to_asset('mobile/')}}css/tizen.css"  />
      <link rel="stylesheet" type="text/css" href="{{URL::to_asset('mobile/')}}plugins/css/af.actionsheet.css"  />
      <link rel="stylesheet" type="text/css" href="{{URL::to_asset('mobile/')}}plugins/css/af.popup.css"  />
      <link rel="stylesheet" type="text/css" href="{{URL::to_asset('mobile/')}}plugins/css/af.scroller.css"  />
      <link rel="stylesheet" type="text/css" href="{{URL::to_asset('mobile/')}}plugins/css/af.selectBox.css"  />  
      <link rel="stylesheet" type="text/css" href="{{URL::to_asset('mobile/')}}css/animate.css"  />      
      <link rel="stylesheet" type="text/css" href="{{URL::to_asset('css/')}}mobilestyles.css"  />  
       <link rel="stylesheet" type="text/css" href="{{URL::to_asset('css/')}}ajaxwait.css"  />      
        <script type="text/javascript" charset="utf-8" src="{{URL::to_asset('mobile/')}}appframework.js"></script>
        <script>
            function loadedPanel(what) {
                //We are going to set the badge as the number of li elements inside the target
                $.ui.updateBadge("#applink", $("#demos").find("li").length);
                $.ui.updateBadge("#unpaidlink", $("#unpaidsales").find("li").length);
                $.ui.updateBadge("#paidlink", $("#paidsales").find("li").length);
            }
            function unloadedPanel(what) {
                console.log("unloaded " + what.id);
            }
            if (!((window.DocumentTouch && document instanceof DocumentTouch) || 'ontouchstart' in window)) {
                var script = document.createElement("script");
                script.src = "{{URL::to_asset('mobile/')}}plugins/af.desktopBrowsers.js";
                var tag = $("head").append(script);
                //$.os.desktop=true;
            }
          //  $.feat.nativeTouchScroll=true;
        </script>        
        <script type="text/javascript" charset="utf-8" src="{{URL::to_asset('mobile/')}}plugins/af.actionsheet.js"></script>
        <script type="text/javascript" charset="utf-8" src="{{URL::to_asset('mobile/')}}plugins/af.css3animate.js"></script>
        <script type="text/javascript" charset="utf-8" src="{{URL::to_asset('mobile/')}}plugins/af.passwordBox.js"></script>          
        <script type="text/javascript" charset="utf-8" src="{{URL::to_asset('mobile/')}}plugins/af.scroller.js"></script>
        <script type="text/javascript" charset="utf-8" src="{{URL::to_asset('mobile/')}}plugins/af.selectBox.js"></script>
        <script type="text/javascript" charset="utf-8" src="{{URL::to_asset('mobile/')}}plugins/af.touchEvents.js"></script>
        <script type="text/javascript" charset="utf-8" src="{{URL::to_asset('mobile/')}}plugins/af.touchLayer.js"></script>
        <script type="text/javascript" charset="utf-8" src="{{URL::to_asset('mobile/')}}plugins/af.popup.js"></script>

        <script type="text/javascript" charset="utf-8" src="{{URL::to_asset('mobile/')}}ui/appframework.ui.js"></script>
        <!-- <script type="text/javascript" charset="utf-8" src="{{URL::to_asset('mobile/')}}ui/transitions/all.js"></script> -->
        <script type="text/javascript" charset="utf-8" src="{{URL::to_asset('mobile/')}}ui/transitions/fade.js"></script>
        <script type="text/javascript" charset="utf-8" src="{{URL::to_asset('mobile/')}}ui/transitions/flip.js"></script>
        <script type="text/javascript" charset="utf-8" src="{{URL::to_asset('mobile/')}}ui/transitions/pop.js"></script>
        <script type="text/javascript" charset="utf-8" src="{{URL::to_asset('mobile/')}}ui/transitions/slide.js"></script>
        <script type="text/javascript" charset="utf-8" src="{{URL::to_asset('mobile/')}}ui/transitions/slideDown.js"></script>
        <script type="text/javascript" charset="utf-8" src="{{URL::to_asset('mobile/')}}ui/transitions/slideUp.js"></script>
        <script type="text/javascript" charset="utf-8" src="{{URL::to_asset('mobile/')}}plugins/af.slidemenu.js"></script>
       	<style>
       	.profileStatNUM {font-size:15px!important;

       	}
       	.avatarRound {
       		border-radius:49px;
       		border:1px solid #fff;
       		width:42px;
       		float:left;

       	}
       	.leader-mobile {
       		width:100%;
       		height:146px;
       		padding-left:20px;
       		padding-bottom:20px;
       		padding-top:12px;
       		padding-right:20px;
       		border-bottom:1px solid #3e3e3e;
       		border-top:1px solid #3e3e3e;
       	}
       	</style>
      
        <script type="text/javascript">
            /* This function runs once the page is loaded, but intel.xdk is not yet active */
            //$.ui.animateHeaders=false;
             var search=document.location.search.toLowerCase().replace("?","");
             //if(!search)
            //$.ui.useOSThemes=true;
            if(search.length>0) //Android fix has too many buggy issues on iOS - can't preview with $.os.android
            {

             /*  $.ui.useOSThemes=true;
                if(search=="win8")
                    $.os.ie=true;
                $.ui.ready(function(){
                    $("#afui").get(0).className=search;
                });*/
            }
            
            var webRoot = "./";
             $.os.android=true;
            //$.ui.autoLaunch = false;
            $.ui.openLinksNewTab = false;
            $.ui.splitview=false;
            

            $(document).ready(function(){
                  // $.ui.launch();

            });
            
            /* This code is used to run as soon as intel.xdk activates */
            var onDeviceReady = function () {
                intel.xdk.device.setRotateOrientation("portrait");
                intel.xdk.device.setAutoRotate(false);
                webRoot = intel.xdk.webRoot + "";
                //hide splash screen
                intel.xdk.device.hideSplashScreen();
                $.ui.blockPageScroll(); //block the page from scrolling at the header/footer
            };
            document.addEventListener("intel.xdk.device.ready", onDeviceReady, false);

            function showHide(obj, objToHide) {
                var el = $("#" + objToHide)[0];

                if (obj.className == "expanded") {
                    obj.className = "collapsed";
                } else {
                    obj.className = "expanded";
                }
                $(el).toggle();

            }


            if($.os.android||$.os.ie||search=="android"){
                $.ui.ready(function(){
                    var $el=$("#afui");
                    $el.addClass("light");
                    $("#toggleAndroidTheme").bind("click",function(e){
                        if($el.hasClass("light"))
                            $el.removeClass("light");
                        else
                            $el.addClass("light");
                    });
                });
            }                        
        </script>

</head>
    <body>
      <div id="notification" class="animated fadeInUp" >

    	</div>
    	<input type="hidden" id="mainURL" value="{{URL::to()}}"/>
        <div id="afui">
            <!-- this is the splashscreen you see. 
            <div id="splashscreen" class='ui-loader heavy'><br/>
                <img class='animated fadeInUp' src='{{URL::to_asset("images/")}}logo-{{$setting->shortcode}}.png' style="margin-left:20px;width:100%;"><br/>
                <img class='animated fadeInUp' src='{{URL::to_asset("mobile/")}}img/loaders/126.gif'>
            </div>-->

            <div id="header">
                <a id='menubadge' onclick='af.ui.toggleSideMenu()' class='menuButton'></a>                 
            </div>

            <div id="content">

                <!-- HOMEPAGE -->
                <div title='Welcome {{Auth::user()->firstname}}' id="main" class="panel" selected="true" data-footer="footerui" data-load="loadedPanel" data-unload="unloadedPanel" data-tab="navbar_home">
                     <?php if(isset($year[$user->id])){
                          $st = $year[$user->id];
                          $app = $st['appointment'];
                      } else {
                          $st = array();
                          $app = array();
                      }
                      if(isset($month[$user->id])){
                          $stmonth = $month[$user->id];
                          $appmonth = $stmonth['appointment']; 
                      } else {
                          $stmonth=array();$appmonth=array();
                      }
                      if(isset($week[$user->id])){
                          $stweek = $week[$user->id];
                          $appweek = $stweek['appointment'];
                      } else {
                          $stweek = array();
                          $appweek=array();
                      }
                      ;?>
                    <div id="profileStrip" style="padding-bottom:40px;">
                    <div class="row-fluid">
                          <div style="width:100%;float:left;">
                            
                            <img title="Click to upload a new avatar" class='smallShadow tooltwo' src='{{$user->avatar_link()}}' style='float:left;width:90px;' data-id="{{$user->id}}" >
                            <div style="float:left;width:50%;margin-left:20px;">
                              <h2 style="color:#1f1f1f;margin-top:0px;margin-left:0px;">{{ucfirst(strtolower($user->firstname))}} <span style="color:#bbb;">{{ucfirst(strtolower($user->lastname))}}</span></h2>
                              <img src='{{URL::to("img/badges/")}}points.png' style='width:45px;margin-bottom:-5px;'>
                              <span class='tooltwo badge badge-inverse'  title='Put On Demos | 1 Point , SOLD Demo | 5 Points'>{{$user->system_points}} Points</span><br/><br/>
                              <img src='{{URL::to("img/badges/")}}bronzecoins.png' style='width:14px;margin-bottom:-5px;'>
                              <span class='tooltwo badge bronzeCoins '  title='For every GROSS unit sold | 1 BRONZE'>{{$user->bronze_points}} </span>
                              <img src='{{URL::to("img/badges/")}}silvercoins.png' style='width:14px;margin-left:0px;margin-bottom:-5px;'>
                              <span class='tooltwo badge silverCoins blackText'  title='For every GROSS sale | 1 SILVER'>{{$user->silver_points}} </span>
                              <img src='{{URL::to("img/badges/")}}goldcoins.png' style='width:14px;margin-left:0px;margin-bottom:-5px;'>
                              <span class='tooltwo badge goldCoins blackText'  title='For every GROSS Super, Mega or Nova System sale | 1 GOLD'>{{$user->gold_points}} </span><br/>
                              
                            </div>
                          </div>

                          <div style="float:left;width:100%;margin-top:20px;">


                            <div class='profileStat'>
                              DEMOS<br/>
                              <div class="profileStatNUM  black">
                              @if(!empty($app['PUTON']))
                                  {{$app['PUTON']}}
                              @else
                              0
                              @endif
                              </div>
                            </div>
                           
                            <div class='profileStat'>
                                SALES<br/>
                                <div class="profileStatNUM  green">
                                    
                                    <span class='stats GROSS'>@if(!empty($st['grosssales'])) {{$st['grosssales']}} @else 0 @endif</span>
                                   
                                </div>
                            </div>
                            <div class='profileStat'>
                                UNITS<br/>
                                <div class="profileStatNUM  blue">
                                    
                                    <span class='stats GROSS'>
                                    @if(!empty($st['totgrossunits'])) {{$st['totgrossunits']}} @else 0 @endif
                                    </span>
                                    
                                   
                                </div>
                            </div>
       
                            <div style='float:left;margin-left:28px;'>
                                <span class='bigCount' style='font-size:44px;'>
                                @if(!empty($app['CLOSE'])) {{number_format($app['CLOSE'],0,'.','')}} @else 0 @endif 
                                <span class='bigCount' style='color:#bbb;'>%</span></span>
                                <br/>Close Percent
                            </div>
                            </div>
                      

                       
                    </div>

                    </div>


                    <div style='height:48px;padding-top:1px;'>
                    	<img class='animated fadeInUp' src='{{URL::to_asset('mobile/')}}images/staff.png' width=110px>
                        <img class='pull-right animated fadeInUp' style='float:right;' src='{{URL::to_asset('mobile/')}}images/specials.png' width=110px>
                    </div>

                    <ul class="list" id="userMenu" >
                    	<li class='largeList' >
                            <a href="#appts" class="viewAppts">
                            	<img class="sideImage" src='{{URL::to_asset('mobile/')}}images/appointment-menu.png'>
                            	&nbsp;<b>Appointment Board</b><br/>
                                <p>&nbsp;View Your Appointments Today</p>
                            	 
                            </a>
                        </li>
                        <li class='largeList' >
                            <a href="#sales">
                                <img class="sideImage" src='{{URL::to_asset('mobile/')}}images/sales-menu.png'>
                                &nbsp;<b>Sales</b><br/>
                                <p>&nbsp;View Your Sale History</p>
                            </a>
                        </li>
                        <li class='largeList' >
                            <a href="#paymentcalc">
                                <img class="sideImage" src='{{URL::to_asset('mobile/')}}images/calculator-menu.png'>
                                &nbsp;<b>Payment Calculator</b><br/>
                                <p>&nbsp;Calculate Monthly Payments</p>
                            </a>
                        </li>
                         <li class='largeList' >
                            <a href="#invoice"  >
                                <img class="sideImage" src='{{URL::to_asset('mobile/')}}images/invoiceside-menu.png'>
                                &nbsp;<b>Invoices</b><br/>
                                <p>&nbsp;View / Create Invoices</p>
                            </a>
                        </li>
                        <li class='largeList' >
                            <a href="#leads"   >
                                <img class="sideImage" src='{{URL::to_asset('mobile/')}}images/mainlead-menu.png'>
                                &nbsp;<b>Leads</b><br/>
                                <p>&nbsp;Enter New Lead / View Leads</p>
                            </a>
                        </li>
                       
                    </ul>
                    <br/><br/>
                    <a href="{{URL::to('users/logout')}}"  style="background:#1f1f1f;color:#fff;padding:18px;width:100%;" class='button logoutButton icon power'>LOGOUT</a>
                </div>
                <!--END HOMEPAGE-->

                <!--ENTER NEW LEAD-->
                 <div title="Enter New Lead" id="newlead" class="panel" data-footer="leadformfooter" >
                  <?php $res = User::where('level','!=',99)->where('user_type','!=','manager')->order_by('firstname')->get();
                  $cities = City::where('status','!=','leadtype')->order_by('cityname','ASC')->get();?>
                  <form id="newleadform" name="newleadform" method="POST" action="">
                    <br/>
                  Phone Number : 
                  <input type="text" name="newlead-custnum" maxlength=12 id="newlead-custnum" onkeyup="addDashes(this)" />
                  Lead Type :<br/>
                   <select id="newlead-leadtype" class="leadtypeSelect" name="newlead-leadtype" style="z-index:50000">
                    <option value=""></option>
                    @if($setting->lead_door==1)<option value="door" selected="selected"> Door</option>@endif
                    @if($setting->lead_referral==1)<option value="referral" >Referral</option>@endif
                    @if($setting->lead_personal==1)<option value="personal" >Personal Lead</option>@endif
                    @if($setting->lead_doorknock==1)<option value="doorknock" >Door Knock</option>@endif
                  </select>
                  <br/><br/>
                  <div class="animated fadeInUp" id="newleadReferral" style="display:none;">
                  Referral Lead (type to search database for lead) :
                  <input type="text" id="referralSearch"/> 
                  <br/>
                  <div id="leadResultBox">
                  <div class="leadResults"></div>
                  </div>
                  <input type="hidden" name="newlead-referralleadHidden" id="newlead-referralHidden"/>
                  </div>
                  Customer Name : 
                    <input type="text" name="newlead-name" id="newlead-name" /> 
                  Spouse Name : (if applicable) 
                    <input type="text" name="newlead-spouse" id="newlead-spouse"  />  
                  
                  Address :
                  <input type="text" class="addressDropdown new-leadAddress" name="newlead-address" id="newlead-address" />
                  
                  City : <br/>
                  <select name="newlead-city" id="newlead-city">
                      <option value=""></option>
                        @foreach($cities as $val)
                              <option value="{{$val->cityname}}">{{$val->cityname}}</option>
                        @endforeach
                  </select>  <br/><br/>

                  Occupation : 
                   <input type="text" name="newlead-job" id="newlead-job" />

                  Marital Status : <br/>
                  <select name="newlead-marital" id="newlead-marital">
                    <option value="single">Single</option>
                    <option value="married">Married</option>
                    <option value="commonlaw">Commonlaw</option>
                    <option value="widowed">Widowed</option>
                  </select>
                  <br/><br/>
                  <div style="width:18%;float:left;">
                  <input type="radio"  id="ft" name="newlead-fullpart[]" class="jq-ui-forms" value="FT" /> <label for="ft">F/T</label>
                  <input type="radio"  id="pt" name="newlead-fullpart[]"  class="jq-ui-forms" value="PT"/> <label for="pt">P/T</label>
                  <input type="radio"  id="retired" name="newlead-fullpart[]"  class="jq-ui-forms" value="R"/> <label for="retired">Retired</label><br/><br/><br/>
                  </div>
                  <div style="width:18%;float:left;margin-left:14px;">
                  <input type="radio"  id="rent" name="newlead-rentown[]" class="jq-ui-forms" value="rent"/> <label for="rent">Rent</label>
                  <input type="radio"  id="own" name="newlead-rentown[]" class="jq-ui-forms" value="own" /> <label for="own">Own</label><br/><br/><br/>
                  </div>
                  <div style="width:20%;float:left;margin-left:14px;margin-bottom:30px;">
                  <input type="checkbox"  id="asthma"  name="newlead-asthma" class="jq-ui-forms"  /> <label for="asthma">Asthma</label>
                  <input type="checkbox"  id="pets"  name="newlead-pets" class="jq-ui-forms" /> <label for="pets">Pets</label>
                  <input type="checkbox"  id="smoke"  name="newlead-smoke" class="jq-ui-forms"  /> <label for="conf">Smoke</label><br><br>
                  </div>
                  <br/>
                  <input type="hidden" id="newlead-status" name="newlead-status" value="NEW" />
                  </form>
                  <br/><br/><br/><br/><br/>
                  </div>


                <!---INVOICING -->
                <div id="invoice" title="Invoices" class="panel" data-footer="footerui"  >
                    <ul class="list" id="userMenu" >
                        <li class='largeList' >
                            <a href="#newinvoice" class="enterNewInvoice">
                                <img class="sideImage" src='{{URL::to_asset('mobile/')}}images/addlead-menu.png'>
                                &nbsp;<b>Create New Invoice</b><br/>
                                <p>&nbsp;Attach Sales To New Invoice</p>
                            </a>
                        </li>
                        <li class='largeList' >
                            <a href="#invoicelist" class="viewInvoiceList">
                                <img class="sideImage" src='{{URL::to_asset('mobile/')}}images/invoice-menu.png'>
                                &nbsp;<b>View Invoices</b><br/>
                                <p>&nbsp;View All Your Invoices</p>
                            </a>
                        </li>
                    </ul>
                </div>
                <!--END NEW LEAD-->

                <div title="Leads" class="panel" id="leads" data-footer="footerui">
                     <ul class="list" id="userMenu" >
                        <li class='largeList' >
                            <a href="#newlead" class="newLeadEntry">
                                <img class="sideImage" src='{{URL::to_asset('mobile/')}}images/addlead-menu.png'>
                                &nbsp;<b>Enter New Lead</b><br/>
                                <p>&nbsp;Referral / Personal / Door Knock</p>
                            </a>
                        </li>
                        <li class='largeList' >
                            <a href="#leadlist" class="viewLeadList">
                                <img class="sideImage" src='{{URL::to_asset('mobile/')}}images/lead-menu.png'>
                                &nbsp;<b>Your Leads</b><br/>
                                <p>&nbsp;View All Your Leads</p>
                            </a>
                        </li>
                    </ul>
                </div>


                <!--APPOINTMENT BOARD-->
                <div title='Appointments' class="panel" id="appts"  data-footer="footerui" data-header="appthead" >
	  				<ul class="list " id="appointmentList">

			  		</ul>
			    </div>
                <!--END APPOINTMENTS-->
                <div id="apptMap" title="MAP" class="panel" data-footer="mapfooter" data-header="maphead">
                    <div id="appMap2" style="width:110%;margin-left:-15px;height:700px;"></div>
                </div>

                <div class="panel" data-title="PROCESS DEMO" id="modalProcess" >
                    <br/>
                    <h4>Select the Result of This Appointment</h4><br/>
                      <button class="soldButton button green" style="width:100%;height:50px;">SOLD</button><br/>
                      <div id="soldSelect" style="display:none;">
                      
                      <form id="processAppForm">
                      <select name='systemtype' id="process-system" >
                      <option value='defender'>Defender</option>
                      <option value='2defenders'>2 Defender</option>
                      <option value='3defenders'>3 Defender</option>
                      <option value='majestic'>Majestic</option>
                      <option value='2maj'>2 Majestics</option>
                      <option value='3maj'>3 Majestics</option>
                      <option value='system'>System</option>
                      <option value='supersystem'>Super System</option>
                      <option value='megasystem'>Mega System</option>
                      <option value='novasystem'>Nova System</option>
                      <option value='supernova'>Super Nova</option>
                      <option value='2system'>2 Systems</option>

                      </select>
                      <label for="payout">Price Sold : </label>
                      <input type="text" name="price" class="salepayout" id="process-price" />
                      </form>
                      <br><br/>
                      
                      <button class="processButton button" data-id='' data-type='SOLD' style="width:100%;height:50px;border:2px solid #1f1f1f;" >SUBMIT</button><br/><br/><br/>
                      </div>
                      <button class="processButton button red" data-id='' data-type='DNS' style="width:100%;height:50px;">DNS</button><br/>
                      <button class="processButton button orange" data-id='' data-type='INC' style="width:100%;height:50px;">INC</button><br/>
                      
                </div>
                <!-- LEAD LIST-->
                <div title="Your Leads" id="leadlist" class="panel" data-footer="footerui">
                    <ul class="list" id="theLeads">
                   
                    </ul>
                  </div> 
                <!--END LEADS-->
                <div id="invoicelist" title="Invoices" class="panel" data-header="invoiceheader" data-footer="footerui"  >
                    <ul class="list" id="invoiceList" >
                       
                    </ul>
                </div>
                <div id="viewinvoice" title="Invoice #" class="panel" data-footer="footerui"  >
                    
                </div>


                <!--SALES PAGE-->
                 <div title="Your Deals" class="panel" id="sales" data-footer="footerui">
                 	 <div style="background:url('../images/subtle_clouds.jpg'); background-size:120%;width:120%;margin-left:-20px; border-bottom:2px solid #1f1f1f;">
                        <center>
                            <img style='width:35%;margin-left:-20px;max-width:800px;' src='{{URL::to_asset("images/")}}sales.png'>
                        <div style='margin-left:-30px;font-size:12px;'>
                            
                      		Total Gross Sales :  
                                @if(isset($year[Auth::user()->id])) 
                                    @if($year[Auth::user()->id]["grosssales"]!=0) <b>{{$year[Auth::user()->id]["grosssales"]}}</b> @endif
                                @else 
                                    <b>0</b>
                                @endif 
                            &nbsp;&nbsp;&nbsp;
                             Total Net Sales :
                                 @if(isset($year[Auth::user()->id])) 
                                    @if($year[Auth::user()->id]["netsales"]!=0) <b>{{$year[Auth::user()->id]["netsales"]}}</b><br/> @endif
                                @else 
                                    <b>0</b>
                                @endif
                           
                            Total Gross Units :  
                                @if(isset($year[Auth::user()->id])) 
                                    @if($year[Auth::user()->id]["totgrossunits"]!=0) <b>{{$year[Auth::user()->id]["totgrossunits"]}}</b> @endif
                                @else 
                                    <b>0</b>
                                @endif 
                            &nbsp;&nbsp;&nbsp;
                             Total Net Units : 
                                 @if(isset($year[Auth::user()->id])) 
                                    @if($year[Auth::user()->id]["totnetunits"]!=0) <b>{{$year[Auth::user()->id]["totnetunits"]}}</b><br/> @endif
                                @else 
                                    <b>0</b>
                                @endif
                          <br/>
                		</div>
                		</center>
                    </div>
                 		<ul class="list" id="userMenu" >
                    	<li class='largeList' >
                            <a href="#yoursales" class="viewSales" data-type="pending">
                            	<img class="sideImage" src='{{URL::to_asset('mobile/')}}images/pending-menu.png'>
                            	&nbsp;<b>Pending / Unpaid Deals</b><br/>
                                <p>&nbsp;View All Your Pending Deals</p>
                            </a>
                        </li>
                        <li class='largeList' style="border-bottom:2px solid #1f1f1f;" >
                            <a href="#yoursales" class="viewSales" data-type="complete">
                                <img class="sideImage" src='{{URL::to_asset('mobile/')}}images/paid-menu.png'>
                                &nbsp;<b>Paid / Complete Deals</b><br/>
                                <p>&nbsp;View Your Completed Sale History</p>
                            </a>
                        </li>
                        <li class='largeList' style="border-bottom:2px solid #1f1f1f;" >
                            <a href="#yoursales" class="viewSales" data-type="cancelled">
                                <img class="sideImage" src='{{URL::to_asset('mobile/')}}images/cancel-menu.png'>
                                &nbsp;<b>Cancels / Turndown</b><br/>
                                <p>&nbsp;View Your Lost Deals</p>
                            </a>
                        </li>

                    </ul>
  
                    <p>Your Estimated Earnings</p>
                    <p style='font-size:9px;margin-top:-10px;'> (Based on wether Sales report is filled out by Managers)</p>
                    <h5>Sales (Year): ${{$earnings['year'][0]->price}} &nbsp;&nbsp;&nbsp;Comm: ${{$earnings['year'][0]->payout}}</h5>
                     <h5>Sales (Month): ${{$earnings['month'][0]->price}}&nbsp;&nbsp;&nbsp;Comm: ${{$earnings['month'][0]->payout}}</h5>
                    <h5>Sales (Week): ${{$earnings['week'][0]->price}}&nbsp;&nbsp;&nbsp;Comm: ${{$earnings['week'][0]->payout}}</h5>
                 </div>
                <!--END SALES-->
                
                <!--SALES HISTORY-->
                <div title="Sales" id="yoursales" class="panel" data-footer="footerdates">
                	<ul class="list " id="saleList">

                	</ul>
                </div>
                <!--END SALES HISTORY-->	

               
                <div id="saleformpanel" class="panel" data-footer="saleformfooter">
                </div>
                <div id="invoiceformpanel" class="panel" data-footer="invoiceformfooter">
                </div>

                <!--CALCULATOR-->

                <div title="Calculator" id="paymentcalc" class="panel" data-footer="footerui">
                 
                
                  <form id="paymentcalulator" name="paymentcalulator" method="POST" action="">
                    <br/>
                  Sticker Price :
                  <input type="text" name="sale_price" id="sale_price" placeholder="Enter retail price of system"/>
                  Sub Total (Customer Price)
                  <input type="text" name="given_price" id="given_price" placeholder="Enter the price you are selling it to the customer"/>
                  Down Payment : 
                  <input type="text" name="down_pay" id="down_pay" value="0"/>
                  <br/>
                  
                  Interest Rate :<br/>
                  <select name="interest" id="interest">
                      @if($setting->shortcode=="putk")
                      <option value="table1">9.95%</option>
                      @endif
                      <option value="table2">19.95%</option>
                      <option value="table3" selected='selected'>29.90%</options>
                  </select><br/>
                   

                 Deferral : <br/>
                        <select name="def" id="def">
                            <option value="0">0 Months</option>
                            <option value="3">3 Months</options>
                            <option value="6">6 Months</options>
                        </select>
                        <br/>
                  Term : <br/>

                        <select name="term" id="term">
                            <option value="6">6 Months</option>
                            <option value="12">12 Months</options>
                            <option value="18">18 Months</options>
                            <option value="24">24 Months</options>
                            <option value="30">30 Months</options>
                            <option value="36">36 Months</options>
                            <option value="42" >42 Months</options>
                            <option value="48" selected='selected'>48 Months</options>  
                            <option value="54">54 Months</options>
                            <option value="60" >60 Months</options>       
                        </select><br/>
                        Tax Rate :<br/> 
                        <select name="tax_rate" id="tax_rate" >
                            <option value="13" data-rates='13%'>Default (13%)</option>
                            <option value="5" data-rates='5% GST'>Alberta (5% GST)</option>
                            <option value="12" data-rates='7% PST & 5% GST' @if($setting->shortcode=='aas' || $setting->shortcode=='healthtek') selected='selected' @endif>BC (7% PST + 5% GST)</option>
                            <option value="13" data-rates='8% PST & 5% GST' @if($setting->shortcode=='whs') selected='selected' @endif>Manitoba (8% PST + 5% GST)</option>
                            <option value="13" data-rates='13% HST' @if($setting->shortcode=='avaeros') selected='selected' @endif >New Brunswick / Newfoundland (13% HST)</option>
                            <option value="5" data-rates='5% GST'>Nunavut & Northwest Ter. (5% GST)</option>
                            <option value="13" data-rates='13% HST' @if($setting->shortcode=='putk' || $setting->shortcode=='be') selected='selected' @endif>Ontario (13% HST )</option>
                            <option value="14.975" data-rates='9.975% QST & 5% GST'>Quebec (9.975% QST + 5% GST )</option>
                            <option value="14" data-rates='14% HST'>Prince Edward Island (14% HST )</option>
                            <option value="10" data-rates='5% PST & 5% GST' @if($setting->shortcode=='quality' || $setting->shortcode=='quality2') selected='selected' @endif>Saskatchewan (5% PST + 5% GST)</option>
                            <option value="4.75" data-rates='4.75%' @if($setting->shortcode=='triad') selected='selected' @endif>North Carolina, US (4.75%)</option>
                            <option value="5" data-rates='5%' @if($setting->shortcode=='foxv' || $setting->shortcode=='ribmount') selected='selected' @endif>Wisconsin, US (5%)</option>
                            <option value="5" data-rates='5%' @if($setting->shortcode=='cyclo') selected='selected' @endif>Iowa, US (5%)</option>
                            <option value="7" data-rates='7%' @if($setting->shortcode=='mdhealth') selected='selected' @endif>Indiana, US (7%)</option>
                          </select>
                  </form>
                  
                  <a  href="#monthlypay" data-transition="flip" >
                       <button class='button calculate' style='background:#1f1f1f;color:#fff;width:100%;'>CALCULATE</button></a>

                  <div id="tables" style="display:none;">
                    @if(Setting::find(1)->shortcode=="putk")
                    <div class="span3">
                        <h3>9.95%</h3>
                        <table class="table table-condensed table-bordered">
                            <thead>
                                <tr><th>TERM</th><th>Deferral 0</th><th>Deferral 3</th><th>Deferral 3</th></tr>
                            </thead>
                            <tbody id="table1">
                                <tr class='term-6'><td>6</td><td class='def-0'>0.171537</td><td class='def-3'>0.175804</td><td class='def-6'>0.180071</td></tr>
                                <tr class='term-12'><td>12</td><td class='def-0'>0.087893</td><td class='def-3'>0.090079</td><td class='def-6'>0.092265</td></tr>
                                <tr class='term-18'><td>18</td><td class='def-0'>0.060034</td><td class='def-3'>0.061527</td><td class='def-6'>0.063021</td></tr>
                                <tr class='term-24'><td>24</td><td class='def-0'>0.046122</td><td class='def-3'>0.047269</td><td class='def-6'>0.048416</td></tr>
                                <tr class='term-30'><td>30</td><td class='def-0'>0.037788</td><td class='def-3'>0.038728</td><td class='def-6'>0.039668</td></tr>
                                <tr class='term-36'><td>36</td><td class='def-0'>0.032244</td><td class='def-3'>0.033046</td><td class='def-6'>0.033848</td></tr>
                                <tr class='term-42'><td>42</td><td class='def-0'>0.028293</td><td class='def-3'>0.028997</td><td class='def-6'>0.029701</td></tr>
                                <tr class='term-48'><td>48</td><td class='def-0'>0.025339</td><td class='def-3'>0.025969</td><td class='def-6'>0.026599</td></tr>
                                <tr class='term-54'><td>54</td><td class='def-0'>0.023048</td><td class='def-3'>0.023621</td><td class='def-6'>0.024195</td></tr>
                                <tr class='term-60'><td>60</td><td class='def-0'>0.021222</td><td class='def-3'>0.02175</td><td class='def-6'>0.022278</td></tr>
                            </tbody>
                        </table>
                    </div>
                    @endif
                    <div class="span3">
                        <h3>19.95%</h3>
                        <table class="table table-condensed table-bordered">
                            <thead>
                                <tr><th>TERM</th><th>Deferral 0</th><th>Deferral 3</th><th>Deferral 3</th></tr>
                            </thead>
                            <tbody id="table2">
                                <tr class='term-6'><td>6</td><td class='def-0'>0.176498</td><td class='def-3'>0.185301</td><td class='def-6'>0.194103</td></tr>
                                <tr class='term-12'><td>12</td><td class='def-0'>0.092611</td><td class='def-3'>0.097230</td><td class='def-6'>0.101848</td></tr>
                                <tr class='term-18'><td>18</td><td class='def-0'>0.064739</td><td class='def-3'>0.067968</td><td class='def-6'>0.071197</td></tr>
                                <tr class='term-24'><td>24</td><td class='def-0'>0.050871</td><td class='def-3'>0.053409</td><td class='def-6'>0.055946</td></tr>
                                <tr class='term-30'><td>30</td><td class='def-0'>0.042605</td><td class='def-3'>0.044730</td><td class='def-6'>0.046854</td></tr>
                                <tr class='term-36'><td>36</td><td class='def-0'>0.037138</td><td class='def-3'>0.038990</td><td class='def-6'>0.040843</td></tr>
                                <tr class='term-42'><td>42</td><td class='def-0'>0.033271</td><td class='def-3'>0.034931</td><td class='def-6'>0.036590</td></tr>
                                <tr class='term-48'><td>48</td><td class='def-0'>0.030404</td><td class='def-3'>0.031920</td><td class='def-6'>0.033437</td></tr>
                                <tr class='term-54'><td>54</td><td class='def-0'>0.028202</td><td class='def-3'>0.029609</td><td class='def-6'>0.031015</td></tr>
                                <tr class='term-60'><td>60</td><td class='def-0'>0.026466</td><td class='def-3'>0.027786</td><td class='def-6'>0.029106</td></tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="span3">
                        <h3>29.90%</h3>
                        <table class="table table-condensed table-bordered">
                            <thead>
                                <tr><th>TERM</th><th>Deferral 0</th><th>Deferral 3</th><th>Deferral 3</th></tr>
                            </thead>
                            <tbody id="table3">
                                <tr class='term-6'><td>6</td><td class='def-0'>0.181499</td><td class='def-3'>0.195066</td><td class='def-6'>0.208634</td></tr>
                                <tr class='term-12'><td>12</td><td class='def-0'>0.097438</td><td class='def-3'>0.104721</td><td class='def-6'>0.112005</td></tr>
                                <tr class='term-18'><td>18</td><td class='def-0'>0.069620</td><td class='def-3'>0.074824</td><td class='def-6'>0.080028</td></tr>
                                <tr class='term-24'><td>24</td><td class='def-0'>0.055861</td><td class='def-3'>0.060037</td><td class='def-6'>0.064213</td></tr>
                                <tr class='term-30'><td>30</td><td class='def-0'>0.047725</td><td class='def-3'>0.051292</td><td class='def-6'>0.054859</td></tr>
                                <tr class='term-36'><td>36</td><td class='def-0'>0.042397</td><td class='def-3'>0.045566</td><td class='def-6'>0.048735</td></tr>
                                <tr class='term-42'><td>42</td><td class='def-0'>0.038672</td><td class='def-3'>0.041563</td><td class='def-6'>0.044454</td></tr>
                                <tr class='term-48'><td>48</td><td class='def-0'>0.035948</td><td class='def-3'>0.038635</td><td class='def-6'>0.041322</td></tr>
                                <tr class='term-54'><td>54</td><td class='def-0'>0.033888</td><td class='def-3'>0.036421</td><td class='def-6'>0.038954</td></tr>
                                <tr class='term-60'><td>60</td><td class='def-0'>0.032292</td><td class='def-3'>0.034706</td><td class='def-6'>0.037120</td></tr>
                            </tbody>
                        </table>
                    </div>
                  </div>
                  </div>
                   <?php if($setting->shortcode=="mdhealth" || $setting->shortcode=="mdhealth2" || $setting->shortcode=="foxvalley" || $setting->shortcode=="cyclo"  || $setting->shortcode=="triad" || $setting->shortcode=="ribmount" ){
                                $fee="";
                               } else {
                                $fee = "49.95";
                                } ;?>
                               
                  <div title="Monthly Payment" id="monthlypay" class="panel">
                        <div class='button grey' style="width:100%;"><span class="monthlypayment" style="font-size:24px;">$0.00</span> </div><br><br/>
                       <ul class="list inset" style="margin-top:-15px;" >
                        <li>Discount   <span style="float:right"> $<span id="discount">0</span></span></li> 
                        <li>Tax Rate <span style="float:right"> <span class='rates' style='font-size:11px;'></span> $<span id="hst" style="font-weight:bolder;">0</span></span></li>
                        <li>Cash Price <span style="float:right"> $<span id="cash_price">0</span></span></li>
                        <li>Reg Fees <span style="float:right"> $ <input type="text" id="fees" value="{{$fee}}" style='width:38%;'></span></li>
                        <li>Total Financed<span style="float:right">  $<span id="TAF" style="font-weight:bolder;">0</span></span></li>
                        <li>TCB<span style="float:right">  $<span id="TCB">0</span></span></li>
                        <li>TAP<span style="float:right">  $<span id="TAP">0</span></span></li>
                       </ul>
                  </div>
                <!--END CALCULATOR-->

            
        
            <footer id='footerui'>
                <a href="#main" id='navbar_home' class='icon home' data-transition="up">Home</a>
                <a href="#appts" class="icon calendar viewAppts " data-transition="up">APPTS</a>
                <a href="#sales" id='navbar_ui' class="icon graph" data-transition="up">SALES</a>
                <a href="#paymentcalc" id='navbar_plugins' class="icon pencil" data-transition="up">CALC</a>
            </footer>

            <footer id='invoiceformfooter'>
                <a href="#" style="color:green;" id='navbar_check' data-id='' class='saveInvoice icon check'>SAVE</a>
                <a href="#" style="color:red;" class="icon close cancelButton" data-transition="up">CANCEL</a>
            </footer>
            <footer id='saleformfooter'>
                <a href="#" style="color:green;" id='navbar_check' data-id='' class='saveSale icon check'>SAVE</a>
                <a href="#" style="color:red;" class="icon close cancelButton" data-transition="up">CANCEL</a>
            </footer>
            <footer id='leadformfooter'>
                <a href="#" style="color:green;" id='navbar_check' data-id='' class='saveNewLead icon check'>SAVE</a>
                <a href="#" style="color:black;" class="icon close clearButton" >CLEAR</a>
                <a href="#" style="color:red;" class="icon close cancelButton" data-transition="up">CANCEL</a>
            </footer>

            <footer id='mapfooter'>
                <center>
                    <button id="footer-in" class='button footerCheckIn markTIME markIN' data-id='' style='padding:8px;width:40%;border:1px solid #aaa;background:#A3E0FF;'>CHECK IN</button>
                    <button id="footer-out" class='button footerCheckIn markTIME markOUT' data-id='' style='padding:8px;width:40%;border:1px solid #aaa;margin-left:10px;background:#FF6666;'>CHECK OUT</button>
                </center>
            </footer>

            <footer id="footerdates">
              <div class="dateBox" >
                <span style="float:left;">From :</span> 
                <input  class="fromdate" id="fromdate" name="startdate" type="text" value="{{date('Y-m-01',strtotime('-8 months'))}}"  />
              </div>
              <div class="dateBox">
                  <span style="float:left">To :</span> 
                  <input class="todate" id="todate" name="enddate" type="text" value="{{date('Y-m-d', strtotime('last day of this month'))}}"  />
              </div>
              <button class="filterDates button " >GO</button>
            </footer>

            <header id="testheader">
                <a id="backButton" onclick="$.ui.goBack()" class='button'>Back</a>
                    <h1>Custom Header</h1>
                <a class="button icon settings" style="float:right">Button</a>
            </header>
            <header id="invoiceheader">
                    <a id="backButton" onclick="$.ui.loadContent('#invoices')" class='button'>Back</a>
                    <h1>Invoices</h1>
            </header>
            <header id="appthead">
                    <a id="backButton" onclick="$.ui.loadContent('#home')" class='button'>Back</a>
                    <h1>Your Demos</h1>
            </header>
            <header id="maphead">
                    <a id="backButton" onclick="$.ui.loadContent('#invoices')" class='button'>Back</a>
                    <h1>MAP</h1>
            </header>


            <!--STATSBOX  ON SIDE--> 
            <nav class="darkBackdrop">
                <center>
                <br/>
                <h4>YOU ARE LEVEL <br/>
                    <strong style="color:green;">{{Auth::user()->level}}</strong>&nbsp;&nbsp;SPECIALIST</h4>

                <img class="animated fadeInUp" src="{{URL::to_asset('images/')}}level{{Auth::user()->level}}.png" style="width:35%">
                    <br/>
                  @if(!empty($month))
                    @foreach($month as $m)
                      @if(isset($m["name"]))
                        @if($m["name"]!="totals")
                          <?php $u=User::find($m["rep_id"]);?>
                          @if($u->id==Auth::user()->id)
                                <b>UNITS </b>(YEAR) :<br/> 
                                @if(isset($year[$u->id])) 
                                    Gross <b>{{$year[$u->id]["totgrossunits"]}}</b> Net <b>{{$year[$u->id]["totnetunits"]}}</b> 
                                @endif
                                <br/><br/>
                                <b>UNITS </b>(MONTH) :<br/> Gross <b>{{$m["totgrossunits"]}}</b> Net <b>{{$m["totnetunits"]}}</b> <br/>
                                <br/><b>UNITS </b>(WEEK) : <br/>
                                @if(isset($week[$u->id])) 
                                 Gross <b>{{$week[$u->id]["totgrossunits"]}}</b> Net <b>{{$week[$u->id]["totnetunits"]}}</b>
                                @else
                                 Gross <b>0</b> Net <b>0</b>
                                @endif
                            

                               <br/><br/>
                               <h2 style='color:yellow'>THIS MONTH </h2>
                               <b>
                                &nbsp;&nbsp;<span style='color:green;'>SOLD : @if($m["grosssales"]!=0) {{$m["grosssales"]}} @endif </span>
                                &nbsp;&nbsp;
                                <span style='color:red;'>DNS : @if($m["appointment"]["DNS"]!=0) {{$m["appointment"]["DNS"]}} @endif </span> 
                                &nbsp;&nbsp;
                                <span class='color:#FF9900;'> INC : @if($m["appointment"]["INC"]!=0) {{$m["appointment"]["INC"]}} @endif </span>
                                </b>

                                <div style="margin-top:10px;">
                                  <img class='animated fadeInUp' src='{{URL::to_asset("images/pureop-maj.png")}}' style='width:45px;'>
                                  <img class='animated fadeInUp' src='{{URL::to_asset("images/pureop-def.png")}}' style='width:45px;'><br/>
                                </div>
                                <div style='margin-top:5px;'>
                                  <span class='statBox' style='color:yellow;background:black;'>  @if($m["grossmd"]["majestic"]!=0) {{$m["grossmd"]["majestic"]}} @endif </span>
                                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                  <span class='statBox' style='background:black;color:yellow;'>   @if($m["grossmd"]["defender"]!=0) {{$m["grossmd"]["defender"]}} @endif </span>
                                </div>
                               <br/>
                               
                          @endif
                        @endif
                      @endif
                    @endforeach
                  @endif
                  <br/>
                  <div class="button viewCommission" style='border:1px solid #bbb; color:#000;padding:5px;font-size:10px;'>
                    VIEW COMMISSION LEVELS
                  </div>
                  <div class='commission' style='display:none;'>
                    <table class='table table-condensed' style="color:#000;">
                      <tr><th>System</th><th>Payout</th></tr>
                      <?php $pureop = DB::query("SELECT * FROM pureop WHERE id = '".Auth::user()->level."'");
                        if(empty($pureop)){
                          $pureop = DB::query("SELECT * FROM pureop WHERE id = '1'");
                        };?>
                      <tr>
                        <td>Defender</td>
                        <td>${{$pureop[0]->defendercom}}</td>
                      </tr>
                      <tr>
                        <td>Majestic</td>
                        <td>${{$pureop[0]->majesticcom}}</td>
                      </tr>
                      <tr>
                        <td>System</td>
                        <td>${{$pureop[0]->systemcom}}</td>
                      </tr>
                      <tr>
                        <td>Super System</td>
                        <td>${{$pureop[0]->supercom}}</td>
                      </tr>
                    </table>
                  </div>
                  <br/>
                  
                  <a href="#sales" class="button viewSales" style='border:1px solid #bbb;color:#000;padding:5px;font-size:10px;'>
                        VIEW YOUR SALES
                    </a>
                    <br/>
                    
                <hr>
                <p style="padding:10px;">Leader Boards <button class='refreshRegional'>Refresh</button></p>
                	<a class="button switchLeaders" style='border:1px solid #bbb;color:#000;padding:5px;font-size:10px;'>SALES</a>
                    <a class="button switchLeaders" style='border:1px solid #bbb;color:#000;padding:5px;font-size:10px;'>UNITS</a>
                    <a class="button switchLeaders" style='border:1px solid #bbb;color:#000;padding:5px;font-size:10px;'>CLOSE</a>
                		

			
                <?php $disp=0;$mega=0; $userdef=0;$nova=0;$twomaj=0; $threemaj=0; $twodef=0; $threedef=0; $super=0;$sys=0; $maj=0;$def=0;$dns=0;$inc=0;$cxl=0;$rb=0;$rbof=0;$rbtf=0;$close=0;$complete=0;$sales=0;$total=0;$totnits=0;$totsales=0;?>
                </center>
                @include('mobile.modules.leaderboard')
                 
            </nav>
            <!--APPOINTMENTS ON SIDE-->
            <aside class="animated fadeInUp " style='padding-left:10px;'>
                <h3 style='margin-top:10px;'>Your Next Demo</h3>
                <div class="yourAppts" style="margin-top:-10px;"></div>
                <div id="appMap" style="border:1px solid #1f1f1f; height:180px;width:201px;margin-left:-11px;"></div>
                <br/><br/>
                <h3>Todays Demos</h3> 
                <div class="todaysDems"></div>
            </aside>


        </div>
    </body>
</html>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&libraries=places&language=en-AU"></script>
<script>
    var options = {componentRestrictions: {country: "ca"}};

        var autocomplete = new google.maps.places.Autocomplete($(".addressDropdown")[0], options);
        google.maps.event.addListener(autocomplete, 'place_changed', function() {

        var place = autocomplete.getPlace();

      address = '';
      if (place.address_components) {
       address += place.address_components[0].short_name;
       address += " "+place.address_components[1].short_name;
       address += " ,"+" "+place.address_components[2].short_name;
      }
});
</script>





<script>
$(document).ready(function(){
    var MainURL = $('#mainURL').val();
   
    // Leader board implementation



    // End Leaderboard
    // System Logout
    $('.logoutButton').click(function(e){
        e.preventDefault();
        var href = $(this).attr('href');
        window.location = href;
    });

    //Calculator calculate
    $('.calculate').click(function(e){
        calculate();
    });

    // Toggle Commission on stats
    $(document).on('click','.viewCommission',function(){
      $('.commission').toggle();
    });

    // Filterdates
    // TODO - add page changer to load based on which page youre on
    $('.filterDates').click(function(){
        getSales("pending");
    });


    //------------HELPFUL FUNCTIONS---------
    //---------------------------------------

         // Popup notification
         function notifyMe(msg,time){
            $('#notification').html(msg).show();
            setTimeout(function(){
                $('#notification').hide();
            },time);
         }
         // End Notification
        
         // Payment Calculator
        function calculate(){
            var tax = $('#tax_rate').val();
            var tax_rate = parseFloat(parseInt(tax))/100;
            var sale_price = $('#sale_price').val();
            var given_price = $('#given_price').val();
            var down_pay = $('#down_pay').val();
            var fees = $('#fees').val();
            var discount = (parseFloat(sale_price)-parseFloat(given_price)).toFixed(2);
            $('#discount').html(discount);
            var hst =parseFloat(given_price)*tax_rate;
            $('#hst').html(hst.toFixed(2));
            $('#cash_price').html((parseFloat(given_price)+parseFloat(hst)).toFixed(2));
            var amount = ((parseFloat(given_price)+parseFloat(hst)+parseFloat(fees))-parseFloat(down_pay));
            $('#TAF').html(amount.toFixed(2));
            var interest = $('#interest').val();
            var def = $('#def').val();
            var term = $('#term').val();
            var calcval = $('#'+interest).find('.term-'+term).find('.def-'+def).html();
            var monthly = parseFloat(amount)*calcval;
            var tap = parseFloat(monthly)*parseInt(term);
            var tcb = tap-amount;
            $('#TCB').html(tcb.toFixed(2));
            $('#TAP').html(tap.toFixed(2));
            $('.monthlypayment').hide().removeClass('fadeInUp').addClass('fadeInUp').show().html("$"+parseFloat(monthly).toFixed(2)+" / Mn");
        }
    //------------END HELPFUL FUNCTIONS------
    //---------------------------------------




    //----------------AJAX LOADED PAGES----------------
    //---------------------------------------------------
        function getAppts(date){
         $.ui.updateContentDiv("#appointmentList","<center><img src='../img/loaders/misc/66.gif' style='margin-top:39px;'></center>");
          if(date!=null){
            $.get("../mobile/appointments",function(data){
              $.ui.updateContentDiv("#appointmentList",data);
            });
          } else {
            $.get("../mobile/appointments",function(data){
              $.ui.updateContentDiv("#appointmentList",data);
            });
          }
        }
    
        function getSales(type){
            var from = $('#fromdate').val();
            var to = $('#todate').val();
            $.ui.updateContentDiv("#saleList","<center><img src='../img/loaders/misc/66.gif' style='margin-top:39px;'></center>");
            $.post("../mobile/sales",{saletype:type,start:from ,end:to},function(data){
                $.ui.updateContentDiv("#saleList",data);
            });
        }

        function getStats(){
            $.ui.updateContentDiv("#stats","<center><img src='../img/loaders/misc/66.gif' style='margin-top:39px;'></center>");
            $.get("../mobile/salestats",function(data){
                $.ui.updateContentDiv("#stats",data);
            });
        }

        function getLeads(){
            $.ui.updateContentDiv("#theLeads","<center><img src='../img/loaders/misc/66.gif' style='margin-top:39px;'></center>");
            $.getJSON('../users/leadlist',function(data){
            var html="";
            $.each(data,function(i,val){
                html+="<li id='leadrow-"+val.id+"' class='' style='border-bottom:1px solid #1f1f1f;'>";
                if(val.status=="INACTIVE"){html+="<button class='deleteLead button red' data-id='"+val.id+"' style='color:#fff;padding:6px;float:right;background:#800000'>DELETE</button>";} 
                    html+="<b style='color:black;'>"+val.entry_date+"</b><br/>";
                    html+="<p><span style='font-size:12px;color:#000'><b>"+val.address+"</b></span><br/>";
                    html+="<b>"+val.cust_num+"</b><br/>";
                    html+="<span class='smallText'>Smoke : "+val.smoke+" | Asthma : "+val.pets+" | Pets : "+val.pets+"<br/>";
                    html+="Job : "+val.fullpart+"&nbsp;&nbsp; Rent/Own : "+val.rentown+"&nbsp;&nbsp;&nbsp;";
                    if(val.referral_id!=0){
                      html+="<br/>Referral Lead :<br/> "+val.referral_id;
                    }
                    html+="</span> </p>";
                if(val.status!='INACTIVE'){
                    html+="<span id=' class='status' style='float:right;margin-top:-20px;'>Status : "+val.status+"</span></li>";
                }
            });
            if(html.length<=0){
                    html+="<center><br/><br/><span style='font-size:18px'>You Have No Leads Entered</span></center>";
            }
            $.ui.updateContentDiv("#theLeads",html);
            });
        }

        function getInvoices(){
            var from = $('#fromdate').val();
            var to = $('#todate').val();
            $.ui.updateContentDiv("#invoiceList","<center><img src='../img/loaders/misc/66.gif' style='margin-top:39px;'></center>");
            $.post("../mobile/invoices",{start:from ,end:to},function(data){
                $.ui.updateContentDiv("#invoiceList",data);
            });
        }

        function getMap(id){
            var url = './getappmap/'+id;
            $.getJSON(url,function(data){
                var ico="";
                $.each(data, function(key, data) {
                        latLng = new google.maps.LatLng(data.lat, data.lng); 
                        if(data.status=="APP"){
                            ico = '/img/pure-op.png';
                            if(data.result=="DNS")  {
                                ico = '/img/app-dns.png';
                            }
                        } else if(data.result=="SOLD")  {
                            ico = '/img/app-sale.png';
                        } else if(data.result=="DNS")  {
                            ico = '/img/app-dns.png';
                        } else if(data.status=="NI")  {
                            ico = '/img/app-dns.png';
                        } else if(data.status=="CXL")  {
                            ico = '/img/app-cxl.png';
                        } else {
                            ico = '/img/door-regy.png';
                        }
                    });
                var mapOptions = {
                        center: latLng,
                        zoom: 15,
                        disableDefaultUI: true,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    };
                var map = new google.maps.Map(document.getElementById("appMap2"),
                    mapOptions);
                    marker = new google.maps.Marker({
                                position: latLng,
                                title: data.title,
                                icon: ico
                    });
                    marker.setMap(map);
                    map.panBy(0,85);
            });
        }
    //----------------AJAX LOADED PAGES----------------
    //---------------------------------------------------


    
    //--------------LEAD PAGE STUFF--------------
    //-------------------------------------------

        $('.viewLeadList').click(function(){
          getLeads();
        });
    
        $('.newLeadEntry').click(function(e){
          $('#newleadform')[0].reset();
        });
        $('.clearButton').click(function(e){
          e.preventDefault();
          $('#newleadform')[0].reset();
        });
        $('.leadtypeSelect').change(function(){
          var options = $(this).val();
          if(options=="referral"){
            $('#newleadReferral').show();
          } else {
            $('#newleadReferral').hide();
          }
        });

        $('#referralSearch').keyup(function(){

          var val = $(this).val();
          $.getJSON("{{URL::to('lead/ajaxleadsearch')}}",{searchterm:val},function(data){
            var html="";
            if(data){
              $.each(data,function(i,val){
                html+="<li class='getLeadFromSearch' data-id='"+val.id+"' data-name='"+val.cust_name+"' >#"+val.id+" | "+val.cust_name+" | "+val.cust_num+" | "+val.address+" | "+val.status+"</li>";
              });
              $('#leadResultBox').show();
              $('.leadResults').html("<img src='{{URL::to_asset('img/loaders/misc/66.gif')}}'>");
              if(html==""){
                html = "<h4>No Leads Match Search....</h4>"
                $('.leadResults').html("").append(html);
              } else {
                $('.leadResults').html("").append("<h5>Click to choose who referred this lead/entry</h5>"+html);
              }
              
            }
          });
          
        });

        $(document).on('click','.getLeadFromSearch',function(){
          var id = $(this).attr('data-id');
          var name = $(this).attr('data-name');
          $('#newlead-referralHidden').val(id);
          $('#referralSearch').val(name+" - Lead # "+id);
          $('#leadResultBox').hide();
        });


        $(document).on('click','.deleteLead',function(){
            var id = $(this).attr('data-id');
            var url="{{URL::to('lead/delete/')}}"+id;
            var l = confirm("Are you sure you want to delete this lead?");
            if(l){
            $.getJSON(url,function(data){
              $('#leadrow-'+id).hide(600);
            });}
        });

        $('.saveNewLead').click(function(e){
          e.preventDefault();
          saveNewLead();
        });

        //NEW LEAD SAVE
        function saveNewLead(){
          var form = $('#newleadform').serialize();
          $.getJSON("{{URL::to('lead/addnewlead')}}",form,function(data){
            if(data=="alreadyexists"){
              $.ui.popup("Number already exists in system!!");
            } else if(data=="nocity"){
              $.ui.popup("Please Enter a City for this lead!");
            } else if(data=="noname"){
              $.ui.popup("Please Enter the Customers Name!");
            } else if(data=="nonum"){
              $.ui.popup("Please Enter a Valid phone number for this lead!");
            } else if(data=="cannotbook") {
              $.ui.popup("You cannot book a lead this far in advance!","BOOKING TOO FAR AHEAD");
            } else {
              $('#newleadform')[0].reset();
              $('.saveForm').removeClass('saveNewLead').removeClass('saveSale').removeClass('saveInvoice');
              getLeads();
              $.ui.loadContent('#leadlist');
              notifyMe("Lead Saved Succesfully",2500);
            }
          });
        };
    //--------------END LEAD PAGE STUFF----------
    //-------------------------------------------




    //-------------APPOINTMENT PAGE STUFF---------
    //--------------------------------------------
        $('.viewAppts').click(function(){
          getAppts();
        });

        $(document).on('click','.viewAppt',function(){
            var id = $(this).attr('data-id');
            var appid = $(this).attr('data-appid');
            var chkin = $(this).attr('data-chkin');
            var chkout = $(this).attr('data-chkout');
            $('.footerCheckIn').attr('data-id',appid);
            if(chkin==0){
                $('#footer-in').hide();
            } else {
                $('#footer-in').show();
            }
            if(chkout==0){
                 $('#footer-out').hide();
            } else {
                $('#footer-out').show();
            }
                   
            $.ui.loadContent('#apptMap');
            
            $.ui.updateContentDiv("#appMap2","<center><img src='../img/loaders/misc/66.gif' style='margin-top:39px;'></center>");
            getMap(id);
            
        });
    
        // Mark in and out times
        $('.processButton').click(function(){

            $('#soldSelect').hide();
            var id = $(this).attr('data-id');
            var thestatus = $(this).attr('data-type');
            var check = "out";
            if(id.length<=0){
                $.ui.popup("Cannot Process. Contact Administrator");
            } else {
                if(thestatus=="SOLD"){
                    var thesystem = $('#process-system').val();
                    var theprice = $('#process-price').val();
                    var theDat = {appid:id,type:check,status:thestatus,systemtype:thesystem,price:theprice,payout:0,request:true};
                    $.getJSON('../sales/registersale',theDat,function(data){
                        console.log(data);
                        if(data=="success"){
                            getAppts();
                            notifyMe(msg,2500);
                            $.ui.loadContent('#appts');
                        } else {
                            $.ui.popup("Submit Failed, please try again");
                        }
                    });
                } else {
                    var theDat = {appid:id,type:check,status:thestatus};
                    $.getJSON('../mobile/marktime',theDat,function(data){
                    console.log(data);
                    if(data=="success"){
                        getAppts();
                        notifyMe(msg,2500);
                        $.ui.loadContent('#appts');
                    } else {
                        $.ui.popup("Submit Failed, please try again");
                    }
                    });
                }
            }
        });

        $('.soldButton').click(function(){
           
             $('#soldSelect').toggle();
        });

        $(document).on('click','.markTIME',function(){
            var id = $(this).attr('data-id');
            if($(this).hasClass('markIN')){
                type="in";
                msg = "Checked Into Demo";
            } else {
                type = "out";
                msg = "Checked Out of Demo";
            }

            if(type=="out"){
                $('.processButton').attr('data-id',id);
                $.ui.loadContent('#modalProcess');

            } else {
                $.getJSON('../mobile/marktime',{appid:id,type:type},function(data){
                    if(data=="success"){
                        getAppts();
                        notifyMe(msg,2500);
                        $.ui.loadContent('#appts');
                    } else {
                        $.ui.popup("Submit Failed, please try again");
                    }
                });
            }


            

        });
    //---------END APPOINTMENT PAGE STUFF---------
    //--------------------------------------------




    //---------FORM FOOTER STUFF------------------
    //--------------------------------------------
        $('.fromdate').change(function(){
          $('.fromdate').val($('.fromdate').val());
        });
    
        $('.todate').change(function(){
          $('.todate').val($('.todate').val());
        });
    
        $('.cancelButton').click(function(e){
            e.preventDefault();
            $.ui.goBack();
        });
        
        // FORM FOOTER STUFF
        $('.saveInvoice').click(function(e){
          e.preventDefault();
          saveInvoice();
        });

        $('.saveSale').click(function(e){
          e.preventDefault();
          saveSale();
        });

        
    //---------END FORM FOOTER STUFF--------------
    //--------------------------------------------



    //---------SALE PAGE STUFF------------------
    //--------------------------------------------
    $('.viewSales').click(function(){
      var type=$(this).data('type');
      getSales(type);
    });
    // View SALE
    $(document).on('click','.viewSale',function(){
      var id = $(this).attr('data-id');
      $.ui.loadContent('#saleformpanel');
      $.ui.setTitle("Sale #"+id);
      $.ui.updateContentDiv("#saleformpanel","<center><img src='../img/loaders/misc/66.gif' style='margin-top:39px;'></center>");
      $.get("../mobile/getsale/"+id,function(data){
        $.ui.updateContentDiv('#saleformpanel',data);
      });
    });
    //Change PAYMENT image when select is chosen
    $(document).on('change','#methodofpay',function(){
      var type = $(this).val().toLowerCase();
      if(type=="lendcare" || type=="crelogix" || type=="jp"){
        $('#interest').show();
      } else {
        $('#interest').hide();
      }
      if(type==""){
        type="none";
      } 
      $('#paymentMethod').attr('src',MainURL+'/images/payment-'+type+'.png');
    });
    //Change SYSTEM image when select is chosen
    $(document).on('change','#typeofsystem',function(){
      var type = $(this).val().toLowerCase()
      $('#systemType').attr('src',MainURL+'/images/pureop-small-'+type+'.png');
    });
    // SAVE SALE
    function saveSale(){
        var form = $('#saleForm').serialize();
        var id = $('#sale_id').val();
        $.getJSON("{{URL::to('mobile/savesale')}}",form,function(data){
            if(data=="failed"){
                $.ui.popup("Save failed! Contact System Administrator with Sale ID!");
            } else if(data=="nosale"){
                $.ui.popup("No Sale Found! Contact System Administrator!");
            } else if(data=="success"){
                $.ui.updateContentDiv("#saleList","<center><img src='../img/loaders/misc/66.gif' style='margin-top:39px;'></center>");
                $.ui.loadContent('#yoursales');
                getSales("pending");
                notifyMe("Sale #"+id+" Updated!",2000);
            }
        });
    }
    //---------END SALE PAGE STUFF----------------
    //--------------------------------------------


    //---------INVOICE PAGE STUFF----------------
    //--------------------------------------------

        //Delete invoice from system
        $(document).on('click','.viewInvoice',function(){
            var id= $(this).attr('data-id');
            $.ui.loadContent('#viewinvoice');
            $.get("../mobile/viewinvoice/"+id,function(data){
                $.ui.updateContentDiv('#viewinvoice',data);   
            });

        });
        //Delete invoice from system
        $(document).on('click','.deleteInvoice',function(){
            var id= $(this).attr('data-id');
            $.getJSON("../sales/deleteinv/"+id,function(data){
                if(data=="success"){
                    $('.invoice-'+id).hide(200);
                    notifyMe("Invoice Removed",2500);
                } else {
                    $.ui.popup("Cannot find Invoice to Delete! Contact Administrator");
                }
            });
        });
        //Remove sale from invoice
        $(document).on('click','.removeDeal',function(){
            var id= $(this).attr('data-id');
           var t = confirm("Are you sure you want to remove this sale from invoice");
           if(t){
             $.getJSON("../sales/removedeal",{thesale:id},function(data){
                if(data!="failed"){
                    $('.salePic-'+id).hide(200);
                    notifyMe("Sale #"+id+" Removed",2500);
                } else {
                    $.ui.popup("Cannot find Sale to Remove! Contact Administrator");
                }
            });
           }
        });
    
        $(document).on('click','.addDeals',function(){
          var id= $(this).attr('data-id');
          $.ui.loadContent('#invoiceformpanel');
          $.ui.setTitle("Update Invoice");
          $.ui.updateContentDiv("#invoiceformpanel","<center><img src='../img/loaders/misc/66.gif' style='margin-top:39px;'></center>");
          $.get("../mobile/invoice/"+id,function(data){
            $.ui.updateContentDiv('#invoiceformpanel',data);
          });
        });

        $('.enterNewInvoice').click(function(){
          $.ui.loadContent('#invoiceformpanel');
          $.ui.setTitle("Create Invoice");
          $.ui.updateContentDiv("#invoiceformpanel","<center><img src='../img/loaders/misc/66.gif' style='margin-top:39px;'></center>");
          $.get("../mobile/invoice",function(data){
            $.ui.updateContentDiv('#invoiceformpanel',data);
          });
        });
    
        $('.viewInvoiceList').click(function(){
            getInvoices();
        });

        //SAVE INVOICE
        function saveInvoice(){
            var form = $('#invoiceForm').serialize();
            var deals = $('.selectdeal');
            var count=0;
            $.each(deals,function(i,val){
                var t = $('#selectdeal-'+i).val();
               if(t.length>0){
                count++;
               }
            });
            if(count==0){
                $.ui.popup("You need to add at least one deal to invoice!");
                return false;
            }
            $.getJSON("{{URL::to('mobile/saveinvoice')}}",form,function(data){
                if(data=="failed"){
                    $.ui.popup("Save failed! Contact System Administrator with Sale ID!");
                } else if(data=="noinvoice"){
                    $.ui.popup("No Invoice Found! Contact System Administrator!");
                } else if(data=="success"){
                    $.ui.updateContentDiv("#invoiceList","<center><img src='../img/loaders/misc/66.gif' style='margin-top:39px;'></center>");
                    $.ui.loadContent('#invoicelist');
                    getInvoices();
                    notifyMe("Invoice Saved!",2000);
                }
            });
        }
    //---------END INVOCIE PAGE STUFF-------------
    //--------------------------------------------


    getAppts();
   
});
</script>
