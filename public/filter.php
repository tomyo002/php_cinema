<?php

declare(strict_types=1);

use Entity\Collection\MovieCollection;
use Entity\Genre;
use Html\AppWebPage;
use Html\Form\GenreForm;

if($_POST['genre']== "default") {
    header('Location: index.php', true, 302);
    exit();
}
$genre = Genre::findById((int)$_POST['genre']);
$webPage = new AppWebPage('films - '.$genre->getName());
$webPage->appendMenu(<<<HTML
    <a href="admin/movie-form.php">ajouter</a>
HTML);
$formGenre = new GenreForm();
$webPage->appendMenu($formGenre->getHtmlForm("filter.php"));
$webPage->appendHeader('<a href="index.php" class="welcome">accueil</a>');
$webPage->appendContent(<<<HTML
                        <div class="list">

                        HTML);

foreach(MovieCollection::findByFilter($genre->getId()) as $movie) {
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
