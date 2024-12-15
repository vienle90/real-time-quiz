<?php

namespace App\Providers;

use App\Events\LeaderboardChanged;
use App\Repositories\Contracts\LeaderboardRepositoryInterface;
use App\Repositories\LeaderBoardRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        LeaderboardRepositoryInterface::class => LeaderboardRepository::class,
    ];
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
