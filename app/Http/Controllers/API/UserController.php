<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Events\Message;
use Illuminate\Http\Request;
use App\Jobs\SendNewPassEmail;
use App\Jobs\SendWelcomeMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class UserController extends Controller
{

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|exists:users',
            'password' => 'required|string|min:6',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['access_token'] = $user->createToken('')->accessToken;
            $success['user'] = [
                'name' => $user->name,
                'email' => $user->email
            ];

            return response()->json(['success' => $success]);

        } else {
            return response()->json(['errors' => ['password' => ['Invalid password.']]]);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'password_confirmation' => 'required|string|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $input = $request->all();

        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);

        $success['access_token'] = $user->createToken('')->accessToken;
        $success['user'] = [
            'name' => $user->name,
            'email' => $user->email
        ];

        SendWelcomeMessage::dispatch($success['user']);

        return response()->json(['success' => $success]);
    }

    public function forgot(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|exists:users',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $newPassword = str_random(6);

        $newPasswordHash = bcrypt($newPassword);

        $user = User::where('email', $request->email);

        $updatePass = $user->update(['password' => $newPasswordHash]);

        $userParams = $user->get()->first();

        if ($updatePass) {

            $paramsForLetter = [
                'name' => $userParams->name,
                'email' => $userParams->email,
                'newpass' => $newPassword
            ];            
            
            SendNewPassEmail::dispatch($paramsForLetter);            
            
            return response()->json(['success' => 'success']);
        }

        return response()->json(['errors']);
    }

    public function update(Request $request)
    {
        if (array_key_exists('name', $request->all()) && count($request->all()) == 1)
            return $this->updateName($request->all());

        if (array_key_exists('email', $request->all()) && count($request->all()) == 1)
            return $this->updateEmail($request->all());

        if (array_key_exists('password', $request->all()))
            return $this->updatePassword($request->all());

        if (array_key_exists('daily', $request->all()) && count($request->all()) == 1)
            return $this->updateDaily($request->all());

        return response()->json(404);
    }

    protected function updateDaily($request)
    {
        $validator = Validator::make($request, [
            'daily' => 'required|in:0,1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        if($request['daily'] == '1')
            Message::dispatch(['message' => 'Now, you will receive a mailing list of all your current tasks every day!', 'room_id' => Auth::id()]);

        if($request['daily'] == '0')
            Message::dispatch(['message' => 'That is your choice!', 'room_id' => Auth::id()]);

        $user = User::findOrFail(Auth::id())->update($request);

        if ($user) {
            return response()->json(['success' => User::findOrFail(Auth::id())]);
        }

    }

    protected function updateName($request)
    {
        $validator = Validator::make($request, [
            'name' => 'required|string|max:255|min:3',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $user = User::findOrFail(Auth::id())->update($request);

        if ($user) {
            return response()->json(['success' => User::findOrFail(Auth::id())]);
        }

    }

    protected function updateEmail($request)
    {
        $validator = Validator::make($request, [
            'email' => 'required|string|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $user = User::findOrFail(Auth::id())->update($request);

        if ($user) {
            return response()->json(['success' => User::findOrFail(Auth::id())]);
        }

    }   
    

    protected function updatePassword($request)
    {
        $validator = Validator::make($request, [
            'password_old' => 'required|string|min:6',
            'password' => 'required|string|min:6',
            'password_confirmation' => 'required|string|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        if (Hash::check($request['password_old'], Auth::user()->password)) {

            $request['password'] = bcrypt($request['password']);

            $user = User::findOrFail(Auth::id());

            if ($user->update($request)) {
                $success['access_token'] = $user->createToken('')->accessToken;
                return response()->json(['success' => $success]);
            }

        } else {
            return response()->json(['errors' => ['password' => ['Invalid password.']]]);
        }

    }


}
