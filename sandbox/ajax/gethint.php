<?php

$servername = "localhost";
$myDB = "camagru";
// $username = "admin";
// $password = "1234";
$username = "root";
$password = "wethinkcode";
$usrsTB = "users";

define ("SERVERNAME" , $servername);
define ("DBNAME" , $myDB);
define ("USERNAME" , $username);
define ("PASSWORD" , $password);
define ("SALT" , "whirlpool" );

try
{
	//	conect to database  to be able to execute CRUD opperations
	$conn = new PDO("mysql:host=".SERVERNAME.";dbname=".DBNAME."", USERNAME, PASSWORD);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	/********************/
	/*		updte		*/
	/********************/
    if ($_POST['update_uName']) {
        $uName = $_POST('update_uName');
        $stmt = $conn->prepare("UPDATE users SET email = :email) WHERE id = ".$_SESSION['id']);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
    }
}
catch(PDOException $e){
    echo "Error: " . $e->getMessage();
}
?>