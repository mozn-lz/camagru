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
	<h2>profile</h2>
	<div>
		<form action="forms/form.php" method="POST">
			<div class="form-row">
				<div class="form-group col-sm-6">
					<label for="userName">First Name</label>
					<input type="text" class="form-control" name="fname" placeholder="First Name">
				</div>
				<div class="form-group col-sm-6">
					<label for="userName">Last Name</label>
					<input type="text" class="form-control" name="sname" placeholder="Last Name">
				</div>
			</div>
			<div class="form-group">
				<label for="Email">Email address</label>
				<input type="email" class="form-control" name="email" placeholder="Email">
			</div>
		<button type="submit" class="btn btn-default" value="updte">Save</button>
	</form>
	</div>
</section>
<section class="shadow-lg p-3 mb-5 bg-white " id="footer">
	<h2>footer</h2>
</section>

<?php include 'frame/tail.php'; ?>