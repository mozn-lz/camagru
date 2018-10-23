<?php
session_start();
include 'default.php';

try
{
	$conn = new PDO("mysql:host=".SERVERNAME.";dbname=".DBNAME."", USERNAME, PASSWORD);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	echo "Connected successfully :0 <br>";

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
		if(isset($_SESSION['id']))
		{
			if ($_POST['update_uName']) {
				$uName = $_POST('update_uName');
				$stmt = $conn->prepare("UPDATE users SET email = :email) WHERE id = ".$_SESSION['id']);
				$stmt->bindParam(':email', $email);
				$stmt->execute();
			}
			if ($_POST['update_fName']) {
				$fName = $_POST('update_fName');
				$stmt = $conn->prepare("UPDATE users SET email = :email) WHERE id = ".$_SESSION['id']);
				$stmt->bindParam(':email', $email);
				$stmt->execute();
			}
			if ($_POST['update_lName']) {
				$lName = $_POST('update_lName');
				$stmt = $conn->prepare("UPDATE users SET email = :email) WHERE id = ".$_SESSION['id']);
				$stmt->bindParam(':email', $email);
				$stmt->execute();
			}
			if ($_POST['update_email']) {
				$email = $_POST('update_email');
				$stmt = $conn->prepare("UPDATE users SET email = :email) WHERE id = ".$_SESSION['id']);
				$stmt->bindParam(':email', $email);
				$stmt->execute();
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
	}

	/********************/
	/*		login		*/
	/********************/
	if ( ($_POST['loginEmail']) && $_POST['loginPassword'] )
	{ // Check if ita the right form and if form elemsnts exist
		if ( trim(($_POST['loginEmail']) != "") && trim(($_POST['loginPassword']) != "") )
		{ // Check if form elements aren't empty
			try
			{
				$conn = new PDO("mysql:host=".SERVERNAME.";dbname=".DBNAME."", USERNAME, PASSWORD);
				// set the PDO error mode to exception
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				// prepare sql and bind parameters
				$stmt = $conn->prepare("SELECT * FROM ".$usrsTB." WHERE email = :email AND pssword = :pssword");
				$email = $_POST['loginEmail'];
				$psword = strtoupper(hash('whirlpool' , $_POST['loginPassword']));
				$stmt->bindParam(':email', $email);
				$stmt->bindParam(':pssword', $psword);
				$stmt->execute();
				// echo $count = $stmt->rowCount() . "<br>";
				if ($count = $stmt->rowCount() == 1 ) {
					$result = $stmt->fetch(PDO::FETCH_ASSOC);
					echo ("res: " . $result['verified'] . "<br>");
					if ($result['verified'] == 0){	//	check if account has been verified
						echo "It seams your account has not been verified yet.<br>Please check your email for verification details.<br>";
					}
					if ($result['verified'] == 1) {	//start session if account verified=TRUE and usr email && password match
						$_SESSION['id'] = $result['id'];
						$_SESSION['uName'] = $result['username'];
						$_SESSION['fName'] = $result['firstname'];
						$_SESSION['sName'] = $result['lastname'];
						$_SESSION['email'] = $result['email'];
						send_mail($email);
						header("Location: ../index.php");
					}
				}elseif ($stmt->rowCount() < 1) {
					echo "Incorrect email or password<br>";
					header("Location: ../login.php");
				}elseif ($stmt->rowCount() > 1) {
					echo "multiple identity chrisis<br>Relax, a psychologist has been called<br>";
				}
			}
			catch(PDOException $e) {
				echo "Login error: " . $e->getMessage();
			}
		}
	}

	/********************/
	/*		reg			*/
	/********************/
	if ( $_POST['reg_uName'] && $_POST['reg_fName'] && $_POST['reg_sName'] && $_POST['reg_email'] && $_POST['reg_password1'] && $_POST['reg_password2'] )
	{ // Check if ita the right form and if form elemsnts exist
		if ( (trim($_POST['reg_uName']) != "") && (trim($_POST['reg_fName']) != "") && (trim($_POST['reg_sName']) != "") && (trim($_POST['reg_email']) != "") && (trim($_POST['reg_password1']) != "") && (trim($_POST['reg_password2']) != "") )
		{ // Check if form elements arent empty
			if ((trim($_POST['reg_password1'])) === (trim($_POST['reg_password2']))){	// checks is passowrds match 'case sensetive'
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
					$psword = strtoupper(hash('whirlpool' , $_POST['reg_password1']));
					$verified = 0;
					
					$stmt->bindParam(':username', $username);
					$stmt->bindParam(':firstname', $firstname);
					$stmt->bindParam(':lastname', $lastname);
					$stmt->bindParam(':email', $email);
					$stmt->bindParam(':pssword', $psword);
					$stmt->bindParam(':verified', $verified);
					$stmt->execute();
					echo "New records created successfully";
					send_mail($email, "new account");
					header("Location: ../index.php");
				}
				catch(PDOException $e) {
					echo "Error: " . $e->getMessage();
				}
			}else{
				echo "<br>passwords don't match";
			}
		}
	}
 }
catch (PDOException $e) {
	echo "PDO Connection failed: " . $e->getMessage();
}

$conn = null;
?>
