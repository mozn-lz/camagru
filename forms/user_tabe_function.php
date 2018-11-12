<?php
session_start();
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

	if ($image) {
		echo '2<br>';
		echo $image . "<br>";
		try{
			$stmt = $conn->prepare("INSERT INTO ".$usrTB." (username, image) VALUES (:uName, :imge)");
			$username = $_SESSION['uName'];
			$image = $_POST['user_pic'];
			$stmt->bindParam(':uName', $_SESSION['uName']);
			$stmt->bindParam(':imge', $image);
			$stmt->extcute();
			echo 'Image uploaded<br>';
		}catch(PDOException $e){
			echo "Insertion error :" . $e->getMessage() . "<br>";
		}
	}
} else {
	echo ('File not found.<br>');
}

// $picture = $_POST('user_pic');

$conn = null;
?>