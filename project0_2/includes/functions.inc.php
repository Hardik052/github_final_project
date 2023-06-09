<?php
require '../connect.php';

function login_user($user_name, $pass){
    $user = user_name_exists($user_name, $user_name);

    if(! $user){
        // error login no info found
        header("location: ../login.php?error='doesnot_exist'");
        exit();
    }

    print_r ($user);
    $pwd_hashed = $user['userPwd'];
    $check_password = password_verify($pass, $pwd_hashed);

    if(!$check_password){

        // login failed
        header("location: ../login_page.php?error='wrong_pass'");
        exit();
    }
    else{
        session_start();
        $_SESSION['user_id']= $user['userId'];
        $_SESSION['useruid']= $user['userUid'];
        header("location: ../index.php");
        exit();
    }

}


function createUser($full_name, $user_name, $pass, $email, $by_admin){
    global $db;
    $users = "INSERT INTO users(userName, userUid, userEmail, userPwd) VALUES(:fullname, :name, :email, :password);";

    $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

    $statement= $db->prepare($users);

    $statement->bindValue(':name', $user_name);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':fullname', $full_name);
    $statement->bindValue(':password', $hashed_pass);

    $statement->execute();

    if(!$by_admin){
        login_user($user_name, $pass);
    }
    else{
        header("location: ../index.php");
        
    }
}



// ERROR HANDLERS

function emptyInputSignup($full_name, $user_name, $pass, $repeat_pass, $email){

    if(empty($full_name) || empty($user_name) || empty($pass) ||empty($repeat_pass) ||empty($email)){
        return true;
    }
    else{
        return false;
    }
}

function invaid_user_name($user_name){
    if(preg_match(("/^[a-zA-Z0-9]*$/"), $user_name) ){
        return false;
    }
    else{
        return true;
    }
}

function invaid_email($email){
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        return false;
    }
    else{
        return true;
    }
}

function pass_match($pass, $repeat_pass){
    if($pass !== $repeat_pass){
        return false;
    }
    else{
        return true;
    }
}

function user_name_exists($user_name, $email){
    global $db;
    $users = "SELECT * FROM users WHERE userUid = :user_name OR userEmail = :email;";

    $statement= $db->prepare($users);

    $statement->bindValue(':user_name', $user_name);
    $statement->bindValue(':email', $email);

    $statement->execute();

    $user_data = $statement->fetch();

    if($user_data){
        // this will be used for login
        return $user_data;
    }
    else{
        return false;
    }
}


function emptyInputLogin($user_name, $pass){

    if(empty($user_name) || empty($pass) ){
        return true;
    }
    else{
        return false;
    }
}