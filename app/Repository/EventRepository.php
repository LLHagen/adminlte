<?php

namespace App\Repository;

use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection;
use Throwable;

class EventRepository
{
    public function __construct(
        readonly private UserRepository $userRepository,
    ) {
        //
    }

    public function getAll(): null|AnonymousResourceCollection
    {
        return $this->buildEventResourceFromModelCollection(Event::all());
    }

    public function create(array $createData): ?EventResource
    {
        $event = Event::create($createData);

        if (empty($event)) {
            return null;
        }

        return $this->buildEventResourceFromModel($event);
    }

    public function delete(Event $event, User $creator): bool|null
    {
        if (!$event->user_id == $creator->id) {
            return false;
        }

        return $event->delete();
    }

    public function participants(Event $event): null|AnonymousResourceCollection
    {
        return $this->userRepository->buildUserResourceFromModelCollection($event->participants()->get());
    }

    public function participantsAttach(Event $event, User $participant): bool
    {
        try {
            $event->participants()->attach($participant->id);

            return true;
        } catch (Throwable $exception) {
            return false;
        }
    }

    public function participantsDetach(Event $event, User $participant): bool
    {
        try {
            $event->participants()->detach($participant->id);

            return true;
        } catch (Throwable $exception) {
            return false;
        }
    }

    public function buildEventResourceFromModel(Event $event= null): ?EventResource
    {
        if (empty($event)) {
            return null;
        }

        return new EventResource($event);
    }

    public function buildEventResourceFromModelCollection(Collection|array $events = null): null|AnonymousResourceCollection
    {
        if (empty($events)) {
            return null;
        }

        return EventResource::collection($events);
    }
}
