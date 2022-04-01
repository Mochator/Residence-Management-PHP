<?php
include("connection.php");
include("login-session.php");
include("retrieve.php");
include("unit-session.php");
include("access-owner-tenant.php");
date_default_timezone_set("Asia/Kuala_Lumpur");
$res = mysqli_query ($con, "Select *, financial_statement.ID as FsID From financial_statement left join financial_type on financial_statement.Financial_type = financial_type.ID where financial_statement.Unit_ID = '$session_unit' order by financial_statement.Due desc;");
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

	<title>UPTOWN | Financial Statement</title>
	<link rel="stylesheet" href="css/default.css">
	<link rel="stylesheet" href="css/table.css">
	 <!--Web Icon & Font input-->
  <script src="head-input.js"></script>
	<!--Font-->
	<link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
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
			<h1>Financial Statement</h1>
			<div class="content">
<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search by Subject">

<table id="myTable">
  <tr class="header">
    <th style="width:20%;">ID</th>
    <th style="width:20%;">Financial Type</th>
    <th style="width:30%;">Amount</th>
    <th style="width:20%;">Due</th>
    <th style="width:10%;">Status</th>
  </tr>
 <?php  while($r = mysqli_fetch_assoc($res)){ ?>
  <tr>
    <td><?php echo $r['FsID'] ?></td>
    <td><?php echo $r['Type'] ?></td>
    <td><?php echo $r['Amount'] ?></td>
    <td><?php echo $r['Due'] ?></td>
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
  <?php include("footer.php");?>
</footer>
</body>
</html>