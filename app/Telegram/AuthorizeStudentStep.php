<?php
/**
 * Created by PhpStorm.
 * User: illia
 * Date: 16.08.18
 * Time: 14:53
 */

namespace App\Telegram;

use App\Profile;
use App\Teacher;
use Illuminate\Support\Facades\DB;
use Telegram;

class AuthorizeStudentStep
{

    /**
     * AuthorizeStudentStep constructor.
     */
    public function __construct()
    {
    }

    public function execute($request, $stepOfUser)
    {
        $chatId = $request['message']['chat']['id'];
        $text = $request['message']['text'];

        $inputSubject = $text;

        $profile = Profile::where('telegram_id', $chatId)->first();

        $uniqueSubjects = $profile->user->student->grade->subjects;

        $userSubject = "";

        foreach ($uniqueSubjects as $subject) {
            if ($subject->name == $inputSubject) {
                $userSubject = $inputSubject;
                break;
            }
        }

//        $parameters = explode(' ', $text);
//
//        $inputSubject = $parameters[0];


//        $uniqueSubjects = DB::table('teachers')
//            ->select('subject')
//            ->groupBy('subject')
//            ->get();
//
//        $userSubject = "";
//
//        foreach ($uniqueSubjects as $subject) {
//            if ($subject->subject == $inputSubject) {
//                $userSubject = $inputSubject;
//                break;
//            }
//        }

        if (!empty($userSubject)) {

            \Session::put('student.subject', $userSubject);

            $profile = Profile::where('telegram_id', $chatId)->first();

            $balanceOfUser = $profile->user->student->balance;

            if ($balanceOfUser < 15) {
                $countOfTeachers = Teacher::where('grade_id', $profile->user->student->grade->id)
                    ->whereHas('subjects', function ($query) use ($userSubject) {
                        $query->where('name', $userSubject);
                    })
                    ->where('is_online', 1)->count();

//                $countOfTeachers = Teacher::where('grade', $profile->user->student->grade)
//                    ->where('subject', $userSubject)
//                    ->where('is_online', 1)->count();

                $message = "We have found {$countOfTeachers} teachers for you who are ready to help you! \n - Your balance is: {$balanceOfUser} \n - Please log in through \nhttps://takweya.com/edit-profile \nto purchase tutoring minute and initialize a new session /start";

                Telegram::sendMessage([
                    'chat_id' => $chatId,
                    'text' => $message,
                ]);
                $stepOfUser->action = null;
                $stepOfUser->save();

                return "Ok";

            } else {
                $message = "Please write down of the material you need help in.";

                Telegram::sendMessage([
                    'chat_id' => $chatId,
                    'text' => $message,
                ]);

                $stepOfUser->action = "studentWriteMaterialForTeacher";
                $stepOfUser->save();

                return "Ok";
            }

        } else {

            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => 'Subject not found. Please input new subject or create new session /start',
            ]);

            return "Ok";
        }
    }
}