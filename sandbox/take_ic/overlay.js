var none		= document.getElementById('none');
var crazy		= document.getElementById('crazy');
var catface		= document.getElementById('catface');
var anonimus	= document.getElementById('anonimus');
var cuagmire	= document.getElementById('Cuagmire');
var sponge		= document.getElementById('Sponge');
var classic		= document.getElementById('Classic');

// var img = document.getElementById('tmpImg');
var img = document.getElementById('video');

none.addEventListener('change', function (e) {
	console.log("None");
	img.src=none.value;
}, false);
crazy.addEventListener('change', function (e) {
	console.log("crazy");
	img.src=crazy.value;
}, false);
catface.addEventListener('change', function (e) {
	console.log("catface");
	img.src=catface.value;
}, false);
anonimus.addEventListener('change', function (e) {
	console.log("anonimus");
	img.src=anonimus.value;
}, false);
cuagmire.addEventListener('change', function (e) {
	console.log("Cuagmire");
	img.src=cuagmire.value;
}, false);
sponge.addEventListener('change', function (e) {
	console.log("Sponge");
	img.src=sponge.value;
}, false);
classic.addEventListener('change', function (e) {
	console.log("Classic");
	img.src=classic.value;
}, false);
