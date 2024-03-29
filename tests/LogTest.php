<?php

namespace Mach3builders\MailLog\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use Mach3builders\MailLog\Models\Mail as MailModel;

class LogTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function messages_are_logged()
    {
        Mail::raw('this is a test message', function (Message $message) {
            $message->to('r.benard@mach3builders.nl', 'Robbin')
                ->from('r.newalsing@mach3builders.nl', 'Rewi');
        });

        $this->assertDatabaseHas('mails', [
            'to' => 'Robbin <r.benard@mach3builders.nl>',
            'from' => 'Rewi <r.newalsing@mach3builders.nl>',
            'body' => 'this is a test message',
            'status' => null,
        ]);
    }

    /** @test */
    public function messages_are_cleaned()
    {
        $keep = MailModel::factory()->create(['created_at' => now()->subDays(6)]);
        $delete = MailModel::factory()->create(['created_at' => now()->subDays(8)]);

        $this->artisan('mail-log:clean');

        $this->assertDatabaseMissing('mails', ['id' => $delete->id]);
        $this->assertDatabaseHas('mails', ['id' => $keep->id]);
    }
}
