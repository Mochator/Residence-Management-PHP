<?php
include("connection.php");
include("login-session.php");
include("unit-session.php");
include("retrieve.php");
include("access-owner-tenant.php");
date_default_timezone_set("Asia/Kuala_Lumpur");
$res = mysqli_query ($con, "Select *, payment.ID as PayID, payment_type.Type as pType from payment left join payment_type on payment.Payment_type = payment_type.ID left join financial_statement on payment.Financial_ID = financial_statement.ID left join financial_type on financial_statement.Financial_type = financial_type.ID left join user on payment.User_ID = user.ID  where payment.Unit_ID = '$session_unit' order by payment.ID desc;");
?>

<!DOCTYPE html>
<html>
<head>

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

</style>

	<title>UPTOWN | Payment History</title>
	<link rel="stylesheet" href="css/default.css">
	<link rel="stylesheet" href="css/table.css">
	<!--Web Icon & Font input-->
  <script src="head-input.js"></script>
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
			<h1>Payment History</h1>
			<div class="content">
<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search by Subject">

<table id="myTable">
  <tr class="header">
    <th style="width:10%;">Payment ID</th>
    <th style="width:10%;">Amount</th>
    <th style="width:10%;">Date Time</th>
    <th style="width:10%;">Payment Method</th>
    <th style="width:10%;">Attachment</th>
    <th style="width:10%;">Paid By</th>
    <th style="width:10%;">Status</th>
    
  </tr>
 <?php  while($r = mysqli_fetch_array($res)){ ?>
  <tr>
    <td><?php echo $r['PayID'] ?></td>
    <td><?php echo $r['Amount'] ?></td>
    <td><?php echo date("d-M-Y",strtotime($r['Timestamp'])) ?></td>
    <td><?php echo $r['pType'] ?></td>
    <td>
    <?php 
      if($r["pType"] == "Online Banking"){
        echo "<a href='".$r["Attachment"]."' target='_blank'><button>View</button></a>";
      } else {
        echo $r["Attachment"];
      } 
    ?>
      
  </td>
  <td><?php echo $r['First_name']." ".$r["Last_name"]; ?></td>
	<td><?php echo $r['Status'] ?></td>


  </tr>
    <?php } ?>
</table>

<script>
function myFunction() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
</script>
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