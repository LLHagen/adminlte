<?php

namespace App\Http\Controllers\Events;

use App\Http\Controllers\Controller;
use App\Models\Event;

class EventController extends Controller
{
    public function show(Event $event)
    {
        return view('events.show', [
            'users' => $event->participants()->paginate(),
            'event' => $event,
        ]);
    }
}
