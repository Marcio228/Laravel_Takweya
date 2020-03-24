<?php
/**
 * Created by PhpStorm.
 * User: illia
 * Date: 16.08.18
 * Time: 14:52
 */

namespace App\Telegram;

use App\Grade;
use App\Profile;
use App\Student;
use App\User;
use Telegram;
use Sentinel;

class StudentRegisterEmailStep
{

    /**
     * StudentRegisterEmailStep constructor.
     */
    public function __construct()
    {
    }

    public function execute($request, $stepOfUser)
    {
        $chatId = $request['message']['chat']['id'];
        $text = $request['message']['text'];

        if (!filter_var($text, FILTER_VALIDATE_EMAIL)) {
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "Please write a valid email",
            ]);
        } else if (User::where('email', $text)->exists()) {
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "This email address is already used in the system",
            ]);
        } else {
            \Session::put('student.email', $text);

            $userName = isset($request['message']['chat']['username']) ? $request['message']['chat']['username'] : "";
            $firstName = isset($request['message']['chat']['first_name']) ? $request['message']['chat']['first_name'] : "";
            $lastName = isset($request['message']['chat']['last_name']) ? $request['message']['chat']['last_name'] : "";
            $email = \Session::get('student.email');
            $phone = \Session::get('student.phone');
            $password = str_random(8);

            $user = Sentinel::registerAndActivate([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'password' => $password,
                'password_confirmation' => $password
            ]);

            Profile::create([
                'user_id' => $user->id,
                'telegram_id' => $chatId,
                'phone' => $phone
            ]);

            $grade = Grade::where('id', \Session::get('student.grade'))->first();

            Student::create([
                'user_id' => $user->id,
                'grade_id' => $grade->id
            ]);

            $role = Sentinel::findRoleBySlug('student');
            $role->users()->attach($user);

            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "Your account was created successfully!." .
                    "\nGrade: " . $grade->name .
                    "\nPhone: " . \Session::get('student.phone') .
                    "\nEmail: " . \Session::get('student.email') .
                    "\nPassword: " . $password .
                    "\nUser name: " . $userName .
                    "\nFirst Name: " . $firstName .
                    "\nLast Name: " . $lastName
//                    "\nYou can change your account using a provide link \nhttps://takweya.com/" .
//                    "\nPlease initialize a new session /start as student",
            ]);

            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "Thank you for signing up! \nWe will send you a message as soon as we are ready to launch!"
            ]);

            $stepOfUser->action = null;
            $stepOfUser->save();
        }

        return "Ok";
    }
}