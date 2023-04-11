<?php

/*******w******** 
    
    Name: Hardik Bhardwaj
    Date: 2023-02-05
    Description: Making a blog website using php.

****************/

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
$statement = $db->prepare($query);  

// Execution on the DB server is delayed until we execute().
$statement->execute(); 




 


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Welcome to our online shop!</title>
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
    <div class="sorting">
        <form action="index.php" method="post">
        <input type="submit" value="nameSort" name="nameSort" >
        <input type="submit" value="upload date sort" name="uploadSort">
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
