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
    public function getFeaturedQuizzes(): Collection
    {
        return Quiz::where('is_featured', true)->get();
    }
}
