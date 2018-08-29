<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DailyMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $userParameters;

    public function __construct($usersParameters)
    {
        $this->usersParameters = $usersParameters;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('task reminder')
            ->markdown('emails.dailymail')
            ->with(['user' => key($this->usersParameters), 'tasks' => $this->usersParameters]);
    }
}
