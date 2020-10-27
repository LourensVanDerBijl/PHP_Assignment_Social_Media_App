<!--when a user sent a message or click on the message icon he should be redirected to this page
on this page I will be displaying the inbox and the outbox of the user the message he has sent and
the message he has recieved-->
<?php
    session_start(); //sesion to know what user is currenly logged in
    require('db.php'); //connecting this page to the database via db.php
    include("header.php"); // adding the header file
    include("include/classes/User.php"); //including the user.php file to use all the information about the user loged in

        if(isset($_REQUEST['messageSent'])){ //before I add a message to the database insure that there is a message to add
            $userMessage = $_POST['messageSent']; //via the post method obtain the data in the text area
            $userMessage = stripslashes($_REQUEST['messageSent']); // remove backslaches
            $userMessage = mysqli_real_escape_string($con,$userMessage); //remove all special characters
            $dateSent = date("Y-m-d H:i:s"); //declare a variable for the current date and time to know when the message was sent
            $name_from = $user['name']; //variable for the sender of the message using the user.php class
            $surname_from = $user['surname']; //variable for the sender of the message using the user.php class
            $name_to = $_POST['sent_to_name']; //declaring a variable for the reciever of the message using the post method in the search box
            $surname_to = $_POST['sent_to_surname']; //declaring a variable for the reciever of the message using the post method in the search box
            $sender_pic = $user['profile_pic']; //adding the senders profile pic

            //the insert query to insert the message into the database
            $query = "INSERT into messaging (name_from, surname_from, name_to, surname_to, message_sent, date_send, Sender_pic) 
            VALUES ('$name_from','$surname_from', '$name_to', '$surname_to', '$userMessage', '$dateSent', '$sender_pic')";
            $result = mysqli_query($con,$query);
            if($result){ // if sent was successfull add a message to inform the user
                echo "<h3>Message sent</h3>";
                
            
            }
        }else{
        }
?>

<div class="user_detail_column">

<body>
    <div class = "split left"> <!--method use to split the screen as styled on hstyle.css-->
        
    <table class = 'messaging_system'><!--Table to display the messages-->
            <tr>
                <td class='inbox_heading' colspan = "3"><h2>Inbox</h2></td><!--creating a heading that span across 3 columns-->
            </tr>
                <?php  
                    $userLogedIn = $user['name']; //variable for who is currenly loged in

                    // SQL query to retrieve the message where the message belongs to the user that is loged in
                    $sql = "SELECT * FROM messaging WHERE name_to = '$userLogedIn' ORDER BY date_send DESC;";
                    $result = mysqli_query($con, $sql); //connecting the connection to the query
                    $resultCheck = mysqli_num_rows($result);//displaying it with the php row function

                        if($resultCheck > 0) {
                            while ($rows = mysqli_fetch_assoc($result)) {
                                echo "<tr>
                                        <td class= 'inbox_details'>
                                            From: ".$rows['name_from']." ".$rows['surname_from']."<br>
                                            To:  ".$rows['name_to']." ".$rows['surname_to']."<br>
                                            Date: ".$rows['date_send']."</td>
                                        <td class='inbox_message'>
                                            ".$rows['message_sent']."<br></td>
                                        <td class='inbox_pics'>
                                            <img src='uploads/".$rows['Sender_pic']."' height=80 width=80 /> </td>";   
                             }
                        }
                ?>
</table>
</div>

<!--split screen method for the outbox side of the screen-->
<div class = "split right">
    <table class = 'messaging_system'>
        <tr>
            <td class='inbox_heading' colspan = "3"><h2>Outbox</h2></td> <!--creating a heading that span across 3 columns-->
        </tr>
            <?php 
                $userLogedIn = $user['name']; //variable for who is currenly loged in

                 // SQL query to retrieve the message where the message belongs to the user that is loged in
                $sql = "SELECT * FROM messaging WHERE name_from = '$userLogedIn' ORDER BY date_send DESC;";
                $result = mysqli_query($con, $sql); //connecting the connection to the query
                $resultCheck = mysqli_num_rows($result); //displaying it with the php row function

                    if($resultCheck > 0) {
                        while ($rows = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                            <td class= 'outbox_details'>
                                To:  ".$rows['name_to']." ".$rows['surname_to']."<br>    
                                From: ".$rows['name_from']." ".$rows['surname_from']."<br>
                                Date: ".$rows['date_send']."</td>
                            <td class='outbox_message'>
                                ".$rows['message_sent']."<br></td>
                            <td class='outbox_pics'>
                                <img src='images/mail.png' height=80 width=80 /> </td>";  
                        }
                    }
            ?>

</div>
</div>
</div>

</body>
</html>
