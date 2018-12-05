let width		= 500,
	height		= 0,
	filter		= 'none',
	streaming	= false;

const canvas		= document.getElementById('canvas');
const photos		= document.getElementById('photos');
const photoButton	= document.getElementById('photo-button');
const photoFiller	= document.getElementById('photo-filler');

var video			= document.getElementById('video');
var uploadImage		= document.getElementById('uploadImage');

uploadImage.addEventListener('change', function () {
	console.log("1\n");
	var fReader = new FileReader();
	fReader.readAsDataURL(uploadImage.files[0]);
	console.log("2\n");
	fReader.onloadend = function(event){
		console.log("3\n");
		// var img = document.getElementById("yourImgTag");
		// img.src = event.target.result;
		console.log("4\n");
		console.log("1. uploadImage.value: " + uploadImage);
		console.log("2. uploadImage.FILES: " + uploadImage).files[0];
		console.log("3. uploadImage.value: " + uploadImage).value;
	}
});


/******************/
/*     OVERLAY    */
/******************/

var none		= document.getElementById('none');
var crazy		= document.getElementById('crazy');
var catface		= document.getElementById('catface');

var overlay = document.getElementById('tmpImg');

none.addEventListener('change', function (e) {
	overlay.src=none.value;
}, false);
crazy.addEventListener('change', function (e) {
	overlay.src=crazy.value;
}, false);
catface.addEventListener('change', function (e) {
	overlay.src=catface.value;
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

/**************************************************************************/

// uploadImage.onclick = function(){
// 	var context;
// 	canvas.width = width;
// 	canvas.height = height;
// 	// Draw image of the video on the canvas
// 	context.drawImage(uploadImage, 0, 0, width, height);
// 	context.drawImage(overlay, 150, 0, 200, 200);
// 	const imgUrl = canvas.toDataURL("image/png");
// }
/**************************************************************************/

uploadImage.addEventListener( 'change', function(){
	console.log("uploadImage.value: " + uploadImage);

	// video.setAttribute('display', 'none');
	video.style.display = "none"
	console.log('hidden\n');
	var nwImg  = document.createElement('img');
	nwImg.setAttribute('src', uploadImage.value);
	document.getElementById('imgVidDiv').appendChild(nwImg);
});

function takePicture() {
	// Create Canvas
	const context = canvas.getContext('2d');
	if (width && height) {
		console.log("uploadImage.value: " + uploadImage.value);
		
		if (uploadImage.value != null && uploadImage.value != "") {
			canvas.width = width;
			canvas.height = height;
			// Draw image of the video on the canvas
			context.drawImage(uploadImage, 0, 0, width, height);
			context.drawImage(overlay, 150, 0, 200, 200);

			// Create image from canvas
			const imgUrl = canvas.toDataURL("image/png");
			// Create image element
			
			// console.log(imgUrl);
			const capture = document.createElement('img');
			capture.setAttribute('src', imgUrl);             // later

			var imageObj1 = new Image();
			var imageObj2 = new Image();
			imageObj1 = capture;
			// console.log("Obj1: " + imageObj1 + '\n');

			imageObj1.onload = function() {
				context.drawImage(imageObj1, 0, 0, width, height);
				imageObj2 = (overlay);
				imageObj2.onload = function() {
					context.drawImage(imageObj2, 0, 0, width, height);
					var img = context.toDataURL("image/png");
				}
			};
		} else {
			canvas.width = width;
			canvas.height = height;
			// Draw image of the video on the canvas
			context.drawImage(video, 0, 0, width, height);
			context.drawImage(overlay, 150, 0, 200, 200);
	
			// Create image from canvas
			const imgUrl = canvas.toDataURL("image/png");
			// Create image element
			//mj
			// console.log(imgUrl);
			const capture = document.createElement('img');
			capture.setAttribute('src', imgUrl);             // later
	
			var imageObj1 = new Image();
			var imageObj2 = new Image();
			imageObj1 = capture;
			// console.log("Obj1: " + imageObj1 + '\n');
	
			imageObj1.onload = function() {
				context.drawImage(imageObj1, 0, 0, width, height);
				imageObj2 = (overlay);
				imageObj2.onload = function() {
					context.drawImage(imageObj2, 0, 0, width, height);
					var img = context.toDataURL("image/png");
				}
			};
		}
	}

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
	//mj console.log("Img: " + document.getElementById('thmb').value);	

	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("close")[0];
	
	// When the user clicks on <span> (x), close the modal
	span.onclick = function() { 
		window.location.replace('./take_picture.php');
		modal.style.display = "none";
	}
}
