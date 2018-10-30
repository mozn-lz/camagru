<?php 
session_start();
$page_title = "Camagru Home";
$sess = isset($_SESSION['id']) && isset($_SESSION['uName']) && isset($_SESSION['fName']) && isset($_SESSION['sName']) && isset($_SESSION['email']);
// if ($sess) {
// 	$username = $_SESSION['uName'];
// 	$firstame = $_SESSION['fName'];
// 	$surname = $_SESSION['sName'];
// 	$email = $_SESSION['email'];
	include 'frame/head.php';
// } else {
// 	header("Location: login.php");
// }
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
		<div id="vid_div">
			<img id="image" src="#" alt="image load error">
			<video id="video">Stream broken...</video>
		</div>
			<select id="photo-overlay">
				<option value="">none</option>
				<option id="1" value="https://dumielauxepices.net/sites/default/files/catwoman-clipart-face-883550-3607898.png">crazy hair</option>
				<option id="2" value="http://shopforclipart.com/images/funny-face-clipart/20.jpg">catface</option>
				<option id="3" value="http://www.transparentpng.com/thumb/anonymous-mask/face-mask-funny-fear-nickname-face-anonymous-mask-png-images--15.png">anonimus</option>
				<option id="4" value="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRbZ-iwDmJ742m1J2SudaOQJ7qbCLdEruSfTQYoZOPVf6yR8y_Z4Q">Cuagmire</option>
				<option id="5" value="https://png.pngtree.com/element_pic/16/12/01/5b3008293536496b29c22ef56c3c9e92.jpg">Sponge</option>
				<option id="6" value="https://www.clipartmax.com/png/middle/18-187369_face-glasses-clipart-funny-face-icon-png.png">Classic disguise</option>
			</select>
		<button id="photo-button" class="btn btn-dark">Take Photo</button>
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

<?php include 'frame/tail.php'; ?>