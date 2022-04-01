<?php include ("connection.php");
include ("login-session.php");
include("unit-session.php");
include("retrieve.php");
include("access-owner-tenant.php");
$res = mysqli_query ($con, "Select * From package_receive where User_ID = '$session_id' and Unit_ID = '$session_unit' order by ID desc;");
?>

<!DOCTYPE html>
<html>
<head>
<title>UPTOWN | My Package Request</title>
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
    <h1>My Package Request</h1>
    <div class="content"  style="text-align:center;">	
    <?php 
    $packageCount = mysqli_num_rows($res);

    if($packageCount > 0){
	   while($r = mysqli_fetch_array($res)){ ?>
  		<div class="gallery">
  		<br>

    			<img src="images/box.svg"  width="200" height="100" class="center">

  			<div class="desc"> 
  				<h4><font color="blue">Unit ID</font>&nbsp;&nbsp;<?php echo $r['Unit_ID'] ?></h4>
                <h4><font color="blue">Name</font>&nbsp;&nbsp;<?php echo $r['Receiver_name'] ?></h4>
                <h4><font color="blue">Status</font>&nbsp;&nbsp;<font color="red"><?php echo $r['Status'] ?></font></h4>
			</div>
		</div>
	<?php 
    }
  } else {
    echo "<h4>No Package Request</h4> Click <u><a href='request-package.php'>here</a></u> to make one!";
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