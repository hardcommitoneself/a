<?php

namespace Database\Seeders;

use App\Models\MeetingRoom;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MeetingRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MeetingRoom::create(['name' => 'Conference Room A', 'capacity' => 10]);
        MeetingRoom::create(['name' => 'Meeting Room B', 'capacity' => 5]);
    }
}
