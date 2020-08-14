<?php

namespace Mach3builders\MailLog;

use Mach3builders\MailLog\Models\Mail;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class WebhookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getMessageId(): ?string
    {
        return $this->input('event-data.message.headers.message-id');
    }

    public function getMail(): ?Mail
    {
        if (! $this->getMessageId()) {
            return null;
        }
        return Mail::where('message_id', $this->getMessageId())->first();
    }

    public function rules(): array
    {
        return [
            'signature' => 'required|array',
            'signature.timestamp' => 'required|numeric',
            'signature.token' => 'required|string',
            'signature.signature' => 'required|string',
            'event-data' => 'required|array',
            'event-data.event' => 'required|string|in:failed,delivered',
            'event-data.timestamp' => 'required|numeric',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            if (! $this->validSignature()) {
                $validator->errors()->add('signature.signature', 'Invalid signature!');
            }
        });
    }

    protected function validSignature(): bool
    {
        $signature = hash_hmac(
            'sha256',
            sprintf('%s%s', $this->input('signature.timestamp'), $this->input('signature.token')),
            config('mail-log.signing_key')
        );

        return $signature == $this->input('signature.signature');
    }
}
