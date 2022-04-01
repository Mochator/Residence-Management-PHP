<!--Tenant navigation
Insert include("nav-tenant.php"); between <nav></nav> in your php file-->

				<div id="menu">
					<div class="logo menu-item">
						<a href="dashboard.php"><img src="Resources/Logo.png" alt="UPtown Residence Logo"></a>
					</div>
					<div class="menu-item">
						<a href="#">My List</a>
						<div class="dropdown expand">
								<a href="my-booking.php">Bookings</a>
								<a href="my-package-request.php">Package Request</a>
								<a href="my-parking-slot-request.php">Parking Slot</a>
								<a href="my-visitor.php">Visitors</a>
								<a href="my-feedback.php">Feedbacks</a>
						</div>
					</div>
					<div class="menu-item">
						<a href="#">Service</a>
						<div class="dropdown expand">
								<a href="make-booking.php">Make Bookings</a>
								<a href="request-package.php">Request Package Receiving</a>
								<a href="request-parking-slot.php">Request Parking Slot</a>
								<a href="register-visitor.php">Visitor Registration</a>
						</div>
					</div>
					<div class="menu-item">
						<a href="#">Financial</a>
						<div class="dropdown expand">
								<a href="financial-statement.php">Financial Statement</a>
								<a href="make-payment.php">Make Payment</a>
								<a href="payment-history.php">Payment History</a>
						</div>
					</div>
					<div class="menu-item">
						<a href="#">Feedback</a>					
						<div class="dropdown expand">
								<a href="management-feedback.php">Feedback to Management</a>
								<a href="resident-feedback.php">Feedback to Resident</a>
						</div>
					</div>
					<div class="menu-item" style="position: absolute; right:0; top:15px;">
						<a href="#">Hey, <?php echo $firstName ?></a>
						<div class="dropdown expand">
								<a href="profile-setting.php">Profile Setting</a>
								<a href="logout.php">Logout</a>
						</div>
					</div>
				</div>

