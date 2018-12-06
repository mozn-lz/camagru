<?php 
session_start();
$page_title = "Profile";
$sess = isset($_SESSION['id']) && isset($_SESSION['uName']) && isset($_SESSION['fName']) && isset($_SESSION['sName']) && isset($_SESSION['email']);
if ($sess) {
	$username = $_SESSION['uName'];
	$firstame = $_SESSION['fName'];
	$surname = $_SESSION['sName'];
	$email = $_SESSION['email'];
	if ($_SESSION['notify'] == 1) {
		$notify = 1;
	} else {
		$notify = 0;
	}
	include 'frame/head.php';
} else {
	$type		= "danger";
	$message	= "Please login/register to access that page<br>";
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
	<div class="row">
		<div class="col-sm-6">
			<h2>Profile</h2>
		</div>
		<div class="col-sm-2">
			<input type="hidden" name="delete_user" id="delete_user">
			<a href="./forgot_password.php"><button type="submit" class="btn btn-primary" value="updte">Change Password</button></a>
		</div>
		<div class="col-sm-1"></div>
		<div class="col-sm-3">
			<input type="hidden" name="delete_user" id="delete_user">
			<a href="./forms/create_user.php"><button type="button" onclick="confirmation()" class="btn btn-danger btn-lg">Delete Account</button></a>
		</div>
	</div>
	<?php include 'frame/messages.php'?>
	<?php
	// echo ("<div class=".$type.">".$message."</div>");
	?>
	<div>
		<form action="forms/form.php" method="POST">
			<div class="form-row">
				<div class="form-group col-sm-6">
					<label for="userName">First Name</label>
					<input type="text" class="form-control" name="update_fName" placeholder="First Name" <?php echo "value=".$firstame?> placeholder="First Name">
				</div>
				<div class="form-group col-sm-6">
					<label for="userName">Last Name</label>
					<input type="text" class="form-control" name="update_lName" placeholder="Last Name" <?php echo "value=".$surname?> placeholder="Last Name">
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-sm-6">
					<label for="userName">User Name</label>
					<input type="text" class="form-control" name="update_uName" placeholder="First Name" <?php echo "value=".$username?> placeholder="First Name">
				</div>
				<div class="form-group col-sm-6">
					<label for="Email">Email address</label>
					<input type="email" class="form-control" name="update_email" placeholder="Email" <?php echo "value=".$email ?> placeholder="Email">
				</div>
			</div>
			<div class="form-group">
				<label for="notifications">Email Notifications</label> <br>
				<select class="form-control" name="update_notification">
					<?php
					if ($notify == 1) {
						echo '<option value="1" selected>Send notifications</option>';
						echo '<option value="0">Don\'t send notifications</option>';
					} 
					if ($notify == 0) {
						echo '<option value="1" >Send notifications</option>';
						echo '<option value="0" selected>Don\'t send notifications</option>';
					}
					?>
				</select>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-success" value="updte">Update</button>
			</div>
		</form>
	</div>
</section>
<section class="shadow-lg p-3 mb-5 bg-white " id="footer">
	<h2>footer</h2>
</section>

<?php include 'frame/tail.php'; ?>