<?php
 include_once 'header.php';
?>


    
<section class="signup-form">
    <h2>Sign Up</h2>
    <form action="includes/signup.inc.php" method="post">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" placeholder="Full name" class="form-control">
        <label for="email" class="form-label">e-mail</label>
        <input type="email" name="email" placeholder="Email" class="form-control" >
        <label for="username" class="form-label">Username</label>
        <input type="text" name="uid" placeholder="Username" class="form-control" >
        <label for="pwd" class="form-label">Password</label>
        <input type="password" name="pwd" placeholder="Password" class="form-control" >
        <label for="pwdrpt" class="form-label">Repeat Password</label>
        <input type="password" name="pwdrepeat" placeholder="repeat password" class="form-control" >
        <input type="hidden" name="by_admin" value="false">
        <button type="submit" name="submit">Sign up</button>
    </form>
</section>
</body>
<?php
if(isset($_GET["error"])){
    if($_GET["error"] == "'empty_fields'"){
        echo "<div class='box'><p>Fill in all the blanks</p></div>";

    }
    else if($_GET["error"] == "'invalid_user_name'"){
        echo "<div class='box'><p>Invalid user name</p></div>";
    }
    else if($_GET["error"] == "'invalid_email'"){
        echo "<div class='box'><p>Invalid email</p></div>";
    }
    else if($_GET["error"] == "'user_name_exists'"){
        echo "<div class='box'><p>UserName already exist</p></div>";
    }
    else if($_GET["error"] == "'password_does_not_match'"){
        echo "<div class='box'><p>Password does not match, Please Try Again !</p></div>";
    }
    

}
?>
