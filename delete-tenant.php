<?php
include("connection.php");
include ("login-session.php");
include("unit-session.php");
include("retrieve.php");
include("access-owner");
$id = $_GET["ID"];

$sql = "update user set Account_status = 'Inactive' where ID = '$id';";
if(!$run = mysqli_query($con, $sql)){
	die("Error : ".mysqli_error($con));
} else {
	echo "<script>alert('Tenant deleted');</script>";
	header("Location: manage-tenant.php");
}
?>