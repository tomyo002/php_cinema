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
$webPage->appendHeader('<a href="index.php" class="welcome">accueil</a>');
$webPage->appendMenu(<<<HTML
    <a href="admin/movie-form.php?movieId={$movie->getId()}">modifier</a>
    <a href="admin/movie-delete.php?movieId={$movie->getId()}">supprimer</a>
HTML


);
$webPage->appendContent(<<<HTML
<div class="movie__info">
    <img src="image.php?imageId={$movie->getPosterId()}&type=movie" class="img_movie">
    <div class="movie__text">
        <div class="title__date">
            <div class="movie__title">{$movie->getTitle()}</div>
            <div class="movie__date">{$movie->getReleaseDateVisual()}</div>           
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
<a href="people.php?peopleId={$people->getId()}">
<div class="people__info">
<img src="image.php?imageId={$people->getAvatarId()}&type=actor">
<div class="people__text">
    <div class="people__role">{$people->getRole($movie->getId())}</div>
    <div class="people__name">{$people->getName()}</div>
</div>
</div>
</a>
HTML);
}
echo $webPage->toHTML();