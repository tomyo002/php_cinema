<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

class Movie
{
    private int $id;
    private int $posterId;
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
}
