<?php

namespace App\Http\Controllers;

use App\Services\GetTopUsersService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Redis;

class QuizController extends Controller
{
    public function __construct(private readonly GetTopUsersService $getTopUsersService)
    {
    }

    public function leaderboard(string $quizId): JsonResponse
    {
       $topUsers = $this->getTopUsersService->__invoke($quizId, 10);
        return response()->json($topUsers);
    }
}
