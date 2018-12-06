<?php
include '../forms/default.php';

/************************************/
/*			Create Table	   		*/
/************************************/
try {
	$conn = new PDO("mysql:host=$servername;dbname=$myDB", USERNAME, PASSWORD);
	// set the PDO error mode to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	// sql to create table
	$sql = "CREATE TABLE ".$usrsTB." (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	username VARCHAR(20) NOT NULL , 
	firstname VARCHAR(30) NOT NULL,
	lastname VARCHAR(30) NOT NULL,
	email VARCHAR(50) NOT NULL,
	notification TINYINT(1) NOT NULL DEFAULT '1',
	pssword VARCHAR(255) NOT NULL , 
	confirm VARCHAR(255) NOT NULL , 
	active TINYINT(1) NOT NULL
	)";
	// use exec() because no results are returned
	$conn->exec($sql);
	echo "Table ".$usrsTB." created successfully<br>";
}
catch(PDOException $e) {
	echo $sql . $e->getMessage();
}

/************************************/
/*			Create UsrsTbl 	   		*/
/************************************/

// $sql = "CREATE TABLE ".$usrTB." ( id INT(255) NOT NULL AUTO_INCREMENT PRIMARY KEY,  username VARCHAR(20) NOT NULL , `image` LONGTEXT NOT NULL ,  `time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,  coments TEXT NULL ,  likes TEXT NULL)"; for propper likes
try{
	$sql = "CREATE TABLE ".$usrTB." 
	( 
		id INT(255) NOT NULL AUTO_INCREMENT PRIMARY KEY,  
		username VARCHAR(20) NOT NULL , 
		`image` LONGTEXT NOT NULL ,  
		`time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,  
		coments TEXT NULL ,  
		likes INT NULL
	)";
	$conn->exec($sql);
	$_SESSION['message'] = "Your account has been verified, you can login now<br>";
	$_SESSION['type'] = 'success';
	echo "User table ".$usrTB." created Successfully.<br>";
}catch (PDOException $e) {
	echo "Errorr creating user table.<br>";
	echo "Sql querry error: " . $e->getMessage() . "<br>";
}
$conn = null;
header("Location: ../login.php");
?>