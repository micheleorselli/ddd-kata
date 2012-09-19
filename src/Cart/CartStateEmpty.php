<?php

namespace Cart;

class CartStateEmpty implements CartStateInterface
{
    public function checkout(Cart $cart)
    {
        throw new \RuntimeException('empty cart cannot checked out');
    }

    public static function getInstance()
    {
        return new self;
    }

    public function addItem(Cart $cart, LineItem $item)
    {
        $cart->subtotal += $item->getPrice();
        $cart->items[] = $item;
        $cart->status = CartStateActive::getInstance();
    }
}