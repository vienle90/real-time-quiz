<?php

namespace App\Console\Commands;

use App\Models\Question;
use App\Models\User;
use App\Services\QuizService;
use App\Services\UserService;
use Illuminate\Console\Command;

class PopulateLeaderboard extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:populate-leaderboard {quizId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate the leaderboard for a quiz';

    public function __construct(
        private readonly QuizService $quizService,
        private readonly UserService $userService,
    )
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $quizId = $this->argument('quizId');
        $this->info("Populating leaderboard for quiz {$quizId}");

        User::where('username', 'like', 'Quiz' . $quizId . '%')->delete();
        for ($i = 0; $i < 20; $i++) {
            $this->userService->createUser(
                username: sprintf('%s%s %s', 'Quiz', $quizId, fake()->name()),
            );
        }

        $question = Question::where('quiz_id', $quizId)->get();

        $users = User::where('username', 'like', 'Quiz' . $quizId . '%')->get();
        foreach ($question as $q) {
            foreach ($users as $user) {
                $this->quizService->joinQuiz($quizId, $user->id);
                $this->quizService->answerQuestion(
                    quizId: $quizId,
                    userId: $user->id,
                    questionId: $q->id,
                    choiceId: $q->choices->random()->id
                );
                sleep(rand(0, 2));
            }
            sleep(rand(0, 2));
        }

        $this->info("Leaderboard for quiz {$quizId} has been populated");
    }
}
