<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\VonageMessage;


class SendOTPNotification extends Notification
{
    // Notification logic goes here
    public function via($notifiable)
    {
        return ['vonage']; // Use the Vonage channel for this notification
    }

    public function toVonage($notifiable)
    {
        return (new VonageMessage)
            ->content('Your SMS message content for OTP');
            // ->from('639262189072');
    }
}
