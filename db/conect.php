<?php

// include 'default.php';

$servername = "localhost";
$myDB = "camagru";
$username = "root";
$password = "wethinkcode";
$usrsTB = "users";

/************************************/
/*				Create DB	   		*/
/************************************/
// try {
// 	$conn = new PDO("mysql:host=$servername", $username, $password);
// 	// set the PDO error mode to exception
// 	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// 	$sql = "CREATE DATABASE ".$myDB;
// 	// use exec() because no results are returned
// 	$conn->exec($sql);
// 	echo "Database created successfully<br>";
// }
// catch(PDOException $e)
// {
// 	echo $sql . "<br>" . $e->getMessage();
// }

/************************************/
/*			Create Table	   		*/
/************************************/
try {
    $conn = new PDO("mysql:host=$servername;dbname=$myDB", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// sql to create table
$sql = "CREATE TABLE ".$usrsTB." (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	username VARCHAR(20) NOT NULL , 
	firstname VARCHAR(30) NOT NULL,
	lastname VARCHAR(30) NOT NULL,
	email VARCHAR(50),
	pssword VARCHAR(255) NOT NULL , 
	verified TINYINT(1) NOT NULL
	)";

    // use exec() because no results are returned
    $conn->exec($sql);
    echo "Table ".$usrsTB." created successfully";
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }



	// "DROP DATABASE `camagru`;
	// DROP DATABASE `mydbpdo`;"

/*
id
username
firstname
lastname
email
pssword
verified
*/	

/************************************/
/*			Insert Data 	   		*/
/************************************/
// try {
//     $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
//     // set the PDO error mode to exception
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//     // prepare sql and bind parameters
//     $stmt = $conn->prepare("INSERT INTO ".$usrsTB." 
// 	(username, firstname, lastname, email, pssword, verified) 
//     VALUES (:username, :firstname, :lastname, :email, :pssword, :verified)");


// 	$stmt->bindParam(':username', $username);
// 	$stmt->bindParam(':firstname', $firstname);
// 	$stmt->bindParam(':lastname', $lastname);
// 	$stmt->bindParam(':email', $email);
// 	$stmt->bindParam(':pssword', $pssword);
// 	$stmt->bindParam(':verified', $verified);

// 	// insert a row
// 	$username = $_POST('username');
// 	$firstname = $_POST('firstname');
// 	$lastname = $_POST('lastname');
// 	$email = $_POST('email');
// 	$pssword = $_POST('pssword');
// 	$verified = $_POST('verified');
//     $stmt->execute();

//     echo "New records created successfully";
//     }
// catch(PDOException $e)
//     {
//     echo "Error: " . $e->getMessage();
//     }


$conn = null;
?>