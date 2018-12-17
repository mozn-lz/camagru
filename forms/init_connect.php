<?php
include 'default.php';
try{
	$conn = new PDO("mysql:host=".SERVERNAME.";dbname=".DBNAME."", USERNAME, PASSWORD);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch (PDOException $e){
	echo "DATABASE CONNECTION FAILED WITH: " . $e->getMessage();
}
?>