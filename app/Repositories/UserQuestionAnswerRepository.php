<?php

declare(strict_types=1);

namespace App\Repositories;
use App\Models\UserQuestionAnswer;
use App\Repositories\Contracts\UserQuestionAnswerRepositoryInterface;

class UserQuestionAnswerRepository implements UserQuestionAnswerRepositoryInterface
{
    public function answerQuestion(int $userId, int $questionId, int $choiceId, bool $isCorrect): UserQuestionAnswer
    {
        return UserQuestionAnswer::create([
            'user_id' => $userId,
            'question_id' => $questionId,
            'choice_id' => $choiceId,
            'is_correct' => $isCorrect
        ]);
    }

}
