<?php

$ROOT_PREFIX = '../';

require($ROOT_PREFIX.'inc/config.inc.php');
require($ROOT_PREFIX.'inc/function.inc.php');

if(isset($_GET['submit'])) {
  $school_id = (int)$_POST['school_id'];
  mysql_query('UPDATE `sessions` SET `school_id` = '.$school_id.' WHERE `id` = '.$session_info['id']);
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
generate_header('Select School',
		'<a href="../home.php" data-icon="delete">Cancel</a>',
		'<a href="#" onClick="document.getElementById(\'manualform\').submit()" data-icon="check">Save</a>'); 
?>
  <form id="manualform" action="manual.php?submit=1" method="post" data-ajax="false"> 
    <div data-role="fieldcontain">
    <label for="school_id" class="select">
      Your School:
    </label>
    <select name="school_id" id="select-choice-1">
      <?php 
	$r = mysql_query('select * from schools');
	while($s = mysql_fetch_assoc($r)) {
       ?>
      <option value="<?php echo $s['id'] ?>"><?php echo $s['name'] ?></option>
      <?php
	}
      ?>
    </select>    
    </div>
  </form>
</div> 
</body>
</html>