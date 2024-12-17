<?php

declare(strict_types=1);

namespace App\Repositories\RedisRepositorires;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Redis;

class RedisUserRepository implements UserRepositoryInterface
{

    public function createUser(string $username): User
    {
        throw new \Exception('Not implemented');
    }

    public function save(User $user): void
    {
        Redis::command('hmset', ['user:' . $user->id, 'username',  $user->username]);
    }
}
