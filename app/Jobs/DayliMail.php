<?php

namespace App\Jobs;

use App\Mail\DailyMail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class DayliMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userParameters;
    protected $email;


    public function __construct($email, $usersTasks)
    {
        $this->email = $email;
        $this->userParameters = $usersTasks;
    }

    public function handle()
    {
        Mail::to($this->email)->send(new DailyMail($this->userParameters));
    }
}
