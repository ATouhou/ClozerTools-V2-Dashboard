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
</script>
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
        <title>{{$setting->title}}</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
        <meta http-equiv="Content-type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0">
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <link rel="stylesheet" type="text/css" href="{{URL::to_asset('css')}}/icons.css" />  

      <link rel="stylesheet" type="text/css" href="{{URL::to_asset('css/src')}}/main.css"  />
      <link rel="stylesheet" type="text/css" href="{{URL::to_asset('css/src')}}/appframework.css"  />
      <link rel="stylesheet" type="text/css" href="{{URL::to_asset('css/src')}}/lists.css"  />
      <link rel="stylesheet" type="text/css" href="{{URL::to_asset('css/src')}}/forms.css"  />
      <link rel="stylesheet" type="text/css" href="{{URL::to_asset('css/src')}}/buttons.css"  />        
      <link rel="stylesheet" type="text/css" href="{{URL::to_asset('css/src')}}/badges.css"  />        
      <link rel="stylesheet" type="text/css" href="{{URL::to_asset('css/src')}}/grid.css"  />

      <!--<link rel="stylesheet" type="text/css" href="{{URL::to_asset('css/src')}}/android.css"  />
      <link rel="stylesheet" type="text/css" href="{{URL::to_asset('css/src')}}/win8.css"  />
      <link rel="stylesheet" type="text/css" href="{{URL::to_asset('css/src')}}/bb.css"  />
      <link rel="stylesheet" type="text/css" href="{{URL::to_asset('css/src')}}/ios.css"  />-->
      <link rel="stylesheet" type="text/css" href="{{URL::to_asset('css/src')}}/ios7.css"  />
      <link rel="stylesheet" type="text/css" href="{{URL::to_asset('css/src')}}/tizen.css"  />
      <link rel="stylesheet" type="text/css" href="{{URL::to_asset('plugins')}}/css/af.actionsheet.css"  />
      <link rel="stylesheet" type="text/css" href="{{URL::to_asset('plugins')}}/css/af.popup.css"  />
      <link rel="stylesheet" type="text/css" href="{{URL::to_asset('plugins')}}/css/af.scroller.css"  />
      <link rel="stylesheet" type="text/css" href="{{URL::to_asset('plugins')}}/css/af.selectBox.css"  /> 
      <link rel="stylesheet" type="text/css" href="{{URL::to_asset('css/custom-mobile.css')}}" /> 
      <link rel="stylesheet" type="text/css" href="{{URL::to_asset('css')}}/animate.css"  />      
        
     
        <script type="text/javascript" charset="utf-8" src="{{URL::to_asset('')}}/appframework.js"></script>
        <script type="text/javascript" charset="utf-8" src="{{URL::to_asset('appframework.js')}}"></script>
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
                script.src = "{{URL::to_asset('plugins')}}/af.desktopBrowsers.js";
                var tag = $("head").append(script);
                //$.os.desktop=true;
            }
          //  $.feat.nativeTouchScroll=true;
        </script>        
        <script type="text/javascript" charset="utf-8" src="{{URL::to_asset('plugins')}}/af.actionsheet.js"></script>
        <script type="text/javascript" charset="utf-8" src="{{URL::to_asset('plugins')}}/af.css3animate.js"></script>
        <script type="text/javascript" charset="utf-8" src="{{URL::to_asset('plugins')}}/af.passwordBox.js"></script>          
        <script type="text/javascript" charset="utf-8" src="{{URL::to_asset('plugins')}}/af.scroller.js"></script>
        <script type="text/javascript" charset="utf-8" src="{{URL::to_asset('plugins')}}/af.selectBox.js"></script>
        <script type="text/javascript" charset="utf-8" src="{{URL::to_asset('plugins')}}/af.touchEvents.js"></script>
        <script type="text/javascript" charset="utf-8" src="{{URL::to_asset('plugins')}}/af.touchLayer.js"></script>
        <script type="text/javascript" charset="utf-8" src="{{URL::to_asset('plugins')}}/af.popup.js"></script>

        <script type="text/javascript" charset="utf-8" src="{{URL::to_asset('ui')}}/appframework.ui.js"></script>
        <!-- <script type="text/javascript" charset="utf-8" src="{{URL::to_asset('ui')}}/transitions/all.js"></script> -->
        <script type="text/javascript" charset="utf-8" src="{{URL::to_asset('ui')}}/transitions/fade.js"></script>
        <script type="text/javascript" charset="utf-8" src="{{URL::to_asset('ui')}}/transitions/flip.js"></script>
        <script type="text/javascript" charset="utf-8" src="{{URL::to_asset('ui')}}/transitions/pop.js"></script>
        <script type="text/javascript" charset="utf-8" src="{{URL::to_asset('ui')}}/transitions/slide.js"></script>
        <script type="text/javascript" charset="utf-8" src="{{URL::to_asset('ui')}}/transitions/slideDown.js"></script>
        <script type="text/javascript" charset="utf-8" src="{{URL::to_asset('ui')}}/transitions/slideUp.js"></script>
        <!--<script type="text/javascript" charset="utf-8" src="{{URL::to_asset('plugins')}}/af.slidemenu.js"></script>-->
       
      
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
             $.os.android=false;
            //$.ui.autoLaunch = false;
            $.ui.openLinksNewTab = false;
            $.ui.splitview=false;
            

            $(document).ready(function(){
                   $.ui.launch();
                   $.ui.disableSideMenu();

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
                

                    //$("#main .list").append("<li><a id='toggleAndroidTheme'>Toggle Theme Color</a></li>");
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
      <div id="afui" >
            <!-- this is the splashscreen you see. -->
            <div id="splashscreen" class='ui-loader heavy'>
              <img class='animated fadeInUp' src='{{URL::to_asset("images/")}}logo-{{$setting->shortcode}}.png'>
              <br/><br/><br/><span class='ui-icon ui-icon-loading spin'></span>
            </div>
            

            <div id="content">

                	<div title='{{str_replace(" - Rep Dashboard","",$setting->title)}}' id="main" class="panel" selected="true" data-load="loadedPanel" data-unload="unloadedPanel" >
                    	<h2 >Welcome {{ucfirst(Auth::user()->firstname)}}</h2>
             
                      <h5>Sales (Year): ${{$earnings['year'][0]->price}} &nbsp;&nbsp;&nbsp;Comm: ${{$earnings['year'][0]->payout}}</h5>
                      <h5>Sales (Month): ${{$earnings['month'][0]->price}}&nbsp;&nbsp;&nbsp;Comm: ${{$earnings['month'][0]->payout}}</h5>
                      <h5>Sales (Week): ${{$earnings['week'][0]->price}}&nbsp;&nbsp;&nbsp;Comm: ${{$earnings['week'][0]->payout}}</h5>
                      <br/>
                      <ul class="list inset">
                          <li class='red'>
                              <a href="#demos" id='applink' class='getAppts icon calendar big '>APPOINTMENT BOARD </a>
                          </li>
                          <li>
                              <a href="#unpaidsales" id="unpaidlink" class='icon basket big' >UNPAID SALES</a>
                          </li>
                          <li>
                              <a href="#paidsales" id="paidlink" class='icon tag big' >PAID SALES</a>
                          </li>
                        </ul><br/>
                    	<ul class="list inset">
                          <li class='red'>
                              <a href="#newlead" id='enternew' class='icon new big'>ENTER NEW LEAD </a>
                          </li>
                          <li class='red'>
                              <a href="#leadlist" id='viewleads' class='viewLeadList icon user big'>ALL YOUR ENTRIES</a>
                          </li>
                        </ul>
                      <br/>
                      <ul class="list inset">
                          <li class='red'>
                              <a href="#paymentcalc" id='payment' class='icon pencil big'>PAYMENT CALCULATOR</a>
                          </li>
                      </ul>
                      <br/>
                      
                        <ul class="list inset">
                          <li style="background:#800000;color:#fff;">
                              <a href="{{URL::to('users/logout')}}" onclick='preventDefault();' class='icon power'>LOGOUT</a>
                          </li>
                    	</ul>
                    
                    	<div class="dashboardstats">
                    	<br/><br/><br/>
                    	@if(!empty($stats))
                    	<h4 style="margin-left:10px;">APPOINTMENT SUMMARY</h4>
                    		<div class="largestats">
                    			<div class="bignum2 BOOK">{{$stats[0]->total}}</div><br/>
                    			APP
                    		</div>
                    		<div class="largestats">
                    			<div class="bignum2 PUTON">{{$stats[0]->dispatched}}</div><br/>
                    			DISP
                    		</div>
                    		<div class="largestats">
                    			<div class="bignum2 PUTON">{{$stats[0]->puton}}</div><br/>
                    			PUTON
                    		</div>
                    		<div class="largestats">
                    			<div class="bignum2 SOLD">{{$stats[0]->sold}}</div><br/>
                    			SOLD
                    		</div>
                    		<div class="largestats">
                    			<div class="bignum2 DNS2">{{$stats[0]->dns}}</div><br/>
                    			DNS
                    		</div>
                    	@endif
                      </div> 
               	</div>
               
                	<div title="Demos" id="demos" class="panel"  data-header="apptheader">
                    <h2>Appointments for {{date('D M-d')}}</h2>
                      <button class="button viewappts" data-id="{{Auth::user()->id}}">VIEW ONLY YOUR APPOINTMENTS</button><br/><br/>
                      <ul class="list" id="apptList">
                      @foreach($appts as $v)
                        <li class="{{$v->status}} appList rep-{{$v->rep_id}}" style="border-bottom:2px solid #1f1f1f;">
                        <a href="#appmap" class="appts rep-{{$v->rep_id}}" data-apptid="{{$v->id}}" data-rep="{{$v->rep_id}}" data-id="{{Auth::user()->id}}">
                          <span class="label label-time">{{date('h:i a', strtotime($v->app_time))}}</span>
                          <span class="label label-name">{{$v->lead->cust_name}}</span>
                          <span class="label label-number">{{$v->lead->cust_num}}</span>
                          <br/><br/>
                          <span style="font-size:12px;color:#000"><b>{{$v->lead->address}}</b></span><br/><br/>
                          Dispatched To : <span id="rep-{{$v->id}}" class="label label-dispatch">{{$v->rep_name}}</span>
                          <span id="status-{{$v->id}}" class="status">{{$v->status}}</span>
                          </a>
                        </li>
                      @endforeach
                      </ul>
                  
                	</div>
                 
                  <div title="APPOINTMENT MAP" id="appmap" class="panel" data-header="appmaphead">
                    <div id="processButtons" style="background:white;display:none;padding:8px;float:left;width:100%;border-bottom:1px solid #1f1f1f">
                      <h4>Process Result of this Appointment</h4>
     
                      <button class="process button green">SOLD</button>&nbsp;&nbsp;
                      <button class="process button red"> DNS</button>&nbsp;&nbsp;
                      <button class="process button orange">INC</button><br/>
                      <div id="soldSelect" style="display:none;">
                        <form id="saleForm" >
                      <select name='systemtype'>
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
                      </select>
                      <label for="payout">Payout : </label>
                      <input type="text" name="payout" class="salepayout" id="payout" />
                      <label for="payout">Price : </label>
                      <input type="text" name="price" class="salepayout" id="price" />
                      <input type="hidden" id="appid" name="appid" value=""/>
                      <input type="hidden" name="request" id="request" value="json"/>
                      <br><br/>
                      </form>
                      <button class="button green saveSale" style="width:100%;">SAVE SALE</button>
                      </div>
                    </div>
                    <div id="map" style="height:880px;width:120%;margin-left:-10px;margin-top:0px;"></div>
                  </div> 
  
                  <div title="Unpaid Sales" id="unpaidsales" class="panel" data-header="unpaidhead" >	
                    <ul class="list">
               		    @foreach($unpaid as $v)
                      <?php $docs = $v->docs;?>
                          <li class="{{$v->status}}" style="border-bottom:2px solid #1f1f1f;">
                            <span class="label label-time" style="font-size:10px;">{{date('M d', strtotime($v->date))}}</span>
                            <span class="label label-name" style="font-size:12px;margin-left:5px;">{{$v->lead->cust_name}}</span>
                            <span class="label label-number" style="font-size:12px;margin-left:5px;">{{ucfirst($v->typeofsale)}}</span><br/><br/>
                            {{$v->lead->address}}
                            <br/><br/>
                            <span id="status-{{$v->id}}" class="label label-payout" >Payout : ${{$v->payout}}</span>
                            <span id="status-{{$v->id}}" class="label label-price" >Price : ${{$v->price}}</span><br/><br/>
                            @if(empty($docs))
                            <button class='button blue uploadDocs' data-id='{{$v->id}}' style='padding:4px;'>UPLOAD DOCS</button>
                            @endif
                          </li>
                       @endforeach 
                    </ul>
                	</div>

                	<div title="Paid Sales" id="paidsales" class="panel" data-header="paidhead" >	
                    <ul class="list">
               		    @foreach($paid as $v)
                          <li class="{{$v->status}}" style="border-bottom:2px solid #1f1f1f;">
                            <span class="label label-time" style="font-size:10px;">{{date('M d', strtotime($v->date))}}</span>
                            <span class="label label-name" style="font-size:12px;margin-left:5px;">{{$v->lead->cust_name}}</span>
                            <span class="label label-number" style="font-size:12px;margin-left:5px;">{{ucfirst($v->typeofsale)}}</span><br/><br/>
                            {{$v->lead->address}}
                            <br/><br/>
                            <span id="status-{{$v->id}}" class="label label-payout" >Payout : ${{$v->payout}}</span>
                            <span id="status-{{$v->id}}" class="label label-price" >Price : ${{$v->price}}</span>
                          </li>
                       @endforeach 
                    </ul>
                	</div>
                 
                  <div id="viewsale" class="panel">
                  <br/>
                  Customer : 
                  <form id="submitpayform" name="submitpayform" method="POST" action="">
                    <input class="saleitem" data-id="" type="text" name="salename" id="cust_name" value=""/>
                  
                  Enter Your Payout : 
                    <input class="saleitem"  data-id=""    type="text" name="payout" id="payout" value=""/>
                    
                  Price : 
                    <input class="saleitem"  data-id=""  type="text" name="price" id="price" value=""/><br/><br/><hr><br/>
                    
                     Type of Sale : <br/>
                      <select class="saleitem" data-id=""  id="typeofsale" name="systemtype" class="span12">
                        <option value='defender'>DEFENDER</option>
                        <option value='majestic'>MAJESTIC</option>
                        <option value='system'>SYSTEM</option>
                        <option value='supersystem'>SUPER SYSTEM</option>
                        <option value='megasystem'>MEGA SYSTEM</option>
                      </select><br/><br/>
                      Defender #1
                      <select class="saleitem" data-id=""  id="defone" name="defone" class="span12">
                      
                      </select>
                      Defender #2
                      <select data-id=""  id="deftwo" name="deftwo" class="span12">
                      
                      </select>
                      Majestic
                      <select class="saleitem" data-id=""  id="maj" name="maj" class="span12">
                    
                      </select>
                      Attachment
                      <select class="saleitem" data-id=""  id="att" name="att" class="span12">
                      
                      </select><br/><br/><hr>

                      <br>
                      Method of Payment
                        <input type="text" class="saleitem" data-id=""  id="payment" name="methodofpay" class="span12" value="">
                        <br/>

                     Deferral : 
                    	 <select class="saleitem" data-id=""  id="deferal" name="deferal" class="span12">
                        <option value=''></option>
                        <option value='NA'>NA</option>
                        <option value='30day'>Net 30</option>
                        <option value='3month'>3 Month</option>
                        <option value='6month'>6 Month</option>
                        </select><br/>
                        <input type="checkbox" value='1' id="net" data-id="" class="salecheck jq-ui-forms" /> <label for="net">NET</label>
                        <input type="checkbox" value='1' id="finance"  data-id="" class="salecheck jq-ui-forms" /> <label for="finance">FINANCE</label>
                        <input type="checkbox" value='1' id="app" data-id="" class="salecheck jq-ui-forms" /> <label for="app">APP</label>
                        <input type="checkbox" value='1' id="tdpay" data-id="" class="salecheck jq-ui-forms" /> <label for="tdpay">TDPAY</label>
                        <input type="checkbox" value='1' id="conf" data-id="" class="salecheck jq-ui-forms" /> <label for="conf">CONF</label>
                        <input type="checkbox" value='1' id="funded" data-id="" class="salecheck jq-ui-forms" /> <label for="funded">FUNDED</label>
                      
                  </form><br/><br/>
                  <a href=''><button class="button green submitsale" style='padding:20px;font-size:20px;'>SAVE</button></a>
                 
                  </div>

                <div title="Enter New Lead" id="newlead" class="panel" data-header="newleadhead">
                  <?php $res = User::where('level','!=',99)->where('user_type','!=','manager')->order_by('firstname')->get();
                  $cities = City::where('status','!=','leadtype')->order_by('cityname','ASC')->get();?>
                
                  <form id="newleadform" name="newleadform" method="POST" action="">
                    <br/>
                  Phone Number : 
                  <input type="text" name="newlead-custnum" maxlength=12 id="newlead-custnum" onkeyup="addDashes(this)" />
                  Lead Type : 
                   <select id="newlead-leadtype" name="newlead-leadtype" style="z-index:50000">
                    <option value=""></option>
                    @if($setting->lead_door==1)<option value="door" selected="selected"> Door</option>@endif
                    @if($setting->lead_referral==1)<option value="referral" >Referral</option>@endif
                    @if($setting->lead_personal==1)<option value="personal" >Personal Lead</option>@endif
                    @if($setting->lead_doorknock==1)<option value="doorknock" >Door Knock</option>@endif
                  </select>
                  <br/><br/>

                  Customer Name : 
                    <input type="text" name="newlead-name" id="newlead-name" /> 
                  Spouse Name : (if applicable) 
                    <input type="text" name="newlead-spouse" id="newlead-spouse"  />  
                  
                  Address :
                  <input type="text" class="addressDropdown new-leadAddress" name="newlead-address" id="newlead-address" />
                  
                  City : 
                  <select name="newlead-city" id="newlead-city">
                      <option value=""></option>
                        @foreach($cities as $val)
                              <option value="{{$val->cityname}}">{{$val->cityname}}</option>
                        @endforeach
                  </select>  <br/><br/>

                  Occupation : 
                   <input type="text" name="newlead-job" id="newlead-job" />

                  Marital Status : 
                  <select name="newlead-marital" id="newlead-marital">
                    <option value="single">Single</option>
                    <option value="married">Married</option>
                    <option value="commonlaw">Commonlaw</option>
                    <option value="widowed">Widowed</option>
                  </select>
                  <br/><br/>
                  <div style="width:18%;float:left;">
                  <input type="checkbox"  id="ft" name="newlead-fullpart[]" class="jq-ui-forms" value="FT" /> <label for="ft">F/T</label>
                  <input type="checkbox"  id="pt" name="newlead-fullpart[]"  class="jq-ui-forms" value="PT"/> <label for="pt">P/T</label><br/><br/><br/>
                  </div>
                  <div style="width:18%;float:left;">
                  <input type="checkbox"  id="rent" name="newlead-rentown[]" class="jq-ui-forms" value="rent"/> <label for="rent">Rent</label>
                  <input type="checkbox"  id="own" name="newlead-rentown[]" class="jq-ui-forms" value="own" /> <label for="own">Own</label><br/><br/><br/>
                  </div>
                  <div style="width:18%;float:left;">
                  <input type="checkbox"  id="asthma"  name="newlead-asthma" class="jq-ui-forms"  /> <label for="asthma">Asthma</label>
                  <input type="checkbox"  id="pets"  name="newlead-pets" class="jq-ui-forms" /> <label for="pets">Pets</label>
                  <input type="checkbox"  id="smoke"  name="newlead-smoke" class="jq-ui-forms"  /> <label for="conf">Smoke</label>
                  </div>
                  <br/>
                  <input type="hidden" id="newlead-status" name="newlead-status" value="NEW" />
                  </form>
                  <br/><br/>
                    <button class="button green submitNewLead" style='width:100%;padding:15px;margin-top:25px;font-size:18px;'>SAVE LEAD</button>
                  </div>

                <div title="Payment Calculator" id="paymentcalc" class="panel" data-header="paymenthead">
                 
                
                  <form id="paymentcalulator" name="paymentcalulator" method="POST" action="">
                    <br/><br/>
                  Sticker Price :
                  <input type="text" name="sale_price" id="sale_price" placeholder="Enter retail price of system"/>
                  Sub Total (Customer Price)
                  <input type="text" name="given_price" id="given_price" placeholder="Enter the price you are selling it to the customer"/>
                  Down Payment : 
                  <input type="text" name="down_pay" id="down_pay" value="0"/>
                  <br/><br>
                  Interest Rate : 
                  <select name="interest" id="interest">
                      @if($setting->shortcode=="putk")
                      <option value="table1">9.95%</option>
                      @endif
                      <option value="table2">19.95%</option>
                      <option value="table3" selected='selected'>29.90%</options>
                  </select>
                 Deferral : 
                        <select name="def" id="def">
                            <option value="0">0 Months</option>
                            <option value="3">3 Months</options>
                            <option value="6">6 Months</options>
                        </select>
                  Term : 
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
                        </select>
                        Tax Rate : 
                        <select name="tax_rate" id="tax_rate" >
                            <option value="13" data-rates='13%'>Default (13%)</option>
                            <option value="5" data-rates='5% GST'>Alberta (5% GST)</option>
                            <option value="12" data-rates='7% PST & 5% GST'>BC (7% PST + 5% GST)</option>
                            <option value="13" data-rates='8% PST & 5% GST'>Manitoba (8% PST + 5% GST)</option>
                            <option value="13" data-rates='13% HST'>New Brunswick / Newfoundland (13% HST)</option>
                            <option value="5" data-rates='5% GST'>Nunavut & Northwest Ter. (5% GST)</option>
                            <option value="13" data-rates='13% HST'>Ontario (13% HST )</option>
                            <option value="14.975" data-rates='9.975% QST & 5% GST'>Quebec (9.975% QST + 5% GST )</option>
                            <option value="14" data-rates='14% HST'>Prince Edward Island (14% HST )</option>
                            <option value="10" data-rates='5% PST & 5% GST'>Saskatchewan (5% PST + 5% GST)</option>
                            <option value="13" data-rates='8% PST & 5% GST'>Manitoba (8% PST + 5% GST)</option>
                          </select>

                  </form>
                  <a  href="#monthlypay" data-transition="flip" ><button class='button green calculate' style='width:100%;'>CALCULATE</button></a>

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
                  <div title="Monthly Payment" id="monthlypay" class="panel">
                        <div class='button grey' style="width:100%;"><span class="monthlypayment" style="font-size:24px;">$0.00</span> </div><br><br/>
                       <ul class="list inset" >
                        <li>Discount   <span style="float:right"> $<span id="discount">0</span></span></li> 
                        <li>Tax Rate <span style="float:right"> <span class='rates' style='font-size:11px;'></span> $<span id="hst" style="font-weight:bolder;">0</span></span></li>
                        <li>Cash Price <span style="float:right"> $<span id="cash_price">0</span></span></li>
                        <li>Reg Fees <span style="float:right"> $<span id="fees">49.95</span></span></li>
                        <li>Total Financed<span style="float:right">  $<span id="TAF" style="font-weight:bolder;">0</span></span></li>
                        <li>TCB<span style="float:right">  $<span id="TCB">0</span></span></li>
                        <li>TAP<span style="float:right">  $<span id="TAP">0</span></span></li>
                       </ul>
                  </div>

                  <div title="Your Leads" id="leadlist" class="panel" data-header="leadlisthead">
                    <ul class="list" id="theLeads">
                   
                    </ul>
                  </div> 

                  
                
               	<div title="Reports Manager" id="reports" class="panel" style="padding-left:0px">
                    	<ul class="list">
                    		<li class="divider">Sales</li>
                    		<li>
                    		 	<a href="#salesstats" class='icon graph big' onclick="$('.getsales').trigger('click');">Sales Rep Averages</a>
                    		 </li>
                    		<li class="divider"></li>
                    	</ul>
               	</div>

                	<div title="Sales Averages" id="salesstats" class="panel"><br/>
                	 	<h3>Sales Team Averages</h3><br/>
                	 	<button class="btn getsales" data-id="DATE">DAILY</button>
                	 	<button class="btn getsales" data-id="WEEK">WEEKLY</button>
                	 	<button class="btn getsales" data-id="MONTH">MONTHLY</button><br/>
                	 	<br/>
                		<div class="salesaverages">
                		
                		</div>
                	</div>
            </div>
            
            <!--FOOTER-->
            <div id="navbar" style='margin: 0;float:left;'>
                <a href="#newlead" class="icon new">NEW LEAD</a>
                <a href="#paymentcalc" class="icon pencil">CALCULATOR</a>
                <a href="#demos" class='getAppts icon calendar'>DEMOS</a>
            </div>

            <!--headers-->
            <header id="apptheader">
                	<a id="backButton" onclick="$.ui.goBack()" class='button'>Back</a>
                	<h1>Appointment Board</h1>
            </header>
            <header id="paidhead">
                  <a id="backButton" onclick="$.ui.goBack()" class='button'>Back</a>
                  <h1>Your Paid Sales</h1>
            </header>
            <header id="unpaidhead">
                  <a id="backButton" onclick="$.ui.goBack()" class='button'>Back</a>
                  <h1>Your Un-Paid Sales</h1>
            </header>
            <header id="newleadhead">
                  <a id="backButton" onclick="$.ui.goBack()" class='button'>Back</a>
                  <h1>Enter New Lead</h1>
            </header>
            <header id="paymenthead">
                  <a id="backButton" onclick="$.ui.goBack()" class='button'>Back</a>
                  <h1>Payment Calculator</h1>
            </header>
            <header id="leadlisthead">
                  <a id="backButton" href="#" class='button'>Back</a>
                  <h1>All Your Entries</h1>
            </header>
             <header id="appmaphead">
                  <a id="backButton" onclick="$.ui.goBack()" class='button'>Back</a>
                  <h1>APPOINTMENT MAP</h1>
            </header>
      </div>


<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&libraries=places&language=en-AU"></script>
 <script>
    var options = {  componentRestrictions: {country: "ca"} };
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

 <script>
                  $(document).ready(function(){
                    function calculate(){
                      var tax = $('#tax_rate').val();
                      var tax_rate = parseFloat(parseInt(tax))/100;
                      var sale_price = $('#sale_price').val();
                      var given_price = $('#given_price').val();
                      var down_pay = $('#down_pay').val();
                      var fees = $('#fees').html();
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
                      $('.calculate').click(function(e){
                       calculate();
                      });
                    });
                  </script>

<script>
$(document).ready(function(){

  $('.fromdate').change(function(){
    $('.fromdate').val($('.fromdate').val());
  });

  $('.todate').change(function(){
    $('.todate').val($('.todate').val());
  });


  $('.submitNewLead').click(function(){
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
        $.ui.popup("Succesfully entered New Lead");
      }
    });
  });

  var t = 1;
     $(document).on('click','.viewappts',function(){
       var d = $(this).attr('data-id');
       if(t==1){
         $('.viewappts').html("VIEW ALL APPOINTMENTS");
         $('.appts').hide();
         $('.appList').hide();
         $('.rep-'+d).show();
         t=0;
       } else {
         $('.viewappts').html("VIEW ONLY YOUR APPOINTMENTS");
         $('.appList').show();
         $('.appts').show();
         t=1;
       }
     });

$(document).on('click','.saveSale',function(){
  var form = $('#saleForm').serialize();
    var t = confirm("Are you sure you want to process this sale!");
    if(t){
      $.getJSON('../sales/registersale',form,function(data){
        if(data=="success"){
          $.ui.popup("Appointment Updated as SOLD!");
          $('#processButtons').hide();
          getAppts();
          //$.ui.loadContent("#demos",true,true,"pop");
        } else {
           $.ui.popup("Failed! Contact your Web Admin");
        }
      });
    }
});

$(document).on('click','.deleteLead',function(){
  var id = $(this).attr('data-id');
  var url="../lead/delete/"+id;
  var l = confirm("Are you sure you want to delete this lead?");
  if(l){
  $.getJSON(url,function(data){
    $('#leadrow-'+id).hide(600);
  });}
});

$(document).on('click','.appts',function(){
var rep = $(this).attr('data-rep');
var id = $(this).attr('data-apptid');
var me = $(this).attr('data-id');

if(rep==me){
  $('#processButtons').show();
  $('#appid').val(id);
} else {
  $('#processButtons').hide();
  $('#appid').val(0);
}
getMap(id);
});

$(document).on('click','.process',function(){
  var id = $('#appid').val();
  var status = $(this).html();
  if(status=="SOLD"){
    $('#soldSelect').show();
  } else {
  var t = confirm("Are you sure you want to process this Appointment as "+status);
    if(t){
      $.getJSON('../appointment/dns/'+id+'-'+status.trim(),{request:'json'},function(data){
        if(data=="success"){
          $.ui.popup("Appointment Updated as "+status+"!");
          $('#processButtons').hide();
          getAppts();
          //$.ui.loadContent("#demos",true,true,"pop");
        } else {
           $.ui.popup("Failed! Contact your Web Admin");
        }
      });
    } else {
      
    }
  }
});

$('.uploadDocs').click(function(){
  var id = $(this).data('id');
  $.ui.popup("This feature isn't available yet");
});


$('.viewLeadList').click(function(){
  getLeads();
});

$('.getAppts').click(function(){
  getAppts();
});

function getMap(id){
	var url = './getappmap/'+id;
	$.getJSON(url,function(data){
		var mapOptions = {
          		center: new google.maps.LatLng(<?php echo $setting->lat;?>,<?php echo $setting->lng;?>),
          		zoom: 8,
          		mapTypeId: google.maps.MapTypeId.ROADMAP
        	};
        	var map = new google.maps.Map(document.getElementById("map"),
            mapOptions);
      	var ico="";
      	$.each(data, function(key, data) {
            	var latLng = new google.maps.LatLng(data.lat, data.lng); 
            	if(data.status=="APP"){
            		ico = '/img/app-app.png';
            	} else if(data.result=="DNS")  {
            		ico = '/img/app-dns.png';
            	} else if(data.status=="NI")  {
            		ico = '/img/app-dns.png';
            	} else if(data.status=="CXL")  {
            		ico = '/img/app-cxl.png';
            	} else {
            		ico = '/img/door-regy.png';
            	}
            	var marker = new google.maps.Marker({
                		position: latLng,
                		title: data.title,
                		icon: ico
            	});
            	marker.setMap(map);
          	});
	});
}


	$('#getmarketstats').click(function(){
    		getBarChart("DATE");
	});

	$('.getmarket').click(function(){
		var t = $(this).data('id');
		getBarChart(t);
	});

	$('.getsales').click(function(){
		var t = $(this).data('id');
		getSalesAvg(t);
	});

	$('.getmarketreport').click(function(){
		var t = $(this).data('id');
		getMarketReport(t);
	});

  $('.viewsale').click(function(){
    var id = $(this).data('id');
    getSale(id);
  });


  function getSale(id){
   $.ajax({
            url: './viewsale/'+id,
            success: function (data) {
            var d = JSON.parse(data);
             var inv = d.inv;

             $('.salecheck').prop("checked" , false);

              $('#payout').val(d.sale.attributes.payout).data('id',d.sale.attributes.id);
              if(d.sale.attributes.net==1){
              	$('#net').prop('checked',true);
              }
              if(d.sale.attributes.finance==1){
              	$('#finance').prop('checked',true);
              }
              if(d.sale.attributes.tdpay==1){
              	$('#tdpay').prop('checked',true);
              }
              if(d.sale.attributes.conf==1){
              	$('#conf').prop('checked',true);
              }
              if(d.sale.attributes.funded==1){
              	$('#funded').prop('checked',true);
              }
              if(d.sale.attributes.app==1){
              	$('#app').prop('checked',true);
              }
              $('#net').data('id',d.sale.attributes.id);
              $('#finance').data('id',d.sale.attributes.id);
              $('#tdpay').data('id',d.sale.attributes.id);
              $('#conf').data('id',d.sale.attributes.id);
              $('#funded').data('id',d.sale.attributes.id);
              $('#app').data('id',d.sale.attributes.id);
              $('#price').val(d.sale.attributes.price).data('id',d.sale.attributes.id);
              $('#defone').val(d.sale.attributes.defone).data('id',d.sale.attributes.id);
              $('#deftwo').val(d.sale.attributes.deftwo).data('id',d.sale.attributes.id);
              $('#maj').val(d.sale.attributes.maj).data('id',d.sale.attributes.id);
              $('#att').val(d.sale.attributes.att).data('id',d.sale.attributes.id);
              $('#cust_name').val(d.sale.attributes.cust_name).data('id',d.sale.attributes.id);
               $('#typeofsale').data('id',d.sale.attributes.id);
              $('#payment').val(d.sale.attributes.payment).data('id',d.sale.attributes.id);
              $('select#typeofsale > option').each(function(){
                if ($(this).val() == d.sale.attributes.typeofsale) $(this).attr("selected","selected");
              });
              $('select#payment > option').each(function(){
                if ($(this).val() == d.sale.attributes.methodofpay) $(this).attr("selected","selected");
              });
              $('select#deferal > option').each(function(){
                if ($(this).val() == d.sale.attributes.deferal) $(this).attr("selected","selected");
              });
              var deftwo = "<option value=''></option>";
              var defone = "<option value=''></option>";
              var att="<option value=''></option>";var maj="<option value=''></option>";
              $.each(inv, function(i, val){

                if(val.attributes.item_name=='defender'){
                  defone+="<option value='"+val.attributes.id+"'";
                  deftwo+="<option value='"+val.attributes.id+"'";
                    if(d.sale.attributes.defone==val.attributes.id){
                      defone+="selected='selected'";
                    }
                     if(d.sale.attributes.deftwo==val.attributes.id){
                      deftwo+="selected='selected'";
                    }

                  defone+=">"+val.attributes.sku+"</option>";
                  deftwo+=">"+val.attributes.sku+"</option>";

                } else if(val.attributes.item_name=='defender'){
                  maj+="<option value='"+val.attributes.id+"'";
                    if(d.sale.attributes.maj==val.attributes.id){
                      maj+="selected='selected'";
                    }
                  maj+=">"+val.attributes.sku+"</option>";
                } else if(val.attributes.item_name=='attachment'){
                  att+="<option value='"+val.attributes.id+"'";
                    if(d.sale.attributes.att==val.attributes.id){
                      att+="selected='selected'";
                    }
                  att+=">"+val.attributes.sku+"</option>";
                }
              });

              $('#defone').html("").append(defone);
              $('#deftwo').html("").append(deftwo);
              $('#maj').html("").append(maj);
              $('#att').html("").append(att);
            }
    });

  }

function getMarketReport(time){
	$.ajax({
            url: './marketingreport',
            data: {period:time},
            success: function (data) {
               	var d = JSON.parse(data);
               
               	var html="";
               	var totalsurveys=0;
               	var totalmas=0;var totalreggies=0;var totalscratch=0;var totalsold=0;var totaldems=0;
			$.each(d.paperanddoor, function(i,val){
               		
               		if(val.original_leadtype==="paper"){
					totalsurveys = totalsurveys+val.tot;
					totalmas = val.tot;
				} else if(val.original_leadtype==="door"){
					totalsurveys = totalsurveys+val.tot;
					totalreggies=val.tot;
				}
					totalsold = totalsold+val.sold;
					totaldems = totaldems+(val.sold+val.dns);
				});

				if(totalreggies+totalmas!=0){
					totalmarketing = parseInt((totalreggies+totalmas)/7);
				} else {
					totalmarketing = 0;
				}

               	$.each(d.paperanddoor, function(i,val){
               		var total="";
               		if(val.original_leadtype.length!=0){
                            	if(val.original_leadtype==="door"){
                            		total = parseInt(val.tot*3);
                            	} else if(val.original_leadtype==="paper") {
                            		total = parseInt(val.tot/7*10.50);
                            	} else if(val.original_leadtype==="other"){
                            		total = parseInt(val.tot/0.75);
                            	};

                            	if((total!=0)&&(val.sold!=0)){
                            		cps = parseInt(total/val.sold);} else {cps=0;}
                            	if((total!=0)&&(val.sold+val.dns!=0)){
                            		cpd = parseInt(total/(val.sold+val.dns));} else {cpd=0;}
                            	if((totalsold!=0)&&(total!=0)){
                            		avgcps = parseInt(total/totalsold);} else {avgcps=0;}
                            	if((totaldems!=0)&&(total!=0)){
                            		avgcpd = parseInt(total/totaldems);} else {avgcpd=0;}
                        }

                        html+="<div class='"+val.leadtype+" filter bignum3 PUTON largenum'>TOTAL "+val.total+"</div>";
                        html+="<div class='"+val.leadtype+" filter bignum3 SOLD largenum'>"+val.sold+"</div>";
                        html+="<div class='"+val.leadtype+" filter bignum3 DNS2 largenum'>"+val.dns+"</div>";
                        html+="<div class='"+val.leadtype+" filter bignum3 BOOK largenum'>"+val.nq+"</div>";
               		
               	});

               	$('.marketreports').html("").append(html);
               	$('.filter').hide();
               	$('.paper').show();

            }	
      });
}


function getBarChart(time){
    	$.get('../users/marketingavg/'+time, function(data){
        	var data = JSON.parse(data);
      	var html="";
      	if(time=="DATE"){time="DAY";}
      	$.each(data.values, function(i,val){
      		html+="<li><span class='label label-dispatch' style='font-size:13px;'>"+val.caller_id+"</span><span class='label label-avail-stats'> "+parseInt(val.avgapp)+"</span><span class='label label-ni'>NI : "+parseInt(val.avgni)+"</span>";
      		if(val.avgdnc>=1){ html+="<span class='label label-dnc'>DNC : "+parseInt(val.avgdnc)+"</span>";}
      		html +="&nbsp;&nbsp;<br/><br/><span class='label label-time' style='font-size:10px;'> "+(parseInt(val.avgapp)/(parseInt(val.avgni)+parseInt(val.avgapp))*100).toFixed(2)+"%</span><span class='label label-name' style='font-size:10px;float:right'>Averages "+parseInt(val.avgcalls)+" Calls a "+time+"</span> </li>";
      	});
       	$('.marketingstats').html("").append("<ul class='list'>"+html+"</ul>");
    	});
}


function getAppts(){
  $.get('../appointment/mobilelist',function(data){
    $.ui.updateContentDiv("#demos",data);
  });
}

function getLeads(){
  $.getJSON('../users/leadlist',function(data){
     var html="";
    $.each(data,function(i,val){
       html+="<li id='leadrow-"+val.id+"' class='' style='border-bottom:1px solid #1f1f1f;'>";
      if(val.status=="INACTIVE"){html+="<button class='deleteLead button red' data-id='"+val.id+"' style='float:right;'>DELETE</button>";} 
      html+="<b style='color:black;'>"+val.entry_date+"</b><br/>";
      html+="<p><span style='font-size:12px;color:#000'><b>"+val.address+"</b></span><br/>";
      html+="<b>"+val.cust_num+"</b></p>";
      if(val.status!='INACTIVE'){
        html+="<span id=' class='status' style='float:right;margin-top:-20px;'>Status : "+val.status+"</span></li>";
      }
    });
    $.ui.updateContentDiv("#theLeads",html);
  });
}

function getSalesAvg(time){
    	$.get('../users/salesavg/'+time, function(data){
        	var data = JSON.parse(data);
      	var html="";
      	if(time=="DATE"){time="DAY";}
      	$.each(data.values, function(i,val){
      		html+="<li><span class='label label-dispatch' style='font-size:13px;'>"+val.rep_id+"</span><span class='label label-avail-stats'>SALES :  "+parseInt(val.avgsold)+"</span>";
      		if(val.avgdns>=1){ html+="<span class='label label-dnc'>DNS : "+parseInt(val.avgdns)+"</span>";}
      		html +="&nbsp;&nbsp;<br/><br/><span class='label label-time' style='font-size:10px;'>CLOSE % :  "+(parseInt(val.avgsold)/(parseInt(val.avgdems))*100).toFixed(2)+"%</span><span class='label label-name' style='font-size:10px;float:right'>Averages "+parseInt(val.avgdems)+" Demos a "+time+"</span> </li>";
      	});
       	$('.salesaverages').html("").append("<ul class='list'>"+html+"</ul>");
    	});
}

});

</script>

</body>
</html>
