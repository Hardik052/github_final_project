<?php
require('connect.php');
  if(isset($_POST['postComment'])){
    $comment = $_POST['comment'];
    $postid = $_POST['id'];

    if($comment != ""){
        $sql = "INSERT INTO comments( comment_comment, product_id) VALUES(:comment_comment, :product_id)";
        $content1 = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

 // A PDO::Statement is prepared from the query.
 $statement1 = $db->prepare($sql);  


 // Execution on the DB server is delayed until we execute().
 $statement1->bindValue(':comment_comment', $comment);
 $statement1->bindValue(':product_id', $postid);

 $row1 = $statement1->fetch();
        if($statement1->execute()){
          header("Location:newWhere.php?id=".$postid);
        }
    }
  }
?>