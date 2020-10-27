<?php
require('db.php'); //including my connection to the database page
include("header.php"); //including the header that will apear on the top of the page
include("include/classes/User.php"); //including the user.php to allow easy access for user information
?>

<!--Take note that because this section falls below the header.php the styling of this page will also be done in hstyle.css -->
<div class="user_detail_column">

    <!--creating the table that allows a user to write posts-->
    <table class="profile_table">
        <tr>
            <td class = "user-column"><a href = "<? echo $userLoggedIn; ?>" class="user_pic"> <img src="uploads/<?php echo $user['profile_pic'];?>"
             height ="150" width= "150"></a><br>
                <?php echo $user['name']." ".$user['surname'];?><br> <!--obtaining this information from the user class-->
                Gender: <?php echo $user['gender'];?> <br> <!--obtaining this information from the user class-->
                Age: <?php echo $user['age'];?> <br> <!--obtaining this information from the user class-->
                <button><a href = "update.php" class = "changelink">Change</a></button>
        
            </td>
            <td class = "user-post"><br>
                <!--Using the post method to save the text that the user input in the text field to insert it into the database -->
                <form class = "post_form" action = " " method="POST">
                    <textarea name="post_text" id = "post_text" placeholder = "Want to post something??" class="post_tarea" required></textarea>
                    <input type="submit" name="submit_post" value="posting" class="post_button">
                </form>
            
            <?php  //starting the php code to input the post into the database
                require('db.php'); //connecting to the database via db.php
                
                //if the textbox for post is filled out(dont allow users to post nothing)
                if(isset($_REQUEST['post_text'])){
                    $userPost = $_POST['post_text'];
                    $userPost = stripslashes($_REQUEST['post_text']); // remove backslaches
                    $userPost = mysqli_real_escape_string($con,$userPost); //remove all special characters
                    $datePost = date("Y-m-d H:i:s"); //php fucntion to save the date and time of the post to display it from newest to oldest
                    $added_by_name = $user['name']; //adding the user that made the post via the user class
                    $added_by_surname = $user['surname']; //adding the user surname that made the post via the user class
                    $user_pic = $user['profile_pic']; // adding the profile pic of the user that made the post via the user class

                    //insterting all the information regarding the post into the database under the post table
                    $query = "INSERT into posts (username, body, added_by_name, added_by_surname, date_added, user_closed, deleted, post_pic) 
                    VALUES ('$userLoggedIn','$userPost', '$added_by_name', '$added_by_surname', '$datePost', 'no', 'no', '$user_pic' )";
                    $result = mysqli_query($con,$query);
                if($result){
                    echo "<h3>Post added to your profile";
                }
                }else{
                }
        ?>
            </td>
        </tr>
    </table><br><br>
</div>

<!-- creating the table and div class where all the post of the entire database will be displayed-->
<div class = the_posts>
    <table class = "post_table">
<?php 
    //no need to include the database connection cause it has already been included above 
    $sql = "SELECT * FROM posts ORDER BY date_added DESC;";
    $result = mysqli_query($con, $sql);
    $resultCheck = mysqli_num_rows($result);//using php row fuction to obtain the amount of row and their data in it

        //The row fuction basically makes a class of each row of the data obtain
        if($resultCheck > 0) { //if the rows are more than 1 their is post that can be recalled if 0 there is no posts in the database
            while ($row = mysqli_fetch_assoc($result)) { 
                echo "<tr class='post_row'>
                    <td class = 'post_pic' >
                        <img src='uploads/".$row['post_pic']."' height=150 width=150 /></td>
                    <td class= 'post_user'>
                        <h4>".$row['added_by_name']." ".$row['added_by_surname']."</h4>".$row['date_added']."</td>
                    <td class='post_text'>
                        <h3>".$row['body']."</h3></td></tr>";
                
                // because I want to print all the post I will use a while statement, while there still is some post keep printing
                //while row is more that 0 print each line in its own row in this table
                //and using the small post class that I created with the php row fucntion
            }
        }


?>
    </table>
</div>
</div> <!--closing the div that started in my header.php file-->

</body>
</html>
