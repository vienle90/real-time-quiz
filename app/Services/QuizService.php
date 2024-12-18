<?php

declare(strict_types=1);

namespace App\Services;

use App\Events\QuestionAnswerSubmitted;
use App\Models\QuizUser;
use App\Models\UserQuestionAnswer;
use App\Repositories\Contracts\QuestionChoiceRepositoryInterface;
use App\Repositories\Contracts\QuestionRepositoryInterface;
use App\Repositories\Contracts\QuizRepositoryInterface;
use App\Repositories\Contracts\QuizUserRepositoryInterface;
use App\Repositories\Contracts\UserQuestionAnswerRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class QuizService
{
    const SCORE_INCREMENT = 5;
    const SCORE_DECREMENT = 1;

    public function __construct(
        private readonly QuizRepositoryInterface               $quizRepository,
        private readonly QuizUserRepositoryInterface           $quizUserRepository,
        private readonly QuestionChoiceRepositoryInterface     $questionChoiceRepository,
    )
    {
    }

    public function getAllQuizzes(): Collection
    {
        return $this->quizRepository->getQuizzes();
    }

    public function joinQuiz(int $quizId, int $userId): QuizUser
    {
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
            $questionId,
            $userId,
            $quizId,
            $choiceId,
            $choice->is_correct,
            $score
        ));

        return [
            'is_correct' => $choice->is_correct,
            'score' => $score,
            'choice_id' => $choiceId,
        ];
    }
}
