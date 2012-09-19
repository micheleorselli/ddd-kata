<?php

namespace Cart;

class LineItem
{
    private $price;
    private $description;

    public function __construct($description, $price) {
        $this->price = $price;
        $this->description = $description;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getDescription() {
        return $this->description;
    }

    public function equals(LineItem $item) {
        return $this->price == $item->getPrice() && $this->description == $item->getDescription();
    }
}