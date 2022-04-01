<?php include ("connection.php");
include ("login-session.php");
include("retrieve.php");
include("access-admin.php");

date_default_timezone_set("Asia/Kuala_Lumpur");
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>RegistrationForm_v1 by Colorlib</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<!-- MATERIAL DESIGN ICONIC FONT -->
		<link rel="stylesheet" href="fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">
		<!--Web Icon & Font input-->
		<script src="head-input.js"></script>

		<!-- STYLE CSS -->
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/default.css">
	</head>

	<body>
		<div class="wrapper" style="background-image: url('images/Background.jpg');">
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
			<div class="inner">
				<div class="image-holder">
					<img src="images/Resident3.jpg" alt="">
				</div>
				<form action="phpmailer.php" method="post">
					<h3>Owner <p>Registration Form</p></h3>
					<div class="form-wrapper">
						<input type="hidden" name="Role" value="Owner" required>  

						</div>
					<br>
					<div class="form-group">
						<input type="text" name="First_name" placeholder="First Name" class="form-control">
						<input type="text" name="Last_name" placeholder="Last Name" class="form-control">
					</div>
					<div class="form-wrapper">
						<input type="text" name="Email" placeholder="Email" class="form-control">
						<i class="zmdi zmdi-email"></i>
					</div>
					
					<div class="form-wrapper">
						<input type="text" name="Contact" placeholder="Contact Number" class="form-control">
						<i class="zmdi zmdi-phone"></i>
					</div>
					
					<div class="form-wrapper">
						<input type="hidden" name="Password" value="admin" class="form-control">
					</div>


					<div class="form-wrapper">
						<input type="hidden"  name="Registered_Date"  class="form-control">
					</div>

					<button>Register
					<i class="zmdi zmdi-arrow-right" ></i>
					</button>
					
				</form>
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