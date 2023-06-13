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
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getPosterId(): int
    {
        return $this->posterId;
    }

    /**
     * @return string
     */
    public function getOriginalLanguage(): string
    {
        return $this->originalLanguage;
    }

    /**
     * @return string
     */
    public function getOriginalTitle(): string
    {
        return $this->originalTitle;
    }

    /**
     * @return string
     */
    public function getOverview(): string
    {
        return $this->overview;
    }

    /**
     * @return string
     */
    public function getReleaseDate(): string
    {
        return $this->releaseDate;
    }

    /**
     * @return int
     */
    public function getRuntime(): int
    {
        return $this->runtime;
    }

    /**
     * @return string
     */
    public function getTagline(): string
    {
        return $this->tagline;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param int $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param int $posterId
     */
    public function setPosterId(?int $posterId): void
    {
        $this->posterId = $posterId;
    }

    /**
     * @param string $originalLanguage
     */
    public function setOriginalLanguage(string $originalLanguage): void
    {
        $this->originalLanguage = $originalLanguage;
    }

    /**
     * @param string $originalTitle
     */
    public function setOriginalTitle(string $originalTitle): void
    {
        $this->originalTitle = $originalTitle;
    }

    /**
     * @param string $overview
     */
    public function setOverview(string $overview): void
    {
        $this->overview = $overview;
    }

    /**
     * @param string $releaseDate
     */
    public function setReleaseDate(string $releaseDate): void
    {
        $this->releaseDate = $releaseDate;
    }

    /**
     * @param int $runtime
     */
    public function setRuntime(int $runtime): void
    {
        $this->runtime = $runtime;
    }

    /**
     * @param string $tagline
     */
    public function setTagline(string $tagline): void
    {
        $this->tagline = $tagline;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

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
    public static function create(?int $id,string $title,string $overview,string $originalTitle,string $releaseDate,?string $posterId=null,string $tagline):Movie
    {
        $movie = new Movie();
        $movie->setId($id);
        $movie->setTagline($tagline);
        $movie->setTitle($title);
        $movie->setOverview($overview);
        $movie->setOriginalTitle($originalTitle);
        $movie->setReleaseDate($releaseDate);
        $movie->setPosterId($posterId);
        return $movie;
    }
    public function delete(): Movie
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
    DELETE FROM movie
    WHERE id = :movieId
SQL
        );
        $stmt->execute([':movieId' => $this->getId()]);
        $this->setId(null);
        return $this;
    }
    public function update(): Movie
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
    UPDATE Artist
    set title= :movietitle,
    tagline= :movietagline,
    releaseDate= :moviereleasedate,
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

    public function insert(): Movie
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
    INSERT INTO Movie (title,tagline,releasedate,overview,orignaltitle,runtime,originallanguage)
    VALUES(:movietitle,:movietagline,:moviedate,:movieoverview,:movieoriginaltitle,:movieruntime,:movieorignallanguage)
SQL
        );
        $stmt->execute([':movietitle'=>$this->getTitle(),':movietagline'=>$this->getTagline(),':moviedate'=>$this->getReleaseDate(),':movieoverview'=>$this->getOverview(),':movieoriginaltitle'=>$this->getOriginalTitle(),':movieruntime'=>$this->getRuntime(),':movieorignallanguage'=>$this->getOriginalLanguage()]);
        $this->setId((int) MyPdo::getInstance()->lastInsertId());
        return $this;
    }

    public function save(): Movie
    {
        if ($this->getId() === null) {
            $this->insert();
        } else {
            $this->update();
        }
        return $this;
    }
}
