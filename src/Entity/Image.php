<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

class Image
{
    private int $id;
    private string $jpeg;

    /**
     * Accesseur d'id d'image
     * retourne une valeur sous forme d'entier
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Accesseur du jpeg d'image
     * retourne une valeur sous forme de chaîne de caractère
     *
     * @return string
     */
    public function getJpeg(): string
    {
        return $this->jpeg;
    }

    /**
     * Méthode de classe qui utilise une id en paramètre pour trouver et donner un objet image
     * retourne un objet image
     *
     * @param int $id
     * @return Image
     */
    public static function findById(int $id): Image
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
    SELECT *
    FROM image
    WHERE id = :id
SQL
        );
        $stmt->execute([':id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, Image::class);
        if (($image = $stmt->fetch()) === false) {
            throw new EntityNotFoundException("Pas d'image pour l'id {$id}");
        }
        return $image;
    }
}
