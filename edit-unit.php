<?php 
include ("connection.php");
include ("login-session.php");
include("retrieve.php");
include("access-admin.php");
$id = $_GET["ID"];
$sql = "select * from unit where ID = '$id';";
if(!$run = mysqli_query($con, $sql)){
	echo "<script>alert('Failed to fetch user query');</script>";
} else {
	$row = mysqli_fetch_assoc($run);
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>UPTOWN | Edit Unit Owner</title>
	<link rel="stylesheet" href="css/default.css">
	<link rel="stylesheet" href="css/admin-panel.css">
	<!--Web Icon & Font input-->
	<script src="head-input.js"></script>
	<!--Font awesome-->
	<link href="font-awesome/css/all.css" rel="stylesheet">
	<script defer src="/font-awesome/js/all.js"></script>
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

		<h1>Edit Unit Owner</h1>
		<div class="content admin-form">
			<form method="post" <?php echo 'action="edit-unit.php?ID='.$id;?>>
				<label for="unit">Unit : <?php echo $id; ?></label>
				<br><br>
				<label for="type">Unit Type : <?php echo $row["Type"];?></label>
				<br><br>
				<label for="user">User</label><br>
				<input type="hidden" name="unit" <?php echo "value='".$id."'";?>>
				<select name='user'>
					<option value="null">---Remove User---</option>
					<?php
					$userSql = "select * from User where Role = 'Owner';";
					$runUser = mysqli_query($con,$userSql);

					while($userRow = mysqli_fetch_assoc($runUser)){
						echo "<option ";
						if($userRow["ID"] == $row["User_ID"]) {
							echo "selected ";
						}
						echo "value='".$userRow["ID"]."'>".$userRow["ID"]."</option>";
					}

					?>
				</select>
				<br><br>
				<input type="submit" name="submit" value="Save">
			</form>
		</div>
	</div>
</body>
</html>

<?php
if(isset($_POST["submit"])) {
	$user = $_POST["user"];
	$unit = $_POST["unit"];
	$updateSql = "update unit set User_ID = '$user' where ID = '$unit'";

	if(!$runUpdate = mysqli_query($con, $updateSql)) {
		echo "<script>alert('".mysqli_error($con)."');</script>";
	} else {
		echo "<script>window.location.href='admin-panel.php';</script>";
	}
	
}
?>