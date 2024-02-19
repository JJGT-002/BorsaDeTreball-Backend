<?php

namespace App\Console\Commands;

use App\Mail\ActivationReminderEmail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendActivationReminder extends Command
{
    protected $signature = 'app:send-activation-reminder';

    protected $description = 'Send activation reminder to users who have not activated their accounts';

    public function handle()
    {
        $users = User::where('isActivated', 0)
            ->where('created_at', '<=', Carbon::now()->subMinutes())
            ->get();

        foreach ($users as $user) {
            Mail::to($user->email)->send(new ActivationReminderEmail($user));

            if ($user->created_at <= Carbon::now()->subMinutes(2)) {
                $user->delete();
            }
        }
    }
}
