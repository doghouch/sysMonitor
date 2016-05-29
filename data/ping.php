<?php
error_reporting(0);

if(empty($_GET['host'])) {
echo '(<b>error: nothing was entered</b>)';
die();
}

$host = $_GET['host'];
$port = '80';
$timeout = '5';

function ping($host, $port, $timeout) { 
  $tB = microtime(true); 
  $fP = fSockOpen($host, $port, $errno, $errstr, $timeout); 
  if (!$fP) { return '(<b>error: connection failed to be established</b>)'; } 
  $tA = microtime(true); 
  return '(<b>ping success - latency: '. round((($tA - $tB) * 1000), 0).' ms</b>)'; 

}

echo ping($host, $port, $timeout);

?>