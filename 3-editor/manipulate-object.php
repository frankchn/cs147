<?php

$ROOT_PREFIX = '../';

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

</head>

<body>
<div data-role="page" data-theme="e">
	
		<div data-role="header" data-theme="e">
			<h1>Manipulate Object</h1>

		</div>

		<div data-role="content" data-theme="e">
			&nbsp;<br>
			<a href="delete.php?k=<?php echo $_GET['k']; ?>" data-role="button" data-ajax="false" data-theme="e">Delete</a>       
		</div>
	</div>
</body>
</html>