<?php

?>
<html>
	<head>
		<title>Reset Password - Social Degree</title>
		<link rel='stylesheet' href='css/style.css' type='text/css' media='all' />
	</head>

<body>
	<?php
		require('db.php'); //including the connection to the database on db.php
		session_start();

		// If form submitted, insert values into the database.
		if (isset($_POST['email'])){
			
			$email = stripslashes($_REQUEST['email']); // remove spaces
			$email = mysqli_real_escape_string($con,$email); //remove special characters in a string
			$NewPassword = stripslashes($_REQUEST['NewPassword']); // remove spaces
			$NewPassword = mysqli_real_escape_string($con,$NewPassword); //remove special characters in a string
			
		//Checking is user existing in the database or not
			$query = "UPDATE users SET password='.md5($NewPassword)' WHERE email = $email";
			$result = mysqli_query($con,$query) or die(mysql_error()); //if the querry suceed .. proceed if not die the connection
			$rows = mysqli_num_rows($result); //using the php row function to determine whether the is a record with this email adress
			
			//if row is equal to 1 it means that a record has been found and has been updated
			if($rows==1){
				$_SESSION['email'] = $email;
				header("Location: login.php"); // Redirect user to login.php
				//if the email is found and has been updated the user will be redirected to the login.php page

			}else{ // if no rows has been found then nothing will be updated cause the email does not exist
				echo "<div class='form'><h3>User Not found.</h3><br/>Click here to <a href='login.php'>Login</a></div>";
					}
	}else{



	?>
<div class="form">
	<h1>Social degree</h1>
	<h1>Reset Password</h1>

<form action="" method="post" name="login">
	<input type="text" name="email" placeholder="Account Email" required />
	<input type="password" name="NewPassword" placeholder="New Password" required />
	<input name="submit" type="submit" value="Change Password" />
</form>

		<p>Not registered yet? <a href='registration.php'>Register Here</a></p>
		<p>Back to Log in? <a href='login.php'>Log in Here</a></p>


</div>
		<?php } ?>


</body>
</html>