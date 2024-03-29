<?php

$ROOT_PREFIX = '../';
require($ROOT_PREFIX.'inc/config.inc.php');
require($ROOT_PREFIX.'inc/function.inc.php');

$i = -1;
$objects = array();

if(!isset($session_info['config_info']['room_config'])) {
  $obj_r = mysql_query("SELECT * FROM `objects` WHERE `style_id` = ".$session_info['config_info']['style_id']);
  $objects = array();
  $i = 0;
  while($obj = mysql_fetch_assoc($obj_r)) {
    $objects[$i] = array();
    $objects[$i]['name'] = $obj['name'];
    $objects[$i]['graphic'] = unserialize($obj['graphic']);
    $objects[$i]['position'] = unserialize($obj['position']);
    $objects[$i]['size'] = unserialize($obj['size']);
    
    $i++;
  }

  for($i = 0; $i < count($objects); $i++) {
    $objects[$i]['collide'] = false;
    $objects[$i]['selected'] = false;
    $objects[$i]['rotation'] = 0;
  }
} else {
  $objects = $session_info['config_info']['room_config'];
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
<script type="text/javascript">
 
var can;
var ctx;
var canX;
var canY;
var mouseIsDown = 0;
var selectMoveIndex = -1;
var waitingForSecond = -1;
var selectIndex = -1;

var loadedImages = 0;
var loadedImgObjs = [];
var objects = <?php echo json_encode($objects); ?>;

function init() {
    can = document.getElementById("can");
    ctx = can.getContext("2d");

    can.addEventListener("touchstart", touchDown, false);
    can.addEventListener("touchmove", touchXY, true);
    can.addEventListener("touchend", touchUp, false); 
 
    can.addEventListener("gesturestart", gestureStart, false);
    can.addEventListener("gesturechange", gestureXY, true);
    can.addEventListener("gestureend", gestureEnd, false); 

    document.body.addEventListener("touchcancel", touchUp, false);
	
    loadImages();
}

function gestureStart(e) {
  
}

function gestureXY(e) {
  if(selectMoveIndex == -1) return;

  objects[selectMoveIndex]['rotation'] = (objects[selectMoveIndex]['rotation'] + e.rotation) % 360;

  drawObjects();
}

function gestureEnd(e) {
	$.post('save.php', { objects: JSON.stringify(objects) }, function(data) { });
}

function loadImages() {
	for(i = 0; i < objects.length; i++) {
		loadedImgObjs[i] = new Array();
		for(j = 0; j < objects[i]['graphic'].length; j++) {
			loadedImgObjs[i][j] = new Image();
			loadedImgObjs[i][j].onload = function() {
				if(++loadedImages >= objects.length)
					drawObjects();
			}
			loadedImgObjs[i][j].src = objects[i]['graphic'][0];
		}
	}
}

function drawObjects() {
	ctx.clearRect(0,0, can.width,can.height);
	
	for(i = 0; i < objects.length; i++) {
		ctx.drawImage(loadedImgObjs[i][0], 
			      objects[i]['position']['x'], 
			      objects[i]['position']['y'], 
			      objects[i]['size']['width'], 
			      objects[i]['size']['height']);

		if(objects[i]['collide']) {		
			ctx.fillStyle = 'rgba(255, 0, 0, 0.5)';
			ctx.fillRect(objects[i]['position']['x'], 
				     objects[i]['position']['y'], 
				     objects[i]['size']['width'], 
				     objects[i]['size']['height']);
		}
		if(objects[i]['selected']) {		
			ctx.fillStyle = 'rgba(255, 0, 255, 0.5)';
			ctx.fillRect(objects[i]['position']['x'], 
				     objects[i]['position']['y'], 
				     objects[i]['size']['width'], 
				     objects[i]['size']['height']);
		}	
	}
}

function touchUp(e) {
	selectMoveIndex = -1;
	checkCollide();
	drawObjects();
	
	$.post('save.php', { objects: JSON.stringify(objects) }, function(data) { });	
}
 
function touchDown(e) {
    e.preventDefault();

    if(e.targetTouches.length == 1) {

      // translation

      canX = e.targetTouches[0].pageX - can.offsetLeft;
      canY = e.targetTouches[0].pageY - can.offsetTop;
      
      for(i = 0; i < objects.length; i++) {
	      if(objects[i]['position']['x'] <= canX && objects[i]['position']['x'] + objects[i]['size']['width'] >= canX &&
		  objects[i]['position']['y'] <= canY && objects[i]['position']['y'] + objects[i]['size']['height'] >= canY) {
			  newselectMoveIndex = i;
	      }
	  objects[i]['selected'] = false;		
      }

      objects[newselectMoveIndex]['selected'] = true;	
      selectIndex = newselectMoveIndex;
      
      if(waitingForSecond == -1) {
	      waitingForSecond = 	newselectMoveIndex;
	      setTimeout('clearSecond()', 400);
      } else if(waitingForSecond == newselectMoveIndex) {
	      $('#manipulate_object').click();
	      clearSecond();	
      } else {
	      clearSecond();	
      }
      
      selectMoveIndex = newselectMoveIndex;

    } else {

      // rotation, we don't need to do anything

    }
    
    drawObjects();
}
 
function clearSecond() {
	waitingForSecond = -1;
}

function touchXY(e) {
    if (!e) var e = event;
    e.preventDefault();	
    if(selectMoveIndex == -1) return;

    if(e.targetTouches.length == 1) {

      // translation

      var newcanX = e.targetTouches[0].pageX - can.offsetLeft;
      var newcanY = e.targetTouches[0].pageY - can.offsetTop;
	  
      var deltaX = newcanX - canX;
      var deltaY = newcanY - canY;
      
      checkCollide();

      objects[selectMoveIndex]['position']['x'] += deltaX;
      objects[selectMoveIndex]['position']['y'] += deltaY; 
      
      canX = newcanX;
      canY = newcanY;

      drawObjects();

    } else {

    }
}

function checkCollide() {
	for(i = 0; i < objects.length; i++) {
		objects[i]['collide'] = false;
	}
	
	for(j = 0; j < objects.length; j++) {
		var collide = false;
		var obj0_x1 = objects[j]['position']['x'];
		var obj0_x2 = objects[j]['position']['x'] + objects[j]['size']['width'];
		var obj0_y1 = objects[j]['position']['y'];
		var obj0_y2 = objects[j]['position']['y'] + objects[j]['size']['height'];
		
		for(i = j + 1; i < objects.length; i++) {
			// really cheap way of checking for collisions
			var obj1_x1 = objects[i]['position']['x'];
			var obj1_x2 = objects[i]['position']['x'] + objects[i]['size']['width'];
			var obj1_y1 = objects[i]['position']['y'];
			var obj1_y2 = objects[i]['position']['y'] + objects[i]['size']['height'];
			
			if (obj0_x1 < obj1_x2 && obj0_x2 > obj1_x1 && obj0_y1 < obj1_y2 && obj0_y2 > obj1_y1) {
				objects[i]['collide'] = true;
				objects[j]['collide'] = true;
			}
		}		
	}
}

function saveConfigurationAndCheckOut() {
	$.post('save.php', { objects: JSON.stringify(objects) }, function(data) {
		window.location = data;
	});
}


$(document).ready(function () {
  init();
  setInterval('drawObjects();', 300);
});

</script>
</head>

<body>
<div data-role="page"  data-theme="e">  
<canvas id="can" width="318" height="370" style="border:1px solid white">

</canvas>
<div data-role="footer" class="ui-bar"  data-theme="e">
	<a href="add.php" data-rel="dialog" data-role="button" data-transition="slidedown" data-icon="plus">Add</a>
    <a href="javascript:saveConfigurationAndCheckOut();" data-role="button" data-transition="slidedown" data-icon="arrow-r">Checkout</a>
</div>

<div style="display:none">
	<a href="manipulate-object.php" id="manipulate_object" data-transition="slidedown" data-rel="dialog">Hidden Dialog</a>
</div>

</div> 
</body>
</html>