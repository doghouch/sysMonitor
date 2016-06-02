<?php
	error_reporting(0);
	if(!empty($_GET['act'])) {
	if ($_GET['act'] === 'connectivity4') {
		$host    = 'ipv4.google.com';
		$port    = '80';
		$timeout = '5';
		
		function ping($host, $port, $timeout)    {
			$tB = microtime(true);
			$fP = fSockOpen($host, $port, $errno, $errstr, $timeout);
			
			if (!$fP) {
				return '<a id="ipv4" class="btn btn-warning btn-lg btn-block flat">No connectivity :(</a><script>console.log("RSP: ajax response success!")</script>';
			}

			$tA = microtime(true);
			// return round((($tA - $tB) * 1000), 0)." ms"; 
			return '<a id="ipv4" class="btn btn-success btn-block btn-lg flat">I see the world!</a><script>console.log("RSP: ajax response success!")</script>';
		}

		echo ping($host, $port, $timeout);
	}

	
	if ($_GET['act'] === 'connectivity6') {
		$host    = 'ipv6.google.com';
		$port    = '80';
		$timeout = '5';
		
		function ping($host, $port, $timeout)    {
			$tB = microtime(true);
			$fP = fSockOpen($host, $port, $errno, $errstr, $timeout);
			
			if (!$fP) {
				return '<a id="ipv6" class="btn btn-warning btn-lg btn-block flat">No connectivity :(</a><script>console.log("RSP: ajax response success!")</script>';
			}

			$tA = microtime(true);
			// return round((($tA - $tB) * 1000), 0)." ms"; 
			return '<a id="ipv6" class="btn btn-success btn-block btn-lg flat">I see the world!</a><script>console.log("RSP: ajax response success!")</script>';
		}

		echo ping($host, $port, $timeout);
	}

	
	if ($_GET['act'] === 'cpu') {
		header('Access-Control-Allow-Origin: *');
		header("Content-type: text/json");
		$load = sys_getloadavg();
		$x    = time() * 1000;
                $newLoad = ($load[0] * 100);
		$y    = $newload;
		$ret  = array(        $x,        $y    );
		echo json_encode($ret);
	}

	
	if ($_GET['act'] === 'ram-graph') {
		header('Access-Control-Allow-Origin: *');
		header("Content-type: text/json");
		$fh  = fopen('/proc/meminfo', 'r');
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
		$x   = time() * 1000;
		$y   = $memused / 1000;
		$ret = array(        $x,        $y    );
		echo json_encode($ret);
	}

	
	if ($_GET['act'] === 'ping') {
		
		if (empty($_GET['host'])) {
			echo '(<b>error: nothing was entered</b>)';
			die();
		}

		$host    = $_GET['host'];
		$port    = '80';
		$timeout = '5';
		
		function ping($host, $port, $timeout)    {
			$tB = microtime(true);
			$fP = fSockOpen($host, $port, $errno, $errstr, $timeout);
			
			if (!$fP) {
				return '(<b>error: connection failed to be established</b>)';
			}

			$tA = microtime(true);
			return '(<b>ping success - latency: ' . round((($tA - $tB) * 1000), 0) . ' ms</b>)';
		}

		echo ping($host, $port, $timeout);
	}

	
	if ($_GET['act'] === 'uptime') {
		$file = @fopen('/proc/uptime', 'r');
		
		if (!$file)        return 'Error: failed to retrieve uptime!';
		$data = @fread($file, 128);
		
		if ($data === false)        return 'Error: failed to retrieve uptime!';
		$upsecs = (int) substr($data, 0, strpos($data, ' '));
		$uptime = Array(        'days' => floor($data / 60 / 60 / 24),        'hours' => $data / 60 / 60 % 24,        'minutes' => $data / 60 % 60,        'seconds' => $data % 60    );
		
		if ($uptime['days'] > 1) {
			echo '' . $uptime['days'] . ' days';
		} else {
			echo '' . $uptime['hours'] . ' hours';
		}

	}

	
	if ($_GET['act'] === 'ram-percentage') {
		$fh  = fopen('/proc/meminfo', 'r');
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
		echo '' . $percent . ' %';
	}

	
	if ($_GET['act'] === 'whoami') {
		echo get_current_user();
	}

	
	if ($_GET['act'] === 'time') {
		$ip_addr = $_SERVER['REMOTE_ADDR'];
		date_default_timezone_set($zones['". $_GET[`zone`] ."']);
		$daydate = date("d/m/Y");
		echo '' . date("g:i:s a") . '';
	}
	} else {
	echo 'Invalid Method';
	die();
	}
	}
	?>
