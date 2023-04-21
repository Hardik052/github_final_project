<?php
 include_once 'header.php';
?>
<section class="signup-form">
    <h2>Sign Up</h2>
    <form action="includes/signup.inc.php" method="post">
        <input type="text" name="name" placeholder="Full name..">
        <input type="email" name="email" placeholder="Email.." >
        <input type="text" name="uid" placeholder="Username.." >
        <input type="password" name="pwd" placeholder="Password.." >
        <input type="password" name="pwdrepeat" placeholder="repeat password.." >
        <input type="hidden" name="by_admin" value="false">
        <button type="submit" name="submit">Sign up</button>
    </form>
</section>
<?php
if(isset($_GET["error"])){
    if($_GET["error"] == "'empty_fields'"){
        echo "<p>Fill in all the blanks</p>";

    }
    else if($_GET["error"] == "'invalid_user_name'"){
        echo "<p>Invalid user name</p>";
    }
    else if($_GET["error"] == "'invalid_email'"){
        echo "<p>Invalid email</p>";
    }
    else if($_GET["error"] == "'user_name_exists'"){
        echo "<p>UserName already exist</p>";
    }
    else if($_GET["error"] == "'password_does_not_match'"){
        echo "<p>Password does not match, Please Try Again !</p>";
    }
    

}
?>
