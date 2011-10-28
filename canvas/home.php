<?php

$ROOT_PREFIX = '../';
require($ROOT_PREFIX.'inc/config.inc.php');
require($ROOT_PREFIX.'inc/function.inc.php');

if(isset($_GET['store']) && $_GET['store'] == 1) {
	die('<script>window.location = "../canvas/index.php";</script>');	
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
</head>

<body>
<div data-role="page">  
    <div data-role="header"> 
        <h1>DORM DECOR</h1> 
    </div> 
	<div data-role="content">
    <ul data-role="listview" data-theme="g">
		<li><a href="index.php">Decorate your room</a></li>
		<li><a href="style.php">Pick a style</a></li>
		<li><a href="../checkout/choose.php">Checkout</a></li>
        <li><a href="help.php">Help</a></li>
	</ul>
        
	</div> 
</div> 
</body>
</html>
