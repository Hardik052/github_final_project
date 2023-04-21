<?php


require('connect.php');
require('authenticate.php');
require('header.php');


  $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_FULL_SPECIAL_CHARS);



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

if ($_POST && isset($_POST['title']) && isset($_POST['content']) && isset($_POST['id'])) {

    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
     $folder = "./image/" . $filename;
   
    $title  = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    
    if(file_is_an_image($tempname, $filename)){
        $filename = $_FILES["uploadfile"]["name"];

    }else{
        $filename = `NULL`;

    }


    $query = "UPDATE products SET product_name = :title, product_description = :content, product_image = :product_image WHERE product_id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':title', $title);        
    $statement->bindValue(':content', $content);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->bindValue(':product_image', $filename);

    
    // Execute the INSERT.
    $statement->execute();
    if(file_is_an_image($tempname, $filename)){
        if (move_uploaded_file($tempname, $folder)) {
            echo "<h3>  Image uploaded successfully!</h3>";
        }
        } 
        else {
            echo "<h3>  No image uploaded !</h3>";
        }
    
    // Redirect after update.
    header("Location:index.php?id={$id}");
    exit;
} else if (isset($_GET['id'])) { // Retrieve quote to be edited, if id GET parameter is in URL.
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    
    // Build SQL query
    $query = "SELECT * FROM products WHERE product_id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);

    $statement->execute();
    $blog = $statement->fetch();
} 
else {
    $id = false; 
}


?>

    <!-- Remember that alternative syntax is good and html inside php is bad -->
    <?php if($id): ?>
        <form method="post" action="edit.php" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $blog['product_id'] ?>">
        <label for="title">title</label>
        <input id="title" name="title" value="<?= $blog['product_name'] ?>">
        &nbsp;  &nbsp;  &nbsp; 
        <label for="content">content</label>
        <input name="content" id="content" value="<?=$blog['product_description']?>">
        <div class="form-group">
                <input class="form-control" type="file" name="uploadfile" value="" />
            </div>
            <?php if( $blog['product_image']): ?>

            <label for="delete_image">Check Here to Delete Image: </label>
        <input type="checkbox" name="delete_image" id="delete_image" value="delete_image">;
        <?php endif ?>
        <input type="submit" value="edit">
      
        
        </form>
        <form method="post" action="delete.php?id=<?=$blog['product_id']?>">
                <input type="hidden" name="id" value="<?= $blog['product_id'] ?>">
                <input type="submit" value="delete">
            </form>
         
            <?php else: ?>
            <h2><a href="index.php">Generation Z</a></h2>
            <?php header('Location: index.php') ?>

           
        <?php endif ?>

        
    </div>      
</body>
</html>