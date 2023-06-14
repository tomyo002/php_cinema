<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

class Movie
{
    private ?int $id;
    private ?int $posterId;
    private string $originalLanguage;
    private string $originalTitle;
    private string $overview;
    private string $releaseDate;
    private int $runtime;
    private string $tagline;
    private string $title;

    /**
     * Accesseur d'id de film
     * retourne une valeur sous form de chiffre ou null
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Accesseur du posterId de film
     * retourne une valeur sous forme de chiffre ou null
     *
     * @return int|null
     */
    public function getPosterId(): ?int
    {
        return $this->posterId;
    }

    /**
     * Accesseur de la langue originale de film
     * retourne une valeur sous forme de chaîne de caractère
     *
     * @return string
     */
    public function getOriginalLanguage(): string
    {
        return $this->originalLanguage;
    }

    /**
     * Accesseur du titre original de film
     * retourne une valeur sous forme de chaîne de caractère
     *
     * @return string
     */
    public function getOriginalTitle(): string
    {
        return $this->originalTitle;
    }

    /**
     * Accesseur du résumé de film
     * retourne une valeur sous forme de chaîne de caractère
     *
     * @return string
     */
    public function getOverview(): string
    {
        return $this->overview;
    }

    /**
     * Accesseur de la date de réalisation de film
     * retourne une valeur sous forme de chaîne de caractère
     *
     * @return string
     */
    public function getReleaseDate(): string
    {
        return $this->releaseDate;
    }

    /**
     * Accesseur de la durée du film
     * retourne une valeur sous forme de chiffre
     *
     * @return int
     */
    public function getRuntime(): int
    {
        return $this->runtime;
    }

    /**
     * Accesseur du slogan du film
     * retourne une valeur sous forme de chaîne de caractère
     *
     * @return string
     */
    public function getTagline(): string
    {
        return $this->tagline;
    }

    /**
     * Accesseur du titre du film
     * retourne une valeur sous forme de chaîne de caractère
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Modificateur d'id qui prend en paramètre un int ou null
     * ne retourne rien
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * Modificateur de posterId qui prend en paramètre un int ou null
     * ne retourne rien
     *
     * @param int|null $posterId
     */
    public function setPosterId(?int $posterId): void
    {
        $this->posterId = $posterId;
    }

    /**
     * Modificateur d'id qui prend en paramètre un string
     * ne retourne rien
     *
     * @param string $originalLanguage
     */
    public function setOriginalLanguage(string $originalLanguage): void
    {
        $this->originalLanguage = $originalLanguage;
    }

    /**
     * Modificateur d'id qui prend en paramètre un string
     * ne retourne rien
     *
     * @param string $originalTitle
     */
    public function setOriginalTitle(string $originalTitle): void
    {
        $this->originalTitle = $originalTitle;
    }

    /**
     * Modificateur d'id qui prend en paramètre un string
     * ne retourne rien
     *
     * @param string $overview
     */
    public function setOverview(string $overview): void
    {
        $this->overview = $overview;
    }

    /**
     * Modificateur d'id qui prend en paramètre un string
     * ne retourne rien
     *
     * @param string $releaseDate
     */
    public function setReleaseDate(string $releaseDate): void
    {
        $this->releaseDate = $releaseDate;
    }

    /**
     * Modificateur d'id qui prend en paramètre un int
     * ne retourne rien
     *
     * @param int $runtime
     */
    public function setRuntime(int $runtime): void
    {
        $this->runtime = $runtime;
    }

    /**
     * Modificateur d'id qui prend en paramètre un string
     * ne retourne rien
     *
     * @param string $tagline
     */
    public function setTagline(string $tagline): void
    {
        $this->tagline = $tagline;
    }

    /**
     * Modificateur d'id qui prend en paramètre un string
     * ne retourne rien
     *
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Méthode de classe qui récupère un film avec l'id pris en paramètre
     * retourne un objet film
     *
     * @param int $id
     * @return Movie
     */
    public static function findById(int $id): Movie
    {
        $pdo = MyPdo::getInstance()->prepare(
            <<<'SQL'
                SELECT id, posterId, originalLanguage, originalTitle, overview, releaseDate, runtime, tagline, title
                from movie
                where id = :idMovie
            SQL
        );
        $pdo->bindValue(':idMovie', $id);
        $pdo->execute();
        $pdo->setFetchMode(PDO::FETCH_CLASS, Movie::class);
        if (($movie = $pdo->fetch()) === false) {
            throw new EntityNotFoundException("l'id ne correspond à aucun film");
        }
        return $movie;
    }

    /**
     * Accesseur des acteurs de film
     * retourne un tableau d'acteur
     *
     * @return People
     */
    public function getPeople(): array
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
    SELECT id,avatarid,birthday,deathday,name,biography,placeOfBirth
    FROM people p 
    WHERE p.id IN(SELECT peopleId
                  FROM cast
                  WHERE movieId= :id)
SQL
        );
        $stmt->execute([':id' => $this->getId()]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, People::class);
        if (($people = $stmt->fetchAll()) === false) {
            throw new EntityNotFoundException("Pas de People pour l'id {$this->getId()}");
        }
        return $people;

    }

    /**
     * Méthode de classe qui crée un objet avec les paramètres
     * retourne un objet film
     *
     * @param int|null $id
     * @param string $title
     * @param string $overview
     * @param string $originalTitle
     * @param string $releaseDate
     * @param int|null $posterId
     * @param string $tagline
     * @param int $runtime
     * @param string $originallanguage
     * @return Movie
     */
    public static function create(?int $id,string $title,string $overview,string $originalTitle,string $releaseDate,?int $posterId,string $tagline,int $runtime,string $originallanguage):Movie
    {
        $movie = new Movie();
        $movie->setId($id);
        $movie->setTagline($tagline);
        $movie->setTitle($title);
        $movie->setOverview($overview);
        $movie->setOriginalTitle($originalTitle);
        $movie->setReleaseDate($releaseDate);
        $movie->setPosterId((int)$posterId);
        $movie->setRuntime((int)$runtime);
        $movie->setOriginalLanguage($originallanguage);
        return $movie;
    }

    /**
     * Méthode qui supprime l'objet de la base de donnée
     * retourne lui-même
     *
     * @return $this
     */
    public function delete(): Movie
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
    DELETE FROM movie
    WHERE id = :movieId;
    DELETE FROM cast
    WHERE movieid = :movieId;
    DELETE FROM movie_genre
    WHERE movieId= :movieId;
SQL
        );
        $stmt->execute([':movieId' => $this->getId()]);
        $this->setId(null);
        return $this;
    }

    /**
     * Méthode qui met à jour les données de la base
     * retourne lui-même
     *
     * @return $this
     */
    public function update(): Movie
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
    UPDATE movie
    set title= :movietitle,
    tagline= :movietagline,
    releaseDate= str_to_date(:moviereleasedate,"%Y-%m-%d"),
    overview= :movieOverview,
    originaltitle= :movieoriginaltitle,
    runtime = :movieruntime,
    originallanguage= :movieoriginallanguage
    WHERE id = :movieid
SQL
        );
        $stmt->execute([':movietitle' => $this->getTitle(), ':movietagline' => $this->getTagline(),':movieid'=>$this->getId(),':moviereleasedate'=>$this->getReleaseDate(),':movieOverview'=>$this->getOverview(),':movieoriginaltitle'=>$this->getOriginalTitle(),':movieruntime'=>$this->getRuntime(),':movieoriginallanguage'=>$this->getOriginalLanguage()]);
        return $this;
    }

    /**
     * Méthode qui insert une donnée de la base
     * retourne lui-même
     *
     * @return $this
     */
    public function insert(): Movie
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
    INSERT INTO movie (title,tagline,releasedate,overview,originaltitle,runtime,originallanguage)
    VALUES(:movietitle,:movietagline,str_to_date(:moviedate,"%Y-%m-%d"),:movieoverview,:movieoriginaltitle,:movieruntime,:movieorignallanguage)
SQL
        );
        $stmt->execute([':movietitle'=>$this->getTitle(),':movietagline'=>$this->getTagline(),':moviedate'=>$this->getReleaseDate(),':movieoverview'=>$this->getOverview(),':movieoriginaltitle'=>$this->getOriginalTitle(),':movieruntime'=>$this->getRuntime(),':movieorignallanguage'=>$this->getOriginalLanguage()]);
        $this->setId((int) MyPdo::getInstance()->lastInsertId());
        return $this;
    }

    /**
     * Méthode qui utilise insert ou update en fonction de l'id du film
     * retourne lui-même
     *
     * @return $this
     */
    public function save(): Movie
    {
        if ($this->getId() === null) {
            $this->insert();
        } else {
            $this->update();
        }
        return $this;
    }

    /**
     * Méthode qui découpe la date du film est la donne en français
     * retourne une date
     * @return string
     */
    public function getReleaseDateVisual():string
    {
        $date = explode('-',$this->releaseDate);
        $year = $date[0];
        $month = $date[1];
        $day = $date[2];
        return "$day/$month/$year";
    }
}
