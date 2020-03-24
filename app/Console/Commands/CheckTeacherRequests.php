<?php

namespace App\Console\Commands;

use App\Lesson;
use App\Step;
use App\Task;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;

class CheckTeacherRequests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'request:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check teacher requests';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tasks = Task::where('execution', "<=", date('Y-m-d H:i'))->get();

        foreach ($tasks as $task) {

            $lesson = Lesson::where('id', $task->lesson_id)->first();
            $chatId = $lesson->student->user->profile->telegram_id;

            $stepOfUser = Step::firstOrCreate(['telegram_id' => $chatId,
                'telegram_id' => $chatId]);

            $proposals = $lesson->proposals()->get();

            if (count($proposals) == 0) {

                $lesson->delete();

                Telegram::sendMessage([
                    'chat_id' => $chatId,
                    'text' => "We not found teachers for you, please init new session /start"
                ]);

                $stepOfUser->action = null;
                $stepOfUser->status = null;
                $stepOfUser->save();

            } else {

                $keyboard = Keyboard::make();
                $keyboard->inline();

                foreach ($proposals as $proposal) {
                    $keyboard->row(
                        Keyboard::inlineButton([
                            'text' => $proposal->teacher->user->first_name,
                            'callback_data' => "/select {$proposal->teacher->id} {$proposal->lesson->id}"
                        ]));

                }

                $response = Telegram::sendMessage([
                    'chat_id' => $chatId,
                    'text' => "Here is a list of online teacher, please choose your preferred tutor, to start a line classroom",
                    'reply_markup' => $keyboard
                ]);

                $stepOfUser->action = "studentIsChooseTeacher";
                $stepOfUser->status = null;
                $stepOfUser->save();
            }

            $task->delete();
        }
    }
}
