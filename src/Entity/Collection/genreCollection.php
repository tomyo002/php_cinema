<?php
declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Genre;
use PDO;

class genreCollection
{
    private int $id;
    private string $name;

    public static function findAll(): array
    {
        $pdo = MyPdo::getInstance()->prepare(
            <<<'SQL'
                SELECT id, name
                from genre
                order by name
            SQL
        );
        $pdo->execute();
        $pdo->setFetchMode(PDO::FETCH_CLASS, Genre::class);
        return $pdo->fetchAll();
    }
}