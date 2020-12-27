<?php
namespace Sanakey\Mnotify;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Sanakey\Mnotify\SMSAPI;

class MnotifyChannel{

    public function send ($notifiable, Notification $notification) {
        
        if (method_exists($notifiable, 'routeNotificationForMnotify')) {
            $number = $notifiable->routeNotificationForMnotify($notifiable);
        } else {
            throw new \Exception("notifiable contact number not found. Return the contact number in the routeNotificationForMnotify method in your model", 1);
        }

        $message = method_exists($notification, 'toMnotify')
            ? $notification->toMnotify($notifiable)
            : $notification->toArray($notifiable);
        if (empty($message)) {
            return;
        }
       
       $payload = $message->toArray();
        $sms = new SMSAPI();
        $sms->message = isset($payload["title"]) ?  $payload["title"].$payload["message"]:$payload["message"];
        $sms->numbers = $number;
        $sms->sender = $payload['sender_id'];
        $response = $sms->sendMessage();
        Log::info("Mnotify Api response => $response->code:$response->message");
        return $response;
    }
}