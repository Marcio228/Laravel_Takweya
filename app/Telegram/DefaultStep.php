<?php
/**
 * Created by PhpStorm.
 * User: illia
 * Date: 16.08.18
 * Time: 14:53
 */

namespace App\Telegram;

use Telegram;

class DefaultStep
{

    /**
     * DefaultStep constructor.
     */
    public function __construct()
    {
    }

    public function execute($request, $stepOfUser)
    {
        $chatId = $request['message']['chat']['id'];

        $reply_markup = Telegram\Bot\Keyboard\Keyboard::remove();

        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => "I don't understand you, please initialize new session /start",
            'reply_markup' => $reply_markup]);

        $stepOfUser->action = null;
        $stepOfUser->save();
        return "Ok";
    }
}