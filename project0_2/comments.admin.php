<?php
require('../header.php');
require('../connect.php');
if($_SESSION['user_id'] != 3){
    header(" location: ../index.php");
    exit();
}
$comments = loading_comments();
$edit_mode = false;
if($_GET){
    $edit = filter_input(INPUT_GET, 'edit',FILTER_SANITIZE_FULL_SPECIAL_CHARS );
if ($edit == true){
    $edit_mode = true;
}
}

if($edit_mode){

    if(isset($_POST['edit'])){
        editing_comment();
    }
    if(isset($_POST['delete'])){
        delete_comment();
    }
}

function loading_comments(){
    global $db;


    $load_comments = "SELECT * FROM comments ;";
    $statement = $db->prepare($load_comments);
    $statement->execute();

    $comments = [];
    while ($x = $statement->fetch() ){
        $comments[] = $x;
        
    }
    
    return $comments;
}

//edit comment
function editing_comment(){
    global $db;
    $comment = filter_input(INPUT_POST, 'comment_comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $comment_id = filter_input(INPUT_POST, 'comment_id', FILTER_SANITIZE_NUMBER_INT);
    $edit_comment = "UPDATE comments SET comment_comment = :comment_comment WHERE comment_id = :comment_id ;";

    $statement= $db->prepare($edit_comment);
    $statement->bindValue(':comment_id', $comment_id, PDO::PARAM_INT);
    $statement->bindValue(':comment_comment', $comment);

    if($statement->execute()){
        echo("Success");
        header("Location: comments.admin.php");
    }


}
function delete_comment(){
    global $db;

    $query = "DELETE FROM comments WHERE comment_id= :comment_id";
    $comment_id = filter_input(INPUT_POST, 'comment_id', FILTER_SANITIZE_NUMBER_INT);
    $statement= $db->prepare($query);
    $statement->bindValue(':comment_id', $comment_id, PDO::PARAM_INT);
    if($statement->execute()){
        echo("Success");
        header("Location: comments.admin.php");
    }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Comment Section !</title>
</head>
<body>
<?php if(! $edit_mode): ?>

<h4><a href="comments.admin.php?edit='true'">Edit</a></h4>
<div>
            
    <?php if(count($comments) > 0):
    foreach ($comments as $com): ?>
        <div> 
        <h2><?= $com['name_comment'] ?></h2>
        <p><?= $com['comment_comment'] ?></p>
        </div>
    <?php endforeach;
    else: ?>
        <div>
            <h2>No comments here</h2>
        </div>
    <?php endif ?>
    <?php else: ?>
    <div>

        <?php if(count($comments) > 0):
        foreach ($comments as $com): ?>
            
            <form action="" method="post">
                <h2><?= $com['name_comment'] ?></h2>

                <input type="hidden" name="comment_id" value="<?= $com['comment_id'] ?>" >
                
                <textarea name="comment_comment" rows="10" ><?= $com['comment_comment'] ?></textarea>
               
                <input type="submit"  value="Edit" name="edit">
                <input type="submit"  value="Delete" name="delete">
            </form>

        <?php endforeach;
        else: ?>
            <div>
                <h2>No comments here</h2>
            </div>
        <?php endif ?>

    </div>
    <?php endif ?>
</div>

    
</body>
</html>