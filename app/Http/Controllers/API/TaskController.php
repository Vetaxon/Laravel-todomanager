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
        $tasks_done = $this->sortTasks(User::findOrFail(Auth::id())->tasks()->orderBy('updated_at')->get()->where('status', 'done')->toArray());

        return response()->json(['success' => ['on' => $tasks_on]]);
    }

    public function indexArchive()
    {
        $tasks_done = User::findOrFail(Auth::id())->tasks()->orderBy('updated_at')->where('status', 'done')->jsonPaginate(10);

        return $tasks_done;
    }


    public function store(Request $request)
    {
        $input = $this->prepareInput($request->all());

        if (array_key_exists('errors', $input))
            return response()->json($input);

        $input['status'] = 'on';

        User::findOrFail(Auth::id())->tasks()->create($input);

        return $this->index();
    }

    public function show($id)
    {
        return response()->json([User::findOrFail(Auth::id())->tasks()->findOrFail($id)]);
    }

    public function update(Request $request, $id)
    {
        if (array_key_exists('status', $request->all()) && count($request->all()) == 1)
            return $this->updateStatus($request->all(), $id);

        if (array_key_exists('urgency', $request->all())
            && array_key_exists('importance', $request->all())
            && count($request->all()) == 2
        ){
            return $this->updateTaskValue($request->all(), $id);
        }
    }

    protected function updateStatus($request, $id)
    {
        $validator = Validator::make($request, [
            'status' => 'required|max:4|min:2',
        ]);

        if ($validator->fails())
            return response()->json(['errors' => $validator->errors()]);

        $task = User::findOrFail(Auth::id())->tasks()->findOrFail($id)->update($request);

        if ($task)
            return response()->json(['success' => 'updated']);
    }

    protected function updateTaskValue($request, $id)
    {
        $validator = Validator::make($request, [
            'importance' => 'required|integer|max:1',
            'urgency' => 'required|integer|max:1',
        ]);

        if ($validator->fails())
            return response()->json(['errors' => $validator->errors()]);

        $task = User::findOrFail(Auth::id())->tasks()->findOrFail($id)->update($request);

        if ($task)
            return $this->index();
    }


    public function destroy($id)
    {
        User::findOrFail(Auth::id())->tasks()->findOrFail($id)->delete();

        return response()->json(['success' => 'deleted']);
    }

    protected function prepareInput($input)
    {
        $validator = Validator::make($input, [
            'task' => 'required|string|max:2000|min:3',
            'importance' => 'required|integer|max:1',
            'urgency' => 'required|integer|max:1'
        ]);

        if ($validator->fails())
            return ['errors' => $validator->errors()];

        $input['title'] = substr($input['task'], 0, 25) . "...";

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
