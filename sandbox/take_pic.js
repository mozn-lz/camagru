let width = 500,
    height = 0,
    filter = 'none',
    streaming = false;

const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const photos = document.getElementById('photos');
const photoButton = document.getElementById('photo-button');
const clearButton = document.getElementById('clear-button');
const photoFilter = document.getElementById('photo-filter');




/******************/
/*     OVERLAY    */
/******************/

var none		= document.getElementById('none');
var crazy		= document.getElementById('crazy');
var catface		= document.getElementById('catface');
var anonimus	= document.getElementById('anonimus');
var cuagmire	= document.getElementById('cuagmire');
var sponge		= document.getElementById('sponge');
var classic		= document.getElementById('classic');

var overlay = document.getElementById('tmpImg');
// var img = document.getElementById('video');

none.addEventListener('change', function (e) {
	console.log("None");
	overlay.src=none.value;
}, false);
crazy.addEventListener('change', function (e) {
	console.log("crazy");
	overlay.src=crazy.value;
}, false);
catface.addEventListener('change', function (e) {
	console.log("catface");
	overlay.src=catface.value;
}, false);
anonimus.addEventListener('change', function (e) {
	console.log("anonimus");
	overlay.src=anonimus.value;
}, false);
cuagmire.addEventListener('change', function (e) {
	console.log("Cuagmire");
	overlay.src=cuagmire.value;
}, false);
sponge.addEventListener('change', function (e) {
	console.log("Sponge");
	overlay.src=sponge.value;
}, false);
classic.addEventListener('change', function (e) {
	console.log("Classic");
    overlay.src=classic.value;
    console.log(classic.value);
}, false);

/************************/
/*      TAKE PICTURE    */
/************************/

navigator.mediaDevices.getUserMedia({video: true, audio: false})
.then(function(stream) {
    // Link to video source
    video.srcObject = stream;
    // Play video
    video.play();
})
.catch(function (err) {
    console.log(`Error: ${err}`);
});

// Play when ready 
video.addEventListener('canplay', function (e) {
    if(!streaming) {
        height = video.videoHeight / (video.videoWidth/ width);
        video.setAttribute('width', width);
        video.setAttribute('height', height);
        canvas.setAttribute('width', width);
        canvas.setAttribute('height', height);

        streaming = true;
    }
}, false);
// Photo button Event Listener
photoButton.addEventListener('click', function (e) {
    takePicture();
    e.preventDefault();
}, false);

function takePicture() {
    // Create Canvas
    const context = canvas.getContext('2d');
	// console.log(overlay.src);
	var ovsr = overlay.src;
	console.log(ovsr);
    if (width && height) {
        canvas.width = width;
        canvas.height = height;
        // Draw image of the video on the canvas
        context.drawImage(video, 0, 0, width, height);
		context.drawImage(ovsr, 0, 0);

        // Create image from canvas
        const imgUrl = canvas.toDataURL('image/png');

		// Create image element
        const img = document.createElement('img');
        img.setAttribute('src', imgUrl);
        //  Add image to photos
        photos.appendChild(img);
    }
}


var c = document.getElementById("canvas");
var ctx = c.getContext("2d");
var img = document.getElementById("scream");
var img2 = new Image();
img2.src = 'https://cdn.sstatic.net/stackexchange/img/logos/so/so-icon.png';
  
$("#button1").click(function(){   
  ctx.drawImage(img,10,10);
});

  $("#button2").click(function(){   
  ctx.drawImage(img2,10,10);
});