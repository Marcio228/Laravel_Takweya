<?php

namespace App\Http\Controllers\Auth;

use App\Mail\ForgotPassword;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Sentinel;
use App\User;
use Reminder;
use Mail;

class ForgotPasswordController extends Controller
{
    public function forgotPassword()
    {
        return view('auth.passwords.email');
    }

    public function postForgotPassword(Request $request)
    {
        $user = User::whereEmail($request->email)->firstOrFail();

        $reminder = Reminder::exists($user) ?: Reminder::create($user);

        $this->sendEmail($user, $reminder->code);

        return redirect('/login')->with('success', 'Resent link was sent your email');
    }

    public function resetPassword($email, $resetCode)
    {
        $user = User::whereEmail($email)->firstOrFail();

        if ($reminder = Reminder::exists($user)) {
            if ($resetCode == $reminder->code) {
                return view('auth.passwords.reset');
            } else {
                return redirect('/login')->with('error', 'Wrong credentials');
            }
        } else {
            return redirect('/login')->with('error', 'Wrong credentials');;
        }
    }

    public function postResetPassword(Request $request, $email, $resetCode)
    {
        $this->validate($request, [
            'password' => 'confirmed|required|string|min:6',
            'password_confirmation' => 'required|string|min:6'
        ]);

        $user = User::whereEmail($email)->firstOrFail();

        if ($reminder = Reminder::exists($user)) {
            if ($resetCode == $reminder->code) {
                Reminder::complete($user, $resetCode, $request->password);

                return redirect('/login')->with('success', 'Please login with your new password');
            } else {
                return redirect('/login')->with('error', 'Wrong credentials');
            }
        } else {
            return redirect('/login')->with('error', 'Wrong credentials');
        }
    }

    private function sendEmail($user, $code)
    {
        Mail::to($user->email)
            ->queue(new ForgotPassword($user, $code));
    }
}
