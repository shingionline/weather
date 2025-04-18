<?php

use Illuminate\Support\Facades\Broadcast;

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

/* public channels */
Broadcast::channel('products', function () { return true; });

/* private channels */ 
Broadcast::channel('visitors', function ($user) { return true; });
Broadcast::channel('contacts', function ($user) { return true; });

Broadcast::channel('notifications_{id}',   function ($user, $id) { return true; });
Broadcast::channel('status_{id}',          function ($user, $id) { return true; });
Broadcast::channel('project_{id}',         function ($user, $id) { return true; });
Broadcast::channel('messages_{id}',        function ($user, $id) { return true; });
Broadcast::channel('files_{id}',           function ($user, $id) { return true; });
Broadcast::channel('transactions_{id}',    function ($user, $id) { return true; });
Broadcast::channel('clicks_{id}',          function ($user, $id) { return true; });
Broadcast::channel('clients_{id}',         function ($user, $id) { return true; });
Broadcast::channel('leads_{id}',           function ($user, $id) { return true; });
Broadcast::channel('lp_visitors_{id}',     function ($user, $id) { return true; });
Broadcast::channel('comments_{articleId}', function ($articleId) { return true; });

/* presence channels */
Broadcast::channel('test_channel', function ($user) { return $user; });

