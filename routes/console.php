<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule the upcoming reservation notifications job to run every minute
Schedule::call(function () {
    $notificationService = app(\App\Services\NotificationService::class);
    \App\Jobs\SendUpcomingReservationNotifications::dispatch($notificationService);
})->everyMinute();
