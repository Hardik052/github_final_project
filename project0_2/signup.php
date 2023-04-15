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

