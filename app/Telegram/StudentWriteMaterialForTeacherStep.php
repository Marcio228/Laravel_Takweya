<?php
/**
 * Created by PhpStorm.
 * User: illia
 * Date: 16.08.18
 * Time: 14:53
 */

namespace App\Telegram;

use App\Lesson;
use App\Profile;
use App\Task;
use App\Teacher;
use Carbon\Carbon;
use Telegram;
use Telegram\Bot\Keyboard\Keyboard;

class StudentWriteMaterialForTeacherStep
{

    /**
     * StudentWriteMaterialForTeacherStep constructor.
     */
    public function __construct()
    {
    }

    public function execute($request, $stepOfUser)
    {
        $chatId = $request['message']['chat']['id'];
        $text = $request['message']['text'];

        $stepOfUser->status = "locked";
        $stepOfUser->save();

        $message = "Please wait while we find the best teacher for you";

        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => $message,
        ]);


        $userSubject = \Session::get('student.subject');

        $profile = Profile::where('telegram_id', $chatId)->first();

        $lesson = Lesson::create([
            'student_id' => $profile->user->student->id,
            'description' => $text
        ]);

        $teachers = Teacher::where('grade_id', $profile->user->student->grade->id)
            ->whereHas('subjects', function ($query) use ($userSubject) {
                $query->where('name', $userSubject);
            })
            ->where('is_online', 1)->get();

//        $teachers = Teacher::where('grade', $profile->user->student->grade)
//            ->where('subject', $userSubject)
//            ->where('is_online', 1)->get();


        $message = $lesson->description . ", do you want to accept the request?";

        foreach ($teachers as $teacher) {

            $keyboard = Keyboard::make()
                ->inline()
                ->row(
                    Keyboard::inlineButton([
                        'text' => 'Accept',
                        'callback_data' => "/accept {$lesson->id}"
                    ]),
                    Keyboard::inlineButton([
                        'text' => 'No accept',
                        'callback_data' => "/decline {$lesson->id}"
                    ])
                );


            Telegram::sendMessage([
                'chat_id' => $teacher->user->profile->telegram_id,
                'text' => $message,
                'reply_markup' => $keyboard
            ]);
        }

        //date("d-m-Y h:i", strtotime(Carbon::now()->addMinutes(2)))
        Task::create(['lesson_id' => $lesson->id,
            'execution' => Carbon::now()->addMinutes(1)]);

        return "Ok";
    }
}