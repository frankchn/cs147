<?php

$ROOT_PREFIX = '../';
require($ROOT_PREFIX.'inc/config.inc.php');
require($ROOT_PREFIX.'inc/function.inc.php');

if(isset($_GET['store']) && $_GET['store'] == 1) {
	$session_info['config_info']['style_id'] = (int)$_POST['style'];
	update_config_info();
	header("Location: ../home.php");
	die();	
}

$objects = object_to_array($session_info['config_info']['room_config']);
$bed=0;
$chair=0;
$drawer=0;
$desk=0;
$plant=0;
foreach($objects as $k => $v) {
	$item = $v['name'];
	if ($item == 'Bed') $bed=1;
	else if ($item == 'Chair') $chair=1;
	else if ($item == 'Drawer') $drawer=1;
	else if ($item == 'Desk') $desk=1;
	else if ($item == 'Plant') $plant=1;
}

?>	

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>DormDecor</title>

<link rel="stylesheet" href="http://code.jquery.com/mobile/1.0rc2/jquery.mobile-1.0rc2.min.css" />
<script src="http://code.jquery.com/jquery-1.6.4.min.js"></script>
<script src="http://code.jquery.com/mobile/1.0rc2/jquery.mobile-1.0rc2.min.js"></script>
<meta content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" name="viewport"/>
    <script src="http://maps.google.com/maps/api/js?sensor=false"
            type="text/javascript"></script>
    <script type="text/javascript">
    //<![CDATA[
    var map;
    var markers = [];
    var infoWindow;
    var locationSelect;

    function load() {
      map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(40, -100),
        zoom: 4,
        mapTypeId: 'roadmap',
        mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU}
      });
      infoWindow = new google.maps.InfoWindow();

      locationSelect = document.getElementById("locationSelect");
      locationSelect.onchange = function() {
        var markerNum = locationSelect.options[locationSelect.selectedIndex].value;
        if (markerNum != "none"){
          google.maps.event.trigger(markers[markerNum], 'click');
        }
      };
   }

   function searchLocations() {

	$('#firstpart').fadeOut('slow', function() {
	  $('#secondpart').fadeIn('slow');
	  load();
	  var address = document.getElementById("addressInput").value;
	  var geocoder = new google.maps.Geocoder();
	  geocoder.geocode({address: address}, function(results, status) {
	    if (status == google.maps.GeocoderStatus.OK) {
	      searchLocationsNear(results[0].geometry.location);
	    } else {
	      alert(address + ' not found');
	    }
	  });
	});


   }

   function clearLocations() {
     infoWindow.close();
     for (var i = 0; i < markers.length; i++) {
       markers[i].setMap(null);
     }
     markers.length = 0;

     locationSelect.innerHTML = "";
     var option = document.createElement("option");
     option.value = "none";
     option.innerHTML = "See all results:";
     locationSelect.appendChild(option);
   }

   function searchLocationsNear(center) {
     clearLocations(); 

     var radius = document.getElementById('radiusSelect').value;
	var bed = "<?php echo $bed; ?>";
	var chair = "<?php echo $chair; ?>";
	var drawer = "<?php echo $drawer; ?>";
	var desk = "<?php echo $desk; ?>";
	var plant = "<?php echo $plant; ?>";
     var searchUrl = 'genxml.php?lat=' + center.lat() + '&lng=' + center.lng() + '&radius=' + radius + 
	       		'&bed='+bed+'&chair='+chair+'&drawer='+drawer+'&desk='+desk+'&plant='+plant;
     downloadUrl(searchUrl, function(data) {
       var xml = parseXml(data);
       var markerNodes = xml.documentElement.getElementsByTagName("marker");
       var bounds = new google.maps.LatLngBounds();
       for (var i = 0; i < markerNodes.length; i++) {
         var name = markerNodes[i].getAttribute("name");
         var address = markerNodes[i].getAttribute("address");
         var distance = parseFloat(markerNodes[i].getAttribute("distance"));
         var latlng = new google.maps.LatLng(
              parseFloat(markerNodes[i].getAttribute("lat")),
              parseFloat(markerNodes[i].getAttribute("lng")));

	 var bed = markerNodes[i].getAttribute("bed");
	 var chair = markerNodes[i].getAttribute("chair");
	 var drawer = markerNodes[i].getAttribute("drawer");
	 var desk = markerNodes[i].getAttribute("desk");
	 var plant = markerNodes[i].getAttribute("plant");
         createOption(name, distance, parseInt(markerNodes[i].getAttribute("internalid")));
         //createMarker(latlng, name, address);
         createMarker(parseInt(markerNodes[i].getAttribute("internalid")), latlng, name, address, bed, chair, drawer, desk, plant);
         bounds.extend(latlng);
       }
       map.fitBounds(bounds);
       locationSelect.style.visibility = "visible";
       locationSelect.onchange = function() {
         var markerNum = locationSelect.options[locationSelect.selectedIndex].value;
         google.maps.event.trigger(markers[markerNum], 'click');
       };
      });
    }

    function createMarker(iid, latlng, name, address, bed, chair, drawer, desk, plant) {
      var html = "<b><a href='choice.php?getoption=" + iid + "'>" + name + "</a></b> <br/>" + address;
      html += "<br/><br/><u>Items Available</u><br><font size='-1'>(<b>bold</b> = item on your shopping list)<br/></font>";
      if (bed == "y") {
	if (<?php echo "$bed"; ?>) html += "<b>Beds</b> | ";
	else html += "Beds | ";
      }
      if (chair == "y") {
	if (<?php echo "$chair"; ?>) html += "<b>Chairs</b> | ";
	else html += "Chairs | ";
      }
      if (drawer == "y") {
	if (<?php echo "$drawer"; ?>) html += "<b>Drawers</b> | ";
	else html += "Drawers | ";
      }
      if (desk == "y") {
	if (<?php echo "$desk"; ?>) html += "<b>Desks</b> | ";
	else html += "Desks | ";
      }
      if (plant == "y") {
	if (<?php echo "$plant"; ?>) html += "<b>Plants</b> | ";
	else html += "Plants | ";
      }


      var marker = new google.maps.Marker({
        map: map,
        position: latlng
      });
      google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
      });
      markers.push(marker);
    }

    function createOption(name, distance, num) {
      var option = document.createElement("option");
      option.value = num;
      option.innerHTML = name + "(" + distance.toFixed(1) + ")";
      locationSelect.appendChild(option);
    }

    function downloadUrl(url, callback) {
      var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;

      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request.responseText, request.status);
        }
      };

      request.open('GET', url, true);
      request.send(null);
    }

    function parseXml(str) {
      if (window.ActiveXObject) {
        var doc = new ActiveXObject('Microsoft.XMLDOM');
        doc.loadXML(str);
        return doc;
      } else if (window.DOMParser) {
        return (new DOMParser).parseFromString(str, 'text/xml');
      }
    }

    function doNothing() {}

    //]]>
  </script>

</head>

<body onload="load()">
<div data-role="page" data-theme="e">  
<?php 
generate_header('Store Locations', '<a href="choose.php" data-icon="back">Back</a>');
?>
    <div data-role="content">
    <div id="firstpart">
     <input type="text" value="94305" id="addressInput" size="10"/>
    <div style="float:left">
      <select id="radiusSelect" style="width:100%">
	<option value="25" selected>25mi</option>
	<option value="100">100mi</option>
	<option value="200">200mi</option>
      </select>
    </div>
    <div style="float:right">
      <input type="button" style="width:100%" onclick="searchLocations()" value="Search"/>
    </div>
    </div>
    <div id="secondpart" style="display:none">
      <div id="map" style="width: 290px; height: 350px"></div>
      <div style="display:none">
      <form id="location" method="post" action="choice.php" data-ajax="false"> 
	  <div><select id="locationSelect" value="Select your store choice" name="store"></select></div>
	  <div><input type="submit" style="width:50%" value="Choose"/></div>
      </form>
      </div>
    </div>
    </div>

</div>
</body>
</html>
