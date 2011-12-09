<?php

$ROOT_PREFIX = '../';

require($ROOT_PREFIX.'inc/config.inc.php');
require($ROOT_PREFIX.'inc/function.inc.php');

// shim to fix weird behavior
$session_info['config_info']['room_config'] = object_to_array($session_info['config_info']['room_config']);

if(isset($_GET['id'])) {

  $r = mysql_fetch_assoc(mysql_query('SELECT * FROM `objects` WHERE `id` = '.((int)$_GET['id'])));
  
  $x = count($session_info['config_info']['room_config']);

  $session_info['config_info']['room_config'][$x] = $r;
  $session_info['config_info']['room_config'][$x]['graphic'] = unserialize($session_info['config_info']['room_config'][$x]['graphic']);
  $session_info['config_info']['room_config'][$x]['position'] = unserialize($session_info['config_info']['room_config'][$x]['position']);
  $session_info['config_info']['room_config'][$x]['size'] = unserialize($session_info['config_info']['room_config'][$x]['size']);

  $session_info['config_info']['room_config'][$x]['collide'] = false;
  $session_info['config_info']['room_config'][$x]['selected'] = false;
  $session_info['config_info']['room_config'][$x]['rotation'] = 0;

  update_config_info();

  header("Location: index.php");
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
<div data-role="page"  data-theme="e">
<?php 
generate_header('Add Object', '<a data-ajax="false" data-transition="slideup" href="index.php" data-icon="delete">Cancel</a>'); 
?>
    <div data-role="content" data-theme="e">
	<ul data-role="listview">
	    <?php
	      $s = "";
	      $c = 0;
	      $r = mysql_query('SELECT * FROM `objects` ORDER BY `style_id` ASC');
	      while($o = mysql_fetch_assoc($r)) {
		$already_in = false;
		$v = mysql_fetch_assoc(mysql_query('SELECT * FROM `styles` WHERE `id` = '.$o['style_id']));
	        $current_type = $v['name'];
		if($current_type != $s) {
		    printf("<li data-role='list-divider'>%s</li>", $current_type);
		    $s = $current_type;
		}
	    ?>
	    <li><a data-ajax="false" href="add.php?id=<?php echo $o['id']; ?>">
		    <img src="<?php echo $o['thumbnail'] ?>" />
		    <h3><?php echo $o['name']; ?></h3>
		    <p><?php echo $o['short_desc']; ?></p>
	    </a></li>
	    <?php
	      }
	    ?>
	</ul>
    </div>
</div>
</body>
</html>
