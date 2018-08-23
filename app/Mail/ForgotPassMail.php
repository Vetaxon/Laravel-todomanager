<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ForgotPassMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $userParameters;

    public function __construct($userParameters)
    {
        $this->userParameters = $userParameters;
    }
    
    public function build()
    {
        return $this->subject('Change password')
            ->markdown('emails.forgotpass')
            ->with(['user' => $this->userParameters]);

    }
}
