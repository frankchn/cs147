<?php

$ROOT_PREFIX = '';
require($ROOT_PREFIX.'inc/config.inc.php');
require($ROOT_PREFIX.'inc/function.inc.php');

// --------------------------

if(isset($_GET['longitude']) || isset($_GET['latitude'])) {
  $loc['longitude'] = (double)$_GET['longitude'];
  $loc['latitude']  = (double)$_GET['latitude'];

  $z = serialize($loc);

  // HACK HACK HACK
  // we also check here and update the school - now we just assume stanford
  $school_id = 1;
  mysql_query('UPDATE `sessions` SET `geolocation` = \''.serialize($loc).'\', `school_id` = '.$school_id.' WHERE `id` = '.$session_info['id']);
}

mysql_query('UPDATE `sessions` SET `school_id` = '.$school_id.' WHERE `id` = '.$session_info['id']);
$session_info['school_id'] = 1;

update_config_info();

header("Location: 1-dormroom/test.php");

die();


?>