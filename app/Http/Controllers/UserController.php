<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    function getUsers()
    {
        $users = User::all();
        return response()->json(['users' => $users], 200);
    }

    function store(Request $request)
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
        $hasher = Hash::check($password, $user->password);
        if (!$user || !$hasher) {
            return response()->json(['errors' => 'your login was not authenticated'], 400);
        }
        $token = $user->createToken('my-token')->plainTextToken;
        return response()->json(['user' => $user, 'token' => $token], 200);
    }
}