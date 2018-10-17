<?php
require_once 'default.php';

// $conn = new PDO("mysql: SERVERNAME, BDNAME", USERNAME, PASSWORD);

try
{
	$conn = new PDO("mysql: SERVERNAME, BDNAME", USERNAME, PASSWORD);

	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	echo "Connected successfully";
	


	/********************/
	/*		updte		*/
	/********************/
	if (isset($_POST['updte']))
	{
		if ( isset($_POST['email']) || isset($_POST['lname']) || isset($_POST['fname']) )
		{
			$email = $_POST['email'];
			$paswd = $_POST['password'];
			$stmt = $conn->prepare("UPDATE users (email, paswd) VALUES (:email, :paswd)");
			$stmt->bindparam(':email', $email);
			$stmt->bindparam(':paswd', $paswd);
			if ($stmt->execute()) {
				echo "New record created successfully";
			} else {
				echo "Unable to create record";
			}
		}
	}
	/********************/
	/*		login		*/
	/********************/
	if (isset($_POST['login']))
	{
		if ( isset($_POST['email']) && isset($_POST['password']) )
		{
			$email = $_POST['email'];
			$paswd = password_hash($_POST['password'], PASSWORD_DEFAULT);
			$stmt = $conn->prepare("SELECT * FROM users WHERE email=:email AND paswd=:paswd)");
			$stmt->bindparam(':email', $email);
			$stmt->bindparam(':paswd', $paswd);
			if ($stmt->execute()) {
				session_start();
				// $_SESSION["user"] =
				$user = $stmt->fetch();
				print_r	($user);
			} else {
				echo "Unable to create record";
			}
		}
		try{
			$conn = new PDO($dsn,$username,$password,$options);
		} catch (PDOException $e){
			echo "Error!".$e->getMessage();
		}
	}
	/********************/
	/*		reg			*/
	/********************/
	if (isset($_POST['reg']))
	{
		if ( isset($_POST['fname']) && isset($_POST['sname']) && isset($_POST['email']) && isset($_POST['password']) )
		{
			$fname = $_POST['fname'];
			$sname = $_POST['sname'];
			$email = $_POST['email'];
			$paswd = password_hash($_POST['password'], PASSWORD_DEFAULT);

			$stmt = $conn->prepare("INSERT INTO users (fname, sname, email, paswd) VALUES (:fname, :sname, :email, :paswd)");
			$stmt->bindparam(':fname', $email);
			$stmt->bindparam(':sname', $email);
			$stmt->bindparam(':email', $email);
			$stmt->bindparam(':paswd', $paswd);
			if ($stmt->execute()) {
				echo "New record created successfully";
			} else {
				echo "Unable to create record";
			}
		}
	}
}
catch ($conn->connect_error) {
	echo "Connection failed: " . $e->getMessage();
}

// fname
// sname
// email
// paswd

// :fname
// :sname
// :email
// :paswd
?>