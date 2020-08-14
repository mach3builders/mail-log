<?php

namespace Mach3builders\MailLog\Commands;

use Illuminate\Console\Command;

class CleanMailCommand extends Command
{
    public $signature = 'mail-log';

    public $description = 'Clean old mail';

    public function handle()
    {
        $this->comment('All done');
    }
}
