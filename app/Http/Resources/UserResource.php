<?php

namespace App\Http\Resources;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

/**
 * Class UserResource
 * @property string $id
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property null|Collection<Event> $events
 * @property string $register_at
 * @property null|string $birthday_at
 * @property null|string $created_at
 * @property null|string $updated_at
 */
class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'events' => EventResource::collection($this->whenLoaded('events')),
            'register_at' => $this->register_at,
            'birthday_at' => $this->birthday_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
