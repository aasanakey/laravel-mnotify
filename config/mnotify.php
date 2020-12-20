<?php

return [

    /*
     * These are the keys for authentication.
     * These keys must be safely stored and should match the corresponding api key for your mnotify account.
     */
    
    'sms_api_key' => env('MNOTIFY_SMS_API_KEY'),
    'api_v2_key' => env('MNOTIFY_APIV2_KEY'),
  
    'sender_id'=>env('MNOTIFY_SENDER_ID'),
];