<?php 
session_start();
$page_title = "Take selfie";
$sess = isset($_SESSION['id']) && isset($_SESSION['uName']) && isset($_SESSION['fName']) && isset($_SESSION['sName']) && isset($_SESSION['email']);
include 'frame/head.php';
include 'forms/init_connect.php';
if ($sess) {
	$username	= $_SESSION['uName'];
	$firstame	= $_SESSION['fName'];
	$surname	= $_SESSION['sName'];
	$email		= $_SESSION['email'];
} else {
//	header("Location: login.php");
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
		<div>
			<a href="take_picture.php">
				<button type="submit" name="delete_profile" class="btn btn-primary btn-lg">Take Picture</button>
			</a>
		</div>
		<?php 
			try {
				$query = $conn->prepare("SELECT * FROM ".PICTABLE);
				$query->execute();

				$result = $query->fetchAll();
				$count = count($result);
				if ($count > 0){
					echo "<br>";
					$i = $count - 1;
					while ($i >= 0) {
						echo ("
						<div class='display_grp col-md-3'>
							<div class='user_pic'>
								<img src=".$result[$i]['image']." alt=''>
							</div>
							<div class='user_picuser_pic'>
								<form action='forms/user_tabe_function.php' method='POST'>
									<div class='inline form-group coment'>
										<input type='hidden' name='img_details' value=".$result[$i]['id'].">
										<input type='text' name='comment' class='form-control' placeholder='Comment' id=''>
									</div>
									<button type='submit' name='comments' value='comments' class='btn btn-success'>Comment</button>
									<button type='submit' name='likes' value='likes' class='btn btn-primary'>".$result[$i]['likes']." Likes</button>
									<button type='submit' name='delete_img' value='delete_img' class='btn btn-danger'>Delete</button>
								</form>
								<div class='comments'>".$result[$i]['coments']."</div>
							</div>
						</div>");
						$i--;
					}
				}
				else {
					echo"This is eemarassing... It looks like user no users and posted any pictures yet.<br>
					Click on the take picture to be the first.";
					// $_SESSION['message'] = "It looks like your account has been verified. Please try to login, or contat our admin at email@email.mail<br>";
					// $_SESSION['type'] = 'danger';
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
