<?php 
session_start();
$page_title = "Camagru lost passwords";
$sess = isset($_SESSION['id']) && isset($_SESSION['uName']) && isset($_SESSION['fName']) && isset($_SESSION['sName']) && isset($_SESSION['email']);
include 'frame/head.php';
include 'forms/init_connect.php';
if ($sess) {
	$username = $_SESSION['uName'];
	$firstame = $_SESSION['fName'];
	$surname = $_SESSION['sName'];
	$email = $_SESSION['email'];
}
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
	if ($sess) {
		echo "<h2>Reset Password</h2>";
	}else{
		echo "<h2>Forgot Password</h2>";
	}
	?>
	<?php include 'frame/messages.php'?>
	<!-- <div class="<?php echo $type; ?>">
		<?php echo $message; ?>
	</div> -->
	<form name="reg_form" action="forms/form.php" method="POST">
		<div class="form-group">
			<label for="email">Email address</label>
			<input required type="email" class="form-control" id="reset_email" name="reset_email" placeholder="Email" >
		</div>
		<button type="submit" class="btn btn-success" name="forgot_password" value="forgot_password">Submit</button>
	</form>
	<?php 
		if ($sess) {
			echo '<p>1. You will be logged out <br>2. Then an email will be sent to your account<br>3. You will have to fillow that link to reset your password</p>';
		}
		else{
			$noAcc = '<div class="col-xs-6 tex-left"><a href="register.php">Don\'t have an account? Click to register</a></div>';
			echo $noAcc;
			echo '<div class="col-xs-6 text-right"><a href="login.php">Know your login details? Click here</a></div>';
		}
	?>
</section>

<!-- footer startss here -->
<section class="shadow-lg p-3 mb-5 bg-white " id="footer">
	<h2>footer</h2>
</section>

<?php 
include 'frame/tail.php'; 
?>