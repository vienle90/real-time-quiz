<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\Contracts\QuestionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class QuestionService
{

    public function __construct(
        private readonly QuestionRepositoryInterface $questionRepository,
    )
    {
    }

    public function getQuestions(int $quizId): Collection
    {
        return $this->questionRepository->getQuestions($quizId);
    }
}
