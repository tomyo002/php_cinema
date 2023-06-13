<?php

declare(strict_types=1);


use Entity\Collection\MovieCollection;
use Html\AppWebPage;

$webPage = new AppWebPage('films');
$webPage->appendMenu(<<<HTML
    <a href="admin/movie_form.php">ajouter</a>
HTML);
$webPage->appendContent(<<<HTML
                        <div class="list">

                        HTML);
foreach(MovieCollection::findAll() as $movie) {
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
