<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $item_1 = [
            'title' => 'Lorem ipsum dolor sit amet',
            'content' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod',
            'icon' => 'slider-1.jpg',
            'lang' => 'en',
            'status' => 1,
            'event_date' => date('Y-m-d H:i:s'),
        ];

        $item_2 = [
            'title' => 'Lorem ipsum dolor sit amet',
            'content' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod',
            'icon' => 'slider-1.jpg',
            'lang' => 'en',
            'status' => 1,
            'event_date' => date('Y-m-d H:i:s'),
        ];

        $item_3 = [
            'title' => 'Lorem ipsum dolor sit amet',
            'content' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod',
            'icon' => 'slider-1.jpg',
            'lang' => 'en',
            'status' => 1,
            'event_date' => date('Y-m-d H:i:s'),
        ];

      \App\Models\Events::firstOrCreate($item_1);
      \App\Models\Events::firstOrCreate($item_2);
      \App\Models\Events::firstOrCreate($item_3);

      
      \App\Models\Library::firstOrCreate($item_1);
      \App\Models\Library::firstOrCreate($item_2);
      \App\Models\Library::firstOrCreate($item_3);
    }
}
