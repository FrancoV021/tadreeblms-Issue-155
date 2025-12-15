<?php

namespace App\Http\Controllers\Frontend\User;

use App\Helpers\CustomHelper;
use App\Http\Controllers\Controller;
use App\Jobs\SendEmailJob;
use DB;
use App\Models\Auth\User;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
/**
 * Class DashboardController.
 */
class DashboardController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('frontend.user.dashboard');
    }


    public function cron_reminder_due_date()
    {
        if(!isset($_GET['days'])){
            echo 'Please add days in url like : ?days=2';die;
        }
        $days=(!empty($_GET['days']))?$_GET['days']:0;


        $today_date=date('Y-m-d');
        $next_date= date('Y-m-d', strtotime($today_date. ' + '.$days.' days'));

        $course_assignment=DB::table('course_assignment')->whereDate('due_date',$next_date)->get();
        foreach ($course_assignment as $this_course_assignment) {
            $course_detail=DB::table('courses')->where('id',$this_course_assignment->course_id)->first();
            foreach (explode(',',$this_course_assignment->assign_to) as $this_assign_to) {
                $user = User::where('id', $this_assign_to)->first();
                try {

                $course_link = url("/course/$course_detail->slug");
                $user_fav_lang = $user->fav_lang;
                $username = $user->full_name;

                if ($user_fav_lang == 'arabic') {
                    $username = $user->arabic_full_name??$user->full_name;
                }

                $variables = [
                    '{User_Name}' => $username,
                    '{Course_Link}' => $course_link,
                    '{Due_Date}' => date('d M Y', strtotime($this_course_assignment->due_date)),
                ];
    
                $email_template = CustomHelper::emailTemplates('assignment_reminder', $user_fav_lang, $variables);

                
                $details = [
                    'to_email' => $user->email,
                    'subject' => $email_template['subject'],
                    'html' => view('emails.default_email_template', [
                        'user' =>  $user,
                        'content' => $email_template
                    ])->render(), 
                ];

                dispatch(new SendEmailJob($details));

                }catch (Exception $e) {

                }
            }
        }
       echo 'Successfully';die;

    }
}
