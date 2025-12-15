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

class CourseTypeFix extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'course-type-fix';

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
            
            $data = Course::with('coursePublishedLessons')
                                ->orderBy('id', 'Desc')
                                //->where('id','135')
                                ->get();
            

            if($data) {
               
                foreach($data as $row) {
                   
                    
                   if($row->coursePublishedLessons->count() == 0) {
                     $row->is_online = 'Offline';
                     
                   } else {
                    $row->is_online = 'Online';
                    
                   }
                   $row->save();
                    
                }

                //dd($users_ids);
            }

        } catch (\Exception $e) {
            \Log::info('backup update failed - ' . $e->getMessage());
        }

        
    }
}
