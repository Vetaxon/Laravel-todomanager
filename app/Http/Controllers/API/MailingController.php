<?php

namespace App\Http\Controllers\API;

use App\Jobs\DayliMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Task;


class MailingController extends Controller
{
    public function daily()
    {
        $usersTasks = Task::getUsersTasksToEmail();

        return view('emails.test')->withTasks($usersTasks['vitalii.ivanov1983@gmail.com']);

    }
}
