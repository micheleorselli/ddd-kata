<?php 

namespace Cart;

class Cart 
{
    private $subtotal = 0;

    public static function createEmpty(){ 
        return new Cart();
    }

    public function isEmpty() {
        return true;
    }

    public function getSubtotal() {
        return $this->subtotal;
    }

    public function addItem(LineItem $item) {
        $this->subtotal += $item->getPrice();
    }
}