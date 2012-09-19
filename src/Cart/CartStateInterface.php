<?php 

namespace Cart;

interface CartStateInterface 
{   
    public function checkout(Cart $cart);

    public function addItem(Cart $cart, LineItem $item);
}
