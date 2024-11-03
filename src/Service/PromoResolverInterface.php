<?php

namespace App\Service;

use App\Model\Offer;
use App\Model\Promo;

interface PromoResolverInterface
{
    public function pickPromo(Offer $offer): ?Promo;
}
