<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Attendee;
use App\Models\Event;
use App\Models\User;

class AtendeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users =User::all();
        $events = Event::all();

        foreach($users as $user) {
            $eventsToAttend = $events->random(rand(1, 3)); // Randomly select 1 to 3 events for each user
            foreach ($eventsToAttend as $event) {
                Attendee::factory()->create([
                    'user_id' => $user->id,
                    'event_id' => $event->id,
                ]);
            }
        }
    }
}
