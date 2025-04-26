<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateRedisUser implements shouldQueue
{
    public string $connection = 'rabbitmq';

    public string $queue = 'create_redis_user';

    /**
     * Create the event listener.
     */
    public function __construct(private readonly UserRepositoryInterface $userRepository)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserCreated $event): void
    {
        $this->userRepository->save($event->user);
        dump('Redis: User created with id: ' . $event->user->id);
    }
}
