<?php
if(!($session_role == "Tenant" || $session_role == "Owner")){
	echo "<script>alert('Access Denied');</script>";
	header("Location: dashboard.php");
}
?>