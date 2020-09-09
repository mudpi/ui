<div class="modal box column-12 sm:column-10 md:column-8 lg:column-5 is-centered m-0-a px-2 py-2 text-ink pin top left columns absolute rounded-3" id="modal">
	<button class="pin right top mt-1 mr-2 text-grey-dark" onclick="closeModal()">x (esc)</button>

	<header class="column column-12 sm:column-8 m-0-a text-primary mb-3 w-100">
		<h3 class="h4">Connect to Network</h3>
	</header>

	<div class="mb-3 column column-12 sm:column-8 m-0-a">
		<label class="label mb-1" for="ssid">SSID</label>
		<input class="input py-2 text-grey-darker px-2 mnw-50" type="text" name="ssid">
	</div>
	
	<div class="mb-3 column column-12 sm:column-8 m-0-a" id="passphrase_block">
		<label class="label mb-1" for="passphrase">Password</label>
		<input class="input py-2 text-grey-darker px-2 mnw-50" type="password" name="passphrase1">
		<span class="text-grey text-xs" id="help_message">Must be between 8 and 64 characters.</span>
		<a onclick="showPassword(1)">Show</a>
	</div>

	<div class="mb-3 column column-12 sm:column-6 m-0-a">
		<button class="button is-primary px-2" id="connect">Connect</button>
	</div>

	<div class="column column-12">
		<span class="text-xs text-grey">Note: Double check your credentials. After a failed connection it can take over 10 minutes before MudPi will reload the hotspot as a fallback.</span>
	</div>
</div>

<div class="modal box column-12 sm:column-8 md:column-6 lg:column-4 is-centered m-0-a px-3 text-ink pin top left columns absolute rounded-3" id="modal_confirm">

	<header class="text-centered text-primary mb-3 w-100">
		<h3>Everything Look Correct?</h3>
		<p class="text-grey-dark text-xs mb-3">MudPi will save the following network configuration and attempt connecting. If wifi connection is offline or fails for over 10 mins the hotspot will be restarted.</p>
		<div class="sm:column-9 text-left m-0-a b-1 b-grey-lighter px-2 py-2">
			<p class="text-grey text-xs">SSID:  <code class="text-purple ml-1 mb-2 text-sm" id="ssid"></code></p>
			<p class="text-grey text-xs" id="passphrase_confirm_block">PASS:  <code class="text-purple ml-1 mb-3 text-sm" id="passphrase"></code></p>
			
		</div>
	</header>	
	<div class="mb-3 flex sm:flex-row m-0-a">
		<button class="button text-grey-dark text-underline hover:text-red-lighter hover:bg-red-dark px-2 sm:mr-2" onclick="closeModal('modal_confirm')">Cancel</button>
		<button class="button is-primary is-outline px-2" id="connect_confirm">Proceed with Connection</button>
	</div>
</div>