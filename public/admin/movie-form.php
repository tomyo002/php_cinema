<?php

declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;
use Entity\Movie;
use Html\AppWebPage;
use Html\Form\MovieForm;

try {
    $appWebPage= new AppWebPage("Information Film");
    $movie= null;
    if(isset($_GET['movieId'])) {
        if(!ctype_digit($_GET['movieId'])) {
            throw new ParameterException();
        }
        $movie = Movie::findById((int)$_GET['movieId']);
    }
    $movieForm = new movieForm($movie);
    $appWebPage->appendContent($movieForm->getHtmlForm("movie-save.php"));
    echo $appWebPage->toHTML();
} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}
