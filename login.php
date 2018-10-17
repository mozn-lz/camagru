<?php include 'frame/head.php'; ?>

<!-- header startss here -->
<section class="shadow-lg p-3 mb-5 bg-white " id="header">
	<ul class="nav nav-pills">
		<li role="presentation" class="active"><a href="index.php">Comagaru</a></li>
		<li role="presentation"><a href="profile.php">Profile</a></li>
		<li role="presentation"><a href="logout.php">Logout</a></li>
	</ul>
</section>


<!-- main startss here -->
<section class="shadow-lg p-3 mb-5 bg-white " id="main">
	<h2>main</h2>
	<form action="forms/form.php" method="POST">
		<div class="form-group">
			<label for="Email1">Email address</label>
			<input required type="email" class="form-control" id="loginEmail" placeholder="Email" >
		</div>
		<div class="form-group">
			<label for="Password1">Password</label>
			<input required type="password" class="form-control" id="loginPassword" placeholder="Password">
		</div>
		<button type="submit" class="btn btn-default" value="login">Submit</button>
	</form>
</section>

<!-- footer startss here -->
<section class="shadow-lg p-3 mb-5 bg-white " id="footer">
	<h2>footer</h2>
</section>

<?php include '/frame/tail.php'; ?>