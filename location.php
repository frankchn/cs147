<?php

$ROOT_PREFIX = '';

require($ROOT_PREFIX.'inc/config.inc.php');
require($ROOT_PREFIX.'inc/function.inc.php');


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

<script language="javascript">

function successHandler(location) {
	window.location = 'home.php?longitude=' + location.coords.longitude + '&latitude=' + location.coords.latitude + '&accuracy = ' + location.coords.accuracy;
}

function errorHandler(error) {
	window.location = 'home.php';
}

window.location = 'home.php';

//navigator.geolocation.getCurrentPosition(successHandler, errorHandler);

</script>

</head>

<body>
<div data-role="page" data-theme="e">  
	<div data-role="content">
    	<img src="images/logo_large.png" />
        <hr />
        <center>Welcome to DormDecor, your one-stop shop for planning, furnishing, and decorating your college dorm room!</center>
    </div> 
</div> 
</body>
</html>
