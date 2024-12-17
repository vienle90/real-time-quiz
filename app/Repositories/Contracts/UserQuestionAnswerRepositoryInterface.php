<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\UserQuestionAnswer;

interface UserQuestionAnswerRepositoryInterface
{
    public function answerQuestion(int $userId, int $questionId, int $choiceId, bool $isCorrect): UserQuestionAnswer;
}
