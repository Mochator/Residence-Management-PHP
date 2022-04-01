<?php include ("connection.php");
include ("login-session.php");
include("retrieve.php");
include("access-admin.php");

	$id = $_GET["ID"];
	$type = $_GET["type"];
	$unit = $_GET["unit"];

	$sql = "select * from parking_slot where Type ='$type' and Unit_ID is null;";
	if(!$run = mysqli_query($con, $sql)){
		echo "<script>alert('Failed to fetch user query');</script>";
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>UPTOWN | Assign Parking Slot</title>
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

		<h1>Assign Parking</h1>
		<div class="content admin-form">
			<form method="post" <?php echo 'action="assign-parking.php?ID='.$id.'&type='.$type.'&unit='.$unit.'"';?> id="parkingSelect">
				<input type="hidden" name="pID" <?php echo "value='".$id."'";?> >
        		<input type="hidden" name="pUnit" <?php echo "value='".$unit."'";?>>
        		<label for="requestID">Parking Slot Request ID : <?php echo $id ?></label><br><br>
        		<label for="unitID">Request Unit ID : <?php echo $unit ?></label><br><br>
        		<label for="requestType">Parking Slot ID</label><br>
        		<select name="parkingSlot" form="parkingSelect">
          		<?php
            	while($row = mysqli_fetch_assoc($run)){
              		echo "<option value='".$row["ID"]."'>".$row["ID"]."</option>";
            	}
          		?>
          		</select>
          		<br><br>
          		<input type="Submit" name="submit" value="Assign">
			</form>
		</div>
	</div>
</body>
</html>

<?php
if(isset($_POST["submit"])){
	$booPSlot = false;
	$booPReq = false;

  $slot = $_POST["parkingSlot"];
  $reqId = $_POST["pID"];
  $reqUnit = $_POST["pUnit"];
  $status = "Approved - ".$slot;
  $date = date("Y-m-d");

  $slotQuery = "update parking_slot set Unit_ID = '$reqUnit', Registered_date = '$date' where ID ='$slot';";
  $reqQuery = "update parking_slot_request set Status = '$status' where ID = '$reqId';";

  if(!$runSlot = mysqli_query($con, $slotQuery)){
    echo "<script>alert('".mysqli_error($con)."');</script>";
  } else {
    $booPSlot = true;
  }

  if(!$runReq = mysqli_query($con, $reqQuery)){
    echo "<script>alert('".mysqli_error($con)."');</script>";
  } else {
    $booPReq = true;
  }

  if($booPReq == true && $booPSlot == true){
    echo "<script>alert('Parking slot request Status and new parking slot updated');</script>";
    echo "<script>window.location.href='admin-panel.php';</script>";
    //header("Refresh:0"); 
  } else {
    echo "<script>alert('Either one of both status was failed to update');</script>";
  }

  unset($_POST["submit"]);
}
?>
