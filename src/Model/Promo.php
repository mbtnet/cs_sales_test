<?php

namespace App\Model;

use App\Model\Promo\PromoInterface;

abstract class Promo implements PromoInterface
{
    abstract function isAvailable(array $products): bool;

    abstract function getPrice(array $products): float;
}
