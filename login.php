<?php 
session_start();
$page_title = "Camagru Logon";
include 'frame/head.php';
$sess = isset($_SESSION['id']) && isset($_SESSION['uName']) && isset($_SESSION['fName']) && isset($_SESSION['sName']) && isset($_SESSION['email']);
if ($sess) {
	$username	= $_SESSION['uName'];
	$firstame	= $_SESSION['fName'];
	$surname	= $_SESSION['sName'];
	$email		= $_SESSION['email'];
	header("Location: index.php");
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
	<h2>Login</h2>
	<?php include 'frame/messages.php'?>
	<form name="reg_form" action="forms/form.php" onsubmit="return validateRegForm()" method="POST">
		<div class="form-group">
			<label for="email">Email address</label>
			<input required type="email" class="form-control" id="loginEmail" name="loginEmail" placeholder="Email" >
		</div>
		<div class="form-group">
			<label for="password">Password</label>
			<input required type="password" class="form-control" id="loginPassword" name="loginPassword" placeholder="Password">
		</div>
		<button type="submit" class="btn btn-default" value="login">Submit</button>
	</form>
	<div class="col-xs-6 tex-left"><a href="register.php">Don't have an account? Click to register</a></div>
	<div class="col-xs-6 text-right"><a href="./forgot_password.php">Forgot password?</a></div>
</section>

<!-- footer startss here -->
<section class="shadow-lg p-3 mb-5 bg-white " id="footer">
	<h2>footer</h2>
</section>

<?php 
// $_SESSION['type'] = '';
// $_SESSION['message'] = '';
include 'frame/tail.php'; 
?>