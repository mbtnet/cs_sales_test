<?php

namespace App\Model;

abstract class Promo
{
    public function getName(): string
    {
        return self::class;
    }
}
