<?php

namespace App\Http\Controllers;

use App\Http\Requests\Events\CreateEventRequest;
use App\Http\Requests\Events\UpdateEventRequest;
use App\Http\Resources\EventResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Services\EventService;
use Illuminate\Http\Request;
use App\Traits\Response;
use App\Models\Event;

class EventController extends Controller
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
        $events = $this->eventService->companyIndex();
        $eventResource = EventResource::collection($events)->response()->getData(true);

        return Response::success(200, 'Events Retrieved', $eventResource);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateEventRequest $request)
    {
        $eventData = $request->validated();
        $company = Auth::user();

        $eventData['company_id'] = $company->id;
        $eventData['is_active'] = true; // can be redefined for users choice

        $event = $this->eventService->store($eventData);
        $eventResource = new EventResource($event);

        return Response::success(201, 'Event Created!', $eventResource);
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

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        $eventData = $request->validated();

        $event = $this->eventService->update($eventData, $event->id);
        $eventResource = new EventResource($event);

        return Response::success(201, 'Event Updated!', $eventResource);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event = $this->eventService->delete($event->id);
        return Response::success(200, 'Event Deleted!');        
    }
}
