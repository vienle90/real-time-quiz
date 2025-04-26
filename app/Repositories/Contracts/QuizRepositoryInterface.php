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
     * @param array $relations Relationships to eager load
     * @return Quiz|null
     */
    public function findById(int $id, array $relations = []): ?Quiz;
    
    /**
     * Find quiz by slug.
     *
     * @param string $slug
     * @param array $relations Relationships to eager load
     * @return Quiz|null
     */
    public function findBySlug(string $slug, array $relations = []): ?Quiz;
    
    /**
     * Find quiz by slug.
     *
     * @param string $slug
     * @param array $relations Relationships to eager load
     * @return Quiz|null
     */
    public function findBySlug(string $slug, array $relations = []): ?Quiz;
    
    /**
     * Find quiz by either ID or slug.
     *
     * @param string|int $idOrSlug
     * @param array $relations Relationships to eager load
     * @return Quiz|null
     */
    public function findByIdOrSlug(string|int $idOrSlug, array $relations = []): ?Quiz;

    /**
     * Get featured quizzes.
     *
     * @return Collection<int, Quiz>
     */
    public function getFeaturedQuizzes(): Collection;
}
