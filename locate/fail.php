<?php

$ROOT_PREFIX = '../';
require($ROOT_PREFIX.'inc/config.inc.php');
require($ROOT_PREFIX.'inc/function.inc.php');

if(isset($_GET['store']) && $_GET['store'] == 1) {
	die('<script>window.location = "../canvas/style.php";</script>');	
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
        <h1>Dorm Location</h1> 
    </div> 
	<div data-role="content">
    	<form method="post" action="fail.php?store=1" data-ajax="false">
        <div>Sorry, we were not able to locate your dorm automatically. Please enter your dorm and dorm room manually.</div>
        <div data-role="fieldcontain">
            <label for="dorm-name">Dorm Name</label>
            <select name="dorm-name" id="dorm-name-select">
                <option value="FroSoCo">FroSoCo</option>
                <option value="Branner">Branner</option>
                <option value="Crothers Memorial">Crothers Memorial</option>
            </select>
        </div>        
        <div data-role="fieldcontain">
            <label for="name">Room Number:</label>
            <input type="number" name="room_number" id="room_number" value=""  />
        </div>	
        <div data-role="fieldcontain">
        	<button type="submit" data-theme="b" name="submit" value="submit-value">Save &amp; Continue</button>
        </div>
        </form>
	</div> 
</div> 
</body>
</html>