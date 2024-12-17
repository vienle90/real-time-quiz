<?php

declare(strict_types=1);

namespace App\Services;

use App\Events\UserCreated;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

readonly class UserService
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    )
    {
    }

    public function createUser(string $username): User
    {
        $user =  $this->userRepository->createUser($username);
        event(new UserCreated($user));

        return $user;
    }
}
