<?php

namespace App\Tests\Entity;

use App\Entity\LineOrder;
use App\Entity\Order;
use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class LineOrderTest extends TestCase
{
    private $lineOrder;

    protected function setUp(): void
    {
        $this->lineOrder = new LineOrder();
    }

    public function testSetQuantity(): void
    {
        $quantity = 5;
        $this->lineOrder->setQuantity($quantity);

        $this->assertEquals(
            $quantity,
            $this->lineOrder->getQuantity(),
            "Failed asserting that the quantity is '{$quantity}' after setting."
        );
    }

    public function testSetSubtotal(): void
    {
        $subtotal = 100.5;
        $this->lineOrder->setSubtotal($subtotal);

        $this->assertEquals(
            $subtotal,
            $this->lineOrder->getSubtotal(),
            "Failed asserting that the subtotal is '{$subtotal}' after setting."
        );
    }

    public function testSetOrderAssociated(): void
    {
        $order = new Order();
        $this->lineOrder->setOrderAssociated($order);

        $this->assertSame(
            $order,
            $this->lineOrder->getOrderAssociated(),
            "Failed asserting that the associated order is the expected instance."
        );
    }

    public function testSetProduct(): void
    {
        $product = new Product();
        $this->lineOrder->setProduct($product);

        $this->assertSame(
            $product,
            $this->lineOrder->getProduct(),
            "Failed asserting that the associated product is the expected instance."
        );
    }

    protected function tearDown(): void
    {
        unset($this->lineOrder);
    }
}
