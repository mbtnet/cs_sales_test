<?php

namespace App\Model;

use App\Model\Product;
use App\Model\Promo;
use App\Helper\PriceHelper;

class Offer
{
    public function __construct(
        /**
         * @param Product[] $products
         */
        private array $products = [],

        /**
         * @param Promo[] $promos
         */
        private array $promos = [],
    ) {
    }

    /**
     * @return Product[]
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * @return Promo[]
     */
    public function getPromos(): array
    {
        return $this->promos;
    }

    public function getPrice(): float
    {
        return PriceHelper::getSum($this->getProducts());
    }

    public function addProduct(Product $product): self
    {
        $this->products[] = $product;

        return $this;
    }

    public function addPromo(Promo $promo): self
    {
        $this->promos[] = $promo;

        return $this;
    }
}
