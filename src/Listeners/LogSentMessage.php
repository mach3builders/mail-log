<?php

namespace Mach3builders\MailLog\Listeners;

use Illuminate\Support\Arr;
use Mach3builders\MailLog\Models\Mail;
use Mach3builders\MailLog\Events\MailLogged;
use Swift_Message;

class LogSentMessage
{
    public function handle($event): void
    {
        /** @var Swift_Message $message */
        $message = $event->message;

        $mail = Mail::create([
            'message_id' => $message->getId(),
            'subject' => $message->getSubject(),
            'from' => $this->formatAddresses($message->getFrom()),
            'to' => $this->formatAddresses($message->getTo()),
            'cc' => $this->formatAddresses($message->getCc()),
            'bcc' => $this->formatAddresses($message->getBcc()),
            'body' => $message->getBody(),
            'status' => 'sending',
        ]);

        event(new MailLogged($mail));
    }

    function formatAddresses(?array $addresses): ?string
    {
        if (! $addresses) {
            return null;
        }

        return collect($addresses)
            ->map(function ($name, $address) {
                return ltrim($name . " <$address>");
            })->implode(',');
    }
}
