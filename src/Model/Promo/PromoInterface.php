<?php

namespace App\Model\Promo;

interface PromoInterface
{
    /**
     * @param Products[] $products
     */
    public function isAvailable(array $products): bool;

    /**
     * @param Products[] $products
     */
    public function getPrice(array $products): float;
}
