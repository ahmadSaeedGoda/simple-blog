<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Category;
use App\Models\Article;
use App\Models\Comment;

class DatabaseTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testDatabase()
    {
        $users = factory(User::class, 3)
           ->create()
           ->each(function ($user) {
            });
        $this->assertTrue(true);
    }
}
