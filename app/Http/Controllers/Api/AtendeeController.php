<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttendeeResource;
use App\Http\Traits\CanLoadRelationships;
use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Http\Request;

class AtendeeController extends Controller
{
    use CanLoadRelationships;
    private readonly array $relations;
    public function __construct()
    {
        $this->relations = [
            'user',
        ];

        $this->middleware('auth:sanctum')->except(['index', 'show']);

        $this->middleware('throttle:api')
            ->only(['store', 'destroy']);

        $this->authorizeResource(Attendee::class, 'attendee');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Event $event)
    {
        $attendees = $this->loadRelationships(
            $event->attendees()->latest()
        );

        return AttendeeResource::collection(
            $attendees->paginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Event $event)
    {
        $attendee = $this->loadRelationships($event->attendees()->create([
            'user_id' => $request->user()->id,
        ]));

        return new AttendeeResource($attendee);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event, Attendee $attendee)
    {
        return new AttendeeResource($this->loadRelationships($attendee));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event, Attendee $attendee)
    {
        //$this->authorize('delete-attendee', [$event, $attendee]);
        $attendee->delete();
        return response()->noContent(status: 204);
    }
}
