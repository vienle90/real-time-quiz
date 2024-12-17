<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    )
    {
    }

    public function create(Request $request): JsonResponse
    {
        $user = $this->userService->createUser($request->get('username'));

        return response()->json($user, 201);
    }

}
