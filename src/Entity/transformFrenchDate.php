<?php
declare(strict_types=1);

namespace Entity;

trait transformFrenchDate
{
    public function transformFrenchDate(string $date):string
    {
        return implode('/', array_reverse(explode('-', $date)));
    }
}