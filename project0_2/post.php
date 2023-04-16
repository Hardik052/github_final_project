
<?php

/******w******* 
    
    Name: Hardik Bhardwaj
    Date: 2023-02-05
    Description: Making a blog website using php.

****************/



require('connect.php');
require('authenticate.php');


 
  $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $product_price = filter_input(INPUT_GET, 'product_price', FILTER_SANITIZE_NUMBER_INT);



function file_is_an_image($tempname, $filename) {
    $allowed_mime_types      = ['image/gif', 'image/jpeg', 'image/png'];
    $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png'];
    
    $actual_file_extension   = pathinfo($filename, PATHINFO_EXTENSION);
    $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);

    $mime_type_is_valid = false;
    if($file_extension_is_valid){
        $actual_mime_type        = getimagesize($tempname)['mime'];
        $mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);
    }
    
    
    return $file_extension_is_valid && $mime_type_is_valid;
}


     

if($_POST && trim($_POST['title'])!='' && trim($_POST['content']) != '' && trim($_POST['product_price']) != ''){
    
    $filename = $_FILES["uploadfile"]["name"];
  $tempname = $_FILES["uploadfile"]["tmp_name"];
   $folder = "./image/" . $filename;
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $product_price = filter_input(INPUT_POST, 'product_price', FILTER_SANITIZE_NUMBER_INT);

    if(file_is_an_image($tempname, $filename)){
        $filename = $_FILES["uploadfile"]["name"];

    }else{
        $filename = `NULL`;

    }



    $query = "INSERT INTO products(product_name, product_description, product_image, category_id, product_price ) VALUES(:product_name, :product_description, :product_image, :category, :product_price)";

    $statement = $db->prepare($query);

        
        //  Bind values to the parameters
        $statement->bindValue(':product_name', $title);
        $statement->bindValue(':product_description', $content);
        $statement->bindValue(':product_image', $filename);
        $statement->bindValue(':category', $category);
        $statement->bindValue(':product_price', $product_price);

        if($statement->execute()){
            echo "Your content has been uploaded successfully !!";
        }else{
            echo"error";
        }
     
        if(file_is_an_image($tempname, $filename)){
        if (move_uploaded_file($tempname, $folder)) {
            echo "<h3>  Image uploaded successfully!</h3>";
            
        }
        } 
        else {
            echo "<h3>  No image uploaded !</h3>";
        }
    
     

        
}else {
    echo " <h4>Fill out the required fields pls !(Required fields are:- *TITLE*, *DESCRIPTION* AND *PRODUCT PRICE*) </h4> ";
}
function loading_categories(){
    global $db;

    $query = "SELECT * FROM category ;";
        // preparring sql for executoin
    $statement = $db->prepare($query);
    
        //executing sql
    $statement->execute();
    $categories = [];
    while ($x = $statement->fetch() ){
        $categories[] = $x;
        
    }
    
    return $categories;
   
}
$row = loading_categories();

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

            <label for="category">Category</label> 
        <select name="category">
            <?php foreach($row as $category_type): ?>
                <option value="<?= $category_type['category_id'] ?>"> <?= $category_type['category_name'] ?> </option>
            <?php endforeach ?>
        </select>
        <label for="product_price">Product Price</label>
        <input type="number" name="product_price" id="product_price">

        <input type="submit">

    </form>
</div>   
</body>
</html>
