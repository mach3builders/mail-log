<?php

namespace Mach3builders\MailLog\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SetupMailgunWebhooks implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public string $domain
    ) {}

    public function handle()
    {
        foreach (['delivered', 'temporary_fail', 'permanent_fail'] as $webhook) {
            Http::asForm()->withBasicAuth('api', config('mail-log.mailgun_api_token'))
                ->post('https://api.eu.mailgun.net/v3/domains/'.$this->domain.'/webhooks', [
                    'domain' => $this->domain,
                    'id' => $webhook,
                    'url' => url('/mails/webhook')
                ]);
        }
    }
}
