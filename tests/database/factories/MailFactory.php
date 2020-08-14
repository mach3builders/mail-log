<?php

use \Faker\Generator;
use Mach3builders\MailLog\Models\Mail;

/* @var Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Mail::class, function (Generator $faker) {
    return [
        'message_id' => '12345',
        'subject' => $faker->sentence,
        'from' => "<{$faker->safeEmail}>",
        'to' => "<{$faker->safeEmail}>",
        'cc' => "<{$faker->safeEmail}>",
        'bcc' => "<{$faker->safeEmail}>",
        'body' => $faker->randomHtml(),
    ];
});
