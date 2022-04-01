<?php
if(!$session_role == "Admin"){
	echo "<script>alert('Access Denied');</script>";
	header("Location: dashboard.php");
}
?>