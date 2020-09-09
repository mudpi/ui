var app = document.getElementById("app");
var overlay = document.querySelector('.overlay');
var button = document.getElementById("update");
var button_continue = document.getElementById("continue");
var version_tag = document.getElementById("version");
var update_title = document.querySelector('#step-2 h2');

button.addEventListener("click", function() { 
	document.querySelector('#step-1').classList.add('transition-out');
	button.textContent = "Checking for Updates...";
	button.disabled = true;
	button.classList.add('is-grey');
	button.classList.remove('is-white');
	setTimeout(function() {
		document.querySelector('#step-1').classList.add('hidden');
		document.getElementById('step-2').classList.remove('hidden');
		document.getElementById('step-2').classList.remove('transition-out');
		makeRequest('ajax/check_for_updates.php') 
	}, 400);
});

button_continue.addEventListener('click', function() {
	app.classList.add('transition-out');
	overlay.classList.remove('transition-out');
	setTimeout(function() {
		window.location.href = 'new_account.php';
	}, 400);
});

setTimeout(function () {
	app.classList.remove('transition-out');
	overlay.classList.add('transition-out');
}, 300);
		
function makeRequest(url, type = 'GET' , callback = null) {
	request = new XMLHttpRequest();

	if (!request) {
		//Problem making request
	  	return false;
	}

	if (callback === null) {
		request.onreadystatechange = handleResponse;
	}
	else {
		request.onreadystatechange = callback;
	}
	request.open(type, url);
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded'); //or application/json;charset=UTF-8
	request.send();
}

function handleResponse() {
	if (request.readyState === XMLHttpRequest.DONE) {
	  if (request.status === 200) {
  		var response = JSON.parse(request.responseText);
    	//Request successful
    	console.log(response);
		version_tag.innerHTML = response.available;
		if(response.has_updates) {
			update_title.innerHTML = "Updates Found!";
			setTimeout(function() {
				update_title.innerHTML = "Installing Updates...";
				makeRequest('ajax/install_updates.php', 'GET', handleUpdateResponse); 
			}, 3000);
		}
		else {
			update_title.innerHTML = "Already Up to Date!";
			setTimeout(function() {
				document.getElementById('step-2').classList.add('transition-out');
				setTimeout(function() {
					document.getElementById('step-2').classList.add('hidden');
					document.getElementById('step-3').classList.remove('hidden');
					document.getElementById('step-3').classList.remove('transition-out');
				}, 500);
			}, 3000);
		}

	  } else {
		document.querySelector('#step-2').classList.add('transition-out');
		document.querySelector('#step-1').classList.remove('transition-out');
		button.disabled = false;
		button.textContent = "Update Check Failed. Try Again.";
		button.classList.remove('is-grey');
		button.classList.add('text-white');
		button.classList.add('bg-red');
    	//Problem with the request (500 error)
	  }
	}
}

function handleUpdateResponse() {
	if (request.readyState === XMLHttpRequest.DONE) {
	  if (request.status === 200) {
  		var response = JSON.parse(request.responseText);
    	//Request successful
    	console.log(response);
    	update_title.innerHTML = "Finishing Updates...";
		setTimeout(function() {
			document.getElementById('step-2').classList.add('transition-out');
			setTimeout(function() {
				document.getElementById('step-2').classList.add('hidden');
				document.getElementById('step-3').classList.remove('hidden');
				document.getElementById('step-3').classList.remove('transition-out');
			}, 500);
		}, 200);
		
	  } else {
		document.querySelector('#step-2').classList.add('transition-out');
		document.querySelector('#step-1').classList.remove('transition-out');
		button.disabled = false;
		button.textContent = "Update Check Failed. Try Again.";
		button.classList.remove('is-grey');
		button.classList.add('text-white');
		button.classList.add('bg-red');
    	//Problem with the request (500 error)
	  }
	}
}