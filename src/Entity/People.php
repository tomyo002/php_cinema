<?php
declare(strict_types=1);
namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

class People
{
private int $id;
private int $avatarid;
private string $birthday;
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
     * @return int
     */
    public function getAvatarid(): int
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

}