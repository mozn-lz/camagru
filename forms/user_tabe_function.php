<?php
session_start();

include_once 'default.php';

$conn = new PDO("mysql:host=".SERVERNAME.";dbname=".DBNAME."", USERNAME, PASSWORD);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// echo('Conection established!<br>');

$sess = isset($_SESSION['id']) && isset($_SESSION['uName']) && isset($_SESSION['fName']) && isset($_SESSION['sName']) && isset($_SESSION['email']);
if ($sess) {	
	// $usrTB		= $_SESSION['uName'];
	$user_id	= $_SESSION['id'];
	$username	= $_SESSION['uName'];
	$firstame	= $_SESSION['fName'];
	$surname	= $_SESSION['sName'];
	$email		= $_SESSION['email'];
	echo "user_id: $user_id <br>";
	echo "username: $username <br>";
	echo "firstame: $firstame <br>";
	echo "surname: $surname <br>";
	echo "email: $email <br>";
	/**************************************/
	/*  Submit new pictute to user table  */
	/**************************************/
	if ($_POST['submit'] == 'cancel') {
		header('location: ../take_picture.php');
	}

	if ($_POST['submit'] == 'submit') 
	{
		$image = $_POST['thmb'];
		if ($image) 
		{
			$current_time = 'CURRENT_TIMESTAMP';
			$username = $_SESSION['uName'];
			try{
				$stmt = $conn->prepare("INSERT INTO " .PICTABLE." (username, image) 
				VALUES (:uName, :imge)");
				$stmt->bindParam(':uName', $username);
				$stmt->bindParam(':imge', $image);
				$stmt->execute();
				echo 'Image uploaded<br>';
				header('location: ../index.php');
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
		echo "comments: " . $_POST['comments'] . "<br>";
		echo "likes: " . $_POST['likes'] . "<br>";
		echo "delete_img: " . $_POST['delete_img'] . "<br>";
		echo '<h1>comments and likes activated</h1> <br>';
		$image_id = $_POST['img_details'];
		$comment = trim($_POST['comment']);
		if ($comment != '' && $image_id) 
		{
			$stmt = $conn->prepare("SELECT * FROM ".PICTABLE." WHERE id = :img_id");
			$stmt->bindParam(':img_id', $image_id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			// $db_Comments = array('Mk:user coment', 'Mk:user coment2');

			// $db_Comments = array($result[0]['coments']);

			$usr_coment = "$username:$comment";
			$db_Comments = ($result[0]['coments']);
			// echo '-5. ';
			// print_r($db_Comments);
			// echo'<br>';

						// explode(" ",$comment);		//		create array from string
			if ($db_Comments == null) {
				$db_Comments = array($result[0]['coments']);
				$usr_coment = "$username:$comment";

				echo '-4. ';
				print_r($db_Comments);
				echo'<br>';
				$db_Comments =  array($usr_coment);	//		remove element from array
				echo '-3. ';
				print_r($db_Comments);
				echo'<br>';
			} else {
				echo '-2. ';
				print_r($db_Comments);
				echo'<br>';
				$db_Comments = json_decode($db_Comments);
				echo '-1.5. ';
				print_r($db_Comments);
				echo'<br>';
				array_push($db_Comments, $usr_coment);//		remove element from array
				// $comment = implode(" ",$comment);		//		create string from array
				echo '-1. ';
				print_r($db_Comments);
				echo'<br>';
			}
			
			echo '0. db_Comment: ';
			print_r($db_Comments);
			echo '<br>';

			$db_Comments = json_encode($db_Comments);
			
			echo '1. Json db_Comment: ' . $db_Comments . '<br>';
			// echo '<h2>comments reactivated '.$usr_coment.'  on '.$image_id.'</h2> <br>';
			try{
				$stmt = $conn->prepare("UPDATE ".PICTABLE." SET coments = :usr_coment WHERE id = :img_id");
									//   ("UPDATE ".PICTABLE." SET coments = :usr_coment WHERE id = :img_id");
				echo "2. db_Comments: " . $db_Comments . "<br>";
				echo "3. image_id: " . $image_id . "<br>";
				$stmt->bindParam(':usr_coment', $db_Comments);
				$stmt->bindParam(':img_id', $image_id);
				echo '<br>';
				echo '<br>';
				// echo 'stmt: ';
				// print_r($stmt);
				// echo '<br>';
				$stmt->execute();
				echo 'image commented<br>';
				header("Location: ../index.php");
			}catch(PDOException $e){
				echo ("comment error " . $e->getMessage());
			}
		}
		// else{
		// 	echo "Comment error: comment or username not found<br>";
		// }
		
		
		
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
				echo "Excecution: ". $count. "<br>";
				echo '<br>';
				/**
				 * get results
				 * fund if user hasalready liked image before,
				 * 		if user.likes == true ? set user like to false : set user like to true
				 */
				if ($count == 1) {
					$likes = $result[0]['likes'];
					$likes++;
					try{
						$query = $conn->prepare("UPDATE ".PICTABLE." SET likes = :usr_like WHERE id = :img_id");
						echo ('6. prepared<br>');
						$query->bindParam(':usr_like', $likes);
						$query->bindParam(':img_id', $image_id);
						echo ('7. Bind: <br>');
						$query->execute();
						echo 'image LIKED<br>';
						header("Location: ../index.php");
					}catch(PDOException $e){
						echo ("+ likes error " . $e->getMessage());
					}
					
/*
					$likes = $result[0]['likes'];
					$likes = explode(" ", $likes);
					
					if (($key = array_search($user_id, $likes)) == false) {		//		if string is present in array
						// explode(" ",$likes);		//		create array from string
						array_push($likes, $user_id);//		remove element from array
						$likes = implode(" ",$likes);		//		create string from array
						
						try{
							$query = $conn->prepare("UPDATE ".PICTABLE." SET likes = :usr_like WHERE id = :img_id");
							echo ('6. prepared<br>');
							$query->bindParam(':usr_like', $likes);
							$query->bindParam(':img_id', $image_id);
							echo ('7. Bind: <br>');
							$query->execute();
							echo 'image LIKED<br>';
							header("Location: ../index.php");
						}catch(PDOException $e){
							echo ("+ likes error " . $e->getMessage());
						}
						header("Location: ../index.php");
					}else {			//		if string is present in array
						try{
							unset($likes[$user_id]);		//		remove element from array
							$likes = implode(" ",$likes);		//		create string from array
							if (trim($likes) == "") {
								$likes = NULL;
							}
							
							echo "key: ".array_search($user_id, $likes) ."<br>";
							$stmt = $conn->prepare("UPDATE ".PICTABLE." SET likes = :usr_like WHERE id = :img_id");
							echo ('4. prepared<br>');
							$stmt->bindParam(':usr_like', $likes);
							$stmt->bindParam(':img_id', $image_id);
							echo ('5. Bind: <br>');
							$stmt->execute();
							header("Location: ../index.php");
							echo 'image unLIKED<br>';
						}catch(PDOException $e){
							echo ("- unlikes error " . $e->getMessage());
						}
						header("Location: ../index.php");
					}
*/
				} else {		//	if there are selected images in the db
					echo "multi-update error<br>";
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
				echo "image_id: " . $image_id . "<br>";
				$stmt = $conn->prepare("SELECT * FROM ".PICTABLE." WHERE id = :img_id");
				$stmt->bindParam(':img_id', $image_id);
				$stmt->execute();
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
				// $result = $stmt->fetchAll();
				echo "conut: ".$count = $stmt->rowCount() . "<br>";
				echo "Count 1: ". $count. "<br>";
				echo '<br>';
				/**
				 * get results
				 * fund if user hasalready liked image before,
				 * 		if user.likes == true ? set user like to false : set user like to true
				 */
				if ($count == 1) {
					echo "Count = 1<br>";
					if ($username === $result['username']) {		//		if string is present in array
						echo "usernames match <br>";
						try{
							$query = $conn->prepare("DELETE FROM ".PICTABLE." WHERE id = :img_id");
							echo ('6. prepared<br>');
							$query->bindParam(':img_id', $image_id);
							echo ('7. Bind: <br>');
							$query->execute();
							echo 'image DELETED<br>';
							header("Location: ../index.php");
						}catch(PDOException $e){
							echo ("Delete error " . $e->getMessage() . "<br>");
							header("Location: ../index.php");
						}
						// header("Location: ../index.php");
					}else {			//		if string is present in array
						echo "It doesnt look like this image is yours.<br>You cant delete images that are not yours";
						header("Location: ../index.php");
					}
				} else {		//	if there are selected images in the db
					echo "multi-update error<br>";
					header("Location: ../index.php");
				}
			}catch(PDOException $e){
				echo ("likes error " . $e->getMessage());
			}
		}
	}
	header("Location: ../index.php");
} else {
	echo ('AUTHENTICATION ERROR.<br>');
	header("Location: ../login.php");
}

$conn = null;

?>