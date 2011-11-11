<?php

/* Some implicit ordering here */

$ROOT_PREFIX = '../';

$i = -1;

$objects[++$i] = array();
$objects[$i]['name']     = 'Bed';
$objects[$i]['graphic']  = array(0 => $ROOT_PREFIX.'assets/tropical/bed_0.png', 
				 1 => $ROOT_PREFIX.'assets/tropical/bed_1.png',
				 2 => $ROOT_PREFIX.'assets/tropical/bed_2.png',
				 3 => $ROOT_PREFIX.'assets/tropical/bed_3.png',
				);
$objects[$i]['position'] = array('x' => 0, 'y' => 0);
$objects[$i]['size']     = array('width' => 108, 'height' => 237);

$objects[++$i] = array();
$objects[$i]['name']     = 'Chair';
$objects[$i]['graphic']  = array(0 => $ROOT_PREFIX.'assets/tropical/chair_0.png', 
				 1 => $ROOT_PREFIX.'assets/tropical/chair_1.png',
				 2 => $ROOT_PREFIX.'assets/tropical/chair_2.png',
				 3 => $ROOT_PREFIX.'assets/tropical/chair_3.png',
				);
$objects[$i]['position'] = array('x' => 140, 'y' => 125);
$objects[$i]['size']     = array('width' => 65, 'height' => 66);

$objects[++$i] = array();
$objects[$i]['name']     = 'Desk';
$objects[$i]['graphic']  = array(0 => $ROOT_PREFIX.'assets/tropical/desk_0.png', 
				 1 => $ROOT_PREFIX.'assets/tropical/desk_1.png',
				 2 => $ROOT_PREFIX.'assets/tropical/desk_2.png',
				 3 => $ROOT_PREFIX.'assets/tropical/desk_3.png',
				);
$objects[$i]['position'] = array('x' => 206, 'y' => 80);
$objects[$i]['size']     = array('width' => 109, 'height' => 161);

$objects[++$i] = array();
$objects[$i]['name']     = 'Drawer';
$objects[$i]['graphic']  = array(0 => $ROOT_PREFIX.'assets/tropical/drawer_0.png', 
				 1 => $ROOT_PREFIX.'assets/tropical/drawer_1.png',
				 2 => $ROOT_PREFIX.'assets/tropical/drawer_2.png',
				 3 => $ROOT_PREFIX.'assets/tropical/drawer_3.png',
				);
$objects[$i]['position'] = array('x' => 206, 'y' => 0);
$objects[$i]['size']     = array('width' => 109, 'height' => 78);

$objects[++$i] = array();
$objects[$i]['name']     = 'Plant';
$objects[$i]['graphic']  = array(0 => $ROOT_PREFIX.'assets/tropical/plant_0.png',
				);
$objects[$i]['position'] = array('x' => 206, 'y' => 0);
$objects[$i]['size']     = array('width' => 109, 'height' => 78);

for($i = 0; $i < count($objects); $i++) {
	echo serialize($objects[$i]['graphic'])."\n";
}


?>