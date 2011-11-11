<?php

$ROOT_PREFIX = '../';
require($ROOT_PREFIX.'inc/config.inc.php');
require($ROOT_PREFIX.'inc/function.inc.php');
require("dbinfo.php");

if(isset($_GET['store']) && $_GET['store'] == 1) {
	die('<script>window.location = "../canvas/index.php";</script>');	
}
// Opens a connection to a MySQL server
$connection=mysql_connect ('localhost', $username, $password);
if (!$connection) {
  die('Not connected : ' . mysql_error());
}

// Set the active MySQL database
$db_selected = mysql_select_db($database, $connection);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
}

$store = $_POST["store"];

$query = sprintf("SELECT name, address FROM addresses WHERE id = $store;");
$result = mysql_query($query);
if (!$result) {
  die('Invalid query: ' . mysql_error());
}
$row = @mysql_fetch_assoc($result);
$store_choice = $row['name'];
$address = $row['address'];
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
<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="UTF-8">
    <link href="style.css" rel="stylesheet" type="text/css">
    <style type="text/css">
      #directions-panel {
        height: 100%;
        float: right;
        width: 390px;
        overflow: auto;
      }

      #map-canvas {
        margin-right: 400px;
      }

      #control {
        background: #fff;
        padding: 5px;
        font-size: 14px;
        font-family: Arial;
        border: 1px solid #ccc;
        box-shadow: 0 2px 2px rgba(33, 33, 33, 0.4);
        display: none;
      }

      @media print {
        #map-canvas {
          height: 500px;
          margin: 0;
        }

        #directions-panel {
          float: none;
          width: auto;
        }
      }
    </style>
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=true"></script>
    <script type="text/javascript">
      var directionDisplay;
      var directionsService = new google.maps.DirectionsService();

      function initialize() {
        directionsDisplay = new google.maps.DirectionsRenderer();
	var map;
        var myOptions = {
          zoom: 7,
          mapTypeId: google.maps.MapTypeId.ROADMAP,
          center: new google.maps.LatLng(41.850033, -87.6500523)
        };
        map = new google.maps.Map(document.getElementById('map_canvas'), myOptions);

        directionsDisplay.setMap(map);
        directionsDisplay.setPanel(document.getElementById('directions-panel'));

        var control = document.getElementById('control');
        control.style.display = 'block';
        map.controls[google.maps.ControlPosition.TOP].push(control);
      }

      function calcRoute() {
        //var start = document.getElementById('start').value;
	var start = 'Stanford, CA';
        var end = document.getElementById('end').value;
        var request = {
          origin: start,
          destination: end,
          travelMode: google.maps.DirectionsTravelMode.DRIVING
        };
        directionsService.route(request, function(response, status) {
          if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
          }
        });
      }

      google.maps.event.addDomListener(window, 'load', initialize);
    </script>
</head>

<body>
<div data-role="page" data-theme="e">  
<?php 
generate_header('Buy From Store', '<a data-ajax="false" data-transition="slideup" href="javascript:history.go(-1)" data-icon="arrow-l">Cancel</a>'); 
?>
	<div data-role="content">
        <div data-role="fieldcontain">
		Congratulations!  You have chosen to purchase your items at <br><br>
		<b><?php echo $store_choice; ?></b><br><br>
		which is located at <br><br>
		<b><?php echo $address; ?></b><br>
        </div>
</div>
<div id="control">
      <strong>Start:</strong>
      <select id="start" onchange="calcRoute();">
        <option value="Stanford, CA">Stanford</option>
      </select>
      <strong>End:</strong>
      <select id="end" onchange="calcRoute();">
        <option value="<?php echo $address; ?>"><?php echo $store_choice; ?></option>
      </select>
    </div>
    <div id="directions-panel"></div>
    <div id="map_canvas"></div>
</div> 
</body>
</html>
