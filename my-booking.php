<?php include ("connection.php");
include ("login-session.php");
include("unit-session.php");
include("retrieve.php");
include("access-owner-tenant.php");

date_default_timezone_set("Asia/Kuala_Lumpur");
$res = mysqli_query ($con, "Select *, booking.ID as Booking_ID From booking left join Facility on booking.Facility_ID = Facility.ID where Unit_ID = '$session_unit' and Date(Date) >= Curdate() order by Date desc");
?>

<!DOCTYPE html>
<html>
<head>
<title>UPTOWN | My Bookings</title>
  <link rel="stylesheet" href="css/default.css">
  
  <!--Web Icon & Font input-->
  <script src="head-input.js"></script>
<style>

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

img.avatar {
  width: 40%;
  border-radius: 30%;
}

.desc h4 {
text-align:left;
}

.gallery {
  margin: 5px;
  border: 5px solid #ccc;
  width: 260px;
  margin-left: 50px;
  display: inline-block;
  height: 450px;
  vertical-align: top;
}


.gallery:hover {
  border: 5px solid #777;
}

div.gallery img {
  width: 50%;
  height: auto;
 
}

div.desc {
  padding: 15px;
  text-align: center;
}

.center {
  display: block;
  margin-left: auto;
  margin-right: auto;
  width: 50%;
  position: relative;
}

</style>
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
    <h1>My Bookings</h1>
    <div class="content" style="text-align: center;">	
    <?php 
  $bookingCount = mysqli_num_rows($res);
  if($bookingCount > 0){
	while($r = mysqli_fetch_assoc($res)){ ?>
    <?php if($r["Status"] == "Approved") {?>
      <a href="booking-detail.php?ID=<?php echo $r['Booking_ID']; ?>">
      <?php }?>
  		<div class="gallery">
  		<br>
  		<?php
  		$facility = $r["Type"];
      

      
  		if($r["Type"] == "Badminton Court") {
  				echo '<img src="images/badminton2.svg"  width="200" height="100" class="center">';
  			} else if($r["Type"] == "Party Room"){
  				echo '<img src="images/party-room.svg"  width="200" height="100" class="center">';
  			} else if($r["Type"] == "BBQ Room"){
  				echo '<img src="images/bbq.svg"  width="200" height="100" class="center">';
  			} else if($r["Type"] == "Functional Hall"){
  				echo '<img src="images/functional-hall.svg"  width="200" height="100" class="center">';
			}
  				
  		?>
  			<div class="desc"> 
  				<h4><font color="blue">Facility</font>&nbsp;&nbsp;<font color="red"><?php echo $r['Name'] ?></font></h4>
                        <h4><font color="blue">Date</font>&nbsp;&nbsp;<?php echo $r['Date'] ?></h4>
                        <h4><font color="blue">Time</font>&nbsp;&nbsp;<?php echo $r['Time'] ?></h4>
                        <h4><font color="blue">Status</font>&nbsp;&nbsp;<font color="red"><?php echo $r['Status'] ?></font></h4>
 
			</div>
		</div>
    <?php if($r["Status"] == "Approved") {?>
    </a>
  <?php }?>
	<?php 
    } 
    } else {
        echo "<h4>No Up-Coming Booking</h4> Click <u><a href='make-booking.php'>here</a></u> to make one!";
      }
    ?>
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