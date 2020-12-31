<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getUsers()
    {
        $users = User::all();
        return response()->json(['users' => $users], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:10|min:5',
            'email' => 'required|email|',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        };

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password'))
        ]);
        $token = $user->createToken($request->password)->plainTextToken;
        return response()->json(['messages' => "user has been created", 'user' => $user, 'token' => $token], 200);
    }
    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json(['errors' => 'Your email or password is incorrect'], 400);
        }
        $hasher = Hash::check($password, $user->password);
        if (!$user || !$hasher) {
            return response()->json(['errors' => 'your login was not authenticated'], 400);
        }
        $token = $user->createToken('my-token')->plainTextToken;
        return response()->json(['user' => $user, 'token' => $token], 200);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => ['required'],
            'password' => ['confirmed', 'required'],
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $hasher = Hash::check($request->input('old_password'), Auth::user()->password);
        if (!$hasher) {
            return response()->json(['error' => 'Your old password does not match'], 400);
        }
        $user = User::find(Auth::id());
        $user->password = Hash::make($request->input('password'));
        $user->save();
        return response()->json(['success' => 'Your password has been succesfully changed']);
    }
}