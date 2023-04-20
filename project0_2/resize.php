<?php

function imageResize($image, $filetype){
    if($filetype == 'png'){
        $image_ig = imagecreatefrompng($image);
    }
    else if($filetype == 'jpg' ||$filetype == 'jpeg' ){
        $og_image = imagecreatefromjpeg($image);
    }
    else{
        header("Location: index.php");
        exit();
    }   
    $width = imagesx($image_ig);
    $height= imagesy($image_ig);

    $newwidth= 400;
    $newheight= 400;
    $new_image= imagecreate($newwidth,$newheight);

    imagecopyresized($new_image,$og_image,0,0,0,0,$newwidth,$newheight,$width,$height);
    imagepng($new_image,$image);
    imagedestroy($image_ig);
    imagedestroy($new_image);
}

$image_path = $_GET['path'];
$filetype = $_GET['filetype'];
imageResize($image_path, $filetype);
header("Location: index.php");
?>

