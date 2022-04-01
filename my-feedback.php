<?php
include("connection.php");
include("login-session.php");
include("unit-session.php");
include("retrieve.php");
include("access-owner-tenant.php");
date_default_timezone_set("Asia/Kuala_Lumpur");
$res = mysqli_query ($con, "Select * From feedback_resident where Sender_ID = '$session_id' and Unit_ID = '$session_unit' order by ID desc;");
$res2 = mysqli_query ($con, "Select * From feedback_management where Unit_ID = '$session_unit' order by ID desc;");
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

	<title>UPTOWN | My Feedback</title>
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
			<h1>Resident Feedback</h1>
			<div class="content">
<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search by Subject">

<table id="myTable">
  <tr class="header">
    <th style="width:20%;">Subject</th>
    <th style="width:20%;">Email</th>
    <th style="width:30%;">Content</th>
    <th style="width:10%;">Sender</th>
    <th style="width:10%;">Receiver Unit</th>
    <th style="width:10%;">Status</th>
  </tr>
 <?php  while($r = mysqli_fetch_array($res)){ ?>
  <tr>
    <td><?php echo $r['Subject'] ?></td>
    <td><?php echo $r['Email'] ?></td>
    <td><?php echo $r['Content'] ?></td>
    <td><?php echo $r['Sender_ID'] ?></td>
    <td><?php echo $r['Receiver_unit'] ?></td>
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
<hr>
<h1>Management Feedback</h1>
      <div class="content">
<input type="text" id="myInput2" onkeyup="myFunction2()" placeholder="Search by Subject">

<table id="myTable2">
  <tr class="header">
    <th style="width:15%;">Subject</th>
    <th style="width:15%;">Email</th>
    <th style="max-width:60%;">Content</th>
    <th style="width:10%;">Status</th>
  </tr>
 <?php  while($r2 = mysqli_fetch_array($res2)){ ?>
  <tr class="tr">
    <td class="td"><?php echo $r2['Subject']; ?></td>
    <td class="td"><?php echo $r2['Email']; ?></td>
    <td class="td"><?php echo $r2['Content']; ?></td>
    <td class="td"><?php echo $r2['Status']; ?></td>
  </tr>
    <?php } ?>
</table>

<script>
function myFunction2() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput2");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable2");
  tr = table.getElementsByClassName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByClassName("td")[0];
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
		</article>
		<footer>
			<?php
			include("footer.php");
			?>
		</footer>
	</div>
</body>
</html>