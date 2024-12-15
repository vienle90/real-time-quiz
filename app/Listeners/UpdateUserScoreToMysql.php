<?php

namespace App\Listeners;

use App\Events\UserScoreUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateUserScoreToMysql
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserScoreUpdated $event): void
    {
        //
    }
}
