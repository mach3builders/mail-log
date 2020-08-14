<?php

namespace Mach3builders\MailLog;

use Illuminate\Http\Response;
use Mach3builders\MailLog\WebhookRequest;
use Mach3builders\MailLog\Events\MailUpdated;

class WebhookController
{
    public function __invoke(WebhookRequest $request): Response
    {
        if ($mail = $request->getMail()) {
            $mail->update([
                'status' => $request->input('event-data.event'),
                'reason' => $request->input('event-data.reason'),
                'severity' => $request->input('event-data.severity'),
                'message' => $request->input('event-data.delivery-status.message'),
                'description' => $request->input('event-data.delivery-status.description'),
            ]);

            event(new MailUpdated($mail));
        }

        return response()->noContent(200);
    }
}
