<?php
 include_once 'header.php';
require('connect.php');
if($_SESSION['user_id'] != 3){
    header(" location: index.php");
    exit();
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
// function to add up categories
function addCategory(){

    global $db;
    //sanitize the data
    $category = filter_input(INPUT_POST, 'new_category', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $query = "INSERT INTO category(category_name) VALUES (:category_name);";
    $statement = $db->prepare($query);
    $statement->bindValue(':category_name', $category);

    if($statement->execute()){
        echo "Success";
    }
}

//update categories function 
function updateCategory(){
    global $db;
    //sanitize the data
    $category = filter_input(INPUT_POST, 'rename', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_input(INPUT_POST, 'loaded_category', FILTER_SANITIZE_NUMBER_INT);

    $query = "UPDATE category SET category_name = :category_name WHERE category_id= :category_id;";
    $statement = $db->prepare($query);
    $statement->bindValue(':category_name', $category);
    $statement->bindValue(':category_id', $category_id);

    if($statement->execute()){
        echo "Success";
    }

}

// delete category 
function deleteCategory(){
    global $db;

    $category_id = filter_input(INPUT_POST, 'loaded_category', FILTER_SANITIZE_NUMBER_INT);

    $query = "DELETE FROM category WHERE category_id= :id";

    $statement= $db->prepare($query);
    $statement->bindValue(':id', $category_id, PDO::PARAM_INT);
    if($statement->execute()){
        echo("Success");

    } 
}
$row = loading_categories();
if(isset($_POST)){

    if(isset($_POST['addCategory']) && trim($_POST['new_category']) != '' ){
        addCategory();
        header("location: admin/admin.php"); 
        exit();
    }

    if(isset($_POST['updateCategory']) && trim($_POST['rename']) != '' ){
        updateCategory();
        header("location: admin.php"); 
        exit();
    }

    if(isset($_POST['deleteCategory'])){
        deleteCategory();
        header("location: admin.php"); 
        exit();
    }
}
?>


<div class="container">
    <!-- loading the categories--->
    <form action="categories.php" method="post">
    <h3>Edit a Category</h3>

    <select name="loaded_category" >

    <?php foreach($row as $category_type): ?>    
    <option value="<?= $category_type['category_id'] ?>"> <?= $category_type['category_name'] ?> </option>
    <?php endforeach ?>

    </select>
   

    <label for="rename" class="form-label" >Rename</label>
    <input type="text"name="rename" >

    <input type="submit" value="Rename Category" name="updateCategory" class="form-control">&nbsp;&nbsp;
    <input type="submit" value="Delete Category" name="deleteCategory" class="form-control">
    </form>


    <!-- adding new categories--->
    <div class="container ">
    <form action="categories.php" method="post">
        <label for="new_category" class="form-label">Add Category</label>
        <input type="text" name="new_category" >

        <input type="submit" value="Add Category" name="addCategory" class="form-control">
        
    </form>
    </div>

    <div>
        <ul>
            <?php foreach($row as $category_name): ?>
                <li><?= $category_name['category_name'] ?> </li>
            <?php endforeach ?>
        </ul>
    </div>

</div>



</body>
</html>
    
</body>
</html>