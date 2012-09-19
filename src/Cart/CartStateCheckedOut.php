<?php

namespace Cart;

class CartStateCheckedOut implements CartStateInterface
{
    public function checkout(Cart $cart)
    {
        throw new \RuntimeException('cart already checked out');
    }

    public static function getInstance()
    {
        return new self;
    }

    public function addItem(Cart $cart, LineItem $item)
    {    
        throw new \RuntimeException('cart already checked out');
    }
}