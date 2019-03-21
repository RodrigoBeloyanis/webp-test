<?php

//$file='car.jpg';
//$file='logo.png';
$src = "logo.png";

//$image = imagecreatefromjpeg($file);
//$image = imagecreatefrompng($file);

//imagepalettetotruecolor($image);
//imagealphablending($image, true);
//imagesavealpha($image,true);	


//ob_start();
//imagejpeg($image,NULL,100);
//$cont = ob_get_contents();
//ob_end_clean();

//imagedestroy($image);
//$content = imagecreatefromstring($cont);
 
//imagewebp($image,'logoWebp.webp');
//imagepng($image,'logoPng.png');
//imagedestroy($content);

$im = new Imagick();
$im->pingImage($src);
$im->readImage($src);
$im->resizeImage(300,300,Imagick::FILTER_CATROM,1,TRUE); 
$im->setImageFormat( "webp" );
//$im->setOption('webp:method', '6'); 
$im->setOption('webp:lossless','true');
$im->writeImage('imagick.webp'); 

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> WEBP </title>
</head>

<body>
    <img src="logoWebp.webp" width="300">
    <img src="logoPng.png" width="300">
    <img src="tbwebp.php?w=300&h=170&img=logoWebp.webp" width="300">
</body> 

</html>