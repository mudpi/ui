<!DOCTYPE html>
<html lang="en">
	<head>
	    <meta charset="utf-8">
		<title>MudPi UI - Dashboard</title>
	    <?php echo csrf_meta(); ?>
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="description" content="MudPi Initial Dashboard Settings.">
	    <meta name="author" content="MudPi - Eric Davisson">

		<link rel="stylesheet" type="text/css" href="css/main.css">
		<link rel="stylesheet" type="text/css" href="css/fonts.css">
		<link rel="stylesheet" type="text/css" href="css/intro.css">
	</head>
	<body>
		<div id="app" class="mnh-full">
			<div class="container">
			<div class="columns is-centered">
			<div class="column sm:column-12 md:column-10 lg:column-6 mnh-full pt-3">
				<img src="img/mudpi_logo_white.png" class="mw-100 logo">
				<div class="content px-2 transition-out text-white mt-a">
					<h1 class="h1 text-white" id="title">Welcome!</h1>
					<p class="mb-2 text-white" id="message">In the next few steps you will be guided through the MudPi UI setup process.</p>
				</div>

				<button id="continue" class="button transition-out is-white hover:bg-white hover:text-primary is-outline px-2 py-2 mb-6 mt-a"><?php echo _("Continue"); ?></button>


			</div> <!-- /Container -->
			</div> <!-- /Columns -->
			</div> <!-- /Column 10 -->
		</div>
		<div class="overlay transition-out"></div>

		<script type="text/javascript" src="js/intro.js"></script>
	</body>
</html>