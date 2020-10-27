<?php
//starting a session variable to keep the username to use it in the dashboard.php
session_start();
?>


<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>Login</title>
		<link rel="stylesheet" href="css/style.css" /><!--connecting to the style.css stylesheet-->
</head>

<body class = "wrapper">

<?php //starting php commands in my body tag to obtain details about exsisting users

	//connecting this page to the database that is on db.php (db = database)
	require('db.php');
	
	$_SESSION['username'] = $username; //creating the username session for my dashboard.php
	
	// If form submitted, start the query to see if the user exist
    if (isset($_POST['username'])){
		
		$username = stripslashes($_REQUEST['username']); // remove spaces
		$username = mysqli_real_escape_string($con,$username); //remove special characters in a string
		// combining the con variable on db.php with the username variable

		$password = stripslashes($_REQUEST['password']); // remove spaces
		$password = mysqli_real_escape_string($con,$password); //remove special characters in a string
		// combining the con variable on db.php with the password variable
		
		//Checking is user existing in the database or not
		$query = "SELECT * FROM `users` WHERE username='$username' and password='".md5($password)."'";
		//with the md5 I am encrypting the password entered also to match it with the already encrypted one in the database

		//result is the SQL query with the connection variable (db.php) and the query above
		$result = mysqli_query($con,$query) or die(mysql_error());

		//using a SQL fuction that will count the rows where the query aplies
		$rows = mysqli_num_rows($result);
		
		// if the rows return is 1 then the user exist and we will proceed to the dashboard.php
		if($rows==1){
			$_SESSION['username'] = $username; //recalling the session variable of the text in the username field, and re-declaring it
			header("Location: dashboard.php"); // Redirect user to dashboard.php
        }else{ //if the variable rows return 0 is means that the user does not exist
			echo "<div class='form'><h3>Username/password is incorrect.</h3><br/>Click here to <a href='login.php'>Login</a></div>";
			}
    }else{



?>
	<div class="form">
		<h1>Social Degree</h1>
		<h1>Log In</h1>

		<form action="" method="post" name="login">
			<!--required field has been added to ensure that the user do not subit and empty request -->
			<input type="text" name="username" placeholder="Username" required />
			<input type="password" name="password" placeholder="Password" required />
			<input name="submit" type="submit" value="Log in" />
		</form>

			<p>Not registered yet? <a href='registration.php'>Register Here</a></p>
			<p>Forgot Password? <a href='passwordRec.php'>Recover Here</a></p>
			<!--Form design with the post method to hide any information in the case of attackers.
			With the options for users to register if they do not have an account and also if they had forgotten their passwords. 
			On both an href had been design that will take you to the page to -->
	</div>
	
<?php } ?>


</body>
</html>
