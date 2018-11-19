<?php
session_start();
$usrTB = $_SESSION['uName'];
$username = $_SESSION['uName'];
$firstame = $_SESSION['fName'];
$surname = $_SESSION['sName'];
$email = $_SESSION['email'];
// echo('id: '.$_SESSION['id']) .'<br>';
// echo('uName: '.$_SESSION['uName']) .'<br>';
// echo('fName: '.$_SESSION['fName']) .'<br>';
// echo('sName: '.$_SESSION['sName']) .'<br>';
// echo('email: '.$_SESSION['email']) .'<br>';
	if ($_POST['submit'] == 'cancel') {
		header('location: ../take_picture.php');
	}
	
if ($_POST['submit'] == 'submit') {
	include_once 'default.php';
	
	$conn = new PDO("mysql:host=".SERVERNAME.";dbname=".DBNAME."", USERNAME, PASSWORD);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	echo('Conection established!<br>');
	
	$sess = isset($_SESSION['id']) && isset($_SESSION['uName']) && isset($_SESSION['fName']) && isset($_SESSION['sName']) && isset($_SESSION['email']);
	if ($sess) {
		echo '1<br>';
		
		echo '1.50<br>';
		
		/**************************************/
		/*  Submit new pictute to user table  */
		/**************************************/
		$image = $_POST['thmb'];
		if ($image) {
			$current_time = 'CURRENT_TIMESTAMP';
			$username = $_SESSION['uName'];
			try{
				$stmt = $conn->prepare("INSERT INTO " .$usrTB."(username, image) 
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
	} else {
		echo ('File not found.<br>');
	}
} 


		/**************************************/
		/*               Comments             */
		/**************************************/
		$comment = $_POST['comment'];
		$img = $_POST['img_details'];
		if ($comment && $img_id) {
			$usr_coment = $username . ':' . $comment;
			try{
				$stmt = $conn->prepare("UPDATE $usrTB SET comment = :usr_coment WHERE id = :img_id");
				$stmt = bindParam(':usr_coment', $usr_coment);
				$stmt = bindParam(':img_id', $img['id']);
				$stmt->execute();
				echo 'image commented<br>';
			}catch(PDOException $e){
				echo ("comment error " . $e->getMessage());
			}
		}else{
			echo "Comment error: comment or username not found<br>";
		}

		/***********************************/
		/*               LIKES             */
		/***********************************/
		$likes = $_POST['likes'];
		$img = $_POST['img_details'];
		if ($likes && $img_id) {
			$usr_like = $username . ':' . $likes;
			try{
				$stmt = $conn->prepare("SELECT FROM $usrTB WHERE id = :img_id");
				$stmt = bindParam(':usr_like', $usr_like);
				$stmt = bindParam(':img_id', $img['id']);
				$stmt->execute();
				/**
				 * get results
				 * fund if user hasalready liked image before,
				 * 		if user.likes == true ? set user like to false : set user like to true
				 */

				$stmt = $conn->prepare("UPDATE $usrTB SET likes = :usr_like WHERE id = :img_id");
				$stmt = bindParam(':usr_like', $usr_like);
				$stmt = bindParam(':img_id', $img['id']);
				$stmt->execute();
				echo 'image LIKED<br>';
			}catch(PDOException $e){
				echo ("likes error " . $e->getMessage());
			}
		}else{
			echo "likes error: comment or username not found<br>";
		}

$conn = null;

?>