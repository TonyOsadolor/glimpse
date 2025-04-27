<?php

namespace App\Services;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventService
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Event::paginate(20);
    }

    /**
     * Display a listing of the resource.
     */
    public function publicindex()
    {
        return Event::active()
            ->where('start_time', '>=', now())
            ->where('end_time', '>=', now())
            ->paginate(20);
    }

    /**
     * Display a listing of the Company Events.
     */
    public function companyIndex()
    {
        $user = Auth::user();
        return Event::where('company_id', $user->id)->paginate(20);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($data)
    {
        return Event::create($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($data, string $id)
    {
        $event = Event::where('id', $id)->orWhere('uuid', $id)->first();
        $event->update($data);
        return $event;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $event = Event::where('id', $id)->orWhere('uuid', $id)->first();
        $event->delete();
    }
}