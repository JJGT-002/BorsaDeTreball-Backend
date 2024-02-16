<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ActivationEmail extends Mailable {

    use Queueable, SerializesModels;

    public $user;


    public function __construct($user) {
        $this->user = $user;
    }

    public function build() {
        return $this->view('emails.activation')
            ->with([
                'userEmail' => $this->user->email,
                'activationLink' => route('activate.user', ['id' => $this->user->id]),
            ])
            ->subject('Activa tu cuenta');
    }
}
