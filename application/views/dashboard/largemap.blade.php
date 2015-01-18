@layout('layouts/main')
@section('content')
<style>
table.apptable {border:1px solid #1f1f1f;padding-bottom:50px;font-size:14px;color:#000;}
table.apptable th {border:1px solid #5e5e5e;background:#3e3e3e;color:#fff;}
table.apptable td {border:1px solid #5e5e5e;}
.processapp{width:90%!important;}
.bignum3{font-size:12px;padding:5px;}
.thedate{padding:2px;padding-left:10px;padding-right:10px;background: #4c4c4c; /* Old browsers */
background: -moz-linear-gradient(top,  #4c4c4c 0%, #595959 12%, #666666 25%, #474747 39%, #2c2c2c 50%, #000000 51%, #111111 60%, #2b2b2b 76%, #1c1c1c 91%, #131313 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#4c4c4c), color-stop(12%,#595959), color-stop(25%,#666666), color-stop(39%,#474747), color-stop(50%,#2c2c2c), color-stop(51%,#000000), color-stop(60%,#111111), color-stop(76%,#2b2b2b), color-stop(91%,#1c1c1c), color-stop(100%,#131313)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #4c4c4c 0%,#595959 12%,#666666 25%,#474747 39%,#2c2c2c 50%,#000000 51%,#111111 60%,#2b2b2b 76%,#1c1c1c 91%,#131313 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #4c4c4c 0%,#595959 12%,#666666 25%,#474747 39%,#2c2c2c 50%,#000000 51%,#111111 60%,#2b2b2b 76%,#1c1c1c 91%,#131313 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #4c4c4c 0%,#595959 12%,#666666 25%,#474747 39%,#2c2c2c 50%,#000000 51%,#111111 60%,#2b2b2b 76%,#1c1c1c 91%,#131313 100%); /* IE10+ */
background: linear-gradient(to bottom,  #4c4c4c 0%,#595959 12%,#666666 25%,#474747 39%,#2c2c2c 50%,#000000 51%,#111111 60%,#2b2b2b 76%,#1c1c1c 91%,#131313 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#4c4c4c', endColorstr='#131313',GradientType=0 ); /* IE6-9 */
color:#fff;border-radius:4px;}
.result {color:#000;margin-left:10px;padding:3px;font-weight:bold;border-radius:3px;}
.NI{background: #FF5050;!importantcolor:#000;}
.CXL {background:#FF5050;!important}
.NH{background:#0099FF;!important}
.NQ{background:#FFCCCC;!important}
.Recall{background: #FFA347;!important}
.CONF{background:#99FF99;!important}
.DNC{background: #CC8080;!important}
.INC {background:#FFCC99;!important}
.DNS{background:#1f1f1f;color:red;!important}
.NA{background:#aaa;!important}
.SOLD{background:green;!important}
.APP{background:#fff;}
.BUMP {background:#CCCCFF;!important}
.ASSIGNED{background:#0099FF;!important}
.DISP{background:#66CCFF;!important}
.NEW{background:#D6D6C2;!important}
.RB-TF{background:#FF99CC;!important}
.RB-OF{background:#FF99CC;!important}
div.jGrowl.myposition {
 position: absolute;
 font-size:200%;
 margin-left:150px;
 top: 20%;
}

.rightbutton{float:right;margin-top:10px;margin-right:10px;}
</style>

  <div id="leadview" style="background:white;min-height:1000px;width:100%;padding-top:20px;margin-top:-90px;position:absolute;z-index:20000;padding:10px;" >
                       
                       
                       <div style="position:fixed;margin-left:-10px;width:53%;top:-100px;border:1px solid #1f1f1f;">
                        		
                        		<A href="{{URL::to('dashboard')}}"><button class="btn btn-danger animated fadeInUp backtoreports" style="position:fixed;right:24px;margin-top:120px;z-index:250000;padding:8px;font-size:15px;"><i class="cus-cancel"></i>&nbsp;&nbsp;BACK TO DASHBOARD</button></a>
                                <div id="map" style="height:1200px;width:100%;"></div>

                            </div>
                                <div style="width:44%;float:right;margin-right:20px;padding-top:30px;">
                                    <button class="btn btn-default" style="margin-bottom:30px;">VIEW TODAYS APPOINTMENTS</button>
                               <h4>All Leads from <span class="label label-info special">{{date('D M-d',strtotime($startdate))}} - {{date('D M-d',strtotime($enddate))}}</span></h4>
                                <table class="apptable" style="font-size:10px;margin-right:22px;">
                                    <thead>
                                        <th style="width:3%;"><center>#</center></th>
                                        <th>CALLED</th>
                                        <th style="width:14%;"><center>Number</center></th>
                                        <th style="width:10%;">Survey Date</th>
                                        <th>Name</th>
                                        <th>Notes</th>
                                        
                                        <th>Status</th>
                                    </thead>
                                    <tbody id="leadtable">
                                    </tbody>
                                </table>
                            </div>
                      
                        	
                          
                             
                       
                    </div>
<script src="{{URL::to_asset('js/include/gmap3.min.js')}}"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&amp;language=en"></script>
<script>
$(document).ready(function(){

    var refreshId = setInterval(function() {
    var url = "{{URL::to('chat/appointmentalert')}}";     
    $.get(url, function(data){
        if(data!="none"){
            $.jGrowl(data+" <br>YOU MUST ASSIGN LEADS BEFORE THIS MESSAGE GOES AWAY!", { 
                    header: 'LEADS REQUESTED', 
                    speed: 4000,
                    theme: 'with-icon',
                    position: 'myposition', //this is default position
                    easing: 'easeOutBack',
                    
                }); 
        toastr.warning(data, 'LEADS REQUESTED');}
        });
         }, 8000);
    $.ajaxSetup({ cache: false });
    


var url = '../lead/getmap';
$.getJSON(url, function(data) {

$("#map").gmap3({
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
      zoom: 14,
       center: new google.maps.LatLng(49.219094,-123.999027),
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        mapTypeControl: true,
        mapTypeControlOptions: {
         mapTypeIds: [google.maps.MapTypeId.ROADMAP, google.maps.MapTypeId.HYBRID,"AAS"],
          style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
        },
        navigationControl: true,
        scrollwheel: true,
        streetViewControl: true
     }
  },

  styledmaptype:{
  id: "AAS",
  options: {
  name:"aas"},
  styles:[
  {
    "featureType": "road.highway",
    "stylers": [
      { "hue": "#08ff00" }
    ]
  },{
    "featureType": "road.arterial",
    "stylers": [
      { "weight": 5 },
      { "hue": "#11ff00" },
      { "color": "#acdd08" }
    ]
  },{
    "featureType": "road.local",
    "stylers": [
      { "lightness": -20 },
      { "gamma": 0.77 }
    ]
  },{
    "featureType": "landscape.natural",
    "stylers": [
      { "hue": "#00ff09" },
      { "color": "#00cf24" },
      { "lightness": -53 },
      { "saturation": -31 }
    ]
  },{
  }
]}



});


html="";count=0;
$.each(data.leads, function(i,val){
    count++;

if(val.status=="SOLD"){thelabel="success special";} else if(val.status=="CXL"){thelabel="important";}
else if((val.status=="DNC")||(val.status=="NQ")){thelabel="important special";}
else if(val.status=="NI"){thelabel="important";} else if((val.status=="RB-TF")||(val.status=="RB-OF")){thelabel="info special";}
else if(val.status=="NH"){thelabel="info";} else if(val.status=="NEW") {thelabel="inverse";} else if(val.status=="ASSIGNED"){thelabel="warning"} else if(val.status=="WrongNumber") {thelabel="warning special";} else {thelabel="success special";}
if(val.status=="APP"){theresult = "<span class='result "+val.result+" '>"+val.result+"</span>";} else {theresult="";}


html+="<tr><td><center>"+count+"</center></td><td><center><span class='label label-important round special'>"+val.assign_count+"</span></center></td><td><center><a href='{{URL::to('lead/newlead/')}}"+val.cust_num+"'>"+val.cust_num+"</a></center></td><td>"+val.entry_date+"</td><td>"+val.cust_name+"</td><td>"+val.notes+"</td><td><span class='label label-"+thelabel+"'>"+val.status+"</span>"+theresult+"</td></tr>";

});
$('#leadtable').html(html);

 

});




$('.filter').click(function(){
var filter = $(this).data('status');
hide(filter);
});

function hide(category) {
    var objs = $("#map").gmap3({
        get: {
            name:"marker",
            all: true
        }
    });    
    $.each(objs, function(i, obj){
        obj.setVisible(false);
    });

    var objs = $("#map").gmap3({
        get: {
            name:"marker",
            tag: category,
            all: true
        }
    });    
    $.each(objs, function(i, obj){
        obj.setVisible(true);
    });
}

$('.backtoreports').click(function(){
    window.scrollTo(0, 0);
$('#leadview').hide();
});




});
</script>
@endsection