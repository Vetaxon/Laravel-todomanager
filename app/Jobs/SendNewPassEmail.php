<?php

namespace App\Jobs;

use App\Mail\ForgotPassMail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendNewPassEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userParameters;
   

    public function __construct($userParameters)
    {
        $this->userParameters = $userParameters;
    }

    public function handle()
    {
        if(Mail::to($this->userParameters['email'])->send(new ForgotPassMail($this->userParameters)))
            info($this->userParameters);
    }
}
