<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function userIsNotAdmin()
    {
        $user = factory(User::class)->create();
        $this->assertFalse($user->isAdmin());
    }
        
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function UserIsAdmin()
    {
        $admin = factory(User::class)
            ->states('is_admin', true)
            ->create();
        $this->assertTrue($admin->isAdmin());
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {

        $this->assertTrue(true);
    }
}
