<?php
 include_once 'header.php';
?>
<section class="signup-form">
    <h2>login</h2>
    <form action="includes/login.inc.php" method="post">
        <input type="text" name="name" placeholder="Username/Email">
        <input type="password" name="pwd" placeholder="Password.." >
        <button type="submit" name="submit">SLog In</button>
    </form>
</section>