<?php
if(!$session_role == "Security"){
	echo "<script>alert('Access Denied');</script>";
	header("Location: dashboard.php");
}
?>