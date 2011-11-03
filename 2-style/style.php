<?php

$ROOT_PREFIX = '../';
require($ROOT_PREFIX.'inc/config.inc.php');
require($ROOT_PREFIX.'inc/function.inc.php');

if(isset($_GET['store']) && $_GET['store'] == 1) {
	die('<script>window.location = "../3-editor/index.php";</script>');	
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
      <div data-role="fieldcontain">
	  <fieldset data-role="controlgroup">
	      <input type="radio" name="style" id="contemp" value="contemporary" checked="checked" />
		      <label for="contemp">Contemporary</label>
	      <input type="radio" name="style" id="modern" value="modern"/>
		      <label for="modern">Modern</label>
	      <input type="radio" name="style" id="art" value="art"/>
		      <label for="art">Art Deco</label>
		<input type="radio" name="style" id="tropical" value="tropical"/>
		      <label for="tropical">Tropical</label>
		<input type="radio" name="style" id="retro" value="retro"/>
		      <label for="retro">Retro</label>
		<input type="radio" name="style" id="med" value="med"/>
		      <label for="med">Mediterranean</label>
	  </fieldset>
      </div>
      </form>
    </div> 
</div> 
</body>
</html>
