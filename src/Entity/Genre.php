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
    public function getMovie():string
    {
        $pdo = MyPdo::getInstance()->prepare(
            <<<'SQL'
                SELECT movieId
                from movie_genre
                where genreId = :idGenre
            SQL
        );
        $pdo->bindValue(':idGenre', $this->getId());
        $pdo->execute();
        $pdo->setFetchMode(PDO::FETCH_CLASS, Genre::class);
        if (($genre = $pdo->fetch()) === false) {
            throw new EntityNotFoundException("l'id ne correspond à aucun film");
        }
        return $genre;
    }
}