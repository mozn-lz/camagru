<?php include 'frame/head.php'; ?>

<section class="shadow-lg p-3 mb-5 bg-white " id="header">
	<ul class="nav nav-pills">
		<li role="presentation" class="active"><a href="index.php">Comagaru</a></li>
		<li role="presentation"><a href="profile.php">Profile</a></li>
		<li role="presentation"><a href="logout.php">Logout</a></li>
	</ul>
	<!-- <h1>Comagaru</h1>
	<div>
		<div class="inline">Profile</div>
		<div class="inline">Logout</div>
	</div> -->
</section>
<section class="shadow-lg p-3 mb-5 bg-white " id="main">
	<h2>main</h2>
	<form>
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
		<div class="form-group">
			<label for="Password">Password</label>
			<input type="password" class="form-control" name="password1" placeholder="Password">
		</div>
		<div class="form-group">
			<label for="Password2">Confirm Password</label>
			<input type="password" class="form-control" name="password2" placeholder="Confirm Password">
		</div>
		<button type="submit" class="btn btn-default" value="reg">Submit</button>
	</form>

</section>
<section class="shadow-lg p-3 mb-5 bg-white " id="footer">
	<h2>footer</h2>
</section>

<?php include '/frame/tail.php'; ?>