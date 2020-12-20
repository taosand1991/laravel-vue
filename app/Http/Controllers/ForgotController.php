<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\WelcomeVerify;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ForgotController extends Controller
{
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email']
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 400);
        }
        $status = Password::sendResetLink($request->only('email'));
        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['status' => __($status)], 200);
        } else {
            return response()->json(['status' => __($status)], 400);
        }
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => ['required'],
            'email' => ['email', 'required'],
            'password' => ['confirmed', 'required']
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
                $user->setRememberToken(Str::random(60));
                event(new PasswordReset($user));
            }
        );
        if ($status == Password::PASSWORD_RESET) {
            $user = User::where('email', $request->only('email'))->first();
            $user->notify(new WelcomeVerify($user));
            return response()->json(['status' => __($status)], 200);
        } else {
            return response()->json(['status' => [__($status)]], 400);
        }
    }
}