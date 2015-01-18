@layout('layouts/main')
@section('content')
<style>

</style>
<div id="main" role="main" class="container-fluid">
    <div class="contained">
        <aside> 
            @render('layouts.managernav')
        </aside>
        <div id="page-content" style="background:white;">
            <h1 id="page-header">Door Reggie History</h1>   
                <div class="fluid-container">
                    <div class="row-fluid" style="margin-bottom:20px;">
                        <h4>Pick a City</h4>
                        @foreach($cities as $val)
                        <button class='btn btn-default getMap' data-city="{{$val->cityname}}" style="margin-top:5px;margin-bottom:5px;">{{$val->cityname}}</button>
                        @endforeach

                    </div>
                    <div class='row-fluid' id="pleasewait" style="display:none;text-align:center;margin-bottom:50px;">
                        <h2 class='animated fadeInUp'>Please Wait...</h2>
                       <img  src="{{URL::to_asset('images/cat-vacuum.gif')}}" width=400px>
                    </div>
                    <div class='row-fluid' id="nodata" style="display:none;text-align:center;margin-bottom:50px;">
                       <img class='animated fadeInUp' src="{{URL::to_asset('images/noresults.jpg')}}" width=400px>
                    </div>
                    <div class='row-fluid' id="thedata" style="display:none;">
                        <div class="row-fluid well" style="margin-top:5px;">
                            
                                <div id="map" style="width:100%;height:480px; "></div>
                        </div>
                        <div class="row-fluid well" >
                                <table class="table table-condensed responsive" id="dtable2">
                                    <thead><tr>
                                        <th>#</th>
                                        <th>Assigned</th>
                                        <th>Number</th>
                                        <th style="width:10%;">Name</th>
                                        <th>Address</th>
                                        <th>Reggier</th>
                                        
                                        <th>Survey Date</th>
                                        <th style="width:12%;">Notes</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>

                                    <tbody id="leadtable"></tbody>
                                </table>
                        </div>
                    </div>
                   

                   
            <aside class="right">
 
            </aside>
        </div>
    </div>
</div>
<div class="push"></div>

<script src="{{URL::to_asset('js/include/gmap3.min.js')}}"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&amp;language=en"></script>
<script>
$(document).ready(function() {

$('.getMap').click(function(){
var dat = $(this).data('city');
$('#pleasewait').hide();
$('#nodata').hide();
$('#thedata').hide();
$('#pleasewait').show();
   setTimeout(function(){
    $.getJSON('../getreggiemap',{city:dat},function(data){
}).done(function(data){
    $('#pleasewait').hide();
    $('#nodata').hide();
    $('#thedata').show();
    $("#map").gmap3({
    marker:{
    values: data.markers,
    options:{
     draggable:false,
    },
    /*events:{
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
    }*/
  },
  map:{
    options:{
      zoom: 9,
        center: new google.maps.LatLng({{Setting::find(1)->lat}},{{Setting::find(1)->lng}}),
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        mapTypeControl: true,
        mapTypeControlOptions: {
         mapTypeIds: [google.maps.MapTypeId.ROADMAP, google.maps.MapTypeId.HYBRID],
          style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
        },
        navigationControl: true,
        scrollwheel: true,
        streetViewControl: true
     }
  }
});

html="";count=0;
$.each(data.tabledata, function(i,val){
    count++;

if(val.status=="SOLD"){thelabel="success special";} else if(val.status=="CXL"){thelabel="important";}
else if((val.status=="DNC")||(val.status=="NQ")){thelabel="important special";}
else if(val.status=="NI"){thelabel="important";} else if(val.status=="NID"){thelabel="important";} else if((val.status=="RB-TF")||(val.status=="RB-OF")){thelabel="info special";}
else if(val.status=="NH"){thelabel="info";} else if(val.status=="NEW") {thelabel="inverse";} else if(val.status=="ASSIGNED"){thelabel="warning"} else if(val.status=="WrongNumber") {thelabel="warning special";} else if(val.status=="INACTIVE"){thelabel = "inverse special";} else {thelabel="success special";}
if(val.status=="APP"){theresult = "<span class='result "+val.result+" '>"+val.result+"</span>";} else {theresult="";}


html+="<tr><td><center>"+count+"</center></td><td><center><span class='label label-important round special'>"+val.assign_count+"</span></center></td><td><center><a href='{{URL::to('lead/newlead/')}}"+val.cust_num+"'><span class='label label-inverse'>"+val.cust_num+"</span></a></center></td><td>"+val.cust_name+"</td><td>"+val.address+"</td><td>"+val.researcher_name+"</td><td>"+val.entry_date+"</td><td>"+val.notes+"</td><td><span class='label label-"+thelabel+"'>"+val.status+"</span>"+theresult+"</td></tr>";

});
$('#leadtable').html(html);
$('#dtable2').dataTable().fnDestroy();
$('#dtable2').dataTable(
    {
            // define table layout
            "sDom" : "<'row-fluid dt-header'<'span6'f><'span6 hidden-phone'T>r>t<'row-fluid dt-footer'<'span6 visible-desktop'i><'span6'p>>",
            // add paging 
            "sPaginationType" : "bootstrap",
            "oLanguage" : {
                "sLengthMenu" : "Showing: 25",
                "sSearch": "" 
            },
            "aaSorting": [],
            "aLengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "All"]],
            "iDisplayLength":500,
            "oTableTools": {
                "sSwfPath": "../js/include/assets/DT/swf/copy_csv_xls_pdf.swf",
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sButtonText": '<i class="cus-doc-excel-table oTable-adjust"></i>'+" BACKUP TO EXCEL"
                    }
                ]
            }
        }); 


}).fail(function() {
    $('#pleasewait').hide();
    $('#nodata').show();
    $('#thedata').hide();
  });
},1200);

});

});
</script>

@endsection