<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class UserScoreController extends Controller
{
    public function index(): JsonResponse
    {
        // User scores is an array that includes user_id, username and score with 10 items
        // Scores are sorted in descending order
        $userScores = [
            ['user_id' => 1, 'username' => 'user1', 'score' => 100],
            ['user_id' => 2, 'username' => 'user2', 'score' => 99],
            ['user_id' => 3, 'username' => 'user3', 'score' => 98],
            ['user_id' => 4, 'username' => 'user4', 'score' => 97],
            ['user_id' => 5, 'username' => 'user5', 'score' => 96],
            ['user_id' => 6, 'username' => 'user6', 'score' => 95],
            ['user_id' => 7, 'username' => 'user7', 'score' => 94],
            ['user_id' => 8, 'username' => 'user8', 'score' => 93],
            ['user_id' => 9, 'username' => 'user9', 'score' => 92],
            ['user_id' => 10, 'username' => 'user10', 'score' => 91],
        ];

        // return Json response with user scores
        return response()->json($userScores);
    }

}
