<?php

namespace App\Http\Controllers;

use App\Http\Resources\EventResource;
use App\Http\Controllers\Controller;
use App\Services\EventService;
use Illuminate\Http\Request;
use App\Traits\Response;
use App\Models\Event;

class ParticipantEventController extends Controller
{
    /**
     * Inject Service Class
     * @param EventService $eventService
     */
    public function __construct(public EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = $this->eventService->publicindex();
        $eventResource = EventResource::collection($events)->response()->getData(true);

        return Response::success(200, 'Open Events Retrieved', $eventResource);
    }

    /**
     * Display the specified resource.
     * 
     * @var Event $event
     */
    public function show(Event $event)
    {
        $eventResource = new EventResource($event);
        return Response::success(200, 'Event Retrieved', $eventResource);
    }
}
