<?php 
include ("connection.php");
include ("login-session.php");
include("retrieve.php");
include("access-admin.php");
$id = $_GET["ID"];
$sql = "select *, financial_statement.ID as Financial_ID from financial_statement inner join financial_type on financial_statement.Financial_type = financial_type.ID where financial_statement.ID = '$id';";
if(!$run = mysqli_query($con, $sql)){
	echo "<script>alert('Failed to fetch user query');</script>";
} else {
	$row = mysqli_fetch_assoc($run);
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>UPTOWN | Edit Financial Statement</title>
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

		<h1>Edit Financial Statement</h1>
		<div class="content admin-form">
			<form method="post" <?php echo "action=edit-financial.php?ID=".$id;?>>
				<label for="ID">ID : <?php echo $row["Financial_ID"];?></label>
				<br><br>
				<label for="fName">Type</label><br>
				<select name="type">
					<?php 
						$typeQuery = "select * from financial_type;";
						$runType = mysqli_query($con, $typeQuery);

						while($typeRow = mysqli_fetch_assoc($runType)) {
							echo "<option value='";
							echo $typeRow["ID"];
							echo "'";
							if($row["Type"] == $typeRow["Type"]){
								echo " selected";
							}
							echo " >";
							echo $typeRow["Type"];
							echo "</option>";
						}
					?>
				</select>
				<br><br>
				<label for="amount">Amount</label><br>
				<input type="text" name="amount" <?php echo "value='".$row["Amount"]."'";?>>
				<br><br>
				<label for="due">Due</label><br>
				<input type="date" name="due" <?php echo "value='".$row["Due"]."'";?>>
				<br><br>
				<label for="status">Status</label><br>
				<select name="status">
					<option value="Paid" <?php if($row["Status"] == "Paid"){echo "selected";}?> >Paid</option>
					<option value="Not paid" <?php if($row["Status"] == "Not paid"){echo "selected";}?> >Not paid</option>
				</select>
				<br><br>
				<label for="unitId">Unit ID</label><br>
				<select name="unit">
				<?php
					$unitSql = "select * from Unit;";
					$runUnit = mysqli_query($con,$unitSql);

					while($unitRow = mysqli_fetch_assoc($runUnit)){
						echo "<option ";
						if($unitRow["ID"] == $row["Unit_ID"]) {
							echo "selected ";
						}
						echo "value='".$unitRow["ID"]."'>".$unitRow["ID"]."</option>";
					}

				?>
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
	$type = $_POST["type"];
	$amount = $_POST["amount"];
	$due = $_POST["due"];
	$status = $_POST["status"];
	$unit = $_POST["unit"];

	$updateSql = "update financial_statement set Financial_type = '$type', Amount ='$amount', Due = '$due', Status = '$status', Unit_ID = '$unit' where ID = '$id';";

	if(!$runUpdate = mysqli_query($con, $updateSql)) {
		die(mysqli_error($con));
	} else {
		echo "<script>window.location.href='admin-panel.php';</script>";
		
	}
	
}
?>