<?php

declare(strict_types=1);

namespace Entity;

trait transformFrenchDate
{
    /**
     * Transforme une date en française prise en paramètre
     * retourne une valeur sous forme de chaîne de caractère
     *
     * @param string $date
     * @return string
     */
    public function transformFrenchDate(string $date): string
    {
        return implode('/', array_reverse(explode('-', $date)));
    }
}
