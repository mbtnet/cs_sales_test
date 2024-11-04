<?php

namespace App\Model\Promo;

use App\Model\Product;

interface PromoInterface
{
    /**
     * @param Product[] $products
     */
    public function isAvailable(array $products): bool;

    /**
     * @param Product[] $products
     */
    public function getPrice(array $products): float;
}
