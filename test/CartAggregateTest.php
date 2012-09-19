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
        $this->assertEquals(0, $this->cart->getSubTotal());
    }

    public function testAddFirstItemUpdatesSubtotal()
    {
        $item =  new Cart\LineItem('dildo', 100);
        $this->cart->addItem($item);
        $this->assertEquals(100, $this->cart->getSubTotal());
    }

    public function testAddManyItemsUpdatesSubtotal()
    {
        for($i = 0; $i<4; $i++){
            $item =  new Cart\LineItem('prodotto'.$i, $i);
            $this->cart->addItem($item);
        }
        $this->assertEquals(6, $this->cart->getSubTotal());
    }

    public function testRemoveItemUpdatesSubtotal()
    {
        for($i = 0; $i<4; $i++){
            $item =  new Cart\LineItem('prodotto'.$i, $i);
            $this->cart->addItem($item);
        }

        $item_to_remove = new Cart\LineItem('prodotto2',2);

        $this->cart->removeItem($item_to_remove);
        $this->assertEquals(4, $this->cart->getSubTotal());
    }

    public function testRemoveItemOnEmptyCartDoesNothing()
    {
        $item_to_remove = new Cart\LineItem('prodotto2',2);

        $this->cart->removeItem($item_to_remove);
        $this->assertEquals(0, $this->cart->getSubTotal());
    }

    public function testRemoveMissingItemFromCartDoesNothing()
    {
        $item =  new Cart\LineItem('prodotto', 10);
        $this->cart->addItem($item);
        $item_to_remove = new Cart\LineItem('prodotto2',2);

        $this->cart->removeItem($item_to_remove);
        $this->assertEquals(10, $this->cart->getSubTotal());
    }

    public function testAddTwiceTheSameItem()
    {
        $item =  new Cart\LineItem('prodotto', 10);
        $this->cart->addItem($item);
        $this->cart->addItem($item);

        $this->assertEquals(20, $this->cart->getSubTotal());
    }

    public function testRemoveItemFromCart()
    {
        $item =  new Cart\LineItem('prodotto', 10);
        $this->cart->addItem($item);
        $this->cart->addItem($item);

        $this->cart->removeItem($item);
        $this->assertEquals(10, $this->cart->getSubTotal());
        $this->cart->removeItem($item);
        $this->assertEquals(0, $this->cart->getSubTotal());
    }

    public function testCheckoutReturnsAnEvent()
    {
        $item =  new Cart\LineItem('prodotto', 10);
        $this->cart->addItem($item);
        $item2 =  new Cart\LineItem('prodotto2', 20);
        $this->cart->addItem($item2);

        $e = $this->cart->checkout();
        $this->assertTrue($e instanceof Cart\CartFinalizedEvent);

        $this->assertEquals($this->cart->getSubTotal(), $e->getSubTotal());
    }

    /**
     * @expectedException RuntimeException
     * @expectedExceptionMessage cart already checked out
     */
    public function testShouldNotBeAllowedToAddItemAfterCheckout()
    {
        $item =  new Cart\LineItem('prodotto', 10);
        $this->cart->addItem($item);
        $item2 =  new Cart\LineItem('prodotto2', 20);
        $this->cart->addItem($item2);     

        $e = $this->cart->checkout();

        $item =  new Cart\LineItem('prodotto30', 50);
        $this->cart->addItem($item);

    }

    /**
     * @expectedException RuntimeException
     * @expectedExceptionMessage empty cart cannot checked out
     */
    public function testShouldNotBeAllowedToCheckoutEmptyCart()
    {
        $e = $this->cart->checkout();
    }

    /**
     * @expectedException RuntimeException
     * @expectedExceptionMessage cart already checked out
     */
    public function testShouldNotBeAllowedToCheckoutCartMoreThanOnce()
    {
        $item =  new Cart\LineItem('prodotto', 10);
        $this->cart->addItem($item);
        $e = $this->cart->checkout();
        $e = $this->cart->checkout();
    }
}