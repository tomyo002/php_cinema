<?php
declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

class Genre
{
    private int $id;
    private string $name;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public static function findById(int $id): Genre
    {
        $pdo = MyPdo::getInstance()->prepare(
            <<<'SQL'
                SELECT id,name
                from genre
                where id = :idGenre
            SQL);
        $pdo->bindValue(':idGenre', $id);
        $pdo->execute();
        $pdo->setFetchMode(PDO::FETCH_CLASS, Genre::class);
        if (($genre = $pdo->fetch()) === false) {
            throw new EntityNotFoundException("l'id ne correspond à aucun genre");
        }
        return $genre;
    }
}