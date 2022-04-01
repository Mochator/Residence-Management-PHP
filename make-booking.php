<!DOCTYPE html>
<html>
<?php 
include("connection.php");
include("login-session.php");
include("retrieve.php");
include("unit-session.php");
include("access-owner-tenant.php");
?>



<?php
if(isset($_POST['submit']))
{
	$unitid = $_SESSION['Unit'];
	$userid = $_SESSION['ID'];
	
	//$verify = mysqli_query($con,"SELECT Unit_ID, Facility_ID, Date FROM booking WHERE Unit_ID = $unitid AND Date='$Date' AND Facility_ID='$facility_id' GROUP BY Unit_ID");
	//$rowcount1=mysqli_num_rows($verify);
	
	$Remarks = isset($_POST['Remarks']) ? $_POST['Remarks'] : '';
	
	$Date = isset($_POST['bookingDate2']) ? $_POST['bookingDate2'] : '';
	
	$facility_id = isset($_POST['table_num2']) ? $_POST['table_num2'] : '';
	
	$Time = isset($_POST['Time']) ? $_POST['Time'] : '';
		
	if ($Time == "") {
		echo '<script>alert("Please select available time!");</script>';
	}
	else {
		
	//$bookingTime = array();
		
	$Time = implode(',', $_POST['Time']);
	
	//$bookingTime = implode(',', array($_POST['bookingTime']));
	
	$con=mysqli_connect("localhost","root","","uptown");
	
	$sql="INSERT INTO booking (Unit_ID, Date, Time, Facility_ID, Remarks, Status) VALUES ('$unitid','$Date','$Time','$facility_id','$Remarks','Pending')";
	
	if (!mysqli_query($con,$sql))
	{
		die('Error: ' . mysqli_error($con));
	}
	else {
		echo '<script>alert("Sucessfully Booked!");window.location.href="make-booking.php";</script>';
	}
	mysqli_close($con);
	//header('Location:make-booking.php');
	}
	
}
?>

<head>
	<script src= http://code.jquery.com/jquery-1.7.2.min.js  ></script>
	<link rel="stylesheet" href="css/default.css">
	<!--Web Icon & Font input-->
	<script src="head-input.js"></script>
	<title>UPTOWN | Booking</title>

<style>
.button {
	background-color:#9ACD32;
}

.button:disabled,
button[disabled] {
	border:1px solid black;
	background-color: #CD5C5C;
	color: white;
}



.form{
	height: 70%;
	position: relative;
	display: block;
	text-align: center;
}

.form-part{
	display: inline-block;
	vertical-align: top;
	background: white;
	margin-left: 20px;
	margin-right: 20px;
	padding: 20px;
}

.floor-plan{
	position: relative;
	width: 700px;
	min-height: 445px;
	background-color: white;
	text-align: center;
}

.floor-plan img{
	width: 660px;
	object-fit: contain;
	position: relative;
}

.fpbutton {
	position: absolute;
	text-align: center; 
	cursor: pointer;
}

textarea{
	width: 98%;
}

</style>

<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<title>Bookings</title>
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
		<h1>Make Booking</h1>
		<div class="">
		<form id="form2" method="post">
			<div class="form container">
				<div class="form-part content floor-plan">
					<img src="Resources/bookingfp2.png" alt="floorplan">
		 			<input type="submit" class="button fpbutton" name="button1" value="A01" style="left: 128px; top: 100px; width: 35px; height: 35px;" id="table1" disabled>
					<input type="submit" class="button fpbutton" name="button2" value="A02" style="left: 306px; top: 100px; right: 0px; width: 35px; height: 35px;" id="table2" disabled>
					<input type="submit" class="button fpbutton" name="button3" value="B01" style="left: 332px; top: 315px; right: 0px; width: 35px; height: 35px;" id="table3" disabled>
			 		<input type="submit" class="button fpbutton" name="button4" value="B02" style="left: 214px; top: 315px; right: 0px; width: 35px; height: 35px;" id="table4" disabled>
			 		<input type="submit" class="button fpbutton" name="button5" value="B03" style="left: 102px; top: 315px; right: 0px; width: 35px; height: 35px;" id="table5" disabled>
			 		<input type="submit" class="button fpbutton" name="button6" value="C01" style="left: 470px; top: 292px; right: 0px; width: 35px; height: 35px;" id="table6" disabled>
		 			<input type="submit" class="button fpbutton" name="button7" value="C02" style="left: 470px; top: 183px; right: 0px; width: 35px; height: 35px;" id="table7" disabled>
		 			<input type="submit" class="button fpbutton" name="button8" value="C03" style="left: 470px; top: 65px; right: 0px; width: 35px; height: 35px;" id="table8" disabled>
     				<input type="submit" class="button fpbutton" name="button9" value="D01" style="left: 420px; top: 415px; right: 0px; width: 35px; height: 35px;" id="table9" disabled>
		 			<input type="submit" class="button fpbutton" name="button10" value="D02" style="left: 630px; top: 415px; right: 0px; width: 35px; height: 35px;" id="table10" disabled>
				</div>
		<form id="form1">
			<div class="form-part content" style="width: 300px; text-align: left;">
			 		<label for="date">Choose a date:</label>
			 		<input type="date"  style="margin-top: 3px;" name="Date" min="<?php echo date("Y-m-d"); ?>"onchange="showNumPax()"/><br>
			 		<label for="facility" id="labelf" style="display:none">Choose a facility:</label>
			 		<select class="" name="Bookings" id="numpax" style="display:none">
									<option value="" label="&nbsp;" selected hidden></option>
									<option value="table1">Party Room A</option>
									<option value="table2">Party Room B</option>
									<option value="table3">Badminton Court A</option>
									<option value="table4">Badminton Court B</option>
									<option value="table5">Badminton Court C</option>
									<option value="table6">Functional Hall A</option>
									<option value="table7">Functional Hall B</option>
									<option value="table8">Functional Hall C</option>
									<option value="table9">BBQ Room A</option>
									<option value="table10">BBQ Room B</option>
					</select><br>
<?php 
if(isset($_POST['button1']))
{
	$unitid = $_SESSION['Unit'];
	$Date = $_POST['Date'];
	$facility_id = "A01";
	$facility_name = "<b>Party Room A</b>";
	$facility_type = "Party Room";
	//echo "<div class=\"title\">Facility No:</div>";
	//echo "&nbsp";
	//echo $facility_id; 
	
	echo 'Facility No'.':'."&nbsp;&nbsp". $facility_id;
	echo"<br><br>";
	echo 'Facility Name'.':'."&nbsp;&nbsp". $facility_name;
	//echo "<div class=\"title\">Facility Type:</div>";
	//echo "&nbsp";
	//echo $facility_name;
	echo '<br><br>';
	
	
	
	$con=mysqli_connect("localhost","root","","uptown");

	//sql query
	$result = mysqli_query($con,"SELECT Date, Facility_ID, GROUP_CONCAT(Time SEPARATOR ',') FROM booking WHERE Date='$Date' AND Facility_ID='$facility_id' GROUP BY Date");
	//$verify = mysqli_query($con,"SELECT Unit_ID, Facility_ID, Date FROM booking WHERE Unit_ID = '$unitid' AND Date='$Date' AND Facility_ID='$facility_id'");
$verify = mysqli_query($con,"SELECT Unit_ID, Facility_ID, Date,Type FROM booking Inner Join facility on booking.Facility_ID = facility.ID WHERE Unit_ID = '$unitid' AND Date='$Date' AND Type ='$facility_type'");

	
	$rowcount1=mysqli_num_rows($verify);
	$rowcount=mysqli_num_rows($result);
	
	echo $facility_id .' on '. $_POST['Date'] . '<input type="hidden" name="bookingDate2" value="'. $_POST['Date'] .'"> <input type="hidden" name="table_num2" value="'. $facility_id .'"><br><br>';
	//echo '<img src="https://api.qrserver.com/v1/create-qr-code/?data=Username:'.$_SESSION['mySession'].'%0ABooking Date:'.$_POST['bookingDate'].'%0ATable No.'.$table_num.'%0ANumber Of Pax:'.$num_pax.'&amp;size=100x100" alt="" title="" />';
	
	if ($rowcount1 == 1) {
		echo '<script>alert("Exceed Limits!");window.location.href="make-booking.php";</script>';
	} elseif ($rowcount != 1) {
		
		echo "<div class=\"title\">Available Time:</div><br>";
		for ($t=9; $t<19; $t++) {
			echo '<input name="Time[]" type="radio" value="'.$t.'">'.$t.':00<br>';
	}
		echo "<br>";
		echo "<div class=\"title\">Remarks:</div>";
		//echo '<input name="Remarks" type="textarea" value="">';
		echo '<textarea rows="2" cols="30" name="Remarks"></textarea>';

	}
	else {
		while($row = mysqli_fetch_array($result))
		{
			$Time = array_map('intval', explode(',', $row["GROUP_CONCAT(Time SEPARATOR ',')"]));
				
				echo "<div class=\"title\">Available Time:</div><br>";
				for ($t=9; $t<19; $t++) {
					echo '<input name="Time[]" type="radio" value="'.$t.'"';

						if (in_array($t , $Time, true)) {
							echo 'disabled="disabled"'; 
						}
					echo $t . '>'.$t.':00<br>';
					
				}
		}
				echo "<br>";
				echo "<div class=\"title\">Remarks:</div>";
				//echo '<input name="Remarks" type="textarea" value="">';
				echo '<textarea rows="2" cols="30" name="Remarks"></textarea>';

	}
	mysqli_close($con);

echo '<br><input type="submit" class="button1" name="submit" value="Book">';
}

if(isset($_POST['button2']))
{
	$unitid = $_SESSION['Unit'];
	$Date = $_POST['Date'];
	$facility_id = "A02";
	$facility_name = "<b>Party Room B</b>";
	$facility_type = "Party Room";
	//echo "<div class=\"title\">Facility No:</div>";
	//echo "&nbsp";
	//echo $facility_id; 
	
	echo 'Facility No'.':'."&nbsp;&nbsp". $facility_id;
	echo"<br><br>";
	echo 'Facility Name'.':'."&nbsp;&nbsp". $facility_name;
	//echo "<div class=\"title\">Facility Type:</div>";
	//echo "&nbsp";
	//echo $facility_name;
	echo '<br><br>';
	
	
	
	$con=mysqli_connect("localhost","root","","uptown");

	//sql query
	$result = mysqli_query($con,"SELECT Date, Facility_ID, GROUP_CONCAT(Time SEPARATOR ',') FROM booking WHERE Date='$Date' AND Facility_ID='$facility_id' GROUP BY Date");
	//$verify = mysqli_query($con,"SELECT Unit_ID, Facility_ID, Date FROM booking WHERE Unit_ID = '$unitid' AND Date='$Date' AND Facility_ID='$facility_id'");
	$verify = mysqli_query($con,"SELECT Unit_ID, Facility_ID, Date,Type FROM booking Inner Join facility on booking.Facility_ID = facility.ID WHERE Unit_ID = '$unitid' AND Date='$Date' AND Type ='$facility_type'");

	
	$rowcount1=mysqli_num_rows($verify);
	$rowcount=mysqli_num_rows($result);
	
	echo $facility_id .' on '. $_POST['Date'] . '<input type="hidden" name="bookingDate2" value="'. $_POST['Date'] .'"> <input type="hidden" name="table_num2" value="'. $facility_id .'"><br><br>';
	//echo '<img src="https://api.qrserver.com/v1/create-qr-code/?data=Username:'.$_SESSION['mySession'].'%0ABooking Date:'.$_POST['bookingDate'].'%0ATable No.'.$table_num.'%0ANumber Of Pax:'.$num_pax.'&amp;size=100x100" alt="" title="" />';
	
	if ($rowcount1 == 1) {
		echo '<script>alert("Exceed Limits!");window.location.href="make-booking.php";</script>';
	} elseif ($rowcount != 1) {
		
		echo "<div class=\"title\">Available Time:</div><br>";
		for ($t=9; $t<19; $t++) {
			echo '<input name="Time[]" type="radio" value="'.$t.'">'.$t.':00<br>';
	}
		echo "<br>";
		echo "<div class=\"title\">Remarks:</div>";
		//echo '<input name="Remarks" type="textarea" value="">';
		echo '<textarea rows="2" cols="30" name="Remarks"></textarea>';

	}
	else {
		while($row = mysqli_fetch_array($result))
		{
			$Time = array_map('intval', explode(',', $row["GROUP_CONCAT(Time SEPARATOR ',')"]));
				
				echo "<div class=\"title\">Available Time:</div><br>";
				for ($t=9; $t<19; $t++) {
					echo '<input name="Time[]" type="radio" value="'.$t.'"';

						if (in_array($t , $Time, true)) {
							echo 'disabled="disabled"'; 
						}
					echo $t . '>'.$t.':00<br>';
					
				}
		}
				echo "<br>";
				echo "<div class=\"title\">Remarks:</div>";
				//echo '<input name="Remarks" type="textarea" value="">';
				echo '<textarea rows="2" cols="30" name="Remarks"></textarea>';

	}
	mysqli_close($con);

echo '<br><input type="submit" class="button2" name="submit" value="Book">';
}

if(isset($_POST['button3']))
{
	$unitid = $_SESSION['Unit'];
	$Date = $_POST['Date'];
	$facility_id = "B01";
	$facility_name = "<b>Badminton Court A</b>";
	$facility_type = "Badminton Court";
	//echo "<div class=\"title\">Facility No:</div>";
	//echo "&nbsp";
	//echo $facility_id; 
	
	echo 'Facility No'.':'."&nbsp;&nbsp". $facility_id;
	echo"<br><br>";
	echo 'Facility Name'.':'."&nbsp;&nbsp". $facility_name;
	//echo "<div class=\"title\">Facility Type:</div>";
	//echo "&nbsp";
	//echo $facility_name;
	echo '<br><br>';
	
	
	
	$con=mysqli_connect("localhost","root","","uptown");

	//sql query
	$result = mysqli_query($con,"SELECT Date, Facility_ID, GROUP_CONCAT(Time SEPARATOR ',') FROM booking WHERE Date='$Date' AND Facility_ID='$facility_id' GROUP BY Date");
	//$verify = mysqli_query($con,"SELECT Unit_ID, Facility_ID, Date FROM booking WHERE Unit_ID = '$unitid' AND Date='$Date' AND Facility_ID='$facility_id'");
	$verify = mysqli_query($con,"SELECT Unit_ID, Facility_ID, Date,Type FROM booking Inner Join facility on booking.Facility_ID = facility.ID WHERE Unit_ID = '$unitid' AND Date='$Date' AND Type ='$facility_type'");

	
	$rowcount1=mysqli_num_rows($verify);
	$rowcount=mysqli_num_rows($result);
	
	echo $facility_id .' on '. $_POST['Date'] . '<input type="hidden" name="bookingDate2" value="'. $_POST['Date'] .'"> <input type="hidden" name="table_num2" value="'. $facility_id .'"><br><br>';
	//echo '<img src="https://api.qrserver.com/v1/create-qr-code/?data=Username:'.$_SESSION['mySession'].'%0ABooking Date:'.$_POST['bookingDate'].'%0ATable No.'.$table_num.'%0ANumber Of Pax:'.$num_pax.'&amp;size=100x100" alt="" title="" />';
	
	if ($rowcount1 == 1) {
		echo '<script>alert("Exceed Limits!");window.location.href="make-booking.php";</script>';
	} elseif ($rowcount != 1) {
		
		echo "<div class=\"title\">Available Time:</div><br>";
		for ($t=9; $t<19; $t++) {
			echo '<input name="Time[]" type="radio" value="'.$t.'">'.$t.':00<br>';
	}
		echo "<br>";
		echo "<div class=\"title\">Remarks:</div>";
		//echo '<input name="Remarks" type="textarea" value="">';
		echo '<textarea rows="2" cols="30" name="Remarks"></textarea>';

	}
	else {
		while($row = mysqli_fetch_array($result))
		{
			$Time = array_map('intval', explode(',', $row["GROUP_CONCAT(Time SEPARATOR ',')"]));
				
				echo "<div class=\"title\">Available Time:</div><br>";
				for ($t=9; $t<19; $t++) {
					echo '<input name="Time[]" type="radio" value="'.$t.'"';

						if (in_array($t , $Time, true)) {
							echo 'disabled="disabled"'; 
						}
					echo $t . '>'.$t.':00<br>';
					
				}
		}
				echo "<br>";
				echo "<div class=\"title\">Remarks:</div>";
				//echo '<input name="Remarks" type="textarea" value="">';
				echo '<textarea rows="2" cols="30" name="Remarks"></textarea>';

	}
	mysqli_close($con);

echo '<br><input type="submit" class="button3" name="submit" value="Book">';
}

if(isset($_POST['button4']))
{
	$unitid = $_SESSION['Unit'];
	$Date = $_POST['Date'];
	$facility_id = "B02";
	$facility_name = "<b>Badminton Court B</b>";
	$facility_type = "Badminton Court";
	//echo "<div class=\"title\">Facility No:</div>";
	//echo "&nbsp";
	//echo $facility_id; 
	
	echo 'Facility No'.':'."&nbsp;&nbsp". $facility_id;
	echo"<br><br>";
	echo 'Facility Name'.':'."&nbsp;&nbsp". $facility_name;
	//echo "<div class=\"title\">Facility Type:</div>";
	//echo "&nbsp";
	//echo $facility_name;
	echo '<br><br>';
	
	
	
	$con=mysqli_connect("localhost","root","","uptown");

	//sql query
	$result = mysqli_query($con,"SELECT Date, Facility_ID, GROUP_CONCAT(Time SEPARATOR ',') FROM booking WHERE Date='$Date' AND Facility_ID='$facility_id' GROUP BY Date");
	//$verify = mysqli_query($con,"SELECT Unit_ID, Facility_ID, Date FROM booking WHERE Unit_ID = '$unitid' AND Date='$Date' AND Facility_ID='$facility_id'");
	$verify = mysqli_query($con,"SELECT Unit_ID, Facility_ID, Date,Type FROM booking Inner Join facility on booking.Facility_ID = facility.ID WHERE Unit_ID = '$unitid' AND Date='$Date' AND Type ='$facility_type'");

	
	$rowcount1=mysqli_num_rows($verify);
	$rowcount=mysqli_num_rows($result);
	
	echo $facility_id .' on '. $_POST['Date'] . '<input type="hidden" name="bookingDate2" value="'. $_POST['Date'] .'"> <input type="hidden" name="table_num2" value="'. $facility_id .'"><br><br>';
	//echo '<img src="https://api.qrserver.com/v1/create-qr-code/?data=Username:'.$_SESSION['mySession'].'%0ABooking Date:'.$_POST['bookingDate'].'%0ATable No.'.$table_num.'%0ANumber Of Pax:'.$num_pax.'&amp;size=100x100" alt="" title="" />';
	
	if ($rowcount1 == 1) {
		echo '<script>alert("Exceed Limits!");window.location.href="make-booking.php";</script>';
	} elseif ($rowcount != 1) {
		
		echo "<div class=\"title\">Available Time:</div><br>";
		for ($t=9; $t<19; $t++) {
			echo '<input name="Time[]" type="radio" value="'.$t.'">'.$t.':00<br>';
	}
		echo "<br>";
		echo "<div class=\"title\">Remarks:</div>";
		//echo '<input name="Remarks" type="textarea" value="">';
		echo '<textarea rows="2" cols="30" name="Remarks"></textarea>';

	}
	else {
		while($row = mysqli_fetch_array($result))
		{
			$Time = array_map('intval', explode(',', $row["GROUP_CONCAT(Time SEPARATOR ',')"]));
				
				echo "<div class=\"title\">Available Time:</div><br>";
				for ($t=9; $t<19; $t++) {
					echo '<input name="Time[]" type="radio" value="'.$t.'"';

						if (in_array($t , $Time, true)) {
							echo 'disabled="disabled"'; 
						}
					echo $t . '>'.$t.':00<br>';
					
				}
		}
				echo "<br>";
				echo "<div class=\"title\">Remarks:</div>";
				//echo '<input name="Remarks" type="textarea" value="">';
				echo '<textarea rows="2" cols="30" name="Remarks"></textarea>';

	}
	mysqli_close($con);

echo '<br><input type="submit" class="button4" name="submit" value="Book">';
}

if(isset($_POST['button5']))
{
	$unitid = $_SESSION['Unit'];
	$Date = $_POST['Date'];
	$facility_id = "B03";
	$facility_name = "<b>Badminton Court C</b>";
	$facility_type = "Badminton Court";
	//echo "<div class=\"title\">Facility No:</div>";
	//echo "&nbsp";
	//echo $facility_id; 
	
	echo 'Facility No'.':'."&nbsp;&nbsp". $facility_id;
	echo"<br><br>";
	echo 'Facility Name'.':'."&nbsp;&nbsp". $facility_name;
	//echo "<div class=\"title\">Facility Type:</div>";
	//echo "&nbsp";
	//echo $facility_name;
	echo '<br><br>';
	
	
	
	$con=mysqli_connect("localhost","root","","uptown");

	//sql query
	$result = mysqli_query($con,"SELECT Date, Facility_ID, GROUP_CONCAT(Time SEPARATOR ',') FROM booking WHERE Date='$Date' AND Facility_ID='$facility_id' GROUP BY Date");
	//$verify = mysqli_query($con,"SELECT Unit_ID, Facility_ID, Date FROM booking WHERE Unit_ID = '$unitid' AND Date='$Date' AND Facility_ID='$facility_id'");
	$verify = mysqli_query($con,"SELECT Unit_ID, Facility_ID, Date,Type FROM booking Inner Join facility on booking.Facility_ID = facility.ID WHERE Unit_ID = '$unitid' AND Date='$Date' AND Type ='$facility_type'");

	
	$rowcount1=mysqli_num_rows($verify);
	$rowcount=mysqli_num_rows($result);
	
	echo $facility_id .' on '. $_POST['Date'] . '<input type="hidden" name="bookingDate2" value="'. $_POST['Date'] .'"> <input type="hidden" name="table_num2" value="'. $facility_id .'"><br><br>';
	//echo '<img src="https://api.qrserver.com/v1/create-qr-code/?data=Username:'.$_SESSION['mySession'].'%0ABooking Date:'.$_POST['bookingDate'].'%0ATable No.'.$table_num.'%0ANumber Of Pax:'.$num_pax.'&amp;size=100x100" alt="" title="" />';
	
	if ($rowcount1 == 1) {
		echo '<script>alert("Exceed Limits!");window.location.href="make-booking.php";</script>';
	} elseif ($rowcount != 1) {
		
		echo "<div class=\"title\">Available Time:</div><br>";
		for ($t=9; $t<19; $t++) {
			echo '<input name="Time[]" type="radio" value="'.$t.'">'.$t.':00<br>';
	}
		echo "<br>";
		echo "<div class=\"title\">Remarks:</div>";
		//echo '<input name="Remarks" type="textarea" value="">';
		echo '<textarea rows="2" cols="30" name="Remarks"></textarea>';

	}
	else {
		while($row = mysqli_fetch_array($result))
		{
			$Time = array_map('intval', explode(',', $row["GROUP_CONCAT(Time SEPARATOR ',')"]));
				
				echo "<div class=\"title\">Available Time:</div><br>";
				for ($t=9; $t<19; $t++) {
					echo '<input name="Time[]" type="radio" value="'.$t.'"';

						if (in_array($t , $Time, true)) {
							echo 'disabled="disabled"'; 
						}
					echo $t . '>'.$t.':00<br>';
					
				}
		}
				echo "<br>";
				echo "<div class=\"title\">Remarks:</div>";
				//echo '<input name="Remarks" type="textarea" value="">';
				echo '<textarea rows="2" cols="30" name="Remarks"></textarea>';

	}
	mysqli_close($con);

echo '<br><input type="submit" class="button5" name="submit" value="Book">';
}

if(isset($_POST['button6']))
{
	$unitid = $_SESSION['Unit'];
	$Date = $_POST['Date'];
	$facility_id = "C01";
	$facility_name = "<b>Functional Hall A</b>";
	$facility_type = "Functional Hall";
	//echo "<div class=\"title\">Facility No:</div>";
	//echo "&nbsp";
	//echo $facility_id; 
	
	echo 'Facility No'.':'."&nbsp;&nbsp". $facility_id;
	echo"<br><br>";
	echo 'Facility Name'.':'."&nbsp;&nbsp". $facility_name;
	//echo "<div class=\"title\">Facility Type:</div>";
	//echo "&nbsp";
	//echo $facility_name;
	echo '<br><br>';
	
	
	
	$con=mysqli_connect("localhost","root","","uptown");

	//sql query
	$result = mysqli_query($con,"SELECT Date, Facility_ID, GROUP_CONCAT(Time SEPARATOR ',') FROM booking WHERE Date='$Date' AND Facility_ID='$facility_id' GROUP BY Date");
	//$verify = mysqli_query($con,"SELECT Unit_ID, Facility_ID, Date FROM booking WHERE Unit_ID = '$unitid' AND Date='$Date' AND Facility_ID='$facility_id'");
	$verify = mysqli_query($con,"SELECT Unit_ID, Facility_ID, Date,Type FROM booking Inner Join facility on booking.Facility_ID = facility.ID WHERE Unit_ID = '$unitid' AND Date='$Date' AND Type ='$facility_type'");

	
	$rowcount1=mysqli_num_rows($verify);
	$rowcount=mysqli_num_rows($result);
	
	echo $facility_id .' on '. $_POST['Date'] . '<input type="hidden" name="bookingDate2" value="'. $_POST['Date'] .'"> <input type="hidden" name="table_num2" value="'. $facility_id .'"><br><br>';
	//echo '<img src="https://api.qrserver.com/v1/create-qr-code/?data=Username:'.$_SESSION['mySession'].'%0ABooking Date:'.$_POST['bookingDate'].'%0ATable No.'.$table_num.'%0ANumber Of Pax:'.$num_pax.'&amp;size=100x100" alt="" title="" />';
	
	if ($rowcount1 == 1) {
		echo '<script>alert("Exceed Limits!");window.location.href="make-booking.php";</script>';
	} elseif ($rowcount != 1) {
		
		echo "<div class=\"title\">Available Time:</div><br>";
		for ($t=9; $t<19; $t++) {
			echo '<input name="Time[]" type="radio" value="'.$t.'">'.$t.':00<br>';
	}
		echo "<br>";
		echo "<div class=\"title\">Remarks:</div>";
		//echo '<input name="Remarks" type="textarea" value="">';
		echo '<textarea rows="2" cols="30" name="Remarks"></textarea>';

	}
	else {
		while($row = mysqli_fetch_array($result))
		{
			$Time = array_map('intval', explode(',', $row["GROUP_CONCAT(Time SEPARATOR ',')"]));
				
				echo "<div class=\"title\">Available Time:</div><br>";
				for ($t=9; $t<19; $t++) {
					echo '<input name="Time[]" type="radio" value="'.$t.'"';

						if (in_array($t , $Time, true)) {
							echo 'disabled="disabled"'; 
						}
					echo $t . '>'.$t.':00<br>';
					
				}
		}
				echo "<br>";
				echo "<div class=\"title\">Remarks:</div>";
				//echo '<input name="Remarks" type="textarea" value="">';
				echo '<textarea rows="2" cols="30" name="Remarks"></textarea>';

	}
	mysqli_close($con);

echo '<br><input type="submit" class="button6" name="submit" value="Book">';
}

if(isset($_POST['button7']))
{
	$unitid = $_SESSION['Unit'];
	$Date = $_POST['Date'];
	$facility_id = "C02";
	$facility_name = "<b>Functional Hall B</b>";
	$facility_type = "Functional Hall";
	//echo "<div class=\"title\">Facility No:</div>";
	//echo "&nbsp";
	//echo $facility_id; 
	
	echo 'Facility No'.':'."&nbsp;&nbsp". $facility_id;
	echo"<br><br>";
	echo 'Facility Name'.':'."&nbsp;&nbsp". $facility_name;
	//echo "<div class=\"title\">Facility Type:</div>";
	//echo "&nbsp";
	//echo $facility_name;
	echo '<br><br>';
	
	
	
	$con=mysqli_connect("localhost","root","","uptown");

	//sql query
	$result = mysqli_query($con,"SELECT Date, Facility_ID, GROUP_CONCAT(Time SEPARATOR ',') FROM booking WHERE Date='$Date' AND Facility_ID='$facility_id' GROUP BY Date");
	//$verify = mysqli_query($con,"SELECT Unit_ID, Facility_ID, Date FROM booking WHERE Unit_ID = '$unitid' AND Date='$Date' AND Facility_ID='$facility_id'");
	$verify = mysqli_query($con,"SELECT Unit_ID, Facility_ID, Date,Type FROM booking Inner Join facility on booking.Facility_ID = facility.ID WHERE Unit_ID = '$unitid' AND Date='$Date' AND Type ='$facility_type'");

	
	$rowcount1=mysqli_num_rows($verify);
	$rowcount=mysqli_num_rows($result);
	
	echo $facility_id .' on '. $_POST['Date'] . '<input type="hidden" name="bookingDate2" value="'. $_POST['Date'] .'"> <input type="hidden" name="table_num2" value="'. $facility_id .'"><br><br>';
	//echo '<img src="https://api.qrserver.com/v1/create-qr-code/?data=Username:'.$_SESSION['mySession'].'%0ABooking Date:'.$_POST['bookingDate'].'%0ATable No.'.$table_num.'%0ANumber Of Pax:'.$num_pax.'&amp;size=100x100" alt="" title="" />';
	
	if ($rowcount1 == 1) {
		echo '<script>alert("Exceed Limits!");window.location.href="make-booking.php";</script>';
	} elseif ($rowcount != 1) {
		
		echo "<div class=\"title\">Available Time:</div><br>";
		for ($t=9; $t<19; $t++) {
			echo '<input name="Time[]" type="radio" value="'.$t.'">'.$t.':00<br>';
	}
		echo "<br>";
		echo "<div class=\"title\">Remarks:</div>";
		//echo '<input name="Remarks" type="textarea" value="">';
		echo '<textarea rows="2" cols="30" name="Remarks"></textarea>';

	}
	else {
		while($row = mysqli_fetch_array($result))
		{
			$Time = array_map('intval', explode(',', $row["GROUP_CONCAT(Time SEPARATOR ',')"]));
				
				echo "<div class=\"title\">Available Time:</div><br>";
				for ($t=9; $t<19; $t++) {
					echo '<input name="Time[]" type="radio" value="'.$t.'"';

						if (in_array($t , $Time, true)) {
							echo 'disabled="disabled"'; 
						}
					echo $t . '>'.$t.':00<br>';
					
				}
		}
				echo "<br>";
				echo "<div class=\"title\">Remarks:</div>";
				//echo '<input name="Remarks" type="textarea" value="">';
				echo '<textarea rows="2" cols="30" name="Remarks"></textarea>';

	}
	mysqli_close($con);

echo '<br><input type="submit" class="button7" name="submit" value="Book">';
}

if(isset($_POST['button8']))
{
	$unitid = $_SESSION['Unit'];
	$Date = $_POST['Date'];
	$facility_id = "C03";
	$facility_name = "<b>Functional Hall C</b>";
	$facility_type = "Functional Hall";
	//echo "<div class=\"title\">Facility No:</div>";
	//echo "&nbsp";
	//echo $facility_id; 
	
	echo 'Facility No'.':'."&nbsp;&nbsp". $facility_id;
	echo"<br><br>";
	echo 'Facility Name'.':'."&nbsp;&nbsp". $facility_name;
	//echo "<div class=\"title\">Facility Type:</div>";
	//echo "&nbsp";
	//echo $facility_name;
	echo '<br><br>';
	
	
	
	$con=mysqli_connect("localhost","root","","uptown");

	//sql query
	$result = mysqli_query($con,"SELECT Date, Facility_ID, GROUP_CONCAT(Time SEPARATOR ',') FROM booking WHERE Date='$Date' AND Facility_ID='$facility_id' GROUP BY Date");
	//$verify = mysqli_query($con,"SELECT Unit_ID, Facility_ID, Date FROM booking WHERE Unit_ID = '$unitid' AND Date='$Date' AND Facility_ID='$facility_id'");
	$verify = mysqli_query($con,"SELECT Unit_ID, Facility_ID, Date,Type FROM booking Inner Join facility on booking.Facility_ID = facility.ID WHERE Unit_ID = '$unitid' AND Date='$Date' AND Type ='$facility_type'");

	
	$rowcount1=mysqli_num_rows($verify);
	$rowcount=mysqli_num_rows($result);
	
	echo $facility_id .' on '. $_POST['Date'] . '<input type="hidden" name="bookingDate2" value="'. $_POST['Date'] .'"> <input type="hidden" name="table_num2" value="'. $facility_id .'"><br><br>';
	//echo '<img src="https://api.qrserver.com/v1/create-qr-code/?data=Username:'.$_SESSION['mySession'].'%0ABooking Date:'.$_POST['bookingDate'].'%0ATable No.'.$table_num.'%0ANumber Of Pax:'.$num_pax.'&amp;size=100x100" alt="" title="" />';
	
	if ($rowcount1 == 1) {
		echo '<script>alert("Exceed Limits!");window.location.href="make-booking.php";</script>';
	} elseif ($rowcount != 1) {
		
		echo "<div class=\"title\">Available Time:</div><br>";
		for ($t=9; $t<19; $t++) {
			echo '<input name="Time[]" type="radio" value="'.$t.'">'.$t.':00<br>';
	}
		echo "<br>";
		echo "<div class=\"title\">Remarks:</div>";
		//echo '<input name="Remarks" type="textarea" value="">';
		echo '<textarea rows="2" cols="30" name="Remarks"></textarea>';

	}
	else {
		while($row = mysqli_fetch_array($result))
		{
			$Time = array_map('intval', explode(',', $row["GROUP_CONCAT(Time SEPARATOR ',')"]));
				
				echo "<div class=\"title\">Available Time:</div><br>";
				for ($t=9; $t<19; $t++) {
					echo '<input name="Time[]" type="radio" value="'.$t.'"';

						if (in_array($t , $Time, true)) {
							echo 'disabled="disabled"'; 
						}
					echo $t . '>'.$t.':00<br>';
					
				}
		}
				echo "<br>";
				echo "<div class=\"title\">Remarks:</div>";
				//echo '<input name="Remarks" type="textarea" value="">';
				echo '<textarea rows="2" cols="30" name="Remarks"></textarea>';

	}
	mysqli_close($con);

echo '<br><input type="submit" class="button8" name="submit" value="Book">';
}

if(isset($_POST['button9']))
{
	$unitid = $_SESSION['Unit'];
	$Date = $_POST['Date'];
	$facility_id = "D01";
	$facility_name = "<b>BBQ Room A</b>";
	$facility_type = "BBQ Room";
	//echo "<div class=\"title\">Facility No:</div>";
	//echo "&nbsp";
	//echo $facility_id; 
	
	echo 'Facility No'.':'."&nbsp;&nbsp". $facility_id;
	echo"<br><br>";
	echo 'Facility Name'.':'."&nbsp;&nbsp". $facility_name;
	//echo "<div class=\"title\">Facility Type:</div>";
	//echo "&nbsp";
	//echo $facility_name;
	echo '<br><br>';
	
	
	
	$con=mysqli_connect("localhost","root","","uptown");

	//sql query
	$result = mysqli_query($con,"SELECT Date, Facility_ID, GROUP_CONCAT(Time SEPARATOR ',') FROM booking WHERE Date='$Date' AND Facility_ID='$facility_id' GROUP BY Date");
	//$verify = mysqli_query($con,"SELECT Unit_ID, Facility_ID, Date FROM booking WHERE Unit_ID = '$unitid' AND Date='$Date' AND Facility_ID='$facility_id'");
	$verify = mysqli_query($con,"SELECT Unit_ID, Facility_ID, Date,Type FROM booking Inner Join facility on booking.Facility_ID = facility.ID WHERE Unit_ID = '$unitid' AND Date='$Date' AND Type ='$facility_type'");

	
	$rowcount1=mysqli_num_rows($verify);
	$rowcount=mysqli_num_rows($result);
	
	echo $facility_id .' on '. $_POST['Date'] . '<input type="hidden" name="bookingDate2" value="'. $_POST['Date'] .'"> <input type="hidden" name="table_num2" value="'. $facility_id .'"><br><br>';
	//echo '<img src="https://api.qrserver.com/v1/create-qr-code/?data=Username:'.$_SESSION['mySession'].'%0ABooking Date:'.$_POST['bookingDate'].'%0ATable No.'.$table_num.'%0ANumber Of Pax:'.$num_pax.'&amp;size=100x100" alt="" title="" />';
	
	if ($rowcount1 == 1) {
		echo '<script>alert("Exceed Limits!");window.location.href="make-booking.php";</script>';
	} elseif ($rowcount != 1) {
		
		echo "<div class=\"title\">Available Time:</div><br>";
		for ($t=9; $t<19; $t++) {
			echo '<input name="Time[]" type="radio" value="'.$t.'">'.$t.':00<br>';
	}
		echo "<br>";
		echo "<div class=\"title\">Remarks:</div>";
		//echo '<input name="Remarks" type="textarea" value="">';
		echo '<textarea rows="2" cols="30" name="Remarks"></textarea>';

	}
	else {
		while($row = mysqli_fetch_array($result))
		{
			$Time = array_map('intval', explode(',', $row["GROUP_CONCAT(Time SEPARATOR ',')"]));
				
				echo "<div class=\"title\">Available Time:</div><br>";
				for ($t=9; $t<19; $t++) {
					echo '<input name="Time[]" type="radio" value="'.$t.'"';

						if (in_array($t , $Time, true)) {
							echo 'disabled="disabled"'; 
						}
					echo $t . '>'.$t.':00<br>';
					
				}
		}
				echo "<br>";
				echo "<div class=\"title\">Remarks:</div>";
				//echo '<input name="Remarks" type="textarea" value="">';
				echo '<textarea rows="2" cols="30" name="Remarks"></textarea>';

	}
	mysqli_close($con);

echo '<br><input type="submit" class="button9" name="submit" value="Book">';
}

if(isset($_POST['button10']))
{
	$unitid = $_SESSION['Unit'];
	$Date = $_POST['Date'];
	$facility_id = "D02";
	$facility_name = "<b>BBQ Room B</b>";
	$facility_type = "BBQ Room";
	//echo "<div class=\"title\">Facility No:</div>";
	//echo "&nbsp";
	//echo $facility_id; 
	
	echo 'Facility No'.':'."&nbsp;&nbsp". $facility_id;
	echo"<br><br>";
	echo 'Facility Name'.':'."&nbsp;&nbsp". $facility_name;
	//echo "<div class=\"title\">Facility Type:</div>";
	//echo "&nbsp";
	//echo $facility_name;
	echo '<br><br>';
	
	
	
	$con=mysqli_connect("localhost","root","","uptown");

	//sql query
	$result = mysqli_query($con,"SELECT Date, Facility_ID, GROUP_CONCAT(Time SEPARATOR ',') FROM booking WHERE Date='$Date' AND Facility_ID='$facility_id' GROUP BY Date");
	//$verify = mysqli_query($con,"SELECT Unit_ID, Facility_ID, Date FROM booking WHERE Unit_ID = '$unitid' AND Date='$Date' AND Facility_ID='$facility_id'");
	$verify = mysqli_query($con,"SELECT Unit_ID, Facility_ID, Date,Type FROM booking Inner Join facility on booking.Facility_ID = facility.ID WHERE Unit_ID = '$unitid' AND Date='$Date' AND Type ='$facility_type'");

	
	$rowcount1=mysqli_num_rows($verify);
	$rowcount=mysqli_num_rows($result);
	
	echo $facility_id .' on '. $_POST['Date'] . '<input type="hidden" name="bookingDate2" value="'. $_POST['Date'] .'"> <input type="hidden" name="table_num2" value="'. $facility_id .'"><br><br>';
	//echo '<img src="https://api.qrserver.com/v1/create-qr-code/?data=Username:'.$_SESSION['mySession'].'%0ABooking Date:'.$_POST['bookingDate'].'%0ATable No.'.$table_num.'%0ANumber Of Pax:'.$num_pax.'&amp;size=100x100" alt="" title="" />';
	
	if ($rowcount1 == 1) {
		echo '<script>alert("Exceed Limits!");window.location.href="make-booking.php";</script>';
	} elseif ($rowcount != 1) {
		
		echo "<div class=\"title\">Available Time:</div><br>";
		for ($t=9; $t<19; $t++) {
			echo '<input name="Time[]" type="radio" value="'.$t.'">'.$t.':00<br>';
	}
		echo "<br>";
		echo "<div class=\"title\">Remarks:</div>";
		//echo '<input name="Remarks" type="textarea" value="">';
		echo '<textarea rows="2" cols="30" name="Remarks"></textarea>';

	}
	else {
		while($row = mysqli_fetch_array($result))
		{
			$Time = array_map('intval', explode(',', $row["GROUP_CONCAT(Time SEPARATOR ',')"]));
				
				echo "<div class=\"title\">Available Time:</div><br>";
				for ($t=9; $t<19; $t++) {
					echo '<input name="Time[]" type="radio" value="'.$t.'"';

						if (in_array($t , $Time, true)) {
							echo 'disabled="disabled"'; 
						}
					echo $t . '>'.$t.':00<br>';
					
				}
		}
				echo "<br>";
				echo "<div class=\"title\">Remarks:</div>";
				//echo '<input name="Remarks" type="textarea" value="">';
				echo '<textarea rows="2" cols="30" name="Remarks"></textarea>';

	}
	mysqli_close($con);

echo '<br><input type="submit" class="button10" name="submit" value="Book">';
}

?>	
</div>
			</form>
			</div>
		</form>
	</div>
	</article>
	<footer>
			<?php
			include("footer.php");
			?>
	</footer>
</div>
<script>
$('#numpax').on('change', function() {
$('#form2 #' + $(this).val()).prop('disabled', false).siblings().prop('disabled', true);
});
</script>
<script>
function showNumPax()
{
	document.getElementById("numpax").style.display = "block";
	document.getElementById("labelf").style.display = "block";
}
</script>

</body>

</html>
