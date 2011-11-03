<?php

/* Some implicit ordering here */

$objects[++$i] = array();
$objects[$i]['name']     = 'Bed';
$objects[$i]['graphic']  = array(0 => $ROOT_PREFIX.'assets/devstyle/bed.png');
$objects[$i]['position'] = array('x' => 0, 'y' => 0);
$objects[$i]['size']     = array('width' => 108, 'height' => 237);

$objects[++$i] = array();
$objects[$i]['name']     = 'Chair';
$objects[$i]['graphic']  = array(0 => $ROOT_PREFIX.'assets/devstyle/chair.png');
$objects[$i]['position'] = array('x' => 140, 'y' => 125);
$objects[$i]['size']     = array('width' => 65, 'height' => 66);

$objects[++$i] = array();
$objects[$i]['name']     = 'Closet';
$objects[$i]['graphic']  = array(0 => $ROOT_PREFIX.'assets/devstyle/closet.png');
$objects[$i]['position'] = array('x' => 0, 'y' => 240);
$objects[$i]['size']     = array('width' => 107, 'height' => 131);

$objects[++$i] = array();
$objects[$i]['name']     = 'Desk';
$objects[$i]['graphic']  = array(0 => $ROOT_PREFIX.'assets/devstyle/desk.png');
$objects[$i]['position'] = array('x' => 206, 'y' => 80);
$objects[$i]['size']     = array('width' => 109, 'height' => 161);

$objects[++$i] = array();
$objects[$i]['name']     = 'Drawer';
$objects[$i]['graphic']  = array(0 => $ROOT_PREFIX.'assets/devstyle/drawer.png');
$objects[$i]['position'] = array('x' => 206, 'y' => 0);
$objects[$i]['size']     = array('width' => 109, 'height' => 78);

for($i = 0; $i < count($objects); $i++) {
	$objects[$i]['collide'] = false;
	$objects[$i]['selected'] = false;
	$objects[$i]['rotation'] = 0;
}


?>