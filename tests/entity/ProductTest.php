<?php

namespace App\Tests\Entity;

use App\Entity\Category;
use App\Entity\Flavor;
use App\Entity\Product;
use Doctrine\Common\Collections\Collection;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    private $product;

    protected function setUp(): void
    {
        $this->product = new Product();
    }

    public function testSetName(): void
    {
        $name = 'Test Product';
        $this->product->setName($name);

        $this->assertEquals(
            $name,
            $this->product->getName(),
            "Failed asserting that the name is '{$name}' after setting."
        );
    }

    public function testSetDescription(): void
    {
        $description = 'Test Description';
        $this->product->setDescription($description);

        $this->assertEquals(
            $description,
            $this->product->getDescription(),
            "Failed asserting that the description is '{$description}' after setting."
        );
    }

    public function testSetImage(): void
    {
        $image = 'test-image.jpg';
        $this->product->setImage($image);

        $this->assertEquals(
            $image,
            $this->product->getImage(),
            "Failed asserting that the image is '{$image}' after setting."
        );
    }

    public function testSetPrice(): void
    {
        $price = 100;
        $this->product->setPrice($price);

        $this->assertEquals(
            $price,
            $this->product->getPrice(),
            "Failed asserting that the price is '{$price}' after setting."
        );
    }

    public function testSetQuantity(): void
    {
        $quantity = 10;
        $this->product->setQuantity($quantity);

        $this->assertEquals(
            $quantity,
            $this->product->getQuantity(),
            "Failed asserting that the quantity is '{$quantity}' after setting."
        );
    }

    public function testAddAndRemoveCategory(): void
    {
        $category = new Category();
        $this->product->addCategory($category);

        $this->assertContains(
            $category,
            $this->product->getCategories(),
            'Failed asserting that the category collection contains the added category.'
        );

        $this->product->removeCategory($category);

        $this->assertNotContains(
            $category,
            $this->product->getCategories(),
            'Failed asserting that the category collection no longer contains the removed category.'
        );
    }

    
    protected function tearDown(): void
    {
        unset($this->product);
    }
}