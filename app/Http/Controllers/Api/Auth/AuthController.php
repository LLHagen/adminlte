<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\BaseApiController;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseApiController
{
    public function __construct(
        readonly private UserRepository $userRepository,
    ) {
        //
    }

    public function register (RegisterRequest $request): JsonResponse
    {
        $user = $this->userRepository->create($request);

        $token = $user->createToken(config('app.name'));

        return $this->respondWithToken($token->plainTextToken);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (!Auth::attempt($credentials)) {
            return $this->unauthorized();
        }
        /* @var User $user */
        $user = Auth::user();

        $token = $user?->createToken(config('app.name'));

        if (empty($token)) {
            return $this->unauthorized();
        }

        return $this->respondWithToken($token->plainTextToken);
    }

    public function logout(): JsonResponse
    {
        /* @var User $user */
        Auth::user()->tokens()?->delete();

        return $this->sendResponse(true);
    }
}
