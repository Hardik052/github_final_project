<?php

/*******w******** 
    
    Name: Hardik Bhardwaj
    Date: 2023-02-05
    Description: Making a blog website using php.

****************/

require('connect.php');
if (isset($_POST['delete_id'])) { 
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        
        // Build SQL query
        $query = "DELETE FROM products WHERE product_id = :product_id";
        $statement = $db->prepare($query);
        $statement->bindValue(':product_id', $id, PDO::PARAM_INT);
    
        $statement->execute();
        $blog = $statement->fetch();
    } 
    else {
        $id = false; 
    }

   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Delete Post</title>
</head>
<body>
<header>
    <div id= "main_nav">
    <ul>
        <li><a href="#">Home</a></li>
        <li><a href="shop.php">Shop</a></li>
        <li><a href="new_item.php">Sell / Donate</a></li>
        <li><a href="contact_us.php">Contact Us</a></li>
        <li><a href="edit.php">Store Location</a></li>
    </ul>
    </div>

</header>
    <div class="content">
<a href="index.php">Home</a>
    &nbsp; &nbsp;
    <a href="post.php">New Post</a>
    <h1><a href="index.php">My Amazing blog</a></h1>
    <p>Click delete to delete the data !</p>
<form method="post" action="">
                <input type="hidden"  value="<?= $rows['id'] ?>">
                <button type="submit" value="delete" name="delete_id" id="delete_id">DELETE</button>
            </form>

</form>
</div>
</body>
</html>