<?php
  // Create database connection
  include("connection.php");
  include("login-session.php");
  include("retrieve.php");
  include("unit-session.php");
 include("access-owner-tenant.php");

  // Initialize message variable
  $msg = "";
  
  // If register button is clicked ...
  if (isset($_POST['submit'])) {
  	$unitid = $_SESSION['Unit'];
	$userid = $_SESSION['ID'];
    $subject = mysqli_real_escape_string($con, $_POST['Subject']);
    $email = mysqli_real_escape_string($con, $_POST['Email']);  
   	$content = mysqli_real_escape_string($con, $_POST['Content']);

  	$sql = "INSERT INTO feedback_management (Subject, Email, Content, Unit_ID, Status) VALUES ('$subject', '$email', '$content','$unitid', 'Pending');";    
  	// execute query
  	mysqli_query($con, $sql);
  	echo'<script>alert("Submitted Successfully!");
  	</script>';
  	}
?>

<!DOCTYPE html>
<html>
<head>
<title>UPTOWN | Management Feedback</title>
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

input[type=email], select, textarea {
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
  background-color: #E34234;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  width:100%;
}

input[type=submit]:hover {
  background-color: #FF4A3B;
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
<h1>Send Feedback to Us</h1>

<div class="content">
<div class="container1">
  <form method="post">
    <b><label for="">Subject</label></b>
    <input type="text" id="" name="Subject" value="" required="required" placeholder="Write a subject..">

	<b><label for="">Email</label></b>
    <input type="email" id="" name="Email" value="" required="required" placeholder="Enter your email..">

	<div class="">
		 <b><label for="">Your Message</label></b>
		<textarea class="" style="font-family:Arial, Helvetica, sans-serif; height:200px" name="Content" placeholder="Your Message" required="required"></textarea>
	</div>


<br>
	<input type="submit" value="Submit" name="submit">
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

<script>
		function showNumPax()
		{
		document.getElementById("numpax").style.display = "block";
		}
</script>

</body>
</html>
