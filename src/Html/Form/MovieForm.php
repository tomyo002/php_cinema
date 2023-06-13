<?php
declare(strict_types=1)
namespace Html\Form;

use Entity\Exception\ParameterException;
use Entity\Movie;
use Html\StringEscaper;

class MovieForm
{
    use StringEscaper;

    private ?Movie $movie;

    private function __construct(?Movie $movie)
    {
        $this->movie = $movie;
    }

    /**
     * @return Movie|null
     */
    public function getMovie(): ?Movie
    {
        return $this->movie;
    }

    public function getHtmlForm(string $action): string
    {
        return <<<HTML
    <form name="movieform" method="post" action="$action">
    <input name="id" type="hidden" value="{$this->movie?->getId()}">
    <label>
    Titre
    <input name="title" type="text" value="{$this->escapeString($this->movie?->getTitle())}" required>
    </label>
    <label>
    Resumé
    <input name="overview" type="text" value="{$this->escapeString($this->movie?->getOverview())}" required>
    </label>
    <label>
    Titre originel
    <input name="originaltitle" type="text" value="{$this->escapeString($this->movie?->getOriginalTitle())}" required>
    </label>
    <label>
    Date de sortie
    <input name="releasedate" type="text" value="{$this->escapeString($this->movie?->getReleaseDate())}" required>
    </label>
    <label>
    Id du Poster
    <input name="posterid" type="text" value="{$this->escapeString($this->movie?->getPosterId())}" placeholder="Facultatif" >
    </label>
    <label>
    Slogan
    <input name="tagline" type="text" value="{$this->escapeString($this->movie?->getTagline())}" required>
    </label>
    <button type="submit">Enregistrer</button>
</form>
HTML;
    }
    public function setEntityFromQueryString(): void
    {
        $movieId = null;
        if (isset($_POST['id']) && ctype_digit($_POST['id'])) {
            $movieId = (int)$_POST['id'];
        }
        if (!isset($_POST['title']) || empty($this->stripTagsAndTrim($_POST['title']))) {
            throw new ParameterException("le film n'a pas de titre");
        }
        if (!isset($_POST['overview']) || empty($this->stripTagsAndTrim($_POST['overview']))) {
            throw new ParameterException("le film n'a pas de resumé");
        }
        if (!isset($_POST['originaltitle']) || empty($this->stripTagsAndTrim($_POST['originaltitle']))) {
            throw new ParameterException("le film n'a pas de titre original");
        }
        if (!isset($_POST['releasedate']) || empty($this->stripTagsAndTrim($_POST['releasedate']))) {
            throw new ParameterException("le film n'a pas de date de sortie");
        }
        if (!isset($_POST['tagline']) || empty($this->stripTagsAndTrim($_POST['tagline']))) {
            throw new ParameterException("le film n'a pas de slogan");
        }
        $movieposterid=null;
        if (isset($_POST['tagline']) ) {
            $movieposterid = $this->stripTagsAndTrim($_POST['posterid']);
        }
        $movietitle = $this->stripTagsAndTrim($_POST['title']);
        $movieoverview = $this->stripTagsAndTrim($_POST['overview']);
        $movieoriginaltitle = $this->stripTagsAndTrim($_POST['originaltitle']);
        $moviereleasedate = $this->stripTagsAndTrim($_POST['releasedate']);
        $movietagline = $this->stripTagsAndTrim($_POST['tagline']);

        $this->movie = Movie::create($movieId, $movietitle,$movieoverview,$movieoriginaltitle,$moviereleasedate,$movietagline,$movieposterid);
    }
}