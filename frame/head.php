<?php session_start(); 
// to be removed later
$_SESSION["id"] = "id";
$_SESSION["uName"] = "username";
$_SESSION["fName"] = "firstname";
$_SESSION["sName"] = "lastname";
$_SESSION["email"] = "email";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style/mastercss.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <?php?>
    <title><?php echo "$page_title"; ?></title>
</head>
<body>
<?php 
$type = $_SESSION['type'];
$message = $_SESSION['message'];
include 'frame/qm.php'; 
?>