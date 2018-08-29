<?php

namespace App\Console\Commands;

use App\Jobs\DayliMail;
use App\Task;
use Illuminate\Console\Command;

class SendDailyEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Daily email sending tasks to users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $usersTasks = Task::getUsersTasksToEmail();

        foreach ($usersTasks as $email => $userTasks) {
            DayliMail::dispatch($email, $userTasks);
        }
    }
}
