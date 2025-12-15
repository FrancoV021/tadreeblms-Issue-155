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
use App\Models\CourseFeedback;
use App\Models\EmployeeProfile;
use App\Models\FeedbackQuestion;
use App\Models\Media;
use App\Models\UserFeedback;
use App\Models\VideoProgress;

class UpdateHasAssesmentSubscribeCoursesOldUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-has-assignment-subscribe-courses-old-users';

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
            SubscribeCourse::with(['user', 'course'])
                ->whereHas('course')
                ->whereHas('user', function ($query) {
                    $query->where('employee_type', 'internal'); 
                    //$query->where('id','4939'); // Filter on the 'user' model's status
                })
                ->whereHas('course')
                ->whereHas('course', function ($query) {
                    //$query->where('id','421');
                    //$query->where('is_online','Online');
                })
                ->orderBy('id', 'desc')
                ->chunk(100, function ($rows) {
                    foreach ($rows as $row) {

                        $course_progress_status = 0;
                        $has_feedback = false;
                        $feedback_given = false;

                        $has_assesment = false;
                        $course_id = $row->course_id;
                        $logged_in_user_id = $row->user_id;


                        //for feedback
                        $has_feedback = CourseFeedback::query()
                                    ->where('course_id', $course_id)
                                    ->count();

                        //dd($has_feedback);

                        // $feedback_given = UserFeedback::query()
                        //             ->where('user_id', $logged_in_user_id)
                        //             ->where('course_id',$course_id)
                        //             ->count();


                        $agmt = Assignment::where('assignments.course_id', $course_id)
                                    ->join('courses', 'courses.id', '=', 'assignments.course_id')
                                    ->join('course_assignment', 'course_assignment.course_id', '=', 'courses.id')
                                    ->join('tests', 'tests.id', '=', 'assignments.test_id')
                                    ->join('test_questions', 'test_questions.test_id', '=', 'tests.id')
                                    //->whereRaw('FIND_IN_SET(?, `assign_to`) > 0', $logged_in_user_id)
                                    ->exists();
                        if ($agmt) {
                            $has_assesment = true;
                        }

                        

                        $is_completed = $row->is_completed;

                        //dd($is_completed, $has_assesment, $has_feedback);

                        if( $is_completed == 0 && $row->grant_certificate == 0) {
                            $row->update(
                                [
                                    'has_feedback' => $has_feedback > 0 ? 1 : 0,
                                    'has_assesment' => $has_assesment,
                                ]
                            );
                        }
    

                        
                    }
                });
        } catch (\Exception $e) {
        }
    }
}
