<?php

$ROOT_PREFIX = '../';
require($ROOT_PREFIX.'inc/config.inc.php');
require($ROOT_PREFIX.'inc/function.inc.php');

if(isset($_GET['store']) && $_GET['store'] == 1) {
	die('<script>window.location = "../canvas/index.php";</script>');	
}

$objects = object_to_array($session_info['config_info']['room_config']);


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
<div data-role="page" data-theme="e">  
<?php 
generate_header('Buy', '<a data-ajax="false" data-transition="slideup" href="javascript:history.go(-1)" data-icon="arrow-l">Cancel</a>'); 
?>
	<div data-role="content">
	  <ul data-role="listview">
	  <?php
	  foreach($objects as $k => $v) {
	    if(isset($v['name'])) {
	    ?>
	    <li><?php echo $v['name']; ?> <span class="ui-li-count">$ <?php echo round($v['price'] ,2) ?></span></li>
	  <?php
	    }
	  }
	  ?>
	  </ul>
        <div data-role="fieldcontain">
        	<button onClick="window.location='checkout.php'" data-theme="b">Buy Items Online</button>
        	<button onClick="window.location='locations.php'" data-theme="b">View Store Locations</button>
        </div>
	</div> 
</div> 
</body>
</html>
