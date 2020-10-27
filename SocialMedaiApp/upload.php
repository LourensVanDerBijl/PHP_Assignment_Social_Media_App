<?php
session_start();
include("include/classes/User.php"); //including the user.php file to use all the information about the user loged in
$target_dir = "uploads/"; //providing the path where the picture needs to be save
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]); //creating a new picture file with the above values
$uploadOk = 1; // if the upload is success this should remain 1 if fail go to 0
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Validating the image file
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image. <br><br> <a href = 'dashboard.php'> Back to Site </a>";
    $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists. <br><br> <a href = 'dashboard.php'> Back to Site </a>";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
  echo "Sorry, your file is too large. <br><br> <a href = 'dashboard.php'> Back to Site </a>";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed. <br><br> <a href = 'dashboard.php'> Back to Site </a>";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded. ";
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "register";
    $profile_pic = htmlspecialchars( basename( $_FILES["fileToUpload"]["name"]));
    $uploadingUser = $_POST['uploadingUser'];
//This code was used to demostrate my ability to write the code with out the use of the db.php file (inheritance)


    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    // The update query where the picture name is being saves
    $sql = "UPDATE users SET profile_pic='".$profile_pic."' WHERE username='$uploadingUser'";
    
    if ($conn->query($sql) === TRUE) {
      echo "Record updated successfully <br><br> <a href = 'dashboard.php'> Back to Site </a>";
     
    
    } else {
      echo "Error updating record: " . $conn->error;
    }
    
    $conn->close();

  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}
?>