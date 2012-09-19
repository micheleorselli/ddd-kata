<?php

namespace Cart;

class CartStateActive implements CartStateInterface
{
    public function checkout(Cart $cart)
    {
        $cart->status = CartStateCheckedOut::getInstance();

        return CartFinalizedEvent::createFromCart($cart);
    }

    public static function getInstance()
    {
        return new self;
    }

    public function addItem(Cart $cart, LineItem $item)
    {    
        $cart->subtotal += $item->getPrice();
        $cart->items[] = $item;
    }
}