<?php
require('connect.php');
require('header.php');
if($_SESSION['user_id'] != 3){
    header(" location: index.php");
    exit();
}
?>


    <div class="container">
        <div class="box">
    <a href="users.php">Manage All Users</a>
    </div>
    <div class="box">
    <a href="comments.admin.php">Comments Access</a>
</div>
<div class="box">
    <a href="categories.php">Manage categories</a>
</div>
<div class="box">
    <a href="post.php">Items</a>
</div>
</div>
</body>
</html>