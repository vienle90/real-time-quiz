<?php

declare(strict_types=1);

namespace App\Repositories\RedisRepositorires;

use App\Repositories\Contracts\LeaderboardRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redis;

class RedisLeaderBoardRepository implements LeaderboardRepositoryInterface
{
    public function getUsers(int $quizId): Collection
    {
        $userScoreSortedSet = sprintf('quiz:%d:user_scores', $quizId);

        $topScores = Redis::command('zrevrange', [$userScoreSortedSet, 0, -1, 'withscores']);

        return collect($topScores)->map(function ($score, $useId) {
            $userDetails = Redis::command('hgetall', ['user:' . $useId]);
            return array_merge($userDetails, ['score' => $score, 'user_id' => $useId]);
        })->values();
    }
}
