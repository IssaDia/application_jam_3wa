<?php

namespace App\Tests\Entity;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserTest extends KernelTestCase
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

    public function testValidUserEntity()
    {
        $user = new User();
        $user->setEmail('test@example.com');
        $user->setPassword('Secure@Password123');
        $user->setRoles(['ROLE_USER']);

        $violations = $this->validator->validate($user);

        $this->assertCount(0, $violations);
    }

    public function testInvalidUserEntity()
    {
        $user = new User();
        $user->setEmail('invalid-email'); // Invalid email format
        $user->setPassword('password'); // Password does not meet the requirements

        $violations = $this->validator->validate($user);

        $this->assertCount(2, $violations);
        $this->assertStringContainsString('email', (string)$violations);
        $this->assertStringContainsString('password', (string)$violations);
    }
}
