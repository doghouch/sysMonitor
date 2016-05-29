<?php
if($_GET['act'] === 'uptime') {

    $file = @fopen('/proc/uptime', 'r');
    if (!$file) return 'Error: failed to retrieve uptime!';
    $data = @fread($file, 128);
    if ($data === false) return 'Error: failed to retrieve uptime!';
    $upsecs = (int)substr($data, 0, strpos($data, ' '));
    $uptime = Array (
        'days' => floor($data/60/60/24),
        'hours' => $data/60/60%24,
        'minutes' => $data/60%60,
        'seconds' => $data%60
    );

if($uptime['days'] > 1) {
    echo ''. $uptime['days'] .' days';
} else {
echo ''. $uptime['hours'] .' hours';
}

}


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

$percent = ($memused / $mem) * 100;
$percent = round($percent, 2);

echo ''. $percent .' %';
}


if($_GET['act'] === 'whoami') {
echo get_current_user();
}


if($_GET['act'] === 'time') {

  $ip_addr = $_SERVER['REMOTE_ADDR'];
  date_default_timezone_set($zones['". $_GET[`zone`] ."']);
  $daydate = date("d/m/Y");
    echo ''. date("g:i:s a") .'';


}




?>







