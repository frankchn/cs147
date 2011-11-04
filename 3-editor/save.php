<?php

$ROOT_PREFIX = '../';
require($ROOT_PREFIX.'inc/config.inc.php');
require($ROOT_PREFIX.'inc/function.inc.php');

$data = json_decode($_POST['objects']);
$session_info['config_info']['room_config'] = ($data);
update_config_info();

printf('../4-checkout/choose.php');


?>