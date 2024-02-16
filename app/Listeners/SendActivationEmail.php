<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Mail\ActivationEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendActivationEmail implements ShouldQueue {

    public function handle(UserRegistered $event) {
        $user = $event->user;

        // Generar una URL para activar al usuario
        $activationUrl = route('activate.user', ['id' => $user->id]);

        // Envía el correo electrónico de activación con el enlace
        Mail::to($user->email)->send(new ActivationEmail($user, $activationUrl));
    }
}
