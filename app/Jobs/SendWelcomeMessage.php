<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;

class SendWelcomeMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userParameters;

    public function __construct($userParameters)
    {
        $this->userParameters = $userParameters;
    }

    public function handle()
    {
        Mail::to($this->userParameters['email'])->send(new WelcomeMail(['name' => $this->userParameters['name']]));
    }
}
