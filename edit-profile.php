<?php include ("connection.php");
include ("login-session.php");
include("retrieve.php");
include("access-admin.php");
$id = $_GET["ID"];
$sql = "select * from user where ID = '$id';";
if(!$run = mysqli_query($con, $sql)){
	echo "<script>alert('Failed to fetch user query');</script>";
} else {
	$row = mysqli_fetch_assoc($run);
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>UPTOWN | Edit User Profile</title>
	<link rel="stylesheet" href="css/default.css">
	<link rel="stylesheet" href="css/admin-panel.css">
	<!--Web Icon & Font input-->
	<script src="head-input.js"></script>
	<!--Font awesome-->
	<link href="font-awesome/css/all.css" rel="stylesheet">
	<script defer src="/font-awesome/js/all.js"></script>

	<!--Javascript-->
	<script>
		function confirmPassword(){
			var pwField = document.getElementById("newPw").value;
			var cfmPwField = document.getElementById("cfmNewPw");

			if(pwField == ""){
				cfmPwField.value = "";
				cfmPwField.disabled = true;
			} else {
				cfmPwField.disabled = false;
			}
		}
	</script>
</head>

<body>
	<div class="tab">
		<div class="tabback">
			<a href="admin-panel.php"><button class="tabtitle"><< Admin Panel</button></a>
			<a href="dashboard.php"><button class="tabtitle"><< Dashboard</button></a>
		</div>
	</div>
	<div class="panel-content">
		<!--Error message-->
		<script src="information-window.js" type="text/javascript"></script>

		<h1>Edit User Profile</h1>
		<div class="content admin-form">
			<form method="post" <?php echo "action=edit-profile.php?ID=".$id;?>>
				<label for="ID">ID : <?php echo $row["ID"];?></label>
				<br><br>
				<label for="fName">First Name</label><br>
				<input type="text" name="fName" <?php echo "value='".$row["First_name"]."'";?>>
				<br><br>
				<label for="lName">Last Name</label><br>
				<input type="text" name="lName" <?php echo "value='".$row["Last_name"]."'";?>>
				<br><br>
				<label for="contact">Contact</label><br>
				<input pattern= "\d*" type="text" name="contact" <?php echo "value='".$row["Contact"]."'";?>>
				<br><br>
				<label for="email">Email</label><br>
				<input type="text" name="email" <?php echo "value='".$row["Email"]."'";?>>
				<br><br>
				<label for="Password">New Password</label><br>
				<input type="password" name="newPw" id="newPw" onchange="confirmPassword()">
				<br><br>
				<label for="cfmNewPw">Confirm New Password</label><br>
				<input type="password" name="cfmNewPw" id="cfmNewPw" disabled>
				<br><br>
				<label for="status">Account Status</label><br>
				<select name="status">
					<option value="Active" <?php if($row["Account_status"] == "Active"){echo "selected";}?> >Active</option>
					<option value="Inactive" <?php if($row["Account_status"] == "Inactive"){echo "selected";}?> >Inactive</option>
				</select>
				<br><br>
				<input type="submit" name="submit" value="Save Changes">
			</form>
		</div>
	</div>
</body>
</html>

<?php
if(isset($_POST["submit"])) {
	$fName = $_POST["fName"];
	$lName = $_POST["lName"];
	$contact = $_POST["contact"];
	$email = $_POST["email"];
	$status = $_POST["status"];

	$fName = mysqli_real_escape_string($con, $fName);
	$lName = mysqli_real_escape_string($con, $lName);
	$contact = mysqli_real_escape_string($con, $contact);
	$email = mysqli_real_escape_string($con, $email);
	$status = mysqli_real_escape_string($con, $status);

	$fName = stripslashes($fName);
	$lName = stripslashes($lName);
	$contact = stripslashes($contact);
	$email = stripslashes($email);
	$status = stripslashes($status);

	$fName = htmlentities($fName);
	$lName = htmlentities($lName);
	$contact = htmlentities($contact);
	$email = htmlentities($email);
	$status = htmlentities($status);

	print_r($_POST);

	$queryBoo = false;

	if(empty($_POST["newPw"])){
		$updateQuery = "update User set First_name='$fName', Last_name='$lName', Contact='$contact', Email='$email', Account_status='$status' where ID = '$id';";
		$queryBoo = true;
	} else {
		$newPw = $_POST["newPw"];
		$cfmNewPw = $_POST["cfmNewPw"];

		if($newPw == $cfmNewPw){
			$newPw = mysqli_real_escape_string($con, $newPw);
			$newPw = stripcslashes($newPw);
			$newPw = htmlentities($newPw);
			$newPw = md5($newPw);


			$updateQuery = "update User set First_name='$fName', Last_name='$lName', Contact='$contact', Email='$email', Account_status='$status', Password='$newPw' where ID = '$id';";
			$queryBoo = true;
		} else {
			echo "<script>document.getElementById('error').style.display = 'block'</script>";
			echo "<script>document.getElementById('error-content').innerHTML = 'Update failed as new password entered doesn\'t match!';</script>";
			echo "<script>document.getElementById('error-title').innerHTML = 'Passport Incorrect'</script>";
		}
	}

	if($queryBoo == true) {
		if(!$runUpdate = mysqli_query($con, $updateQuery)) {
			//echo "<script>document.getElementById('error-content').innerHTML = 'Failed to update one or more of the details<br>';</script>";
			echo "<script>document.getElementById('error-content').innerHTML = '".mysqli_error($con)."';</script>";
			echo "<script>document.getElementById('error').style.display = 'block'</script>";
			echo "<script>document.getElementById('error-title').innerHTML = 'Update Failed'</script>";
		} else {
			echo "<script>alert('Update success!');</script>";
			header("Refresh: 0");
		}
	}
}
?>