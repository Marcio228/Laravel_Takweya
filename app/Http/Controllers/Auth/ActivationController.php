<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Sentinel;
use Activation;
use App\Http\Controllers\Controller;

class ActivationController extends Controller
{
    public function activate($email, $activationCode)
    {
        $user = User::whereEmail($email)->firstOrFail();

        if (Activation::complete($user, $activationCode)) {
            return redirect('/login')->with('success', 'Your account was activated');
        } else {
            return redirect('/login')->with('error', 'Wrong credentials');
        }
    }
}
