<?php

namespace App\Http\Controllers\Api\Events;

use App\Http\Controllers\BaseApiController;
use App\Http\Requests\CreateEventRequest;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\User;
use App\Repository\EventRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class EventController extends BaseApiController
{
    public function __construct(
        readonly private EventRepository $eventRepository,
    ) {
        //
    }

    public function index(Request $request): JsonResponse
    {
        return $this->sendResponse([
            'events' => $this->eventRepository->getAll(),
        ]);
    }

    public function my(Request $request): JsonResponse
    {
        /* @var User $user */
        $user = Auth::user();

        return $this->sendResponse([
            'events' => $this->eventRepository->getForUser($user),
        ]);
    }

    public function create(CreateEventRequest $request): JsonResponse
    {
        $createData = $request->only(array_keys($request->validated()));

        /* @var User $user */
        $user = Auth::user();
        $createData['user_id'] = $user->id;

        $event = $this->eventRepository->create($createData);

        return $this->sendResponse([
            'event' => $event,
        ]);
    }

    public function delete(Event $event): JsonResponse
    {
        /* @var User $user */
        $user = Auth::user();

        return $this->sendResponse($this->eventRepository->delete($event, $user));
    }

    public function participants(Event $event): JsonResponse
    {
        return $this->sendResponse([
            'participants' => $this->eventRepository->participants($event)
        ]);
    }

    public function participantsAttach(Event $event): JsonResponse
    {
        /* @var User $user */
        $user = Auth::user();

        return $this->sendResponse($this->eventRepository->participantsAttach($event, $user));
    }

    public function participantsDetach(Event $event): JsonResponse
    {
        /* @var User $user */
        $user = Auth::user();

        return $this->sendResponse($this->eventRepository->participantsDetach($event, $user));
    }
}
