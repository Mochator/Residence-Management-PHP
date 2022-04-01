<!--To check if user has logged in-->
<?php
session_start();

if(!(isset($_SESSION["ID"]) && isset($_SESSION["Role"]))) {
	header("Location: login.php");
}

?>