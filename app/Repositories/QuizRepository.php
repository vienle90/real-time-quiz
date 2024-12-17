<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Quiz;
use App\Repositories\Contracts\QuizRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class QuizRepository implements QuizRepositoryInterface
{
    public function getQuizzes(): Collection
    {
        return Quiz::all();
    }
}
