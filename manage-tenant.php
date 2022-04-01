<?php include ("connection.php");
include ("login-session.php");
include("retrieve.php");
include("unit-session.php");
include("access-owner.php");
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>UPTOWN | Manange Tenants</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<!-- MATERIAL DESIGN ICONIC FONT -->
		<link rel="stylesheet" href="fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">
		<!--Web Icon & Font input-->
		<script src="head-input.js"></script>

		<!-- STYLE CSS -->
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/default.css">

		<style>
			th{
				background-color: black;
				color: white;
			}

			td{
				background-color: rgba(225,225,225,1);
			}

			td, th{
				padding: 3px;
			}

			table{
				text-align: center;
				width: 100%;
			}
		</style>
	</head>

	<body>
		<div class="wrapper" style="background-image: url('images/Background2.jpg');">
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
				<div class="image-holder content">
					<table>
						<th>User ID</th>
						<th>Name</th>
						<th>Email</th>
						<th>Contact</th>
						<th>Delete</th>
					<?php
					$tenantSql = "select * from tenants left join user on tenants.User_ID = user.ID where user.Account_status = 'Active' and tenants.Unit_ID = '$session_unit';";
					if(!$runTenant = mysqli_query($con, $tenantSql)){
						die("Error : ".mysqli_error($con));
					} else {

					while($tenantRow = mysqli_fetch_assoc($runTenant)){
						echo "<tr><td>";
						echo $tenantRow["User_ID"];
						echo "</td><td>";
						echo $tenantRow["First_name"]." ".$tenantRow["Last_name"];
						echo "</td><td>";
						echo $tenantRow["Email"];
						echo "</td><td>";
						echo $tenantRow["Contact"];
						echo "</td><td>";
						echo "<a href='delete-tenant.php?ID=".$tenantRow["User_ID"]."'><button>Delete</button></a></td></tr>";
					}

					}
					?>
					</table>
				</div>
				<form action="phpmailer2.php" method="post">
					<h3>Tenant - Sub account <p>Registration Form</p></h3>
					<div class="form-wrapper">
						<input type="hidden" name="Role" value="Tenant" required>  

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