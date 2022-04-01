<!--Security navigation
Insert include("nav-security.php"); between <nav></nav> in your php file-->

				<div id="menu">
					<div class="logo menu-item">
						<a href="dashboard.php"><img src="Resources/Logo.png" alt="UPtown Residence Logo"></a>
					</div>
					<div class="menu-item">
						<a href="visitor-list.php">Visitor List</a>
					</div>
					<div class="menu-item" style="position: absolute; right:0; top:15px;">
						<a href="#">Hey, <?php echo $firstName ?></a>
						<div class="dropdown expand">
								<a href="profile-setting.php">Profile Setting</a>
								<a href="logout.php">Logout</a>
						</div>
					</div>
				</div>

