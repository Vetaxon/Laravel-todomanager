<?php

namespace App\Http\Controllers\API;

use App\Task;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class TaskController extends Controller
{
    public function index()
    {

        $tasks_on = $this->sortTasks(User::findOrFail(Auth::id())->tasks()->orderBy('created_at')->get()->where('status', 'on')->toArray());
        $tasks_done = $this->sortTasks(User::findOrFail(Auth::id())->tasks()->orderBy('created_at')->get()->where('status', 'done')->toArray());

        return response()->json(['success' => ['on' => $tasks_on, 'done' => $tasks_done]]);
    }


    public function store(Request $request)
    {

        if (array_key_exists('errors', $this->prepareInput($request->all())))
            return response()->json($this->prepareInput($request->all()));

        $task = User::findOrFail(Auth::id())->tasks()->create($this->prepareInput($request->all()));

        return response()->json(['success' => $task]);

    }

    public function show($id)
    {
        return response()->json([User::findOrFail(Auth::id())->tasks()->findOrFail($id)]);
    }

    public function update(Request $request, $id)
    {
        if (array_key_exists('errors', $this->prepareInput($request->all())))
            return response()->json($this->prepareInput($request->all()));

        $task = User::findOrFail(Auth::id())->tasks()->findOrFail($id)->update($this->prepareInput($request->all()));

        return response()->json(['success' => $task]);

    }


    public function destroy($id)
    {
        User::findOrFail(Auth::id())->tasks()->findOrFail($id)->delete();

        return response()->json(['success' => 'deleted']);
    }

    protected function prepareInput($input)
    {
        $validator = Validator::make($input, [
            'task' => 'required|string|max:700|min:3',
            'importance' => 'required|integer|max:1',
            'urgency' => 'required|integer|max:1'
        ]);

        if ($validator->fails())
            return ['errors' => $validator->errors()];

        $input['title'] = substr($input['task'], 0, 40) . "...";
        $input['status'] = 'on';

        return $input;
    }

    protected function sortTasks($tasks)
    {
        $tasks_sorted['doit'] = [];
        $tasks_sorted['schedule'] = [];
        $tasks_sorted['delegate'] = [];
        $tasks_sorted['drop'] = [];

        foreach ($tasks as $task) {

            if ($task['urgency'] == 1 && $task['importance'] == 1)
                array_push($tasks_sorted['doit'], $task);

            if ($task['urgency'] == 0 && $task['importance'] == 1)
                array_push($tasks_sorted['schedule'], $task);

            if ($task['urgency'] == 1 && $task['importance'] == 0)
                array_push($tasks_sorted['delegate'], $task);

            if ($task['urgency'] == 0 && $task['importance'] == 0)
                array_push($tasks_sorted['drop'], $task);

        }

        return $tasks_sorted;
    }
}
