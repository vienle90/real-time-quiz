<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Question;
use App\Repositories\Contracts\QuestionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class QuestionRepository implements QuestionRepositoryInterface
{
    public function getQuestions(int $quizId): Collection
    {
        return Question::with('choices')
            ->where('quiz_id', $quizId)
            ->get();
    }

    public function findOrFail(int $id): Question
    {
        return Question::findOrFail($id);
    }
}
