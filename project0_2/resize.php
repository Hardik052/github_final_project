<?php

function resize_image($image, $extension){
    if($extension == 'png'){
        $image_ig = imagecreatefrompng($image);
    }
    else if($extension == 'jpg' ||$extension == 'jpeg' ){
        $image_ig = imagecreatefromjpeg($image);
    }
    else{
        header("Location: index.php");
        exit();
    }   
    $width = imagesx($image_ig);
    $height= imagesy($image_ig);

    $newwidth= 500;
    $newheight= 500;
    $new_image= imagecreate($newwidth,$newheight);

    imagecopyresized($new_image,$image_ig,0,0,0,0,$newwidth,$newheight,$width,$height);
    imagepng($new_image,$image);
    imagedestroy($image_ig);
    imagedestroy($new_image);
}

$image = $_GET['image'];
$extension = $_GET['extension'];
resize_image($image, $extension);
header("Location: index.php");
?>

