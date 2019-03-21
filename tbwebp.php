<?php

ini_set('date.timezone','America/Sao_Paulo');
ini_set('allow_url_fopen',1);
ini_set('allow_url_include',1);
ini_set('file_put_contents',1);
ini_set('output_buffering',4096);
ini_set('magic_quotes_gpc','Off');
ini_set('memory_limit','1024M');
ini_set('upload_max_filesize','100M');
ini_set('post_max_size','100M');
ini_set('max_execution_time','60');
ini_set('max_input_nesting_level',256);

error_reporting(0); 
//ini_set('display_errors',0); 

if(!is_dir('./cache/')){mkdir('./cache/', 0777);}

if(empty($_GET['w']) || empty($_GET['h'] || empty($_GET['img']))){ exit; }

define('DESIRED_IMAGE_WIDTH', $_GET['w']);
define('DESIRED_IMAGE_HEIGHT', $_GET['h']);

list($source_width, $source_height, $source_type) = getimagesize($_GET['img']);

$hash = md5($_GET['w'] . $_GET['h'] . $_GET['img'] . $source_width . $source_height . $source_type) . ".txt";

if(!file_exists('cache/'.$hash)){

    $source_gdim = imagecreatefromwebp($_GET['img']);

    imagepalettetotruecolor($source_gdim);
    imagealphablending($source_gdim, true);
    imagesavealpha($source_gdim,true);	

    $source_aspect_ratio = $source_width / $source_height;

    $desired_aspect_ratio = DESIRED_IMAGE_WIDTH / DESIRED_IMAGE_HEIGHT;

    if ($source_aspect_ratio > $desired_aspect_ratio) {

        $temp_height = DESIRED_IMAGE_HEIGHT;
        $temp_width = ( int ) (DESIRED_IMAGE_HEIGHT * $source_aspect_ratio);

    } else {

        $temp_width = DESIRED_IMAGE_WIDTH;
        $temp_height = ( int ) (DESIRED_IMAGE_WIDTH / $source_aspect_ratio);

    }

    $temp_gdim = imagecreatetruecolor($temp_width, $temp_height);

    imagefill($temp_gdim,0,0,0x7fff0000);
    imagepalettetotruecolor($temp_gdim);
    imagealphablending($temp_gdim, true);
    imagesavealpha($temp_gdim,true);	

    imagecopyresampled($temp_gdim, $source_gdim, 0, 0, 0, 0, $temp_width, $temp_height, $source_width, $source_height);

    $desired_gdim = imagecreatetruecolor(DESIRED_IMAGE_WIDTH, DESIRED_IMAGE_HEIGHT);

    imagefill($desired_gdim,0,0,0x7fff0000);
    imagepalettetotruecolor($desired_gdim);
    imagealphablending($desired_gdim, true);
    imagesavealpha($desired_gdim,true);	

    imagecopy($desired_gdim, $temp_gdim, 0, 0, ($temp_width - DESIRED_IMAGE_WIDTH) / 2, ($temp_height - DESIRED_IMAGE_HEIGHT) / 2, DESIRED_IMAGE_WIDTH, DESIRED_IMAGE_HEIGHT);

    imagewebp($desired_gdim,'cache/'.$hash);

} 

header('Content-type: image/webp');
readfile('cache/'.$hash);
