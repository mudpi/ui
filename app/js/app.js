//Ajax for loading in data
var request;
var networks;
var selected_network;
var general_data = new FormData();
var loader = document.getElementById('loader');
var button = document.getElementById("rescan");
var app = document.getElementById("app");
var overlay = document.querySelector('.overlay');

var modal = document.getElementById("modal");
var ssid_input = document.querySelector('[name="ssid"]');
var passphrase_input = document.querySelector('[name="passphrase1"]');
var passphrase_block = document.getElementById('passphrase_block');
var passphrase_confirm_block = document.getElementById('passphrase_confirm_block');
var button_connect = document.getElementById("connect");
var button_connect_confirm = document.getElementById("connect_confirm");

document.onkeydown = function(e) {
	if (e.key === 'Escape') {
		closeModal();
	}
}

setTimeout(function () {
	app.classList.remove('transition-out');
	overlay.classList.add('transition-out');
}, 300);

//document.querySelector("#rescan").addEventListener('click', makeRequest);
button.addEventListener('click', function(){ makeRequest('ajax/get_nearby_networks.php', 'POST', general_data); });

button_connect.addEventListener('click', function() {
	if (( selected_network.protocol.localeCompare("Open") != 0 ) && ( passphrase_input.value.length < 8 || passphrase_input.value.length > 64 )) {
		passphrase_input.classList.add("b-red-light");
		passphrase_input.classList.add("b-1");
		document.getElementById("help_message").classList.add("text-red");
		document.getElementById("help_message").classList.remove("text-grey");
	}
	else {
		closeModal(); 
		document.getElementById('passphrase').innerHTML = passphrase_input.value;
		document.getElementById('ssid').innerHTML = ssid_input.value;
		openModal('modal_confirm'); 
	}
	
});

button_connect_confirm.addEventListener('click', function() {
	var network_data = new FormData();
	network_data.append('ssid', ssid_input.value);
	if ( selected_network.protocol.localeCompare("Open") != 0 ) {
		network_data.append('passphrase', passphrase_input.value);
	}
	selected_network.passphrase = passphrase_input.value;
	network_data.append('network', JSON.stringify(selected_network));
	makeRequest('ajax/connect_to_network.php', 'POST', network_data, handleSaveFileResponse);
});

function closeModal(id = null) {
	let m = null;
	if(!id) {
		m = document.getElementById("modal");
	}
	else {
		m = document.getElementById(id);
	}

	if (m.classList.contains('open')) {
		m.classList.toggle('open');
		app.classList.toggle('bg-grey-darkest');
		app.classList.toggle('opacity-25');
	}
}

function openModal(id = null) {
	let m = null;
	if(!id) {
		m = document.getElementById("modal");
		passphrase_input.classList.remove("b-red-light");
		passphrase_input.classList.remove("b-1");
		document.getElementById("help_message").classList.remove("text-red");
		document.getElementById("help_message").classList.add("text-grey");
	}
	else {
		m = document.getElementById(id);
	}
	if (!m.classList.contains('open')) {
		m.classList.toggle('open');
		app.classList.toggle('bg-grey-darkest');
		app.classList.toggle('opacity-25');

	}
}

function makeRequest(url, type = 'POST' , data = null, callback = null) {
	request = new XMLHttpRequest();

	let old_networks = document.querySelectorAll(`.network`);
	old_networks.forEach(net => net.classList.add('transition-out'));
	setTimeout(function() {
		document.querySelector('#networks').innerHTML = '';
	}, 300)

	if (!request) {
		//Problem making request
	  	return false;
	}
	if (data === null) {
		console.log("Defaulting form data.");
		data = new FormData();
	}

	loader.classList.remove('hidden');
	button.textContent = "Scanning...";
	button.disabled = true;
	button.classList.add('is-grey');
	button.classList.remove('is-primary');

	if (callback === null) {
		request.onreadystatechange = handleResponse;
	}
	else {
		request.onreadystatechange = callback;
	}
	request.open(type, url);
	// request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded'); //or application/json;charset=UTF-8
	setCSRFHeader(request, type, data);
	request.send(data);
}

function handleResponse() {
	if (request.readyState === XMLHttpRequest.DONE) {
	  if (request.status === 200) {
  		var response = JSON.parse(request.responseText);
  		networks = response;
    	//Request successful
    	loader.classList.add('hidden');
		button.textContent = "Rescan";
		button.disabled = false;
		button.classList.remove('is-grey');
		button.classList.add('is-primary');
    	addResults(response);

	  } else {
    	loader.classList.add('opacity-0');
		button.disabled = false;
		button.textContent = "Scan Failed. Refresh Page.";
		button.classList.remove('is-grey');
		button.classList.add('text-white');
		button.classList.add('bg-red');
    	//Problem with the request (500 error)
	  }
	}
}

function handleSaveFileResponse() {
	if (request.readyState === XMLHttpRequest.DONE) {
	  if (request.status === 200) {
  		var response = JSON.parse(request.responseText);
    	//Request successful
    	closeModal('modal_confirm');
    	// alert(response.message);
   		
		overlay.classList.remove('transition-out');
    	loader.classList.add('hidden');
		setTimeout(function() {
			window.location.href = 'wifi_confirm.php';
		}, 700);


	  } else {
	  	alert(request.responseText);
    	loader.classList.add('hidden');
		button_connect_confirm.textContent = "File Save Failed!";
    	//Problem with the request (500 error)
	  }
	}
}

function setCSRFHeader(xhr, type, d) {
    var csrfToken = document.querySelector('meta[name=csrf_token]').getAttribute('content');
    if (/^(POST|PATCH|PUT|DELETE)$/i.test(type)) {
    	d.append("csrf_token", csrfToken);
        xhr.setRequestHeader("X-CSRF-Token", csrfToken);
    }
}

function addResults(results, elm = null) {
	if (!results) {
		return;
	}

	if (!elm) {
		elm = document.querySelector('#networks');
	}
	elm.innerHTML = '';

	let count = 1;
	for (var network in results) {
		let row = document.createElement('div');
		row.id = `network-${count}`
		row.dataset.name = results[network]['ssid'];
		row.classList.add('network');
		row.classList.add('transition-out');
		row.classList.add('box');
		row.classList.add('mb-3');
		row.classList.add('py-2');
		row.classList.add('rounded-3');
		row.innerHTML = `<div class="flex flex-row">
				<div class="mr-a">
					<h3 class="h5 mb-0">${results[network]['ssid'].includes('\\x00') ? '<strong>HIDDEN</strong>' : results[network]['ssid']}</h3> 
					<span class="text-sm text-grey">${results[network]['macAddress']}</span>
				</div>
				<div class="text-right signal flex flex-row">
					${results[network]['protocol'] == 'Open' ? '' : '<img class="mw-100 mr-2 security" style="width:12px;" src="img/lock.svg">'}
					<div class="wifi-strength">
						<span class="bar ${results[network]['strength'] >= 1 ? 'active' : ''} inactive"></span>
						<span class="bar ${results[network]['strength'] >= 2 ? 'active' : ''} inactive"></span>
						<span class="bar ${results[network]['strength'] >= 3 ? 'active' : ''} inactive"></span>
						<span class="bar ${results[network]['strength'] >= 4 ? 'active' : ''} inactive"></span>
					</div>
				</div>
			</div>`;
			//<button class="button is-primary is-outline action connect-button" id="button${results[network]['ssid']}" data-name="${results[network]['ssid']}">Connect</button>
		elm.append(row);
		count++;
	}
	
	setTimeout(function() {
		let nets = document.querySelectorAll(`.network`);
		nets.forEach(net => net.classList.remove('transition-out'));

		setTimeout(function() {
			let bars = document.querySelectorAll(`.wifi-strength .bar`);
			bars.forEach(bar => bar.classList.remove('inactive'));
		}, 400);
	}, 200);
	

	var buttons = document.querySelectorAll("#networks .network");

	buttons.forEach(button => button.addEventListener('click', function(e) {
			selected_network = networks[this.dataset.name];
			ssid_input.value = selected_network.ssid ? selected_network.ssid : '';
			passphrase_input.value = selected_network.passphrase ? selected_network.passphrase : '';
			if(selected_network.protocol.localeCompare("Open") == 0) {
				passphrase_block.style.display = "none";
				passphrase_confirm_block.style.display = "none";
			}
			else {
				passphrase_block.style.display = "";
				passphrase_confirm_block.style.display = "";
			}
			openModal(null);
		}));
	
}