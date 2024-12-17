<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\QuestionChoice;
use App\Repositories\Contracts\QuestionChoiceRepositoryInterface;

class QuestionChoiceRepository implements QuestionChoiceRepositoryInterface
{

    public function findOrFail(int $id, int $questionId): QuestionChoice
    {
        return QuestionChoice::where('id', $id)
            ->where('question_id', $questionId)
            ->firstOrFail();
    }
}
