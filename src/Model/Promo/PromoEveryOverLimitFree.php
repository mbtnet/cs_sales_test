<?php

namespace App\Model\Promo;

class PromoEveryOverLimitFree implements PromoInterface
{
    const PRODUCTS_LIMIT = 4;

    /**
     * @param Products[] $products
     */
    public function isAvailable(array $products): bool
    {
        return count($products) > self::PRODUCTS_LIMIT;
    }

    /**
     * @param Products[] $products
     */
    public function getPrice(array $products): float
    {
        // The question is: which products supposed to be "free"? Just every "fifth" one, or all of the cheapest with the given type?

        $limit = self::PRODUCTS_LIMIT;
        $types = [];
        $sumPrice = 0.0;

        foreach ($products as $product) {
            //TODO !!!!!!!!!
            ++$type[$product->getType()];
        }

        return $sumPrice;
    }
}
