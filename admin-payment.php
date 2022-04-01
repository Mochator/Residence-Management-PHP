<?php
include("connection.php");
include("login-session.php");
include("retrieve.php");
include("access-admin.php");
date_default_timezone_set("Asia/Kuala_Lumpur");
if(isset($_GET["search"])){
	$unit = $_GET["unit"];
}
if(isset($_GET["fsearch"])){
	$unit = $_GET["unit"];
	$id = $_GET["id"];
}



?>

<!DOCTYPE html>
<html>
<head>
	<title>UPTOWN | Admin Payment</title>
	<link rel="stylesheet" href="css/default.css">
	<link rel="stylesheet" href="css/profile-setting.css">
	<!--Web Icon & Font input-->
	<script src="head-input.js"></script>
	<!--Font awesome-->
	<link href="font-awesome/css/all.css" rel="stylesheet">
	<script defer src="/font-awesome/js/all.js"></script>

	<style>
		#form3{
			display:;
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
			<h1>Admin Make Payment</h1>
			<!--Error message-->
			<script src="information-window.js" type="text/javascript"></script>

			<!--Form part-->
			<form method="get" action="admin-payment.php">
				<div class="content">
					<label for="unit">Unit</label><br>
					<select class="width50 input-field" name="unit">
					<?php
						$unitSql = "select * from unit;";
						$runUnit = mysqli_query($con, $unitSql);

							while($unitRow = mysqli_fetch_assoc($runUnit)){
								echo "<option ";
								if(isset($_GET["search"]) || isset($_GET["fsearch"])){
									if($unitRow["ID"] == $unit){
										echo "selected ";
									}
								}
								echo "value='".$unitRow["ID"]."'>".$unitRow["ID"]."</option>";
							}
					?>
					</select>
					<br><br>
					<input name="search" type="submit" value="Search Unit">
				</div>
			</form>	

			<form method="get" action="admin-payment.php">
				<div class="content">
					<label for="financial">Financial ID</label><br>
					<select class="width50 input-field" name="id">
						<option value='null'>---Select Financial ID---</option>
					<?php
						if(isset($_GET["search"]) || isset($_GET["fsearch"])) {

							$financialSql = "select * from financial_statement where Unit_ID = '$unit' and Status = 'Not paid';";
							$runFinancial = mysqli_query($con, $financialSql);

							while($financialRow = mysqli_fetch_assoc($runFinancial)){
								echo "<option ";
								if(isset($_GET["fsearch"])){
									if($financialRow["ID"] == $id){
										echo "selected ";
									}
								}
								echo "value='".$financialRow["ID"]."'>".$financialRow["ID"]."</option>";
							}
						}
					?>
					</select>
					<?php if(isset($_GET["search"])||isset($_GET["fsearch"])){echo "<input type='hidden' name='unit' value='".$unit."'>"; }?>
					<br><br>
					<input name="fsearch" type="submit" id='financialId' value="Retrieve" <?php if(!(isset($_GET["fsearch"]) || isset($_GET["search"]))){echo "disabled";}?>>
				</div>
			</form>	

			<?php
			if(isset($_GET["fsearch"])){
				$unit = $_GET["unit"];
				$id = $_GET["id"];
				$fSql = "select * from financial_statement left join financial_type on financial_statement.Financial_type = financial_type.ID where financial_statement.ID = '$id';";

				if(!$runF = mysqli_query($con, $fSql)){
					die("Error: ".mysqli_error($con));
				} else {
					echo "<script>document.getElementById('form3').style.display = 'block';</script>";
					$fRow = mysqli_fetch_assoc($runF);
					//echo "run";
				}
			}
			?>

			<form method="post" action="admin-payment.php" id="form3">
				<div class="content">
					<label for="fType">Financial Type</label><br>
					<input class="width50 input-field" type="text" disabled <?php if(isset($_GET["fsearch"])){ echo "value ='".$fRow["Type"]."'";}?>>
					<br><br>
					<label for="fAmount">Amount</label><br>
					<input class="width50 input-field" type="text" disabled <?php if(isset($_GET["fsearch"])){ echo "value ='".$fRow["Amount"]."'";}?>>
					<br><br>
					<label for="fDue">Due</label><br>
					<input class="width50 input-field" name="due" type="text" disabled <?php if(isset($_GET["fsearch"])){ echo "value ='".$fRow["Amount"]."'";}?>>
					<br><br>
					<label for="pType">Payment Method</label><br>
					<select name="pType" class="width50 input-field">
						<?php
						$pMethodSql = "select * from payment_type where not Type='Online Banking'";
						$runPMethod = mysqli_query($con, $pMethodSql);
						while($methodRow = mysqli_fetch_assoc($runPMethod)){
							echo "<option value='".$methodRow["ID"]."'>".$methodRow["Type"]."</option>";
						}
						?>
					</select>
					<br><br>
					<label for="remarks">Remarks</label><br>
					<textarea form="form3" name="remarks" placeholder="Eg. as Paid 100 out of 200"></textarea>
					<br><br>
					<label for="attachment">Attachment</label><br>
					<input type="text" class="width50 input-field" name="attachment" placeholder="Enter the receipt number">
					<br><br>
					<label for="user">User_ID</label><br>
					<select name="user" class="width50 input-field">
						<?php
						$userSql = "select * from user where Role = 'Owner' or Role = 'Tenant'";
						$runUser = mysqli_query($con, $userSql);
						while($userRow = mysqli_fetch_assoc($runUser)){
							echo "<option value='".$userRow["ID"]."'>".$userRow["ID"]."</option>";
						}
						?>
					</select>
					<?php if(isset($_GET["search"])||isset($_GET["fsearch"])){echo "<input type='hidden' name='unit' value='".$unit."'>"; }?>
					<?php if(isset($_GET["fsearch"])){echo "<input type='hidden' name='id' value='".$id."'>"; }?>
					<br><br>
					<input type="submit" name="submit" value="Submit" id="submit" <?php if(!isset($_GET["fsearch"])){echo "disabled";}?> >
				</div>
			</form>	

		</article>
		<footer>
			<?php
			include("footer.php");
			?>
		</footer>
	</div>
	<?php
	if(isset($_POST["submit"])){
		$pType = $_POST["pType"];
		$attachment = $_POST["attachment"];
		$remarks = $_POST["remarks"];
		$unit = $_POST["unit"];
		$user = $_POST["user"];
		$financial = $_POST["id"];

		$pType = htmlentities(stripslashes(mysqli_real_escape_string($con, $pType)));
		$attachment = htmlentities(stripslashes(mysqli_real_escape_string($con, $attachment)));
		$remarks = htmlentities(stripslashes(mysqli_real_escape_string($con, $remarks)));
		$unit = htmlentities(stripslashes(mysqli_real_escape_string($con, $unit)));
		$user = htmlentities(stripslashes(mysqli_real_escape_string($con, $user)));
		$financial = htmlentities(stripslashes(mysqli_real_escape_string($con, $financial)));

		$paymentSql = "insert into payment(`Payment_type`, `Attachment`, `Remarks`, `Unit_ID`, `User_ID`, `Financial_ID`, `Status`) VALUES ('$pType', '$attachment', '$remarks', '$unit', '$user', '$financial', 'Approved');";
		if(!$runPayment = mysqli_query($con, $paymentSql)){
			echo "<script>alert('".mysqli_error($con)."');</script>";
		} else {
			echo "<script>alert('Location: admin-payment.php')</script>";
		}
	}
	?>
</body>
</html>