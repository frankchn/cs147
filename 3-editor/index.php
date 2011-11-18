<?php

$ROOT_PREFIX = '../';
require($ROOT_PREFIX.'inc/config.inc.php');
require($ROOT_PREFIX.'inc/function.inc.php');

$i = -1;
$objects = array();

$display_first = false;

if(!isset($session_info['config_info']['room_config']) ||
   !is_array($session_info['config_info']['room_config']) ||
    count($session_info['config_info']['room_config']) == 0) { 
  $obj_r = mysql_query("SELECT * FROM `objects` WHERE `style_id` = 1 AND `incl_default` = 1");
  $objects = array();
  $i = 0;
  while($obj = mysql_fetch_assoc($obj_r)) {
    $objects[$i] = array();
    $objects[$i]['id'] = $obj['id'];
    $objects[$i]['name'] = $obj['name'];
    $objects[$i]['graphic'] = unserialize($obj['graphic']);
    $objects[$i]['position'] = unserialize($obj['position']);
    $objects[$i]['size'] = unserialize($obj['size']);
    $objects[$i]['price'] = ($obj['price']);
    cd 
    $i++;
  }

  for($i = 0; $i < count($objects); $i++) {
    $objects[$i]['collide'] = false;
    $objects[$i]['selected'] = false;
    $objects[$i]['rotation'] = 0;
  }

  $session_info['config_info']['room_config'] = $objects;
  $display_first = true;

  update_config_info();
} else {
  $objects = object_to_array($session_info['config_info']['room_config']);
  //$display_first = true;
} 

for($i = 0; $i < count($objects); $i++) {
  $objects[$i]['selected'] = false;
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

var oldIndex = -1;
var oldX = -1;
var oldY = -1;

var loadedImages = 0;
var loadedImgObjs = [];
var objects = <?php echo json_encode($objects); ?>;

var doorObject;

var rotated_this_round = false;

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
  e.preventDefault();
  rotated_this_round = false;
}

function gestureXY(e) {
  e.preventDefault();	

  if(selectMoveIndex == -1) return;
  drawObjects();
}

function gestureEnd(e) {
  e.preventDefault();	
  
  var sz = objects[selectMoveIndex]['graphic'].length;

  if(e.rotation > 50) {
    objects[selectMoveIndex]['rotation'] = (objects[selectMoveIndex]['rotation'] + 1) % sz;
    var tmp = objects[selectMoveIndex]['size']['width'];
    objects[selectMoveIndex]['size']['width'] =  objects[selectMoveIndex]['size']['height'];
    objects[selectMoveIndex]['size']['height'] = tmp;
  }

  if(e.rotation < -50) {
    objects[selectMoveIndex]['rotation'] = (objects[selectMoveIndex]['rotation'] + sz - 1) % sz;
    var tmp = objects[selectMoveIndex]['size']['width'];
    objects[selectMoveIndex]['size']['width'] =  objects[selectMoveIndex]['size']['height'];
    objects[selectMoveIndex]['size']['height'] = tmp;
  }

  $.post('save.php', { objects: JSON.stringify(objects) }, function(data) { });
}

function loadImages() {
	doorObject = new Image();
	doorObject.src = "../assets/door.png";

	for(i = 0; i < objects.length; i++) {
		loadedImgObjs[i] = new Array();
		for(j = 0; j < objects[i]['graphic'].length; j++) {
			loadedImgObjs[i][j] = new Image();
			loadedImgObjs[i][j].onload = function() {
				if(++loadedImages >= objects.length)
					drawObjects();
			}
			loadedImgObjs[i][j].src = objects[i]['graphic'][j];
		}
	}

}

function drawObjects() {
	ctx.clearRect(0,0, can.width,can.height);
	
	ctx.drawImage(doorObject, 115, 280, 90, 100);

	for(i = 0; i < objects.length; i++) {
		obj_w = objects[i]['size']['width'];
		obj_h = objects[i]['size']['height'];

		ctx.drawImage(loadedImgObjs[i][objects[i]['rotation']], 
			      objects[i]['position']['x'], 
			      objects[i]['position']['y'], 
			      obj_w, 
			      obj_h);

		if(objects[i]['collide']) {		
			ctx.fillStyle = 'rgba(255, 0, 0, 0.5)';
			ctx.fillRect(objects[i]['position']['x'], 
				     objects[i]['position']['y'], 
				     obj_w, 
				     obj_h);
		}
		if(objects[i]['selected']) {		
			ctx.fillStyle = 'rgba(255, 0, 255, 0.5)';
			ctx.fillRect(objects[i]['position']['x'], 
				     objects[i]['position']['y'], 
				     obj_w, 
				     obj_h);
		}	
	}
}

function touchUp(e) {
	checkCollide();
	drawObjects();
	
	$.post('save.php', { objects: JSON.stringify(objects) }, function(data) { });	
}
 
function touchDown(e) {

    if(e.targetTouches.length == 1) {

      // translation

    e.preventDefault();

      canX = e.targetTouches[0].pageX - can.offsetLeft;
      canY = e.targetTouches[0].pageY - can.offsetTop;
      
      var newselectMoveIndex = -1;

      for(i = 0; i < objects.length; i++) {
	      if(objects[i]['position']['x'] <= canX && objects[i]['position']['x'] + objects[i]['size']['width'] >= canX &&
		  objects[i]['position']['y'] <= canY && objects[i]['position']['y'] + objects[i]['size']['height'] >= canY) {
			  newselectMoveIndex = i;
	      }
	  objects[i]['selected'] = false;		
      }

      if(newselectMoveIndex == -1) {
	newselectMoveIndex = -1;
	selectIndex = -1;
	selectMoveIndex = -1;
	return;
      }

      oldIndex = selectMoveIndex;
      oldX = canX;
      oldY = canY;

      objects[newselectMoveIndex]['selected'] = true;	
      selectIndex = newselectMoveIndex;
      
      if(waitingForSecond == -1) {
	waitingForSecond = newselectMoveIndex;
	setTimeout('clearSecond()', 400);
      } else if(waitingForSecond == newselectMoveIndex) {
	$('#manipulate_object').attr('href', 'manipulate-object.php?k=' + newselectMoveIndex);
	$('#manipulate_object').click();
	clearSecond();	
      } else {
	clearSecond();	
      }
      
      selectMoveIndex = newselectMoveIndex;

    } 
    
    drawObjects();
}
 
function clearSecond() {
	waitingForSecond = -1;
}

function touchXY(e) {
    if (!e) var e = event;
    if(selectMoveIndex == -1) return;

    if(e.targetTouches.length == 1) {

    e.preventDefault();	

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

function deleteSelectedObject() {
  if(selectMoveIndex > -1) {
    window.location = 'delete.php?k=' + selectMoveIndex;
  }
}

function rotateObject() {
  if(selectMoveIndex != -1) {
    var sz = objects[selectMoveIndex]['graphic'].length;

    objects[selectMoveIndex]['rotation'] = (objects[selectMoveIndex]['rotation'] + 1) % sz;
    var tmp = objects[selectMoveIndex]['size']['width'];
    objects[selectMoveIndex]['size']['width'] =  objects[selectMoveIndex]['size']['height'];
    objects[selectMoveIndex]['size']['height'] = tmp;

    $.post('save.php', { objects: JSON.stringify(objects) }, function(data) { });    
  }
}

function undoConfiguration() {
  if(oldIndex > -1) {
    objects[oldIndex]['position']['x'] = oldX;
    objects[oldIndex]['position']['y'] = oldY;
    drawObjects();
  }
}

function lightUp(int icon){
	switch(icon){
	case 0:
		Document.getElementById("arrow").src="../images/left2.png";
		alert("changed item");
		setTimeout("Document.getElementById('arrow').src='../images/left.png'", 500);
		break;
	case 1:
		Document.getElementById("arrow").src="../images/add2.png";
		alert("changed item");
		setTimeout("Document.getElementById('arrow').src='../images/add.png'", 500);
		break;
	case 2:
		Document.getElementById("arrow").src="../images/arrow2.png";
		alert("changed item");
		setTimeout("Document.getElementById('arrow').src='../images/arrow.png'", 500);
		break;
	case 3:
		Document.getElementById("arrow").src="../images/rotate2.png";
		alert("changed item");
		setTimeout("Document.getElementById('arrow').src='../images/rotate.png'", 500);
		break;
	case 4:
		Document.getElementById("arrow").src="../images/checkout2.png";
		alert("changed item");
		setTimeout("Document.getElementById('arrow').src='../images/checkout.png'", 500);
		break;
	}
}

$(document).ready(function () {
  loadImages();
  init();
  setInterval('drawObjects();', 300);
  <?php
   if($display_first) {
  ?>
    $('#process').click();
  <?php
    }
  ?>
});

</script>
</head>

<body>
<div data-role="page"  data-theme="e">  

<div data-role="header" class="ui-bar"  data-theme="e">
  <div class="ui-grid-d">
    <a class="ui-block-a" data-transition="slideup" href="../1-dormroom/pick.php" data-icon="arrow-l"><img id="arrow" border="0" src="../images/arrow.png" onclick="lightUp(0)" /></a>
    <a class="ui-block-b" href="add.php"><img id="add" border="0" src="../images/add.png" onclick="lightUp(1)" /></a>
    
    <a class="ui-block-c" href="javascript:deleteSelectedObject()"><img id="trash" src="../images/trash.png" onclick="lightUp(2)" /></a>
    <a class="ui-block-d" href="javascript:rotateObject()"><img id="rotate" border="0" src="../images/rotate.png" onclick="lightUp(3)" /></a>
    
    <a class="ui-block-e" href="javascript:saveConfigurationAndCheckOut();"><img id="checkout" border="0" src="../images/checkout.png" onclick="lightUp(4)" /></a>
  </div>
</div>

<canvas id="can" width="318" height="375" style="border:1px solid white">

</canvas>


<div style="display:none">
    <a href="manipulate-object.php" id="manipulate_object" data-transition="slidedown" data-rel="dialog">Hidden Dialog</a>
</div>

<div style="display:none">
    <a href="help.php" id="process" data-transition="slidedown" data-rel="dialog">Help</a>
</div>

</div> 
</body>
</html>