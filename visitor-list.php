<?php 
include ("connection.php");
include ("login-session.php");
include("unit-session.php");
include("retrieve.php");
include("access-security.php");
?>

<!DOCTYPE html>
<html>
<head>
	<title>UPTOWN | Visitor List</title>
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
			<a href="dashboard.php"><button class="tabtitle"><< Dashboard</button></a>
		</div>
	</div>
	<div class="tabcontent" style="display: block;">
		<h1>Visitor List</h1>
		<div class="content admin-form" style=" padding: 10px;">
			<table>
          	<tr>
            	<th>ID</th>
      	      	<th>Name</th>
       	    	<th>Vehicle Type</th>
   	         	<th>Vehicle No.</th>
            	<th>Visit Purpose</th>
            	<th>Unit ID</th>
            	<th>Contact</th>
            	<th>Date</th>
            	<th>Status</th>
            	<th>Action</th>   
          	</tr>
          <?php
          $today = date("Y-m-d");
          $visitorQuery = "select *, visitor.ID as VisitorID from visitor left join user on visitor.User_ID = user.ID where visitor.Date = '$today' order by visitor.ID desc, visitor.Status desc ;";
          if(!$runVisitor = mysqli_query($con, $visitorQuery)){
            echo "Error : ".mysqli_error($con);
          } else {
            while($visitorRow = mysqli_fetch_assoc($runVisitor)){
              echo "<tr><td>";
              echo $visitorRow["VisitorID"];
              echo "</td><td>";
              echo $visitorRow["Name"];
              echo "</td><td>";
              echo $visitorRow["Types"];
              echo "</td><td>";
              echo $visitorRow["Vehicle_No"];
              echo "</td><td>";
              echo $visitorRow["Visit_Purpose"];
              echo "</td><td>";
              echo $visitorRow["Unit_ID"];
              echo "</td><td>";
              echo $visitorRow["Contact"];
              echo "</td><td>";
              echo $visitorRow["Date"];
              echo "</td><td>";
              echo $visitorRow["Status"];
              echo "</td>";
              if($visitorRow["Status"] == "Pending"){
                echo "<td class='center'>";
                echo "<form method='post' action='visitor-list.php'>";
                echo "<input type='submit' name='visitorTick' style=\"background-image:url('Resources/tick.png');\" class='status-button' value='".$visitorRow["VisitorID"]."'></form>";
                echo "<form method='post' action='visitor-list.php'>";
                echo "<input type='hidden' name='visitorDate' value='".$visitorRow["Date"]."'>";
                echo "<input type='submit' name='visitorDel' style=\"background-image:url('Resources/cross.png');\" class='status-button' value='".$visitorRow["VisitorID"]."'></form>";
              } else {
                echo "<td>Reviewed";
              }
              echo "</td></tr>";
            }
          }
          ?>
        </table>
		</div>
	</div>
</body>
</html>

<?php
if(isset($_POST["visitorTick"])) {
	$id1 = $_POST["visitorTick"];
	$updateSql1 = "update visitor set Status = 'Reached' where ID = '$id1'";

	if(!$runUpdate1 = mysqli_query($con, $updateSql1)) {
		echo "<script>alert('".mysqli_error($con)."');</script>";
	} else {
		echo "<script>window.location.href='visitor-list.php';</script>";
	}
	unset($_POST["visitorTick"]);
}
?>

<?php
if(isset($_POST["visitorDel"])) {
	$id2 = $_POST["visitorDel"];
	$date = $_POST["visitorDate"];
	$today = date("Y-m-d");

	$updateSql2 = "update visitor set Status = 'Removed' where ID = '$id2'";

	if(!$runUpdate2 = mysqli_query($con, $updateSql2)) {
		echo "<script>alert('".mysqli_error($con)."');</script>";
	} else {
		echo "<script>window.location.href='visitor-list.php';</script>";
	}
}
?>

<?php
$autoSql = "update visitor set Status = 'Removed' where Status = 'Pending' and Date < '$today'";
mysqli_query($con, $autoSql);
?>