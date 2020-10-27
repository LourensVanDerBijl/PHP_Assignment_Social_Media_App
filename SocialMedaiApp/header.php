<!--This is my header file in also form a sort of class meaning i can use this code on 
multiple pages. on every page I will include the header that indicate the user loged in
and the avaliable mune bar for the user-->

<?php
session_start(); //pulling the username for the session variable on log in to save it as the user loged in
require('db.php'); // using my connection page to connect to the database

    if(isset($_SESSION['username'])){ //Sesion obtain from the login.php page
        $userLoggedIn = $_SESSION['username'];  // user that is not log in will be redirected

        //with this query I used the sesion variable to search for the users details in the database
        $query = "SELECT * FROM `users` WHERE username='$userLoggedIn'";
        $user_details = mysqli_query($con,$query) or die(mysql_error());
        $user = mysqli_fetch_array($user_details, MYSQLI_ASSOC);
    
    // if not found redirect the user to the login page (maybe when the sesion has cleared)
    } else {
        header("Location: login.php");
    }
    // creating a search option to view other users or his own page
    if (isset($_GET['search'])){
        header("Location: profile.php");
        
     }
?>


<html>
<head>
    <title>Welcome to Social Degree</title>
    <link rel="stylesheet" href="css/hstyle.css"/>
</head>
 <body>
     <div class = "top-nav-bar">
         <div class="logo">
             <a href = "dashboard.php"> <img src="images/logoNn.png" alt="Logo" width = "300" height = "40"> </a>
             
             
         </div>

        <nav> 
            <!--form for the search box allowing users to search for one another-->
            <form action="profile.php" method="post"  class = "topnav">
                <input type="text" name="search" placeholder="Search by name" >
                <input type= "submit" value = "Search user">
            
            </form>
         
         
         
            <!--The navigation bar menu's-->
            <a href = "#" class = "user"> <?php echo $user['name']." ". $user['surname']; ?> <img src="images/user.png" alt="Logo" width = "40" height = "30" class="icons"> </a>
            <a href = "messageSystem.php"> <img src="images/mesage.png" alt="mesenger" width = "40" height = "30" class="icons"> </a> 
            <!-- will take yhe user to its inbox and outbox-->

            <a href = "#"> <img src="images/notification.png" alt="notification" width = "40" height = "30" class="icons"> </a>
            <!--This was not part of the assignment but give the pages more look--> 

            <a href = "update.php"> <img src="images/maintenance.png" alt="setings" width = "40" height = "30" class="icons"> </a> 
            <!-- will take the user to his setings page to update his details-->

            <a href = "logout.php"> <img src="images/on-off-button.png" alt="Logout" width = "40" height = "30" class="icons"> </a> 
            <!-- User Logout and also destroy the session-->
         </nav>

<!-- please notice that the div class is starting on the header.php and ending on the dashboard.php same goes for the messaging pages
This is to connect the header page with all the other pages-->


    </div>
    <div class="wrapper">
        
    





