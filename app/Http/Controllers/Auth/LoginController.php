<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Sentinel;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;

class LoginController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        try {
            $remember = false;

            if (isset($request->remember)) {
                $remember = true;
            }

            if (Sentinel::authenticate($request->all(), $remember)) {
                $redirect = Session::get('loginRedirect', '/');
                Session::forget('loginRedirect');

                return redirect()->to($redirect);
            } else {
                return redirect()->back()->with(['error' => 'These credentials do not match our records.'])
                    ->withInput(['email' => $request->input('email')]);
            }
        } catch (ThrottlingException $e) {
            $delay = $e->getDelay();
            return redirect()->back()->with(['error' => "You are banned for $delay seconds"]);
        } catch (NotActivatedException $e) {
            return redirect()->back()->with(['error' => "Your account is not activated!"]);
        }
    }

    public function logout()
    {
        Sentinel::logout();

        return redirect('/login');
    }
}
