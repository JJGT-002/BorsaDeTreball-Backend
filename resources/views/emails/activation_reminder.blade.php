@component('mail::message')
    # ¡Recordatorio de activación de cuenta!

    No olvides activar tu cuenta en los próximos 3 días. Si no lo haces, tu cuenta podría ser eliminada.

    @component('mail::button', ['url' => $activationLink, 'color' => 'primary'])
        Activar Cuenta
    @endcomponent

    Gracias por usar {{ config('app.name') }}.

    Saludos,<br>
    El equipo de {{ config('app.name') }}
@endcomponent
