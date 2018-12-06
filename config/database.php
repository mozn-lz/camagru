<?php
include '../forms/default.php';

/************************************/
/*				Create DB	   		*/
/************************************/
try {
	$conn = new PDO("mysql:host=$servername", USERNAME, PASSWORD);
	// set the PDO error mode to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "CREATE DATABASE ".$myDB;
	// use exec() because no results are returned
	$conn->exec($sql);
	echo "Database created successfully<br>";
}
catch(PDOException $e) {
	echo $sql . "<br>" . $e->getMessage();
}
$conn = null;
header("Location: ./setup.php");
?>