<?php

/* Some implicit ordering here */

$objects[++$i] = array();
$objects[$i]['name']     = 'Bed';
$objects[$i]['graphic']  = $ROOT_PREFIX.'assets/development/bed.png';
$objects[$i]['position'] = array('x' => 0, 'y' => 0);
$objects[$i]['size']     = array('width' => 108, 'height' => 237);
$objects[$i]['collide']  = false;

$objects[++$i] = array();
$objects[$i]['name']     = 'Chair';
$objects[$i]['graphic']  = $ROOT_PREFIX.'assets/development/chair.png';
$objects[$i]['position'] = array('x' => 140, 'y' => 125);
$objects[$i]['size']     = array('width' => 65, 'height' => 66);
$objects[$i]['collide']  = false;

$objects[++$i] = array();
$objects[$i]['name']     = 'Closet';
$objects[$i]['graphic']  = $ROOT_PREFIX.'assets/development/closet.png';
$objects[$i]['position'] = array('x' => 0, 'y' => 240);
$objects[$i]['size']     = array('width' => 107, 'height' => 131);
$objects[$i]['collide']  = false;

$objects[++$i] = array();
$objects[$i]['name']     = 'Desk';
$objects[$i]['graphic']  = $ROOT_PREFIX.'assets/development/desk.png';
$objects[$i]['position'] = array('x' => 206, 'y' => 80);
$objects[$i]['size']     = array('width' => 109, 'height' => 161);
$objects[$i]['collide']  = false;

$objects[++$i] = array();
$objects[$i]['name']     = 'Drawer';
$objects[$i]['graphic']  = $ROOT_PREFIX.'assets/development/drawer.png';
$objects[$i]['position'] = array('x' => 206, 'y' => 0);
$objects[$i]['size']     = array('width' => 109, 'height' => 78);
$objects[$i]['collide']  = false;


?>