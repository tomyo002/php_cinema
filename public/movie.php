<?php
declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\Movie;
use Html\AppWebPage;

$webPage = new AppWebPage();

if (!isset($_GET['movieId'])) {
    header('Location: index.php', true, 302);
    exit();
}
if (!ctype_digit($_GET['movieId'])) {
    header('Location: index.php', true, 302);
    exit();
}
try {
    $movie = Movie::findById( $_GET['artistId']);
} catch (EntityNotFoundException $e) {
    http_response_code(404);
    exit();
}