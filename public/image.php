<?php
declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;
use Entity\Image;

try{
    if(!isset($_GET['imageId'])){
        throw new ParameterException("L' imageId n'est pas défini");
    }
    if(!ctype_digit($_GET['imageId'])){
        throw new ParameterException("imageId n'est pas un entier");
    }
    $image= Image::findById((int)$_GET['coverId']);
    header('Content-Type: image/jpeg');
    echo $image->getJpeg();
}catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}