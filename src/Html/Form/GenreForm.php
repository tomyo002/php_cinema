<?php

declare(strict_types=1);

namespace Html\Form;

use Entity\Collection\genreCollection;

class GenreForm
{
    public function getHtmlForm(string $action): string
    {
        $id = null;
        if(!empty($_POST['genre']) && ctype_digit($_POST['genre'])) {
            $id = (int)$_POST['genre'];
        }
        $form = <<<HTML
     <form name="genre-form" method="post" action="$action" class="genre__form">
    <label for="select">Choisir un genre:</label>
    <select name="genre" id="select">
        <option value="default">--choisir une option--</option>
HTML;
        foreach(genreCollection::findAll() as $genre) {
            if($id == $genre->getId()) {
                $form .= <<<HTML
         <option value="{$genre->getId()}"selected>{$genre->getName()}</option>
         HTML;
            } else {
                $form .= <<<HTML
         <option value="{$genre->getId()}">{$genre->getName()}</option>
HTML;
            }
        }
        $form.=<<<HTML
</select>
     <button type="submit">Selectionner</button>
    </form>
HTML;
        return $form;

    }
}
