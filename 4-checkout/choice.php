<?php

$ROOT_PREFIX = '../';
require($ROOT_PREFIX.'inc/config.inc.php');
require($ROOT_PREFIX.'inc/function.inc.php');
//require("dbinfo.php");

if(isset($_POST['store'])) {
  $store = $_POST["store"];
}

if(isset($_GET['getoption'])) {
  $store = $_GET['getoption'];
}

$objects = object_to_array($session_info['config_info']['room_config']);

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
   
</head>

<body>
<div data-role="page" data-theme="e">  
<?php 
generate_header('Buy From Store', '<a data-ajax="false" href="locations.php" data-icon="arrow-l">Cancel</a>'); 
?>
	<div data-role="content">
        <div data-role="fieldcontain">
		Congratulations!  You have chosen to purchase your items (<?php
$i=0;
foreach($objects as $k => $v) {
	echo $v["name"];
	if ($i != count($objects)-1) echo ", ";
	$i++;
}
?>
) at <br><br>
		<b><?php echo $store_choice; ?></b><br><br>
		which is located at <br><br>
		<b><?php echo $address; ?></b><br><br>
	<div style="text-align:center"><a href="directions.php?store_id=<?php echo $store; ?>" data-ajax="false">See directions!</a></div>

        </div>
</div>
</body>
</html>
