<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegisteredStudentNotification extends Notification
{
    use Queueable;

    public $student;
    public function __construct($student)
    {
        $this->student = $student;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('Benvingut a la Borsa de Treball de Cip FP Batoi!!')
                    ->line('Açí tens l\'informació del teu usuari:')
                    ->line('Detalls: ')
                    ->line('E-mail -> '.$this->student->Cycle->email)
                    ->line('Adreça -> '.$this->student->Cycle->address)
                    ->line('Rol -> Alumne')
                    ->line('Nom -> '.$this->student->name)
                    ->line('Cognoms -> '.$this->student->surnames)
                    ->line('CV -> '.$this->student->urlCV)
                    ->line('Queda solament que actives el teu compte')
                    ->action('Activar compte',url('/sales/'.$this->sale->id));
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
