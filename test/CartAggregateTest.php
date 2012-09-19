<?php 

class CartAggregateTest extends PHPUnit_Framework_Testcase
{
    public function setUp()
    {
        $this->cart = Cart\Cart::createEmpty();
    }

    public function testANewEmptyCartHasNoItems()
    {
        $this->assertTrue($this->cart->isEmpty());
    }

    public function testANewCartHasZeroSubtotal()
    {
        $this->assertEquals(0, $this->cart->getSubtotal());
    }

    public function testAddFirstItemUpdatesSubtotal()
    {
        $item =  new Cart\LineItem('dildo', 100);
        $this->cart->addItem($item);
        $this->assertEquals(100, $this->cart->getSubtotal());
    }

    public function testAddManyItemsUpdatesSubtotal()
    {
        for($i = 0; $i<4; $i++){
            $item =  new Cart\LineItem('prodotto'.$i, $i);
            $this->cart->addItem($item);
        }
        $this->assertEquals(6, $this->cart->getSubtotal());
    }

    public function testRemoveItemUpdatesSubtotal()
    {
        for($i = 0; $i<4; $i++){
            $item =  new Cart\LineItem('prodotto'.$i, $i);
            $this->cart->addItem($item);
        }

        $item_to_remove = new Cart\LineItem('prodotto2',2);

        $this->cart->removeItem($item_to_remove);
        $this->assertEquals(4, $this->cart->getSubtotal());
    }


}