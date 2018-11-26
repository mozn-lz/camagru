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
		<h2>Login</h2>
			<div class="<?php echo $type; ?>"><?php echo $message; ?></div>
		<form name="reg_form" action="forms/form.php" onsubmit="return validateRegForm()" method="POST">
			<div class="form-group">
				<label for="Password">Password</label>
				<input required type="password" class="form-control" id="reg_password1" name="password1" placeholder="Password">
			</div>
			<div class="form-group">
				<label for="Password2">Confirm Password</label>
				<input required type="password" class="form-control" id="reg_password2" name="password2" placeholder="Confirm Password">
			</div>
			<button type="submit" class="btn btn-default" value="reset_password">Submit</button>
		</form>
	<?php
	// if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
		// Verify
		try {
			// echo "0. Selceting user.<br>";
			$query = $conn->prepare("SELECT * FROM ".$usrsTB." WHERE email = :email AND confirm = :hash");
			$email = ($_GET['email']); // Set email variable
			$hash = ($_GET['hash']); // Set hash variable
			$query-> bindParam(':email', $email);
			$query-> bindParam(':hash', $hash);
			$query->execute();

			// echo "User selection done.<br>";

			$result = $query->fetchAll();

			if ($count = $query->rowCount() == 1){
				// $usrTB = $result[0]['username'];
				$id			= $result[0]['id'];
				$username	= $result[0]['username'];
				$firstname	= $result[0]['firstname'];
				$lastname	= $result[0]['lastname'];
				$email		= $result[0]['email'];
			}
			else {
				$_SESSION['message'] = "It looks like your account has been verified. Please try to login, or contat our admin at email@email.mail<br>";
				$_SESSION['type'] = 'danger';
			}
		}catch (PDOException $e){
			echo "Sql querry error: " . $e->getMessage() . "<br>";
		}
		if (($count == 1) &&  ($result[0]['active'] == 0)) {
			try {
						// echo "1. Activating user.<br>";
				$active = 1;
				$stmt = $conn->prepare("UPDATE ".$usrsTB." SET active = :active WHERE email = :email AND confirm = :hash AND active = 0");
				$stmt->bindParam(':active', $active);
				$stmt->bindParam(':email', $email);
				$stmt->bindParam(':hash', $hash);
				$stmt->execute();
						// echo "User activated.<br>";
				$_SESSION['type'] = "success";
				$_SESSION['message'] = "Your account has been verified";
			}catch (PDOException $e){
				echo "Errorr creating user Data.<br>";
				echo "Sql querry error: " . $e->getMessage() . "<br>";
			}
			// header("Location: login.php");
		} else {
			$_SESSION['message'] = "It looks like your account has already been verified. <br>Please try to login, or contat our admin at email@email.mail<br>";
			$_SESSION['type'] = 'caution';
			// header("Location: login.php");
		}
	// }else{
	// 	$_SESSION['message'] = "Something went wrong, Don't worry you are safe now<br>";
	// 	$_SESSION['type'] = 'caution';
	// 	header("location: index.php");
	// }
	?>
</section>

<!-- footer startss here -->
<section class="shadow-lg p-3 mb-5 bg-white " id="footer">
	<h2>footer</h2>
</section>

<?php include 'frame/tail.php'; ?>