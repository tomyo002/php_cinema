<?php

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use Entity\Movie;
use PDO;

class MovieCollection
{
    public static function findAll(): array
    {
        $pdo = MyPdo::getInstance()->prepare(
            <<<'SQL'
                SELECT id, posterId, originalLanguage, originalTitle, overview, releaseDate, runtime, tagline, title
                from movie
                order by title
            SQL
        );
        $pdo->execute();
        $pdo->setFetchMode(PDO::FETCH_CLASS, Movie::class);
        return $pdo->fetchAll();
    }
    public static function findByFilter(int $idFilter): array|false
    {

        $pdo = MyPdo::getInstance()->prepare(
            <<<'SQL'
                SELECT id, posterId, originalLanguage, originalTitle, overview, releaseDate, runtime, tagline, title
                from movie
                where id in (select movieId
                            from movie_genre
                            where genreId = :idGenre)
                
                SQL);
        $pdo->bindValue(':idGenre', $idFilter);
        $pdo->execute();
        $pdo->setFetchMode(PDO::FETCH_CLASS, Movie::class);
        if (($movie = $pdo->fetchAll()) === false) {
            throw new EntityNotFoundException("l'id ne correspond à aucun film");
        }
        return $movie;
    }
}
