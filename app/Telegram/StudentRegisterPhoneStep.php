<?php
/**
 * Created by PhpStorm.
 * User: illia
 * Date: 16.08.18
 * Time: 14:52
 */

namespace App\Telegram;

use Telegram;

class StudentRegisterPhoneStep
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

        \Session::put('student.phone', $text);

        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => 'What is your email?',
        ]);

        $stepOfUser->action = 'studentRegisterEmailStep';
        $stepOfUser->save();

        return "Ok";
    }
}