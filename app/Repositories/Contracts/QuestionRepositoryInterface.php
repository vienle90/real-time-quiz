<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Question;
use Illuminate\Database\Eloquent\Collection;

interface QuestionRepositoryInterface
{
    public function getQuestions(int $quizId): Collection;

    public function findOrFail(int $id): Question;
}
