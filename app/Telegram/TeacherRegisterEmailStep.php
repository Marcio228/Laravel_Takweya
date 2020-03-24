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
use App\Subject;
use App\Teacher;
use App\User;
use Telegram;
use Sentinel;

class TeacherRegisterEmailStep
{

    /**
     * TeacherRegisterEmailStep constructor.
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

            return "Ok";

        } else if (User::where('email', $text)->exists()) {
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "This email address is already used in the system",
            ]);

            return "Ok";

        } else {
            \Session::put('teacher.email', $text);

            $userName = isset($request['message']['chat']['username']) ? $request['message']['chat']['username'] : "";
            $firstName = isset($request['message']['chat']['first_name']) ? $request['message']['chat']['first_name'] : "";
            $lastName = isset($request['message']['chat']['last_name']) ? $request['message']['chat']['last_name'] : "";
            $email = \Session::get('teacher.email');
            $phone = \Session::get('teacher.phone');
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

            $grade = Grade::where('id', \Session::get('teacher.grade'))->first();

            $teacher = Teacher::create([
                'user_id' => $user->id,
                'grade_id' => $grade->id
            ]);

            $subjectsNameString = "";
            $subjects = \Session::get('teacher.subjects');

            if ($subjects) {
                $teacher->subjects()->attach(array_keys($subjects));
                $subjectsNameString = implode(', ', $subjects);
            }

            $role = Sentinel::findRoleBySlug('teacher');
            $role->users()->attach($user);

            $text = "Your account was created successfully!." .
                "\nGrade: " . $grade->name;

            if ($subjectsNameString) {
                $text .= "\nSubjects: " . $subjectsNameString;
            }
            $text .= "\nPhone: " . \Session::get('teacher.phone') .
                "\nEmail: " . \Session::get('teacher.email') .
                "\nPassword: " . $password .
                "\nUser name: " . $userName .
                "\nFirst Name: " . $firstName .
                "\nLast Name: " . $lastName;

            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => $text
            ]);

            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "Thank you for signing up! \nWe will email you with the application form soon."
            ]);

            $stepOfUser->action = null;
            $stepOfUser->save();

            return "Ok";
        }
    }
}