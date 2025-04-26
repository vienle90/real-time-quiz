<?php

namespace App\Providers;

use App\Repositories\CategoryRepository;
use App\Repositories\Contracts\CategoryRepositoryInterface;
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
use App\Repositories\UserQuestionAnswerRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register repository bindings
        $this->app->bind(QuizRepositoryInterface::class, QuizRepository::class);
        $this->app->bind(QuizUserRepositoryInterface::class, QuizUserRepository::class);
        $this->app->bind(QuestionChoiceRepositoryInterface::class, QuestionChoiceRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(LeaderboardRepositoryInterface::class, RedisLeaderBoardRepository::class);
        $this->app->bind(QuestionRepositoryInterface::class, QuestionRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(UserQuestionAnswerRepositoryInterface::class, UserQuestionAnswerRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
    }
}
