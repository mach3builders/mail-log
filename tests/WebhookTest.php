<?php

namespace Mach3builders\MailLog\Tests;

use Mach3builders\MailLog\Models\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WebhookTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        config()->set('mail-log.signing_key', 'secret');
    }

    protected function payload($merge = [])
    {
        return array_merge_recursive([
            'signature' => [
                'timestamp' => '1597408612',
                'token' => 'e206bef12314ae90f75e6c64b5c0f9821a1d1ea196c10c8969',
                'signature' => '91f8974bde950dda1007396c6a3c1f5247b3d8533836128ad18946c3ff119c5b',
            ],
            'event-data' => [
                'timestamp' => '1597408612',
                'event' => 'failed',
                'severity' => 'temporary',
                'message' => [
                    'headers' => [
                        'message-id' => '12345',
                    ],
                ],
                'delivery-status' => [
                    'description' => 'Delivery failed description',
                    'message' => 'Delivery failed message',
                ],
            ],
        ], $merge);
    }

    /** @test */
    public function signature_must_be_valid()
    {
        $this->post('mails/webhook', $this->payload([
            'signature' => [
                'signature' => 'invalid',
            ]
        ]))->assertSessionHasErrors('signature.signature');
    }

    /** @test */
    public function webhook_updates_mail()
    {
        $mail = Mail::factory()->create(['message_id' => '12345']);

        $this->post('mails/webhook', $this->payload())
            ->assertSessionDoesntHaveErrors()
            ->assertOk();

        $this->assertDatabaseHas('mails', [
            'id' => $mail->id,
            'status' => 'failed',
            'status' => 'failed',
            'severity' => 'temporary',
            'description' => 'Delivery failed description',
            'message' => 'Delivery failed message',
        ]);
    }
}
