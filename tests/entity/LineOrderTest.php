<?php

namespace App\Tests\Entity;

use App\Entity\LineOrder;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class LineOrderTest extends KernelTestCase
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

    public function testValidLineOrderEntity()
    {
        $lineOrder = new LineOrder();
        $lineOrder->setQuantity(2);
        $lineOrder->setSubtotal(50.0);

        // You may need to set the associated Order and Product entities as well.

        $violations = $this->validator->validate($lineOrder);

        $this->assertCount(0, $violations);
    }

    public function testInvalidLineOrderEntity()
    {
        $lineOrder = new LineOrder();
        // Missing required fields

        $violations = $this->validator->validate($lineOrder);

        $this->assertCount(3, $violations); // Adjust the count based on your entity's validation constraints
    }
}
