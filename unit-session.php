<!--To check if user has logged in-->
<?php
if($_SESSION["Role"] == "Owner" || $_SESSION["Role"] == "Tenant"){
	if(!(isset($_SESSION["Unit"]))) {
		header("Location: dashboard.php");
	}
}
?>