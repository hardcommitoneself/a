<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Booking;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Booking::create([
            'meeting_room_id' => 1,
            'user_id' => 1,
            'start_time' => now()->addHours(rand(1, 24)),
            'end_time' => now()->addHours(rand(25, 48)),
        ]);
    }
}
