<?php
session_start();
include 'default.php';
$userTB = $_SESSION['email'];
/************************************/
/*			Create Table	   		*/
/************************************/
try {
	// //	conect to database  to be able to execute CRUD opperations
	// $conn = new PDO("mysql:host=".SERVERNAME.";dbname=".DBNAME."", USERNAME, PASSWORD);
	// // set the PDO error mode to exception
	// $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	// sql to create table
	// $sql = "CREATE TABLE ".$usrsTB."(
	// id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	// username VARCHAR(50),
	// email VARCHAR(50),
	// image VARCHAR(20) NOT NULL , 
	// timestmap VARCHAR(30) NOT NULL,
	// coments VARCHAR(30) NULL,
	// likes VARCHAR(30) NULL
	// )";

	// // sql to create table


	$val = mysql_query('select 1 from `table_name` LIMIT 1');

	if($val !== FALSE)
	{
	//DO SOMETHING! IT EXISTS!
	}
	else
	{
		function create_user_table($username) {
			$usrTB = $username;
			$sql = "CREATE TABLE ".$usrTB." 
			( 
				id INT(255) NOT NULL AUTO_INCREMENT PRIMARY KEY,  
				`image` BLOB NOT NULL ,  
				`time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,  
				coments VARCHAR(255) NULL ,  
				likes TINYINT(1) NULL
			)";
				
				// use exec() because no results are returned
				$conn->exec($sql);
				echo "Table ".$usrTB." created successfully";
		}
		function uplolad_pictures($username) {
		// $stmt = $conn-> INSERT image INTO $username
			$stmt = $conn->prepare("INSERT INTO ".$username." (image, time, email) VALUES (?, ?, ?)");
			$stmt->bind_param("sss", $firstname, $lastname, $email);
		
		}
	}


}
catch(PDOException $e) {
	echo $sql . "<br>" . $e->getMessage();
}


$conn = null
?>