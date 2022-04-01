<?php
  // Create database connection
  include("connection.php");
  include("login-session.php");
  include("unit-session.php");
  include("retrieve.php");
  include("access-owner-tenant.php");
 

  // Initialize message variable
  $msg = "";
  
  // If register button is clicked ...
  if (isset($_POST['submit'])) {
  	$unitid = $_SESSION['Unit'];
  	$userid = $_SESSION['ID'];
    //$unitid = mysqli_real_escape_string($con, $_POST['Unit_ID']);
    //$userid = mysqli_real_escape_string($con, $_POST['User_ID']);  
   	$typesofparking = mysqli_real_escape_string($con, $_POST['Type']);

  	$sql = "INSERT INTO parking_slot_request (Type, Unit_ID, Status) VALUES ('$typesofparking', '$unitid', 'Pending');";    
  	// execute query
  	mysqli_query($con, $sql);
  	echo'<script>alert("Successfully Requested!");
  	</script>';
  	}
?>

<!DOCTYPE html>
<html>
<head>
<title>Parking Request Form</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/default.css">
<!--Web Icon & Font input-->
<script src="head-input.js"></script>
<style>
input[type=text], select, textarea {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  margin-top: 6px;
  margin-bottom: 16px;
  resize: vertical;
}

input[type=submit] {
  background-color: #e34234;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  width:100%;
}

input[type=submit]:hover {
  background-color: #ff4a3b;
}

.container1 {
  margin-left: 25%;
  margin-right: 25%;
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}

.container2 {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 15px;
  outline-color:black;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

input[type=radio]{
  margin: 5px 0;
}

/* Hide the browser's default checkbox */
.container2 input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

/* Create a custom checkbox */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 19px;
  width: 19px;
  background-color:silver;
}

/* On mouse-over, add a grey background color */
.container2:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.container2 input:checked ~ .checkmark {
  background-color: #2196F3;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the checkmark when checked */
.container2 input:checked ~ .checkmark:after {
  display: block;
}

/* Style the checkmark/indicator */
.container2 .checkmark:after {
  left: 7px;
  top: 4px;
  width: 2px;
  height: 6px;
  border: solid white;
  border-width: 0 3px 3px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
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
<h1>Parking Slot Request Form</h1>
<div class="content">
<div class="container1">
  <form method="post">
    <b><label for="fname">Unit ID</label></b>
    <input type="text" id="" name="unitid" value="<?php echo ($_SESSION['Unit'])?>" disabled="disabled" required="required">

	<div class="">
		<b><label>Types of Parking</label></b><br><br>
		<input class="" type="radio" required name="Type" value="Regular Car Slot">Regular Car Slot<br>
		<input class="" type="radio" required name="Type" value="Handicap Car Slot">Handicap Car Slot<br>			
    <input class="" type="radio" required name="Type" value="Regular Motor Slot">Regular Motor Slot<br>
    <input class="" type="radio" required name="Type" value="Handicap Motor Slot">Handicap Motor Slot<br>  
	</div><br><br>

	<input type="submit" value="Apply Now" name="submit">
  </form>
</div>
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
