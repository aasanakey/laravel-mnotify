<?php
namespace Tests\Notifications;

use Illuminate\Notifications\Notification;
use Sanakey\Mnotify\Message;

class ExampleNotification extends Notification{

    public function via($notifiable)
    {
        return ['mnotify'];
    }

    public function toMnotify($notifiable)
    {
        return (new Message)
            ->sender_id('TestSystem')
            ->title('Approved')
            ->message('Your account was approved!');
    }
}