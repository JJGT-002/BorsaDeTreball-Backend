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

    public function build(): ActivationEmail
    {
        return $this->view('emails.activation')
            ->with([
                'user' => $this->user,
                'userName' => ($this->user->role === 'admin') ? 'Administrador' :
                    (($this->user->role === 'responsible') ? 'Responsable' : (($this->user->role === "student") ?
                        $this->user->Student->name : $this->user->Company->name)),
                'activationLink' => route('activate.user', ['id' => $this->user->id]),
            ])
            ->subject('Activa tu cuenta');
    }
}
