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
	<?php
	$i = 0;
		echo "email: " . $_GET['email'] . '<br>';
		echo "hash: " . $_GET['hash'] . '<br>';
		echo "usrtb: " .$usrsTB. '<br>';
	if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
		// Verify data
		$query = $conn->prepare("SELECT * FROM ".$usrsTB." WHERE email = :email AND confirm = :hash");
		$email = ($_GET['email']); // Set email variable
		$hash = ($_GET['hash']); // Set hash variable
		$query-> bindParam(':email', $email);
		$query-> bindParam(':hash', $hash);
		$query->execute();
		if ($query->rowCount() == 1) {
			try {
				$active = 1;
				$stmt = $conn->prepare("UPDATE ".$usrsTB." SET active = :active WHERE email = :email AND confirm = :hash AND active = '0'");
				$stmt->bindParam(':active', $active);
				$stmt->bindParam(':email', $email);
				$stmt->bindParam(':hash', $hash);
				$stmt->execute();
				$_SESSION['type'] = "success";
				$_SESSION['message'] = "Your account has been verified";
				include('forms/create_user.php');	//user_table related functions
				/*	Function create_user_table() from "include('forms/create_user.php');" 
					To create table where user will upload images */
				create_user_table($username = $query['username']);
				header("Location: login.php");
			}catch (PDOException $e){
				echo "Sql querry error: " . $e->getMessage();
			}
		} else {
			echo "no record found" . "<br>";
		}
	}else{
		echo "data not found" . "<br>";
	}
	?>
</section>

<!-- footer startss here -->
<section class="shadow-lg p-3 mb-5 bg-white " id="footer">
	<h2>footer</h2>
</section>

<?php include 'frame/tail.php'; ?>