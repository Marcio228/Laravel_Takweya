<?php
/**
 * Created by PhpStorm.
 * User: illia
 * Date: 16.08.18
 * Time: 14:51
 */

namespace App\Telegram;

use App\Grade;
use App\Subject;
use Telegram;
use Telegram\Bot\Keyboard\Keyboard;

class TeacherRegisterGradeStep
{

    /**
     * TeacherRegisterGradeStep constructor.
     */
    public function __construct()
    {
    }

    public function execute($request, $stepOfUser)
    {

        $chatId = $request['message']['chat']['id'];
        $text = $request['message']['text'];

        $grade = Grade::where('name', $text)->first();

        if (!$grade) {
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => 'Grade not found',
            ]);
        } else if ($grade->slug == "university") {
            \Session::put('teacher.grade', $grade->id);

            $reply_markup = Telegram\Bot\Keyboard\Keyboard::remove();

            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => 'What is your phone?',
                'reply_markup' => $reply_markup
            ]);
            $stepOfUser->action = 'teacherRegisterPhoneStep';
            $stepOfUser->save();

        } else {
            \Session::put('teacher.grade', $grade->id);

            $keyboard = Keyboard::make();

            $subjects = $grade->subjects()->get();
//            $subjects = Subject::where('grade_id', $grade->id)->get();

            foreach ($subjects as $subject) {
                $keyboard->row(
                    Keyboard::inlineButton([
                        'text' => $subject->name
                    ]));

            }

            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => 'Please select the subjects you teach? If you choose all prefer subjects, please write /finish',
                'reply_markup' => $keyboard
            ]);

            $stepOfUser->action = 'teacherRegisterSubjectStep';
            $stepOfUser->save();
        }

        return "Ok";
    }
}