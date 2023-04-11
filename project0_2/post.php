
<?php

/******w******* 
    
    Name: Hardik Bhardwaj
    Date: 2023-02-05
    Description: Making a blog website using php.

****************/



require('connect.php');
require('authenticate.php');

if($_POST && trim($_POST['title'])!='' && trim($_POST['content']) != ''){
    
    $filename = $_FILES["uploadfile"]["name"];
  $tempname = $_FILES["uploadfile"]["tmp_name"];
   $folder = "./image/" . $filename;
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);


    $query = "INSERT INTO products(product_name, product_description, product_image ) VALUES(:product_name, :product_description, :product_image)";

    $statement = $db->prepare($query);

        
        //  Bind values to the parameters
        $statement->bindValue(':product_name', $title);
        $statement->bindValue(':product_description', $content);
        $statement->bindValue(':product_image', $filename);

        if($statement->execute()){
            echo "Your content has been uploaded successfully !!";
        }else{
            echo"error";
        }
        if (move_uploaded_file($tempname, $folder)) {
            echo "<h3>  Image uploaded successfully!</h3>";
        } else {
            echo "<h3>  No image uploaded !</h3>";
        }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>My Blog Post!</title>
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
    <a href="post.php">New Posts</a>
    <h1><a href="index.php">Generation Z ! </a></h1>
    <h1>New Post</h1>
    <!-- Remember that alternative syntax is good and html inside php is bad -->
    <form action="post.php" method="post" enctype="multipart/form-data">
        <label for="title" >title</label>
        <input id="title" name="title">
        &nbsp;  &nbsp;  &nbsp; 
        <label for="content">content</label>
        <textarea name="content" id="content" cols="30" rows="10"></textarea>
        <div class="form-group">
                <input class="form-control" type="file" name="uploadfile" value="" />
            </div>

        <input type="submit">

    </form>
</div>   
</body>
</html>
