<?php

namespace App\Repository;

use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function create(RegisterRequest $request): User
    {
        if (!empty($request->birthday_at)) {
            try {
                $birthday = new Carbon($request->birthday_at);
            } catch (InvalidFormatException) {
                //
            }
        }

        return User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'register_at' => Date::now(),
            'birthday_at' => $birthday ?? null,
        ]);
    }

    public function buildUserResourceFromModel(User $user = null): ?UserResource
    {
        if (empty($user)) {
            return null;
        }

        return new UserResource($user);
    }

    public function buildUserResourceFromModelCollection(Collection|array $users = null): null|AnonymousResourceCollection
    {
        if (empty($users)) {
            return null;
        }

        return UserResource::collection($users);
    }

}
