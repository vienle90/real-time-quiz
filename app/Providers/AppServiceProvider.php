<?php

namespace App\Providers;

use App\Listeners\CreateRedisUser;
use App\Repositories\Contracts\LeaderboardRepositoryInterface;
use App\Repositories\Contracts\QuestionChoiceRepositoryInterface;
use App\Repositories\Contracts\QuestionRepositoryInterface;
use App\Repositories\Contracts\QuizRepositoryInterface;
use App\Repositories\Contracts\QuizUserRepositoryInterface;
use App\Repositories\Contracts\UserQuestionAnswerRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\QuestionChoiceRepository;
use App\Repositories\QuestionRepository;
use App\Repositories\QuizRepository;
use App\Repositories\QuizUserRepository;
use App\Repositories\RedisRepositorires\RedisLeaderBoardRepository;
use App\Repositories\RedisRepositorires\RedisUserRepository;
use App\Repositories\UserQuestionAnswerRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        LeaderboardRepositoryInterface::class => RedisLeaderBoardRepository::class,
        QuizRepositoryInterface::class => QuizRepository::class,
        UserRepositoryInterface::class => UserRepository::class,
        QuizUserRepositoryInterface::class => QuizUserRepository::class,
        QuestionRepositoryInterface::class => QuestionRepository::class,
        QuestionChoiceRepositoryInterface::class => QuestionChoiceRepository::class,
        UserQuestionAnswerRepositoryInterface::class => UserQuestionAnswerRepository::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->when(CreateRedisUser::class)
            ->needs(UserRepositoryInterface::class)
            ->give(RedisUserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
