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

class SubscribeCourseFix extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-subscribe-course-fix';

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
                                    //$query->where('id','4576'); // Filter on the 'user' model's status
                                })
                                ->whereHas('course')
                                ->whereHas('course', function ($query) {
                                    //$query->where('id','138');
                                })
                                ->orderBy('id', 'Desc')
                                ->get();
            //dd($data); 

            if($data) {
                $users_ids = [];
                foreach($data as $row) {
                    
                    $course_id = $row->course_id;
                    $user_id = $row->user_id;
                    $attendance_progress = CustomHelper::progress($row->course_id, $row->user_id);
                    $score = $row->assignmentScoreValue(@$row->student->id);
                    //dd($course_id,$user_id, $attendance_progress, $score);
                    if($score == 100 && $score > $attendance_progress) {
                        $total_lessons = Lesson::where('course_id', $course_id)
                            ->where('published', 1)
                            ->pluck('id');
                        //2220, 2221
                        //dd($total_lessons, $course_id);
                        $total_lessons_count = count($total_lessons);
                        $total_lessons_completes = 0;
                        foreach ($total_lessons as $lesson) {
                            $lesson_id = $lesson;
                            $employee_id = $user_id;
                            $chanpter_exits = DB::table('chapter_students')->select('*')
                                ->where('model_id', $lesson_id)
                                ->where('course_id', $course_id)
                                ->where('user_id', $employee_id)
                                ->first();
                            if(!$chanpter_exits) {
                                $chapter_data = [
                                    'model_type' => 'App\Models\Lesson',
                                    'model_id' => $lesson_id,
                                    'course_id' => $course_id,
                                    'user_id' => $employee_id,
                                    'created_at' => date('Y-m-d H:i:s',strtotime("-1 days")),
                                    'updated_at' => date('Y-m-d H:i:s',strtotime("-1 days"))
                                ];
                                ChapterStudent::insert($chapter_data);
                            }

                            $lessonStatusEmployee = CustomHelper::lessonStatusEmployee(0, $lesson, $course_id, $user_id);
                            //dd($lessonStatusEmployee);
                            if ($lessonStatusEmployee == 'Completed') {
                                $total_lessons_completes++;
                            }
                        }
                        
                        $users_ids[] = $user_id;
                    }
                    
                    
                }

                //dd($users_ids);
            }

        } catch (\Exception $e) {
            \Log::info('backup update failed - ' . $e->getMessage());
        }

        
    }
}
