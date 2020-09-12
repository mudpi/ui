<!DOCTYPE html>
<html lang="en">
	<head>
	    <meta charset="utf-8">
		<title>MudPi Displays</title>
	    <?php echo csrf_meta(); ?>
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="description" content="MudPi Control Page for Displays.">
	    <meta name="author" content="MudPi - Eric Davisson">

		<link rel="stylesheet" type="text/css" href="css/main.css">
		<link rel="stylesheet" type="text/css" href="css/fonts.css">
		<link rel="stylesheet" type="text/css" href="css/app.css">
		<style>
			#app.transition-out {
				background-position:0 0;
			}

			.container {
				transition: all .4s ease;
			}

			.container.transition-out {
				opacity: 0;
				transform:translateY(-10px);
				visibility: hidden;
				display: none;
			}

			.logo {
				width:64px;
			}

			.input {
				box-shadow:inset 0 1px 3px rgba(50,50,93,.05),inset 0 2px 5px rgba(0, 0, 0, 0.21);
			}
		</style>
	</head>
	<body>
		<div id="app" class="mnh-full">
			<div class="container">
			<div class="columns is-centered">
			<div class="column sm:column-12 md:column-12 lg:column-10">
				<div class="content px-2">
					<h1 class="h2 text-primary" id="title">Displays</h1>
					<p class="mb-4 text-grey-dark" id="message">Monitor and send messages to the display queue.</p>
					<div id="errors" class="rounded-2 text-red-dark errors">
						
					</div>

					<div class="columns" style="margin-left:-10px;margin-right:-10px;">
						<?php foreach($displays as $display) { ?>
						<div class="column column-12 sm:column-12 md:column-6">
							<div class="box py-1">
								<h3 class="h4"><?php echo $display->topic; ?></h3>
								<span class="text-grey-dark-lightest text-xs"><?php echo $display->model; ?> - </span>
								<?php if(isset($display->address)) { ?>
									<span class="text-grey-dark-lightest text-xs mb-1">0x<?php echo $display->address; ?>
								<?php }?></span>
								<p class="text-grey-dark-lightest text-xs mb-1"><?php echo $display->rows; ?> x <?php echo $display->columns; ?></p>
								
								<div class="columns is-centered">
									<div class="column column-12 columns">
										<div class="mb-2 column column-10">
											<label class="label mb-1 text-white" for="name">Message</label>
											<input class="input rounded-2 py-2 text-grey-darker px-2" placeholder="Type message here..." type="text" name="message">
										</div>
										<div class="mb-2 column column-2">
											<label class="label mb-1 text-white" for="name">Duration</label>
											<input class="input rounded-2 py-2 text-grey-darker px-2" value="60" placeholder="15" type="number" name="duration">
										</div>

										<div class="mb-1 column column-12">
											<?php echo csrf_field(); ?>
											<input class="input rounded-2 py-2 text-grey-darker px-2" value="<?php echo $display->topic; ?>" placeholder="mudpi/lcd" type="hidden" name="topic">
											<button id="create" class="button rounded-2 is-primary px-3 py-2 mb-2"><?php echo _("Send"); ?></button>
										</div>
									</div>

									</div> <!-- /Columns -->
							</div>
						</div>
					<?php }?>
					</div>
					
				</div>


			</div> <!-- /Container -->
			</div> <!-- /Columns -->
			</div> <!-- /Column 10 -->
		</div>


		<script type="text/javascript" src="js/displays.js"></script>
	</body>
</html>