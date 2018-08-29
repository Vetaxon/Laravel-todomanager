<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $userParameters;

    public function __construct($userParameters)
    {
        $this->userParameters = $userParameters;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Welcome to ToDoManager')
            ->markdown('emails.welcome_mail')
            ->with(['user' => $this->userParameters]);
    }
}
