<?php

$ROOT_PREFIX = '../';
require($ROOT_PREFIX.'inc/config.inc.php');
require($ROOT_PREFIX.'inc/function.inc.php');

$data = json_decode($_POST['objects']);
$_SESSION['objects'] = $data;

printf('../4-checkout/checkout.php');


?>