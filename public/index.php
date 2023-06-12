<?php
declare(strict_types=1);


use Entity\Collection\MovieCollection;
use Html\AppWebPage;

$webPage = new AppWebPage('films');

$webPage->appendContent('<main class="list">');
foreach(MovieCollection::findAll() as $movie) {
    $webPage->appendContent(
        <<<HTML
<a href="movie.php?movieId={$movie->getId()}">
    <span>{$webPage->escapeString($movie->getTitle())}</span>
</a>

HTML
    );
}
$webPage->appendContent('</main>');
echo $webPage->toHTML();
