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
