<?php 
session_start();
$page_title = "Camagru Registration";
include 'frame/head.php'; 
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
	<h2>Registration</h2>
	<?php include 'frame/messages.php'?>
	<form name="reg_form" action="forms/form.php" onsubmit="return validateRegForm()" method="POST">
		<div class="form-row">
			<div class="form-group col-sm-6">
				<label for="userName">First Name</label>
				<input required type="text" class="form-control" id="reg_fName" name="reg_fName" placeholder="First Name">
			</div>
			<div class="form-group col-sm-6">
				<label for="userName">Last Name</label>
				<input required type="text" class="form-control" id="reg_sName" name="reg_sName" placeholder="Last Name">
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-sm-6">
				<label for="userName">User Name</label>
				<input required type="text" class="form-control" id="reg_uName" name="reg_uName" placeholder="First Name">
			</div>
		 	<div class="form-group col-sm-6">
				<label for="Email">Email address</label>
				<input required type="email" class="form-control" id="reg_email" name="reg_email" placeholder="Email">
			</div>
		</div>
		<div class="form-group">
			<label for="Password">Password</label>
			<input required type="password" class="form-control" id="reg_password1" name="reg_password1" placeholder="Password">
		</div>
		<div class="form-group">
			<label for="Password2">Confirm Password</label>
			<input required type="password" class="form-control" id="reg_password2" name="reg_password2" placeholder="Confirm Password">
		</div>
		<button type="submit" class="btn btn-default" name="register" value="reg">Submit</button>
	</form>
	<a href="login.php">Already have an account? Click to login</a>
</section>
<section class="shadow-lg p-3 mb-5 bg-white " id="footer">
	<h2>footer</h2>
</section>

<?php include 'frame/tail.php'; ?>
