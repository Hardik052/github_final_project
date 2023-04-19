<?php
require 'connect.php';
require 'authenticate.php';
session_start();
if($_SESSION['useruid'] != 'Admin5252'){
    header(" location: index.php");
    exit();
}

$editmode = false;
if($_GET){
    if ($_GET['edit'] == true){
        $editmode = true;
    }
}

// view/add/delete users here
$users = loading_users();
if(isset($_POST['delete'])){
    delete_user();
}
if($editmode){
    if(isset($_POST['edit'])){
        editing_users();
    }
}
function loading_users(){
    global $db;


    $load_users = "SELECT * FROM users;";
        // preparring sql for executoin
    $statement = $db->prepare($load_users);
        
        //executing sql
    $statement->execute();

    $users = [];
    while ($x = $statement->fetch() ){
        $users[] = $x;   
    }
    return $users;
}
function editing_users(){
    global $db;
    $userEmail = filter_input(INPUT_POST, 'edit_user_email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $fullname = filter_input(INPUT_POST, 'edit_fullname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $edit_user_id = filter_input(INPUT_POST, 'edit_user_id', FILTER_SANITIZE_NUMBER_INT);
    $edit_user = "UPDATE users SET userName= :userName , userEmail = :userEmail  WHERE userId = :userId ;";

    $statement= $db->prepare($edit_user);
    $statement->bindValue(':userId', $edit_user_id, PDO::PARAM_INT);
    $statement->bindValue(':userEmail', $userEmail);
    $statement->bindValue(':userName', $fullname);

    if($statement->execute()){
        echo("Success");
        header("Location: index.php");
    }
} 
function delete_user(){
    global $db;

    $query = "DELETE FROM users WHERE userId= :userId";
    $edit_user_id = filter_input(INPUT_POST, 'edit_user_id', FILTER_SANITIZE_NUMBER_INT);

    if($edit_user_id == 3){
        header("location: index.php");
        exit();
    }

    $statement= $db->prepare($query);
    $statement->bindValue(':userId', $edit_user_id, PDO::PARAM_INT);
    if($statement->execute()){
        echo("Success");
        header("Location: users.php");
    } // add an alert to confirm delete
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to my Blog!</title>
</head>
<body>

<div class="container">
    <form class="border m-3 p-2" action="includes/signup.inc.php" method="post">
        <h2>Add a new user</h2>

        <label for="name" class="form-label">Full Name</label>
        <input type="text" class="form-control" name="name" placeholder="Full name ...">

        <label for="user_name" class="form-label">User Name</label>
        <input type="text" class="form-control" name="uid" placeholder="User name ...">

        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" name="email" placeholder="Email ...">

        <label for="pwd" class="form-label">Password</label>
        <input type="password" class="form-control" name="pwd" placeholder="Password ...">

        <label for="pwd_repeat" class="form-label">Repeat Password</label>
        <input type="password" class="form-control" name="pwdrepeat" placeholder=" Repeat Password ...">

        <input type="hidden" name="by_admin" value= 'Admin5252'>

        <input type="submit" class="btn btn-primary" value="Create User" name="submit">
    </form>
</div>

<div>
       <h4> *Wanna edit user data ? click here  => <a href="users.php?edit=true" class="btn btn-outline-secondary">Edit</a> </h4>
        <?php foreach ($users as $user): ?>
            <form action="" method="post" class="border border-1 m-3 p-3">
                <input type="hidden" name="edit_user_id" value="<?= $user['userId']?>">

                <?php if($editmode): ?>
                    <div class="form-floating">
                    <input type="email" class="form-control" name="edit_user_email" value="<?= $user['userEmail']?>" placeholder="User email">
                    <label for="email" class="form-label">UserEmail</label>
                    </div>
                    <div class="form-floating">
                        <input type="text" class="form-control" name="edit_fullname" value="<?= $user['userName']?>" placeholder="Full name">
                        <label for="fullname" class="form-label">FullName</label>
                    </div>
                    
                   <input type='submit' value='edit' class='btn btn-outline-secondary' name='edit'>

                <?php else: ?>
                    <h2><?= $user['userName']?></h2>
                <?php endif ?>
                
                <input type="submit" value="Delete" class="btn btn-danger" name="delete">

                <h6>________________</h6>
            </form>

        <?php endforeach ?>
    </div>
</div>

</body>