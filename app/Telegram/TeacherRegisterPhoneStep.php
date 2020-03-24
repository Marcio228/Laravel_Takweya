<?php
/**
 * Created by PhpStorm.
 * User: illia
 * Date: 16.08.18
 * Time: 15:06
 */

namespace App\Telegram;

use Telegram;

class TeacherRegisterPhoneStep
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

        \Session::put('teacher.phone', $text);

        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => 'What is your email?',
        ]);
        $stepOfUser->action = 'teacherRegisterEmailStep';
        $stepOfUser->save();

        return "Ok";
    }
}