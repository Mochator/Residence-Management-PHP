<?php include ("connection.php");
include ("login-session.php");
include("unit-session.php");
include("retrieve.php");
include("access-owner-tenant.php");
$res = mysqli_query ($con, "Select * From parking_slot_request where Unit_ID = '$session_unit' order by ID desc;");?>

<!DOCTYPE html>
<html>
<head>
<title>UPTOWN | My Resident Feedback</title>
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
  width: 250px;
  margin-left: 50px;
  display: inline-block
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
    <h1>My Parking Slot</h1>
    <div class="content" style="text-align: center;">	
    <?php 
     $count = mysqli_num_rows($res);

  if($count > 0){
	while($r = mysqli_fetch_array($res)){ ?>
  		<div class="gallery">
  		<br>
    			<img src="images/parking.svg"  width="200" height="100" class="center">

  			<div class="desc"> 
  				 <h4><font color="blue">Request ID</font>&nbsp;&nbsp;<?php echo $r['ID'] ?></h4>
                 <h4><font color="blue">Type</font>&nbsp;&nbsp;<?php echo $r['Type'] ?></h4>
                 <h4><font color="blue">Status</font>&nbsp;&nbsp;<?php echo $r['Status']; ?></h4>
			</div>
		</div>
	<?php } 
    } else {
        echo "<h4>No Package Slot Request</h4> Click <u><a href='request-parking-slot.php'>here</a></u> to make one!";
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