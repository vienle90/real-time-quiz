<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function createUser(string $username): User
    {
        return User::create(['username' => $username]);
    }

    public function save(User $user): void
    {
        $user->save();
    }
    
    public function findById(int $userId): ?User
    {
        return User::find($userId);
    }
}
