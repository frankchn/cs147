<?php

$ROOT_PREFIX = '../';
require($ROOT_PREFIX.'inc/config.inc.php');
require($ROOT_PREFIX.'inc/function.inc.php');
//require("dbinfo.php");

if(!isset($_POST['store'])) {
  die("Sorry, please select a store first.");
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
		<b><?php echo $address; ?></b><br><br>
	<a href="directions.php?store_id=<?php echo $store; ?>" data-ajax="false">See directions!</a></br>

        </div>
</div>
</body>
</html>
