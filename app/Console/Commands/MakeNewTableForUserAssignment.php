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
use App\Models\courseAssignment;
use App\Models\CourseAssignmentToUser;
use App\Models\EmployeeProfile;

class MakeNewTableForUserAssignment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:course_assignment_users';

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
            
            $data = courseAssignment::query()
                                //->where('course_id','273')
                                //->where('id','4450')
                                ->get();
            



            if($data) {
               
                foreach($data as $row) {
                    
                    if(!empty($row->assign_to)) {
                        $assigned_users = $row->assign_to != null ? explode(',',$row->assign_to) : [];
                    } else {
                        // get all users by department
                        $assigned_users = self::getAllUsersByDepartment($row->department_id) ?? [];
 
                    }
                    //dd($assigned_users);
                    if($row->course_id) {
                        foreach($assigned_users as $user_id) {
                            $updated = CourseAssignmentToUser::updateOrCreate(
                                [
                                   
                                    'course_id' => $row->course_id,
                                    'user_id' => $user_id,
                                ],
                                [
                                    'course_assignment_id' => $row->id,
                                    'log_comment' => 'cmd run'
                                ]
                            );
                            
                            //dd($updated);
                        }
                    }
                    
                    
                }

                
            }

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
