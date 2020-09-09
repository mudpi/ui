<!DOCTYPE html>
<html lang="en">
	<head>
	    <meta charset="utf-8">
		<title>MudPi Setup - Create Account</title>
	    <?php echo csrf_meta(); ?>
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="description" content="MudPi Initial Setup Page for First time users.">
	    <meta name="author" content="MudPi - Eric Davisson">

		<link rel="stylesheet" type="text/css" href="css/main.css">
		<link rel="stylesheet" type="text/css" href="css/fonts.css">
		<link rel="stylesheet" type="text/css" href="css/app.css">
		<style>
			#app {
				background: linear-gradient(315deg, #5c9347, #dbf0d0, #fff);
				background-size: 600% 600%;
				background-position:100% 100%;
				transition:background-position 2s ease;
			}

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
		<div id="app" class="transition-out mnh-full">
			<div class="container" id="form">
				<div class="columns is-centered">
				<div class="column column-12 sm:column-10 md:column-8 lg:column-6 relative">
					<div class="text-white mt-2 mb-2 text-centered">
						<h1 class="h1" id="title">MudPi Account</h1>
						<p>Register a new MudPi account to backup configurations and manage devices online.</p>
						<div id="errors" class="rounded-2 text-red-dark errors">
							
						</div>
					</div>
				</div>
				</div>

				<div class="columns is-centered">
				<div class="column column-12 sm:column-8 md:column-6 lg:column-4 columns">
					<div class="mb-2 column column-12">
						<label class="label mb-1 text-white" for="name">Name</label>
						<input class="input rounded-2 py-2 text-grey-darker px-2 mnw-50" placeholder="Eric Davis" type="text" name="name">
					</div>

					<div class="mb-2 column column-12">
						<label class="label mb-1 text-white" for="email">Email</label>
						<input class="input rounded-2 py-2 text-grey-darker px-2 mnw-50" placeholder="email@domain.com" type="email" name="email">
					</div>
					
					<div class="mb-2 column column-12">
						<label class="label mb-1 text-white" for="password">Password (between 8 and 64 characters)</label>
						<input class="input rounded-2 py-2 text-grey-darker px-2 mnw-50" type="password" placeholder="" maxlength="64" name="password">
					</div>

					<div class="mb-4 column column-12">
						<label class="label mb-1 text-white" for="password_confirmation">Password Confirm</label>
						<input class="input rounded-2 py-2 text-grey-darker px-2 mnw-50" type="password" placeholder="" maxlength="64" name="password_confirmation">
					</div>

					<div class="mb-1 column column-12">
						<button id="create" class="button rounded-2 is-white text-primary px-3 py-2 mb-2" style="min-width: 200px;"><?php echo _("Create"); ?></button>
						<p class="text-xs text-italic text-white text-centered mb-2">Skip if you already have an account.</p>
						<a href="complete.php" class="text-underline text-centered text-xs" style="color:#f9f9f9;text-decoration:underline;">Skip</a>
					</div>

					<img src="img/mudpi_logo_white.png" class="mw-100 logo ml-a mr-a mt-3 mb-2">
				</div>

				</div> <!-- /Columns -->
			</div> <!-- /Container -->
			<div class="container transition-out" id="account">
				<div class="columns is-centered">
					<div class="column column-12 sm:column-10 md:column-8 lg:column-6 columns">
						<div class="px-1 text-white mt-2 mb-2 column column-12 text-centered">
							<h1 class="h1" id="title">Welcome <span id="name"></span></h1>
							<p class="mb-3">Shortly an email will be sent to <span class="font-bold" id="email"></span> to confirm your account. Save your access token below somewhere safe. It has been encrypted and will only be shown once. This token is needed when configuring new devices on your account.</p>
							<p class="mb-2">Token: <code id="token" class="font-bold" style="word-break:break-word;"></code></p>
							<p class="text-xs font-italic mb-4">You may generate new tokens, but each device will need the new token.</p>
							<a id="continue" href="complete.php" class="button rounded-2 is-white text-primary px-3 py-2 mb-3" style="min-width: 200px;"><?php echo _("Continue"); ?></a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="overlay"></div>

		<script type="text/javascript" src="js/account.js"></script>
	</body>
</html>