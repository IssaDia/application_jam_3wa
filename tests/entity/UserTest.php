<?php

namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\User\UserInterface;

class UserTest extends TestCase
{
    private $user;

    protected function setUp(): void
    {
        $this->user = new User();
    }

    public function testSetEmail(): void
    {
        $email = 'test@example.com';
        $this->user->setEmail($email);

        $this->assertSame(
            $email,
            $this->user->getEmail(),
            "Failed asserting that the email is the expected value."
        );
    }

    public function testGetUserIdentifier(): void
    {
        $email = 'test@example.com';
        $this->user->setEmail($email);

        $userIdentifier = $this->user->getUserIdentifier();

        $this->assertEquals(
            $email,
            $userIdentifier,
            "Failed asserting that the user identifier is the email."
        );
    }

    public function testGetRoles(): void
    {
        $roles = ['ROLE_ADMIN', 'ROLE_USER'];
        $this->user->setRoles($roles);

        
        $userRoles = $this->user->getRoles();

        $this->assertEquals(
           $roles,
            $userRoles,
            "Failed asserting that the user roles are the expected values."
        );
    }

    public function testSetPassword(): void
    {
        $password = 'TestPassword1@';
        $this->user->setPassword($password);

        $this->assertSame(
            $password,
            $this->user->getPassword(),
            "Failed asserting that the password is the expected value."
        );
    }

    public function testEraseCredentials(): void
    {
        // Erase credentials is an empty method
        $this->user->eraseCredentials();

        $this->expectNotToPerformAssertions();
    }

    protected function tearDown(): void
    {
        unset($this->user);
    }
}
