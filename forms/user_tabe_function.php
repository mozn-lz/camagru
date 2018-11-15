<?php
session_start();
	if ($_POST['submit'] == 'cancel') {
		header('location: ../take_picture.php');
	}
	
if ($_POST['submit'] == 'submit') {
	include_once 'default.php';
	
	$conn = new PDO("mysql:host=".SERVERNAME.";dbname=".DBNAME."", USERNAME, PASSWORD);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	echo('Conection established!<br>');
	// echo('id: '.$_SESSION['id']) .'<br>';
	// echo('uName: '.$_SESSION['uName']) .'<br>';
	// echo('fName: '.$_SESSION['fName']) .'<br>';
	// echo('sName: '.$_SESSION['sName']) .'<br>';
	// echo('email: '.$_SESSION['email']) .'<br>';
	
	$sess = isset($_SESSION['id']) && isset($_SESSION['uName']) && isset($_SESSION['fName']) && isset($_SESSION['sName']) && isset($_SESSION['email']);
	if ($sess) {
		$usrTB = $_SESSION['uName'];
		$username = $_SESSION['uName'];
		$firstame = $_SESSION['fName'];
		$surname = $_SESSION['sName'];
		$email = $_SESSION['email'];
		echo '1<br>';
		
// $filetype = $_FILES['file']['type'];
// $filePointer = fopen($_FILES['file']['tmp_name'], 'rb'); //rb - read , binary

// 		print_r($filetype);
		echo '1.50<br>';
		$image = $_POST['thmb'];
		// echo $image . "<br>";
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
	// $picture = $_POST('user_pic');
	
} 

// INSERT INTO `mk` (`id`, `username`, `image`, `time`, `coments`, `likes`) 
// VALUES (NULL, 'mk', 
// 'data:image/png;base64,', 
// CURRENT_TIMESTAMP, 
// NULL, 
// NULL);

// INSERT INTO `mk` (`username`, `image`, `time`) 
// VALUES ('mk', 'data:image/png;base64', CURRENT_TIMESTAMP);

$conn = null;

?>