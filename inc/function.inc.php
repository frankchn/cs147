<?php

function generate_header($g = '', $l = '', $r = '') {
  if(!empty($g)) $g = ''.$g; else $g = 'DormDecor';
  echo('<div data-role="header" data-theme="e">'.$l.'<h3 style="text-align:center;margin-top:10px;margin-bottom:10px;">'.$g.'</h3>'.$r.'</div>');
}

function gen_random_string($length = 8) {
  $s = "";
  for($i = 0; $i < $length; $i++) {
    $s .= chr(ord('A') + mt_rand(0, 25));
  }
  return $s;
}

function gen_new_session() {
  $s_unique_id = gen_random_string(16);
  setcookie('session_key', $s_unique_id, time() + 86400 * 100, '/');
  mysql_query('INSERT INTO `sessions` (`key`, `first_visit`, `last_seen`, `config_info`) VALUES ("'.$s_unique_id.'", '.time().', '.time().', \''.serialize(array()).'\')');
}

function update_config_info() {
  global $session_info;
  $x = serialize($session_info['config_info']);
  mysql_query('UPDATE `sessions` SET `config_info` = \''.$x.'\' WHERE `key` = "'.$_COOKIE['session_key'].'"');
}


function object_to_array($Class){
    $Class = (array)$Class;

    foreach($Class as $key => $value){
	if(is_object($value)&&get_class($value)==='stdClass'){
	    $Class[$key] = object_to_array($value);
	}
    }
    return $Class;
}

// ------------------------

if(isset($_COOKIE['session_key'])) {
  // check whether the session key is valid or not
  $session_info = mysql_fetch_assoc(mysql_query('SELECT * FROM `sessions` WHERE `key` = "'.$_COOKIE['session_key'].'"'));
  if(!is_array($session_info)) gen_new_session();
} else {
  gen_new_session();
}

$session_info = mysql_fetch_assoc(mysql_query('SELECT * FROM `sessions` WHERE `key` = "'.$_COOKIE['session_key'].'"'));
$session_info['config_info'] = unserialize($session_info['config_info']);

?>