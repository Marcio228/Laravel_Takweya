<?php
/**
 * Created by PhpStorm.
 * User: illia
 * Date: 16.08.18
 * Time: 14:52
 */

namespace App\Telegram;

use App\Grade;
use Telegram;

class StudentRegisterGradeStep
{

    /**
     * StudentRegisterGradeStep constructor.
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
        } else {

            \Session::put('student.grade', $grade->id);

            $reply_markup = Telegram\Bot\Keyboard\Keyboard::remove();

            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => 'What is your phone?',
                'reply_markup' => $reply_markup
            ]);

            $stepOfUser->action = 'studentRegisterPhoneStep';
            $stepOfUser->save();
        }

        return "Ok";
    }
}