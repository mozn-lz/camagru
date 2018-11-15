let width = 500,
	height = 0,
	filter = 'none',
	streaming = false;

const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const photos = document.getElementById('photos');
const photoButton = document.getElementById('photo-button');
const clearButton = document.getElementById('clear-button');
const photoFiller = document.getElementById('photo-filler');



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
	console.log(classic.value);
	overlay.src=classic.value;
}, false);

/*--------------------------------------------End Overlay---------------------------------*/


/************************/
/*      Take Picture    */
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
	if (width && height) {
		canvas.width = width;
		canvas.height = height;
		// Draw image of the video on the canvas
		context.drawImage(video, 0, 0, width, height);
		context.drawImage(overlay, 150, 0, 200, 200);

		// Create image from canvas
		const imgUrl = canvas.toDataURL('image/png');
		// Create image element
		const capture = document.createElement('img');
		capture.setAttribute('src', imgUrl);             // later


		var imageObj1 = new Image();
		var imageObj2 = new Image();
		imageObj1 = capture;
		console.log("Obj1: " + imageObj1 + '\n');
		
		imageObj1.onload = function() {
			context.drawImage(imageObj1, 0, 0, width, height);
			// imageObj2.src = 'res/mask1.png';
			imageObj2 = (overlay);
		console.log("Obj2: " + imageObj2.src + '\n');
			imageObj2.onload = function() {
				context.drawImage(imageObj2, 0, 0, width, height);
				var img = context.toDataURL("image/png");
				// document.write(' <img src="' + img + '" width="50%" height="%"/>');
				// document.write('<img src="' + capture + '" width="50%" height="%"/>');
				// photos.appendChild(img);
			}
		};
	}
	// document.write('1. <img src="' + imageObj1.src + '" width="%" height="%"/><br>' );
	var selfiePic = document.getElementById('selfie');
	var modal = document.getElementById('myModal');

	// Get the image and insert it inside the modal - use its "alt" text as a caption
	// var img = document.getElementById('selfie');
	var modalImg = document.getElementById("img01");
	var captionText = document.getElementById("caption");

	
	selfiePic.addEventListener('load', function () {
		overlay.style.display = "none";
		video.style.display = "none";
		modal.style.display = "block";
		modalImg.src = this.src;
	    captionText.innerHTML = this.alt;
	});
	selfiePic = document.getElementById('selfie').src = imageObj1.src;
	document.getElementById('thmb').value = selfiePic;
	console.log("Img: " + document.getElementById('thmb').value);
	

	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("close")[0];
	
	// When the user clicks on <span> (x), close the modal
	span.onclick = function() { 
		window.location.replace('./take_picture.php');
		modal.style.display = "none";
	}
	

}
/*-------------------------------------------------------------------------------------------------------*/

// var imageObj1 = new Image();
// var imageObj2 = new Image();
// imageObj1.src = imgUrl;
// imageObj1.onload = function() {
//     context.drawImage(imageObj1, -1, -30, 150, 300);
//     imageObj2.src = document.getElementById('img2').src;
//     imageObj2.onload = function() {
//         context.drawImage(imageObj2, 0, 0, 300, 150);
//         var img = c.toDataURL("image/png");
//         document.write('<img src="' + img + '" width="50%" height="%"/>');
//    }
// };



// var c=document.getElementById("myCanvas");
// var ctx=c.getContext("2d");
// var imageObj1 = new Image();
// var imageObj2 = new Image();
// imageObj1.src =  document.getElementById('img1').src;
// imageObj1.onload = function() {
//     ctx.drawImage(imageObj1, -1, -30, 150, 300);
//     imageObj2.src = document.getElementById('img2').src;
//     imageObj2.onload = function() {
//         ctx.drawImage(imageObj2, 0, 0, 300, 150);
//         var img = c.toDataURL("image/png");
//         document.write('<img src="' + img + '" width="50%" height="%"/>');
//    }
// };

/*-------------------------------------------------------------------------------------------------------*/

clearButton.addEventListener('change', function (e) {
	photos.innerHTML = '';
	
});


