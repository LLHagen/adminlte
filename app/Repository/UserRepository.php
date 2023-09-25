<?php

namespace App\Repository;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection;

class UserRepository
{
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
