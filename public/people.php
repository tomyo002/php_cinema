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
    $people = People::findById((int)$_GET['peopleId']);
} catch (EntityNotFoundException $e) {
    http_response_code(404);
    exit();
}
$movies= $people->getMovie();
$webPage->setTitle('Films-'.$people->getName().'<a href="index.php" class="welcome">accueil</a>');
$webPage->appendContent(<<<HTML
                            <div class="people">
                                        <img src="image.php?imageId={$people->getAvatarId()}&type=actor" class="img__actor">
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
                                                <span class="date__bird">{$people->getBirthday()}</span>
                                                <h1>-</h1>
                                                <span class="date__Death">$dateOfDead</span>
                                            </article>
                                            <span>{$people->getBiography()}</span>
                                        </article>
                                    </div>

                        HTML);
foreach ($movies as $movie){
    $webPage->appendContent(<<<HTML
            <a href="movie.php?movieId={$movie->getId()}" class="lienMovie">
                <div class="movie__info">
                    <img src="image.php?imageId={$movie->getPosterId()}" class="img_movie_fromPeople">
                    <div class="movie__text2">
                        <div class="movie__text3">
                            <span class="movie__name">{$movie->getTitle()}</span>
                            <span class="movie__date">{$movie->getReleaseDate()}</span>
                        </div>  
                            <span class="movie__role">{$people->getRole($movie->getId())}</span>
                            
                    </div>
                </div>
            </a>

HTML);
}
echo $webPage->toHTML();
