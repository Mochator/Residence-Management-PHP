<?php 
include ("connection.php");
include ("login-session.php");
include("retrieve.php");
include("access-admin.php");

?>
<!DOCTYPE html>
<html>
<head>
	<title>UPTOWN | Admin Panel</title>
	<link rel="stylesheet" href="css/default.css">
	<link rel="stylesheet" href="css/admin-panel.css">
	<!--Web Icon & Font input-->
  <script src="head-input.js"></script>
	<!--Font awesome-->
	<link href="font-awesome/css/all.css" rel="stylesheet">
	<script defer src="/font-awesome/js/all.js"></script>

	<!--Javascript-->
	<script>
		function openCity(evt, cityName) {
  			// Declare all variables
  			var i, tabcontent, tablinks;

  			// Get all elements with class="tabcontent" and hide them
  			tabcontent = document.getElementsByClassName("tabcontent");
  				for (i = 0; i < tabcontent.length; i++) {
  			  		tabcontent[i].style.display = "none";
  				}

  			// Get all elements with class="tablinks" and remove the class "active"
  			tablinks = document.getElementsByClassName("tablinks");
  				for (i = 0; i < tablinks.length; i++) {
  			 		tablinks[i].className = tablinks[i].className.replace(" active", "");
  				}

  			// Show the current tab, and add an "active" class to the link that opened the tab
  			document.getElementById(cityName).style.display = "block";
  			evt.currentTarget.className += " active";
		}

		function openDrop(evt, cityName) {
  			// Declare all variables
  			var i, tabcontent, tablinks;

  			// Get all elements with class="tabcontent" and hide them
  			tabdrop = document.getElementsByClassName("tabdrop");
  				for (i = 0; i < tabdrop.length; i++) {
  			  		tabdrop[i].style.display = "none";
  				}

  			// Show the current tab, and add an "active" class to the link that opened the tab
  			document.getElementById(cityName).style.display = "block";
		}
	</script>

  <!--Decline form Javascript-->
  <script>
    function bookingForm(bookingid){
      document.getElementById("bookingForm").style.display = "block";
      document.getElementById("bookingID").value = bookingid;
    }

    function parkingForm(parkingid){
      document.getElementById("parkingForm").style.display = "block";
      document.getElementById("parkingID").value = parkingid;
    }

    function fdrForm(fdrid){
      document.getElementById("fdrForm").style.display = "block";
      document.getElementById("fdrID").value = fdrid;
    }

    function paymentForm(payid){
      document.getElementById("paymentForm").style.display = "block";
      document.getElementById("paymentID").value = payid;
    }

    function formClose(formid){
      document.getElementById(formid).style.display = "none";
    }
  </script>

  <!--Delete Record-->
  <script>
    function deleteFinancial(fsid){
      if(confirm("Confirm deleting Financial Statement: " + fsid + " ?")){
        window.open("delete-financial.php?ID="+ fsid, '_blank');
        window.location.href = "admin-panel.php";
      }
    }
  </script>
</head>

<body>
  <header></header>
	<div class="wrapper">
      <!--Decline Forms-->
      <!--Booking Decline Form-->
      <form action="admin-panel.php" method="post" id="bookingForm" class="decline-form">
        <span onclick="formClose('bookingForm')">&times;</span>
        <input type="hidden" name="bookingId" value="" id="bookingID">
        <textarea name="bookingReason" form="bookingForm" placeholder="Insert your decline reason here." required></textarea>
        <br>
        <input type="submit" name="bookingDecline" value="Decline">
      </form>

      <!--Parking Slot Decline Form-->
      <form action="admin-panel.php" method="post" id="parkingForm" class="decline-form">
        <span onclick="formClose('parkingForm')">&times;</span>
        <input type="hidden" name="parkingId" value="" id="parkingID">
        <textarea name="parkingReason" form="parkingForm" placeholder="Insert your decline reason here." required></textarea>
        <br>
        <input type="submit" name="parkingDecline" value="Decline">
      </form>

      <!--Feedback Resident Decline Form-->
      <form action="admin-panel.php" method="post" id="fdrForm" class="decline-form">
        <span onclick="formClose('fdrForm')">&times;</span>
        <input type="hidden" name="fdrId" value="" id="fdrID">
        <textarea name="fdrReason" form="fdrForm" placeholder="Insert your decline reason here." required></textarea>
        <br>
        <input type="submit" name="fdrDecline" value="Decline">
      </form>

      <!--Payment Decline Form-->
      <form action="admin-panel.php" method="post" id="paymentForm" class="decline-form">
        <span onclick="formClose('paymentForm')">&times;</span>
        <input type="hidden" name="paymentId" value="" id="paymentID">
        <textarea name="paymentReason" form="paymentForm" placeholder="Insert your decline reason here." required></textarea>
        <br>
        <input type="submit" name="paymentDecline" value="Decline">
      </form>

			<!--Tab Control-->
			<div class="tab">
				<button class="tabtitle" onclick="openDrop(event, 'general')">General</button>
				<div class="tabdrop" id="general">
  					<button class="tablinks" onclick="openCity(event, 'user')">&emsp;User</button>
  					<button class="tablinks" onclick="openCity(event, 'unit')">&emsp;Unit</button>
  					<button class="tablinks" onclick="openCity(event, 'tenant')">&emsp;Tenant</button>
  					<button class="tablinks" onclick="openCity(event, 'parking')">&emsp;Parking Slot</button>
  				</div>

  				<button class="tabtitle" onclick="openDrop(event, 'services')">Services</button>
  				<div class="tabdrop" id="services">
  					<button class="tablinks" onclick="openCity(event, 'booking')">&emsp;Booking</button>
  					<button class="tablinks" onclick="openCity(event, 'visitor')">&emsp;Visitor</button>
  					<button class="tablinks" onclick="openCity(event, 'package')">&emsp;Package</button>
  					<button class="tablinks" onclick="openCity(event, 'parkingReq')">&emsp;Parking Slot Request</button>
  				</div>

  				<button class="tabtitle" onclick="openDrop(event, 'financial')">Financial</button>
  				<div class="tabdrop" id="financial">
  					<button class="tablinks" onclick="openCity(event, 'f-statement')">&emsp;Financial Statement</button>
  					<button class="tablinks" onclick="openCity(event, 'payment')">&emsp;Payment</button>
  				</div>

  				<button class="tabtitle" onclick="openDrop(event, 'feedback')">Feedback</button>
  				<div class="tabdrop" id="feedback">
  					<button class="tablinks" onclick="openCity(event, 'management')">&emsp;Management</button>
  					<button class="tablinks" onclick="openCity(event, 'resident')">&emsp;Resident</button>
  				</div>

          <a href="dashboard.php"><button class="tabtitle tabback"><< Dashboard</button></a>
			</div>
			<!--Tab Content-->
			<div id="user" class="tabcontent">
  			<h3>User</h3>
        <table>
          <tr>
            <th style="width: 5%;">ID</th>
            <th style="width: 10%;">First Name</th>
            <th style="width: 10%;">Last Name</th>
            <th style="width: 15%;">Email</th>
            <th style="width: 10%;">Password</th>
            <th style="width: 10%;">Contact</th>
            <th style="width: 10%;">Role</th>
            <th style="width: 5%;">Unit Own</th>
            <th style="width: 10%;">Registered Date</th>
            <th style="width: 10%;">Account Status</th>
            <th style="width: 5%;">Edit</th>
          </tr>
          <?php
          $userQuery = "select *, user.ID as UserID, count(unit.User_ID) as Unit_own from user left join unit on user.ID = unit.User_ID group by user.ID;";
          if(!$runUser = mysqli_query($con, $userQuery)){
            echo "Error : ".mysqli_error($con);
          } else {
            while($userRow = mysqli_fetch_assoc($runUser)){
              echo "<tr><td>";
              echo $userRow["UserID"];
              echo "</td><td>";
              echo $userRow["First_name"];
              echo "</td><td>";
              echo $userRow["Last_name"];
              echo "</td><td>";
              echo $userRow["Email"];
              echo "</td><td style='width: 10%;'>";
              echo $userRow["Password"];
              echo "</td><td>";
              echo $userRow["Contact"];
              echo "</td><td>";
              echo $userRow["Role"];
              echo "</td><td>";
              echo $userRow["Unit_own"];
              echo "</td><td>";
              echo $userRow["Registered_date"];
              echo "</td><td>";
              echo $userRow["Account_status"];
              echo "</td><td>";
              echo "<a target='_blank' href='edit-profile.php?ID=";
              echo $userRow["UserID"];
              echo "'><button>Edit</button</a></td></tr>";
            }
          }
          ?>
        </table>
			</div>

			<div id="unit" class="tabcontent">
  			<h3>Unit</h3>
        <table>
          <tr>
            <th>ID</th>
            <th>Type</th>
            <th>Owner</th>
            <th>Owner Name</th>
            <th>Owner's Contact</th>
            <th>Carpark Own</th>
            <th>Edit</th>
          </tr>
          <?php
          $unitQuery = "select *, unit.ID as UnitID, count(parking_slot.ID) as Carpark, unit.Type as UnitType from unit left join user on user.ID = unit.User_ID left join parking_slot on unit.ID = parking_slot.Unit_Id group by unit.ID;";
          if(!$runUnit = mysqli_query($con, $unitQuery)){
            echo "Error : ".mysqli_error($con);
          } else {
            while($unitRow = mysqli_fetch_assoc($runUnit)){
              echo "<tr><td>";
              echo $unitRow["UnitID"];
              echo "</td><td>";
              echo $unitRow["UnitType"];
              echo "</td><td>";
              echo $unitRow["User_ID"];
              echo "</td><td>";
              echo $unitRow["First_name"]. " ". $unitRow["Last_name"];
              echo "</td><td>";
              echo $unitRow["Contact"];
              echo "</td><td>";
              echo $unitRow["Carpark"];
              echo "</td><td>";
              echo "<a target='_blank' href='edit-unit.php?ID=";
              echo $unitRow["UnitID"];
              echo "'><button>Edit</button></a></td></tr>";
            }
          }
          ?>
        </table>
			</div>

			<div id="tenant" class="tabcontent">
  			<h3>Tenant</h3>
        <table>
          <tr>
            <th>ID</th>
            <th>Unit ID</th>
            <th>User ID</th>
            <th>Tenant's Name</th>
            <th>Tenant's Contact</th>
          </tr>
          <?php
          $tenantQuery = "select *, tenants.ID as TenantID from tenants left join user on tenants.User_ID = User.ID where user.Account_status = 'Active';";
          if(!$runTenant = mysqli_query($con, $tenantQuery)){
            echo "Error : ".mysqli_error($con);
          } else {
            while($tenantRow = mysqli_fetch_assoc($runTenant)){
              echo "<tr><td>";
              echo $tenantRow["TenantID"];
              echo "</td><td>";
              echo $tenantRow["Unit_ID"];
              echo "</td><td>";
              echo $tenantRow["User_ID"];
              echo "</td><td>";
              echo $tenantRow["First_name"]. " ". $tenantRow["Last_name"];
              echo "</td><td>";
              echo $tenantRow["Contact"];
              echo "</td></tr>";
            }
          }
          ?>
        </table>
			</div>

      <div id="parking" class="tabcontent">
        <h3>Parking Slot</h3>
        <table>
          <tr>
            <th>ID</th>
            <th>Type</th>
            <th>Unit ID</th>
            <th>Registered Date</th>
            <th>Edit</th>
          </tr>
          <?php
          $parkingQuery = "select * from parking_slot;";
          if(!$runParking = mysqli_query($con, $parkingQuery)){
            echo "Error : ".mysqli_error($con);
          } else {
            while($parkingRow = mysqli_fetch_assoc($runParking)){
              echo "<tr><td>";
              echo $parkingRow["ID"];
              echo "</td><td>";
              echo $parkingRow["Type"];
              echo "</td><td>";
              echo $parkingRow["Unit_ID"];
              echo "</td><td>";
              echo $parkingRow["Registered_date"];
              echo "</td><td>";
              echo "<a target='_blank' href='edit-parking.php?ID=";
              echo $parkingRow["ID"];
              echo "'><button>Edit</button></a></td></tr>";
            }
          }
          ?>
        </table>
      </div>

      <div id="booking" class="tabcontent">
        <h3>Booking</h3>
        <table>
          <tr>
            <th>ID</th>
            <th>Facility Type</th>
            <th>Facility Name</th>
            <th>Date</th>
            <th>Time</th>
            <th>Remarks</th>
            <th>Timestamp</th>
            <th>Unit ID</th>
            <th>Status</th>
            <th>Action</th>    
          </tr>
          <?php
          $bookingQuery = "select *, booking.ID as BookingID from booking left join facility on booking.Facility_ID = Facility.ID order by booking.Status desc, booking.ID desc;";
          if(!$runBooking = mysqli_query($con, $bookingQuery)){
            echo "Error : ".mysqli_error($con);
          } else {
            while($bookingRow = mysqli_fetch_assoc($runBooking)){
              echo "<tr><td>";
              echo $bookingRow["BookingID"];
              echo "</td><td>";
              echo $bookingRow["Type"];
              echo "</td><td>";
              echo $bookingRow["Name"];
              echo "</td><td>";
              echo $bookingRow["Date"];
              echo "</td><td>";
              echo $bookingRow["Time"];
              echo "</td><td>";
              echo $bookingRow["Remarks"];
              echo "</td><td>";
              echo $bookingRow["Timestamp"];
              echo "</td><td>";
              echo $bookingRow["Unit_ID"];
              echo "</td><td>";
              echo $bookingRow["Status"];
              echo "</td>";
              if($bookingRow["Status"] == "Pending"){
                echo "<td class='center'>";
                echo "<form method='post' action='admin-panel.php'>";
                echo "<input type='submit' name='bookingApprove' style=\"background-image:url('Resources/tick.png');\" class='status-button' value='".$bookingRow["BookingID"]."'></form>";
                echo "<button style=\"background-image:url('Resources/cross.png');\" class='status-button' onclick=\"bookingForm('".$bookingRow["BookingID"]."')\"></button>";
              } else {
                echo "<td>Reviewed";
              }
              echo "</td></tr>";
            }
          }
          ?>
        </table>
      </div>

      <div id="visitor" class="tabcontent">
        <h3>Visitor</h3>
        <table>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Vehicle</th>
            <th>Visit Purpose</th>
            <th>Resident Unit</th>
            <th>Resident Name</th>
            <th>Resident's Contact</th>
            <th>Date</th>
            <th>Status</th>
          </tr>
          <?php
          $visitorQuery = "select *, visitor.ID as VisitorID from visitor left join user on visitor.User_ID = user.ID order by visitor.Status asc, visitor.ID desc;";
          if(!$runVisitor = mysqli_query($con, $visitorQuery)){
            echo "Error : ".mysqli_error($con);
          } else {
            while($visitorRow = mysqli_fetch_assoc($runVisitor)){
              echo "<tr><td>";
              echo $visitorRow["VisitorID"];
              echo "</td><td>";
              echo $visitorRow["Name"];
              echo "</td><td>";
              echo $visitorRow["Types"]." - ".$visitorRow["Vehicle_No"];
              echo "</td><td>";
              echo $visitorRow["Visit_Purpose"];
              echo "</td><td>";
              echo $visitorRow["Unit_ID"];
              echo "</td><td>";
              echo $visitorRow["First_name"]." ".$visitorRow["Last_name"];
              echo "</td><td>";
              echo $visitorRow["Contact"];
              echo "</td><td>";
              echo $visitorRow["Date"];
              echo "</td><td>";
              echo $visitorRow["Status"];
              echo "</td></tr>";
            }
          }
          ?>
        </table>
      </div>

      <div id="package" class="tabcontent">
        <h3>Package</h3>
        <table>
          <tr>
            <th>ID</th>
            <th>Receiver's Name</th>
            <th>Remarks</th>
            <th>User ID</th>
            <th>Registor's Name</th>
            <th>Registor's Contact</th>
            <th>Unit ID</th>
            <th>Status</th>
            <th>Action</th>   
          </tr>
          <?php
          $packageQuery = "select *,package_receive.ID as PackageID from package_receive left join user on package_receive.User_ID = user.ID order by package_receive.Status asc,  package_receive.ID desc;";
          if(!$runPackage = mysqli_query($con, $packageQuery)){
            echo "Error : ".mysqli_error($con);
          } else {
            while($packageRow = mysqli_fetch_assoc($runPackage)){
              echo "<tr><td>";
              echo $packageRow["PackageID"];
              echo "</td><td>";
              echo $packageRow["Receiver_name"];
              echo "</td><td>";
              echo $packageRow["Remarks"];
              echo "</td><td>";
              echo $packageRow["User_ID"];
              echo "</td><td>";
              echo $packageRow["First_name"]." ".$packageRow["Last_name"];
              echo "</td><td>";
              echo $packageRow["Contact"];
              echo "</td><td>";
              echo $packageRow["Unit_ID"];
              echo "</td><td>";
              echo $packageRow["Status"];
              echo "</td>";
              if($packageRow["Status"] == "Pending"){
                echo "<td class='center'>";
                echo "<form method='post' action='admin-panel.php'>";
                echo "<input type='submit' name='packageReceive' style=\"background-image:url('Resources/tick.png');\" class='status-button' value='".$packageRow["PackageID"]."'></form>";
              } else {
                echo "<td>Reviewed";
              }
              echo "</td></tr>";
            }
          }
          ?>
        </table>
      </div>

      <div id="parkingReq" class="tabcontent">
        <h3>Parking Slot Request</h3>
        <table>
          <tr>
            <th>ID</th>
            <th>Type</th>
            <th>Unit ID</th>
            <th>Carpark Own</th>
            <th>Status</th>
            <th>Action</th>    
          </tr>
          <?php
          $parkingReqQuery = "select *, parking_slot_request.ID as ReqID, parking_slot_request.Unit_ID as ReqUnit, parking_slot_request.Type as ReqType, count(parking_slot.ID) as Carpark FROM parking_slot_request left join parking_slot on parking_slot_request.Unit_ID = parking_slot.Unit_ID group by parking_slot_request.Unit_ID order by parking_slot_request.ID desc, Status desc;";
          if(!$runParkingReq = mysqli_query($con, $parkingReqQuery)){
            echo "Error : ".mysqli_error($con);
          } else {
            while($parkingReqRow = mysqli_fetch_assoc($runParkingReq)){
              echo "<tr><td>";
              echo $parkingReqRow["ReqID"];
              echo "</td><td>";
              echo $parkingReqRow["ReqType"];
              echo "</td><td>";
              echo $parkingReqRow["ReqUnit"];
              echo "</td><td>";
              echo $parkingReqRow["Carpark"];
              echo "</td><td>";
              echo $parkingReqRow["Status"];
              echo "</td>";
              if($parkingReqRow["Status"] == "Pending"){
                echo "<td class='center'>";
                echo "<a href='assign-parking.php?ID=";
                echo $parkingReqRow["ReqID"]."&type=".$parkingReqRow["ReqType"]."&unit=".$parkingReqRow["ReqUnit"]."'>";
                echo "<button style=\"background-image:url('Resources/tick.png');\" class='status-button'></button></a>";
                echo "<button style=\"background-image:url('Resources/cross.png');\" class='status-button' onclick=\"parkingForm('".$parkingReqRow["ReqID"]."')\"></button>";
              } else {
                echo "<td>Reviewed";
              }
              echo "</td></tr>";
            }
          }
          ?>
        </table>
      </div>

      <div id="f-statement" class="tabcontent">
        <h3>Financial</h3>
        <a href="add-financial.php"><button id="fs">Add Financial Statement</button></a>
        <table>
          <tr>
            <th>ID</th>
            <th>Type</th>
            <th>Amount</th>
            <th>Due</th>
            <th>Unit_ID</th>
            <th>Status</th>
            <th>Edit</th>
            <th>Delete</th>
          </tr>
          <?php
          $fsQuery = "select *, financial_statement.ID as FsID from financial_statement left join financial_type on financial_statement.Financial_type = financial_type.ID order by financial_statement.ID desc;";
          if(!$runFs = mysqli_query($con, $fsQuery)){
            echo "Error : ".mysqli_error($con);
          } else {
            while($fsRow = mysqli_fetch_assoc($runFs)){
              echo "<tr><td>";
              echo $fsRow["FsID"];
              echo "</td><td>";
              echo $fsRow["Type"];
              echo "</td><td>";
              echo $fsRow["Amount"];
              echo "</td><td>";
              echo $fsRow["Due"];
              echo "</td><td>";
              echo $fsRow["Unit_ID"];
              echo "</td><td>";
              echo $fsRow["Status"];
              echo "</td><td>";
              echo "<a target='_blank' href='edit-financial.php?ID=".$fsRow["FsID"]."'><button>Edit</button></a>";
              echo "</td><td>";
              echo "<button onclick=\"deleteFinancial('".$fsRow["FsID"]."')\">Delete</button>";
              echo "</td></tr>";
            }
          }
          ?>
        </table>
      </div>

      <div id="payment" class="tabcontent">
        <h3>Payment</h3>
        <table>
          <tr>
            <th>ID</th>
            <th>Type</th>
            <th>Amount</th>
            <th>Method</th>
            <th>View</th>
            <th>Financial ID</th>
            <th>Payer's Unit</th>
            <th>Payer's ID</th>
            <th>Timestamp</th>
            <th>Status</th>
            <th>Action</th>    
          </tr>
          <?php
          $payQuery = "select *, payment.ID as paymentID, payment.Status as paymentStatus, financial_type.Type as fType, payment_type.Type as pType from payment left join financial_statement on payment.Financial_ID = financial_statement.ID left join financial_type on financial_statement.Financial_type = financial_type.ID left join payment_type on payment.Payment_type = payment_type.ID order by payment.Status desc, payment.ID desc;";
          if(!$runPay = mysqli_query($con, $payQuery)){
            echo "Error : ".mysqli_error($con);
          } else {
            while($payRow = mysqli_fetch_assoc($runPay)){
              echo "<tr><td>";
              echo $payRow["paymentID"];
              echo "</td><td>";
              echo $payRow["fType"];
              echo "</td><td>";
              echo $payRow["Amount"];
              echo "</td><td>";
              echo $payRow["pType"];
              echo "</td><td>";
              if($payRow["pType"] == "Online Banking"){
                echo "<a href='".$payRow["Attachment"]."' target='_blank'><button>View</button></a>";
              } else {
                echo $payRow["Attachment"];
              }
              echo "</td><td>";
              echo $payRow["Financial_ID"];
              echo "</td><td>";
              echo $payRow["Unit_ID"];
              echo "</td><td>";
              echo $payRow["User_ID"];
              echo "</td><td>";
              echo $payRow["Timestamp"];
              echo "</td><td>";
              echo $payRow["paymentStatus"];
              echo "</td>";
              if($payRow["paymentStatus"] == "Pending"){
                echo "<td class='center'>";
                echo "<form method='post' action='admin-panel.php'>";
                echo "<input type='hidden' name='payFs' value='".$payRow["Financial_ID"]."'>";
                echo "<input type='submit' name='paymentApprove' style=\"background-image:url('Resources/tick.png');\" class='status-button' value='".$payRow["paymentID"]."'></form>";
                echo "<button style=\"background-image:url('Resources/cross.png');\" class='status-button' onclick=\"paymentForm('".$payRow["paymentID"]."')\"></button>";
              } else {
                echo "<td>Reviewed";
              }
              echo "</td></tr>";
            }
          }
          ?>
        </table>
      </div>

      <div id="resident" class="tabcontent">
        <h3>Resident</h3>
        <table>
          <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Subject</th>
            <th>Content</th>
            <th>Sender Unit</th>
            <th>Sender ID</th>
            <th>Receiver Unit</th>
            <th>Status</th>
            <th>Action</th>    
          </tr>
          <?php
          $fdrQuery = "select * from feedback_resident order by Status desc, ID desc;";
          if(!$runFdr = mysqli_query($con, $fdrQuery)){
            echo "Error : ".mysqli_error($con);
          } else {
            while($fdrRow = mysqli_fetch_assoc($runFdr)){
              echo "<tr><td>";
              echo $fdrRow["ID"];
              echo "</td><td>";
              echo $fdrRow["Email"];
              echo "</td><td>";
              echo $fdrRow["Subject"];
              echo "</td><td>";
              echo $fdrRow["Content"];
              echo "</td><td>";
              echo $fdrRow["Unit_ID"];
              echo "</td><td>";
              echo $fdrRow["Sender_ID"];
              echo "</td><td>";
              echo $fdrRow["Receiver_unit"];
              echo "</td><td>";
              echo $fdrRow["Status"];
              echo "</td>";
              if($fdrRow["Status"] == "Pending"){
                echo "<td class='center'>";
                echo '<button class="status-button" style=\'background-image:url("Resources/tick.png");\' onclick="window.location.href=\'phpmailer-fdr.php?Email='.$fdrRow['Email'].'&Subject='.$fdrRow['Subject'].'&Sender='.$fdrRow['Unit_ID'].'&ID='.$fdrRow['ID'].'&Receiver='.$fdrRow['Receiver_unit'].'\'"></button>';
                echo "<button style=\"background-image:url('Resources/cross.png');\" class='status-button' onclick=\"fdrForm('".$fdrRow["ID"]."')\"></button>";
              } else {
                echo "<td>Reviewed";
              }
              echo "</td></tr>";
            }
          }
          ?>
        </table>
      </div>

      <div id="management" class="tabcontent">
        <h3>Management</h3>
        <table>
          <tr>
            <th>ID</th>
            <th>Subject</th>
            <th>Email</th>
            <th>Content</th>
            <th>Unit_ID</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
          <?php
          $fdmQuery = "select * from feedback_management order by ID desc;";
          if(!$runFdm = mysqli_query($con, $fdmQuery)){
            echo "Error : ".mysqli_error($con);
          } else {
            while($fdmRow = mysqli_fetch_assoc($runFdm)){
              echo "<tr><td>";
              echo $fdmRow["ID"];
              echo "</td><td>";
              echo $fdmRow["Subject"];
              echo "</td><td>";
              echo $fdmRow["Email"];
              echo "</td><td>";
              echo $fdmRow["Content"];
              echo "</td><td>";
              echo $fdmRow["Unit_ID"];
              echo "</td><td>";
              echo $fdmRow["Status"];
              echo "</td>";
              if($fdmRow["Status"] == "Pending") {
                echo "<td class='center'>";
                echo "<form method='post' action='admin-panel.php'>";
                echo "<input type='submit' name='fdmReview' style=\"background-image:url('Resources/tick.png');\" class='status-button' value='".$fdmRow["ID"]."'></form>";
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
//Booking Approval & Decline
if(isset($_POST["bookingApprove"])){
  $approveBookingId = $_POST["bookingApprove"];
  $approveBookingSql = "update booking set Status = 'Approved' where ID = '$approveBookingId';";
  if(!$runApproveBooking = mysqli_query($con, $approveBookingSql)){
    echo "<script>alert('".mysqli_error($con)."');</script>";
  } else {
    echo "<script>alert('Booking Approved!');</script>";
    echo "<script>window.location.href='admin-panel.php';</script>";
  }
  unset($_POST["bookingApprove"]);
}

if(isset($_POST["bookingDecline"])){
  $bookingReason = "Declined - ".$_POST["bookingReason"];
  $bookingId = $_POST["bookingId"];
  $declineBookingSql = "update booking set Status = '$bookingReason' where ID = '$bookingId';";
  if(!$runDeclineBooking = mysqli_query($con, $declineBookingSql)){
    echo "<script>alert('".mysqli_error($con)."');</script>";
  } else {
    echo "<script>alert('Booking Declined!');</script>";
    echo "<script>window.location.href='admin-panel.php';</script>";
    //header("Refresh:0");
  }
  unset($_POST["bookingDecline"]);
}

//Parking Slot Request Decline
if(isset($_POST["parkingDecline"])){
  $parkingReason = "Declined - ".$_POST["parkingReason"];
  $parkingId = $_POST["parkingId"];
  $declineParkingSql = "update parking_slot_request set Status = '$parkingReason' where ID = '$parkingId';";
  if(!$runDeclineParking = mysqli_query($con, $declineParkingSql)){
    echo "<script>alert('".mysqli_error($con)."');</script>";
  } else {
    echo "<script>alert('Parking Slot Request Declined!');</script>";
    echo "<script>window.location.href='admin-panel.php';</script>";
    //header("Refresh:0");
  }
  unset($_POST["parkingDecline"]);
}

//Package Received
if(isset($_POST["packageReceive"])){
  $packageReceiveId = $_POST["packageReceive"];
  $packageReceiveSql = "update package_receive set Status = 'Received' where ID = '$packageReceiveId';";
  if(!$runPackageReceive = mysqli_query($con, $packageReceiveSql)){
    echo "<script>alert('".mysqli_error($con)."');</script>";
  } else {
    echo "<script>alert('Package Status Updated!');</script>";
    echo "<script>window.location.href='admin-panel.php';</script>";
  }
  unset($_POST["packageReceive"]);
}

//Payment Approve
if(isset($_POST["paymentApprove"])){
  $approvePaymentId = $_POST["paymentApprove"];
  $approvePaymentFs = $_POST["payFs"];

  $approvePaymentSql = "update payment set Status = 'Approved! Receipt can be claimed @ Level 7 Management Office.' where ID = '$approvePaymentId';";
  $approveFsSql = "update financial_statement set Status = 'Paid' where ID ='$approvePaymentFs'";

  $booPayment1 = false;
  $booPayment2 = false;

  if(!$runApprovePayment = mysqli_query($con, $approvePaymentSql)){
    echo "<script>alert('".mysqli_error($con)."');</script>";
  } else {
    $booPayment1 = true;
  }

    if(!$runApproveFs = mysqli_query($con, $approveFsSql)){
    echo "<script>alert('".mysqli_error($con)."');</script>";
  } else {
    $booPayment2 = true;
  }

  if($booPayment1 == true && $booPayment2 == true){
    echo "<script>alert('Payment Approved!');</script>";
    echo "<script>window.location.href='admin-panel.php';</script>";
  }

  unset($_POST["paymentApprove"]);
}

//Payment Decline
if(isset($_POST["paymentDecline"])){
  $paymentReason = "Declined - ".$_POST["paymentReason"];
  $paymentId = $_POST["paymentId"];
  $declinePaymentSql = "update payment set Status = '$paymentReason' where ID = '$paymentId';";
  if(!$runDeclinePayment = mysqli_query($con, $declinePaymentSql)){
    echo "<script>alert('".mysqli_error($con)."');</script>";
  } else {
    echo "<script>alert('Payment Declined!');</script>";
    echo "<script>window.location.href='admin-panel.php';</script>";
    //header("Refresh:0");
  }
  unset($_POST["paymentDecline"]);
}

//Feedback Resident Decline
if(isset($_POST["fdrDecline"])){
  $fdrReason = "Declined - ".$_POST["fdrReason"];
  $fdrId = $_POST["fdrId"];
  $declinePaymentSql = "update feedback_resident set Status = '$fdrReason' where ID = '$fdrId';";
    if(!$runDeclinePayment = mysqli_query($con, $declinePaymentSql)){
      echo "<script>alert('".mysqli_error($con)."');</script>";
    } else {
      echo "<script>alert('Resident Feedback Declined!');</script>";
      echo "<script>window.location.href='admin-panel.php';</script>";
      //header("Refresh:0");
    }
    unset($_POST["paymentDecline"]);
}

//Feedback Management Reviewed
if(isset($_POST["fdmReview"])){
  $fdmId = $_POST["fdmReview"];
  $fdmReviewSql = "update feedback_management set Status = 'Reviewed' where ID = '$fdmId';";
    if(!$runFdmReview = mysqli_query($con, $fdmReviewSql)){
      echo "<script>alert('".mysqli_error($con)."');</script>";
    } else {
      echo "<script>alert('Management Feedback Reviewed!');</script>";
      echo "<script>window.location.href='admin-panel.php';</script>";
      //header("Refresh:0");
    }
    unset($_POST["fdmReview"]);
}
?>

<?php
$today = date("Y-m-d");
$autoSql = "update visitor set Status = 'Removed' where Status = 'Pending' and Date < '$today'";
mysqli_query($con, $autoSql);
?>