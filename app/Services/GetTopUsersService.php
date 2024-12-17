<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\Contracts\LeaderboardRepositoryInterface;
use Illuminate\Support\Collection;

readonly class GetTopUsersService
{
    const DEFAULT_LIMIT = -1;

    public function __construct(
        private LeaderBoardRepositoryInterface $leaderBoardRepository,
    )
    {
    }

    public function __invoke(int $quizId): Collection
    {
        return $this->leaderBoardRepository->getUsers(
            quizId: $quizId,
        );
    }
}
