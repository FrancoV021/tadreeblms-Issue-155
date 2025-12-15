<?php

namespace App\Jobs;

use App\Mail\PathwayAssignmentWelcomeMail;
use App\Models\Auth\User;
use CustomHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class PathwayAssignmentEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    public $recipients = [];

    public function __construct($recipients, $data)
    {
        $this->data = $data;
        $this->recipients = $recipients;
        //dd($this->user);
    }

    public function handle()
    {
        foreach($this->recipients as $user) {
           
            $user_detail = User::where('id', $user['id'])->first();

             $variables = [
                    '{User_Name}' => $user_detail->fav_lang == 'english' ? $user_detail->first_name : $user_detail->arabic_first_name,
                    '{Course_Title}' => $this->data['assignment_title'],
                    '{Link}' => $this->data['site_url'],
             ];
    
            $email_template = CustomHelper::emailTemplates('pathway_assignment', $user_detail->fav_lang, $variables);

            $details = [
                'to_email' => $user_detail->email,
                'subject' => $email_template['subject'],
                'html' => view('emails.default_email_template', [
                    'user' =>  $user_detail,
                    'content' => $email_template
                ])->render(), 
            ];

            dispatch(new SendEmailJob($details));

        }
        
    }
}
