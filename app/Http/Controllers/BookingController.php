<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Booking;
use App\Models\MeetingRoom;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = MeetingRoom::all();
        $bookings = Booking::with('meetingRoom', 'user')->get();

        return Inertia::render('bookings/Index', [
            'rooms' => $rooms,
            'bookings' => $bookings,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'selectedRoom' => 'required|integer',
            'startTime' => 'required|date',
            'endTime' => 'required|date'
        ]);

        if (Booking::hasConflict($request->selectedRoom, $request->startTime, $request->endTime)) {
            return to_route('bookings.index')->withErrors([
                'selectedRoom' => 'The room is already booked'
            ]);
        }

        $booking = Booking::create([
            'meeting_room_id' => $request->selectedRoom,
            'user_id' => auth()->id(),
            'start_time' => $request->startTime,
            'end_time' => $request->endTime,
        ]);

        return to_route('bookings.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
