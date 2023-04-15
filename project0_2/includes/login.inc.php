<?php
require '../connect.php';
require_once 'functions.inc.php';

if(isset($_POST['submit']))
{
    $user_name = $_POST['name'];
    $pass = $_POST['pwd'];

    if(emptyInputLogin($user_name, $pass) ){
        header("location: ../login.php?error='empty_fields'");
        exit();
    }

    login_user($user_name, $pass);

}
else{
    header("location: ../login_page.php");
    exit();
}