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
        return response()->json([User::findOrFail(Auth::id())->tasks()->get()]);
    }

    public function create()
    {
        //
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
}
