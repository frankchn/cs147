<?php

$ROOT_PREFIX = '';
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
<?php 
generate_header('Help', '<a href="home.php" data-icon="delete">Back</a>', ''); 
?> 
	<div data-role="content">
	<p>Confused? Here's what you need to know:</p>
        
        <p>In the Decorate Your Room page, tap and drag items to move them around. Double-tap items to modify them, hit add to add items (not implemented yet), and hit checkout to find these items online.</p>
        
        <p>On the Checkout page, decide whether you want to find these items online or find them in-stores.</p>
        
        
	</div> 
</div> 
</body>
</html>
