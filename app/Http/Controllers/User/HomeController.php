<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\ReferralTelegramUser;
use App\User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class HomeController extends Controller
{
    public function index()
    {
        $currentUser = User::where('id', Sentinel::getUser()->id)->firstOrFail();

        $user = null;

        if ($currentUser->inRole('teacher')) {
            $user = $currentUser->teacher;
        } else {
            $user = $currentUser->student;
        }

        $historyLessons = $user->lessons()->active()
            ->orderByDesc('created_at')->limit(3)->get();

        return view('user.home.index', compact('historyLessons'));
    }
}
