<?php
include_once 'header.php';

  

$login_user = false;
$admin_access = false;


if(array_key_exists('user_id', $_SESSION ) ){
    $login_user =true;

    if($_SESSION['user_id'] == 3){
        $admin_access = true;
    }
}

?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2><a href="products.php">GENERATION Z ! </a></h2>
    <h2>we are street-wear re-selling company, we sell hoodies, t-shirts, sneakers at very reasonable rates !</h2>
    <h2>Come and visit us Monday to Friday 10 AM to 7 PM.</h2>

    
    
</body>
</html>
