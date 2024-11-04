<?php

namespace App\Model\Promo;

use App\Model\Promo;

class PromoEveryOverLimitFree extends Promo implements PromoInterface
{
    const PRODUCTS_LIMIT = 5;

    public function __construct(
        private int $productsLimit = self::PRODUCTS_LIMIT,
    )
    {
    }

    /**
     * @param Products[] $products
     */
    public function isAvailable(array $products): bool
    {
        return $this->productsLimit <= count($products);
    }

    /**
     * @param Products[] $products
     */
    public function getPrice(array $products): float
    {
        //TODO The question is: which products supposed to be "free"? Just every "fifth" one, or all of the cheapest with the given type over limit?

        $limit = $this->productsLimit;
        $typesCounters = [];
        $sumPrice = 0.0;

        foreach ($products as $product) {
            $type = $product->getType()->value;
            $typesCounters[$type] =  
                isset($typesCounters[$type]) ? 
                ++$typesCounters[$type] : 
                1;

            if($limit === $typesCounters[$type]) {
                $typesCounters[$type] = 0;
            } else {
                $sumPrice += $product->getPrice();
            }
        }

        return $sumPrice;
    }
}
