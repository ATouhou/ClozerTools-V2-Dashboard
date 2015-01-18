<?php session_start();
include("dbconnect.php");
$country = $_GET['c'];
if(empty($country)){$country="us";}
if($country=="can"){$ctransform = "var tfm = 'S0.70,0.60,0,0';var trn = '-920,-255';
		c.forEach(function(obj){obj.transform(tfm);obj.translate(trn);});";} else {$ctransform ="var tfm = 'S0.98,0.98,0,0';var trn = '0,0';
		c.forEach(function(obj){obj.transform(tfm);obj.translate(trn);});";};?>
		
		
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DASAL | Find a Representative</title>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link href="css/framework.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="js/raphael-min.js"></script>
<script type="text/javascript" src="js/map-<?echo $country;?>.js"></script>
 
	
	  <script type="text/javascript">
$(document).ready(function(){

$('div#repbox').fadeIn(800);
$('div#replisting').html('<h3>Try Our Satellite Map</h3><p style="font-size:14px;">We now have a Google Earth view of our rep map<br>You must have an up-to-date browser for it to work properly.<br>If youd like to try it, click <a href="/Satellite-Rep-Finder">HERE</a><br>Or just click "CLICK FOR SATELLITE VIEW" at the top right</p>');
$('div#replisting').show();

$('div.main_wrap').hide();
$('div.main_wrap').fadeIn(1200);

$('div#closerepbox').click(function(){
$('div#repbox').fadeOut(300);
});

$('.repbutton').click(function(){
$('#hiddenlist').toggle(350);
});

//Create the map
var c = Raphael('map', 980, 600);
c.safari();
	
    var label = c.popup(0, 0, "").hide();
    attr = { fill: '#6e6e6e', stroke: '#1f1f1f', 'stroke-width': 0.6, 'stroke-linejoin': 'round' }
	
    arr = new Array();
    for (var item in paths) {
        var p = c.path(paths[item].path);
	
        arr[p.id] = item;
		p.attr(attr);
        p.hover(function(){
		          this.animate({
                   fill: '#336699' }, 200);
        bbox = this.getBBox();
		label.attr({text: paths[arr[this.id]].name}).update(bbox.x, bbox.y + bbox.height/2, bbox.width).toFront().show();
        }, function(){
            this.animate({
               fill: attr.fill,}, 450, "bounce");
		label.hide();
        })
        .click(function(){
		var state= paths[arr[this.id]].name;
	
		$.ajax({
		type: "POST",
		data: { state: state},
		 beforeSend: function() {
        $('div#replisting').hide();
		$('div#repbox').fadeIn();
        $('div#ajaxwait').fadeIn(); 
         }, 
         complete: function() {
           $('div#ajaxwait').hide(); 
         },
		dataType: "html",
		url: "getreplist.php",
		success: function(data){
		
		$('div#replisting').fadeIn(200);
		$('div#replisting').html(data);
		
		}
		});
		})
  } <?echo $ctransform;?>
 
  var replist = new Array();
  $('td#address').each(function(){
 	var lat = $(this).attr('data-lat');
 	var lon = $(this).attr('data-long'); 
	var namedata = $(this).attr('data-name');
 	var citydata = $(this).attr('data-city');
 	var phone = $(this).attr('data-phone');
 	var fax = $(this).attr('data-fax');
 	var addressdata = $(this).html();
 
 var text = namedata+ "\n" + addressdata + "\n" + citydata + "\n\n" + phone + "\n" + fax; 
 var latlon = $(this).attr('data-lat') + " | " + $(this).attr('data-long');
 var p = c.ellipse(lat,lon,4,4).attr({fill: "#336699", stroke: "#eee", 'stroke-width':1.5}); 
	p.hover(function(){
	<?if($country=="can"){echo "alert(text);";}?>;
 this.animate({
                   transform: 's3.5', fill: 'yellow', stroke: '#000', 'stroke-width': 4, }, 200);
bbox = this.getBBox();
		label.attr({text: text, 'font-size': 14, 'font-weight': 'bold', 'font-family':'Trebuchet MS'}).update(bbox.x, bbox.y + bbox.height/2, bbox.width).toFront().show(500);}, function(){
	 this.animate({
               transform: 's1.', fill: '#336699', stroke: '#eee', 'stroke-width': 1.5,
				
            }, 450, "bounce");
		label.hide(1500);
		});
	
  });
  
});
</script>
</head>

<body id="dark">
<!--TOP BAR & MENU-->
<?php include ("header-float.php");?>
<!-- END TOP and MENU-->

	<!--PAGE WRAPPER BOX-->
	<div class="main_wrap">
	<!--NO BACKGROUND BOX-->    
	<div class="content-inner-design-noback"> 
    <!--BREADCRUMB LINKS and UNDERLINE-->
        <div class="full_width">
        <p class="breadcrumb"><a href="../">Home</a> / <a href="#">Resources</a> / <strong class="active-link">Find-A-Rep</strong></p>
      </div>
     
<!--MAIN CONTENT OPEN-->
 <div class="container16">

<div id="satellite"><A href='/Satellite-Rep-Finder'>CLICK FOR SATELLITE VIEW</a></div>
      	
      	<div class="f16" id="contentbox">
		
		<div id="repbanner"><img src="images/findrepbanner-<?echo $country;?>.jpg"></div>
		<button id="repbutton" class="repbutton">View Large List</button>
		
		<div id="flagbox">
			<h3>Pick a Country</h2><br>
			<div id="usa" class="flag">
			<a href="USA-Reps"><img src="images/flag-usa.png" border="0" width=90px></a>
			</div>
		
			<div id="canada" class="flag">
			<a href="Canada-Reps"><img src="images/flag-canada.png" border="0" width=90px></a>
			</div>
		</div>
		      <div id="map_canvas"></div>
		
		
 		<div id="repbox">
		<div id="closerepbox"><img src="images/closebox.png" width=48px></div>
		<div id="replisting"></div>
		<div id="ajaxwait"><img src="images/ajax-loader.gif"><br><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Please wait... Loading</p></div>
		
		</div>
		
	 <div class="f15" id="hiddenlist">
 <?php 

$i = 1;
$stagger ="";
if($country=="us"){$country = "USA";} else {$country = "Canada";};
$q2 = "SELECT name, address, city, state, country, phone, fax, website, latitude, longitude FROM customerlist WHERE country = '".$country."' ORDER BY country, state, name ";
$run = mysql_query($q2);
echo "<table class=tempparts>";
$del = mysql_fetch_array($run);
while($row = mysql_fetch_array($run)){
$stagger="";
$i++;  
$name = $row["name"];
$address= $row["address"];
$lat = $row['latitude'];
$long = $row['longitude'];
$country=$row["country"];
$state = $row["state"];
$city = $row["city"];
$phone= $row["phone"];
$fax= $row["fax"];
$website = $row["website"];
 if ($i % 2 == 0 ) {$stagger = "<tr class=stagger><td width=15%><span class=state>$state</span></td><td width=30%><span class=name>$name</span></td><td width=20% id='address' data-city='".$city."' data-lat=$lat data-long=$long data-phone='".$phone."' data-fax='".$fax."' data-name='".$name."'>$address</td><td width=20%>$phone</td></tr><tr class=stagger><td></td><td><a href=http://$website target=_blank>$website</a></td><td>$city</td><td>$fax</td></tr>";}
else {$stagger = "<tr><td width=15%><span class=state>$state</span></td><td width=30%><span class=name>$name</span></td><td width=20% id='address' data-lat=$lat data-phone='".$phone."' data-fax='".$fax."' data-city='".$city."' data-long=$long data-name='".$name."'>$address</td><td width=20%>$phone</td></tr>
<tr><td></td><td><a href=http://$website target=_blank>$website</a></td><td>$city</td><td>$fax</td></tr>";}
echo $stagger;}
echo "</table>";
?>

 </div>
 
		
		
	    <div id="map"></div>
		
		
	

	</div>
    </div>
    
  
		
    </div>
	</div>
	





    
<!--FOOTER-->     
<?php include ("footer.php");?>

<!--END PAGE-->
</body>
</html>
   