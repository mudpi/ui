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
			<?php include "partials/navigation.php"; ?>
			<div class="columns is-centered">
			<div class="column sm:column-12 md:column-12 lg:column-10">
				<div class="content px-2">
					<h1 class="h2 text-primary" id="title">Dashboard</h1>
					<p class="mb-4 text-grey-dark" id="message">System booted <?php echo timeForHumans($started_at); ?> ago.</p>


					<h3 class="h3 text-primary">Sensors</h3>
					<div class="columns" style="margin-left:-10px;margin-right:-10px;">
						<?php foreach($sensors as $sensor) { ?>
						<div class="column column-12 sm:column-12 md:column-4">
							<div class="box bg-primary py-1 text-white">
								<h3 class="h4"><?php echo $sensor->name; ?></h3>
								<span class="text-grey-dark-lightest text-xs"><?php echo $sensor->type; ?> - </span>
								<?php if(isset($sensor->pin)) { ?>
									<span class="text-grey-dark-lightest text-xs mb-1"><?php echo $sensor->pin; ?>
								<?php }?></span>
								<?php if(isset($sensor->address)) { ?>
									<span class="text-grey-dark-lightest text-xs mb-1">0x<?php echo $sensor->address; ?>
								<?php }?></span>
								<div class="columns">
									<?php foreach($sensor->value as $key => $value) { ?>
										<div class="column px-1">
											<p class="text-white font-bold <?php echo (count((array)$sensor->value) > 3) ? 'h4' : 'h3'; ?>"><?php echo $value ?><?php echo $readingSuffixes[$key]; ?></p>
											<p class="text-white font-bold text-xs"><?php echo ucfirst($key); ?></p>
										</div>
									<?php }?>
								</div>
							</div>
						</div>
					<?php }?>
					</div>
					
				</div>


			</div> <!-- /Container -->
			</div> <!-- /Columns -->
			</div> <!-- /Column 10 -->
		</div>

	</body>
</html>