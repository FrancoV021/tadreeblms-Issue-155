<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PathwayAssignmentWelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $user;

    public function __construct($user, $data)
    {
        $this->data = $data;
        $this->user = $user;
    }

    public function build()
    {
        //dd("gd");
        return $this->from('training@delta-medlab.com', 'Delta Academy')
                    ->subject('New Assignment | Delta Academy')
                    ->view('emails.pathway_assignment_welcome')
                    ->with([
                        'user' => $this->user,
                        'details' => $this->data
                    ]);
    }
}
