<?php
session_start();
require_once 'functions.inc.php';

if(isset($_POST['submit']))
{
    // grabbing the data
    $full_name = $_POST['name'];
    $user_name = $_POST['uid'];
    $pass = $_POST['pwd'];
    $repeat_pass = $_POST['pwdrepeat'];
    $email = $_POST['email'];
    $by_admin = $_POST['by_admin'];


    if(emptyInputSignup($full_name, $user_name, $pass, $repeat_pass, $email) ){
        header("location: ../signup.php?error='empty_fields'");
        exit();
    }

    if(invaid_user_name($user_name)){
        header("location: ../signup.php?error='invalid_user_name'");
        exit();
    }

    if(invaid_email($email)){
        header("location: ../signup.php?error='invalid_email'");
        exit();
    }

    if(user_name_exists($user_name, $email)){
        header("location: ../signup.php?error='user_name_exists'");
        exit();
    }

    if(!pass_match($pass, $repeat_pass)){
        header("location: ../signup.php?error='password_does_not_match'");
        exit();
    }

    createUser($full_name, $user_name, $pass, $email, $by_admin);
}

else{
    header ("../signup.php");
    exit();
}