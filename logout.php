<?php
	session_start();
	if(isset($_SESSION["ID"])) {
		unset($_SESSION["ID"]);
		//echo "ID unset done";
	}
	if(isset($_SESSION["Role"])) {
		unset($_SESSION["Role"]);
		//echo "Role unset done";
	}
	if(isset($_SESSION["Unit"])) {
		unset($_SESSION["Unit"]);
		//echo "Unit unset done";
	}
	
	session_destroy();
	echo "<body style='background-color: #E34234; position: relative;'><div style='position:absolute; margin: auto; top:0; right: 0; left:0; bottom:0;'><h1 style='color: white;'>Redirecting you back to login page...</h1></div></body>";
	header("Refresh:1; login.php");
?>