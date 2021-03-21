var app = document.getElementById("app");
var errors_list = document.getElementById("errors");

var displays = document.querySelectorAll('.display');

displays.forEach(display => {
	display.querySelector(".send_message").addEventListener('click', function() {
		var formdata = new FormData();
		formdata.append("message", display.querySelector('[name="message"]').value);
		formdata.append("duration", display.querySelector('[name="duration"]').value);
		formdata.append("topic", display.querySelector('[name="topic"]').value);
		makeRequest('ajax/display_message.php', 'POST', formdata, display.querySelector('.send_message'));
	});
});
  
function makeRequest(url, type = 'POST' , data = null, button_element = null) {
	request = new XMLHttpRequest();

	if (!request) {
		//Problem making request
		return false;
	}
	if (data === null) {
		console.log("Defaulting form data.");
		data = new FormData();
	}

	button_element.textContent = "Sending...";
	button_element.disabled = true;
	button_element.classList.add('is-grey');
	button_element.classList.remove('is-primary');
	errors_list.classList.remove("bg-red-light");
	errors_list.classList.remove("p-2");

	request.onreadystatechange = handle_response(button_element);
	
	request.open(type, url);
	// request.setRequestHeader('Accept', 'application/json'); //or application/json;charset=UTF-8
	setCSRFHeader(request, type, data);
	request.send(data);
}

function handle_response(button = null) {
	return function() {
		if (request.readyState === XMLHttpRequest.DONE) {
		  if (request.status === 200 || request.status === 201) {
			var response = JSON.parse(request.responseText).data;
			console.log(response);
			//Request successful
			button.textContent = "Send Message";
			button.disabled = false;
			button.classList.remove('is-grey');
			button.classList.add('is-primary');

		  } else {
			var response = JSON.parse(request.responseText);
			errors_list.classList.add("bg-red-light");
			errors_list.classList.add("p-2");
			let errors = `<p>${response.message}</p><ul>`;
			for (var e in response.errors) {
				errors += `<li class="text-xs">${e} - ${response.errors[e][0]}</li>`;
			}
			errors += `</ul>`;
			errors_list.innerHTML = errors;
			button.disabled = false;
			button.textContent = "Create Account";
			button.classList.remove('is-grey');
			button.classList.add('is-white');
			//Problem with the request (500 error)
		  }
		}
	};
}

function setCSRFHeader(xhr, type, d) {
	var csrfToken = document.querySelector('meta[name=csrf_token]').getAttribute('content');
	if (/^(POST|PATCH|PUT|DELETE)$/i.test(type)) {
		d.append("csrf_token", csrfToken);
		xhr.setRequestHeader("X-CSRF-Token", csrfToken);
	}
}