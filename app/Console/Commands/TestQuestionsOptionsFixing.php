<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\TestQuestion;

class TestQuestionsOptionsFixing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fixing-test-questions-options';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        
         
        try {
            $questons_ids = [];
            $test_questons = TestQuestion::query()
                        ->where('id','94')
                        ->get();
            foreach($test_questons as $question) {
                if(!empty($question->option_json)) {
                    if(json_decode($question->option_json)) {
                        $questons_ids[] = $question->id;
                        dd(json_decode($question->option_json));
                    } else {
                        dd(json_decode($question->option_json));
                    }

                }
                
            }

            dd($questons_ids);

        } catch (\Exception $e) {
            \Log::info('backup update failed - ' . $e->getMessage());
        }

        
    }
}
