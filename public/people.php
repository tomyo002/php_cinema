<?php
declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\People;
use Html\AppWebPage;

$webPage = new AppWebPage();

if (!isset($_GET['peopleId'])) {
    header('Location: index.php', true, 302);
    exit();
}
if (!ctype_digit($_GET['peopleId'])) {
    header('Location: index.php', true, 302);
    exit();
}
try {
    $people = People::findById( $_GET['peopleId']);
} catch (EntityNotFoundException $e) {
    http_response_code(404);
    exit();
}
$movies= $people->getMovie();
$webPage->setTitle('Films-'.$people->getName());
$webPage->appendContent(<<<HTML
                        <div class="people">
                            <img src="image.php?{$people->getAvatarid()}">
                            <article class="description">
                                    <span>{$people->getName()}</span>
                                    <span>{$people->getPlaceOfBirth()}</span>
                        HTML);
$dateOfDead='';
if($people->getDeathday() !=null) {
    $dateOfDead=$people->getDeathday();
}
$webPage->appendContent(<<<HTML
                                <article class="year">
                                    <span>{$people->getBirthday()}</span>
                                    <h1>-</h1>
                                    <span>$dateOfDead</span>
                                </article>
                                <span>{$people->getBiography()}</span>
                            </article>
                        </div>
                        HTML);
foreach ($movies as $movie){
    $webPage->appendContent(<<<HTML
<div class="movie">
<img src="image.php?imageId={$movie->getPosterId()}">
<div class="movie__text">
    <div class="movie__name">{$movie->getTitle()}</div>
    <div class="movie__date">{$movie->getDate()}</div>
    <div class="movie__role">{$people->getRole($movie->getId())}-></div>
    
</div>
</div>
HTML);
}
echo $webPage->toHTML();