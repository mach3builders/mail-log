<?php

use Illuminate\Support\Facades\Route;
use Mach3builders\MailLog\MailController;
use Mach3builders\MailLog\WebhookController;

Route::prefix(config('mail-log.route_path'))->group(function () {
    Route::post('webhook', WebhookController::class);

    Route::middleware(config('mail-log.middleware'))->group(function () {
        Route::get('/', [MailController::class, 'index'])
            ->name('mail-log::index');

        Route::get('{mail}', [MailController::class, 'show'])
            ->name('mail-log::show');
    });
});

