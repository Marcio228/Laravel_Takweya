<?php
/**
 * Created by PhpStorm.
 * User: illia
 * Date: 16.08.18
 * Time: 14:52
 */

namespace App\Telegram;

use App\Profile;
use App\Teacher;
use Telegram;

class TeacherOnlineStep
{

    /**
     * TeacherOnlineStep constructor.
     */
    public function __construct()
    {
    }

    public function execute($request, $stepOfUser)
    {
        $chatId = $request['message']['chat']['id'];
        $text = $request['message']['text'];

        $parameters = explode(' ', $text);

        if ($parameters[0] == "/offline") {
            $stepOfUser->action = "teacherOffline";
            $stepOfUser->save();

            $message = "You are on the offline list. Notifications are disabled. To initialize new session please write /start or /online";

            $profile = Profile::where('telegram_id', $chatId)->first();

            $teacher = Teacher::where('user_id', $profile->user->id)->first();
            $teacher->is_online = false;
            $teacher->save();

            $this->showMessage($chatId, $message);

            return "Ok";
        } else {
            $message = "You are on the online list. Notifications are enabled. For exit write /offline";

            $this->showMessage($chatId, $message);

            return "Ok";
        }
    }

    private function showMessage($chatId, $message)
    {

        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => $message
        ]);
    }
}