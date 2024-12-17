<?php

namespace App\Listeners;

use App\Events\QuestionAnswerSubmitted;
use App\Repositories\Contracts\QuizUserRepositoryInterface;
use App\Repositories\Contracts\UserQuestionAnswerRepositoryInterface;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateUserAnswerToMysql implements ShouldQueue
{
    public string $connection = 'rabbitmq';

    public string $queue = 'mysql_user_answer_update';

    /**
     * Create the event listener.
     */
    public function __construct(
        private readonly QuizUserRepositoryInterface           $quizUserRepository,
        private readonly UserQuestionAnswerRepositoryInterface $userQuestionAnswerRepository,

    )
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(QuestionAnswerSubmitted $event): void
    {
        $this->quizUserRepository->increaseScore(
            quizId: $event->quizId,
            userId: $event->userId,
            score: $event->score,
        );

        $this->userQuestionAnswerRepository->answerQuestion(
            userId: $event->userId,
            questionId: $event->questionId,
            choiceId: $event->choiceId,
            isCorrect: $event->isCorrect,
        );
    }
}
