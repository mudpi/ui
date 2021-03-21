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
		</style>
	</head>
	<body>
		<div id="app" class="mnh-full">
			<?php include "partials/navigation.php"; ?>	
			<div class="container">
			<div class="columns is-centered">
			<div class="column sm:column-12 md:column-12">
				<div class="content px-2 w-100">
					<h1 class="h2 text-primary" id="title">Displays</h1>
					<p class="mb-4 text-grey-dark" id="message">Control and monitor displays attached to MudPi.</p>
					<div id="errors" class="rounded-2 text-red-dark errors">
						
					</div>

					<div class="columns" style="margin-left:-10px;margin-right:-10px;">
						<?php foreach($displays as $key => $display) { ?>
						<div class="column column-12 sm:column-12 md:column-6">
							<div class="box py-1 px-1 display" data-key="<?php echo $display->key;?>" data-topic="<?php echo $display->topic ?? '' ?>">
								<div class="flex flex-row px-1">
									<div class="mr-a">
										<h3 class="h4 text-primary"><?php echo ($display->name); ?></h3>
										<p class="text-grey-dark text-xs mb-1"><?php echo $display->rows ?? "2"; ?> x <?php echo $display->columns ?? "16"; ?></p>
										<p class="text-grey-dark text-xs mb-1"><?php echo $display->interface ?></p>
									</div>
									<div class="ml-a text-right">
										<p class="text-grey-dark text-sm"><?php echo $display->topic ?? ''; ?></p>
										<?php if(isset($display->address)) { ?>
											<span class="text-grey text-xs mb-1">Address: 0x<?php echo $display->address; ?>
										<?php }?></span>
									</div>
								</div>
								
								
									<div class="columns">
										<div class="mb-2 column column-10">
											<label class="label mb-1 text-primary" for="name">Message</label>
											<input class="input rounded-2 py-2 text-grey-darker px-2" placeholder="Type message here..." type="text" name="message">
										</div>
										<div class="mb-2 column column-2">
											<label class="label mb-1 text-primary" for="name">Duration</label>
											<input class="input rounded-2 py-2 text-grey-darker px-2 w-100" value="60" placeholder="15" type="number" name="duration">
										</div>

										<div class="mb-1 column column-12">
											<?php echo csrf_field(); ?>
											<input class="input rounded-2 py-2 text-grey-darker px-2" value="<?php echo $display->topic ?? "char_display/".$display->key; ?>" placeholder="mudpi/char_dislay" type="hidden" name="topic">
											<button class="button send_message" class="button rounded-2 is-primary px-2 py-1 text-small mb-2"><?php echo _("Send"); ?></button>
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


		<script type="text/javascript" src="js/displays.js"></script>
	</body>
</html>