<!DOCTYPE html>
<html lang="en">
	<head>
	    <meta charset="utf-8">
		<title>MudPi Dashboard</title>
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
			<div class="container">
			<div class="columns is-centered">
			<div class="column sm:column-12 md:column-12 lg:column-10">
				<div class="content px-2">
					<h1 class="h2 text-primary" id="title">Dashboard</h1>
					<p class="mb-4 text-grey-dark" id="message">View the contents of MudPi log Files below. </p>
					<p class="mb-4 text-grey-dark" id="message">System booted <?php echo $started_at; ?> ago.</p>


					<h3 class="h3 text-primary">Sensors</h3>
					<div class="columns">
						<?php foreach($sensors as $sensor) { ?>
						<div class="column column-12 sm:column-12 md:column-4 lg:column-3">
							<div class="box">
								<h3 class="h4"><?php echo $sensor->name; ?></h3>
								<p class="text-grey-dark text-xs"><?php echo $sensor->type; ?></p>
								<p class="text-grey-dark text-xs mb-3"><?php echo isset($sensor->pin) ? $sensor->pin : isset($sensor->address) ? $sensor->address : ''; ?></p>
								<p class="text-primary h2">0</p>
							</div>
						</div>
					<?php }?>
					</div>
					

					<h3 class="h3 text-primary">Config</h3>
					<pre class="mb-3 bg-grey-lighter p-2 rounded-3" style="max-height:500px;overflow:scroll;"><code><?php var_dump($config); ?></code></pre>
				</div>


			</div> <!-- /Container -->
			</div> <!-- /Columns -->
			</div> <!-- /Column 10 -->
		</div>

	</body>
</html>