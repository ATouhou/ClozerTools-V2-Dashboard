@layout('layouts/main')
@section('content')

<style>
    #dispatch {display:none;}
    #processapp {display:none;}
</style>
      
<div id="main" role="main" class="container-fluid">
    <div class="contained">
        
        <!--Aside start-->
        <aside> 
            @render('layouts.managernav')
        </aside>
        <!-- aside end -->
                

        <div id="page-content">
            
                <div class="fluid-container">
                    <h1 id="page-header" data-date="{{$datepass}}">Door Registrations for {{$date}}</h1>   
                        <!-- widget grid -->
                        <section id="widget-grid" class="">
        
							<div class="row-fluid" id="googlemaps">
                            <!-- new widget -->
                            <div class="jarviswidget"  data-widget-editbutton="false" data-widget-deletebutton="false"
                                    data-widget-fullscreenbutton="false" >
                                <header>
                                    <h2>Map of Door Reggies</h2>                           
                                </header>
                                    <div>
                                        <div class="inner-spacer" > 
                                            <div id="map" style="width:100%;height:500px;"></div>
                                        </div>
                                    </div>
                            </div>
                        </div>


                         
                        
                            <div class="row-fluid" id="appointments">
                                <div class="jarviswidget" data-widget-editbutton="false" data-widget-deletebutton="false"
                                    data-widget-fullscreenbutton="false" >
                                    <header>
                                        <h2>Door Registrations for {{$date}}</h2>                           
                                    </header>
                                        <!-- wrap div -->
                                        <div>
                                            <div class="inner-spacer"> 
                                                <table class="table table-bordered responsive" id="dtable" >
                                                                    <thead>
                                                        <tr>
                                                            
                                                            <th>Name</th>
                                                            <th>Number</th>
                                                            <th>Address</th>
                                                            <th>Booker</th>
                                                            <th>TIME</th>
                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(!empty($appts))
                                                    @foreach($appts as $val)
                                                  

                                                        <tr >
                                                          
                                                            <td>{{ucfirst($val->cust_name)}}</td>
                                                            <td>{{$val->cust_num}}</td>
                                                            <td>{{$val->address}},{{$val->city}}</td>
                                                            <td class="center">{{$val->booker_name}}</td>
                                                            
                                                            <td><center>{{$val->created_at}}</center></td>
                                                            
                                                        </tr>
                                                    @endforeach
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- end content-->
                                        </div>
                                        <!-- end wrap div -->
                                </div>
                        </div>
                        
                        


                        
                        </section>
                </div>
        </div>             
        <!-- end main content -->
            
        <!-- aside right on high res -->
        <aside class="right">
            @render('layouts.chat')
            <div class="divider"></div>
            <!-- date picker -->
            <h2 class="shadow">Appointment Date</h2>
            <div id="filterdate" class="shadow" style="background:#1f1f1f;border-radius:12px"></div>
        </aside>
    </div>
</div>
<!--end fluid-container-->
    
    <div class="push"></div>
    
    <!-- end .height wrapper -->
    @include('plugins.processdemo')


<!---SCRIPTS FOR THIS PAGE-->

<script src="{{URL::to_asset('js/include/gmap3.min.js')}}"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&amp;language=en"></script>
<script>
$(document).ready(function(){


var date = $('#page-header').data('date');
var url = '../lead/getmap?date='+date;

$.getJSON(url, function(data) {
$("#map").gmap3({
  marker:{
    values: data,
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
      }
    }
  },
  map:{
    options:{
      zoom: 15,
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
});




});
</script>
<!--END SCRIPTS-->
@endsection