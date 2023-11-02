<?php 

namespace App\Tests\Entity;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CategoryTest extends KernelTestCase
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

    public function testValidCategoryEntity()
    {
        $category = new Category();
        $category->setName('Category Name');
        $category->setDescription('Category Description');

        // You can set other fields as well, depending on your constraints.

        $violations = $this->validator->validate($category);

        $this->assertCount(0, $violations);
    }

    public function testInvalidCategoryEntity()
    {
        $category = new Category();
        // Missing required fields

        $violations = $this->validator->validate($category);

        $this->assertCount(2, $violations); // Adjust the count based on your entity's validation constraints
    }
}
