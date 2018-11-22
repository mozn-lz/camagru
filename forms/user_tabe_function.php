<?php
session_start();

include_once 'default.php';

$conn = new PDO("mysql:host=".SERVERNAME.";dbname=".DBNAME."", USERNAME, PASSWORD);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// echo('Conection established!<br>');


$sess = isset($_SESSION['id']) && isset($_SESSION['uName']) && isset($_SESSION['fName']) && isset($_SESSION['sName']) && isset($_SESSION['email']);
if ($sess) {	
	$usrTB		= $_SESSION['uName'];
	$user_id	= $_SESSION['id'];
	$username	= $_SESSION['uName'];
	$firstame	= $_SESSION['fName'];
	$surname	= $_SESSION['sName'];
	$email		= $_SESSION['email'];

	// echo "usrTB: $usrTB  <br>";
	// echo "user_id: $user_id  <br>";
	// echo "username: $username  <br>";
	// echo "firstame: $firstame  <br>";
	// echo "surname: $surname  <br>";
	// echo "email: $email  <br>";

	if ($_POST['submit'] == 'cancel') {
		header('location: ../take_picture.php');
	}

	if ($_POST['submit'] == 'submit') 
	{
		/**************************************/
		/*  Submit new pictute to user table  */
		/**************************************/
		$image = $_POST['thmb'];
		if ($image) 
		{
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
	}

	// echo '<br> img dertails: <b>';
	// print_r($_POST['img_details']);
	// echo '</b><br>';
	if ($_POST['comments'] || $_POST['likes'])
	{
		echo '<h1>comments and likes activated</h1> <br>';
		$image_id = $_POST['img_details'];
		/**************************************/
		/*               Comments             */
		/**************************************/
		$comment = $_POST['comments'];
		if ($_POST['comment'] && $image_id) 
		{
			$usr_coment = $username . ':' . $comment;
			echo '<h2>comments reactivated '.$usr_coment.'</h2>  <br>';
			try{
				$stmt = $conn->prepare("UPDATE $usrTB SET comment = :usr_coment WHERE id = :img_id");
				$stmt->bindParam(':usr_coment', $usr_coment);
				$stmt->bindParam(':img_id', $image_id);
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
		if ($_POST['likes'] && $image_id) 
		{
			// echo "<h2>likes reactivated:'1. $_POST['likes']', 2. $image_id</h2> <br>End <br>";
			try{
				$stmt = $conn->prepare("SELECT * FROM $usrTB WHERE id = :img_id");
				$stmt->bindParam(':img_id', $image_id);
				$stmt->execute();
				$result = $stmt->fetchAll();
				$count = count($result);
				echo "Excecution: ". $count. "<br>";

				/**
				 * get results
				 * fund if user hasalready liked image before,
				 * 		if user.likes == true ? set user like to false : set user like to true
				 */
				if ($count == 1) {
					$likes = $result[0]['likes'];
					// $usr_like = $username . ':' . $likes;
					// $likes = $user_id;
					echo ('<br>new array: ');
					print_r($likes);
					echo ('<br>');

					// in_array
					// if (($key = array_search($user_id, $likes)) == false) {		//		if string is present in array
					if (($key = in_array($user_id, $likes)) == false) {		//		if string is present in array
						explode(" ",$likes);		//		create array from string
						unset($likes[$key]);		//		remove element from array
						implode(" ",$likes);		//		create string from array

						echo "key: ".array_search($user_id, $likes) ."<br>";
						$stmt = $conn->prepare("UPDATE $usrTB SET likes = :usr_like WHERE id = :img_id");
						echo ('4. prepared<br>');
						$stmt->bindParam(':usr_like', $likes);
						$stmt->bindParam(':img_id', $image_id);
						echo ('5. Bind: <br>');
						$stmt->execute();
						echo "stmt: ". $stmt;
						echo 'image unLIKED<br>';
					}else {			//		if string is present in array
						explode(" ",$likes);		//		create array from string
						array_push($likes, $user_id);//		remove element from array
						implode(" ",$likes);		//		create string from array

						$query = $conn->prepare("UPDATE $usrTB SET likes = :usr_like WHERE id = :img_id");
						echo ('6. prepared<br>');
						$query->bindParam(':usr_like', $likes);
						$query->bindParam(':img_id', $image_id);
						echo ('7. Bind: <br>');
						$query->execute();
						echo "stmt: ". $query;
						echo 'image LIKED<br>';
					}
				} else {		//	if there are selected images in the db
					echo "multi-update error<br>";
				}
			}catch(PDOException $e){
				echo ("likes error " . $e->getMessage());
			}
		}
	}
} else {
	echo ('image not found.<br>');
}

$conn = null;

?>