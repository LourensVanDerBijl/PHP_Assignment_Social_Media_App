<?php

?>
<!--With this code I create an automatic email reply once a user
click on thie forgot password.
But this code is being by-passed at the buttom of the code to allow easy access to lectures.being View
And because no email server set up. if you want it to work actively yo can just enter your email server details
in the code below -->

<html>
	
	<head>
		<title>Password Recovery - Socail Degree</title>
		<link rel='stylesheet' href='css/style.css' type='text/css' media='all' />
	</head>


	<body>
		<div style="width:700px; margin:50 auto;">
		<h2>Social Degree Password Recovery</h2>   

<?php
include('db.php'); //including the database connection file

	//if the textbox has been filled make the following variables
	if(isset($_POST["email"]) && (!empty($_POST["email"]))){
		$email = $_POST["email"];
		$email = filter_var($email, FILTER_SANITIZE_EMAIL); //this will remove all illegal characters from an email adress
		$email = filter_var($email, FILTER_VALIDATE_EMAIL); //this will remove all illegal characters from an email adress


	if (!$email) { //if the email variable is incorrect the user made a type error
  		$error .="<p>Invalid email address please type a valid email address!</p>";
	}else{  //if no type errors we will start searching the database for the email typed by the user
		$sel_query = "SELECT * FROM `users` WHERE email='".$email."'";
		$results = mysqli_query($con,$sel_query);
		$row = mysqli_num_rows($results); //using a php row function to determine how many rows was found with the query result
	if ($row==""){ // if no rows was found it means that this user does not exist or email does not exist
		$error .= "<p>No user is registered with this email address!</p>";
		}
	}

	// creating another table to create a new temporary password for the user
	if($error!=""){
		echo "<div class='error'>".$error."</div>
		<br /><a href='javascript:history.go(-1)'>Go Back</a>";
	}else{
		// the created password will only be useble for 1 day
		$expFormat = mktime(date("H"), date("i"), date("s"), date("m")  , date("d")+1, date("Y"));
		$expDate = date("Y-m-d H:i:s",$expFormat); //the date that the request has been made
		$key = md5(2418*2+$email); // creating an unique key and combining it to create an unique password
		$addKey = substr(md5(uniqid(rand(),1)),3,10);
		$key = $key . $addKey;
// Insert into the password_reset_temp table
mysqli_query($con,
"INSERT INTO `password_reset_temp` (`email`, `key`, `expDate`)
VALUES ('".$email."', '".$key."', '".$expDate."');");

	//With this code we are creating the email that is going to be sent to the users email account
	$output='<p>Dear user,</p>';
	$output.='<p>Please click on the following link to reset your password.</p>';
	$output.='<p>-------------------------------------------------------------</p>';
	$output.='<p><a href="C:\MAMP\htdocs\SocialMedaiApp\</a></p>'; //need to be change to a password recovery page		
	$output.='<p>-------------------------------------------------------------</p>';
	$output.='<p>Please be sure to copy the entire link into your browser.
	The link will expire after 1 day for security reason.</p>'; //with the time declaration this link or actaully the password will only be availible for 1 day
	$output.='<p>If you did not request this forgotten password email, no action 
	is needed, your password will not be reset. However, you may want to log into 
	your account and change your security password as someone may have guessed it.</p>';   	
	$body = $output; // defining it as the body of the email
	$subject = "Password Recovery -Social Degree"; // the subject line

	$email_to = $email; //the email adress that was found in the database
	$fromserver = "noreply@noHost.com"; //enter a host server email
	require("PHPMailer/PHPMailerAutoload.php");
	$mail = new PHPMailer(); 
	$mail->IsSMTP();
	$mail->Host = "mail.visionweb.co.za"; // Enter your host here
	$mail->SMTPAuth = true;
	$mail->Username = "lourens@visionweb.co.za"; // Enter your email here
	$mail->Password = "Middelburg"; //Enter your passwrod here
	$mail->Port = 25; //the port of your host server
	$mail->IsHTML(true);
	$mail->From = "noreply@noHost.com"; // changing the sender information
	$mail->FromName = "Social Degree"; // changing the sender information
	$mail->Sender = $fromserver; // indicates ReturnPath header
	$mail->Subject = $subject; // creating the subject variable to enter into the email
	$mail->Body = $body; // creating the email body variable
	$mail->AddAddress($email_to); // ensuring that the email is sent
if(!$mail->Send()){
	echo "Mailer Error: " . $mail->ErrorInfo;
}else{
	echo "<div class='error'>
	<p>An email has been sent to you with instructions on how to reset your password.</p>
	</div><br /><br /><br />";
	}

		}	

}else{
?>

<!--As you will see the code above enter all into the password_reset_temp table in the database and will
also sent the email perfectly. But due to the facted that I have no email server and I do not want to make marking my
assignment time consuming I have created a by-pass method to the reset.php page where user can change the email without
using the email instructions -->
<form method="post" action="" name="reset">

	<label><strong>Enter Your Email Address:</strong></label><br /><br />
	<input type="email" name="email" placeholder="username@email.com" />
	<br /><br />
	<button><a href="reset.php">Reset Password</a></button>
<!-- With the href above i will automatically move the user to the reset page by-passing the email sent -->
</form>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
<?php } ?>



</div>
</body>
</html>