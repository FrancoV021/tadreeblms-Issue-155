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
use App\Models\Course;

class FixCoursesProgress extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix-course-progress';

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
            
            $data = SubscribeCourse::query()
                                //->with(['course'])
                                ->orderBy('id', 'Desc')
                                //->where('course_id','354')
                                //->where('user_id','4475')
                                ->get();
            

            if($data) {
               
                foreach($data as $row) {
                   
                    
                  
                    if($row->grant_certificate == 1) {
                        $row->assignment_progress = 100;
                        $row->save();
                        //dd("sds");
                    }
                   
                        
                    

                   

                  
                    
                }

                //dd($users_ids);
            }

        } catch (\Exception $e) {
            dd('backup update failed - ' . $e->getMessage());
        }

        
    }

    

}
