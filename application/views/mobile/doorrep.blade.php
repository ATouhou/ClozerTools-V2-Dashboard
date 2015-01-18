<?php $setting = Setting::find(1);?>
<?php if($setting->shortcode=="putk"){$amt = 2.00;} else{$amt=3.00;};?>
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
                      
                    	<ul class="list inset">
                         <li class='red'>
                             <a href="#newlead" id='enternew' class='icon new big'>ENTER NEW LEAD </a>
                         </li>
                         <li class='red'>
                             <a href="#todaysleadlist" id='viewtodaysleads' class='viewTodaysLeads icon user big'>TODAYS ENTRIES</a>
                         </li>
                         <li class='red'>
                             <a href="#leadlist" id='viewleads' class='viewLeadList icon user big'>ALL YOUR ENTRIES</a>
                         </li>
                      </ul>
                      <br/>
                      <ul class="list inset">
                         <li class='red'>
                             <a href="#reports" id='report' class='getStats icon graph big'>DAILY STATS</a>
                         </li>
                      </ul>
                      <br/>

                        <ul class="list inset">
                          <li>
                              <a href="{{URL::to('users/logout')}}" onclick='preventDefault();' class='icon power'>LOGOUT</a>
                          </li>
                    	</ul>
                    
                    	
               	</div>
                 
                  <div title="APPOINTMENT MAP" id="appmap" class="panel" data-header="appmaphead">
                    <div id="map" style="height:880px;width:120%;margin-left:-10px;margin-top:0px;"></div>
                  </div> 


                <div title="Enter New Lead" id="newlead" class="panel" data-header="newleadhead">
                  <?php $res = User::where('level','!=',99)->where('user_type','=','doorrep')->order_by('firstname')->get();
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


                  <div  id="todaysleadlist" class="panel" >
                    <ul class="list" id="todaysLeads" >
                   
                    </ul>
                  </div>
                  <div  id="leadlist" class="panel" data-footer="datefoot"   >
                    <ul class="list" id="theLeads" >
                   
                    </ul>
                  </div> 

               	<div title="Daily Summary" id="reports" class="panel" data-header="reporthead" data-footer="datefootstats">
                    	<ul class="list" id="theStats">
                      
                    	</ul>
               	</div>
            </div>
            
            <!--FOOTER-->
            <div id="navbar" style='margin: 0;float:left;'>
                <a href="#newlead" class="icon new">NEW LEAD</a>
                <a href="#reports" class="getStats icon graph">DAILY STATS</a>
                <a href="#todaysleadlist" class='viewTodaysLeads icon calendar'>LEADS TODAY</a>
            </div>
            <div id="datefoot" >
              <div style="width:39%;float:left;margin-top:10px;margin-left:5px;">
                <span style="float:left;color:#fff;">From :</span> 
                <input style="width:65%;float:left;height:22px;" class="fromdate" id="fromdate" name="startdate" type="text" value="{{date('Y-m-d',strtotime('-7 Days'))}}"  />
              </div>
              <div style="width:39%;float:left;margin-left:8px;margin-top:10px;">
                  <span style="float:left;color:#fff;">To :</span> 
                  <input style="width:65%;float:left;height:22px;" class="todate" id="todate" name="enddate" type="text" value="{{date('Y-m-d')}}"  />
              </div>
              <div style="float:right;width:13%;margin-right:15px;">
                <button class="filterLeads button green" style="width:100%;">GO</button>
              </div>
            </div>
            <div id="datefootstats" >
              <div style="width:39%;float:left;margin-top:10px;margin-left:5px;">
                <span style="float:left;color:#fff;">From :</span> 
                <input style="width:65%;float:left;height:22px;" class="fromdate" id="fromdatestat" name="startdate" type="text" value="{{date('Y-m-d',strtotime('-7 Days'))}}"  />
              </div>
              <div style="width:39%;float:left;margin-left:8px;margin-top:10px;">
                  <span style="float:left;color:#fff;">To :</span> 
                  <input style="width:65%;float:left;height:22px;" class="todate" id="todatestat" name="enddate" type="text" value="{{date('Y-m-d')}}"  />
              </div>
              <div style="float:right;width:13%;margin-right:15px;">
                <button class="filterStats button green" style="width:100%;">GO</button>
              </div>
            </div>
            <!--headers-->
            <header id="reporthead">
                	<a id="backButton" onclick="$.ui.goBack()" class='button'>Back</a>
                	<h1>Your Reports</h1>
            </header>
            <header id="newleadhead">
                  <a id="backButton" onclick="$.ui.goBack()" class='button'>Back</a>
                  <h1>Enter New Lead</h1>
                  
            </header>
             <header id="appmaphead">
                  <a id="backButton" onclick="$.ui.goBack()" class='button'>Back</a>
                  <h1>MAP</h1>
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

  $('.viewLeadList').click(function(){
    $.ui.setTitle("All Your Entries");
    setTimeout(getLeads,400);
  });

  $('.viewTodaysLeads').click(function(){
    $.ui.setTitle("Todays Leads");
    getLeads("today"); 
  });

  $('.getStats').click(function(){ 
    getStats();
  });


$('.filterStats').click(function(){
  getStats();
});

$('.filterLeads').click(function(){
  getLeads();
});

function getStats(time){
  $.ui.updateContentDiv("#theStats","<center><img src='../img/loaders/misc/66.gif' style='margin-top:39px;'></center>");
  var from = $('#fromdatestat').val();
  var to = $('#todatestat').val();
  if(time=="today"){
    var form = {date:'today'};
  } else {
    var form = {date:'range',start:from,end:to};
  } 
  $.getJSON('../users/mobilestats/doorrep',form,function(data){
    console.log(data);
     var html="";
     var amt = parseFloat("{{$amt}}");
    $.each(data,function(i,val){
      var theTot = (parseInt(val.total)-parseInt(val.wrong))*amt;
      html+="<li class='' style='border-bottom:1px solid #000;'><b style='font-size:15px;color:#000;'>"+val.entry_date+"</b><br/>";
      html+="<b>Total:</b> "+val.total+"&nbsp;&nbsp;<b>Contact:</b> "+val.contact;
      html+="<span class='label label-ni' >NI : "+val.ni+"</span>&nbsp;&nbsp;<span class='label label-nq'> NQ : "+val.nq+"</span>&nbsp;&nbsp;<br/><br/><span class='label label-wrong'> Wrong : "+val.wrong+"</span><span class='label label-name'> $"+parseFloat(theTot).toFixed(2)+" </span><span class='label label-dnc' >DNS : "+val.dns+"</span><span class='label label-sold' >SOLD : "+val.sold+"</span> </li>";
      
    });
    $.ui.updateContentDiv("#theStats",html);
  });
}

function getLeads(time){
  $.ui.updateContentDiv("#theLeads","<center><img src='../img/loaders/misc/66.gif' style='margin-top:39px;'></center>");
  var from = $('#fromdate').val();
  var to = $('#todate').val();
  if(time=="today"){
    var form = {date:'today'};
  } else {
    var form = {date:'range',start:from,end:to};
  } 

  $.getJSON('../users/leadlist',form,function(data){
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
   
    if(time=="today"){
      $.ui.updateContentDiv("#todaysLeads",html);
    } else {
      $.ui.updateContentDiv("#theLeads",html);
    }
  });
}

$(document).on('click','.deleteLead',function(){
  var id = $(this).attr('data-id');
  var url="../lead/delete/"+id;
  var l = confirm("Are you sure you want to delete this lead?");
  if(l){
  $.getJSON(url,function(data){
    $('#leadrow-'+id).hide(600);
  });}
});



/*
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

*/
  



});

</script>

</body>
</html>
