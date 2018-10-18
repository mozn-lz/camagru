<?php
include 'default.php';

try
{
	$conn = new PDO("mysql:host=".SERVERNAME.";dbname=".DBNAME."", USERNAME, PASSWORD);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	echo "Connected successfully";

	// function create_session(array $usr_data){
	// 	session_start();
	// 	session['id'] = $usr_data[0];
	// 	session['name'] = $usr_data[1];
	// 	session['sname'] = $usr_data[2];
	// 	session['email'] = $usr_data[3];

	/********************/
	/*		updte		*/
	/********************/

	if ( ($_POST['update_email']) || ($_POST['update_lName']) || ($_POST['update_fName']) || ($_POST['update_uName']) )
	{
		if ($_POST['update_email']) {
			$email = $_POST('update_email');
			$stmt->bindParam(':email', $email);
		}
		if ($_POST['update_lName']) {
			$lName = $_POST('update_lName');
			$stmt->bindParam(':lName', $lName);
		}
		if ($_POST['update_fName']) {
			$fName = $_POST('update_fName');
			$stmt->bindParam(':fName', $fName);
		}
		if ($_POST['update_uName']) {
			$uName = $_POST('update_uName');
			$stmt->bindParam(':uName', $uName);
		}
		(condition) ? a : b ;
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

	/********************/
	/*		login		*/
	/********************/

		if ( ($_POST['log_email']) && ($_POST['log_password']) )
		{
			$email = $_POST['email'];
			$psword = password_hash($_POST['password'], PASSWORD_DEFAULT);
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
		

	/********************/
	/*		reg			*/
	/********************/

	if ( $_POST['reg_uName'] && $_POST['reg_fName'] && $_POST['reg_sName'] && $_POST['reg_email'] && $_POST['reg_password1'] )
	{
		try {
			$conn = new PDO("mysql:host=".SERVERNAME.";dbname=".DBNAME."", USERNAME, PASSWORD);
			// set the PDO error mode to exception
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			// prepare sql and bind parameters
			$stmt = $conn->prepare("INSERT INTO ".$usrsTB." 
			(username, firstname, lastname, email, pssword, verified) 
			VALUES (:username, :firstname, :lastname, :email, :pssword, :verified)");
			$username = $_POST['reg_uName'];
			$firstname = $_POST['reg_fName'];
			$lastname = $_POST['reg_sName'];
			$email = $_POST['reg_email'];
			$psword = $_POST['reg_password1'];
			$verified = 0;
			
			$stmt->bindParam(':username', $username);
			$stmt->bindParam(':firstname', $firstname);
			$stmt->bindParam(':lastname', $lastname);
			$stmt->bindParam(':email', $email);
			$stmt->bindParam(':pssword', $psword);
			$stmt->bindParam(':verified', $verified);
			$stmt->execute();
			echo "New records created successfully";
		}
		catch(PDOException $e)
		{
			echo "Error: " . $e->getMessage();
		}
	}

}

catch (PDOException $e) {
	echo "PDO Connection failed: " . $e->getMessage();
}

$conn = null;
?>
