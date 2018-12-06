<?php 
session_start();
$page_title = "Camagru Verification";
include 'frame/head.php';
include 'forms/init_connect.php';
?>

<!-- header startss here -->
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

<!-- main startss here -->
<section class="shadow-lg p-3 mb-5 bg-white " id="main">
	<?php
	if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
		// Verify
		try {
			$query = $conn->prepare("SELECT * FROM ".$usrsTB." WHERE email = :email AND confirm = :hash");
			$email = ($_GET['email']); // Set email variable
			$hash = ($_GET['hash']); // Set hash variable
			$query-> bindParam(':email', $email);
			$query-> bindParam(':hash', $hash);
			$query->execute();


			$result = $query->fetchAll();

			if ($count = $query->rowCount() == 1){
				$id			= $result[0]['id'];
				$username	= $result[0]['username'];
				$firstname	= $result[0]['firstname'];
				$lastname	= $result[0]['lastname'];
				$email		= $result[0]['email'];
			}
			else {
				$type		= 'danger';
				$message	= "It looks like your account was verified before. Please try to login, or contat our admin at email@email.mail<br>";
				header("Location: login.php?$type=$message");
			}
		}catch (PDOException $e){
			echo "Sql querry error: " . $e->getMessage() . "<br>";
		}
		if (($count == 1) &&  ($result[0]['active'] == 0)) {
			try {
				$active = 1;
				$stmt = $conn->prepare("UPDATE ".$usrsTB." SET active = :active WHERE email = :email AND confirm = :hash AND active = 0");
				$stmt->bindParam(':active', $active);
				$stmt->bindParam(':email', $email);
				$stmt->bindParam(':hash', $hash);
				$stmt->execute();

				$type = "success";
				$message = "Your account has been verified";
				header("Location: login.php?$type=$message");
			}catch (PDOException $e){
				echo "Errorr creating user Data.<br>";
				echo "Sql querry error: " . $e->getMessage() . "<br>";
			}
			header("Location: login.php");
		} else {
			$type		= 'caution';
			$message	= "It looks like your account has already been verified. <br>Please try to login, or contat our admin at email@email.mail<br>";
			header("Location: login.php?$type=$message");
				// header("Location: login.php");
		}
	}else{
		$type = 'caution';
		$message = "Something went wrong, Don't worry you are safe now<br>";
		header("Location: login.php?$type=$message");
			// header("location: login.php");
	}
	?>
</section>

<!-- footer startss here -->
<section class="shadow-lg p-3 mb-5 bg-white " id="footer">
	<h2>footer</h2>
</section>

<?php include 'frame/tail.php'; ?>