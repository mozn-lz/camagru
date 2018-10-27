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
	<!-- echo ("<div class=".$type.">".$message."</div>"); -->
	<div id="myOnlineCamera">
		<video></video>
		<canvas></canvas>
		<button>Take Photo!</button>
	</div>
	
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
// var video = document.getElementById('video');
// if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
//  navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
//  video.src = window.URL.createObjectURL(stream);
//  video.play();
//  });
// }


function startWebcam(stream){

var myOnlineCamera    = getElementById('myOnlineCamera'),
	video            = myOnlineCamera.querySelectorAll('video'),
	canvas            = myOnlineCamera.querySelectorAll('canvas');

video.width = video.offsetWidth;

if(navigator.getUserMedia){                    // Standard
	video.src = stream;
	video.play();
}else if(navigator.webkitGetUserMedia){        // WebKit
	video.src = window.webkitURL.createObjectURL(stream);
	video.play();
}else if(navigator.mozGetUserMedia){        // Firefox
	video.src = window.URL.createObjectURL(stream);
	video.play();
};

// Click to take the photo
$('#webcam-popup .takephoto').click(function(){
	// Copying the image in a temporary canvas
	var temp = document.createElement('canvas');

	temp.width  = video.offsetWidth;
	temp.height = video.offsetHeight;

	var tempcontext = temp.getContext("2d"),
		tempScale = (temp.height/temp.width);

	temp.drawImage(
		video,
		0, 0,
		video.offsetWidth, video.offsetHeight
	);

	// Resize it to the size of our canvas
	canvas.style.height    = parseInt( canvas.offsetWidth * tempScale );
	canvas.width        = canvas.offsetWidth;
	canvas.height        = canvas.offsetHeight;
	var context        = canvas.getContext("2d"),
		scale        = canvas.width/temp.width;
	context.scale(scale, scale);
	context.drawImage(bigimage, 0, 0);
});
};
</script>

<?php include 'frame/tail.php'; ?>