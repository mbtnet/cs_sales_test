<?php

namespace App\Model\Promo;

use App\Helper\PriceHelper;

class PromoPriceOverLimit implements PromoInterface
{
    const PRICE_LIMIT = 100.0;
    const PRICE_REDUCTION_PERCENT = 10;

    public function __construct(
        private float $maxPrice = self::PRICE_LIMIT,
        private int $priceReductionPercent = self::PRICE_REDUCTION_PERCENT,
    )
    {
    }

    /**
     * @param Products[] $products
     */
    public function isAvailable(array $products): bool
    {
        return PriceHelper::getPrice($products) > $this->maxPrice;
    }

    /**
     * @param Products[] $products
     */
    public function getPrice(array $products): float
    {
        $sum = PriceHelper::getPrice($products);
        
        return $sum - ($sum * ($this->priceReductionPercent / 100));
    }
}
