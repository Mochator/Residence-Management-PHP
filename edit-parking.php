<?php 
include ("connection.php");
include ("login-session.php");
include("retrieve.php");
include("access-admin.php");
$id = $_GET["ID"];

$sql = "select * from parking_slot where ID = '$id';";
if(!$run = mysqli_query($con, $sql)){
	echo "<script>alert('Failed to fetch user query');</script>";
} else {
	$row = mysqli_fetch_assoc($run);
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>UPTOWN | Edit Parking Slot</title>
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

		<h1>Edit Parking Slot</h1>
		<div class="content admin-form">
			<form method="post" id="parking-form" <?php echo 'action="edit-parking.php?ID='.$id.'"';?> >
				<label for="slot">Parking Slot : <?php echo $id; ?></label>
				<br><br>
				<label for="type">Parking Type : <?php echo $row["Type"];?></label>
				<br><br>
				<label for="unit">Unit</label><br>
				<input type="hidden" name="slot" <?php echo "value='".$id."'";?>>
				<select name='unit' form="parking-form">
					<option value="null">---Remove Unit---</option>
					<?php
					$unitSql = "select * from Unit;";
					$runUnit = mysqli_query($con,$unitSql);

					while($unitRow = mysqli_fetch_assoc($runUnit)){
						echo "<option value='";
						echo $unitRow["ID"];
						echo "'";
						if($unitRow["ID"] == $row["Unit_ID"]) {
							echo " selected ";
						}
						echo ">".$unitRow["ID"]."</option>";
					}
					?>
				</select><br><br>
				<input type="submit" name="submit" value="Save">
			</form>
		</div>
	</div>
</body>
</html>

<?php
if(isset($_POST["submit"])) {
	$slot = $_POST["slot"];
	$unit = $_POST["unit"];
	$date = date("Y-m-d");
	$updateSql = "update parking_slot set Unit_ID = '$unit', Registered_date = '$date' where ID = '$slot'";

	if(!$runUpdate = mysqli_query($con, $updateSql)) {
		echo "<script>alert('".mysqli_error($con)."');</script>";
	} else {
		echo "<script>alert('Parking slot data updated!');</script>";
		echo "<script>window.location.href='admin-panel.php';</script>";
	}
	
}
?>