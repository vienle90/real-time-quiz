<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Quiz;
use App\Repositories\Contracts\QuizRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class QuizRepository implements QuizRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getQuizzes(): Collection
    {
        return Quiz::all();
    }

    /**
     * @inheritDoc
     */
    public function getQuizzesByDifficulty(string $difficulty): Collection
    {
        return Quiz::where('difficulty', $difficulty)->get();
    }

    /**
     * @inheritDoc
     */
    public function findById(int $id, array $relations = []): ?Quiz
    {
        return Quiz::with($relations)->find($id);
    }
    
    /**
     * @inheritDoc
     */
    public function findBySlug(string $slug, array $relations = []): ?Quiz
    {
        return Quiz::with($relations)->where('slug', $slug)->first();
    }
    
    /**
     * @inheritDoc
     */
    public function findBySlug(string $slug, array $relations = []): ?Quiz
    {
        return Quiz::with($relations)->where('slug', $slug)->first();
    }
    
    /**
     * @inheritDoc
     */
    public function findByIdOrSlug(string|int $idOrSlug, array $relations = []): ?Quiz
    {
        // Check if $idOrSlug is numeric, treat it as ID
        if (is_numeric($idOrSlug)) {
            $quiz = $this->findById((int) $idOrSlug, $relations);
            if ($quiz) {
                return $quiz;
            }
        }
        
        // If not found by ID or not numeric, try as slug
        return $this->findBySlug((string) $idOrSlug, $relations);
    }

    /**
     * @inheritDoc
     */
    public function getFeaturedQuizzes(): Collection
    {
        return Quiz::where('is_featured', true)->get();
    }
}
