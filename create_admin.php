<?php
include('connection.php');
error_reporting(0);
session_start();
if (!isset($_SESSION['Admin_ID'])) {
	header("location:admin_login.php");
	die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="photos\images.png"/>
    <title>Create | Admin</title>
</head>
<body>
    
</body>
</html>