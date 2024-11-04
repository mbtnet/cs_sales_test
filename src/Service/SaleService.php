<?php

namespace App\Service;

use App\Model\Offer;

class SaleService
{
    public function __construct(
        private PromoResolverInterface $promoResolver,
    )
    {
    }

    public function getProductsPrice(Offer $offer): float
    {
        return $offer->getPrice();
    }

    public function getCheckoutPrice(Offer $offer): float
    {
        $promo = $this->promoResolver->pickPromo($offer);

        if (null === $promo) {
            return $offer->getPrice();
        }

        return $promo->getPrice($offer->getProducts());
    }
}
