<?php

$ROOT_PREFIX = '../';

require($ROOT_PREFIX.'inc/config.inc.php');
require($ROOT_PREFIX.'inc/function.inc.php');

// shim to fix weird behavior
$session_info['config_info']['room_config'] = object_to_array($session_info['config_info']['room_config']);

if(isset($_GET['k'])) {
  unset( $session_info['config_info']['room_config'][(int)($_GET['k'])] );
  $session_info['config_info']['room_config'] = array_values($session_info['config_info']['room_config']);
  update_config_info();
}

header("Location: index.php");


?>