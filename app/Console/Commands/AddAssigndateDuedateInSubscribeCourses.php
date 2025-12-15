<?php

namespace App\Console\Commands;

use App\Jobs\SendEmailJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\LearningPathwayAssignment;
use App\Models\LearningPathwayCourse;
use App\Models\courseAssignment;
use App\Models\Stripe\SubscribeCourse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AddAssigndateDuedateInSubscribeCourses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'assign-date-in-subsribe-course';

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
                ->whereHas('user', function ($query) {
                    $query->where('employee_type', 'internal');
                })
                ->whereHas('course')
                ->where(function ($query) {
                    $query->whereNull('assign_date')
                    ->orWhereNull('due_date');
                })
                ->orderBy('id', 'desc')
                ->chunk(100, function ($courses) {

                    $updates = [];

                    foreach ($courses as $row) {
                        $assign_dates = [];
                        $due_dates = [];

                        if ($assignment = $row->courseAssignment()) {
                            $assign_dates[] = $assignment->assign_date ? Carbon::parse($assignment->assign_date)->format('Y-m-d') : '';
                            $due_dates[] = $assignment->due_date ? Carbon::parse($assignment->due_date)->format('Y-m-d') : '';
                        }

                        if ($pathwayAssignment = $row->courseAssigmentByPathway()) {
                            $assign_dates[] = $pathwayAssignment->created_at ? Carbon::parse($pathwayAssignment->created_at)->format('Y-m-d') : '';
                            $due_dates[] = $pathwayAssignment->due_date ? Carbon::parse($pathwayAssignment->due_date)->format('Y-m-d') : '';
                        }

                        $assign_dates = array_filter($assign_dates);
                        $due_dates = array_filter($due_dates);

                        $assign_date = count($assign_dates) ? min($assign_dates) : null;
                        $due_date = count($due_dates) ? min($due_dates) : null;

                        $updates[] = [
                            'id' => $row->id,
                            'assign_date' => $assign_date,
                            'due_date' => $due_date,
                        ];
                    }

                    // 🧠 Now update each row in DB in a loop (per chunk)
                    foreach ($updates as $update) {
                        DB::table('subscribe_courses')
                            ->where('id', $update['id'])
                            ->update([
                                'assign_date' => $update['assign_date'],
                                'due_date' => $update['due_date'],
                            ]);
                    }
                });
        } catch (\Exception $e) {
            $details['to_name'] = '';
            $details['to_email'] = 'akumar@beyondtech.club';
            $details['subject'] = 'Update Due Date Issue By Cron';
            $details['html'] = '
                Please fix the error ' . $e->getMessage() .'
            ';
    
            dispatch(new SendEmailJob($details));
            \Log::info('backup update failed - ' . $e->getMessage());
        }
    }
}
