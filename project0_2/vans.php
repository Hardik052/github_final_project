<?php
require('connect.php');
$query = "SELECT * FROM products WHERE category_id = 2";
$statement = $db->prepare($query);

// Execution on the DB server is delayed until we execute().
$statement->execute(); 
$row = $statement->fetch();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Welcome to our online shop!</title>
</head>
<body>
<header>
    <!--- nav bar and other stuff on top-->
    <!-- put a logo and social handles-->
    <!-- nav bar-->
    <div id= "main_nav">
    <ul>
        <li><a href="#">Home</a></li>
        <li><a href="shop.php">Shop</a></li>
        <li><a href="new_item.php">Sell / Donate</a></li>
        <li><a href="contact_us.php">Contact Us</a></li>
        <li><a href="edit.php">Store Location</a></li>
    </ul>
    </div>
    <div>
        <form method="POST">
        </form>
    </div>

</header>   
    <div class="content">
    <a href="index.php">Home</a>
    &nbsp; &nbsp;
    <a href="post.php">Add Product</a>
   <h1><a href="index.php">Generation Z</a></h1>
    <!-- Remember that alternative syntax is good and html inside php is bad -->
   <?php while($row = $statement->fetch()): ?>

  
        <table>
            <tr>
                <th><a href="newWhere.php?category_id=<?= $row['category_id']?>"><?= $row['product_name']?></a></th>
            </tr>
            <tr>
            <?php if(strlen($row['product_description']) > 200): ?>
                        <td><?= substr($row['product_description'], 0, 200)?> ...<a href="newWhere.php?category_id=<?= $row['category_id']?>">Read Full Post</a></td>
                    <?php else: ?>
                        <td><?= $row['product_description']?></td>
                        <?php endif ?>
            </tr>
            <tr>
            <?php 
            $folder = "./image/". $row['product_image'];
            ?>
            <img src="<?= $folder ?>" alt="image:)">
            </tr>
        </table>
        <?php endwhile ?>
  
    </div>   
</body>
</html>