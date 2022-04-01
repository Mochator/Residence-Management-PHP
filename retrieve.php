<?php
//Retrieve ID

$session_id = $_SESSION["ID"];
$session_role = $_SESSION["Role"];

if(isset($_SESSION["Unit"])) {
	$session_unit = $_SESSION["Unit"];
}

$userQuery = "select * from user where ID = '$session_id';";
if(!$runUser = mysqli_query($con, $userQuery)){
	die("Error : ".mysqli_error($con));
} else {
	$userRow = mysqli_fetch_assoc($runUser);
	$firstName = $userRow["First_name"];
}

?>
