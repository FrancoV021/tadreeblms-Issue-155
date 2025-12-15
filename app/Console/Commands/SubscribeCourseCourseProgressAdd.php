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
use App\Models\EmployeeCourseProgress;
use App\Models\Media;
use App\Models\VideoProgress;

class SubscribeCourseCourseProgressAdd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-subscribe-course-progress-adding';

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
                                    //$query->where('id','4656'); // Filter on the 'user' model's status
                                })
                                ->whereHas('course')
                                ->whereHas('course', function ($query) {
                                    //$query->where('id','289');
                                    //$query->where('is_online','Online');
                                })
                                //->where('is_completed', 1)
                                ->orderBy('id', 'Desc')
                                ->get();
            //dd($data); 

            if($data) {
                $users_ids = [];
                foreach($data as $row) {
                    
                    $course_id = $row->course_id;
                    $user_id = $row->user_id;
                    //$attendance_progress = CustomHelper::progress($row->course_id, $row->user_id);
                    //$score = $row->assignmentScoreValue(@$row->student->id);
                    //dd($course_id,$user_id, $attendance_progress, $score);

                    if($row->course->is_online == 'Offline') {
                        if($row->is_attended == 1 && $row->is_completed == 0) {
                            $row->update([
                                'course_progress_status' => 1
                            ]);
                        }
                        if($row->is_attended == 1 && $row->is_completed == 1) {
                            $row->update([
                                'course_progress_status' => 2
                            ]);
                        }
                    } elseif ($row->course->is_online == 'Live-Classroom') {
                        if($row->is_attended == 1 && $row->is_completed == 0) {
                            $row->update([
                                'course_progress_status' => 1
                            ]);
                        }
                        if($row->is_attended == 1 && $row->is_completed == 1) {
                            $row->update([
                                'course_progress_status' => 2
                            ]);
                        }
                    } else { // Online course



                        if($row->is_completed == 1) {

                            if($row->has_assesment)  {
                                if($row->assesment_taken == 1) {
                                    $row->update([
                                        'course_progress_status' => 2
                                    ]); 
                                } 

                                if($row->assesment_taken == 0) {
                                    $row->update([
                                        'course_progress_status' => 1
                                    ]); 
                                }
                            } else {
                                $row->update([
                                    'course_progress_status' => 2
                                ]);
                            }  
                           
                           
                        }

                        if($row->is_completed == 0) {

                            $total_lessons = Lesson::where('course_id', $course_id)
                                ->where('published', 1)
                                ->pluck('id')
                                ->toArray() ?? [];

                            $total_media_ids = Media::whereIn('model_id', $total_lessons)
                                ->pluck('id')
                                ->toArray() ?? [];
                            
                            $use_has_started = VideoProgress::whereIn('media_id', $total_media_ids)
                                        ->where('user_id', $user_id)
                                        ->where('progress_per', '>' , 90)
                                        ->count();

                            if($use_has_started)  {
                                $row->update([
                                    'course_progress_status' => 1
                                ]);
                            } else {
                                $row->update([
                                    'course_progress_status' => 0
                                ]);
                            }          
                            
                        }
                        
                    }

                    
                    
                    
                }

                //dd($users_ids);
            }

        } catch (\Exception $e) {
            \Log::info('backup update failed - ' . $e->getMessage());
        }

        
    }
}
