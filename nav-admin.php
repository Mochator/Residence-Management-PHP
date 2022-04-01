<!--Admin navigation
Insert include("nav-admin.php"); between <nav></nav> in your php file-->

				<div id="menu">
					<div class="logo menu-item">
						<a href="dashboard.php"><img src="Resources/Logo.png" alt="UPtown Residence Logo"></a>
					</div>
					<div class="menu-item">
						<a href="admin-panel.php">Admin Panel</a>
					</div>
					<div class="menu-item">
						<a href="#">Create account</a>
						<div class="dropdown expand">
								<a href="create-owner.php">Create Owner Account</a>
								<a href="create-security.php">Create Security Account</a>
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

