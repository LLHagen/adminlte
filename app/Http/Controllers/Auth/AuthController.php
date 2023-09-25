<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseApiController;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseApiController
{
    public function register (RegisterRequest $request): JsonResponse
    {
        if (!empty($request->birthday_at)) {
            try {
                $birthday = new Carbon($request->birthday_at);
            } catch (InvalidFormatException) {
                return $this->sendError("Недопустимый формат для поля День Рождения");
            }
        }

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'register_at' => Date::now(),
            'birthday_at' => $birthday ?? null,
        ]);

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
