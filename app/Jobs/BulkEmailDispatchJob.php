<?php

namespace App\Jobs;

use App\Jobs\SendEmailJob;
use App\Models\Auth\User;
use App\Models\EmailCampainUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BulkEmailDispatchJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userEmails;
    protected $validated;
    protected $campain_id;

    public function __construct(int $campain_id, array $userEmails, array $validated)
    {
        $this->userEmails = $userEmails;
        $this->validated = $validated;
        $this->campain_id = $campain_id;
    }

    public function handle()
    {
        foreach ($this->userEmails as $email) {
            $user = User::where('email', $email)->first();
            $user_fav_lang = 'english';

            $content = [
                'email_content' => $this->validated['email_content'],
                'email_heading' => 'Welcome to Delta Academy',
                'sub_heading' => 'A journey of learning and development',
                'register_button' => $this->validated['register_button'],
            ];

            $details = [
                'campain_id' => $this->campain_id,
                'to_email' => $email,
                'subject' => $this->validated['subject'],
                'html' => view('emails.default_email_template', [
                    'user' => $user,
                    'content' => $content
                ])->render(),
            ];

            EmailCampainUser::query()
            ->where('email',$email)
            ->where('campain_id', $this->campain_id)
            ->update([
                'status' => 'processed',
                'sent_at' => now()
            ]);

            dispatch(new SendEmailJob($details));
        }
    }
}
