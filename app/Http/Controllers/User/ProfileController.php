<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\User;
use Sentinel;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = User::where('id', Sentinel::getUser()->id)->firstOrFail();

        return view('user.profile.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = User::where('id', Sentinel::getUser()->id)->firstOrFail();

        $this->validate($request, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => "unique:users,email,$user->id,id|required|string|email|max:255",
//            'grade' => 'required',
        ]);

        $user->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email')
        ]);

        if ($user->inRole('student')) {
            $user->student->update([
//                'grade' => $request->input('grade'),
                'balance' => $request->input('balance')
            ]);
        }
//        else {
//            $user->teacher->update([
//                'grade' => $request->input('grade'),
//                'subject' => $request->input('subject')
//            ]);
//        }

        return redirect('/edit-profile')->with('message', 'Your profile was updated successfully');
    }
}
