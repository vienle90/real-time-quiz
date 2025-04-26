<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\QuizDifficulty;
use App\Events\QuestionAnswerSubmitted;
use App\Models\Quiz;
use App\Models\QuizUser;
use App\Repositories\Contracts\QuestionChoiceRepositoryInterface;
use App\Repositories\Contracts\QuizRepositoryInterface;
use App\Repositories\Contracts\QuizUserRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class QuizService
{
    const SCORE_INCREMENT = 5;
    const SCORE_DECREMENT = 1;

    public function __construct(
        private readonly QuizRepositoryInterface               $quizRepository,
        private readonly QuizUserRepositoryInterface           $quizUserRepository,
        private readonly QuestionChoiceRepositoryInterface     $questionChoiceRepository,
        private readonly UserRepositoryInterface               $userRepository
    )
    {
    }

    public function getAllQuizzes(): Collection
    {
        return $this->quizRepository->getQuizzes();
    }

    /**
     * Get featured quizzes.
     *
     * @return Collection
     */
    public function getFeaturedQuizzes(): Collection
    {
        return $this->quizRepository->getFeaturedQuizzes();
    }

    /**
     * Get a base query builder for quizzes.
     *
     * @return Builder
     */
    public function getQuizQuery(): Builder
    {
        return Quiz::query();
    }

    public function getQuizzesByDifficulty(?string $difficulty = null, bool $featured = false): Collection
    {
        if ($featured) {
            return $this->getFeaturedQuizzes();
        }

        if ($difficulty && $difficulty !== 'all' && in_array($difficulty, QuizDifficulty::values())) {
            return $this->quizRepository->getQuizzesByDifficulty($difficulty);
        }

        return $this->getAllQuizzes();
    }

    public function getQuizById(int $quizId, array $relations = []): ?Quiz
    {
        return $this->quizRepository->findById($quizId, $relations);
    }

    public function joinQuiz(int $quizId, int $userId): QuizUser
    {
        $user = $this->userRepository->findById($userId);
        if (!$user) {
            throw new ModelNotFoundException("User with ID {$userId} not found");
        }

        return $this->quizUserRepository->joinQuiz($userId, $quizId);
    }

    public function getUser(int $quizId, int $userId): ?QuizUser
    {
        return $this->quizUserRepository->getUser($quizId, $userId);
    }

    public function answerQuestion(int $quizId, int $userId, int $questionId, int $choiceId): array
    {
        $choice = $this->questionChoiceRepository->findOrFail($choiceId, $questionId);
        $score = $choice->is_correct ? self::SCORE_INCREMENT : -self::SCORE_DECREMENT;
        event(new QuestionAnswerSubmitted(
            questionId: $questionId,
            userId: $userId,
            quizId: $quizId,
            choiceId: $choiceId,
            isCorrect: $choice->is_correct,
            score: $score
        ));

        return [
            'is_correct' => $choice->is_correct,
            'score' => $score,
            'choice_id' => $choiceId,
        ];
    }
}
