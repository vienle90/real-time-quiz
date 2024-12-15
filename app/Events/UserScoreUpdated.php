<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserScoreUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        private readonly int $quizId,
        private readonly int $userId,
        private readonly int $score
    )
    {

    }

    public function getQuizId(): int
    {
        return $this->quizId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getScore(): int
    {
        return $this->score;
    }
}
