<?php

namespace Mach3builders\MailLog\Commands;

use Illuminate\Console\Command;
use Mach3builders\MailLog\Models\Mail;
use Mach3builders\MailLog\Jobs\SetupMailgunWebhooks;

class SetupWebhooks extends Command
{
    public $signature = 'mail-log:setup-webhooks {domain? : xxx.com of the domain}';

    public $description = 'Setup the mailhun webhooks needed for the package';

    public function handle()
    {
        $domain = $this->argument('domain') ?? data_get(parse_url(config('app.url')), 'host');

        SetupMailgunWebhooks::dispatchNow($domain);

        $this->comment('Webhooks setup for: '.$domain);
    }
}
