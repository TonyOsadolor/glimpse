<?php

namespace App\Http\Controllers;

use App\Http\Requests\Events\RegisterEventRequest;
use App\Http\Resources\RegisterEventResource;
use App\Services\RegisterEventService;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\RegisterEvent;
use Illuminate\Http\Request;
use App\Traits\Response;

class RegisterEventController extends Controller
{
    /**
     * Inject Service Class
     * @param RegisterEventService $registerEventService
     */
    public function __construct(public RegisterEventService $registerEventService)
    {
        $this->registerEventService = $registerEventService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $myEvents = $this->registerEventService->index();
        $eventResource = RegisterEventResource::collection($myEvents)->response()->getData(true);

        return Response::success(200, 'My Registered Event', $eventResource);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegisterEventRequest $request)
    {
        $user = Auth::user();
        $eventData = $request->validated();
        
        $eventData['user_id'] = $user->id;

        $registerEvent = $this->registerEventService->store($eventData);

        if($registerEvent['status'] !== 200) {
            return Response::error($registerEvent['status'], "{$registerEvent['msg']}");
        }
        
        $eventResource = new RegisterEventResource($registerEvent['register']);
        return Response::success(201, "{$registerEvent['msg']}", $eventResource);
    }

    /**
     * Display the specified resource.
     */
    public function show(RegisterEvent $event)
    {
        $eventResource = new RegisterEventResource($event);
        return Response::success(200, 'Registered Event Retrieved', $eventResource);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RegisterEvent $event)
    {
        $event = $this->registerEventService->delete($event->id);
        return Response::success(200, 'Event Registration Deleted!'); 
    }
}
