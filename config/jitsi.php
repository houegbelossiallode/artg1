<?php

return [
    'url' => env('JITSI_URL', 'https://meet.jit.si'),
    'app_id' => env('JITSI_APP_ID'),
    'app_secret' => env('JITSI_APP_SECRET'),
    'enable_recording' => env('JITSI_ENABLE_RECORDING', false),
    'prejoin_minutes' => env('JITSI_PREJOIN_MINUTES', 5),
    'postjoin_minutes' => env('JITSI_POSTJOIN_MINUTES', 15),
];
