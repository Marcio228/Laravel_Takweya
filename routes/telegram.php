<?php



/* Telegram routes */
//Route::get('me', 'TelegramController@me');
//Route::get('updates', 'TelegramController@updates');
//Route::get('respond', 'TelegramController@respond');
//Route::get('setWebHook', 'TelegramController@setWebHook');
//Route::get('removeWebHook', 'TelegramController@removeWebhook');

Route::post(env('TELEGRAM_BOT_TOKEN').'/webhook', 'TelegramController@webhook');
Route::get('/Telegram/{code}', 'TelegramController@telegram');
