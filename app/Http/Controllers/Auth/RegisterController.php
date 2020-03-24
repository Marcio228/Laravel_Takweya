<?php

namespace App\Http\Controllers\Auth;

use App\Mail\EmailActivate;
use App\ReferralLink;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Sentinel;
use Activation;
use Mail;

class RegisterController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }

    public function postRegister(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'unique:users|required|string|email|max:255',
            'password' => 'confirmed|required|string|min:6',
            'password_confirmation' => 'required|string|min:6'
        ]);

        $user = Sentinel::registerAndActivate($request->all());

        $role = Sentinel::findRoleBySlug('teacher');
        $role->users()->attach($user);

        Sentinel::login($user);

        return redirect('/');
    }

    private function sendEmail($user, $code)
    {
        Mail::to($user->email)
            ->queue(new EmailActivate($user, $code));
    }
}
