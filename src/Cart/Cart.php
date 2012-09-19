<?php 

namespace Cart;

class Cart 
{   
    public $subtotal = 0;
    
    public $status;

    public $items = array();

    private function __construct()
    {
        $this->status = CartStateEmpty::getInstance();
    }

    public static function createEmpty()
    { 
        return new Cart();
    }

    public function isEmpty()
    {
        return empty($this->items);
    }

    public function getSubTotal()
    {
        return $this->subtotal;
    }

    public function checkout()
    {
        return $this->status->checkout($this);
    }

    public function addItem(LineItem $item)
    {
        $this->status->addItem($this, $item);
    }

    public function removeItem(LineItem $item_to_remove)
    {
        foreach ($this->items as $key => $item)
        {
            if ($item->equals($item_to_remove))
            {
                $this->subtotal -= $item->getPrice();
                unset($this->items[$key]);

                break;
            }
        }
    }
}