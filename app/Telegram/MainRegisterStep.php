<?php
/**
 * Created by PhpStorm.
 * User: illia
 * Date: 16.08.18
 * Time: 14:50
 */

namespace App\Telegram;

use App\Grade;
use Telegram;
use Telegram\Bot\Keyboard\Keyboard;


class MainRegisterStep
{

    /**
     * MainRegisterStep constructor.
     */
    public function __construct()
    {
    }

    public function execute($request, $stepOfUser)
    {
        $chatId = $request['message']['chat']['id'];
        $text = $request['message']['text'];

        $parameters = explode(' ', $text);

        if ($parameters[0] == "Teacher") {
            $reply_markup = Telegram\Bot\Keyboard\Keyboard::remove();

            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => 'We are creating your teacher account now',
                'reply_markup' => $reply_markup
            ]);

            $keyboard = Keyboard::make();

            $grades = Grade::get();

            foreach ($grades as $grade) {
                $keyboard->row(
                    Keyboard::inlineButton([
                        'text' => $grade->name
                    ]));

            }

            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => 'What is your grade?',
                'reply_markup' => $keyboard
            ]);

            $stepOfUser->action = "teacherRegisterGradeStep";
            $stepOfUser->save();

            return "Ok";

        } else if ($parameters[0] == "Student") {
            $reply_markup = Telegram\Bot\Keyboard\Keyboard::remove();

            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => 'We are creating your teacher student account now',
                'reply_markup' => $reply_markup
            ]);

            $keyboard = Keyboard::make();

            $grades = Grade::get();

            foreach ($grades as $grade) {
                $keyboard->row(
                    Keyboard::inlineButton([
                        'text' => $grade->name
                    ]));

            }

            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => 'What is your grade?',
                'reply_markup' => $keyboard
            ]);

            $stepOfUser->action = "studentRegisterGradeStep";
            $stepOfUser->save();

            return "Ok";
        } else {
            $stepOfUser->action = null;
            $stepOfUser->save();

            return "Ok";
        }
    }
}