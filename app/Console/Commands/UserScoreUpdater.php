<?php

namespace App\Console\Commands;

use App\Events\UserScoreUpdated;
use Illuminate\Console\Command;

class UserScoreUpdater extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:user-score-updater {quizId} {userId} {score}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update user scores';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $quizId = $this->argument('quizId');
        $userId = $this->argument('userId');
        $score = $this->argument('score');

        event(new UserScoreUpdated($quizId, $userId, $score));
        $this->info('Fired event to update user score. Quiz ID: ' . $quizId . ', User ID: ' . $userId . ', Score: ' . $score);
    }
}
