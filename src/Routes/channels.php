<?php
use CoreCMF\Socialite\App\Broadcasting\LoginChannel;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/
Broadcast::channel('App.User.Login.{uuid}', function ($uuid) {
    return (string) session('uuid') === (string) $uuid;
});
