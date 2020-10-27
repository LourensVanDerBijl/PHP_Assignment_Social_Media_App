<?php

//The connection is to localhost username is root and password is root and connecting to register database
$con = mysqli_connect("localhost","root","root","register");
	if (mysqli_connect_errno()){ //connecting to the database if fail is will echo the error
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
		die();// if the connection fail it will also die all the attempted connections
		}

date_default_timezone_set('Africa/Harare');	
$error="";	//seting the time zone to south africa time and creating and error variable if error happens
?>

<!--This page is intended as a class so that I do not have to write this code on every page I can just include it-->