@layout('layouts/main')
@section('content')

	<?php $adds=array();?>
	@foreach($apps as $a)
	   
	    <?php $adds[] = $a->lead->address;?>
	@endforeach



    <?php $adds2 = json_encode($adds);?>

<div id='map-canvas' style="height:900px;float:left;width:100%;">

</div>
<div id="my_textual_div" style="float:left;position:absolute;width:400px;height:400px;z-index:50000;">

	</div>


<script src="{{URL::to_asset('js/')}}BpTspSolver.js"></script>
<script src="{{URL::to_asset('js/')}}tsp.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
    <script>
var myMap;

function initialize() {
  var mapOptions = {
    zoom: 8,
    center: new google.maps.LatLng(-34.397, 150.644)
  };
  myMap = new google.maps.Map(document.getElementById('map-canvas'),
      mapOptions);

directionsPanel = document.getElementById("my_textual_div");
// Create the tsp object
tsp = new BpTspSolver(myMap, directionsPanel);

// Set your preferences
tsp.setAvoidHighways(true);
tsp.setTravelMode(google.maps.DirectionsTravelMode.DRIVING);
// Add points (by coordinates, or by address).
// The first point added is the starting location.


$.each(<?php echo $adds2;?>, function(i,val){
	console.log(val);
	if(val!=''){
tsp.addAddress(val, addAddressCallback);}
});
// The last point added is the final destination (in the case of A - Z mode)
//  // Note: The callback is new for version 3, to ensure waypoints and addresses appear in the order they were added in.
//tsp.addAddress('2156 East 28th Avenue, Vancouver', addAddressCallback);
//tsp.addAddress('1856 Harbour Street, Port Coquitlam', addAddressCallback);
//tsp.addAddress('1836 E13th Avenue, Vancouver', addAddressCallback);

function addAddressCallback(d){
	

}

function addWaypointCallback(d){

console.log(d);
}
function removeOldMarkers() {
    for (var i = 0; i < markers.length; ++i) {
        markers[i].setMap(null);
    }
    markers = new Array();
}

function onSolveCallback(myTsp) {
  //jQuery('#dialogProgress').dialog('close');
    var dirRes = tsp.getGDirections();
    var dir = dirRes.routes[0];
    // Print shortest roundtrip data:
   
    /*var pathStr = "<p>Trip duration: " + formatTime(getTotalDuration(dir)) + "<br>";
    pathStr += "Trip length: " + formatLength(getTotalDistance(dir)) + 
      " (" + formatLengthMiles(getTotalDistance(dir)) + ")</p>";
    document.getElementById("path").innerHTML = pathStr;
    document.getElementById("exportDataButton").innerHTML = "<input id='rawButton' class='calcButton' type='button' value='Toggle raw path output' onClick='toggle(\"exportData\"); document.getElementById(\"outputList\").select();'>";
    var durStr = "<input id='csvButton' class='calcButton' type='button' value='Toggle csv durations matrix' onClick='toggle(\"durationsData\");'>";
    document.getElementById("durations").innerHTML = durStr;
    document.getElementById("exportLabelButton").innerHTML = "<input id='rawLabelButton' class='calcButton' type='button' value='Raw path with labels' onClick='toggle(\"exportLabelData\"); document.getElementById(\"outputLabelList\").select();'>"
    document.getElementById("exportAddrButton").innerHTML = "<input id='rawAddrButton' class='calcButton' type='button' value='Optimal address order' onClick='toggle(\"exportAddrData\"); document.getElementById(\"outputAddrList\").select();'>"
    document.getElementById("exportOrderButton").innerHTML = "<input id='rawOrderButton' class='calcButton' type='button' value='Optimal numeric order' onClick='toggle(\"exportOrderData\"); document.getElementById(\"outputOrderList\").select();'>"

    var formattedDirections = formatDirections(dir, mode);
    document.getElementById("routeDrag").innerHTML = formattedDirections[0];
    document.getElementById("my_textual_div").innerHTML = formattedDirections[1];
    document.getElementById("garmin").innerHTML = createGarminLink(dir);
    document.getElementById("tomtom").innerHTML = createTomTomLink(dir);
    document.getElementById("exportGoogle").innerHTML = "<input id='googleButton' value='View in Google Maps' type='button' class='calcButton' onClick='window.open(\"" + createGoogleLink(dir) + "\");' />";
    document.getElementById("reverseRoute").innerHTML = "<input id='reverseButton' value='Reverse' type='button' class='calcButton' onClick='reverseRoute()' />";
    jQuery('#reverseButton').button();
    jQuery('#rawButton').button();
    jQuery('#rawLabelButton').button();
    jQuery('#csvButton').button();
    jQuery('#googleButton').button();
    jQuery('#tomTomButton').button();
    jQuery('#garminButton').button();
    jQuery('#rawAddrButton').button();
    jQuery('#rawOrderButton').button();*/

    jQuery("#sortable").sortable({ stop: function(event, ui) {
          var perm = jQuery("#sortable").sortable("toArray");
          var numPerm = new Array(perm.length + 2);
          numPerm[0] = 0;
          for (var i = 0; i < perm.length; i++) {
            numPerm[i + 1] = parseInt(perm[i]);
          }
          numPerm[numPerm.length - 1] = numPerm.length - 1;
          tsp.reorderSolution(numPerm, onSolveCallback);
        } });
    jQuery("#sortable").disableSelection();
    for (var i = 1; i < dir.legs.length; ++i) {
      var finalI = i;
      jQuery("#dragClose" + i).button({
        icons: { primary: "ui-icon-close" },
            text: false
            }).click(function() {
                tsp.removeStop(parseInt(this.value), null);
              });
    }
    removeOldMarkers();

    // Add nice, numbered icons.
    if (mode == 1) {
        var myPt1 = dir.legs[0].start_location;
        var myIcn1 = new google.maps.MarkerImage("{{URL::to_asset('img/app-small-DISP.png')}}");
        var marker = new google.maps.Marker({ 
            position: myPt1, 
            icon: myIcn1, 
            map: myMap });
        markers.push(marker);
    }
    for (var i = 0; i < dir.legs.length; ++i) {
        var route = dir.legs[i];
        var myPt1 = route.end_location;
        var myIcn1;
        if (i == dir.legs.length - 1 && mode == 0) {
            myIcn1 = new google.maps.MarkerImage("{{URL::to_asset('img/app-small-DISP.png')}}");
        } else {
            myIcn1 = new google.maps.MarkerImage("{{URL::to_asset('img/app-small-DISP.png')}}");
        }
        var marker = new google.maps.Marker({
            position: myPt1,
            icon: myIcn1,
            map: myMap });
        markers.push(marker);
    }
    // Clean up old path.
    if (dirRenderer != null) {
        dirRenderer.setMap(null);
    }
    dirRenderer = new google.maps.DirectionsRenderer({
        directions: dirRes,
        hideRouteList: true,
        map: myMap,
        panel: null,
        preserveViewport: false,
        suppressInfoWindows: true,
        suppressMarkers: true });

    // Raw path output
    var bestPathLatLngStr = dir.legs[0].start_location.toString() + "\n";
    for (var i = 0; i < dir.legs.length; ++i) {
        bestPathLatLngStr += dir.legs[i].end_location.toString() + "\n";
    }
   /* document.getElementById("exportData_hidden").innerHTML = 
        "<textarea id='outputList' rows='10' cols='40'>" 
        + bestPathLatLngStr + "</textarea><br>";*/

    // Raw path output with labels
    var labels = tsp.getLabels();
    var order = tsp.getOrder();
    var bestPathLabelStr = "";
    if (labels[order[0]] == null) {
      bestPathLabelStr += order[0];
    } else {
      bestPathLabelStr += labels[order[0]];
    }
    bestPathLabelStr += ": " + dir.legs[0].start_location.toString() + "\n";
    for (var i = 0; i < dir.legs.length; ++i) {
      if (labels[order[i+1]] == null) {
        bestPathLabelStr += order[i+1];
      } else {
        bestPathLabelStr += labels[order[i+1]];
      }
      bestPathLabelStr += ": " + dir.legs[i].end_location.toString() + "\n";
    }
   /* document.getElementById("exportLabelData_hidden").innerHTML = 
        "<textarea id='outputLabelList' rows='10' cols='40'>" 
      + bestPathLabelStr + "</textarea><br>";*/

    // Optimal address order
    var addrs = tsp.getAddresses();
    var order = tsp.getOrder();
    var bestPathAddrStr = "";
    if (addrs[order[0]] == null) {
      bestPathAddrStr += dir.legs[0].start_location.toString();
    } else {
      bestPathAddrStr += addrs[order[0]];
    }
    bestPathAddrStr += "\n";
    for (var i = 0; i < dir.legs.length; ++i) {
      if (addrs[order[i+1]] == null) {
        bestPathAddrStr += dir.legs[i].end_location.toString();
      } else {
        bestPathAddrStr += addrs[order[i+1]];
      }
      bestPathAddrStr += "\n";
    }
   /* document.getElementById("exportAddrData_hidden").innerHTML = 
        "<textarea id='outputAddrList' rows='10' cols='40'>" 
      + bestPathAddrStr + "</textarea><br>";*/

    // Optimal numeric order
    var bestOrderStr = "";
    for (var i = 0; i < order.length; ++i) {
      bestOrderStr += "" + (order[i] + 1) + "\n";
    }
    /*document.getElementById("exportOrderData_hidden").innerHTML =
        "<textarea id='outputOrderList' rows='10' cols='40'>" 
      + bestOrderStr + "</textarea><br>";*/
     
    var durationsMatrixStr = "";
    var dur = tsp.getDurations();
    for (var i = 0; i < dur.length; ++i) {
        for (var j = 0; j < dur[i].length; ++j) {
            durationsMatrixStr += dur[i][j];
            if (j == dur[i].length - 1) {
                durationsMatrixStr += "\n";
            } else {
                durationsMatrixStr += ", ";
            }
        }
    }
   
   /* document.getElementById("durationsData_hidden").innerHTML = 
        "<textarea name='csvDurationsMatrix' rows='10' cols='40'>" 
        + durationsMatrixStr + "</textarea><br>";*/
}

// Or, if you want to start in the first location and end at the last,
// but don't care about the order of the points in between:
// tsp.solveAtoZ(onSolveCallback);
// Solve the problem (start and end up at the first location)
setTimeout(
tsp.solveRoundTrip(onSolveCallback),2000);


// Retrieve the solution (so you can display it to the user or do whatever :-)
}

google.maps.event.addDomListener(window, 'load', initialize);
</script>

@endsection
