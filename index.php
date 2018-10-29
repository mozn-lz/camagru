<?php 
session_start();
$page_title = "Camagru Home";
$sess = isset($_SESSION['id']) && isset($_SESSION['uName']) && isset($_SESSION['fName']) && isset($_SESSION['sName']) && isset($_SESSION['email']);
if ($sess) {
	$username = $_SESSION['uName'];
	$firstame = $_SESSION['fName'];
	$surname = $_SESSION['sName'];
	$email = $_SESSION['email'];
	include 'frame/head.php';
} else {
	header("Location: login.php");
}
?>

<section class="shadow-lg p-3 mb-5 bg-white " id="header">
	<ul class="nav nav-pills">
		<li role="presentation" class="active"><a href="index.php">Comagaru</a></li>
		<li role="presentation"><a href="profile.php">Profile</a></li>
		<?php 
		if ($sess) 
			echo '<li role="presentation"><a href="forms/logout.php">Logout</a></li>';
		else
			echo '<li role="presentation"><a href="login.php">Login</a></li>';
		?>
	</ul>
</section>

<section class="shadow-lg p-3 mb-5 bg-white " id="main">
	<h2>MaiN</h2>
	<div class="top-container">
		<video id="video">Stream broken...</video>
		<button id="photo-button" class="btn btn-dark">Take Photo</button>
		<select id="photo-filter">
			<option value="none">none</option>
			<option value="grayscale(100%)">grayscale</option>
			<option value="sepia(100%)">sepia</option>
			<option value="invert(100%)">invert</option>
			<option value="hue-rotate(90deg)"></option>
			<option value="blur(10px)">blur</option>
			<option value="contrust(200%)">contrust</option>
		</select>
		<button id="clear-button">Clear</button>
		<canvas id="canvas"></canvas>
	</div>
	<div class="bottom-container">
		<div id="photos"></div>
	</div>

	<!-- echo ("<div class=".$type.">".$message."</div>"); -->
	<!-- <div id="myOnlineCamera"> -->
		<!-- <video id="video" autoplay></video>
		<canvas ></canvas> -->
		<!-- <button>Take Photo!</button> -->
	<!-- </div> -->
	
	<?php
	echo ("<div class=".$type.">".$message."</div>");
	// $_SESSION['type'] = "";
	// $_SESSION['message'] = "";
	?>
	
	<div>
		SELECT * FROM TABLE
		<!-- <center>
			<video id="video" width="640" height="480" autoplay></video>
		</center> -->
	</div>
</section>

<section class="shadow-lg p-3 mb-5 bg-white " id="footer">
	<h2>footer</h2>
</section>
<script>
navigator.getUserMedia(
    // Options
    {
        video: true
    },
    // Success Callback
    function(stream){

        // Create an object URL for the video stream and
        // set it as src of our HTLM video element.
        video.src = window.URL.createObjectURL(stream);

        // Play the video element to show the stream to the user.
        video.play();

    },
    // Error Callback
    function(err){
        // Most common errors are PermissionDenied and DevicesNotFound.
        console.error(err);
    }
);
function takeSnapshot(){
	var hidden_canvas = document.querySelector('canvas'),
		video = document.querySelector('video.camera_stream'),
		image = document.querySelector('img.photo'),

	// Get the exact size of the video element.
	width = video.videoWidth,
	height = video.videoHeight,

	// Context object for working with the canvas.
	context = hidden_canvas.getContext('2d');

	// Set the canvas to the same dimensions as the video.
	hidden_canvas.width = width;
	hidden_canvas.height = height;

	// Draw a copy of the current frame from the video on the canvas.
	context.drawImage(video, 0, 0, width, height);

	// Get an image dataURL from the canvas.
	var imageDataURL = hidden_canvas.toDataURL('image/png');

	// Set the dataURL as source of an image element, showing the captured photo.
	image.setAttribute('src', imageDataURL); 

}

function takeSnapshot(){

//...

// Get an image dataURL from the canvas.
var imageDataURL = hidden_canvas.toDataURL('image/png');

// Set the href attribute of the download button.
document.querySelector('#dl-btn').href = imageDataURL;
}

// var video = document.getElementById('video');
// if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
//  navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
//  video.src = window.URL.createObjectURL(stream);
//  video.play();
//  });
// }


// function startWebcam(stream){

// 	var myOnlineCamera    = getElementById('myOnlineCamera'),
// 		video            = myOnlineCamera.querySelectorAll('video'),
// 		canvas            = myOnlineCamera.querySelectorAll('canvas');

// 	video.width = video.offsetWidth;

// 	if(navigator.getUserMedia){                    // Standard
// 		video.src = stream;
// 		video.play();
// 	}else if(navigator.webkitGetUserMedia){        // WebKit
// 		video.src = window.webkitURL.createObjectURL(stream);
// 		video.play();
// 	}else if(navigator.mozGetUserMedia){        // Firefox
// 		video.src = window.URL.createObjectURL(stream);
// 		video.play();
// 	};

// 	// Click to take the photo
// 	$('#webcam-popup .takephoto').click(function(){
// 		// Copying the image in a temporary canvas
// 		var temp = document.createElement('canvas');

// 		temp.width  = video.offsetWidth;
// 		temp.height = video.offsetHeight;

// 		var tempcontext = temp.getContext("2d"),
// 			tempScale = (temp.height/temp.width);

// 		temp.drawImage(
// 			video,
// 			0, 0,
// 			video.offsetWidth, video.offsetHeight
// 		);

// 		// Resize it to the size of our canvas
// 		canvas.style.height    = parseInt( canvas.offsetWidth * tempScale );
// 		canvas.width        = canvas.offsetWidth;
// 		canvas.height        = canvas.offsetHeight;
// 		var context        = canvas.getContext("2d"),
// 			scale        = canvas.width/temp.width;
// 		context.scale(scale, scale);
// 		context.drawImage(bigimage, 0, 0);
// 	});
// };
</script>

<?php include 'frame/tail.php'; ?>