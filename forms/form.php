<?php
session_start();
include 'default.php';
// include 'forms/helpers.php';

function send_mail($username, $firstname, $lastname, $email, $hash, $type) {		//	Send email to Registerd user
	$to      = $email; // Send email to our user
	$headers = 'From:noreply@comagaru.com' . "\r\n"; // Set from headers

	if ($type == "user details") {		//	change user details
		$subject = "Your Camagaru user details have been changed";
		$message = "Your account has successfully been created";
	}
	if ($type == "new user") {		//	
		$subject = 'Signup | Verification'; // Give the email a subject    
		// $message = "Your account was created at " . $date;
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
	   http://127.0.0.1:8080/camagru/verify.php?email='.$email.'&hash='.$hash.'
	   '; // Our message above including the link
	}
	if ($type == "user login") {	//	if user login
		$subject = 'Signin | Notification'; // Give the email a subject    
		// $message = "Your account was created at " . $date;
		$message = '
		
		Account accessed

		Hi '.$username.',

		Your account has been accessed. Please let us know if this was not done by you.

	   '; // Our message above including the link
	}
	if ($type == "reset_password") {		//	
		$subject = 'Reset Password'; // Give the email a subject    
		// $message = "Your account was created at " . $date;
		$message = '
		
	   Someone said you forgot your password. If it was not you, please ignore this email.
	   If it was you, click the link below to reser your password.

	   ------------------------
		
	   Please click this link to activate your account:
	   http://127.0.0.1:8080/camagru/reset_password.php?email='.$email.'&hash='.$hash.'
	   '; // Our message above including the link
	}
	mail($to, $subject, $message, $headers);
}

try
{
	function passwd_check($passwd){
		$uppercase = preg_match('@[A-Z]@', $passwd);
		$lowercase = preg_match('@[a-z]@', $passwd);
		$number    = preg_match('@[0-9]@', $passwd);

		if(!$uppercase || !$lowercase || !$number || strlen($passwd) < 8) {
			return (false);
		}
		return (true);
	}
	//	conect to database  to be able to execute CRUD opperations
	$conn = new PDO("mysql:host=".SERVERNAME.";dbname=".DBNAME."", USERNAME, PASSWORD);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	/****************************/
	/*		reset password		*/
	/****************************/
	if ($_POST['reset_password']) {
		$_POST['notification'] == 'notify';
		echo "reseting password<br>";
		if((trim($_POST['reset_email']) != "") && (trim($_POST['password1']) != "") && (trim($_POST['password2']) != "")){
			echo "reseting password:: elements found<br>";
			if (($_POST['password1'] === $_POST['password2']) && passwd_check($_POST['password1'])) {
				echo "Passwords maatch<br>";
				try{
					$email = $_POST['reset_email'];
					$psword = strtoupper(hash('whirlpool' , $_POST['password1']));
					$stmt = $conn->prepare("UPDATE $usrsTB SET pssword=:pssword WHERE email=:email" );
					$stmt->bindParam(':pssword', $psword);
					$stmt->bindParam(':email', $email);
					$stmt->execute();
					$type		= "success";
					$message	= "Password reset was successfull.<br>Please login";
					header("Location: ../login.php?$type=$message");
					// header("Location: ../login.php");
				}catch(PDOException $e) {
					echo "Forget Error: " . $e->getMessage() . "<br>";
					$type		= "danger";
					$message	= "There was an error resetign your password.<br>Try again";
					header("Location: ../reset_password.php?$type=$message");
					// header("Location: ../reset_password.php");
				}
			} else {
				echo 'passwords dont match';
				$type		= "danger";
				$message	= "Your passwords should match<br>Be 8 charecters long<br>Contain an uppercase letter<br>Contain a lowercase letter<br>Contain a number";
				header("Location: ../reset_password.php?$type=$message");
					// header("Location: ../reset_password.php");
			}
		}else {
			echo 'Password empty<br>';
			$type		= "danger";
			$message	= "Looks like one of your passwords is missing...<br>Try again...you might have to go back to yout email link<br>";
			header("Location: ../reset_password.php?$type=$message");
			// header("Location: ../reset_password.php");
		}
	}

	/****************************/
	/*		forgot password		*/
	/****************************/
	if ($_POST['forgot_password']) {
		if (trim($_POST['reset_email']) != "") {		//	check if user is registerd/valid
			$query = $conn->prepare("SELECT * FROM ".$usrsTB." WHERE email = :email");
			$email = $_POST['reset_email'];
			$query->bindParam(':email', $email);
			$query->execute();

			if ($count = count($query) == 1 ) 
			{	// Find out if email already exists in database (IF USER EXISTS)
				$result = $query->fetch(PDO::FETCH_ASSOC);
				$username	= $result['username'];
				$firstname	= $result['firstname'];
				$lastname	= $result['lastname'];
				$email		= $result['email'];
				try {
					$confirm = hash(md5 ,rand());
					// prepare sql and bind parameters
					$stmt = $conn->prepare("UPDATE $usrsTB SET confirm=:confirm WHERE email=:email");
					$stmt->bindParam(':confirm', $confirm);
					$stmt->bindParam(':email', $email);
					$stmt->execute();

					echo "Please check your email successfully";
					// $_SESSION['message'] = "Account created successfully. <br> Please check your email to confirm";
					// $_SESSION['type'] = 'success';
					send_mail($username, $firstname, $lastname, $email, $confirm, "reset_password");
					$type		= "success";
					$message	= "Everthing looks good, check your email<br>";
					header("Location: ../fotgot_password.php?$type=$message");
					// header("Location: ./logout.php");
				}
				catch(PDOException $e) {
					echo "Forget Error: " . $e->getMessage() . "<br>";
				}
			} else {
				echo ("email address not found");
				$type		= "caution";
				$message	= "Either you entered the wrong email or you dont have an account with us.<br>We cant find your email address<br>";
				header("Location: ../fotgot_password.php?$type=$message");
			}		
		} else {
			echo "Your email seams to be empty";
			$type		= "danger";
			$message	= "Your email seams to be empty<br>";
			header("Location: ../fotgot_password.php?$type=$message");
		}
	}

	/********************/
	/*		upadte		*/
	/********************/
	if ( ($_POST['update_email']) || ($_POST['update_lName']) || ($_POST['update_fName']) || ($_POST['update_uName']) )
	{
		if(isset($_SESSION['id']))
		{
			$query = $conn->prepare("SELECT * FROM ".$usrsTB." WHERE id = :id");
			$id = $_SESSION['id'];
			$query->bindParam(':id', $id);
			$query->execute();

			$result = $query->fetch(PDO::FETCH_ASSOC);
			$username	= $result['username'];
			$firstname	= $result['firstname'];
			$lastname	= $result['lastname'];
			$email		= $result['email'];

			$update_uName			= $_POST['update_uName'];
			$update_fName			= $_POST['update_fName'];
			$update_lName			= $_POST['update_lName'];
			$update_email			= $_POST['update_email'];
			$update_notification	= $_POST['update_notification'];

			if (($update_uName != "") && ($update_uName != null) && ($update_uName != $result['username'])) {
				try{
					$stmt = $conn->prepare("UPDATE ".$usrsTB." SET username = :newUsrName WHERE id =:id");
					$stmt->bindParam(':newUsrName', $update_uName);
					$stmt->bindParam(':id', $_SESSION['id']);
					$stmt->execute();
					/****************************************** */
					$stmt = $conn->prepare("SELECT * FROM ".$usrTB." WHERE username = :username");
					$stmt->bindParam(':username', $_SESSION['uName']);
					$stmt->execute();
					$result = $stmt->fetchAll();
					if (count($result) > 0) {
						$stmt = $conn->prepare("UPDATE ". $usrTB." SET username = :newUser WHERE username = :oldUser");
						$stmt->bindParam(':newUser', $update_uName);
						$stmt->bindParam(':oldUser', $_SESSION['uName']);
						$stmt->execute();
						echo "username changed in all tables<br>";
					} 
					/****************************************** */
					$_SESSION['uName'] = $update_uName;
				}catch(PDOException $e){
					echo "Update querry error: " . $e->get_Message() . "<br>";
				}
			}
			if (($update_fName != "") && ($update_fName != null) && ($update_fName != $result['firstname'])) {
				try{
					echo "update fName<br>From ".$result['firstname']." to ".$update_fName;
					$stmt = $conn->prepare("UPDATE users SET firstname = :update_fName WHERE id = :id");
					$stmt->bindParam(':update_fName', $update_fName);
					$stmt->bindParam(':id', $_SESSION['id']);
					$stmt->execute();
					$_SESSION['fName'] = $update_fName;
				}catch(PDOException $e){
					echo "Update querry error: " . $e->get_Message() . "<br>";
				}
			}
			if (($update_lName != "") && ($update_lName != null) && ($update_lName != $result['lastname'])) {
				try{
					echo "update lName<br>From ".$result['lastname']." to ".$update_lName;
					$stmt = $conn->prepare("UPDATE users SET lastname = :update_lName WHERE id = :id");
					$stmt->bindParam(':update_lName', $update_lName);
					$stmt->bindParam(':id', $_SESSION['id']);
					$stmt->execute();
					$_SESSION['lName'] = $update_lName;
				}catch(PDOException $e){
					echo "Update querry error: " . $e->get_Message() . "<br>";
				}
			}
			if (($update_email != "") && ($update_email != null) && ($update_email != $result['email'])) {
				try{
					echo "update email<br>From ".$result['email']." to ".$update_email;
					$stmt = $conn->prepare("UPDATE users SET email = :update_email WHERE id = :id");
					$stmt->bindParam(':update_email', $update_email);
					$stmt->bindParam(':id', $_SESSION['id']);
					$stmt->execute();
					$_SESSION['email'] = $update_email;
				}catch(PDOException $e){
					echo "Update querry error: " . $e->get_Message() . "<br>";
				}
			}
			echo "<br>Notification update: ". $update_notification . "<br>";
			if (($update_notification == 1) || ($update_notification == 0)) {
				try{
					echo "update notification<br>From ".$result['notification']." to ".$update_notification;
					$stmt = $conn->prepare("UPDATE users SET `notification` = :update_notification WHERE id = :id");
					$stmt->bindParam(':update_notification', $update_notification);
					$stmt->bindParam(':id', $_SESSION['id']);
					$stmt->execute();
					$_SESSION['notification'] = $update_notification;
				}catch(PDOException $e){
					echo "Update querry error: " . $e->get_Message() . "<br>";
				}
			}
			$type		= "Success";
			$message	= "Your change has been implemented<br>";
			header("Location: ../profile.php?$type=$message");
			// header("Location: ../profile.php");
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
				// prepare sql and bind parameters
				$stmt = $conn->prepare("SELECT * FROM ".$usrsTB." WHERE email = :email AND pssword = :pssword");
				$email = $_POST['loginEmail'];
				$psword = strtoupper(hash('whirlpool' , $_POST['loginPassword']));
				$stmt->bindParam(':email', $email);
				$stmt->bindParam(':pssword', $psword);
				$stmt->execute();
				echo $count = $stmt->rowCount() . "<br>";
				if ($count = $stmt->rowCount() == 1 ) 
				{
					echo $count = $stmt->rowCount() . "<br>";
					$result = $stmt->fetch(PDO::FETCH_ASSOC);
					if ($result['active'] == 0)
					{	//	check if account has been verified
						$message = "It seams your account has not been verified yet.<br>Please check your email for verification details.<br>";
						$type = 'danger';
						header("Location: ../login.php?$type=$message");
						// header("Location: ../login.php");
					}
					if ($result['active'] == 1) 
					{	//start session if account verified=TRUE and usr email && password match
						$username	= $_SESSION['uName'] = $result['username'];
						$firstname	= $_SESSION['fName'] = $result['firstname'];
						$lastname	= $_SESSION['sName'] = $result['lastname'];
						$email		= $_SESSION['email'] = $result['email'];
						$_SESSION['notify'] = $result['notification'];
						$_SESSION['id'] = $result['id'];
						$type = 'success';
						$message = "logged in successfully<br>";
						send_mail($username, $firstname, $lastname, $email, $hash, "user login");
						header("Location: ../index.php?$type=$message");
						// header("Location: ../index.php");
					}
				}elseif ($count < 1) {
					$message = 'Incorrect email or password<br> ...or you dont have an account<br>';
					$type = 'danger';
					header("Location: ../login.php?$type=$message");
					// header("Location: ../login.php");
				}elseif ($count > 1) {
					$message = "multiple identity chrisis<br>Relax, a psychologist has been called<br>";
					$type = 'danger';
						header("Location: ../login.php?$type=$message");
					// header("Location: ../login.php");
				}else{
					$message = "We ran out of errors... who knew, we sent an admin to fix it.<br>";
					$type = 'danger';
						header("Location: ../login.php?$type=$message");
						// header("Location: ../login.php");
				}
			}
			catch(PDOException $e) {
				echo "Login error: " . $e->getMessage() . "<br>";
			}
		}
		// $message = "It looks like you didn't enter your email or password.<br>";
		// $type = 'danger';
		// 	header("Location: ../login.php?$type=$message");
	}

	/********************/
	/*		reg			*/
	/********************/
	if ( $_POST['reg_uName'] && $_POST['reg_fName'] && $_POST['reg_sName'] && $_POST['reg_email'] && $_POST['reg_password1'] && $_POST['reg_password2'] )
	{ // Check if ita the right form and if form elemsnts exist
		if ( (trim($_POST['reg_uName']) != "") && (trim($_POST['reg_fName']) != "") && (trim($_POST['reg_sName']) != "") && (trim($_POST['reg_email']) != "") && (trim($_POST['reg_password1']) != "") && (trim($_POST['reg_password2']) != "") )
		{ // Check if form elements arent empty
			if ((trim($_POST['reg_password1'])) === (trim($_POST['reg_password2'])) && (passwd_check($_POST['reg_password1'])))
			{	// checks is passowrds match 'case sensetive'
				$query = $conn->prepare("SELECT * FROM ".$usrsTB." WHERE email = :email");
				$email = $_POST['reg_email'];
				$query->bindParam(':email', $email);
				$query->execute();
				if ($count = $query->rowCount() == 0 )
				{ // Find out if email already exists in database (IF USER EXISTS)
					try {
						// prepare sql and bind parameters
						$stmt = $conn->prepare("INSERT INTO ".$usrsTB." 
						(username,  firstname,  lastname,  email,  pssword,  confirm,  active) 
						VALUES (:username, :firstname, :lastname, :email, :pssword, :confirm, :active)");
						$username = $_POST['reg_uName'];
						$firstname = $_POST['reg_fName'];
						$lastname = $_POST['reg_sName'];
						$email = $_POST['reg_email'];
						$psword = strtoupper(hash('whirlpool' , $_POST['reg_password1']));
						$confirm = hash(md5 ,rand());
						$active = 0;
						
						$stmt->bindParam(':username', $username);
						$stmt->bindParam(':firstname', $firstname);
						$stmt->bindParam(':lastname', $lastname);
						$stmt->bindParam(':email', $email);
						$stmt->bindParam(':pssword', $psword);
						$stmt->bindParam(':confirm', $confirm);
						$stmt->bindParam(':active', $active);
						$stmt->execute();
						// echo "New records created successfully";
						// $_SESSION['message'] = "Account created successfully. <br> Please check your email to confirm";
						// $_SESSION['type'] = 'success';
						send_mail($username, $firstname, $lastname, $email, $confirm, "new user");
						$message = "Just 1 more step befor you start, Please check you email and click on the link.<br>";
						$type = 'success';
						header("Location: ../login.php?$type=$message");
					}
					catch(PDOException $e) {
						echo "Error: " . $e->getMessage() . "<br>";
					}
				}else {
					$message = "User email already exists please try to login";
					$type = 'danger';
						header("Location: ../register.php?$type=$message");
				}
			}else{
				$type		= "danger";
				$message	= "Your passwords should match<br>Be 8 charecters long<br>Contain an uppercase letter<br>Contain a lowercase letter<br>Contain a number";
				echo "failed<br>";
				header("Location: ../register.php?$type=$message");
			}
		}
	}

	/********************/
	/*	deregister		*/
	/********************/
	if ($_POST['delete_profile'])
	{ // 
		$query = $conn->prepare("SELECT * FROM ".$usrsTB." WHERE email = :email");
		$email = $_POST['reg_email'];
		$query->bindParam(':email', $email);
		$query->execute();
		if ($count = $query->rowCount() == 0 )
		{ // Find out if email already exists in database (IF USER EXISTS)
			try {
				// prepare sql and bind parameters
				$stmt = $conn->prepare("INSERT INTO ".$usrsTB." 
				(username,  firstname,  lastname,  email,  pssword,  confirm,  active) 
				VALUES (:username, :firstname, :lastname, :email, :pssword, :confirm, :active)");
				$username = $_POST['reg_uName'];
				$firstname = $_POST['reg_fName'];
				$lastname = $_POST['reg_sName'];
				$email = $_POST['reg_email'];
				$psword = strtoupper(hash('whirlpool' , $_POST['reg_password1']));
				$confirm = hash(md5 ,rand());
				$active = 0;

				$stmt->bindParam(':username', $username);
				$stmt->bindParam(':firstname', $firstname);
				$stmt->bindParam(':lastname', $lastname);
				$stmt->bindParam(':email', $email);
				$stmt->bindParam(':pssword', $psword);
				$stmt->bindParam(':confirm', $confirm);
				$stmt->bindParam(':active', $active);
				$stmt->execute();
				// echo "New records created successfully";
				$message = "Account created successfully. <br> Please check your email to confirm";
				$type = 'success';
				send_mail($username, $firstname, $lastname, $email, $confirm, "new user");
				header("Location: ../index.php?$type=$message");
				// header("Location: ../index.php");
			}
			catch(PDOException $e) {
				echo "Error: " . $e->getMessage() . "<br>";
			}
		}else {
			$message = "Do you have an account? The syste mdoesnt think you do..<br>";
			$type = 'caution';
				header("Location: ../register.php?$type=$message");
			// header("Location: ../register.php");
		}
	}
	// header("Location: ../index.php");
}catch (PDOException $e) {
	echo "PDO Connection failed: " . $e->getMessage() . "<br>";
}

$conn = null;
?>
