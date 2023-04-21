<?php
include_once 'header.php';
$login_user = false;
$admin_access = false;
if(array_key_exists('useruid', $_SESSION ) ){
    $login_user =true;

    if($_SESSION['user_id'] == 3){
        $admin_access = true;
    }
}

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
    <?php if($admin_access): ?>
    <h4>*As an admin you can edit posts => <a href="edit.php?id=<?=$row['product_id']?>**">edit</a></h4>
    <?php endif ?>
    <form method= "POST" action="comment.php" class="form-horizontal">
        <input type="hidden" name="id" value=<?php echo $id?>>
        <label for="comment">Add Comment</label>
        <?php
if(isset($_SESSION['useruid'])){
       echo "<textarea name='comment' placeholder='comment' class='form-control' cols='10' rows='5'></textarea>";
} else {
    echo "<textarea name='comment' placeholder='comment' class='form-control' cols='10' rows='5'></textarea>";
    echo "<label for='name_comment'>Name</label>";
    echo "<input type='text' name='name_comment' id='name_comment'>";

}
?>
        <input type="submit" value="Comment" name="postComment">
    </form>
</div>

<div>
    <h1>All Comments</h1>
    <?php if(count($row3) > 0):
            foreach ($row3 as $commentData): ?>
                <div>
                    <?php
                    
                        echo $commentData['comment_comment']. "(".$commentData['name_comment'].")";
                    ?>
                    
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