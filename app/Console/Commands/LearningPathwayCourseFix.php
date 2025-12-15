<?php

namespace App\Console\Commands;

use App\Models\CourseAssignmentToUser;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\LearningPathwayAssignment;
use App\Models\UserLearningPathway;
use App\Models\Stripe\SubscribeCourse;

class LearningPathwayCourseFix extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-pathway-course-fix';

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
            
            $data = LearningPathwayAssignment::query()
                                            ->with('pathway.learningPathwayCoursesOrdered')
                                            ->get();
            //dd($data);

            if($data) {
                foreach($data as $row) {
                    $assigned_users = $row->assigned_to != null ? json_decode($row->assigned_to) : [];
                    
                    foreach($assigned_users as $user) {
                        $already_exits = UserLearningPathway::query()
                                            ->where('user_id', $user)
                                            ->where('pathway_id', $row->pathway_id)
                                            ->count();
                        if($already_exits == 0) {
                            
                            $insert_data = [
                                'user_id' => $user,
                                'pathway_id' => $row->pathway_id,
                            ];
                            UserLearningPathway::insert($insert_data); 
                            
                        }


                        $courses_data = $row->pathway->learningPathwayCoursesOrdered ?? [];
                        foreach($courses_data as $course) {
                            $already_exits = SubscribeCourse::query()
                                                ->where('user_id', $user)
                                                ->where('course_id', $course->course_id)
                                                ->count();
                            if($already_exits == 0) {
                                
                                $insert_data = [
                                    'user_id' => $user,
                                    'due_date' => $row->due_date,
                                    'assign_date' => $row->created_at,
                                    'is_pathway' => $row->pathway_id,
                                    'status' => 1,
                                    'course_id' => $course->course_id
                                ];
                                SubscribeCourse::insert($insert_data); 
                                
                            } else {
                                $insert_data = [
                                    'user_id' => $user,
                                    'due_date' => $row->due_date,
                                    'assign_date' => $row->created_at,
                                    'is_pathway' => $row->pathway_id,
                                    'status' => 1,
                                    'course_id' => $course->course_id
                                ];
                                SubscribeCourse::where('user_id', $user)
                                                    ->where('course_id', $course->course_id)
                                                    ->update($insert_data);
                            }
                        }
                        
                    }
                }
            }

        } catch (\Exception $e) {
            \Log::info('backup update failed - ' . $e->getMessage());
        }

        
    }
}
