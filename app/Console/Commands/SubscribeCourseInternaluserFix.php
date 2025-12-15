<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\LearningPathwayAssignment;
use App\Models\UserLearningPathway;
use App\Models\Stripe\SubscribeCourse;
use App\Helpers\CustomHelper;
use App\Models\Lesson;
use Illuminate\Support\Facades\DB;
use App\Models\ChapterStudent;

class SubscribeCourseInternaluserFix extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-subscribe-course-internal-fix';

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
            
            $data = SubscribeCourse::with('user', 'course')
                                ->whereHas('user', function ($query) {
                                    $query->where('employee_type', 'internal'); 
                                    //$query->where('id','4212'); // Filter on the 'user' model's status
                                })
                                ->whereHas('course')
                                ->whereHas('course', function ($query) {
                                    //$query->where('id','138');
                                })
                                ->where('status',0)
                                ->orderBy('id', 'Desc')
                                ->get();
            //dd($data); 

            if($data) {
                
                foreach($data as $row) {
                    $row->status = 1;
                    $row->save();
                }

                //dd($users_ids);
            }

        } catch (\Exception $e) {
            \Log::info('backup update failed - ' . $e->getMessage());
        }

        
    }
}
