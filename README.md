## Mail log

![detail](detail.png)

![overview](overview.png)


## Installation

You can install the package via composer:

```bash
composer require mach3builders/mail-log
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="Mach3builders\MailLog\MailLogServiceProvider" --tag="migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --provider="Mach3builders\MailLog\MailLogServiceProvider" --tag="config"
```

This is the contents of the published config file:

```php
return [
    'route_path' => 'mails',

    'middleware' => ['web', 'auth'],

    'signing_key' => env('MAIL_LOG_SIGNING_KEY'),

    'keep_mail_for_days' => env('MAIL_LOG_KEEP_FOR_DAYS', 7),

    'mailgun_api_token' => env('MAILGUN_API_TOKEN'),
];
```

### Setting up the webhook
#### Manual
Go to mailgun.org and setup 3 webhooks: delivered, temporary fail and permanent fail to point at ```mails/webhook```. The package won't accept any other webhooks for now.

#### Command
If you want you could use the SetupWebhooksCommand wich triggers a Job that setups the webhooks for you

```bash
php artisan mail-log:setup-webhooks
php artisan mail-log:setup-webhooks "mach3test.com"
```

It doesnt matter if you choose the command or manual setup route, you will still have the login in too mailgun and go to your webhooks overview.
Copy your webhook signing key and update ```MAIL_LOG_SIGNING_KEY``` in the config.

## Usage

When you require this package it will automaticaly start logging all e-mails sent.
Visit `/mails` to view all logged mails.

### Listening for changes

You can listen to ```MailUpdated``` event to update your own models. 
You can access ```$event->mail``` for the updated model.

```
protected $listen = [
        \Mach3builders\MailLog\Events\MailUpdated::class => [
            \App\Listeners\UpdateUserComfirmationEmail::class,
        ]
];
```

### Editting views

To edit the views used publish them and edit to your liking.

```bash
php artisan vendor:publish --provider="Mach3builders\MailLog\MailLogServiceProvider" --tag="views"
```

### Cleaning up mail logs

You can run ```php artisan mail-log:clean``` command to clean up the mail log. By default this will remove all mails older than 7 days.

If you want to adjust the amount of days to keep email you can adjust it in the config. or you caan update the .env file ```MAIL_LOG_KEEP_FOR_DAYS=365```.

### Running the cleanup on a schedule

```php
//app/Console/Kernel.php

protected function schedule(Schedule $schedule)
{
   $schedule->command('mail-log:clean')->daily();
}
```

## Testing

``` bash
composer test
```
