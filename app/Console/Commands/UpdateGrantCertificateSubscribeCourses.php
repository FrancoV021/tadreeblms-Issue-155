<?php

namespace App\Console\Commands;

use App\Helpers\CustomHelper;
use App\Jobs\SendEmailJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\LearningPathwayAssignment;
use App\Models\LearningPathwayCourse;
use App\Models\courseAssignment;
use App\Models\Stripe\SubscribeCourse;
use Illuminate\Support\Facades\DB;

class UpdateGrantCertificateSubscribeCourses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-grant-certificate-subscribecourses';

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
            
            SubscribeCourse::with('user', 'course')
            ->where('is_completed', 1)
            ->where('grant_certificate', '0')
            ->whereHas('course')
            ->orderBy('id', 'Desc')
            ->chunk(100, function ($chunk) {
                foreach ($chunk as $row) {
                    
                    $updates = [];

                    if($row->user_id > 0 && $row->course_id >0) {
                       
                        /*
                        $progress = CustomHelper::progress($row->course_id, $row->user_id);
                        //dd($progress);
                        if(isset($row->student)) {
                            $srore = (string)$row->assignmentScore(@$row->student->id);
                        }
                        $status = @$row->course->assignmentStatus(@$row->user_id);

                        $row->assignment_progress = $progress;
                        $row->assignment_status = $status;
                        $row->assignment_score = $srore; 
                        */
                        
                       $grant_certificate = $row->course->grantCertificate($row->user_id) ?? 0;
                       if($row->assignment_progress == 100)
                       {
                        $grant_certificate = 1;
                       }

                        $updates[] = [
                            'id' => $row->id,
                            'grant_certificate' => $grant_certificate,
                        ];
                    }
                    
                }

                foreach ($updates as $update) {
                    DB::table('subscribe_courses')
                        ->where('id', $update['id'])
                        ->update([
                            'grant_certificate' => $update['grant_certificate'],
                        ]);
                }
            });

        } catch (\Exception $e) {
            \Log::info('backup update failed - ' . $e->getMessage());
        }

        
    }
}
