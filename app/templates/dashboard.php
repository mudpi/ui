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
			<?php include "partials/navigation.php"; ?>
			<div class="container">
			<div class="columns is-centered">
			<div class="column sm:column-12 md:column-12">
				<div class="content px-2 w-100">
					<h1 class="h2 text-primary" id="title">Dashboard</h1>
					<p class="mb-4 text-grey-dark" id="message">System booted <?php echo timeForHumans($started_at); ?> ago.</p>


					<h3 class="h3 text-primary">Sensors</h3>
					<div class="columns" style="margin-left:-10px;margin-right:-10px;">
						<?php foreach($config->sensor as $sensor) { ?>
						<div class="column column-12 sm:column-12 md:column-4">
							<div class="box py-1 text-primary rounded-3 mb-2">
								<h3 class="h4"><?php echo $sensor->name ?? ''; ?></h3>
								<span class="text-grey-dark-lightest text-xs"><?php echo $sensor->interface; ?> - </span>
								<?php if(isset($sensor->pin)) { ?>
									<span class="text-grey-dark-lightest text-xs mb-1">Pin: <?php echo $sensor->pin; ?>
								<?php }?></span>
								<?php if(isset($sensor->address)) { ?>
									<span class="text-grey-dark-lightest text-xs mb-1">0x<?php echo $sensor->address; ?>
								<?php }?></span>
								<div class="columns">
									<?php if (is_object($sensor->state->state)) { foreach($sensor->state->state as $key => $value) { ?>
										<div class="column px-1">
											<p class="text-primary font-bold <?php echo (count((array)$sensor->state->state) > 3) ? 'h4' : 'h3'; ?>"><?php echo $value ?><?php echo $readingSuffixes[$key]; ?></p>
											<p class="text-primary font-bold text-xs"><?php echo ucfirst($key); ?></p>
										</div>
									<?php } } else { ?>
										<div class="column px-1">
											<p class="text-primary font-bold h3"><?php echo $sensor->state->state ?><?php echo $readingSuffixes[$sensor->classifier]; ?></p>
											<p class="text-primary font-bold text-xs"><?php echo ucfirst($sensor->classifier); ?></p>
										</div>
									<?php }?>
								</div>
								<div class="columns">
									<div class="column sm:column-12 align-items-center">
										<p class="text-xs text-primary-light">Updated: <?php echo ( isset($sensor->state->updated_at) && $sensor->state->updated_at ) ? timeForHumans(DateTime::createFromFormat('Y-m-d H:i:s', $sensor->state->updated_at)->format('U')) : 'never'?> ago</p>
									</div>
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