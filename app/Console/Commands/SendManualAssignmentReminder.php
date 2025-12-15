<?php

namespace App\Console\Commands;

use App\Helpers\CustomHelper;
use App\Jobs\SendEmailJob;
use App\Models\AssessmentAccount;
use App\Models\Assignment;
use App\Models\Auth\User;
use App\Models\courseAssignment;
use App\Models\ManualAssessment;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendManualAssignmentReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:manual-auto-assignment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will send reminders for all manual assignments based on due date before x days as defined in handle method.';

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
     * @return int
     */
    public function handle()
    {

        $fiveDaysFromNow = Carbon::now()->addDays(5)->startOfDay();
        $fifteenDaysFromNow = Carbon::now()->addDays(15)->startOfDay();

        $this->sendManualAssesmentReminder($fiveDaysFromNow, $fifteenDaysFromNow);
        $this->sendAssesmentReminder($fiveDaysFromNow, $fifteenDaysFromNow);
        
    }

    protected function sendManualAssesmentReminder($fiveDaysFromNow, $fifteenDaysFromNow)
    {
        // Fetch records matching the criteria
        $assessments = ManualAssessment::whereDate('due_date', $fiveDaysFromNow)
            ->orWhereDate('due_date', $fifteenDaysFromNow)
            ->get();

        if ($assessments->isEmpty()) {
            $this->info('No assessments found with due dates exactly 5 or 15 days from now.');
            return;
        }

        // Perform actions on each assessment
        foreach ($assessments as $assessment) {
            if ($assessment->user) {
                $test_taken = CustomHelper::is_test_taken($assessment->assessment_id, $assessment->user_id);
                if (!$test_taken) {
                    $this->info("Processing assessment ID: {$assessment->id}");

                    $due_date = date('d M Y', strtotime($assessment->due_date));
                    $assessment_title = $assessment->assignment->test->title;
                    $test_link = route('manual_online_assessment', ['assignment' => $assessment->assignment->url_code, 'verify_code' => $assessment->assignment->verify_code, 'assessment_id' => $assessment->assessment_id, 'manual_assessment_id' => $assessment->id]);

                    //         //send a notification
                    //         $details['to_email'] = $assessment->user->email;
                    //         $details['subject'] = "Reminder for $assessment_title assessment | " . env("APP_NAME");
                    //         $details['html'] = "# Hello " . $assessment->user->name . "<br>
                    // This is a friendly reminder for the $assessment_title assessment. Kindly complete it by $due_date.<br>
                    // <a href='" . $test_link . "'>Assessment Link</a>
                    // <br>
                    // <br>
                    // <br>
                    // Thanks,<br> " . env('APP_NAME');

                    $user_fav_lang = $assessment->user->fav_lang;

                    $variables = [
                        '{User_Name}' => $assessment->user->name,
                        '{Course_Link}' => $test_link,
                        '{Due_Date}' => $due_date,
                        '{Subject}' => $assessment_title,
                    ];

                    $email_template = CustomHelper::emailTemplates('assignment_reminder', $user_fav_lang, $variables);

                    $details = [
                        'to_email' => $assessment->user->email,
                        'subject' => $email_template['subject'],
                        'html' => view('emails.default_email_template', [
                            'user' =>  $assessment->user,
                            'content' => $email_template
                        ])->render(), 
                    ];

                    dispatch(new SendEmailJob($details));
                }
            }
        }

        $this->info('Due date checks and actions completed successfully.');
    }

    protected function sendAssesmentReminder($fiveDaysFromNow, $fifteenDaysFromNow)
    {
        // Fetch records matching the criteria
        $assessments = courseAssignment::with(['assessment'])->whereDate('due_date', $fiveDaysFromNow)
            ->orWhereDate('due_date', $fifteenDaysFromNow)
            ->get();

       //dd($assessments, $fiveDaysFromNow, $fifteenDaysFromNow);

        if ($assessments->isEmpty()) {
            $this->info('No assessments found with due dates exactly 5 or 15 days from now.');
            return;
        }

        // Perform actions on each assessment
        foreach ($assessments as $assessment) {

            if($assessment->assessment) {

                $users = $assessment->assign_to != null ? explode(",", $assessment->assign_to) : [];
            
                $test_id = $assessment->assessment->test_id ?? null;

                if($test_id) {
                    //dd($assessment?->assessment?->course_id);

                    foreach($users as $user) {
                        if ($user) {

                            

                            $test_taken = CustomHelper::is_test_taken($test_id, $user);

                            //dd($test_taken);

                            if (!$test_taken) {
                                $this->info("Processing assessment ID: {$assessment->id} & UserID: {$user}");

                                $due_date = date('d M Y', strtotime($assessment->due_date));
                                //dd( $due_date );
                                $assessment_title = $assessment->assessment->test->title;
                                //dd($assessment_title);

                                $test_link = route('online_assessment', ['assignment' => $assessment->assessment->url_code, 'verify_code' => $assessment->assessment->verify_code, 'assessment_id' => $assessment->assessment->id]);

                                //dd($test_link);

                                $user_detail = User::where('id', $user)->first();

                                //send a notification
                                //$details['to_email'] = $user_detail->email;

                                $this->info("Processing Email Ids: { $user_detail->email } ");
                                //dd($details['to_email']);

                                // $details['subject'] = "Reminder for $assessment_title assessment | " . env("APP_NAME");
                                // $details['html'] = "# Hello " . $user_detail->name . "<br>
                                // Please Ignore it!! This is a friendly reminder for the $assessment_title assessment. Kindly complete it by $due_date.<br>
                                // <a href='" . $test_link . "'>Assessment Link</a>
                                // <br>
                                // <br>
                                // <br>
                                // Thanks,<br> " . env('APP_NAME');

                                $user_fav_lang = $user_detail->fav_lang;

                                $variables = [
                                    '{User_Name}' => $user_detail->name,
                                    '{Course_Link}' => $test_link,
                                    '{Due_Date}' => $due_date,
                                    '{Subject}' => $assessment_title,
                                ];

                                $email_template = CustomHelper::emailTemplates('assignment_reminder', $user_fav_lang, $variables);

                                $details = [
                                    'to_email' => $user_detail->email,
                                    'subject' => $email_template['subject'],
                                    'html' => view('emails.default_email_template', [
                                        'user' =>  $user,
                                        'content' => $email_template
                                    ])->render(), 
                                ];

                                dispatch(new SendEmailJob($details));
                                //dd("stops");
                            }
                        }
                    }
                }

                
            }
            
            
        }

        $this->info('Due date checks and actions completed successfully.');
    }
}
