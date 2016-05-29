<?php
error_reporting(0);
$host = 'ipv4.google.com';

$port = '80';
$timeout = '5';

function ping($host, $port, $timeout) { 
  $tB = microtime(true); 
  $fP = fSockOpen($host, $port, $errno, $errstr, $timeout); 
  if (!$fP) { return '<a id="ipv4" class="btn btn-warning btn-lg btn-block flat">No connectivity :(</a><script>console.log("RSP: ajax response success!")</script>'; } 
  $tA = microtime(true); 
  // return round((($tA - $tB) * 1000), 0)." ms"; 
  return '<a id="ipv4" class="btn btn-success btn-block btn-lg flat">I see the world!</a><script>console.log("RSP: ajax response success!")</script>';
}


echo ping($host, $port, $timeout);

?>