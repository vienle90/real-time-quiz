<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\QuizUser;
use App\Repositories\Contracts\QuizUserRepositoryInterface;

class QuizUserRepository implements QuizUserRepositoryInterface
{
    public function joinQuiz(int $userId, int $quizId): QuizUser
    {
        $quizUser = QuizUser::where('user_id', $userId)
            ->where('quiz_id', $quizId)
            ->first();

        if ($quizUser) {
            return $quizUser;
        }

        return QuizUser::create([
            'user_id' => $userId,
            'quiz_id' => $quizId,
            'score' => 0,
            'status' => QuizUser::STATUS_JOINED,
        ]);
    }

    public function getUser(int $quizId, int $userId): ?QuizUser
    {
        return QuizUser::where('user_id', $userId)
            ->where('quiz_id', $quizId)
            ->firstOrFail();
    }

    public function increaseScore(int $quizId, int $userId, $score): void
    {
        QuizUser::where('user_id', $userId)
            ->where('quiz_id', $quizId)
            ->increment('score', $score);
    }
}
