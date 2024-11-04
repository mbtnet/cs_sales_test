<?php

namespace App\Model;

use App\Enum\ProductType;

class Product
{
    public function __construct(
        private string $name,
        private ProductType $type,
        private float $price,
    ) {
    }

    /**
     * Get the value of name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of type
     */
    public function getType(): ProductType
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     */
    public function setType(ProductType $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of price
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     */
    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }
}
