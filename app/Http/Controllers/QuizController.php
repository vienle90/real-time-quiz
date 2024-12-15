<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Redis;

class QuizController extends Controller
{
    public function leaderboard(string $quizId): JsonResponse
    {
        $userScoreSortedSet = sprintf('quiz:%d:user_scores', $quizId);

        $topScores = Redis::command('zrevrange', [$userScoreSortedSet, 0, 9, 'withscores']);

        $topUserDetails = collect($topScores)->map(function ($score, $useId) {
            $userDetails = Redis::command('hgetall', ['user:' . $useId]);
            return array_merge($userDetails, ['score' => $score, 'user_id' => $useId]);
        })->values();

        // return Json response with user scores
        return response()->json($topUserDetails);

    }
}
