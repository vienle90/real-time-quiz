<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface LeaderboardRepositoryInterface
{
    public function getTopUsers(int $quizId, int $limit): Collection;
}
