<?php

namespace App\Listeners;

use App\Events\UserScoreUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Redis;

class UpdateUserScoreToRedis implements ShouldQueue
{
    /**
     * The name of the connection the job should be sent to.
     *
     * @var string|null
     */
    public ?string $connection = 'rabbitmq';

    /**
     * The name of the queue the job should be sent to.
     *
     * @var string|null
     */
    public ?string $queue = 'redis_user_score_update';
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserScoreUpdated $event): void
    {
        $userDetails = Redis::command('hgetall', ['user:' . $event->getUserId()]);
        if (empty($userDetails)) {
            Redis::command('hmset', ['user:' . $event->getUserId(), 'name', fake()->name()]);
        }
        $userScoreSortedSet = sprintf('quiz:%d:user_scores', $event->getQuizId());
        Redis::command('ZINCRBY', [$userScoreSortedSet, $event->getScore(), $event->getUserId()]);
        dump('Redis: User score updated for user id: ' . $event->getUserId() . ' with score: ' . $event->getScore());
    }
}
