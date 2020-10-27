<?php
    session_start();
    include("header.php"); //including the header that will apear on the top of the page
    include("include/classes/User.php");

    //connecting this page to the database via a seperate connection page db.php
    require('db.php'); 
    
?>



<body ><!--this wrapper is being styled in the style.css stylesheet-->
<div class = "form-update">
<h2>User Details update</h2>

<Label>Change Password: </Label> <a href = "reset.php">Click here </a>
<br><br> <!--Redirect the user to the password recover page that allows a user change his/her password-->

<div class = "personal_info">
<form method="post" action="update.php" name="UpdateName">
<br>
<Label>Change Name: </Label> <input type="text" name="UName" value = "<?php echo $user['name']; ?>"> <br><br>
<Label>Change Surname: </Label> <input type="text" name="USurname" value = "<?php echo $user['surname']; ?>"><br><br>
<Label>Change Age: </Label> <input type="number" name="UAge" value = "<?php echo $user['age']; ?>"><br><br>
<Label>Change Gender: </Label> <input type="text" name="UGender" value = "<?php echo $user['gender']; ?>"><br><br>
<Label>Change Country: </Label><input type="text" name="UCountry" value = "<?php echo $user['country']; ?>"><br><br>
<Label>Change City: </Label> <input type="text" name="UCity" value = "<?php echo $user['city']; ?>"><br><br>
 
 
<br><input type ="submit" name="UpSurname" value = "Update" class="updateInfo" >
<h6>Please refresh to see updates</h6>


 <!--<input type ="submit" name="UpSurname" value = "Update" class="updateInfo">-->
</form><br>
<?php 
require ('db.php'); //connecting to the database with the db.php page
$updateName = $_POST['UName']; //declaring a variable from the POST method
$updateSurname = $_POST['USurname']; //declaring a variable from the POST method
$updateAge = $_POST['UAge']; //declaring a variable from the POST method
$updateGender = $_POST['UGender']; //declaring a variable from the POST method
$updateCountry = $_POST['UCountry']; //declaring a variable from the POST method
$updateCity = $_POST['UCity']; //declaring a variable from the POST method

//my SQL statement to update the database
$sqlName = "UPDATE users SET name='".$updateName."', surname = '".$updateSurname."' , age = '".$updateAge."', gender = '".$updateGender."', country = '".$updateCountry."', city = '".$updateCity."'  WHERE username='$userLoggedIn'";
//because I used value instead of placeholders the statement will run even if the user only update one of the fields



//connecting the database con variable on the db.php page to the sql query above
if ($con->query($sqlName) === TRUE) {
    echo "";
    
    $con->close();
    
  } else {
    echo "" . $conn->error;
    $con->close(); //closing the connection to allow another update
  }
  ?>
</div>

<form method="post" action="upload.php" name="UpdateProfilePicture" enctype="multipart/form-data">
<br> <!--creating a form to upload image enctype ="multipart/form-data" that allows any form of file in this form  -->
<Label>Change Profile Picture: </Label> <input type="file" name="fileToUpload" id="fileToUpload"> <input type ="submit" name="UpProfilePic" value = "Update" class="updateInfo">
<!--hidden value to save to who the profile pic belongs to -->
<input type = "hidden" name= "uploadingUser" value = "<?php echo $user['username']; ?>">
</form><br>


</div>
</body>

</html>
