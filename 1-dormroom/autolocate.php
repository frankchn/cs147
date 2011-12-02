<!DOCTYPE html>
<html>
<head>

<title>MapLocation</title>

<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.0rc2/jquery.mobile-1.0rc2.min.css" />
<script src="http://code.jquery.com/jquery-1.6.4.min.js"></script>
<script src="http://code.jquery.com/mobile/1.0rc2/jquery.mobile-1.0rc2.min.js"></script>

<style type="text/css">
  html { height: 100% }
  body { height: 100%; margin: 0; padding: 0 }
  #map_canvas { height: 300px }
</style>

<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=true"></script>
<script type="text/javascript" src="map.js"></script>
</head>
<body onload="initialize()">
<div data-role="page" data-theme="e">  

  <div data-role="content">
  <div id="map_canvas" style="width:290px; height:300px"></div>
	<input type="button" value="Find My Dorm!" onclick="reverseGeocode()">
  </div>
</div>
</body>

</html>