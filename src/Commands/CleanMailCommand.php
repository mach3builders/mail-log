<?php

namespace Mach3builders\MailLog\Commands;

use Illuminate\Console\Command;
use Mach3builders\MailLog\Models\Mail;

class CleanMailCommand extends Command
{
    public $signature = 'mail-log:clean';

    public $description = 'Clean mail older than specified in the config';

    public function handle()
    {
        $days = config('mail-log.keep_mail_for_days', 7);

        Mail::where('created_at', '<', now()->subDays($days))->delete();

        $this->comment('All done');
    }
}
