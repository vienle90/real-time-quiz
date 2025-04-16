<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Quiz;
use Illuminate\Database\Eloquent\Collection;

interface QuizRepositoryInterface
{
    public function getQuizzes(): Collection;
    
    public function findById(int $id): ?Quiz;
}
