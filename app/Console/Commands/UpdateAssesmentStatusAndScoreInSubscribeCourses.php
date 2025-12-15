<?php

namespace App\Console\Commands;

use App\Helpers\CustomHelper;
use App\Jobs\SendEmailJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\LearningPathwayAssignment;
use App\Models\LearningPathwayCourse;
use App\Models\courseAssignment;
use App\Models\EmployeeCourseProgress;
use App\Models\Stripe\SubscribeCourse;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UpdateAssesmentStatusAndScoreInSubscribeCourses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-assesmentstatus-score-subscribecourses';

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
        $startDate = Carbon::now()->subMonths(6);
        $endDate = Carbon::now();

        try {
            
            $today_course_taken = EmployeeCourseProgress::query()
                ->where('is_cron_run', 0)
                ->whereDate('created_at', $endDate->toDateString())
                ->get();

            
            $userCourseMap = $today_course_taken->map(function ($item) {
                return [
                    'user_id' => $item->user_id,
                    'course_id' => $item->course_id,
                ];
            });

            
            foreach ($userCourseMap as $map) {
                SubscribeCourse::with(['user', 'course', 'student', 'employeeProfile.department_details'])
                    ->where('user_id', $map['user_id'])
                    ->where('course_id', $map['course_id'])
                    ->whereHas('course')
                    ->chunk(100, function ($chunk) {
                        $updates = [];

                        foreach ($chunk as $row) {
                            $progress = 0;
                            $progress_status = 'Not started';
                            $assignment_score = null;
                            $assignment_status = null;
                            $trainer_name = '';

                            if ($row->user_id && $row->course_id) {
                                $progress = CustomHelper::progress($row->course_id, $row->user_id);

                                if ($progress > 0 && $progress < 70) {
                                    $progress_status = 'In progress';
                                } elseif ($progress >= 70) {
                                    $progress_status = 'Completed';
                                }

                                // Trainer name (from course_user table)
                                $courseUser = DB::table('course_user')->where('course_id', $row->course_id)->first();
                                if ($courseUser) {
                                    $user = DB::table('users')->where('id', $courseUser->user_id)->first();
                                    $trainer_name = $user ? $user->first_name . ' ' . $user->last_name : '';
                                }

                                // Score and assignment status
                                if ($row->student) {
                                    $assignment_score = (string)$row->assignmentScore($row->student->id);
                                }

                                if ($row->course) {
                                    $assignment_status = $row->course->assignmentStatus($row->user_id, $progress);
                                }

                                if($row->grant_certificate != 1) {
                                    // Prepare update row
                                    $updates[] = [
                                        'id' => $row->id,
                                        'course_trainer_name' => $trainer_name,
                                        'assignment_progress' => $progress,
                                        'assignment_status' => $assignment_status,
                                        'assignment_score' => $assignment_score,
                                    ];
                                }

                                
                            }
                        }

                        
                        foreach ($updates as $update) {
                            DB::table('subscribe_courses')
                                ->where('id', $update['id'])
                                ->update([
                                    'course_trainer_name' => $update['course_trainer_name'],
                                    'assignment_progress' => $update['assignment_progress'],
                                    'assignment_status' => $update['assignment_status'],
                                    'assignment_score' => $update['assignment_score'],
                                ]);
                        }
                    });

                
                EmployeeCourseProgress::where('user_id', $map['user_id'])
                    ->where('course_id', $map['course_id'])
                    ->update(['is_cron_run' => 1]);
            }
        } catch (\Exception $e) {
            $details = [
                'to_name' => '',
                'to_email' => 'akumar@beyondtech.club',
                'subject' => 'Update Cron Assessment Status, Score, Trainer Name',
                'html' => 'Please fix the error: ' . $e->getMessage()
            ];

            dispatch(new SendEmailJob($details));
            \Log::error('Assessment cron failed: ' . $e->getMessage());
        }
    }
}
