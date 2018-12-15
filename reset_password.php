<?php 
session_start();
$page_title = "Camagru Password Reset";
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
	<?php include 'frame/messages.php'?>
	<?php
	if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
		// Verify
		try {
			// echo "0. Selceting user.<br>";
			$query = $conn->prepare("SELECT * FROM ".$usrsTB." WHERE email = :email AND confirm = :hash");
			$email = ($_GET['email']); // Set email variable
			// echo "email" . $email . "<br>";
			$hash = ($_GET['hash']); // Set hash variable
			// echo "hash" . $hash . "<br>";
			$query-> bindParam(':email', $email);
			$query-> bindParam(':hash', $hash);
			$query->execute();


			$result = $query->fetchAll();

			if ($count = $query->rowCount() == 1){
				$_SESSION['email'] = $result['email'];
			}
			else {
				$_SESSION['message'] = "Password authentication error, please reset your pasword again<br>";
				$_SESSION['type'] = 'danger';
			}
		}catch (PDOException $e){
			echo "Sql querry error: " . $e->getMessage() . "<br>";
		}
	}else {
		$message = "It's Possible you had a weak password<br>Make sure to have 8 charecters<br>min: 1 UPPER CASE, lowercase, and NUMBER<br>";
		$type = 'danger';
		header("Location: index.php?$type=$message");
		// header("Location: index.php");
	}
	?>
	<form name="reg_form" action="forms/form.php" onsubmit="return validateRegForm()" method="POST">
		<?php echo( "<input required type='hidden' class='form-control' id='email' name='reset_email' value='$email'>" )?>
		<div class="form-group">
			<label for="Password">Password</label>
			<input required type="password" class="form-control" id="reg_password1" name="password1" placeholder="Password">
		</div>
		<div class="form-group">
			<label for="Password2">Confirm Password</label>
			<input required type="password" class="form-control" id="reg_password2" name="password2" placeholder="Confirm Password">
		</div>
		<button type="submit" class="btn btn-default" name="reset_password" value="reset_password">Submit</button>
	</form>
</section>

<!-- footer startss here -->
<section class="shadow-lg p-3 mb-5 bg-white " id="footer">
	<h2>footer</h2>
</section>

<?php include 'frame/tail.php'; ?>