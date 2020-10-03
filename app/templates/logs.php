<!DOCTYPE html>
<html lang="en">
	<head>
	    <meta charset="utf-8">
		<title>MudPi UI - Logs</title>
	    <?php echo csrf_meta(); ?>
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="description" content="MudPi UI Logs">
	    <meta name="author" content="MudPi - Eric Davisson">

		<link rel="stylesheet" type="text/css" href="css/main.css">
		<link rel="stylesheet" type="text/css" href="css/fonts.css">
		<link rel="stylesheet" type="text/css" href="css/app.css">
	</head>
	<body>
		<div id="app" class="mnh-full">
			<?php include "partials/navigation.php"; ?>
			<div class="container">
			<div class="columns is-centered">
			<div class="column sm:column-12 md:column-12">
				<div class="content px-2 w-100">
					<h1 class="h2 text-primary" id="title">Logs</h1>
					<p class="mb-4 text-grey-dark" id="message">View the contents of MudPi log Files below.</p>

					<h3 class="h3 text-primary">MudPi Logs</h3>
					<pre class="mb-3 bg-grey-lighter p-2 rounded-3" style="max-height:500px;overflow:scroll;"><code><?php echo $mudpi_log; ?></code></pre>

					<h3 class="h3 text-primary">MudPi Errors</h3>
					<pre class="mb-3 bg-grey-lighter p-2 rounded-3" style="max-height:500px;overflow:scroll;"><code><?php echo $mudpi_error_log; ?></code></pre>

					<h3 class="h3 text-primary">Auto AP Mode</h3>
					<pre class="mb-3 bg-grey-lighter p-2 rounded-3" style="max-height:500px;overflow:scroll;"><code><?php echo $auto_ap_log; ?></code></pre>

					<h3 class="h3 text-primary">Wifi Config</h3>
					<pre class="mb-3 bg-grey-lighter p-2 rounded-3" style="max-height:500px;overflow:scroll;"><code><?php echo $wpa_config; ?></code></pre>

					<h3 class="h3 text-primary">Sprout</h3>
					<pre class="mb-3 bg-grey-lighter p-2 rounded-3" style="max-height:500px;overflow:scroll;"><code><?php 
							foreach($sprout_data as $log) {
								echo $log["time"];
								echo "\n";
								echo $log["source"];
								echo "\n";
								echo "Run: ".$log["boots"];
								echo "\n";
								if(!is_array($log['value'])) {
									$log['value'] = [ $log['value'] ];
								}
								foreach($log["value"] as $index => $reading) {
									if(isset($reading["sensor"])) {
										echo $reading["sensor"];
										echo "\n";
									}
									echo $reading["value"]."mV";
									echo "\n";
									if(isset($reading["parsed"])) {
										echo $reading["parsed"]."%";
										echo "\n";
									}
									echo "Boot cycle: ". $reading["boots"];
									echo "\n----\n";
								}
								echo "\n\n";
							}
						 ?></code></pre>
				</div>


			</div> <!-- /Container -->
			</div> <!-- /Columns -->
			</div> <!-- /Column 10 -->
		</div>

	</body>
</html>