<?php 
session_start();
$page_title = "Take selfie";
$sess = isset($_SESSION['id']) && isset($_SESSION['uName']) && isset($_SESSION['fName']) && isset($_SESSION['sName']) && isset($_SESSION['email']);
if ($sess) {
	$usrTB = $_SESSION['uName'];
	$username = $_SESSION['uName'];
	$firstame = $_SESSION['fName'];
	$surname = $_SESSION['sName'];
	$email = $_SESSION['email'];
	include 'frame/head.php';
	include 'forms/init_connect.php';
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
		<h2>Take pic</h2>
		<?php 
			try {
				$query = $conn->prepare("SELECT * FROM ".$usrTB);
				$query->execute();
				// echo "Select query Executed successfully <br>";
	
				$result = $query->fetchAll();
				$count = count($result);
			if ($count > 0){
					echo "<br>";
					$i = $count - 1;
						// echo "i: $i <br>";
					while ($i >= 0) {
						// if (count($result[$i]['likes'] == 0) {
						// 	echo "likes";
						// } else {
						// 	echo count($result[$i]['likes']);
						// }
						echo ("
						<div class='display_grp col-md-3'>
							<div class='user_pic'>
								<img src=".$result[$i]['image']." alt=''>
							</div>
							<div class='user_picuser_pic'>
								<!-- <div class='inline time'>".$result[$i]['time']."</div> -->
								<form action='forms/user_tabe_function.php' method='post'>
									<div class='inline form-group coment'>
										<input type='text' name='img_details' value=".$result[$i].">   <!-- Hidden line !!!!REMEMBER TO SET AS HIDDENT IN CSS -->
										<input type='text' name='comment' class='form-control' placeholder='Comment' id=''>
										<button type='submit' class='btn btn-success'>Comment</button>
									</div>
									<!-- <div class='inline btn btn-primary likes' name='likes'>".count($result[$i]['likes'])." Likes</div> -->
									<button type='submit' name='likes' class='btn btn-primary'>".count($result[$i]['likes'])." Likes</button>
								</form>
								<div id='comments'></div>
							</div>
						</div>");
						$i--;
					}
				}
				else {
					$_SESSION['message'] = "It looks like your account has been verified. Please try to login, or contat our admin at email@email.mail<br>";
					$_SESSION['type'] = 'danger';
				}
			}catch (PDOException $e){
				echo "Sql querry error: " . $e->getMessage() . "<br>";
			}
		?>
	</section>

	<section class="shadow-lg p-3 mb-5 bg-white " id="footer">
		<h2>footer</h2>
	</section>
	
	<script src="./style/masterjs.js"></script>
<?php include 'frame/tail.php'; ?>
