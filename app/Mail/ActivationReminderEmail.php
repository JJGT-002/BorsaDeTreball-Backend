<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ActivationReminderEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build(): ActivationReminderEmail
    {
        return $this->subject('Recordatorio de activación de cuenta')
            ->markdown('mails.activation_reminder')
            ->with([
                'activationLink' => route('activate.user', ['id' => $this->user->id]),
            ]);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Activation Reminder Email',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mails.activation_reminder',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
