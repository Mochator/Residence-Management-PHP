<?php
//delete financial statement only 
include ("connection.php");
include ("login-session.php");
include("retrieve.php");
include("access-admin.php");

$id = $_GET["ID"];
$sql = "delete from financial_statement where ID = '$id'";
if(!$run = mysqli_query($con, $sql)){
	echo "<script>alert('Failed to delete! Error : '.".mysqli_error($con).";</script>";
} else {
	echo "<script>window.close();</script>";
}
?>