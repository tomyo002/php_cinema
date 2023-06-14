<?php
declare(strict_types=1);
namespace Html\Form;

use Entity\Exception\ParameterException;
use Entity\Movie;
use Html\StringEscaper;

class MovieForm
{
    use StringEscaper;

    private ?Movie $movie;

    public function __construct(?Movie $movie =null)
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
    <form name="movieform" method="post" action="$action" class="movie__form">
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
    <input name="posterid" type="number" value="{$this->movie?->getPosterId()}" placeholder="Facultatif" >
    </label>
    <label>
    Slogan
    <input name="tagline" type="text" value="{$this->escapeString($this->movie?->getTagline())}" required>
    </label>
     <label>
    durée
    <input name="runtime" type="number" value="{$this->movie?->getRuntime()}" required>
    </label>
     <label>
    langage original
    <input name="originallanguage" type="text" value="{$this->escapeString($this->movie?->getOriginalLanguage())}" required>
    </label>
    <button type="submit">Enregistrer</button>
</form>
HTML;
    }

    /**
     * @throws ParameterException
     */
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
            throw new ParameterException("le film n'a pas de résumé");
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
        if (!isset($_POST['runtime']) || empty($this->stripTagsAndTrim($_POST['runtime']))) {
            throw new ParameterException("le film n'a pas de duree");
        }
        if (!isset($_POST['originallanguage']) || empty($this->stripTagsAndTrim($_POST['originallanguage']))) {
            throw new ParameterException("le film n'a pas de langage original");
        }
        $movieposterid=null;
        if (isset($_POST['posterid']) ) {
            $movieposterid = $this->stripTagsAndTrim($_POST['posterid']);
        }
        $movietitle = $this->stripTagsAndTrim($_POST['title']);
        $movieoverview = $this->stripTagsAndTrim($_POST['overview']);
        $movieoriginaltitle = $this->stripTagsAndTrim($_POST['originaltitle']);
        $moviereleasedate = $this->stripTagsAndTrim($_POST['releasedate']);
        $movietagline = $this->stripTagsAndTrim($_POST['tagline']);
        $movieruntime = $this->stripTagsAndTrim($_POST['runtime']);
        $movieoriginallang = $this->stripTagsAndTrim($_POST['originallanguage']);

        $this->movie = Movie::create($movieId, $movietitle,$movieoverview,$movieoriginaltitle,$moviereleasedate,(int)$movieposterid,$movietagline,(int)$movieruntime,$movieoriginallang);
    }
}