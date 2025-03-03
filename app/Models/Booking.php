<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'meeting_room_id',
        'user_id',
        'start_time',
        'end_time',
    ];

    public function meetingRoom()
    {
        return $this->belongsTo(MeetingRoom::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function hasConflict($roomId, $startTime, $endTime)
    {
        return self::where('meeting_room_id', $roomId)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime])
                    ->orWhere(function ($query) use ($startTime, $endTime) {
                        $query->where('start_time', '<', $endTime)
                            ->where('end_time', '>', $startTime);
                    });
            })->exists();
    }
}
