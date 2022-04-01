<?php
include("connection.php");
session_start();
if(isset($_SESSION["ID"]) && isset($_SESSION["Role"])){
	header("Location: dashboard.php");
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" href="css/login.css">
	<link rel="stylesheet" href="css/default.css">
	<!--Web Icon & Font input-->
	<script src="head-input.js"></script>
</head>

<body style="background-color: #E34234;">
	<div id="login">
		<div id="title"><img src="Resources/Logo.png" alt="UPtown Logo"></div>
		<hr>
		<br>
		<form method="POST" action="login.php" id="form">
			<label for="email">Email</label><br>
			<input type="email" name="email" placeholder="eg. john12345@gmail.com">
			<br><br>
			<label for="password">Password</label><br>
			<input type="password" name="password">
			<br><br>
			<input type="submit" name="submit" value="Login"><br>
			<div id="login_error">x</div>
		</form>
		<hr>
		<p>Please visit our management office @ Level 7 or dial 03-1234567 for any further assistance. Thank you.<br><br>- UPTOWN Residence Management</p>
	</div>


<?php
if(isset($_POST["submit"])) {

	$email = $_POST["email"];
	$password = $_POST["password"];

	//HTML entities
	$email = mysqli_real_escape_string($con, $email);
 	$password = mysqli_real_escape_string($con, $password);

 	//stripslashes
	$email = stripslashes($email);
	$password = stripslashes($password);

	//htmlentities
	$email = htmlentities($email);
	$password = htmlentities($password);

	//Encryption
	$password = md5($password);

	//Query
	$query = "Select * from user where Email = '$email';";


	if(!$runQuery = mysqli_query($con, $query)) {
		die("Error : ". mysqli_error($con));
	} else {
		$rowCount = mysqli_num_rows($runQuery);

		if($rowCount == 1){

			$userRow = mysqli_fetch_assoc($runQuery);
			$dbPassword = $userRow["Password"];

			if($userRow["Account_status"] == "Active") { 
				if($password == $dbPassword) {
					$role = $userRow["Role"];
					$id = $userRow["ID"];

					//Set session
					$_SESSION["ID"] = $id;
					$_SESSION["Role"] = $role;

					//echo $_SESSION["ID"];
					//echo $_SESSION["Role"];

					//echo isset($_SESSION["ID"]);
					//echo isset($_SESSION["Role"]);

					//header("Location:dashboard.php");
					echo "<script>window.location.href='dashboard.php';</script>";
					//echo "password correct";
				} else {
					echo "<script>document.getElementById('login_error').innerHTML = 'Incorrect username or password';</script>";
					echo "<script>document.getElementById('login_error').style.visibility='visible';</script>";
				}
			} else {
				echo "<script>document.getElementById('login_error').innerHTML = 'Your account has been deactivated or terminated!';</script>";
				echo "<script>document.getElementById('login_error').style.visibility='visible';</script>";
			}
		} else {
			echo "<script>document.getElementById('login_error').innerHTML = 'User doesn\'t exist!';</script>";
			echo "<script>document.getElementById('login_error').style.visibility='visible';</script>";
		}

	}
}
	mysqli_close($con);
?>

</body>
</html>