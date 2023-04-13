<?php

function imageResize($image){
    $image_image = imagecreatefrompng($image);
    $width = imagesx($image_image);
    $height= imagesy($image_image);

    $newWidth= 400;
    $newHeight= 400;
    $new_image= imagecreate($newWidth,$newHeight);

    imagecopyresized($new_image,$og_image,0,0,0,0,$newWidth,$newHeight,$width,$height);
    imagepng($new_image,$image);
    imagedestroy($image_image);
    imagedestroy($new_image);
}

$image_path = $_GET['path'];
imageResize($image_path);
echo"success";
header("Location:index.php");
?>