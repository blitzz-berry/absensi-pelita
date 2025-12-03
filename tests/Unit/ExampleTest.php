<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\User;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_that_true_is_true(): void
    {
        $this->assertTrue(true);
    }

    /**
     * Test user model creation
     */
    public function test_user_model_can_be_created(): void
    {
        $user = new User();
        $user->nama = 'Test User';
        $user->email = 'test@example.com';
        $user->password = bcrypt('password');
        $user->role = 'guru';

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('Test User', $user->nama);
        $this->assertEquals('test@example.com', $user->email);
        $this->assertEquals('guru', $user->role);
    }

    /**
     * Test password hashing
     */
    public function test_password_is_hashed_correctly(): void
    {
        $password = 'password';
        $hashedPassword = bcrypt($password);

        $this->assertTrue(password_verify($password, $hashedPassword));
        $this->assertNotEquals($password, $hashedPassword);
    }

    /**
     * Test user role validation
     */
    public function test_user_roles_are_correct(): void
    {
        $adminUser = new User();
        $adminUser->role = 'admin';
        $this->assertEquals('admin', $adminUser->role);

        $guruUser = new User();
        $guruUser->role = 'guru';
        $this->assertEquals('guru', $guruUser->role);
    }
}
