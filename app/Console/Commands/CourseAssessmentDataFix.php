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
use App\Models\courseAssignment;
use App\Models\EmployeeProfile;

class CourseAssessmentDataFix extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-course-assesment-fix';

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
        
         //dd("hhhh");
        try {
            
            $courses_ids = [];
            
            $data = courseAssignment::query()
                                ->with('assignedBy', 'course', 'department')->orderBy('id', 'Desc')
                                //->where('course_id','121')
                                ->get();
            
            if($data) {
                foreach($data as $row) {

                    if(empty($row->department_id)) {
                        $assigned_users = $row->assign_to != null ? explode(',',$row->assign_to) : [];
                    } else {
                        // get all users by department
                        $assigned_users = self::getAllUsersByDepartment($row->department_id) ?? [];
 
                    }
                    
                    $course_id = $row->course_id;
                    foreach($assigned_users as $user_id) {
                        if($user_id) {
                            $courses_ids[] = $course_id;
                            $already_exits = SubscribeCourse::query()
                                                ->where('user_id', $user_id)
                                                ->where('is_pathway', $row->is_pathway)
                                                ->where('course_id', $course_id)
                                                ->count();
                            //dd($already_exits);
                            if($already_exits == 0) {
    
                                $insert_data = [
                                    'user_id' => $user_id,
                                    'is_pathway' => $row->is_pathway,
                                    'status' => 1,
                                    'due_date' => $row->due_date,
                                    'assign_date' => $row->assign_date,
                                    'course_id' => $course_id
                                ];
                                //dd($insert_data);
                                SubscribeCourse::insert($insert_data); 
    
                            } else {
                                $upadte_data = [
                                    'user_id' => $user_id,
                                    'is_pathway' => $row->is_pathway,
                                    'status' => 1,
                                    'due_date' => $row->due_date,
                                    'assign_date' => $row->assign_date,
                                    'course_id' => $course_id
                                ];
                                //dd($upadte_data);
                                SubscribeCourse::where('user_id', $user_id)
                                                    ->where('is_pathway', $row->is_pathway)
                                                    ->where('course_id', $course_id)
                                                    ->update($upadte_data);
                            }
                        }
                        
                    }
                    
                }
            } 

            //dd($courses_ids);

        } catch (\Exception $e) {
            \Log::info('backup update failed - ' . $e->getMessage());
        }

        
    }

    protected function getAllUsersByDepartment($dept_id)
    {
        return EmployeeProfile::query()
            ->where('department', $dept_id)
            ->pluck('user_id');
    }
}
