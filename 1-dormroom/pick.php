<?php

$ROOT_PREFIX = '../';
require($ROOT_PREFIX.'inc/config.inc.php');
require($ROOT_PREFIX.'inc/function.inc.php');

$x = array();
$r = mysql_query('SELECT * FROM `rooms` ORDER BY `dorm_id` ASC');
while($w = mysql_fetch_assoc($r)) {
  $x[] = $w;
}

if(isset($_GET['store']) && $_GET['store'] == 1) {
  $session_info['config_info']['dorm_id'] = (int)$_POST['dorm'];
  $session_info['config_info']['room_type'] = (int)$_POST['room'];

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
generate_header('Dorm Location', '<a href="../home.php" data-icon="delete">Cancel</a>',
		'<a href="#" onClick="document.getElementById(\'manualform\').submit()" data-icon="check">Save</a>'); 
?>
    <div data-role="content">
      <form method="post" id="manualform" action="pick.php?store=1" data-ajax="false">
      <div data-role="fieldcontain">
	  <label for="dorm">Dorm Name</label>
	  <select onchange="gorefresh()" name="dorm" id="dorm-select">
	    <?php
	      $r = mysql_query('SELECT * FROM `dorms` WHERE `school_id` = '.$session_info['school_id']);
	      while($q = mysql_fetch_assoc($r)) {
	    ?>
	      <option <?php if(isset($_GET['d']) && $_GET['d'] == $q['id']) echo 'selected="selected"'; ?> value="<?php echo $q['id']; ?>"><?php echo $q['dorm_name']; ?></option>
	    <?php
	      }
	    ?>
	  </select>
      </div>        
      <div data-role="fieldcontain">
	  <label for="name">Room Type:</label>
	  <select name="room" id="room-select">

	  </select>
      </div>	
      </form>
    </div> 
</div> 
<script language="javascript">

// stupid fix 
function gorefresh() {
  dorm_id = document.getElementById("dorm-select").options[document.getElementById("dorm-select").selectedIndex].value;
  window.location = 'pick.php?d=' + dorm_id;
}

var dormoptions = <?php echo json_encode($x); ?>;

function gochangeoptions() {
  dorm_id = document.getElementById("dorm-select").options[document.getElementById("dorm-select").selectedIndex].value;

  while(document.getElementById('room-select').length > 0) document.getElementById('room-select').remove(0);
  for(i = 0; i < dormoptions.length; i++) {
    if(dormoptions[i]['dorm_id'] == dorm_id) {
      var o = document.createElement("option");
      o.text = dormoptions[i]['name'];
      o.value = dormoptions[i]['id'];
      document.getElementById('room-select').add(o);
    }
  }

  $.trigger('updatelayout');
}

$(function() {  gochangeoptions();
});

</script>
</body>
</html>