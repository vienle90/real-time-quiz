<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Quiz;
use Illuminate\Database\Eloquent\Collection;

interface QuizRepositoryInterface
{
    /**
     * Get all quizzes.
     *
     * @return Collection<int, Quiz>
     */
    public function getQuizzes(): Collection;
    
    /**
     * Get quizzes by difficulty.
     *
     * @param string $difficulty
     * @return Collection<int, Quiz>
     */
    public function getQuizzesByDifficulty(string $difficulty): Collection;
    
    /**
     * Find quiz by ID.
     *
     * @param int $id
     * @return Quiz|null
     */
    public function findById(int $id): ?Quiz;
    
    /**
     * Get featured quizzes.
     *
     * @return Collection<int, Quiz>
     */
    public function getFeaturedQuizzes(): Collection;
}
