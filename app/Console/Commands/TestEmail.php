<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestEmail extends Command
{
    protected $signature = 'email:test {to : Email address to send the test to}';

    protected $description = 'Send a test email using the configured Laravel mailer';

    public function handle(): int
    {
        $to = $this->argument('to');

        $this->info("Sending test email to {$to}...");

        try {
            Mail::raw(
                "This is a test email from Laravel.\n\n"
                . "If you received this message, Laravel is successfully "
                . "sending mail through the configured SMTP relay.\n\n"
                . "Mailer: " . config('mail.default') . "\n"
                . "SMTP host: " . config('mail.mailers.smtp.host') . "\n"
                . "SMTP port: " . config('mail.mailers.smtp.port') . "\n"
                . "From: " . config('mail.from.address'),
                function ($message) use ($to) {
                    $message
                        ->to($to)
                        ->subject('Laravel SMTP Test');
                }
            );

            $this->info('Email sent successfully.');

            return self::SUCCESS;
        } catch (\Throwable $e) {
            $this->error('Failed to send email.');
            $this->error($e->getMessage());

            $this->newLine();
            $this->line('Exception: ' . get_class($e));

            return self::FAILURE;
        }
    }
}
