<?php

return [
    'route_path' => 'mails',

    'middleware' => ['web', 'auth'],

    'signing_key' => env('MAIL_LOG_SIGNING_KEY'),

    'keep_mail_for_days' => env('MAIL_LOG_KEEP_FOR_DAYS', 7),
];
