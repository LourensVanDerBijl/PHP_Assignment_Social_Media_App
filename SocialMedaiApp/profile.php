<!--When a user search for another user we will be displaying all the post made by that
user. In the header.php file we offer a search that can be used to be redirected to this page
where the user being search information and posts will be displayed. 
also on this page we will allow a user to search for another user and sent him / her an online
message-->
<?php
    session_start(); //start the sesion of the user loged in we wil be using it to sent messages
    require('db.php'); //including the database connection page
    include("header.php"); //including the header so we can see to person currently loged in
    include("include/classes/User.php"); //including the user class (user.php) to use the information of the user loged in 
    $userProfile = $_POST['search']; //obtaining the information that was entered in the search box
?>

<!-- The table for the details of the user being search-->
<div class="user_detail_column">
<body>

<div class = "viewProfile">
    <table class = "beingView" >
        <?php 
            //searching the database for the users being search for
            $sql = "SELECT * FROM users WHERE name= '$userProfile'";
            $result = mysqli_query($con, $sql);
            //obtaining all that information with the php row function (we will be using it as a class also)
            $resultCheck = mysqli_num_rows($result);

        if($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            //while row is equal to data from the query print the following table rows and columns
            //we are using the class of the php row function to obtain the data in the rows $row['the column we are looking for']
            echo "<h1 class='private_profile_heading'>This is the profile page of:</h1>
              <tr>
                <td class='private_profile_IMG'>
                  <img src='uploads/".$row['profile_pic']."' height=150 width=150 /></td>
                <td class='private_profile_details'>
                  <h2>".$row['name']." ".$row['surname']."</h2>
                  Gender: <b>".$row['gender']."</b><br>
                  Age: <b>".$row['age']."</b><br>
                  Country: <b>".$row['country']."</b><br>
                  City: <b>".$row['city']."</b><br>
                  User since: <b>".$row['trn_date']."</b></td>
                


                <td class='private_profile_messaging'>
                <form action='messageSystem.php' method='post'  class = 'messenger'>
                    <textarea name='messageSent' placeholder = 'Type message to ".$row['name']."' class = 'messageSent'></textarea>
                    <input type = 'hidden' name='sent_to_name' value ='".$row['name']."'>
                    <input type = 'hidden' name='sent_to_surname' value ='".$row['surname']."'><br>
                    <input type= 'submit' value = 'Sent Message'>
                </form></td>";

                //with the form above I added the feature to do online messages where a user can search for a profile and sent them a message
                //This form is of post method where the information will be sent to the messageSystem.php page where all the messages will be displayed
            }
        }
        ?>
</table>
</div>


<!--once the user have search for another users I will be querying al the post from the user that is being searched and display it on this page-->
<div class = "viewProfile_Post">
<table class="beingView_Post">

<?php  
    //Search for all the post from the table post where the user being search is the user that added the post
    $sql = "SELECT * FROM posts WHERE added_by_name = '$userProfile'";
    $result = mysqli_query($con, $sql);
    $resultCheck = mysqli_num_rows($result);
    //The results must be pulled with the php row fuction so that the data can be displayed in a class manner

        if($resultCheck > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr class='post_row'>
                    <td class = 'post_pic' >
                        <img src='uploads/".$row['post_pic']."' height=150 width=150 /></td>
                    <td class= 'post_user'>
                        <h4>".$row['added_by_name']." ".$row['added_by_surname']."</h4>".$row['date_added']."</td>
                    <td class='post_text'>
                        <h3>".$row['body']."</h3></td></tr>";
            }
        }


?>
</div>
</div>
</div>

</body>
</html>
