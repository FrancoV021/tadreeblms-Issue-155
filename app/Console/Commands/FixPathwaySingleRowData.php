<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\LearningPathwayAssignment;
use App\Models\UserLearningPathway;
use App\Models\Stripe\SubscribeCourse;
use App\Helpers\CustomHelper;
use App\Models\Assignment;
use App\Models\Lesson;
use Illuminate\Support\Facades\DB;
use App\Models\ChapterStudent;
use App\Models\courseAssignment;
use App\Models\CourseAssignmentToUser;
use App\Models\CourseFeedback;
use App\Models\EmployeeProfile;
use App\Models\FeedbackQuestion;
use App\Models\Media;
use App\Models\UserFeedback;
use App\Models\VideoProgress;

class FixPathwaySingleRowData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix-pathway-single-row-data';

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
            LearningPathwayAssignment::with(['pathwayCourses', 'pathwayCourses.course'])
                ->whereHas('pathwayCourses.course')
                //->where('id', 102)
                ->orderBy('id', 'desc')
                ->chunk(100, function ($rows) {
                    foreach ($rows as $row) {

                        $assigned_users = json_decode($row->assigned_to) ?? [];

                        $row->pathwayCourses;

                        foreach($assigned_users as $user) {
                            if($row->pathwayCourses) {
                                foreach($row->pathwayCourses as $pathCourse) {
                                    $updated = CourseAssignmentToUser::updateOrCreate(
                                        [
                                        
                                            'course_id' => $pathCourse->course->id,
                                            'user_id' => $user,
                                        ],
                                        [
                                            'created_at' => $row->created_at,
                                            'updated_at' => $row->updated_at,
                                            'course_assignment_id' => $row->id,
                                            'log_comment' => 'cmd run',
                                            'by_pathway' => 1
                                        ]
                                    );
                                }
                            }
                        }

                        
                        

                        $has_feedback = 0;
                        $feedback_given = 0;
                        $has_assesment = 0;
                        $assignment_taken = 0;
                        $course_progress_status = 0;
                        $is_completed = 0;
                        
                        // $row->update(
                        //     [
                        //         'has_feedback' => $has_feedback > 0 ? 1 : 0,
                        //         'feedback_given' => $feedback_given > 0 ? 1 : 0,
                        //         'has_assesment' => $has_assesment,
                        //         'assesment_taken' => $assignment_taken,
                        //         'course_progress_status' => $course_progress_status,
                        //         'is_completed' => $is_completed > 0 ? 1 : 0,
                        //     ]
                        // );
                    }
                });
        } catch (\Exception $e) {
        }
    }
}
