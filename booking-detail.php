<?php
include("connection.php");
include("login-session.php");
include("retrieve.php");
include("unit-session.php");
include("access-owner-tenant.php");
date_default_timezone_set("Asia/Kuala_Lumpur");
$id = intval($_GET['ID']);
$result = mysqli_query ($con, "Select *, booking.ID as Booking_ID From booking left join Facility on booking.Facility_ID = Facility.ID where booking.ID =$id");
$row = mysqli_fetch_Array($result);

if(!$row["Unit_ID"]==$session_unit){
  echo "<script>alert('Access denied!');</scrcipt>";
  echo "<script>window.location.href='dashboard.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<style>

li {
  display: inline-block;
  list-style-type: none;
  padding: 1em;
}

li span {
  display: block;

}

.button {
  background-color: #555555; /* Green */
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
}

table, tr, td, th, ul, li, table span{
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

</style>

	<title>UPTOWN | Resident Feedback</title>
	<link rel="stylesheet" href="css/default.css">
	<link rel="stylesheet" href="css/table.css">
	<!--Web Icon & Font input-->
  <script src="head-input.js"></script>
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
			<h1>Booking Details</h1>
			<div class="content">

<table id="myTable">
  <tr class="header">
	<th style="width:10%;">Booking ID</th>
      <th style="width:20%;">Facility Name</th>
      <th style="width:20%;">Facility Type</th>
      <th style="width:10%;">Date</th>
      <th style="width:10%;">Time</th>
      <th style="width:30%;">Countdown To Booking Time</th>
  </tr>
  <tr>
    <td><?php echo $row['Booking_ID'] ?></td>
    <td><?php echo $row['Name'] ?></td>
    <td><?php echo $row['Type'] ?></td>
    <td><?php echo $row['Date'] ?></td>
    <td><?php echo $row['Time'] ?></td>
    <td><ul>
   			 <li><span id="days"></span>days</li>
  			 <li><span id="hours"></span>Hours</li>
    		 <li><span id="minutes"></span>Minutes</li>
  
 			 </ul>
</td>
  </tr>

</table>
<br><br>
<a href="my-booking.php" class="button">Back</a>
<?php $bookingdate = date_create($row['Date']);


?>


<script>
function myFunction() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
</script>
</div>
		</article>
		<footer>
			<?php
			include("footer.php");
			?>
		</footer>
	</div>
</body>
</html>

<script>
const second = 1000,
minute = second * 60,
hour = minute * 60,
day = hour * 24;

let countDown = new Date('<?php echo date_format($bookingdate,"M d, Y"); ?>, <?php echo $row['Time'] ?>').getTime(),
    x = setInterval(function() {

     	  let now = new Date().getTime(),
          distance = countDown - now;

        document.getElementById('days').innerText = Math.floor(distance / (day)),
        document.getElementById('hours').innerText = Math.floor((distance % (day)) / (hour)),
        document.getElementById('minutes').innerText = Math.floor((distance % (hour)) / (minute)),
        document.getElementById('seconds').innerText = Math.floor((distance % (minute)) / second);
      
    }, second)
    </script> 


                 
 			 
               