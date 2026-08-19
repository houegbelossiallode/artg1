<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;

class NotificationService
{
    public function create(User $user, string $type, string $title, string $message, ?string $link = null, ?int $reservationId = null): Notification
    {
        return Notification::create([
            'user_id' => $user->id,
            'reservation_id' => $reservationId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'link' => $link,
            'read' => false,
        ]);
    }

    public function notifyReservationReport(User $recipient, string $courseTitle, string $proposedDate, string $proposedTime, string $proposerName, ?int $reservationId = null): Notification
    {
        return $this->create(
            $recipient,
            'warning',
            'Proposition de report de réservation',
            "Une nouvelle proposition de report a été soumise pour le cours \"{$courseTitle}\" par {$proposerName}.",
            route('dashboard.professeur.reservations'),
            $reservationId
        );
    }

    public function notifyReservationAccepted(User $recipient, string $courseTitle, string $date, string $time, ?int $reservationId = null): Notification
    {
        return $this->create(
            $recipient,
            'success',
            'Réservation acceptée',
            "Votre réservation pour le cours \"{$courseTitle}\" a été acceptée pour le {$date} à {$time}.",
            route('dashboard.apprenant.reservations'),
            $reservationId
        );
    }

    public function notifyReservationRefused(User $recipient, string $courseTitle, string $reason = '', ?int $reservationId = null): Notification
    {
        $message = "Votre réservation pour le cours \"{$courseTitle}\" a été refusée.";
        if ($reason) {
            $message .= " Raison : {$reason}";
        }

        return $this->create(
            $recipient,
            'error',
            'Réservation refusée',
            $message,
            route('dashboard.apprenant.cours'),
            $reservationId
        );
    }

    public function notifyUpcomingReservation(User $recipient, string $courseTitle, string $time, ?int $reservationId = null): Notification
    {
        return $this->create(
            $recipient,
            'info',
            'Rappel : Cours imminent',
            "Le cours \"{$courseTitle}\" commence dans 15 minutes (à {$time}).",
            route('dashboard.apprenant.reservations'),
            $reservationId
        );
    }

    public function markAsRead(Notification $notification): void
    {
        $notification->markAsRead();
    }

    public function markAllAsRead(User $user): void
    {
        Notification::forUser($user->id)->unread()->update([
            'read' => true,
            'read_at' => now(),
        ]);
    }

    public function getUnreadCount(User $user): int
    {
        return Notification::forUser($user->id)->unread()->count();
    }
}
