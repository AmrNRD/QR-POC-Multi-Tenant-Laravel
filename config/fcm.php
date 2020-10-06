<?php

return [
    'driver' => env('FCM_PROTOCOL', 'http'),
    'log_enabled' => false,

    'http' => [
        'server_key' => env('FCM_SERVER_KEY', 'AAAArw-vxQc:APA91bHdF0iwuLXyNfSEdz6aLe102QZ7Fh_28BZkrIpwyY5-IHJ0SC6V5-ouQDmM7QOeG-Hs6CrEwafWVe-VQqrmuxYwH8ROMec9vxZZaK74lhsebqAbeABSpf0jCzQJ0uwnf_5pOYNN'),
        'sender_id' => env('FCM_SENDER_ID', '751882454279'),
        'server_send_url' => 'https://fcm.googleapis.com/fcm/send',
        'server_group_url' => 'https://android.googleapis.com/gcm/notification',
        'timeout' => 30.0, // in second
    ],
];
