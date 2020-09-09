var app = document.getElementById("app");
var button = document.getElementById("continue");
var message = document.getElementById("message");
var title = document.getElementById("title");
var content = document.querySelector(".content");
var overlay = document.querySelector(".overlay");
let step = 0;
let steps = [
	'In the next few steps you will be guided through the MudPi setup process.',
	''

];
let titles = [
	'Welcome!',
	'Lets Get Started!'
];

setTimeout(function () {
	content.classList.remove('transition-out');
	app.classList.add('step-1');
}, 600);
setTimeout(function () {
	button.classList.remove('transition-out');
}, 3000);

button.addEventListener('click', function() {
	content.classList.add('transition-out');
	button.classList.add('transition-out');
	if (step >= 7) {
		overlay.classList.remove('transition-out');
		setTimeout(function() {
			window.location.href = 'logs.php';
		}, 600);
	}
	else {
		app.classList.remove(`step-${step+1}`);
		step++;
		app.classList.add(`step-${step+1}`);
		setTimeout(function() {
			message.innerHTML = steps[step];
			title.innerHTML = titles[step];
			content.classList.remove('transition-out');
			setTimeout(function() {
				button.classList.remove('transition-out');
			}, 600);
		}, 400);
	}
	
});