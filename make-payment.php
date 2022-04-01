<?php
  // Create database connection
  include("connection.php");
  include("login-session.php");
  include("unit-session.php");
  include("retrieve.php");
  include("access-owner-tenant.php");
 

  if(isset($_GET["searchfid"])){
  	$financialid = $_GET['scripts'];
  	$fsql = "select *, financial_statement.ID as FID from financial_statement left join financial_type on financial_statement.Financial_type = financial_type.ID where financial_statement.ID = '$financialid';";
  	if(!$runF = mysqli_query($con, $fsql)){
  	echo "<script>alert('".mysqli_error($con)."')</script>";
  	} else {
  	$financialRow = mysqli_fetch_assoc($runF);
  	}
  }
  
  // If register button is clicked ...
  if (isset($_POST['submit'])) {
	$unitid = $_SESSION['Unit'];
  	$userid = $_SESSION['ID'];
  	$financialid = $_GET['scripts'];

    //$unitid = mysqli_real_escape_string($con, $_POST['Unit_ID']);
    //$userid = mysqli_real_escape_string($con, $_POST['User_ID']);  
    
    //$finid= mysqli_real_escape_string($con, $_POST['display']);
  	$paymentmethod = mysqli_real_escape_string($con, $_POST['Payment_Method']);
  	//$searchfid = mysqli_real_escape_string($con, $_POST['display']);
   		
	 $remarks = $_POST["remarks"];
	// Get image name
  	$image = $_FILES['image']['name'];
    $ext = pathinfo($image, PATHINFO_EXTENSION);
    $rename = date("Ymdhis").$session_unit;
  	  	
  	// image file directory
  	$target = "file/".$rename.".".$ext;
	
	if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
  		$msg = "Image uploaded successfully";
  	}else{
  		$msg = "Failed to upload image";
  	}
    //echo $msg;
  	$sql = "INSERT INTO payment (Payment_type, Attachment, Status, Unit_ID, User_ID, Financial_ID, Remarks) VALUES ('P02', '$target', 'Pending', '$session_unit', '$session_id', '$financialid', '$remarks');";    
  	// execute query
    if(!mysqli_query($con, $sql)){
      die("Error : ".mysqli_error($con));
    } else {
      echo'<script>alert("Successfully Submitted!");</script>';
    }
  	
    unset($searchfid);

  	}
?>

<!DOCTYPE html>
<html>
<head>
<title>UPTOWN | Payment</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/default.css">
<!--Web Icon & Font input-->
<script src="head-input.js"></script>
<style>
input[type=text], select, textarea, input[type=file] {
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
    <h1>Make Payment</h1>
    <div class="content">

<div class="container1">
  <form method="get" action="make-payment.php">
    <b><label for="fname">Unit ID</label></b>
    <input type="text" id="" name="unitid" value="<?php echo $_SESSION['Unit'];?>" disabled="disabled" required="required">
    
		<b><span class="">Select Your Financial ID</span></b>
<select class="" name="scripts" id="scripts">
<option value="" label="Select a financial id.." selected hidden></option>
		<?php 
		$res=mysqli_query($con,"select * from financial_statement where Unit_ID = '$session_unit' and Status = 'Not paid';");
		while($row=mysqli_fetch_array($res))
		{	
		echo "<option value='".$row["ID"]."'>".$row["ID"]."</option>";
		}
		
		?>
</select>	
		<input type="submit" id="searchfid" name="searchfid" value="Search"/>
		</form>
		
		<form method="POST" action="" enctype="multipart/form-data" id="last">
		<br>
	<div class="">
    <b><label for="fid">Financial ID</label></b>
    <input type="text" name="display" id="display" placeholder="" required="required" disabled="disabled" <?php if(isset($_GET["searchfid"])){echo "value='".$financialRow["FID"]."'";}?>>
    </div>	
    
	<b><label for="amt">Financial Type</label></b>
	<input type="text" disabled="disabled" <?php if(isset($_GET["searchfid"])){echo "value='".$financialRow["Type"]."'";}?>>
	<?php 

	if (isset($_GET['search'])) {
			$searchfid = mysqli_real_escape_string($con, $_POST['display']);
			$res1=mysqli_query($con,"select Type from financial_type Inner Join financial_statement on financial_type.ID = financial_statement.Financial_type WHERE financial_statement.ID = '$searchfid'");
				while($row=mysqli_fetch_array($res1))
			{
			?>
	
			<input type="text" id="selectfid" name="selectfid" placeholder="" required="required" disabled="disabled" value="<?php echo $row["Type"];?>">
	
			<?php
			}
			}
			?>

	
    <b><label for="amt">Amount</label></b>
    <input type="text" name="Amount" placeholder="" required="required" disabled="disabled"  <?php if(isset($_GET["searchfid"])){echo "value='".$financialRow["Amount"]."'";}?>>
	
	<div class="">
		<b><span class="">Payment Method</span></b>
		<select class="" name="Payment_Method" required="required">
			
			<option value="P02">Online Banking</option>
		</select>
	</div>
	
	<div class="">
	<b><label for="uploadfile">Add Attachment</label></b> &nbsp;&nbsp;
    <input type="file" name="image" required="required">
    </div>

    <div class="">
  <b><label for="remarks">Remarks</label></b>
    <textarea form="last" style="resize: none; width: 100%;" placeholder="Optional" name="remarks"></textarea>
    </div>
    
	<div class="">
	<br><br>

	<input type="submit" value="Apply Now" name="submit">
</form>
</div>
</article>
	<footer>
			<?php
			include("footer.php");
			?>
	</footer>
</div>
<script>
(function() {
    
    // get references to select list and display text box
    var sel = document.getElementById('scripts');
    var el = document.getElementById('display');


    function getSelectedOption(sel) {
        var opt;
        for ( var i = 0, len = sel.options.length; i < len; i++ ) {
            opt = sel.options[i];
            if ( opt.selected === true ) {
                break;
            }
        }
        return opt;
    }

    // assign onclick handlers to the buttons
    document.getElementById('searchfid').onclick = function () {
        el.value = sel.value;    
    }
        
}());
// immediate function to preserve global namespace</script>
</body>
</html>
