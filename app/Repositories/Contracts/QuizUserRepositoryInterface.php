<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\QuizUser;

interface QuizUserRepositoryInterface
{
    public function joinQuiz(int $userId, int $quizId): QuizUser;

    public function getUser(int $quizId, int $userId): ?QuizUser;

    public function increaseScore(int $quizId, int $userId, $score): void;
}
