<?php

/*******w******** 
    
    Name: Hardik Bhardwaj
    Date: 2023-02-05
    Description: Making a blog website using php.

****************/

require('connect.php');
$query = "SELECT * FROM products WHERE product_id = :product_id LIMIT 1";

 // A PDO::Statement is prepared from the query.
 $statement = $db->prepare($query);  
 $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

 // Execution on the DB server is delayed until we execute().
 $statement->bindValue('product_id', $id, PDO::PARAM_INT);
 $statement->execute(); 
 $row = $statement->fetch();

 function loading_comments(){
    global $db;

    $id= filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $load_comments = "SELECT * FROM comments WHERE  product_id= :id ;";
        // preparring sql for executoin
    $statement = $db->prepare($load_comments);
    
        //bind
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    
        //executing sql
    $statement->execute();
    //$row2 = $statement->fetch();
    $comments = [];
    while ($x = $statement->fetch() ){
        $comments[] = $x;
        
    }
    
    return $comments;
    
}
if(isset($_GET['id'])){
    $row3 = loading_comments();    
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Generation Z !</title>
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

</header>
<div class="content">    
<a href="index.php">Home</a>
    &nbsp; &nbsp;
    <a href="post.php">New Product</a>
    <h1><a href="index.php">Generation Z !</a></h1>
    <!-- Remember that alternative syntax is good and html inside php is bad -->

    <h2>Product name</h2>
    <p><?= $row['product_name'] ?></p>

    <h2>Product Description</h2>
    <p><?= $row['product_description'] ?></p>
    <p><a href="edit.php?id=<?=$row['product_id']?>">edit</a></p>
    <form method= "POST" action="comment.php" class="form-horizontal">
        <input type="hidden" name="id" value=<?php echo $id?>>
        <label for="comment">Add Comment</label>
        <textarea name="comment" placeholder="comment" class="form-control" cols="10" rows="5"></textarea>
        <input type="submit" value="Comment" name="postComment">
    </form>
   
</div>

<div>
    <h1>All Comments</h1>
    <?php if(count($row3) > 0):
            foreach ($row3 as $commentData): ?>
                <div>
            
                <p><?= $commentData['comment_comment'] ?></p>

                
             

                </div>
            <?php endforeach;
            else: ?>
                <div>
                    <h2>No comments here</h2>
                </div>
            <?php endif ?>
   
</div>
</body>
</html>