<?php
declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;
use Entity\Movie;

try {
    if(! isset($_GET['movieId'])) {
        throw new ParameterException();
    }
    if (! ctype_digit($_GET['movieId'])) {
        throw new ParameterException();
    }
    $id = (int)$_GET['movieId'];
    $movie = Movie::findById($id);
    $movie->delete();
    header("location: ../index.php", $replace = true, $response_code = 302);
    exit();
} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}