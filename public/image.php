<?php

declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;
use Entity\Image;

try {
    if(empty($_GET['imageId'])) {
        if(isset($_GET['type'])&&$_GET['type']=='movie'){
            header('Location: /img/movie.jpeg',true,302);
            exit();
        }
        else{
            header('Location: /img/actor.jpeg',true,302);
            exit();
        }
    }
    if(!ctype_digit($_GET['imageId'])) {
        throw new ParameterException("imageId n'est pas un entier");
    }
    $image= Image::findById((int)$_GET['imageId']);
    header('Content-Type: image/jpeg');
    echo $image->getJpeg();
} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}
