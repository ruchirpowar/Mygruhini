<?php
require_once("config/connection.php");
$pdo = pdo_connect_mysql();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/contactstyle.css">
    <script src="js/contact.js" defer></script>
</head>
<body>
<div class="wrapper">
  <h2>Contact us</h2>
  <div id="error_message">
     
  </div>
  <form action="" id="myform" method="POST">
    <div class="input_field">
        <input type="text" placeholder="Name" id="name" name="name"  maxlength="32" value="" required>
    </div>
    <div class="input_field">
        <input type="text" placeholder="Subject" id="subject" name="subject"  value="" required>
    </div>
    <div class="input_field">
        <input type="text" placeholder="Phone" id="phone" name="phonenumber"  value="" required>
    </div>
    <div class="input_field">
        <input type="text" placeholder="Email" id="email" name="emailaddres"  value="" required>
    </div>
    <div class="input_field">
        <textarea placeholder="Message" id="message" name="message"  value="" required></textarea>
    </div>
    <div class="cl">
        <input type="submit" name="send" value="send"  onclick = "validate();">
    </div>
  </form>
  <?php

    if(!empty(isset($_POST['send'])))
    {
    // getting Post values
        $name=trim($_POST['name']);
        $phoneno=stripslashes(trim($_POST['phonenumber']));
        $email=strtolower(strip_tags(trim($_POST['emailaddres'])));
        $subject=$_POST['subject'];
        $message=stripslashes(trim($_POST['message']));

        // Insert quaery
        $sql="INSERT INTO `contact`(`user_name`, `subject`, `user_mob`, `user_email`, `content`) VALUES (:fname,:subject,:phone,:email,:message)";
        $query = $pdo->prepare($sql);
        // Bind parameters
        $query->bindParam(':fname',$name,PDO::PARAM_STR);
        $query->bindParam(':phone',$phoneno,PDO::PARAM_STR);
        $query->bindParam(':email',$email,PDO::PARAM_STR);
        $query->bindParam(':subject',$subject,PDO::PARAM_STR);
        $query->bindParam(':message',$message,PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $pdo->lastInsertId();
        if(!empty($lastInsertId))
        {
        //mail function for sending mail
            $toEmail = "bigapplegrocerystore@gmail.com";
            $mailHeaders = "From: " . $name . "<". $email .">\r\n";
            $ms="
            Name:</b> $name,
        Phone Number: $phoneno,
            Email Id: $email,";
            $ms=$message;
            if(isset($_SESSION['sess_user_id']) && $_SESSION['sess_user_id'] != ""){
                if(mail($toEmail, $name,$subject, $ms,$mailHeaders)) {
                    $ms="<script>alert('Your contact information is received successfully.')</script>";
                    $type = "success";
                    echo"<script>alert('Your contact information is received successfully.')
                    window.location='ppl.php';
                    </script>";
                }
                else
                {
                echo "<script>alert('Something went wrong. Please try again');</script>";
                }
            }
            else{
                if(mail($toEmail, $name,$subject, $ms,$mailHeaders)) {
                    $ms="<script>alert('Your contact information is received successfully.')</script>";
                    $type = "success";
                    echo"<script>alert('Your contact information is received successfully.')
                    window.location='index.php';
                    </script>";
                }
                else
                {
                echo "<script>alert('Something went wrong. Please try again');</script>";
                }
            }
        }
    }
  ?>
</div>
</body>
</html>