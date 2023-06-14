<?php

declare(strict_types=1);

use Entity\Exception\ParameterException;
use Html\Form\MovieForm;

try {
    $movieForm = new MovieForm();
    $movieForm->setEntityFromQueryString();
    $movie=$movieForm->getMovie();
    $movie->save();
    header("location: ../index.php", $replace = true, $response_code = 302);
    exit();
} catch (ParameterException) {
    http_response_code(400);
} catch (Exception) {
    http_response_code(500);
}
