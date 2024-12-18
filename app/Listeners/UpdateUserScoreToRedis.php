<?php

namespace App\Listeners;

use App\Events\LeaderboardChanged;
use App\Events\QuestionAnswerSubmitted;
use App\Services\LeaderboardService;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Redis;

class UpdateUserScoreToRedis implements ShouldQueue
{

    const LEADERBOARD_UPDATED_TIMESTAMP_KEY = 'quiz:%s:leaderboard_updated_timestamp';

    const LEADERBOARD_UPDATE_INTERVAL = 2; //3 seconds
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
    public function __construct(
        private readonly LeaderboardService $getTopUsersService
    )
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(QuestionAnswerSubmitted $event): void
    {
        $userScoreSortedSet = sprintf('quiz:%d:user_scores', $event->quizId);
        Redis::command('ZINCRBY', [$userScoreSortedSet, $event->score, $event->userId]);

        info('Redis: User score updated for user id: ' . $event->userId . ' with score: ' . $event->score);
        $newScore = Redis::command('zscore', [$userScoreSortedSet, $event->userId]);

        $topUsers = $this->getTopUsersService->__invoke($event->quizId)->toArray();

        event(new LeaderboardChanged(
            quizId: $event->quizId,
            topUsers: $topUsers
        ));
    }

    private function shouldUpdateLeaderboard(int $quizId): bool
    {
        $now = Carbon::now();
        $lastUpdated = Redis::command('get', [sprintf(self::LEADERBOARD_UPDATED_TIMESTAMP_KEY, $quizId)]);
        if ($lastUpdated === null) {
            Redis::set(sprintf(self::LEADERBOARD_UPDATED_TIMESTAMP_KEY, $quizId), $now->timestamp);
            return true;
        }

        $lastUpdated = Carbon::createFromTimestamp($lastUpdated);
        if ($now->diffInSeconds($lastUpdated) > self::LEADERBOARD_UPDATE_INTERVAL) {
            Redis::command('set', [sprintf(self::LEADERBOARD_UPDATED_TIMESTAMP_KEY, $quizId), $now->timestamp]);
            return true;
        }

        return false;

    }
}
