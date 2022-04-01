<?php 
include ("connection.php");
include ("login-session.php");
include("retrieve.php");
include("access-admin.php");

?>

<!DOCTYPE html>
<html>
<head>
	<title>UPTOWN | Create Financial Statement</title>
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

		<h1>Create Financial Statement</h1>
		<div class="content admin-form">
			<form method="post" action="add-financial.php">
  
  
		<span class="">Financial Type</span><br>
<select class="" name="Financial_type" id="scripts">
<option value="0" label="Select a financial type." selected hidden></option>
		<?php 
		$res=mysqli_query($con,"select * from financial_type");
		while($row=mysqli_fetch_assoc($res))
		{	
		echo "<option value='".$row["ID"]."'>".$row["Type"]."</option>";
		}
		
		?>
</select>	

    <br><br>
		<span class="">Unit ID</span><br>
<select class="" name="Unit_ID" id="scripts">
<option value="0" label="Select a Unit id." selected hidden></option>
		<?php 
		$res=mysqli_query($con,"select ID from unit");
		while($row=mysqli_fetch_assoc($res))
		{	
		echo "<option value='".$row["ID"]."'>".$row["ID"]."</option>";
		}
		
		?>
</select>	
	<br><br>
    <label for="amt">Amount</label><br>
    <input type="text" name="Amount" placeholder="Numeric value only" required="required" pattern="*\d{1,10}+.*\d{0,2})|*\d{1,10}" title="Numeric value only">
    <br><br>
    <label for="amt">Due Date</label><br>
    <input type="date" name="Due" <?php echo "min='".date('Y-m-d')."'";?> required="required" >
    <br><br>

    <input type="hidden" name="Status" value="Pending">

	<input type="submit" value="Create Financial Statement" name="submit" required>
</form>
		</div>
	</div>
</body>
</html>

<?php

if (isset($_POST['submit'])) {
$ftype = $_POST['Financial_type'];
$due = $_POST['Due'];
$uid = $_POST['Unit_ID'];
$status = $_POST['Status'];
$amount = $_POST['Amount'];

if($uid == "0" || $ftype == "0"){
	echo'<script>alert("All fields have to be filled!");</script>';
	//echo $ftype;
	//echo $uid;
} else {
	//echo "success1/2";
	$sql="INSERT INTO financial_statement(Financial_type, Amount, Due, Status, Unit_ID) Values ('$ftype','$amount','$due','Not paid','$uid')";

if(!mysqli_query($con,$sql))
{
  die('Error:'.mysqli_error($con));
} else {
echo'<script>alert("New financial statement has created!");window.location.href = "admin-panel.php";</script>';
	//echo "success";
}
}
mysqli_close($con);
}
?>

