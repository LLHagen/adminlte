<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

/**
 * Class EventResource
 * @property string $id
 * @property string $title
 * @property string $text
 * @property User $creator
 * @property null|Collection<User> $participants
 * @property null|string $created_at
 * @property null|string $updated_at
 */
class EventResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'text' => $this->text,
            'creator' => new UserResource($this->whenLoaded('creator')),
            'participants' => UserResource::collection($this->whenLoaded('participants')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
