<?php
/**
 * Created by PhpStorm.
 * User: illia
 * Date: 16.08.18
 * Time: 15:06
 */

namespace App\Telegram;

use App\Subject;
use Telegram;

class TeacherRegisterSubjectStep
{

    /**
     * TeacherRegisterSubjectStep constructor.
     */
    public function __construct()
    {
    }

    public function execute($request, $stepOfUser)
    {
        $chatId = $request['message']['chat']['id'];
        $text = $request['message']['text'];

        if ($text != "/finish") {

            $grade = \Session::get('teacher.grade');

            $subject = Subject::where('name', $text)->whereHas('grades', function ($query) use ($grade) {
                $query->where('id', $grade);
            })->first();
//            $subject = Subject::where('name', $text)->where('grade_id', \Session::get('teacher.grade'))->first();

            if ($subject) {

                $subjects = [];

                if (\Session::has('teacher.subjects')) {
                    $subjects = \Session::get('teacher.subjects');
                }

                if (!array_key_exists($subject->id, $subjects)) {
                    $subjects[$subject->id] = $subject->name;
                }

                \Session::put('teacher.subjects', $subjects);

            } else {
                Telegram::sendMessage([
                    'chat_id' => $chatId,
                    'text' => 'Subject not found',
                ]);
            }

        } else {
            if (!(\Session::has('teacher.subjects'))) {
                Telegram::sendMessage([
                    'chat_id' => $chatId,
                    'text' => 'You should write subjects'
                ]);
            } else {

                $reply_markup = Telegram\Bot\Keyboard\Keyboard::remove();

                Telegram::sendMessage([
                    'chat_id' => $chatId,
                    'text' => 'What is your phone?',
                    'reply_markup' => $reply_markup
                ]);
                $stepOfUser->action = 'teacherRegisterPhoneStep';
                $stepOfUser->save();
            }
        }

        return "Ok";
    }
}