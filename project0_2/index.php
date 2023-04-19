<?php
include_once 'header.php';



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

$login_user = false;
$admin_access = false;


function filter_category(){
    global $db;
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
echo"else";
}


if(array_key_exists('useruid', $_SESSION ) ){
    $login_user =true;

    if($_SESSION['useruid'] == 'Admin5252'){
        $admin_access = true;
    }
}



require('connect.php');
$query = "SELECT * FROM products  ORDER BY product_id ASC LIMIT 10  ";
$statement = $db->prepare($query);  

// Execution on the DB server is delayed until we execute().
$statement->execute(); 


if(isset($_POST['nameSort'])){
    $query = "SELECT * FROM products  ORDER BY product_name ASC   ";

    $statement = $db->prepare($query);  

// Execution on the DB server is delayed until we execute().
$statement->execute(); 

}if (isset($_POST['uploadSort'])){
    $query = "SELECT * FROM products  ORDER BY product_date DESC   ";

    $statement = $db->prepare($query);  

// Execution on the DB server is delayed until we execute().
$statement->execute(); 


}
if (isset($_POST['priceSort'])){
    $query = "SELECT * FROM products  ORDER BY product_price DESC   ";

    $statement = $db->prepare($query);  

// Execution on the DB server is delayed until we execute().
$statement->execute(); 


}
$statement = $db->prepare($query);  

// Execution on the DB server is delayed until we execute().
$statement->execute(); 




 


?>

<section class="index-intro">
    <?php if ($admin_access): ?>
    <a href="users.php">Manage Users ! </a>
    <?php endif ?>
    
<?php if($admin_access): ?>
    <h4>*Admin is logged in ! </h4>
    <?php endif ?>
    <?php
if(isset($_SESSION['useruid'])){
           echo "<h4>Currently, Logged in user is: ". $_SESSION['useruid'] .  "</h4>";
            
        } 
        ?>
</section>


    <div class="sorting">
        <form action="index.php" method="post">
            <?php
        if(isset($_SESSION['useruid'])){    
        echo "<input type='submit' value='nameSort' name='nameSort' >";
        echo "<input type='submit' value='upload date sort' name='uploadSort'>";
        echo "<input type='submit' value='priceSort' name='priceSort' >";
        }
        ?>
     </form>
    </div>
    <div class="searchbar">
        <form method="post">
            <label for="search">searchhh</label>
            <input type="text" name="search" id="search">
            <input type="submit" value="submit" name="submit" id="submit">
        </form>
    </div>
 
    <div class="content">
    <a href="index.php">Home</a>
    &nbsp; &nbsp;
    <a href="post.php">Add Product</a>
   <h1><a href="index.php">Generation Z</a></h1>
    <!-- Remember that alternative syntax is good and html inside php is bad -->
   <?php while($row = $statement->fetch()): ?>

  
        <table>
            <tr>
                <th><a href="newWhere.php?id=<?= $row['product_id']?>"><?= $row['product_name']?></a></th>
            </tr>
            <tr>
            <?php if(strlen($row['product_description']) > 200): ?>
                        <td><?= substr($row['product_description'], 0, 200)?> ...<a href="newWhere.php?id=<?= $row['product_id']?>">Read Full Post</a></td>
                    <?php else: ?>
                        <td><?= $row['product_description']?></td>
                        <?php endif ?>
            </tr>
            <tr>
            <?php 
            $folder = "./image/". $row['product_image'];
            ?>
            <img src="<?= $folder ?>" alt="image:)">
            </tr>
        </table>
        <?php endwhile ?>
  
    </div>   
</body>
</html>
<?php

$con = new PDO("mysql:host=localhost;dbname=shopserver",'root','');

if (isset($_POST["submit"])) {
	$str = $_POST["search"];
	$sth = $con->prepare("SELECT * FROM `products` WHERE product_name LIKE '%$str%' LIMIT 10");

	$sth->setFetchMode(PDO:: FETCH_OBJ);
	$sth -> execute();

	if($row = $sth->fetch())
	{
		?>
		<br><br><br>
        <h1>Search Result !</h1>
		<table>
			<tr>
				<th>Name</th>
				<th>Description</th>
			</tr>
			<tr>
				<td><?php echo $row->product_name; ?></td>
				<td><?php echo $row->product_description;?></td>
			</tr>

		</table>
<?php 
	}
		
		
		else{
			echo "Name Does not exist";
		}


}

?>
