<?php

$ROOT_PREFIX = '../';
require($ROOT_PREFIX.'inc/config.inc.php');
require($ROOT_PREFIX.'inc/function.inc.php');

if(isset($_GET['store']) && $_GET['store'] == 1) {
        $session_info['config_info']['room_config'] = array();
	$session_info['config_info']['style_id'] = (int)$_POST['style'];
	update_config_info();
	header("Location: ../home.php");
	die();	
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
<div data-role="page" data-theme="e">  
<?php 
generate_header('Pick A Style', '<a href="../home.php" data-icon="delete">Cancel</a>',
		'<a href="#" onClick="document.getElementById(\'manualform\').submit()" data-icon="check">Save</a>'); 
?>
    <div data-role="content">
      <form id="manualform" method="post" action="style.php?store=1" data-ajax="false">
	  <fieldset data-role="controlgroup">
	      <?php
	      $i = 0;
	      $s_r = mysql_query('SELECT * FROM `styles`');
	      while($s = mysql_fetch_assoc($s_r)) {
		printf('<input %s type="radio" name="style" id="a_%s" value="%s" /><label for="a_%s">%s</label>',
		       ($i == 0) ? "checked" : "",
		       $s['id'], $s['id'], $s['id'],
		       $s['name']);
		$i++;
	      }
	      ?>
	  </fieldset>
      </form>
    </div> 
</div> 
</body>
</html>
