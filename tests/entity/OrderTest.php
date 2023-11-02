<?php

namespace App\Tests\Entity;

use App\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class OrderTest extends KernelTestCase
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->validator = self::getContainer()->get(ValidatorInterface::class);
    }

    public function testValidOrderEntity()
    {
        $order = new Order();
        $order->setDatetime(new \DateTime());
        $order->setTotal(100.0);
        $order->setStatus('PAYMENT_WAITING');

        $violations = $this->validator->validate($order);

        $this->assertCount(0, $violations);
    }

    public function testInvalidOrderEntity()
    {
        $order = new Order();
        // Missing required fields

        $violations = $this->validator->validate($order);

        $this->assertCount(3, $violations); // Adjust the count based on your entity's validation constraints
    }
}
