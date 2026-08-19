<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use App\Services\NotificationService;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendUpcomingReservationNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        //
    }

    public function handle(NotificationService $notificationService): void
    {
        // Get reservations starting in exactly 15 minutes
        $startTime = Carbon::now()->addMinutes(15);
        $endTime = Carbon::now()->addMinutes(16);

        $upcomingReservations = Reservation::where('status', 'accepted')
            ->where('date_reservation', $startTime->toDateString())
            ->where('heure_debut', '>=', $startTime->format('H:i'))
            ->where('heure_debut', '<', $endTime->format('H:i'))
            ->whereDoesntHave('notifications', function ($query) {
                $query->where('type', 'info')
                    ->where('title', 'Rappel : Cours imminent')
                    ->where('created_at', '>=', Carbon::now()->subMinutes(20));
            })
            ->with(['course', 'user', 'course.professeur'])
            ->get();

        foreach ($upcomingReservations as $reservation) {
            $courseTitle = $reservation->course->titre;
            $startTime = Carbon::parse($reservation->heure_debut)->format('H:i');

            // Notify the student
            if ($reservation->user) {
                $notificationService->notifyUpcomingReservation(
                    $reservation->user,
                    $courseTitle,
                    $startTime,
                    $reservation->id
                );
            }

            // Notify the professor
            if ($reservation->course->professeur) {
                $notificationService->notifyUpcomingReservation(
                    $reservation->course->professeur,
                    $courseTitle,
                    $startTime,
                    $reservation->id
                );
            }
        }
    }
}
