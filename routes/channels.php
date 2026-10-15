<?php

use Illuminate\Support\Facades\Broadcast;

/* | | broadcast channels | | | here you may register all of the event broadcasting channels that your | application supports. the given channel authorization callbacks are | used to check if an authenticated user can listen to the channel. | */

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
