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

    public function findById(int $userId): ?User
    {
        $userData = Redis::command('hgetall', ['user:' . $userId]);
        
        // If no data found in Redis, return null
        if (empty($userData)) {
            return null;
        }
        
        // Convert Redis response to associative array
        $userDataArray = [];
        for ($i = 0; $i < count($userData); $i += 2) {
            $userDataArray[$userData[$i]] = $userData[$i + 1];
        }
        
        // If no username found, return null
        if (!isset($userDataArray['username'])) {
            return null;
        }
        
        // Create a new User instance and fill attributes
        $user = new User();
        $user->id = $userId;
        $user->username = $userDataArray['username'];
        
        return $user;
    }
}
