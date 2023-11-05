<?php

namespace App\Tests\Entity;

use App\Entity\LineOrder;
use App\Entity\Order;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    private $order;

    protected function setUp(): void
    {
        $this->order = new Order();
    }

    public function testSetDatetime(): void
    {
        $datetime = new \DateTime();
        $this->order->setDatetime($datetime);

        $this->assertSame(
            $datetime,
            $this->order->getDatetime(),
            "Failed asserting that the datetime is the expected instance."
        );
    }

    public function testSetTotal(): void
    {
        $total = 150.75;
        $this->order->setTotal($total);

        $this->assertEquals(
            $total,
            $this->order->getTotal(),
            "Failed asserting that the total is '{$total}' after setting."
        );
    }

    public function testAddAndRemoveLineOrder(): void
    {
        $lineOrder = new LineOrder();
        $this->order->addLineOrder($lineOrder);

        $this->assertContains(
            $lineOrder,
            $this->order->getLineOrders(),
            'Failed asserting that the line order collection contains the added line order.'
        );

        $this->order->removeLineOrder($lineOrder);

        $this->assertNotContains(
            $lineOrder,
            $this->order->getLineOrders(),
            'Failed asserting that the line order collection no longer contains the removed line order.'
        );
    }

    public function testSetStatus(): void
    {
        $status = 'Shipped';
        $this->order->setStatus($status);

        $this->assertEquals(
            $status,
            $this->order->getStatus(),
            "Failed asserting that the status is '{$status}' after setting."
        );
    }

    protected function tearDown(): void
    {
        unset($this->order);
    }
}
