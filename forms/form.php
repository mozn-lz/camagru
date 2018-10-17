<?php
include 'default.php';

// $conn = new PDO("mysql: SERVERNAME, BDNAME", USERNAME, PASSWORD);

try
{
	$conn = new PDO("mysql: SERVERNAME, DBNAME", USERNAME, PASSWORD);

	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	echo "Connected successfully";
	
	// function create_session(array $usr_data){
	// 	session_start();
	// 	session['id'] = $usr_data[0];
	// 	session['name'] = $usr_data[1];
	// 	session['sname'] = $usr_data[2];
	// 	session['email'] = $usr_data[3];
	// }

	/********************/
	/*		updte		*/
	/********************/
	if (isset($_POST['updte']))
	{
		echo "Updaate\n\n";
		if ( isset($_POST['email']) || isset($_POST['lname']) || isset($_POST['fname']) )
		{
			$email = $_POST['email'];
			$paswd = $_POST['password'];
			$stmt = $conn->prepare("UPDATE users SET (email, paswd) VALUES (:email, :paswd)");
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
		echo "login\n\n";
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
		
	}
	/********************/
	/*		reg			*/
	/********************/
	if (isset($_POST['reg']))
	{
		echo "Reg\n\n";
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
catch (PDOException $e) {
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