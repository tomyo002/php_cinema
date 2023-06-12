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
    $movie = Movie::findById( (int)$_GET['movieId']);
} catch (EntityNotFoundException $e) {
    http_response_code(404);
    exit();
}
$peoples= $movie->getPeople();
$webPage->setTitle("Titre -".$movie->getTitle());
$webPage->appendContent(<<<HTML
<div class="movie__info">
    <img src="image.php?imageId={$movie->getPosterId()}">
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
foreach ($peoples as $people){
    $webPage->appendContent(<<<HTML
<div class="people__info">
<img src="image.php?imageId={$people->getAvatarId()}">
<div class="people__text">
    <div class="people__role">{$people->getRole($movie->getId())}-></div>
    <div class="people__name">{$people->getName()}</div>
</div>
</div>
HTML);
}
echo $webPage->toHTML();