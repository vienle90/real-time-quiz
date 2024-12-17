<?php

namespace Tests\Feature\Repositories;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;
    private readonly UserRepository $userRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepository = new UserRepository();
    }

    public function test_can_create_user()
    {
        $this->userRepository->createUser('John Doe');
        $this->assertDatabaseHas('users', ['username' => 'John Doe']);
    }

    public function test_can_save_user()
    {
        $user = User::factory()->create(['username' => 'John Doe']);
        $user->username = 'Jane Doe';

        $this->userRepository->save($user);

        $this->assertDatabaseHas('users', ['username' => 'Jane Doe']);
    }
}
