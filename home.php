<?php

$ROOT_PREFIX = '';
require($ROOT_PREFIX.'inc/config.inc.php');
require($ROOT_PREFIX.'inc/function.inc.php');

// --------------------------

if(isset($_GET['longitude']) || isset($_GET['latitude'])) {
  $loc['longitude'] = (double)$_GET['longitude'];
  $loc['latitude']  = (double)$_GET['latitude'];

  $z = serialize($loc);

  // HACK HACK HACK
  // we also check here and update the school - now we just assume stanford
  $school_id = 1;
  mysql_query('UPDATE `sessions` SET `geolocation` = \''.serialize($loc).'\', `school_id` = '.$school_id.' WHERE `id` = '.$session_info['id']);

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

<body data-theme="e">
<div data-role="page" data-theme="e">  
    <?php generate_header(); ?>
    <div data-role="content" data-theme="e">
      <ul data-role="listview" data-theme="e">
	  <li><a href="1-dormroom/pick.php">Dorm Room</a></li>
	  <?php if(isset($session_info['config_info']['dorm_id']) && isset($session_info['config_info']['style_id'])) { ?>
	  <li><a data-ajax="false" href="3-editor/index.php">Decorate</a></li>        
	  <li><a href="4-checkout/choose.php">Checkout</a></li>
	  <?php } ?>
	  <li><a href="help.php">Help</a></li>
      </ul>
    </div> 
</div> 
</body>
</html>
