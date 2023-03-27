<?php

namespace Mach3builders\MailLog\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Mach3builders\MailLog\MailLogServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Mach3Builders\\MailLog\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            MailLogServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('app.key', 'base64:BprTTzEwvzVQdkXvX19QR7mmpwgAsHAdyVBKd+EOBvQ=');

        $app['config']->set('mail.default', 'array');

        $app['config']->set('mail-log.middleware', ['web']);

        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        include_once __DIR__.'/../database/migrations/create_mails_table.php';

        (new \CreateMailsTable())->up();
    }
}
