<?php
session_start(); 
include_once 'default.php';
include 'init_connect.php';


function send_mail($username, $image_owner_email, $type) {		//	Send email to Registerd user
	$to      = $image_owner_email; // Send email to our user
	$headers = 'From:noreply@comagaru.com' . "\r\n"; // Set from headers


	if ($type == "comment") {		//	change user details
		$subject = "New comment";
		$message = "Someone Comented on your picture";
	}
	if ($type == "like") {		//	
		$subject = "New like";
		$message = "Someone Liked on your picture";
	}
		mail($to, $subject, $message, $headers);
}

$sess = isset($_SESSION['id']) && isset($_SESSION['uName']) && isset($_SESSION['fName']) && isset($_SESSION['sName']) && isset($_SESSION['email']);
if ($sess) {
	$user_id	= $_SESSION['id'];
	$username	= $_SESSION['uName'];
	$firstame	= $_SESSION['fName'];
	$surname	= $_SESSION['sName'];
	$email		= $_SESSION['email'];
	/**************************************/
	/*  Submit new pictute to user table  */
	/**************************************/
	if ($_POST['cancel']) {
		header('location: ../take_picture.php');
	}

	if ($_POST['submit'] == 'submit') 
	{
		$image = $_POST['thmb'];
		if ($image) 
		{
			$current_time = 'CURRENT_TIMESTAMP';
			try{
				$stmt = $conn->prepare("INSERT INTO " .PICTABLE." (username, image) 
				VALUES (:uName, :imge)");
				$stmt->bindParam(':uName', $email);
				$stmt->bindParam(':imge', $image);
				$stmt->execute();
				$type		="success";
				$message	="Your image was successfully saved<br>";
				header("Location: ../index.php?$type=$message");
			}catch(PDOException $e){
				echo "Insertion error :" . $e->getMessage() . "<br>";
			}
		}
	}

	/**************************************/
	/*               Comments             */
	/**************************************/
	if ($_POST['comments'] || $_POST['likes'] || $_POST['delete_img'])
	{
		$image_id = $_POST['img_details'];
		$comment = trim($_POST['comment']);
		if ($_POST['comments']){
			if ($comment != '' && $image_id) 
			{
				$stmt = $conn->prepare("SELECT * FROM ".PICTABLE." WHERE id = :img_id");
				$stmt->bindParam(':img_id', $image_id);
				$stmt->execute();
				$result = $stmt->fetchAll();

				$usr_coment = "$username:$comment";
				$db_Comments = ($result[0]['coments']);
				$image_user_email = $result[0]['username'];
				if ($db_Comments == null) {
					$db_Comments = array($result[0]['coments']);
					$usr_coment = "$username:$comment";
					$db_Comments =  array($usr_coment);	//		remove element from array
				} else {
					$db_Comments = json_decode($db_Comments);
					array_push($db_Comments, $usr_coment);//		remove element from array
				}

				$db_Comments = json_encode($db_Comments);
				
				try{
					$stmt = $conn->prepare("UPDATE ".PICTABLE." SET coments = :usr_coment WHERE id = :img_id");
					$stmt->bindParam(':usr_coment', $db_Comments);
					$stmt->bindParam(':img_id', $image_id);
					$stmt->execute();
						$stmt = $conn->prepare("SELECT * FROM $usrsTB WHERE email=:email");
						$stmt->bindParam(':email', $image_user_email);
						$stmt->execute();
						$userDetails = $stmt->fetchAll();
					if ($userDetails[0]['notification'] == 1){
						send_mail($username, $image_user_email, "comment");
					}
					$message = "Image commented.<br>";
					$type = 'success';
					header("Location: ../index.php?$type=$message");
				}catch(PDOException $e){
					$message = $e->getMessage();
					$type = 'caution';
					header("Location: ../index.php?$type=$message");
				}
			}else {
				$message = "Please enter a comment";
				$type = 'caution';
				header("Location: ../index.php?$type=$message");
			}
		}

		/***********************************/
		/*               LIKES             */
		/***********************************/
		if ($_POST['likes'] && $image_id) 
		{
			try{
				$stmt = $conn->prepare("SELECT * FROM ".PICTABLE." WHERE id = :img_id");
				$stmt->bindParam(':img_id', $image_id);
				$stmt->execute();
				$result = $stmt->fetchAll();
				$count = count($result);
				/**
				 * get results
				 * fund if user hasalready liked image before,
				 * 		if user.likes == true ? set user like to false : set user like to true
				 */
				if ($count == 1) {
					$likes = $result[0]['likes'];
					$image_user_email = $result[0]['username'];
					$likes++;
					try{
						$query = $conn->prepare("UPDATE ".PICTABLE." SET likes = :usr_like WHERE id = :img_id");
						$query->bindParam(':usr_like', $likes);
						$query->bindParam(':img_id', $image_id);
						$query->execute();
							$stmt = $conn->prepare("SELECT * FROM $usrsTB WHERE email=:email");
							$stmt->bindParam(':email', $image_user_email);
							$stmt->execute();
							$userDetails = $stmt->fetchAll();
							if ($userDetails[0]['notification'] == 1){
								send_mail($username, $image_user_email, "like");
							}
						$message = "Picture  liked.<br>";
						$type = 'success';
						header("Location: ../index.php?$type=$message");
					}catch(PDOException $e){
						$message =  $e->getMessage();
						$type = 'success';
						header("Location: ../index.php?$type=$message");
					}
				} else {		//	if there are selected images in the db
					$message = "Like...ing error.<br>";
					$type = 'caution';
					header("Location: ../index.php?$type=$message");
				}
			}catch(PDOException $e){
				echo ("likes error " . $e->getMessage());
			}
		}
	
		/***********************************/
		/*              DELETE             */
		/***********************************/
		if ($_POST['delete_img'] && $image_id)
		{
			try{
				$stmt = $conn->prepare("SELECT * FROM ".PICTABLE." WHERE id = :img_id");
				$stmt->bindParam(':img_id', $image_id);
				$stmt->execute();
				$result = $stmt->fetch(PDO::FETCH_ASSOC);

				if ($count == 1) {
					if ($_SESSION['email'] === $result['username']) {		//		if string is present in array
						try{
							$query = $conn->prepare("DELETE FROM ".PICTABLE." WHERE id = :img_id");
							$query->bindParam(':img_id', $image_id);
							$query->execute();
							$type		= "sussess";
							$message	= "Image successfully deleted<br>";
							header("Location: ../index.php?$type=$message");
						}catch(PDOException $e){
							$type		= "danger";
							$message	= "Error deliting image<br>";
							header("Location: ../index.php?$type=$message");
						}
					}else {			//		if string is present in array
						$type		= "Danger";
						$message	= "It doesnt look like this image is yours.<br>You cant delete images that are not yours";
						header("Location: ../index.php?$type=$message");
					}
				} else {		//	if there are selected images in the db
					$message = "multi-update error.<br>";
					$type = 'caution';
					header("Location: ../index.php?$type=$message");
				}
			}catch(PDOException $e){
				echo ("likes error " . $e->getMessage());
			}
		}
		// header("Location: ../index.php");
	}
} else {
	$message = "Your credentials can not be verified.<br>";
	$type = 'success';
	header("Location: ./logout.php?$type=$message");
}

$conn = null;
?>