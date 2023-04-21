
<?php

require('connect.php');
include('header.php');

//user login check
$login_user = false;
$admin_access = false;
if(array_key_exists('user_id', $_SESSION ) ){
    $login_user =true;

    if($_SESSION['user_id'] == 3){
        $admin_access = true;
    }
}

$cat = loading_categories();


if(array_key_exists( 'category_id', $_GET) ){
    $categoryID = $_GET['category_id'];
}
 
if($_POST){
    $result_start=0;
    $search_value = $_POST['searchText'];
    $sortBy = $_POST['sort_by'];
    $sortType = $_POST['sort_type'];

    if(! array_key_exists( 'category_id', $_GET)){
    $categoryID = $_POST['category'];
    }

    $row = search_bar_filter($search_value, $sortBy, $sortType, $categoryID);
}

else{
    if(array_key_exists( 'category_id', $_GET)){
        $products = "SELECT * FROM products WHERE category_id = :category_id "; 
        $statement = $db->prepare($products);
        $statement->bindValue(':category_id', $categoryID);
    }
    else{
        $products = "SELECT * FROM products ";
        $statement = $db->prepare($products);
    }
    $statement->execute();
    $results = [];
    while ($x = $statement->fetch() ){
        $results[] = $x;    
    }
    $row = $results;
} 

function search_bar_filter($search_value, $sortBy, $sortType, $category_id){
    global $db;
    
    $products = "SELECT * FROM products 
        WHERE `product_name` LIKE '%$search_value%' AND category_id LIKE '$category_id' ORDER BY $sortBy $sortType   ;";

    if($category_id == "all_categories"){
        $products = "SELECT * FROM products 
            WHERE `product_name` LIKE '%$search_value%' 
            ORDER BY $sortBy $sortType" ;
    }
    $statement = $db->prepare($products);
    
    $statement->execute();

    $results = [];
    while ($x = $statement->fetch() ){
        $results[] = $x;
        
    }
    
    return $results;

}


// loading the categories
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

//maybe use session to savve  and load the radio selection



?>


<div class="container">
<?php if($admin_access): ?>
    <div class="container">
    <h4>*Admin is logged in ! </h4>
    <div class="row">
        <div class="box">
    <a href="users.php">Manage Users ! </a>
</div>
<div class="box">
    <a href="categories.php">Manage Categories </a>
</div>
<div class="box"> 
    <a href="admin.php">Admin Access</a>
</div>
</div>
</div>
    <?php endif ?>
    <?php
    if ($login_user): ?>
    <div class="box">
     <a href="post.php">Add Product</a>
    </div>
    <div id="category_bar">
        <a class="col" href="products.php?result_start=0"><div class="col box">All categories</div></a>
            <?php foreach ($cat as $category) : ?>
                <a class="col" href="products.php?category_id=<?= $category['category_id']?>&result_start=0 "><div class="col box"> <?= $category['category_name'] ?> </div></a>
            <?php endforeach ?>
        </div>
    </div>
    <div id="search_box" class="row">
        <form action="" method="post">
            <label for="sort_by" class="form-label">Sort By</label>
            <select name="sort_by" class="form-select-sm" >
                <option value="product_date">By Date</option>
                <option value="product_name">By Name</option>
                <option value="product_price">By Price</option>
            </select>

            <label for="sort_type"></label>
            <select name="sort_type" class="form-select-sm">
                <option value="ASC">asc </option>
                <option value="DESC">desc</option>
            </select>

            <?php if(!array_key_exists( 'category_id', $_GET)): ?>
            <label for="category">Category</label> 
            <select class="form-select-sm" name="category">
                <option value="all_categories"> ---All Categories--- </option>
                <?php foreach($cat as $category_type): ?>
                    <option value="<?= $category_type['category_id'] ?>"> <?= $category_type['category_name'] ?> </option>
                <?php endforeach ?>
            </select>
            <?php endif ?>

            <input type="text"  name="searchText" id="" placeholder="Type here to search" class="form-control" >
            <input type="submit" value="Search" name="search" class='btn btn-outline-secondary'>
        </form>
        <?php endif ?>

    </div> 


    <div id="products">

        <?php if($row): ?>
        <h3> <?= count($row)?> Results Found !!!</h3>
        <?php foreach ($row as $product): ?>

        <div class="container">
            
            <div class="box">
                <a href="newWhere.php?id=<?=$product['product_id']?>">
                    <?php 
                    if($product['product_image']):
                        $folder = "image/". $product['product_image'];
                        ?>
                        <img src="<?= $folder ?>" alt="image here">

                        <div id="with_img">
                            <h3> <?= $product['product_name'] ?> </h3></a> 
                            <h3> $<?=$product['product_price'] ?></h3>
                            <?php if(strlen($product['product_description']) > 200): ?>
                                <p><?= substr($product['product_description'], 0, 200) ?>.... </p>
                            <?php else: ?>
                            <p><?= $product['product_description'] ?></p>
                            <?php endif ?>
                        </div>
                    <?php else:?>

                    <div id="no_img">
                    <h3> <?= $product['product_name'] ?> </h3></a> 
                            <h3> $<?=$product['product_price'] ?></h3>
                            <?php if(strlen($product['product_description']) > 200): ?>
                                <p><?= substr($product['product_description'], 0, 200) ?>.... </p>
                            <?php else: ?>
                            <p><?= $product['product_description'] ?></p>
                        <?php endif ?>
                    </div>
                    
                    <?php endif ?>
                
            </div>
        </div>
        <?php endforeach ; ?>
    </div>


        <?php    else: ?>
    <div id="no_result">
        <h2> No Results Found</h2>
        <a href="products.php?result_start=0">Click here to view all products</a>
        <?php endif ?>

    </div>

    <ul>
    


        </div> 
</body>

</html>

