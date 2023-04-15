<?php
 session_start();
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Welcome to our online shop!</title>
</head>
<body>
<header>
    <!--- nav bar and other stuff on top-->
    <!-- put a logo and social handles-->
    <!-- nav bar-->
    <div id= "main_nav">
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="index.php">Shop</a></li>
        <li><a href="edit.php">Store Location</a></li>
        <?php
        if(isset($_SESSION['useruid'])){
           echo "<li><a href='profile.php'>profile</a></li>";
            echo "<li><a href='includes/logout.inc.php'>logout</a></li>";
        }
    else{
     echo "<li><a href='login.php'>log in</a></li>";
     echo  "<li><a href='signup.php'>sign up</a></li>";
    }
        ?>
    </ul>
    </div>

</header>