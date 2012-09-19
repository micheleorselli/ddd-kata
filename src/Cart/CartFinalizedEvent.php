<?php

namespace Cart;

class CartFinalizedEvent
{
   
    private $time_stamp = 0;
    private $cart;  

    private function __construct(Cart $cart)
    {   
        $this->time_stamp = new \DateTime('now');
        $this->cart = $cart;
    }

    public static function createFromCart(Cart $cart)
    {
        return new CartFinalizedEvent($cart);
    }

    public function getSubTotal()
    {
        return $this->cart->getSubTotal();
    }
}