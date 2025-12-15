<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\LearningPathwayAssignment;
use App\Models\LearningPathwayCourse;
use App\Models\courseAssignment;
use App\Models\Stripe\SubscribeCourse;
use DB;
use App\Models\Auth\User;

class RemoveDuplicateSubsribeCourse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remove-duplicate-subsribe-course';

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
            
            $lpa = DB::select("SELECT user_id, course_id, COUNT(*) 
                FROM subscribe_courses 
                WHERE 1 
                GROUP BY user_id, course_id
                HAVING COUNT(*) > 1
            ");
            if($lpa) {
                foreach($lpa as $row) {
                    if($row->user_id) {
                        $duplicateList = SubscribeCourse::where('user_id', $row->user_id)
                            ->where('course_id', $row->course_id)
                            ->get();
                        $firstUser = $duplicateList->first();
                        $duplicateList->shift();
                        foreach ($duplicateList as $row) {
                            $row->delete();
                        }
                    }
                    
                }
            }

        } catch (\Exception $e) {
            \Log::info('backup update failed - ' . $e->getMessage());
        }

        
    }
}
