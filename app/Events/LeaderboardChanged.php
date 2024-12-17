<?php

namespace App\Events;

use App\Services\LeaderboardService;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class LeaderboardChanged implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $connection = 'rabbitmq';

    public string $queue = 'leaderboard_changed';

    /**
     * Create a new event instance.
     */
    public function __construct(
        public readonly string $quizId,
        public readonly array $topUsers,
    )
    {
        //
    }

    public function broadcastOn(): Channel|array
    {
        return new Channel('quiz.' . $this->quizId);
    }

    public function broadcastAs(): string
    {
        return 'leaderboard.changed';
    }
}
