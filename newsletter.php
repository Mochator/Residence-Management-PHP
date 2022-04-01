<?php
include("connection.php");
include("login-session.php");
include("unit-session.php");
include("retrieve.php");
date_default_timezone_set("Asia/Kuala_Lumpur");

?>
<!DOCTYPE html>
<html>
<head>
	<title>UPTOWN | Newsletter</title>
	<link rel="stylesheet" href="css/default.css">
	<!--Web Icon & Font input-->
	<script src="head-input.js"></script>
	<!--Font awesome-->
	<link href="font-awesome/css/all.css" rel="stylesheet">
	<script defer src="/font-awesome/js/all.js"></script>

	<style>
		.newsletter-item{
			display: inline-block;
			padding: 20px;
			vertical-align: top;
			position: relative;
		}

		.newsletter-item i{
			color: #FF4A3B;
		}

		.newsletter-item h2{
			font-size: ;
		}

		.post-date{
			position: absolute;
			bottom: 20px;
			right: 20px;
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
			<h1>Newsletter</h1>
			<div class="content">
				<div class="newsletter-item"><i class="fas fa-exclamation-triangle fa-10x"></i></div>
				<div class="newsletter-item width79">
					<h2>Water Shortage</h2>
					<p>Dear tenants and owners, there will be a shortage of water supply on Wednesday, 15th January 2020 from 1200 to 1700, due to maintenance of water pipes. We apologize for any inconvenience caused.</p>
				</div>
				<span class="post-date">4th January 2020</span>
			</div>
			<div class="content">
				<div class="newsletter-item"><i class="fas fa-info-circle fa-10x"></i></div>
				<div class="newsletter-item width79">
					<h2>Owner Whatsapp Group</h2>
					<p>Dear owners, a QR code to our lastest Whatsapp group has been sent to your registered email in our system. It can be used to join our owners whatsapp group for lastest information or any interactions with your neighbours.</p>
				</div>
				<span class="post-date">1st January 2020</span>
			</div>
			<div class="content">
				<div class="newsletter-item"><i class="fas fa-info-circle fa-10x"></i></div>
				<div class="newsletter-item width79">
					<h2>A Change in UPTOWN Management Team</h2>
					<p>Dear everyone, the management team of UPTOWN Residence has been changed on 20th December 2019</p>
				</div>
				<span class="post-date">18th December 2019</span>
			</div>
			<div class="content">
				<div class="newsletter-item"><i class="fas fa-bug fa-10x"></i></div>
				<div class="newsletter-item width79">
					<h2>Pest Control</h2>
					<p>Dear owners and tenants, there will be a pest control activity throughout the building on 30th November 2019, 5PM to 6PM. Try to stay indoor, sorry for the inconvenience caused.</p>
				</div>
				<span class="post-date">25th November 2019</span>
			</div>
			<div class="content">
				<div class="newsletter-item"><i class="fas fa-exclamation-triangle fa-10x"></i></div>
				<div class="newsletter-item width79">
					<h2>Water Tank Maintenance</h2>
					<p>Dear owners and tenants, maintenance on UPTOWN Residence's water tanks will be carried out on this Saturday, 25th November 2019, 1200PM. The maintenance requires approximately 3 to 4 hours. We apologize for your inconvenience.</p>
				</div>
				<span class="post-date">18th November 2019</span>
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