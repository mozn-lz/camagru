<?php
session_start();
include 'default.php';
include 'forms/helpers.php';

date_default_timezone_set('Africa/Johannesburg');
$date = date('d/m/Y H:i:s', time());
$headers .= 'From: <admin@lcamagaru.com>' . "\r\n";

function send_mail($username, $firstname, $lastname, $email, $hash, $type) {
	echo "sending mail<br>";
    // if ($type == "user details") {
    //     $subject = "Your Camagaru user details have been changed";
    //     $message = "Your account has successfully been created";
    // }
    // if ($type == "new user") {
    //     $subject = "Email confirmation on Camagaru";
    //     $message = "Your account was created at " . $date;
    // }
    // if ($type == "user login") {
	//     $subject = "Login confirmation";
    //     $message = "You signed in at " . $date;
	// }
	// echo $date;

	$to      = $email; // Send email to our user
	$subject = 'Signup | Verification'; // Give the email a subject 
	$message = '
	 
	Thanks for signing up!
	Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
	 
	------------------------
	username: '.$username.'
	First Name: '.$firstname.'
	Last Name: '.$lastname.'
	Email: '.$email.'
	Password: ...just kidding, thats a serurity risk.
	------------------------
	 
	Please click this link to activate your account:
	http://127.0.0.1:8080/camagru/?email='.$email.'&hash='.$hash.'
	 
	'; // Our message above including the link
						 
	$headers = 'From:noreply@yourwebsite.com' . "\r\n"; // Set from headers

	mail($email, $subject, $message, $headers);
}

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
				send_mail($email, "user details");
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
				if ($count = $stmt->rowCount() == 1 ) 
				{
					$result = $stmt->fetch(PDO::FETCH_ASSOC);
					if ($result['verified'] == 0)
					{	//	check if account has been verified
						$_SESSION['message'] = "It seams your account has not been verified yet.<br>Please check your email for verification details.<br>";
						$_SESSION['type'] = "danger";
					}
					if ($result['verified'] == 1) 
					{	//start session if account verified=TRUE and usr email && password match
						$_SESSION['id'] = $result['id'];
						$_SESSION['uName'] = $result['username'];
						$_SESSION['fName'] = $result['firstname'];
						$_SESSION['sName'] = $result['lastname'];
						$_SESSION['email'] = $result['email'];
						$_SESSION['msg'] = '';
						send_mail($username, $firstname, $lastname, $email, $psword, "user login");
						header("Location: ../index.php");
					}
				}elseif ($count < 1) {
					$_SESSION['message'] = "Incorrect email or password<br>";
					$_SESSION['type'] = "danger";
					header("Location: ../login.php");
				}elseif ($count > 1) {
					$_SESSION['message'] = "multiple identity chrisis<br>Relax, a psychologist has been called<br>";
					$_SESSION['type'] = "danger";
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
			if ((trim($_POST['reg_password1'])) === (trim($_POST['reg_password2'])))
			{	// checks is passowrds match 'case sensetive'
				$query = $conn->prepare("SELECT * FROM ".$usrsTB." WHERE email = :email");
				$email = $_POST['reg_email'];
				$query->bindParam(':email', $email);
				$query->execute();
				if ($count = $query->rowCount() == 0 )
				{ // Find out if email already exists in database (IF USER EXISTS)
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
						// echo "New records created successfully";
						$_SESSION['message'] = "Account created successfully. <br> Please check your email to confirm";
						$_SESSION['type'] = "success";
						send_mail($username, $firstname, $lastname, $email, $psword, "new user");
						header("Location: ../index.php");
					}
					catch(PDOException $e) {
						echo "Error: " . $e->getMessage();
					}
				}else {
					$_SESSION['message'] = "User email already exists please try to login";
					$_SESSION['type'] = "danger";
					header("Location: ../register.php");
				}
			}else{
				$_SESSION['message'] = "Passwords don't match";
				$_SESSION['type'] = "danger";
				header("Location: ../register.php");
			}
		}
	}
 }
catch (PDOException $e) {
	echo "PDO Connection failed: " . $e->getMessage();
}

$conn = null;
?>
