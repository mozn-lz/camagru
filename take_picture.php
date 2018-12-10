<?php 
session_start();
$page_title = "Take selfie";
$sess = isset($_SESSION['id']) && isset($_SESSION['uName']) && isset($_SESSION['fName']) && isset($_SESSION['sName']) && isset($_SESSION['email']);
if ($sess) {
	$username = $_SESSION['uName'];
	$firstame = $_SESSION['fName'];
	$surname = $_SESSION['sName'];
	$email = $_SESSION['email'];
	include 'frame/head.php';
} else {
	$type		= "danger";
	$message	= "Plese login first<br>";
	header("Location: login.php?$type=$message");
	// header("Location: login.php");
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
		<h2>Take pic</h2>
		<?php include 'frame/messages.php'?>
		<div class="top-container">
			<div id="overlay-options">
				<input type="radio" name="overlay" value="#" id="none" checked="checked"> Ugly face
				<input type="radio" name="overlay" value="res/mask1.png" id="crazy"> crazy
				<input type="radio" name="overlay" value="res/mask2.png" id="catface"> catface

			</div>
			<div id="vid_div">
				<div>
					<button id="photo-button" class="btn btn-success">Take Photo</button>
					<!-- <input type="file" name="uploadImage" id="uploadImage" accept="image/gif, image/jpeg, image/png"> -->
					<input type="file" onchange="encodeImageFileAsURL(this)" />
					<!-- <button id="clear-button">Clear</button> -->
				</div>
				<div id="imgVidDiv">
					<img id="tmpImg" src=""  alt="">
					<video id="video">Stream broken...</video>
				</div>	
			</div>
			<div id="photos">
				<img id="selfie" src="" alt="" style="width:100%;max-width:300px">
				
				<!-- The Modal -->
				<div id="myModal" class="modal">
					<span class="close">&times;</span>
					<img class="modal-content" name="user_pic" id="img01">
					<div id="caption"></div>
					<form action="forms/user_tabe_function.php" method="post">
						<input class="hidden" type="text" id="thmb" name="thmb" value="#">
						<button name="cancel" value="cancel" type="submit">Cancel</button>
						<button name="submit" value="submit" type="submit">Save</button>
					</form>
				</div>
			</div>
		</div>
		<canvas id="canvas"></canvas>
	</section>
	
	<section class="shadow-lg p-3 mb-5 bg-white " id="footer">
		<h2>footer</h2>
	</section>
	<script src="./style/take_pic.js"></script>
</body>
</html>