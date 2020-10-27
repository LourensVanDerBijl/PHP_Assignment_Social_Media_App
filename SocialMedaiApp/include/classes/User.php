<!-- woth this code I created a user class where I can pull the user information from
any of my pages where it is included on this page  -->
<?php
class User { //the user class
	private $user; //private class variable user
	private $con;	//the con variable as declare in db.php


	//This is the contructer that save all information on the user so that i can use it when I include the user file
	public function __construct($con, $user){
        $this->con = $con;
        $query = "SELECT * FROM `users` WHERE username='$user'";
		$user_details_query = mysqli_query($con,$query) or die(mysql_error());
        $this->user = mysqli_fetch_array($user_details_query);
     
	}

	 public function getUsername() { //part of the class I use this fuction to save the user log in instead of the session
		return $this->user['username'];
	}

	//This fuction is not part of the assignment but can be use to get the number of post that the user have post
	 public function getNumPosts() { 
       $username = $this->user['username'];
	   $query = "SELECT post FROM `users` WHERE username='$username'";
		$query1 = mysqli_query($this->con,$query);
		$row = mysqli_fetch_array($query1);
		return $row['post']; 
	}

	public function getFirstAndLastName() { //easy accessible fucntion that return the name and the surname of the user
        $username = $this->user['username'];
        $query = "SELECT name, surname FROM `users` WHERE username='$username'";
		$query_getUserFL = mysqli_query($this->con,$query);
		$row = mysqli_fetch_array($query_getUserFL);
		return $row['name'] . " " . $row['surname'];
	}




}

?>

