<?php

return [
    'route_path' => 'mails',

    'middleware' => ['web', 'auth'],

    'signing_key' => env('MAIL_LOG_SIGNING_KEY'),
];
