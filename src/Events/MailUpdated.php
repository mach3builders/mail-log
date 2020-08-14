<?php

namespace Mach3builders\MailLog\Events;

use Illuminate\Queue\SerializesModels;
use Mach3builders\MailLog\Models\Mail;
use Illuminate\Foundation\Events\Dispatchable;

class MailUpdated
{
    use Dispatchable, SerializesModels;

    /** @var \App\Models\User */
    public $mail;

    public function __construct(Mail $mail)
    {
        $this->mail = $mail;
    }
}
