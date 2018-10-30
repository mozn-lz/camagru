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
		<button id="clear-button">Clear</button>
		<canvas id="canvas"></canvas>
	</div>
	<div class="bottom-container">
		<div id="photos"></div>
	</div>
	
	<?php
	echo ("<div class=".$type.">".$message."</div>");
	// $_SESSION['type'] = "";
	// $_SESSION['message'] = "";
	?>
	
	<div>
		SELECT * FROM TABLE
	</div>
</section>

<section class="shadow-lg p-3 mb-5 bg-white " id="footer">
	<h2>footer</h2>
</section>

<?php include 'frame/tail.php'; ?>