<?php
    session_start();

    //connecting this page to the database via a seperate connection page db.php
    require('db.php'); 
?>

<!DOCTYPE html>
<html>
    
    <head>
        <meta charset="utf-8">
        <title>Social Degree Registration</title>
        <link rel="stylesheet" href="css/style.css" /><!--connecting to the style.css stylesheet-->
    </head>

<body class="wrapper"><!--this wrapper is being styled in the style.css stylesheet-->
    
<?php // starting my php in the body to get the details in the post form
	
    // If form submitted, insert values into the database.
    if (isset($_REQUEST['username'])){
        
        $username = stripslashes($_REQUEST['username']); // removes backslashes
		$username = mysqli_real_escape_string($con,$username); //escapes special characters in a string
        // the username variable is connected to my con (connection) variable as declared in the db.php page

        $email = stripslashes($_REQUEST['email']); // removes backslashes
        $email = mysqli_real_escape_string($con,$email); //escapes special characters in a string
        // the email variable is connected to my con (connection) variable as declared in the db.php page
        
        $password = stripslashes($_REQUEST['password']); // removes backslashes
        $password = mysqli_real_escape_string($con,$password); //escapes special characters in a string
        // the password variable is connected to my con (connection) variable as declared in the db.php page
        
        $name = stripslashes($_REQUEST['name']); // removes backslashes
        $name = mysqli_real_escape_string($con,$name); //escapes special characters in a string
        // the name variable is connected to my con (connection) variable as declared in the db.php page

        $surname = stripslashes($_REQUEST['surname']); // removes backslashes
        $surname = mysqli_real_escape_string($con,$surname); //escapes special characters in a string
        // the surname variable is connected to my con (connection) variable as declared in the db.php page

        $age = stripslashes($_REQUEST['age']); // removes backslashes
        $age = mysqli_real_escape_string($con,$age); //escapes special characters in a string
        // the age variable is connected to my con (connection) variable as declared in the db.php page

        $gender = stripslashes($_REQUEST['gender']); // removes backslashes
        $gender = mysqli_real_escape_string($con,$gender); //escapes special characters in a string
        // the gender variable is connected to my con (connection) variable as declared in the db.php page

        $country = stripslashes($_REQUEST['country']); // removes backslashes
        $country = mysqli_real_escape_string($con,$country); //escapes special characters in a string
        // the country variable is connected to my con (connection) variable as declared in the db.php page

        $city = stripslashes($_REQUEST['city']); // removes backslashes
        $city = mysqli_real_escape_string($con,$city); //escapes special characters in a string
        // the city variable is connected to my con (connection) variable as declared in the db.php page

        

        $trn_date = date("Y-m-d H:i:s"); //Automatic  date function by php that get the current date and time
        
        //This is my SQL query to add the values to the column in my users table note that ID is not included due to primary key and auto increasement.. 
        //The md5 infront of password is to enrypt the password 
        $query = "INSERT into users (username, password, email, name, surname, age, gender, country, city, profile_pic, post, trn_date) 
        VALUES ('$username', '".md5($password)."', '$email', '$name', '$surname', '$age', '$gender', '$country', '$city', 'default.JPG','0', '$trn_date')";
        
        // with result I combine the SQL query with the connection variable as defined in db.php
        $result = mysqli_query($con,$query);
        if($result){
            echo "<div class='form'><h3>You are registered successfully.</h3><br/>Click here to <a href='login.php'>Login</a></div>";
        }
    }else{ 
?>

<!-- This is the html registration form.
That is being used by the post method to obtain the information and insert it 
into the database. 
By carefully declaring the input type field  and marking it as required,
I also added some form validation features. -->
<div class="form">
    <h1>Registration</h1>
        <a href="login.php">Already a member click here!</a> <!--allowing the user to return to the login form-->

    <form name="registration" action="" method="post">
        <input type="text" name="username" placeholder="Username" required />
        <input type="email" name="email" placeholder="Email" required />
        <input type="password" name="password" placeholder="Password" required />
        <input type="text" name="name" placeholder="Name" required />
        <input type="text" name="surname" placeholder="Surname" required /> <br><br>
        <input type="number" name="age" placeholder="Age" required /> <br> <br>
        
        <select name="gender" id="gender" required>  
            <option value="Defualt">Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select> <br>
        
        <input type="text" name="country" placeholder="Country" required />
        <input type="text" name="city" placeholder="City" required/><br><br>
        <label>Add a profile picture on settings Tab</label>
        
        <input type="submit" name="submit" value="Register" />
    </form>
</div>

    <?php } ?>

</body>

</html>
