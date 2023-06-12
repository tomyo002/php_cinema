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
$peoples= $movie->getPeople();
$webPage->setTitle("Titre -".$movie->getTitle());
$webPage->appendContent(<<<HTML
<div class="movie__info">
    <img src="image.php?movieId={$movie->getId()}">
    <div class="movie__text">
        <div class="title__date">
            <div class="movie__title">{$movie->getTitle()}</div>
            <div class="movie__date">{$movie->getReleaseDate()}</div>
            
        </div>
        <div class="movie__originalTitle">{$movie->getOriginalTitle()}</div>
        <div class="movie__TagLine">{$movie->getTagline()}</div>    
        <div class="movie__Overview">{$movie->getOverview()}</div>
    </div>
</div>
HTML
);