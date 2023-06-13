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
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getAvatarId(): ?int
    {
        return $this->avatarid;
    }

    /**
     * @return string
     */
    public function getBirthday(): string
    {
        return $this->birthday;
    }

    /**
     * @return string|null
     */
    public function getDeathday(): ?string
    {
        return $this->deathday;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getBiography(): string
    {
        return $this->biography;
    }

    /**
     * @return string
     */
    public function getPlaceOfBirth(): string
    {
        return $this->placeOfBirth;
    }
    public function getRole(int $movieId):string
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

    public static function findById(int $id): People
    {
        $pdo= MyPdo::getInstance()->prepare(
            <<<'SQL'
            select id, avatarid, birthday, deathday, name, biography, placeOfBirth
            from people
            where id = :peopleId
            SQL);
        $pdo->bindValue(':peopleId',$id);
        $pdo->execute();
        $pdo->setFetchMode(PDO::FETCH_CLASS, People::class);
        if (($people = $pdo->fetch()) === false) {
            throw new EntityNotFoundException("l'id ne correspond à aucun acteur");
        }
        return $people;
    }
    public function getMovie():array
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
}