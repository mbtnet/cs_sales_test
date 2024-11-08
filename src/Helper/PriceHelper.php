<?php

namespace App\Helper;

use App\Model\Product;

class PriceHelper
{
    /**
     * @param Product[] $products
     */
    public static function getSum(array $products): float
    {
        $sum = 0.0;
        foreach ($products as $product) {
            $sum += $product->getPrice();
        }

        return $sum;
    }
}
