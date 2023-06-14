<?php
declare(strict_types=1);

namespace Html\Form;

use Entity\Collection\genreCollection;

class GenreForm
{
    public function getHtmlForm(string $action):string
    {
        $form = <<<HTML
     <form name="genre-form" method="post" action="$action" class="genre__form">
    <label for="select">Choisir un genre:</label>
    <select name="genre" id="select">
        <option value="default">--Please choose an option--</option>
HTML;
        foreach(genreCollection::findAll() as $genre) {
            $form.= <<<HTML
         <option value="{$genre->getId()}">{$genre->getName()}</option>
HTML;

        }
        $form.=<<<HTML
</select>
     <button type="submit">Selectionner</button>
    </form>
HTML;
        return $form;

    }
}