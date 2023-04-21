<?php
include_once 'header.php';

  

$login_user = false;
$admin_access = false;


if(array_key_exists('user_id', $_SESSION ) ){
    $login_user =true;

    if($_SESSION['user_id'] == 3){
        $admin_access = true;
    }
}

?>


    <div class="container">
    <h2><a href="products.php">GENERATION Z ! </a></h2>
    <div class="box">
    <h2>we are street-wear re-selling company, we sell hoodies, t-shirts, sneakers at very reasonable rates !</h2>
    <h2>Come and visit us Monday to Friday 10 AM to 7 PM.</h2>
</div>
</div>
    
    
</body>
</html>
