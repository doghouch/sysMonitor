<?php
header('Access-Control-Allow-Origin: *');  
header("Content-type: text/json");



$load = sys_getloadavg();

$x = time() * 1000;
$y = $load[0];

$ret = array($x, $y);
echo json_encode($ret);
?>