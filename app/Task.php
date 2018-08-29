<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Task extends Model
{
    protected $fillable = [
        'user_id','title','task','urgency','importance','status'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public static function getUsersTasksToEmail()
    {
        $usersTasks = DB::table('users')
            ->join('tasks', 'users.id', '=', 'tasks.user_id')
            ->select('users.name', 'users.email', 'tasks.task', 'tasks.urgency', 'tasks.importance', 'tasks.created_at')
            ->where('status', 'on')
            ->where('daily', '1')
            ->orderBy('users.name')
            ->get();

        foreach ($usersTasks as $usersTask){

            if($usersTask->urgency == 1 && $usersTask->importance == 1)
                $usersTasksSortByUser[$usersTask->email][$usersTask->name]['doit'][] = $usersTask;

            if($usersTask->urgency == 1 && $usersTask->importance == 0)
                $usersTasksSortByUser[$usersTask->email][$usersTask->name]['delegate'][] = $usersTask;

            if($usersTask->urgency == 0 && $usersTask->importance == 1)
                $usersTasksSortByUser[$usersTask->email][$usersTask->name]['schedule'][] = $usersTask;

            if($usersTask->urgency == 0 && $usersTask->importance == 0)
                $usersTasksSortByUser[$usersTask->email][$usersTask->name]['drop'][] = $usersTask;
        }

        return json_decode(json_encode($usersTasksSortByUser), true);
    }

    
    
}
