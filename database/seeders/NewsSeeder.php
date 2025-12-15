<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $news_1 = [
            'title' => 'Lorem ipsum dolor sit amet',
            'content' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod',
            'status' => 1,
            'lang' => 'en',
            'slug' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod',
        ];

        $news_2 = [
           'title' => 'Lorem ipsum dolor sit amet',
            'content' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod',
            'status' => 1,
            'lang' => 'ar',
            'slug' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod',
        ];

        // $news_3 = [
        //     'title' => 'Lorem ipsum dolor sit amet',
        //     'content' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod',
        //     'status' => 1,
        //     'lang' => 'en',
        //     'slug' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod',
        // ];

        // $news_4 = [
        //     'title' => 'Lorem ipsum dolor sit amet',
        //     'content' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod',
        //     'status' => 1,
        //     'lang' => 'ar',
        //     'slug' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod',
        // ];

      \App\Models\News::firstOrCreate($news_1);
      \App\Models\News::firstOrCreate($news_2);
      //\App\Models\News::firstOrCreate($news_3);
      //\App\Models\News::firstOrCreate($news_4);
    }
}
