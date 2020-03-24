<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Sentinel;

class UserController extends Controller
{
    public function index()
    {
        $currentUser = User::where('id', Sentinel::getUser()->id)->firstOrFail();

        $users = User::where('id', '!=', $currentUser->id)->get();

        return view('admin.users.index', compact('users'));
    }
}