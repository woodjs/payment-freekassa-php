<?php

require('./index.php');

function getIP() {
  if(isset($_SERVER['HTTP_X_REAL_IP'])) return $_SERVER['HTTP_X_REAL_IP'];
  return $_SERVER['REMOTE_ADDR'];
}

if (!in_array(getIP(), array('168.119.157.136', '168.119.60.227', '138.201.88.124'))) die("hacking attempt!");


$freekassa->setUp($_REQUEST['AMOUNT'], $_REQUEST['MERCHANT_ORDER_ID']);

$sign = $freekassa->getOrderSignature();

if ($sign != $_REQUEST['SIGN']) die('wrong sign');

/* 

1. checking the availability and amount of the order
2. issue a service to a user

*/

die('YES');
