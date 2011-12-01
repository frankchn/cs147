<?php
header("Content-type: text/xml");
require("dbinfo.php");

function parseToXML($htmlStr) 
{ 
$xmlStr=str_replace('<','&lt;',$htmlStr); 
$xmlStr=str_replace('>','&gt;',$xmlStr); 
$xmlStr=str_replace('"','&quot;',$xmlStr); 
$xmlStr=str_replace("'",'&#39;',$xmlStr); 
$xmlStr=str_replace("&",'&amp;',$xmlStr); 
return $xmlStr; 
} 

// Get parameters from URL
$center_lat = $_GET["lat"];
$center_lng = $_GET["lng"];
$radius = $_GET["radius"];
$items = array("bed"=>false, "chair"=>false, "drawer"=>false, "desk"=>false, "plant"=>false);
$items["bed"] = $_GET["bed"];
$items["chair"] = $_GET["chair"];
$items["drawer"] = $_GET["drawer"];
$items["desk"] = $_GET["desk"];
$items["plant"] = $_GET["plant"];

$required_items = array();
foreach ($items as $item => $presence) {
	if ($presence == true) {
		$required_items[] = $item;
	}
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

// Select all the rows in the markers table
$query = sprintf("SELECT id, address, name, lat, lng, bed, chair, drawer, desk, plant, ( 3959 * acos( cos( radians('%s') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('%s') ) + sin( radians('%s') ) * sin( radians( lat ) ) ) ) AS distance FROM addresses",
  mysql_real_escape_string($center_lat),
  mysql_real_escape_string($center_lng),
  mysql_real_escape_string($center_lat));

if (!empty($required_items)) {
	$query .= " WHERE ";
	$i = 0;
	foreach ($required_items as $item) {
		if ($i != 0) $query .= " AND ";
		$query .= "$item='y'";
		$i++;
	}
}

$query .= sprintf(" HAVING distance < '%s'", mysql_real_escape_string($radius));

$result = mysql_query($query);
if (!$result) {
  die('Invalid query: ' . mysql_error());
}
// Start XML file, echo parent node
echo "<markers>\n";
// Iterate through the rows, printing XML nodes for each
while ($row = @mysql_fetch_assoc($result)){
  // ADD TO XML DOCUMENT NODE
  echo '<marker ';
  echo 'name="' . parseToXML($row['name']) . '" ';
  echo 'address="' . parseToXML($row['address']) . '" ';
  echo 'lat="' . $row['lat'] . '" ';
  echo 'lng="' . $row['lng'] . '" ';
  echo 'distance="' . $row['distance'] . '" ';
  echo 'internalid="'. $row['id'] . '" ';
  echo 'bed="'. $row['bed'] . '" ';
  echo 'chair="'. $row['chair'] . '" ';
  echo 'drawer="'. $row['drawer'] . '" ';
  echo 'desk="'. $row['desk'] . '" ';
  echo 'plant="'. $row['plant'] . '" ';
  echo "/>\n";
}

// End XML file
echo "</markers>\n";

?>

