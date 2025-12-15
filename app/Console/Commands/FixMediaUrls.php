<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Lexx\ChatMessenger\Models\Message;
use Lexx\ChatMessenger\Models\Participant;
use Lexx\ChatMessenger\Models\Thread;
use Illuminate\Support\Facades\Schema;

class FixMediaUrls extends Command
{
   
    protected $signature = 'fix:media-urls';

    
    protected $description = 'fix old chat package to new package insert data';

    
    public function __construct()
    {
        parent::__construct();
    }

    
    public function handle()
    {
        DB::table('media_')
            //->whereNull('aws_url')
            ->orderBy('id')
            ->chunk(200, function ($rows) {

                foreach ($rows as $row) {
                    DB::table('media')
                        ->where('id', $row->id)
                        ->where('model_id', $row->model_id)
                        ->update([
                            'aws_url' => $row->aws_url
                        ]);
                }

            });


        $this->info("Done updating media table.");
    }
}
