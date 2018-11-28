<?php 
session_start();
$page_title = "Profile";
$sess = isset($_SESSION['id']) && isset($_SESSION['uName']) && isset($_SESSION['fName']) && isset($_SESSION['sName']) && isset($_SESSION['email']);
if ($sess) {
	$username = $_SESSION['uName'];
	$firstame = $_SESSION['fName'];
	$surname = $_SESSION['sName'];
	$email = $_SESSION['email'];
	include 'frame/head.php';
} else {
	$_SESSION['message'] = "Please login/register to access that page<br>";
	$_SESSION['type'] = "danger";
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
	<div class="row">
		<div class="col-sm-8">
			<h2>Profile</h2>
		</div>
		<div class="col-sm-4">
			<input type="hidden" name="delete_user" id="delete_user">
			<a href="./forms/create_user.php"><button type="button" onclick="confirmation()" class="btn btn-danger btn-lg">Delete Account</button></a>
		</div>
	</div>
	<?php
	echo ("<div class=".$type.">".$message."</div>");
	// $_SESSION['type'] = '';
	// $_SESSION['message'] = '';
	?>
	<div>
		<form action="forms/form.php" method="POST">
			<div class="form-row">
				<div class="form-group col-sm-6">
					<label for="userName">First Name</label>
					<input type="text" class="form-control" name="fname" <?php echo "value=".$firstame ?> placeholder="First Name">
				</div>
				<div class="form-group col-sm-6">
					<label for="userName">Last Name</label>
					<input type="text" class="form-control" name="sname" <?php echo "value=".$surname ?> placeholder="Last Name">
				</div>
			</div>
			<div class="form-group">
				<label for="Email">Email address</label>
				<input type="email" class="form-control" name="email" <?php echo "value=".$email ?> placeholder="Email">
			</div>
		<button type="submit" class="btn btn-default" value="updte">Save</button>
	</form>
	</div>
</section>
<section class="shadow-lg p-3 mb-5 bg-white " id="footer">
	<h2>footer</h2>
</section>

<?php include 'frame/tail.php'; ?>