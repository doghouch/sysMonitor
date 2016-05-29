<html>
<head>
<title>sysMonitor: main</title>

<!-- CSS -->
<link href='https://fonts.googleapis.com/css?family=Montserrat|Roboto:300' rel='stylesheet' type='text/css'>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.6/yeti/bootstrap.min.css">

<!-- Custom Styling -->
<style type="text/css">
body {
padding-top: 100px;
font-family: 'Roboto', sans-serif;
}

content {
font-family: 'Montserrat', sans-serif;
}

sep {
font-family: 'Roboto', sans-serif;
}

@media (max-width: 767px)
.navbar-default .navbar-nav .open .dropdown-menu>li>a>a:hover {
    color: #000;
}

.navbar {
    border: none;
    -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
}


.dropdown-menu > li > a {
    display: block;
    padding: 6px 20px;
    clear: both;
    font-weight: normal;
    line-height: 1.42857143;
    white-space: nowrap;

}

.dropdown-menu>li>a:focus, .dropdown-menu>li>a:hover {
background-color: transparent;
font-weight: bold;

}

.flat {
border-radius: 0px;
text-align: left;
}

.centered {
text-align: center;
}

.large {
font-size: 100px;
text-transform: uppercase;
}

.stats {
padding-bottom: 50px;
}

.sp {
padding-top: 10px;
}

.large {
font-size: 4em;
}

.contain {
width: 100%;
background-color: #e5e5e5;
padding-top: 15px;
padding-bottom: 15px;
padding-left: 25px;
}
</style>


<!-- Javascript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/solid-gauge.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/raphael/2.1.2/raphael-min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/justgage/1.2.2/justgage.min.js"></script>

<!-- Custom Javascript (if you're too lazy to add another JS file) -->

<script type="text/javascript">
function requestRAM() {
    $.ajax({
        url: 'data/graphing.php?act=ram',
        success: function(point) {
            var series = chart3.series[0],
                shift = series.data.length > 20; // shift if the series is 
                                                 // longer than 20

            // add the point
            chart3.series[0].addPoint(point, true, shift);
            
            // call it again after one second
            setTimeout(requestRAM, 1000);    
        },
        cache: false
    });
}

function requestCPU() {
    $.ajax({
        url: 'data/graphing.php?act=cpu',
        success: function(point) {
            var series = chart4.series[0],
                shift = series.data.length > 20; // shift if the series is 
                                                 // longer than 20

            // add the point
            chart4.series[0].addPoint(point, true, shift);
            
            // call it again after one second
            setTimeout(requestCPU, 1000);    
        },
        cache: false
    });
}

</script>



<script type="text/javascript">

$(document).ready(function() {
    chart3 = new Highcharts.Chart({
        chart: {
            renderTo: 'ram-chart',
                type: 'spline',
                animation: Highcharts.svg, // don't animate in old IE
                marginRight: 10,
                marginBottom: 65,
            events: {
                load: requestRAM
            }
        },
        title: {
            text: ''
        },
        tooltip: {
            valueSuffix: ' MB'
        },
        xAxis: {
            type: 'datetime',
            tickPixelInterval: 150,

            maxZoom: 20 * 1000
        },
        yAxis: {
            minPadding: 0.2,
            maxPadding: 0.2,
            title: {
                text: '',
                margin: 80
            }
        },

       plotOptions: {
            series: {
                animation: true
            }
        },

        credits: {
            enabled: false, // Enable/Disable the credits
        },

        series: [{
            name: 'RAM Used',
            data: []
        }]
    });        
});

$(document).ready(function() {
    chart4 = new Highcharts.Chart({
        chart: {
            renderTo: 'cpu-chart',
                type: 'spline',
                animation: Highcharts.svg, // don't animate in old IE
                marginRight: 10,
                marginBottom: 65,
            events: {
                load: requestCPU
            }
        },
        title: {
            text: ''
        },
        tooltip: {
            valueSuffix: ' %'
        },
        xAxis: {
            type: 'datetime',
            tickPixelInterval: 150,

            maxZoom: 20 * 1000
        },
        yAxis: {
            minPadding: 0.2,
            maxPadding: 0.2,
            title: {
                text: '',
                margin: 80
            }
        },
        credits: {
            enabled: false, // Enable/Disable the credits
        },
        series: [{
            name: 'CPU Load',
            data: []
        }]
    });        
});


function getUptime() {
$("#uptime").load("data/stats.php?act=uptime");
}
function getRAM() {
$("#ram").load("data/stats.php?act=ram");
}
function getUser() {
$("#whoami").load("data/stats.php?act=whoami");
}

function getTime() {
$("#time").load("data/stats.php?act=time");
}




 setInterval(function() {
  getUptime()
  getRAM()
  getUser()
  getTime()
    }, 1000);



        $(document).ready(function() {

            function loading() {
                $('#ping-rsp').show().html('(<b>pinging...</b>)');
            }

            function formResult(data) {
                $('#ping-rsp').html(data);
                $('#host').val('');
            }

            function onSubmit() {
                $('#ping').submit(function() {
                    var action = $(this).attr('action');
                    loading();
                    $.ajax({
                        url: 'data/ping.php',
                        type: 'GET',
                        data: {
                            host: $('#host').val()
                        },
                        success: function(data) {
                            formResult(data);
                        },
                        error: function(data) {
                            formResult(data);
                        }
                    });
                    return false;
                });
            }
            onSubmit();

        });
</script>
</head>

<body>
<div class="container">

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
      <div class="navbar-header">
      <a class="navbar-brand">
        <b>sysMonitor</b> <small>by doghouch</small>
      </a>
      </div>
  </div>
</nav>

<div class="sp"></div><!--spacing-->
<div class="sp"></div><!--spacing-->

<div class="contain">
<h1>system</h1>
</div>
<div class="sp"></div><!--spacing-->
<div class="sp"></div><!--spacing-->
<div class="sp"></div><!--spacing-->
<div class="sp"></div><!--spacing-->
<div class="sp"></div><!--spacing-->
<div class="row stats">
<div class="sp"></div><!--spacing-->
<div class="sp"></div><!--spacing-->
<div class="col-md-3">
<span>Server Uptime</span>
<h1 style="margin-bottom: 0px; margin-top: 0px;"><div id="uptime">...</div></h1>
<div class="sp"></div><!--spacing-->
<div class="sp"></div><!--spacing-->
<div class="sp"></div><!--spacing-->
</div>
<div class="col-md-3">


<span>RAM Used</span>
<h1 style="margin-bottom: 0px; margin-top: 0px;"><div id="ram">...</div></h1>
<div class="sp"></div><!--spacing-->
<div class="sp"></div><!--spacing-->
<div class="sp"></div><!--spacing-->
</div>
<div class="col-md-3">


<span>whoami</span>
<h1 style="margin-bottom: 0px; margin-top: 0px;"><div id="whoami">...</div></h1>
<div class="sp"></div><!--spacing-->
<div class="sp"></div><!--spacing-->
<div class="sp"></div><!--spacing-->
</div>
<div class="col-md-3">


<span>system time</span>
<h1 style="margin-bottom: 0px; margin-top: 0px;"><div id="time">...</div></h1>
<div class="sp"></div><!--spacing-->
<div class="sp"></div><!--spacing-->
<div class="sp"></div><!--spacing-->



</div>

</div>
<div class="contain">
<h1>graphs</h1>
</div>
<div class="sp"></div><!--spacing-->
<div class="sp"></div><!--spacing-->
<div class="sp"></div><!--spacing-->
<div class="sp"></div><!--spacing-->
<div class="sp"></div><!--spacing-->
<div class="sp"></div><!--spacing-->

<div class="row">
<div class="col-md-6">

       <span>RAM Usage</span>
<div id="ram-chart"></div>
<div class="sp"></div><!--spacing-->
<div class="sp"></div><!--spacing-->
<div class="sp"></div><!--spacing-->

     </div>
 
<div class="col-md-6">
        <span>CPU Usage</span>
<div id="cpu-chart"></div>
<div class="sp"></div><!--spacing-->
<div class="sp"></div><!--spacing-->
<div class="sp"></div><!--spacing-->

</div>

</div>


<div class="sp"></div><!--spacing-->



<div class="contain">
<h1>network</h1>
</div>
<div class="sp"></div><!--spacing-->
<div class="sp"></div><!--spacing-->
<div class="sp"></div><!--spacing-->
<div class="sp"></div><!--spacing-->
<div class="sp"></div><!--spacing-->

<div class="row">
<div class="col-md-3">
IPv4 connectivity
<div id="ipv4-rsp"><a id="ipv4" class="btn btn-info btn-block btn-lg flat">Loading...</a></div>
<div class="sp"></div><!--spacing-->
<div class="sp"></div><!--spacing-->
<div class="sp"></div><!--spacing-->

</div>
<div class="col-md-3">
IPv6 connectivity
<div id="ipv6-rsp"><a id="ipv6" class="btn btn-info btn-block btn-lg flat">Loading...</a></div>
<div class="sp"></div><!--spacing-->
<div class="sp"></div><!--spacing-->
<div class="sp"></div><!--spacing-->

</div>
<div class="col-md-6">
Ping Test <span id="ping-rsp">(<b>ex. google.ca</b>)</span>
<form id="ping" method="POST">
<input class="form-control input-lg flat" name="host" id="host" placeholder="Enter an IP address or a host to ping here..."></input>
</form>
</div>
</div>


    
</div>


<script type="text/javascript">
$( "#ipv4" ).click(function() {
  $("#ipv4-rsp").load("data/connectivity4.php");
});

$("#ipv4-rsp").load("data/connectivity4.php");

$( "#ipv6" ).click(function() {
  $("#ipv6-rsp").load("data/connectivity6.php");
});

$("#ipv6-rsp").load("data/connectivity6.php");
</script>

</body>


