<?php

namespace App\Tests\Entity;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductTest extends KernelTestCase
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

    public function testValidProductEntity()
    {
        $product = new Product();
        $product->setName('Test Product');
        $product->setPrice(100);
        $product->setDescription('Description');
        $product->setImage('Image');
        $product->setQuantity(1);

        $violations = $this->validator->validate($product);

        $this->assertCount(0, $violations);
    }

    public function testInvalidProductEntity()
    {
        $product = new Product();
        // Missing required fields

        $violations = $this->validator->validate($product);

        $this->assertCount(2, $violations); // Adjust the count based on your entity's validation constraints
    }
}
