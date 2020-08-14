<?php

namespace Mach3builders\MailLog;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Mach3builders\MailLog\Commands\CleanMailCommand;

class MailLogServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/mail-log.php' => config_path('mail-log.php'),
            ], 'config');

            $this->publishes([
                __DIR__.'/../resources/views' => base_path('resources/views/vendor/mail-log'),
            ], 'views');

            $this->publishes([
                __DIR__ . '/../database/migrations/create_mails_table.php' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_mails_table.php'),
            ], 'migrations');
        }

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'mail-log');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'mail-log');

        $this->loadRoutesFrom(__DIR__.'/../src/routes.php');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/mail-log.php', 'mail-log');

        $this->registerEventListener();

        $this->commands([
            CleanMailCommand::class,
        ]);
    }

    public function registerEventListener()
    {
        Event::listen(
            \Illuminate\Mail\Events\MessageSending::class,
            \Mach3builders\MailLog\Listeners\LogSendingMessage::class
        );
    }
}
