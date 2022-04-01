<?php
include("connection.php");
include("login-session.php");
include("retrieve.php");
date_default_timezone_set("Asia/Kuala_Lumpur");

?>
<!DOCTYPE html>
<html>
<head>
	<title>UPTOWN | Dashboard</title>
	<link rel="stylesheet" href="css/default.css">
	<link rel="stylesheet" href="css/dashboard.css">

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
				<h1>Dashboard</h1>
			<?php

			//For admin only
			if($session_role == "Admin"){
				echo "<div class='dashboard content'>";

				//Newsletter
				echo "<a href='newsletter.php'><div class='dashboard-item'>Newsletter<i class='far fa-newspaper fa-pull-left fa-9x'></i></div></a>";

				//Admin Panel
				echo "<a href='admin-panel.php'><div class='dashboard-item'>Admin Panel<i class='fas fa-tools fa-pull-left fa-9x'></i></div></a>";

				//Create owner & security account
				echo "<a href='create-owner.php'><div class='dashboard-item'>Create Owner Account<i class='fas fa-user-plus fa-pull-left fa-9x'></i></div></a>";
				echo "<a href='create-security.php'><div class='dashboard-item'>Create Security Account<i class='fas fa-user-plus fa-pull-left fa-9x'></i></div></a>";

				//Create admin account
				echo "<a href='create-admin.php'><div class='dashboard-item'>Create Admin Account<i class='fas fa-user-plus fa-pull-left fa-9x'></i></div></a>";

				//Make payment
				echo "<a href='admin-payment.php'><div class='dashboard-item'>Make Payment<i class='fas fa-money-bill-alt fa-pull-left fa-9x'></i></div></a>";

				echo "</div>";

			//For security only
			} elseif($session_role == "Security") {
				echo "<div class='dashboard content'>";

				//Newsletter
				echo "<a href='newsletter.php'><div class='dashboard-item'>Newsletter<i class='far fa-newspaper fa-pull-left fa-9x'></i></div></a>";

				//Visitor List
				echo "<a href='visitor-list.php'><div class='dashboard-item'>Visitor List<i class='fas fa-user-check fa-pull-left fa-9x'></i></div></a>";

				echo "</div>";

			//For owner only
			} elseif($session_role == "Owner") {

				
					$unitQuery = "Select * from unit where User_ID = '$session_id';";

					if(!$runUnit = mysqli_query($con, $unitQuery)) {
						die("Error : ".mysqli_error($con));
					} else {

						echo "<div id='select-unit' class='select-unit'>";
						echo "<h3>Please select a unit to proceed</h3>";
						echo "<form method='post' action='dashboard.php'>";
						while($unitRow = mysqli_fetch_assoc($runUnit)) {
							echo "<input name='unit' type='submit' class='unit' id='";
							echo $unitRow["ID"];
							echo "' value='";
							echo $unitRow["ID"];
							echo "'>";
						}
						echo "</form></div>";					
					}

					//Unit session set
				if(isset($_SESSION["Unit"])){
					echo "<div class='dashboard content'>";

					//Unit
					echo "<a onclick='document.getElementById(\"select-unit\").style.display=\"block\"'><div class='dashboard-item'>Selected Unit<br>";
					echo $session_unit;
					echo "<i class='fas fa-building fa-pull-left fa-9x'></i></div></a>";

					//Newsletter
					echo "<a href='newsletter.php'><div class='dashboard-item'>Newsletter<i class='far fa-newspaper fa-pull-left fa-9x'></i></div></a>";
								
					//Financial statement
					echo "<a href='financial-statement.php'><div class='dashboard-item'>Financial Statement<i class='fas fa-coins fa-pull-left fa-9x'></i></div></a>";

					//My booking
					echo "<a href='my-booking.php'><div class='dashboard-item'>My Booking<i class='fas fa-table-tennis fa-pull-left fa-9x'></i></div></a>";

					//My visitor
					echo "<a href='my-visitor.php'><div class='dashboard-item'>My Visitor<i class='fas fa-user-friends fa-pull-left fa-9x'></i></div></a>";

					//My package
					echo "<a href='my-package-request.php'><div class='dashboard-item'>My package<i class='fas fa-box fa-pull-left fa-9x'></i></div></a>";

					echo "</div>";

					//dashboard info part
					//unit info part
					$ownerQuery = "select * from unit inner join user on unit.User_ID = user.ID where unit.ID = '$session_unit'";

					if(!$runOwner = mysqli_query($con, $ownerQuery)){
						die("Error : ".mysqli_error($con));
					} else {
						$ownerRow = mysqli_fetch_assoc($runOwner);
						$ownerName = $ownerRow["First_name"]." ".$ownerRow["Last_name"];

						//Show unit info
						echo "<div class='dashboard content'><div class='dashboard-info'>";
						echo "<h2>Unit Information</h2><hr><br>";
						echo "<span>Unit Number: ".$_SESSION["Unit"]."</span>";
						echo "<br><span>Owner Unit: ".$ownerName."</span><br><br>";

						//Financial info part
						$financialQuery = "select * from financial_statement inner join financial_type on financial_statement.Financial_type = financial_type.ID where not financial_statement.Status = 'Paid' and financial_statement.Unit_ID = '$session_unit' and financial_type.Type = 'Misc.' order by financial_statement.Due asc limit 1";

						if(!$runFinancial = mysqli_query($con, $financialQuery)){
							die("Error : ".mysqli_error($con));
						} else {
							$financialRowCount = mysqli_num_rows($runFinancial);
							echo "<b>Financial</b><br>";
							if($financialRowCount > 0) {

								$financialRow = mysqli_fetch_assoc($runFinancial);
								$dueDate = $financialRow["Due"];

								//Show up-coming paymenet
								echo "<span>Next misc. fees due date: ".$dueDate;
								echo "</span></span><br><br>";
							} else {
								echo "<span>All current dues are paid!</span><br><br>";
							}
						}

						//Parking slot own
						$parkingQuery = "select * from parking_slot where Unit_ID = '$session_unit';";	
						if(!$runParking = mysqli_query($con, $parkingQuery)){
							die("Error : ".mysqli_error($con));
						} else {
							$parkingRowCount = mysqli_num_rows($runParking);
							echo "<b>Parking Slot</b><br>";
							if($parkingRowCount > 0) {
							
								//Show up-coming paymenet
								echo "<ul>";
								while($parkingRow = mysqli_fetch_assoc($runParking)){
									echo "<li>".$parkingRow["ID"]."</li>";
								}
								echo "</ul>";
							} else {
								echo "<span>No Parking Slot own!</span><br>";
							}
						}

						echo "</div>"; //close dashboard-info (2)			
					}


					//Today's info
					$today = date("Y-m-d");
					echo "<div class='dashboard-info'><h2>Today</h2><hr><br>";

					//Today's booking
					$todayBooking = "select *, facility.ID as FacID from booking left join facility on booking.Facility_ID = facility.ID where booking.Unit_ID = '$session_unit' and booking.Status = 'Approved' and booking.Date = '$today'";
					
					if(!$runTodayBooking = mysqli_query($con, $todayBooking)) {
						die("Error : ".mysqli_error($con));
					} else {				

						$todayBookingCount = mysqli_num_rows($runTodayBooking);

						//Show Booking title
						echo "<b>Bookings</b><br>";

						if($todayBookingCount > 0) {			

							//fetch all today's booking data
							while($todayBookingRow = mysqli_fetch_assoc($runTodayBooking)) {
								echo "<span>";
								echo $todayBookingRow["Name"];
								echo " (".$todayBookingRow["FacID"].") - ";
								echo date("h:i A", strtotime($todayBookingRow["Time"]));
								echo "</span><br>";
							}

							echo "<br>";

						} else {
							echo "<span class='no-notice'>No bookings made!</span><br>";
						}					
					}

					//Today's visitors
					$todayVisitor = "select * from visitor left join user on visitor.User_ID = user.ID where visitor.Date = '$today' and visitor.Unit_ID = '$session_unit'";

					if(!$runTodayVisitor = mysqli_query($con, $todayVisitor)){
						die("Error : ".mysqli_error($con));
					} else {

						$todayVisitorCount = mysqli_num_rows($runTodayVisitor);

						//Show Visitor title
						echo "<br><b>Visitor</b><br>";

						if($todayVisitorCount > 0) {

							//fetch all today's visitor data
							while($todayVisitorRow = mysqli_fetch_assoc($runTodayVisitor)){
								echo "<span>";
								echo $todayVisitorRow["Name"];
								echo " - registered by ";
								echo $todayVisitorRow["First_name"] ." ". $todayVisitorRow["Last_name"];
								echo "</span><br>";
							}
							echo "<br>";

						} else {
							echo "<span class='no-notice'>No visitors registered</span><br>";
						}
						echo "</div>"; //close dashboard-info (2)
					}

					echo "</div>"; //close dashboard
				} else {
					echo "<script>document.getElementById('select-unit').style.display = 'block';</script>";
				}

			//For tenant only
			} else if($session_role == "Tenant" ) {

				$tenantUnitBoo = false;

				$unitQuery = "Select * from tenants where User_ID = '$session_id';";

				if(!$runUnit = mysqli_query($con, $unitQuery)) {
					die("Error : ".mysqli_error($con));
				} else {
					$unitRowCount = mysqli_num_rows($runUnit);

					if($unitRowCount == 1) {
						$unitRow = mysqli_fetch_array($runUnit);
						$_SESSION["Unit"] = $unitRow["Unit_ID"];
						$session_unit = $_SESSION["Unit"];
						$tenantUnitBoo = true;
					} else {
						echo "Error : Failed to retrieve unit";
					}
				}

				if($tenantUnitBoo == true) {

					echo "<div class='dashboard content'>";

					//Unit
					echo "<div class='dashboard-item'>";
					echo $session_unit;
					echo "<i class='fas fa-building fa-pull-left fa-9x'></i></div>";

					//Newsletter
					echo "<a href='newsletter.php'><div class='dashboard-item'>Newsletter<i class='far fa-newspaper fa-pull-left fa-9x'></i></div></a>";
								
					//Financial statement
					echo "<a href='financial-statement.php'><div class='dashboard-item'>Financial Statement<i class='fas fa-coins fa-pull-left fa-9x'></i></div></a>";

					//My booking
					echo "<a href='my-booking.php'><div class='dashboard-item'>My Booking<i class='fas fa-table-tennis fa-pull-left fa-9x'></i></div></a>";

					//My visitor
					echo "<a href='my-visitor.php'><div class='dashboard-item'>My Visitor<i class='fas fa-user-friends fa-pull-left fa-9x'></i></div></a>";

					//My package
					echo "<a href='my-package-request.php'><div class='dashboard-item'>My package<i class='fas fa-box fa-pull-left fa-9x'></i></div></a>";

					echo "</div>";

					//dashboard info part
					//unit info part
					$ownerQuery = "select * from unit inner join user on unit.User_ID = user.ID where unit.ID = '$session_unit'";

					if(!$runOwner = mysqli_query($con, $ownerQuery)){
						die("Error : ".mysqli_error($con));
					} else {
						$ownerRow = mysqli_fetch_assoc($runOwner);
						$ownerName = $ownerRow["First_name"]." ".$ownerRow["Last_name"];

						//Show unit info
						echo "<div class='dashboard content'><div class='dashboard-info'>";
						echo "<h2>Unit Information</h2><hr><br>";
						echo "<span>Unit Number: ".$_SESSION["Unit"]."</span>";
						echo "<br><span>Owner Unit: ".$ownerName."</span><br><br>";

						//Financial info part
						$financialQuery = "select * from financial_statement inner join financial_type on financial_statement.Financial_type = financial_type.ID where not financial_statement.Status = 'Paid' and financial_statement.Unit_ID = '$session_unit' and financial_type.Type = 'Misc.' order by financial_statement.Due asc limit 1";

						if(!$runFinancial = mysqli_query($con, $financialQuery)){
							die("Error : ".mysqli_error($con));
						} else {
							$financialRowCount = mysqli_num_rows($runFinancial);
							echo "<b>Financial</b><br>";
							if($financialRowCount > 0) {

								$financialRow = mysqli_fetch_assoc($runFinancial);
								$dueDate = $financialRow["Due"];

								//Show up-coming paymenet
								echo "<span>Next misc. fees due date: ".$dueDate;
								echo "</span></span><br><br>";
							} else {
								echo "<span>All current dues are paid!</span><br><br>";
							}
						}

						//Parking slot own
						$parkingQuery = "select * from parking_slot where Unit_ID = '$session_unit';";	
						if(!$runParking = mysqli_query($con, $parkingQuery)){
							die("Error : ".mysqli_error($con));
						} else {
							$parkingRowCount = mysqli_num_rows($runParking);
							echo "<b>Parking Slot</b><br>";
							if($parkingRowCount > 0) {
							
								//Show up-coming paymenet
								echo "<ul>";
								while($parkingRow = mysqli_fetch_assoc($runParking)){
									echo "<li>".$parkingRow["ID"]."</li>";
								}
								echo "</ul>";
							} else {
								echo "<span>No Parking Slot own!</span><br>";
							}
						}

						echo "</div>"; //close dashboard-info (2)			
					}


					//Today's info
					$today = date("Y-m-d");
					echo "<div class='dashboard-info'><h2>Today</h2><hr><br>";

					//Today's booking
					$todayBooking = "select *, facility.ID as FacID from booking left join facility on booking.Facility_ID = facility.ID where booking.Unit_ID = '$session_unit' and booking.Status = 'Approved' and booking.Date = '$today'";
					
					if(!$runTodayBooking = mysqli_query($con, $todayBooking)) {
						die("Error : ".mysqli_error($con));
					} else {				

						$todayBookingCount = mysqli_num_rows($runTodayBooking);

						//Show Booking title
						echo "<b>Bookings</b><br>";

						if($todayBookingCount > 0) {			

							//fetch all today's booking data
							while($todayBookingRow = mysqli_fetch_assoc($runTodayBooking)) {
								echo "<span>";
								echo $todayBookingRow["Name"];
								echo " (".$todayBookingRow["FacID"].") - ";
								echo date("h:i A", strtotime($todayBookingRow["Time"]));
								echo "</span><br>";
							}

							echo "<br>";

						} else {
							echo "<span class='no-notice'>No bookings made!</span><br>";
						}					
					}

					//Today's visitors
					$todayVisitor = "select * from visitor left join user on visitor.User_ID = user.ID where visitor.Date = '$today' and visitor.Unit_ID = '$session_unit'";

					if(!$runTodayVisitor = mysqli_query($con, $todayVisitor)){
						die("Error : ".mysqli_error($con));
					} else {

						$todayVisitorCount = mysqli_num_rows($runTodayVisitor);

						//Show Visitor title
						echo "<br><b>Visitor</b><br>";

						if($todayVisitorCount > 0) {

							//fetch all today's visitor data
							while($todayVisitorRow = mysqli_fetch_assoc($runTodayVisitor)){
								echo "<span>";
								echo $todayVisitorRow["Name"];
								echo " - registered by ";
								echo $todayVisitorRow["First_name"] ." ". $todayVisitorRow["Last_name"];
								echo "</span><br>";
							}
							echo "<br>";

						} else {
							echo "<span class='no-notice'>No visitors registered</span><br>";
						}
						echo "</div>"; //close dashboard-info (2)
					}

					echo "</div>"; //close dashboard
				}
			}	
			?>
		</article>
		<footer>
			<?php
			include("footer.php");
			?>
		</footer>
		<?php
		if(isset($_POST['unit'])){
			$_SESSION["Unit"] = $_POST["unit"];
			unset($_POST["unit"]);
			echo "<script>window.location.href='dashboard.php';</script>";
		}
		?>
	</div>
</body>
</html>