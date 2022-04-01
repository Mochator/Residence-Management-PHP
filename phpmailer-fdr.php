<?php
include("connection.php");
include("login-session.php");
//include("access-admin.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master\src\Exception.php';
require 'PHPMailer-master\src\PHPMailer.php';
require 'PHPMailer-master\src\SMTP.php';

$Email = $_GET['Email'];
$Subject = $_GET['Subject'];
$Sender = $_GET['Sender'];
$Receiver = $_GET["Receiver"];
$ID = $_GET['ID'];

$sendMail1 = false;
$sendMail2 = false;
//Retrieve receiver email success
$booOwner = false;
$booTenant = false;

$tenants = array();

//Retrieve receiver owner email
$ownerSql = "select * from unit left join user on unit.User_ID = user.ID where unit.ID = '$Receiver' and user.Account_status = 'Active';";
$runOwner = mysqli_query($con, $ownerSql);
if(mysqli_num_rows($runOwner) == 1){
  $ownerRow = mysqli_fetch_assoc($runOwner);
  $booOwner = true;
  $owner = $ownerRow["Email"]; //Owner email
}

//Retrieve content
$contentSql = "select Content from feedback_resident where ID = '$ID';";
$runContent = mysqli_query($con, $contentSql);
$contentRow = mysqli_fetch_assoc($runContent);
$content = $contentRow["Content"];
?>


<?php
//To Owner Receiver
if($booOwner == true){
$message = "Dear ".$Receiver.",\r\n\r\nA feedback is sent to you from your neighbour(s). \r\n\r\n\"".$content."\"\r\n\r\n\r\nYour sincerely,\r\nUPTOWN Residence Management";

/* Include the Composer generated autoload.php file. 
require 'C:\xampp\composer\vendor\autoload.php'; */

/* If you installed PHPMailer without Composer do this instead: */

/* Create a new PHPMailer object. Passing TRUE to the constructor enables exceptions. */
$mail = new PHPMailer(TRUE);
/*$mailid = $email;
$subject = "Test";
$text_message = "Hello";
$message = "Thank You for Contact with us.";
*/

//Send to receiver owner
try {
$mail->isSMTP();                            // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';             // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                     // Enable SMTP authentication
$mail->Username = 'assignmenttesting123@gmail.com';   // SMTP username
$mail->Password = 'Abc12345@@@';           // SMTP password
$mail->SMTPSecure = 'tls';                  // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                          // TCP port to connect to

   $mail->setFrom('assignmenttesting123@gmail.com', 'Uptown Resident Tenant Management');

   $mail->addAddress($owner, 'Receipient');

   $mail->Subject = 'UPTOWN Residence Feedback : '.$Subject;

   $mail->Body = $message;
              
   $mail->send();

   $sendMail1 = true;
}
catch (Exception $e)
{
   echo $e->errorMessage();
}
catch (\Exception $e)
{
   echo $e->getMessage();
}
} else {
  $sendMail1 = true;
}
?>

<?php
//Tenants
if($booOwner == true){

 //Retrieve receiver tenants email if any
$tenantSql = "select * from tenants inner join user on tenants.User_ID = user.ID where tenants.Unit_ID = '$Receiver' and user.Account_status = 'Active';";
$runTenants = mysqli_query($con, $tenantSql);
$tenantCount = mysqli_num_rows($runTenants);
if($tenantCount > 0){
  $i = 0;
  $booTenant = true;
  while($tenantRow = mysqli_fetch_assoc($runTenants)){
    $tenants[$i] = $tenantRow["Email"];
    $i++;
  }
} else {
  $booTenant = false;
}

//Retrieve tenants success
if($booTenant == true){

//To Receiver
$message = "Dear ".$Receiver.",\r\n\r\n A feedback is sent to you from your neighbour(s). \r\n \r\n\"".$content."\"\r\n\r\n\r\nYour sincerely,\r\nUPTOWN Residence Management";

/* Include the Composer generated autoload.php file. 
require 'C:\xampp\composer\vendor\autoload.php'; */

/* If you installed PHPMailer without Composer do this instead: */
//require 'PHPMailerAutoload.php';


/* Create a new PHPMailer object. Passing TRUE to the constructor enables exceptions. */
$mail3 = new PHPMailer(true);
/*$mailid = $email;
$subject = "Test";
$text_message = "Hello";
$message = "Thank You for Contact with us.";
*/
//Send to receiver tenants
  foreach($tenants as $tenant){
    try {

$mail3->isSMTP();                            // Set mailer to use SMTP
$mail3->Host = 'smtp.gmail.com';             // Specify main and backup SMTP servers
$mail3->SMTPAuth = true;                     // Enable SMTP authentication
$mail3->Username = 'assignmenttesting123@gmail.com';   // SMTP username
$mail3->Password = 'Abc12345@@@';           // SMTP password
$mail3->SMTPSecure = 'tls';                  // Enable TLS encryption, `ssl` also accepted
$mail3->Port = 587;                          // TCP port to connect to

   $mail3->setFrom('assignmenttesting123@gmail.com', 'Uptown Resident Tenant Management');

   $mail3->addAddress($tenant, 'Receipient');

   $mail3->Subject = 'UPTOWN Residence Feedback : '.$Subject;

   $mail3->Body = $message;
              
   $mail3->send();

   $sendMail2 = true;

}
catch (Exception $e)
{
   echo $e->errorMessage();
}
catch (\Exception $e)
{
   echo $e->getMessage();
}
}
} //Owner true
} else {
  $sendMail2 = true;
}
?>



<?php

if($booOwner == true) {
  $sql = "UPDATE feedback_resident SET Status = 'Approved' WHERE ID = '$ID'";
} else {
  $sql = "update feedback_resident set Status = 'Declined - No owner or tenants registered for that unit' where ID = '$ID'";
}

if($sendMail1 == true && $sendMail2 == true){
  if(!mysqli_query($con,$sql)){
    die('Error:'.mysqli_error($con));
  } else {
    echo "<script>alert('Resident Feedback Approved!');</script>";
    echo "<script>window.location.href='admin-panel.php';</script>";
  }
}

//echo'<script>alert("Feedback approved!");window.location.href = "admin-panel.php";</script>';

mysqli_close($con);
?>









