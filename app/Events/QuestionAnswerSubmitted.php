<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QuestionAnswerSubmitted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public int $questionId,
        public int $userId,
        public int $quizId,
        public int $choiceId,
        public bool $isCorrect,
        public int $score,
    )
    {
        //
    }

}
