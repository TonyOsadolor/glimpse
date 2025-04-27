<?php

namespace App\Services;

use App\Models\Event;
use App\Models\RegisterEvent;
use Illuminate\Support\Facades\Auth;

class RegisterEventService
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        return RegisterEvent::where('user_id', $user->id)->paginate(20);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(array $data)
    {
        $user = Auth::user();
        try {
            $check = $this->checkEventQualification($user->id, $data['event_id']);            
            $data['event_id'] = $check['event']['id'];

            $create = RegisterEvent::create($data);
            return [
                'status' => 200,
                'msg' => 'Event Registration Successful!',
                'register' => $create,
            ];
        } catch (\Exception $error) {
            $httpCode = $error->getCode() > 0 ? $error->getCode() : 500;
            return [
                'status' => $httpCode,
                'msg' => $error->getMessage(),
            ];
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $event = RegisterEvent::find($id);
        $event->delete();
    }

    /**
     * Private function to check for 
     * Overlapping Event
     */
    private function checkEventQualification($userId, $eventId)
    {
        $event = Event::active()->where('uuid', $eventId)->first();
        if (!$event) throw new \Exception("Invalid Event Data", 400);
        
        $register = RegisterEvent::query();
        $selfRegisteration = $register->where('event_id', $event->id)->where('user_id', $userId)->count();
        $registration = $register->where('event_id', $event->id)->count();
        $alreadyRegistered = RegisterEvent::where('user_id', $userId)
            ->whereHas('event', function ($query) use ($event) {
                $query->where('start_time', $event->start_time);
            })->exists();
        
        if(!$event) {
            throw new \Exception("Event Not Found!", 404);
        }
        if($event && $event->start_time < now()) {
            throw new \Exception("Sorry, Registration has Closed", 400);
        }
        if($event && $registration >= $event->max_participants) {
            throw new \Exception("Sorry, maximum Participants reached!", 400);
        }
        if($selfRegisteration) {
            throw new \Exception("You have already Registered for this Event!", 403);
        }
        if($alreadyRegistered) {
            throw new \Exception("Sorry You cannot Register for Overlapping Events", 403);
        }

        return [
            'event' => $event,
        ];
    }
}