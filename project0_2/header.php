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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <!--- nav bar and other stuff on top-->
    <!-- put a logo and social handles-->
    <!-- nav bar-->
    <div id= "container">
        
    <ul>
        <div class="row">
        <div class="col">
            <div class="box">
        <li><a href="index.php">Home</a></li>
</div> 
</div>
<div class="col">
    <div class="box">
        <li><a href="products.php">Products</a></li>
</div>
</div>
<div class="col">
    <div class="box">
        <?php
        if(isset($_SESSION['useruid'])){
            echo "<li><a href='includes/logout.inc.php'>logout</a></li>";
        }
    else{
     echo "<li><a href='login.php'>log in</a></li>";
     echo  "<li><a href='signup.php'>sign up</a></li>";
    }
        ?>
        </div>
        </div>
</div>
    </ul>
    </div>

</header>