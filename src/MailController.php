<?php

namespace Mach3builders\MailLog;

use Illuminate\Contracts\View\View;
use Mach3builders\MailLog\Models\Mail;

class MailController
{
    public function index(): View
    {
        $mails = Mail::paginate(50);

        return view('mail-log::index', compact('mails'));
    }

    public function show(Mail $mail): View
    {
        return view('mail-log::show', compact('mail'));
    }
}
