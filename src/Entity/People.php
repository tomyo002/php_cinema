<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

class People
{
    private int $id;
    private ?int $avatarid;
    private ?string $birthday;
    private ?string $deathday;
    private string $name;
    private string $biography;
    private string $placeOfBirth;

    /**
     * Accesseur d'id de people
     * retourne une valeur sous forme de chiffre
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Accesseur d'avatarId de people
     * retourne une valeur sous forme de chiffre ou null
     *
     * @return int|null
     */
    public function getAvatarId(): ?int
    {
        return $this->avatarid;
    }

    /**
     * Accesseur la date de naissance de people
     * retourne une valeur sous forme de chaîne de caractère
     *
     * @return string
     */
    public function getBirthday(): string
    {
        return $this->birthday;
    }

    /**
     * Accesseur la date de mort de people
     * retourne une valeur sous forme de chaîne de caractère ou null
     *
     * @return string|null
     */
    public function getDeathday(): ?string
    {
        return $this->deathday;
    }

    /**
     * Accesseur le nom de people
     * retourne une valeur sous forme de chaîne de caractère
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Accesseur la biographie de people
     * retourne une valeur sous forme de chaîne de caractère
     *
     * @return string
     */
    public function getBiography(): string
    {
        return $this->biography;
    }

    /**
     * Accesseur du lieu de naissance de people
     * retourne une valeur sous forme de chaîne de caractère
     *
     * @return string
     */
    public function getPlaceOfBirth(): string
    {
        return $this->placeOfBirth;
    }

    /**
     * Méthode qui donne le rôle de l'acteur avec l'id du film pris en paramètre
     * retourne une chaîne de caractère
     *
     * @param int $movieId
     * @return string
     */
    public function getRole(int $movieId): string
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
    SELECT role
    FROM cast
    WHERE peopleid= :id 
    AND movieId=:movieId
SQL
        );
        $stmt->execute([':id' => $this->getId(),':movieId'=>$movieId]);
        return $stmt->fetch()['role'];
    }

    /**
     * Méthode de classe qui récupère un people avec l'id pris en paramètre
     * retourne un objet people
     *
     * @param int $id
     * @return People
     */
    public static function findById(int $id): People
    {
        $pdo= MyPdo::getInstance()->prepare(
            <<<'SQL'
            select id, avatarid, birthday, deathday, name, biography, placeOfBirth
            from people
            where id = :peopleId
            SQL
        );
        $pdo->bindValue(':peopleId', $id);
        $pdo->execute();
        $pdo->setFetchMode(PDO::FETCH_CLASS, People::class);
        if (($people = $pdo->fetch()) === false) {
            throw new EntityNotFoundException("l'id ne correspond à aucun acteur");
        }
        return $people;
    }

    /**
     * Accesseur des films joué par l'acteur
     * retourne un tableau de film
     *
     * @return Movie
     */
    public function getMovie(): array
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
    SELECT id, posterId, originalLanguage, originalTitle, overview, releaseDate, runtime, tagline, title
    FROM movie m
    WHERE m.id IN(SELECT movieId
                  FROM cast
                  WHERE peopleId= :id)
SQL
        );
        $stmt->execute([':id' => $this->getId()]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, Movie::class);
        if (($movie = $stmt->fetchAll()) === false) {
            throw new EntityNotFoundException("Pas de film pour l'id {$this->getId()}");
        }
        return $movie;

    }

    /**
     * Méthode qui découpe la date de naissance est la donne en français
     * retourne une date
     * @return string
     */
    public function getBirthdayVisual(): string
    {
        $date = explode('-', $this->birthday);
        $year = $date[0];
        $month = $date[1];
        $day = $date[2];
        return "$day/$month/$year";
    }

    /**
     * Méthode qui découpe la date de mort est la donne en français
     * retourne une date
     * @return string
     */
    public function getDeathdayVisual(): string
    {
        $date = explode('-', $this->deathday);
        $year = $date[0];
        $month = $date[1];
        $day = $date[2];
        return "$day/$month/$year";
    }
}
