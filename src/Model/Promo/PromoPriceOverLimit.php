<?php

namespace App\Model\Promo;

use App\Helper\PriceHelper;
use App\Model\Promo;
use App\Model\Product;

class PromoPriceOverLimit extends Promo
{
    const PRICE_LIMIT = 100.0;
    const PRICE_REDUCTION_PERCENT = 10;

    public function __construct(
        private float $maxPrice = self::PRICE_LIMIT,
        private int $priceReductionPercent = self::PRICE_REDUCTION_PERCENT,
    ) {
    }

    /**
     * @param Product[] $products
     */
    public function isAvailable(array $products): bool
    {
        return PriceHelper::getSum($products) > $this->maxPrice;
    }

    /**
     * @param Product[] $products
     */
    public function getPrice(array $products): float
    {
        $sum = PriceHelper::getSum($products);

        return $sum - ($sum * ($this->priceReductionPercent / 100));
    }
}
