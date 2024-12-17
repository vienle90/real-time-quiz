<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\QuestionChoice;

interface QuestionChoiceRepositoryInterface
{
    public function findOrFail(int $id, int $questionId): QuestionChoice;
}
