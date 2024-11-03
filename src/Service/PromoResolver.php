<?php

namespace App\Service;

use App\Model\Offer;
use App\Model\Promo;

class PromoResolver implements PromoResolverInterface
{
    public function pickPromo(Offer $offer): ?Promo
    {
        if (empty($offer->getPromos())) {
            return null;
        }

        $products = $offer->getProducts();
        $maxPrice = $offer->getPrice();
        $bestPromo = null;

        foreach ($offer->getPromos() as $promo) {
            if ($promo->isAvalable($products) && $maxPrice > $promo->getPrice($products)) {
                $bestPromo = $promo;
            }
        }

        return $bestPromo;
    }
}
