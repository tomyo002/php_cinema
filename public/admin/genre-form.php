<?php
declare(strict_types=1);

use Entity\Collection\genreCollection;
use Html\AppWebPage;

$webPage = new AppWebPage("filtre");
$webPage->appendHeader('<a href="../index.php" class="welcome">accueil</a>');
$webPage->appendContent(<<<HTML
    <form name="genre-form" action="../filtre.php">
    <label for="select">Choisir un genre:</label>
    <select name="genre" id="select">
        <option value="">--Please choose an option--</option>
HTML);
foreach(genreCollection::findAll() as $genre){
    $webPage->appendContent(<<<HTML
    <option value="{$genre->getId()}">{$genre->getName()}</option>
    HTML);
}
$webPage->appendContent(<<<HTML
    </select>
    </form>
HTML);
echo $webPage->toHTML();