<?php
declare(strict_types=1);

use Entity\Collection\MovieCollection;
use Entity\Genre;
use Entity\Movie;
use Html\AppWebPage;

$webPage = new AppWebPage(' filtre films');
$webPage->appendHeader('<a href="index.php" class="welcome">accueil</a>');
$webPage->appendContent(<<<HTML
                        <div class="list">

                        HTML);
$genre = Genre::findById((int)$_POST['genre']);
foreach(MovieCollection::findByFilter($genre->getId()) as $movie)
{
    $webPage->appendContent(
        <<<HTML
        <a href="movie.php?movieId={$movie->getId()}" class="movie">
            <img src="image.php?imageId={$movie->getPosterId()}" class="img_movie">
            <span class="title">{$webPage->escapeString($movie->getTitle())}</span>
        </a>

HTML
    );
}
$webPage->appendContent('</div>');
echo $webPage->toHTML();
