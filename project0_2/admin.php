<?php
require('connect.php');
session_start();
if($_SESSION['user_id'] != 3){
    header(" location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>product name here</title>
</head>
<body>
    <a href="users.php"><div>Manage All Users</div></a>
    <a href="comments.admin.php"><div> Comments Access</div></a>
    <a href="categories.php"><div>Manage categories</div></a>
    <a href="post.php"><div>Items</div></a>

</body>
</html>