<?php

namespace Mach3builders\MailLog\Listeners;

use Illuminate\Mail\Events\MessageSent;
use Mach3builders\MailLog\Models\Mail;
use Mach3builders\MailLog\Events\MailLogged;

class LogSendingMessage
{
    public function handle(MessageSent $event): void
    {
        $message = $event->sent->getOriginalMessage();

        $mail = Mail::create([
            'message_id' => $event->sent->getMessageId(),
            'subject' => $message->getSubject(),
            'from' => $this->formatAddresses($message->getFrom()),
            'to' => $this->formatAddresses($message->getTo()),
            'cc' => $this->formatAddresses($message->getCc()),
            'bcc' => $this->formatAddresses($message->getBcc()),
            'body' => $message->getHtmlBody(),
        ]);

        event(new MailLogged($mail));
    }

    /**
     * @var \Symfony\Component\Mime\Address[]
     */
    public function formatAddresses(?array $addresses): ?string
    {
        if (! $addresses) {
            return null;
        }

        return collect($addresses)
            ->map(function ($address) {
                return ltrim($address->getName() . " <{$address->getAddress()}>");
            })->implode(',');
    }
}
