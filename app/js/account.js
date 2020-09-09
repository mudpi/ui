var app = document.getElementById("app");
var overlay = document.querySelector('.overlay');
var button = document.getElementById("create");
// var button_continue = document.getElementById("continue");
var token_tag = document.getElementById("token");
var errors_list = document.getElementById("errors");
var name_input = document.querySelector('[name="name"]');
var email_input = document.querySelector('[name="email"]');
var pass_input = document.querySelector('[name="password"]');
var pass_confirm_input = document.querySelector('[name="password_confirmation"]');

setTimeout(function () {
	app.classList.remove('transition-out');
	overlay.classList.add('transition-out');
}, 300);

button.addEventListener('click', function() {
	var formdata = new FormData();
	formdata.append("name", name_input.value);
	formdata.append("email", email_input.value);
	formdata.append("password", pass_input.value);
	formdata.append("password_confirmation", pass_confirm_input.value);
	makeRequest('http://mudapi.test/api/register', 'POST', formdata);
});
  
function makeRequest(url, type = 'POST' , data = null, callback = null) {
	request = new XMLHttpRequest();

	if (!request) {
		//Problem making request
	  	return false;
	}
	if (data === null) {
		console.log("Defaulting form data.");
		data = new FormData();
	}

	button.textContent = "Creating Account...";
	button.disabled = true;
	button.classList.add('is-grey');
	button.classList.remove('is-white');
  	errors_list.classList.remove("bg-red-light");
  	errors_list.classList.remove("p-2");

	if (callback === null) {
		request.onreadystatechange = handleResponse;
	}
	else {
		request.onreadystatechange = callback;
	}
	request.open(type, url);
	request.setRequestHeader('Accept', 'application/json'); //or application/json;charset=UTF-8
	request.send(data);
}

function handleResponse() {
	if (request.readyState === XMLHttpRequest.DONE) {
	  if (request.status === 200 || request.status === 201) {
  		var response = JSON.parse(request.responseText).data;
  		console.log(response);
    	//Request successful
		button.textContent = "Continue";
		button.disabled = false;
		button.classList.remove('is-grey');
		button.classList.add('is-primary');
		token_tag.innerHTML = response.token;
		document.getElementById('name').innerHTML = response.name;
		document.getElementById('email').innerHTML = response.email;
		document.getElementById('form').classList.add('transition-out');
		setTimeout(function() {
			document.getElementById('account').classList.remove('transition-out');
		}, 400);

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
}