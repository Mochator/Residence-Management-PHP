<?php
include("connection.php");
include("login-session.php");
include("unit-session.php");
include("retrieve.php");
date_default_timezone_set("Asia/Kuala_Lumpur");

?>

<!DOCTYPE html>
<html>
<head>
	<title>UPTOWN | Profile Setting</title>
	<link rel="stylesheet" href="css/default.css">
	<link rel="stylesheet" href="css/profile-setting.css">
	<!--Web Icon & Font input-->
	<script src="head-input.js"></script>
	<!--Font awesome-->
	<link href="font-awesome/css/all.css" rel="stylesheet">
	<script defer src="/font-awesome/js/all.js"></script>
</head>

<body>
	<div class="wrapper">
		<header>
			<nav class="container">
				<?php
					if($session_role == "Owner") {
						include("nav-owner.php");
					} else if ($session_role == "Tenant") {
						include("nav-tenant.php");
					} else if ($session_role == "Admin") {
						include("nav-admin.php");
					} else if ($session_role == "Security") {
						include("nav-security.php");
					}
				?>
			</nav>
		</header>
		<article>
			<h1>Profile Setting</h1>
			<!--Error message-->
			<script src="information-window.js" type="text/javascript"></script>

			<!--Form part-->
			<form method="post" action="profile-setting.php">
				<div class="content">
					<label for="firstName">First Name</label><br>
					<input type="text" name="firstName" class="input-field width50">
					<br><br>
					<label for="lastName">Last Name</label><br>
					<input type="text" name="lastName" class="input-field width50">
					<br><br>
					<label for="contact">Contact</label><br>
					<input type="text" name="contact" class="input-field width50" pattern="\d*" title="Numeric value only">
					<br><br>
					<label for="email">Email</label><br>
					<input type="email" name="Email" class="input-field width50">
					<br><br>
					<label for="newPassword">New Password</label><br>
					<input type="password" name="newPassword" class="input-field width50">
					<br><br>
					<label for="newPasswordCfm">New Password Confirmation</label><br>
					<input type="password" name="newPasswordCfm" class="input-field width50">
					<br><br>
				</div>
				<div class="content">
					<label for="currentPassword">Current Password</label><br>
					<input type="password" name="currentPassword" class="input-field width50" required>
					<br><br>

				</div>
				<input type="submit" name="submit" value="Save">
			</form>	
		</article>
		<footer>
			<?php
			include("footer.php");
			?>
		</footer>
	</div>


<?php
if(isset($_POST["submit"])){
	//Check current password field
	$booPw = false;
	$password = $_POST["currentPassword"];
	$password = mysqli_real_escape_string($con, $password);
	$password = stripslashes($password);
	$password = htmlentities($password);
	$password = md5($password);

	$pwQuery = "select * from user where ID = '$session_id';";

	if(!$runPw = mysqli_query($con, $pwQuery)){
		echo "Error : ".mysqli_error($con);
	} else {
		$pwRow = mysqli_fetch_assoc($runPw);
		if($password == $pwRow["Password"]) {
			//Success modify
			$successFName = false;
			$successLName = false;
			$successContact = false;
			$successEmail = false;
			$successPassword = false;

			//echo "pw correct";

			//Check each field value
			if(!empty($_POST["firstName"])){
				$fName = $_POST["firstName"];
				$password = mysqli_real_escape_string($con, $fName);
				$password = stripslashes($fName);
				$password = htmlentities($fName);
				$query = "update user set Firstname = '$fName' where ID = '$session_id'";
				if(!$runQuery = mysqli_query($con, $query)){
					echo "<script>document.getElementById('error-content').innerHTML = 'Failed to update First Name.<br>';</script>";
				} else {
					$successFName = true;
				}
			} else {
				$successFName = true;
			}

			if(!empty($_POST["lastName"])){
				$lName = $_POST["lastName"];
				$lName = mysqli_real_escape_string($con, $lName);
				$lName = stripslashes($lName);
				$lName = htmlentities($lName);
				$query = "update user set Last_name = '$lName' where ID = '$session_id'";
				if(!$runQuery = mysqli_query($con, $query)){
					echo "<script>document.getElementById('error-content').innerHTML = 'Failed to update Last Name.<br>';</script>";
				} else {
					$successLName = true;
				}
			} else {
				$successLName = true;
			}

			if(!empty($_POST["contact"])){
				$contact = $_POST["contact"];
				$contact = mysqli_real_escape_string($con, $contact);
				$contact = stripslashes($contact);
				$contact = htmlentities($contact);
				$query = "update user set Contact = '$contact' where ID = '$session_id'";
				if(!$runQuery = mysqli_query($con, $query)){
					echo "<script>document.getElementById('error-content').innerHTML = 'Failed to update Contact.<br>';</script>";
				} else {
					$successContact = true;
				}
			} else {
				$successContact = true;
			}

			if(!empty($_POST["newPassword"])){
				//$newPw
				$newPw = $_POST["newPassword"];
				$newPwCfm = $_POST["newPasswordCfm"];

				if($newPw == $newPwCfm){
					$newPw = mysqli_real_escape_string($con, $newPw);
					$newPw = stripslashes($newPw);
					$newPw = htmlentities($newPw);
					$newPw = md5($newPw);

					$query = "update user set Password = '$newPw' where ID = '$session_id'";
					if(!$runQuery = mysqli_query($con, $query)){
						echo "<script>document.getElementById('error-content').innerHTML = 'Failed to update Password.<br>';</script>";
					} else {
						$successPassword = true;
					}
				} else {
					echo "<script>document.getElementById('information-content').innerHTML += 'Update failed as new password entered doesn't match!';</script>";
				}
			} else {
				$successPassword = true;
			}

			if(!empty($_POST["email"])){
				$email = $_POST["email"];
				$email = mysqli_real_escape_string($con, $email);
				$email = stripslashes($email);
				$email = htmlentities($email);
				$query = "update user set Email = '$email' where ID = '$session_id'";
				if(!$runQuery = mysqli_query($con, $query)){
					echo "<script>document.getElementById('error-content').innerHTML = 'Failed to update Email.<br>';</script>";
				} else {
					$successEmail = true;
				}
			} else {
				$successEmail = true;
			}

			if($successEmail == false || $successPassword ==  false || $successContact ==  false || $successLName ==  false || $successFName == false) {
				echo "<script>document.getElementById('error').style.display = 'block'</script>";
				echo "<script>document.getElementById('error-title').innerHTML = 'Update Failed'</script>";
			} else {
				echo "<script>document.getElementById('information').style.display = 'block'</script>";
				echo "<script>document.getElementById('information-title').innerHTML = 'Update Success';</script>";
				echo "<script>document.getElementById('information-content').innerHTML += 'Data has been successfully updated';</script>";
			}

		} else {
			echo "<script>document.getElementById('information').style.display = 'block'</script>";
			echo "<script>document.getElementById('information-title').innerHTML = 'Password Incorrect';</script>";
			echo "<script>document.getElementById('information-content').innerHTML += 'Update failed as current password entered is incorrect!';</script>";
		}
	}
}
?>

</body>
</html>