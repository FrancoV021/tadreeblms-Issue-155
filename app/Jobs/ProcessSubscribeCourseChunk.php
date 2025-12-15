<?php

namespace App\Jobs;

use App\Models\Stripe\SubscribeCourse;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Bus\Dispatchable;
use CustomHelper;

class ProcessSubscribeCourseChunk implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $ids;

    /**
     * Maximum number of attempts before failing permanently
     */
    public $tries = 30;

    /**
     * Job timeout in seconds (1 hour)
     */
    public $timeout = 3600;

    /**
     * Optional: Limit retries within time window
     */
    public function retryUntil()
    {
        return now()->addHours(2);
    }

    /**
     * Constructor
     */
    public function __construct(array $ids)
    {
        $this->ids = $ids;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $rows = SubscribeCourse::with('user', 'course')
                ->whereIn('id', $this->ids)
                ->whereHas('course')
                ->get();

        $updates = [];

        foreach ($rows as $row) {
            try {
                $status = null;
                $score = null;
                $progress_status = 'Not started';
                $progress = 0;

                if ($row->user_id > 0 && $row->course_id > 0) {
                    $progress = CustomHelper::progress($row->course_id, $row->user_id);
                    $progress_status = $progress >= 70 ? 'Completed' : ($progress > 0 ? 'In progress' : 'Not started');

                    $trainer_name = '';
                    $courseUser = DB::table('course_user')->where('course_id', $row->course_id)->first();
                    if ($courseUser) {
                        $user = DB::table('users')->where('id', $courseUser->user_id)->first();
                        $trainer_name = $user ? ($user->first_name . ' ' . $user->last_name) : '';
                    }

                    if (isset($row->student)) {
                        $score = (string) $row->assignmentScore(@$row->student->id);
                    }

                    $status = @$row->course->assignmentStatus(@$row->user_id);

                    $updates[] = [
                        'id' => $row->id,
                        'course_trainer_name' => $trainer_name,
                        'assignment_progress' => $progress,
                        'assignment_status' => $status,
                        'assignment_score' => $score,
                    ];
                }
            } catch (\Throwable $e) {
                \Log::error('Error in ProcessSubscribeCourseChunk', [
                    'row_id' => $row->id ?? null,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                // Continue to next row
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
    }
}
