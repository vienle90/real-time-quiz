<?php

namespace Tests\Unit\Services;


use App\Events\UserCreated;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\UserService;
use Illuminate\Support\Facades\Event;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    private UserRepositoryInterface|MockObject $userRepository;
    private readonly UserService $userService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepository = $this->createMock(UserRepositoryInterface::class);
        $this->userService = new UserService($this->userRepository);
    }

    public function test_can_create_user()
    {
        Event::fake();
        $user = new User(['name' => 'John Doe']);
        $this->userRepository->expects($this->once())
            ->method('createUser')
            ->with('John Doe')
            ->willReturn($user);
        $result = $this->userService->createUser('John Doe');

        Event::assertDispatched(UserCreated::class, function (UserCreated $e) use ($user) {
            return $e->user === $user;
        });

        $this->assertEquals($user->toArray(), $result->toArray());
    }
}
