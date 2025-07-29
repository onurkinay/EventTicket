<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Event::create([
            'title' => 'Hamlet',
            'event_date' => '2025-09-01 20:00:00',
            'description' => 'A tragedy by William Shakespeare. It tells the story of Prince Hamlet, who seeks revenge against his uncle Claudius, who has murdered Hamlet\'s father, taken the throne, and married Hamlet\'s mother.',
            'venue_id' => 1,
            'image' => '/imgs/hamlet.jpg',
        ])->update(['created_at' => Date::now(), 'updated_at' => Date::now()]);

        Event::create([
            'title' => 'Macbeth',
            'event_date' => '2025-10-05 21:00:00',
            'description' => 'A tragedy by William Shakespeare. Set in Scotland, it tells the story of Macbeth, a Scottish general whose ambition leads him to treach',
            'venue_id' => 2,
            'image' => '/imgs/macbeth.jpg',
        ])->update(['created_at' => Date::now(), 'updated_at' => Date::now()]);

        Event::create([
            'title' => 'Romeo and Juliet',
            'event_date' => '2025-10-10 18:30:00',
            'description' => 'A tragedy by William Shakespeare. It tells the story of two young star-crossed lovers whose deaths ultimately reconcile their feuding families.',
            'venue_id' => 3,
            'image' => '/imgs/romeo_and_juliet.jpg',
        ])->update(['created_at' => Date::now(), 'updated_at' => Date::now()]);

        Event::create([
            'title' => 'Othello',
            'event_date' => '2025-10-15 19:30:00',
            'description' => 'A tragedy by William Shakespeare. It tells the story of Othello, a Moorish general in the Venetian army, who is manipulated by his envious subordinate Iago into believing that his wife Desdemona has been unfaithful.',
            'venue_id' => 4,
            'image' => '/imgs/othello.jpg',
        ])->update(['created_at' => Date::now(), 'updated_at' => Date::now()]);
    }
}
