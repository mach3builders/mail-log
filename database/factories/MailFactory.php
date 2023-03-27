<?php

namespace Mach3Builders\MailLog\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Mach3builders\MailLog\Models\Mail;

class MailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Mail::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'message_id' => '12345',
            'subject' => $this->faker->sentence,
            'from' => "<{$this->faker->safeEmail}>",
            'to' => "<{$this->faker->safeEmail}>",
            'cc' => "<{$this->faker->safeEmail}>",
            'bcc' => "<{$this->faker->safeEmail}>",
            'body' => $this->faker->randomHtml(),
        ];
    }
}
