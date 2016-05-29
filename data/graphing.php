<?php
header('Access-Control-Allow-Origin: *');  
header("Content-type: text/json");

if($_GET['act'] === 'ram') {
  $fh = fopen('/proc/meminfo','r');
  $mem = 0;
  while ($line = fgets($fh)) {
    $pieces = array();
    if (preg_match('/^MemTotal:\s+(\d+)\skB$/', $line, $pieces)) {
      $mem = $pieces[1];
      break;
    }
  }

 while ($line = fgets($fh)) {
    $pieces = array();
    if (preg_match('/^Active:\s+(\d+)\skB$/', $line, $pieces)) {
      $memused = $pieces[1];
      break;
    }
  }
  fclose($fh);

$x = time() * 1000;

$y = $memused / 1000;


$ret = array($x, $y);
echo json_encode($ret);
}


if($_GET['act'] === 'cpu') {




$load = sys_getloadavg();




$x = time() * 1000;

$y = $load[0];


$ret = array($x, $y);
echo json_encode($ret);
}




?>